<?php
/**
 * Author: @Small Ant mz
 * Date: 2020年7月2日 上午 11:34:28
 * Q-Email:1306643459@qq.com
 */
namespace app\adminback\controller;

use app\adminback\model\AdminUser;
use app\adminback\model\Role;
use app\common\controller\Base;
use app\common\lib\Auth;

class AdminBase extends Base
{
    public $request;
    protected $middleware = ['Operatelog','Langswitch'];
    public function initialize()
    {

        parent::initialize();

        $this->request = \request();

        $sessionAdminId = getSessionAdminId();
        if (!empty($sessionAdminId)) {
            //保持获取当前最新角色，并获取用户最新数据
            $user_admin = new AdminUser();
            $user = $user_admin->where('aid', $sessionAdminId)->find();
            //超管时刻可以冻结该用户
            if(!$user['status']){
                return $this->redirect(url("login/index"));
            }

            $module     = $this->request->module();
            $controller = $this->request->controller();
            $action     = $this->request->action();
            $rule       = $module .'/'. $controller.'/' . $action;
            $auth = new Auth();
            if (!$auth->checkAccess($rule)) {
                $this->error(lang('USER_ACCESS'));
            }
            $this->assign("admin_user", $user);

        } else {
            if ($this->request->isAjax()) {
                $this->error(lang("USER_NOT_LOGIN"), url("login/index"));
            } else {
                return $this->redirect(url("login/index"));
            }
        }
    }


    public function uploadImg(){
        $file = $this->request->file('img_file');
        if(!$file){
            return returnImgData('',lang('IMAGE_NOTEMPTY'));
        }
        $module     = $this->request->controller();
        $path =   WEB_ROOT.'uploads/image/'.getSessionAdminId()."/$module/";
        $info = $file->rule('md5')->validate(['ext'=>'jpg,png,gif'])->move($path);
        if($info){
            $imgurl= '/uploads/image/'.getSessionAdminId()."/$module/".$info->getSaveName();
            $imgdata = array("src" =>$imgurl);
           return returnImgData($imgdata);
        }
    }

    public function uploadImgEditor(){
        $file = $this->request->file('img_file_editor');

        if(!$file){
            return returnImgEditorData();
        }
        $module     = $this->request->controller();
        $path =   WEB_ROOT.'uploads/image/'.getSessionAdminId()."/$module/editor/";
        $info = $file->rule('md5')->validate(['ext'=>'jpg,png,gif'])->move($path);
        if($info){
            $imgurl= '/uploads/image/'.getSessionAdminId()."/$module/editor/".$info->getSaveName();
            $imgdata = array(imgRealURL($imgurl));
            return returnImgEditorData($imgdata);
        }
    }


}
