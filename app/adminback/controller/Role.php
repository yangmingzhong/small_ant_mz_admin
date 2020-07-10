<?php
/**
 * Author: @Small Ant mz
 * Date: 2020年7月5日  12:32:28
 * Q-Email:1306643459@qq.com
 */
namespace app\adminback\controller;

use app\adminback\model\AdminUser;
use app\adminback\model\Node as NodMod;
use app\adminback\model\Role as RoleMod;

class Role extends AdminBase
{
    public function initialize()
    {
        parent::initialize();
    }
    // 角色列表
    public function index()
    {

        if($this->request->isAjax()) {
            $limit =  $this->request->param('limit')?$this->request->param('limit'):20;
            $page =  $this->request->param('page')?$this->request->param('page'):1;
            $roleName = json_decode($this->request->param('searchParams'),true);
            $where = [];
            if (!empty($roleName['username'])) {
                $where[] = ['role_name', 'like', '%'.$roleName['username'] . '%'];
            }

            $roleModel = new RoleMod();
            $listCount = $roleModel->where($where)->count();
            $list = $roleModel->where($where)->order('role_id', 'desc')->page($page)->limit($limit)->select();
            return returnTableData($listCount,$list);
        }

        return $this->fetch();
    }

    // 添加角色
    public function add()
    {
        if ($this->request->isPost()) {

            $param = $this->request->post();

            if (empty($param['role_name'])) {
                return returnMsg(204, '', lang('ROLE_NAME_NOTEMPTY'));
            }

            //判断角色名称是否已经存在
            $roleModel = new RoleMod();
            $hasData = $roleModel->where('role_name', $param['role_name'])->find();
            if(!empty($hasData)) {
                return returnMsg(205, '', lang('ROLE_NAME_EXIST'));
            }
            $param['role_node'] = '1,2,3,10';
            $result = $roleModel->insert($param);
            if($result){
                return returnMsg(200, '', lang('ADD_SUCCESS'));
            }else{
                return returnMsg(202, '', lang('ADD_FAILED'));
            }
            return json($res);
        }
        return $this->fetch();
    }

    // 编辑角色
    public function edit()
    {
        $roleModel = new RoleMod();
        if ($this->request->isPost()) {

            $param = $this->request->post();
            if (empty($param['role_name'])) {
                return returnMsg(204, '', lang('ROLE_NAME_NOTEMPTY'));
            }

            //判断角色名称是否已经存在
            if($param['role_id'] == 1){
                return returnMsg(208, '', lang('SUPER_MANAGE'));
            }
            $hasData = $roleModel->where('role_name', $param['role_name'])->where('role_id', '<>', $param['role_id'])->find();
            if(!empty($hasData)) {
                return returnMsg(205, '', lang('ROLE_NAME_EXIST'));
            }



            $result = $roleModel->save($param,['role_id'=>$param['role_id']]);
            if($result){

                return returnMsg(200, '', lang('EDIT_SUCCESS'));
            }else{
                return returnMsg(202, '', lang('EDIT_FAILED'));
            }
        }

        $id = $this->request->param('id');


        $this->assign([
            'role_data' => $roleModel->getRoleInfoById($id),
        ]);

        return $this->fetch();
    }

    // 删除角色
    public function delete()
    {
        if ($this->request->isPost()) {

            $id = $this->request->post('role_id');

            $roleModel = new RoleMod();
            if (1 == $id) {
                return returnMsg(208, '', lang('SUPER_MANAGE'));
            }

            // 检测角色下是否有管理员
            $adminModel = new AdminUser();
            $hasExist = $adminModel->getAdminUserByRoleId($id);

            if (!empty($hasExist)) {
                return returnMsg(208, '', lang('HAVE_OTHER_ADMIN'));
            }

            $result = $roleModel->where('role_id', $id)->delete();

            if($result){
                return returnMsg(200, '', lang('DELETE_SUCCESS'));
            }else{
                return returnMsg(202, '', lang('DELETE_FAILED'));
            }
        }
    }

    /**
     * 拉黑，启用角色
     * @return \think\response\Json
     */
    public function statusRole()
    {
        if(request()->isAjax()) {

            $adminId = $this->request->param('role_id');
            if (1 == $adminId) {
                return returnMsg(205, '', lang('SUPER_MANAGE'));
            }

            $roleModel = new RoleMod();
            $findExist = $roleModel->where('role_id',$adminId)->find();
            if(empty($findExist)){
                returnMsg(205,'',lang('ROLE_NOTEXIST'));
            }
            $result = $roleModel->updateRoleInfoById($adminId,['status'=>$findExist['status']?0:1]);
            if($result){
                return returnMsg(200, '', lang('EDIT_SUCCESS'));
            }else{
                return returnMsg(202, '', lang('EDIT_FAILED'));
            }
        }
    }


    // 分配权限
    public function roleSetting()
    {
        $roleModel = new RoleMod();
        $roleId = $this->request->param('role_id');
        $roleInfo =$roleModel->getRoleInfoById($roleId);
        if($this->request->isAjax()) {
            if ($this->request->isPost()) {

                $param = $this->request->post();

                $roleModel = new RoleMod();
                $role_node_arr = json_decode($param['saveRoleid'],true);
                $role_node = '';
                if($role_node_arr){
                    foreach ($role_node_arr as $val) {
                        $role_node .= $val.',';
                    }
                }

                $result = $roleModel->updateRoleInfoById($param['role_id'], [
                    'role_node' => trim($role_node, ',')
                ]);

                if($result){
                    //清除权限缓存
                    cache("role_" . $param['role_id'].'_auth',null);
                    return returnMsg(200, '', lang('EDIT_SUCCESS'));
                }else{
                    return returnMsg(202, '', lang('EDIT_FAILED'));
                }
            }else{

                $NodeModel = new NodMod();
                $NodeCount = $NodeModel->count();
                $getAllMenu = $NodeModel->getAllMenu(detectLang());
                //判断是否选中
                $nodePathArr = explode(',',$roleInfo['role_node']);
                foreach ($getAllMenu as $key=>$val){
                    if(in_array($val['node_id'],$nodePathArr)){
                        $getAllMenu[$key]['LAY_CHECKED'] = true;
                    }else{
                        $getAllMenu[$key]['LAY_CHECKED'] = false;
                    }
                }

                return returnTableData($NodeCount,$getAllMenu);
            }
        }



        $this->assign([
            'role_info' => $roleInfo
        ]);

        return view('role_auth');
    }

}
