<?php
/**
 * Author: @Small Ant mz
 * Date: 2020年7月4日 上午 11:34:28
 * Q-Email:1306643459@qq.com
 */
namespace app\adminback\controller;

use app\adminback\model\AdminUser;
use app\adminback\validate\AdminValidate;
use tool\Log;

class Usermanage extends AdminBase
{

    // 用户列表
    public function index()
    {
        if($this->request->isAjax()) {
            $limit =  $this->request->param('limit')?$this->request->param('limit'):20;
            $page =  $this->request->param('page')?$this->request->param('page'):1;
            $ParamsName = json_decode($this->request->param('searchParams'),true);
            $where = [];
            if (!empty($ParamsName['username'])) {
                $where[] = ['user_name', 'like', '%'.$ParamsName['username'] . '%'];
            }


            $adminModel = new AdminUser();
            $listCount = $adminModel->where($where)->count();
            $roleText = (new \app\adminback\model\Role())->cache(120)->column('role_name','role_id');
            $list = $adminModel->where($where)->order('create_time', 'desc')->page($page)->limit($limit)->select();
            foreach ($list as $key=>$val){
                $list[$key]['role_txt']  = $roleText[$val['role_id']];
            }
            return returnTableData($listCount,$list);
        }

        return $this->fetch();
    }

    // 添加管理员
    public function addAdminUser()
    {
        if(request()->isPost()) {

            $param = $this->request->post();

            if (empty($param['user_name'])) {
                return returnMsg(204, '', lang('USERNAME_OR_EMAIL_EMPTY'));
            }
            if (empty($param['password'])) {
                return returnMsg(204, '', lang('PASSWORD_REQUIRED'));
            }
            if (empty($param['role_id'])) {
                return returnMsg(204, '', lang('NEED_ROLE'));
            }

            $param['password'] = shaPassword($param['password']);

            $adminModel = new AdminUser();
            $hasData = $adminModel->where('user_name', $param['user_name'])->find();
            if(!empty($hasData)) {
                return returnMsg(205, '', lang('USERNAME_OR_EMAIL_EXIST'));
            }
            $result = $adminModel ->save($param);
            if($result){
                return returnMsg(200, '', lang('ADD_SUCCESS'));
            }else{
                return returnMsg(202, '', lang('ADD_FAILED'));
            }
            return json($res);
        }

        $this->assign([
            'roles' => (new \app\adminback\model\Role())->where('status',1)->select()
        ]);

        return $this->fetch('add');
    }

    // 编辑管理员
    public function editAdminUser()
    {
        $adminModel = new AdminUser();
        if(request()->isPost()) {

            $param = $this->request->post();

            if (empty($param['user_name'])) {
                return returnMsg(204, '', lang('USERNAME_OR_EMAIL_EMPTY'));
            }

            if (empty($param['role_id'])) {
                return returnMsg(204, '', lang('NEED_ROLE'));
            }

            if(isset($param['password'])) {
                $param['password'] = shaPassword($param['password']);
            }

            if (1 == $param['aid']) {
                return returnMsg(205, '', lang('SUPER_MANAGE'));
            }

            $hasData = $adminModel->where('user_name', $param['user_name'])->where('aid', '<>', $param['aid'])->find();
            if(!empty($hasData)) {
                return returnMsg(205, '', lang('USERNAME_OR_EMAIL_EXIST'));
            }
            $result = $adminModel->save($param,['aid'=> $param['aid']]);
            if($result){
                return returnMsg(200, '', lang('EDIT_SUCCESS'));
            }else{
                return returnMsg(202, '', lang('EDIT_FAILED'));
            }
        }

        $adminId = $this->request->param('id');

        $this->assign([
            'save_data' => $adminModel->getAdminById($adminId),
            'roles' => (new \app\adminback\model\Role())->where('status',1)->select()
        ]);

        return $this->fetch('edit');
    }


    // 编辑管理员
    public function editPassword()
    {
        $adminModel = new AdminUser();
        if(request()->isPost()) {

            $param = $this->request->post();


            if(empty($param['old_password'])) {
                return returnMsg(204, '', lang('OLD_PASSWORD_INPUT'));
            }
           if(empty($param['new_password'])) {
                        return returnMsg(204, '', lang('NEW_PASSWORD_INPUT'));
                    }
           if(empty($param['confirm_password'])) {
                        return returnMsg(204, '', lang('CONFIRM_PASSWORD_INPUT'));
                   }
           if($param['confirm_password'] != $param['new_password']) {
                        return returnMsg(204, '', lang('CONFIRM_PASSWORD_NEW'));
             }

           $findAdmin = $adminModel->getAdminById(getSessionAdminId());
           if(empty($findAdmin)){
               return returnMsg(206, '', lang('USERNAME_NOTEXIST'));
           }
           if(shaPassword($param['old_password']) != $findAdmin['password']){
               return returnMsg(205, '', lang('OLD_PASSWORD_NOTRUE'));
           }

            $result = $adminModel->save(['password'=>shaPassword($param['new_password'])],['aid'=> getSessionAdminId()]);
            if($result){
                return returnMsg(200, '', lang('EDIT_SUCCESS'));
            }else{
                return returnMsg(202, '', lang('EDIT_FAILED'));
            }
        }



        return $this->fetch('edit_password');
    }


    /**
     * 删除管理员
     * @return \think\response\Json
     */
    public function delAdminUser()
    {
        if(request()->isAjax()) {

            $adminId = $this->request->param('id');
            if (1 == $adminId) {
                return returnMsg(205, '', lang('SUPER_MANAGE'));
            }


            $adminModel = new AdminUser();
            $result = $adminModel->where('aid',$adminId)->delete();


            if($result){
                return returnMsg(200, '', lang('DELETE_SUCCESS'));
            }else{
                return returnMsg(202, '', lang('DELETE_FAILED'));
            }
        }
    }


    /**
     * 拉黑，启用管理员
     * @return \think\response\Json
     */
    public function statusAdminUser()
    {
        if(request()->isAjax()) {

            $adminId = $this->request->param('aid');
            if (1 == $adminId) {
                return returnMsg(205, '', lang('SUPER_MANAGE'));
            }

            $adminModel = new AdminUser();
            $findExist = $adminModel->where('aid',$adminId)->find();
            if(empty($findExist)){
                      returnMsg(205,'',lang('USERNAME_NOTEXIST'));
            }
            $result = $adminModel->updateAdminInfoById($adminId,['status'=>$findExist['status']?0:1]);
            if($result){
                return returnMsg(200, '', lang('EDIT_SUCCESS'));
            }else{
                return returnMsg(202, '', lang('EDIT_FAILED'));
            }
        }
    }

}
