<?php
/**
 * Author: @Small Ant mz
 * Date: 2020年7月2日  15:34:28
 * Q-Email:1306643459@qq.com
 */
namespace app\adminback\controller;

use app\adminback\model\AdminUser;
use app\adminback\model\LoginLog;
use think\Controller;
use think\Request;

class Login extends Controller
{
    // 登录页面
    protected $middleware = ['Langswitch'];
    public function index()
    {

        return view();
    }

    // 登录
    public function doLogin()
    {
        if(request()->isPost()) {
            $param = input('post.');
            if(!captcha_check($param['captcha'])){
                return returnMsg(2004, '', lang('CAPTCHA_NOT_RIGHT'));
            }
            $log = new LoginLog();
            $adminUser = new AdminUser();
            $adminInfo = $adminUser->getAdminByName($param['username']);


            if(empty($adminInfo)){
                return returnMsg(2001, '', lang('USERNAME_NOT_EXIST'));
            }
            if(!$this->checkPassword($param['password'], $adminInfo['password'])){
                return returnMsg(2002, '', lang('PASSWORD_NOT_RIGHT'));
            }
            if(!$adminInfo['status']){
                return returnMsg(2003, '', lang('USER_STATUS_BLOCKED_RETURN'));
            }
            // 存储状态
            session('admin_id', $adminInfo['aid']);

            // 更新登录时间
            $adminUser->updateAdminInfoById( $adminInfo['aid'], ['last_login_time' => date('Y-m-d H:i:s')]);
            $log->writeLoginLog($adminInfo['aid']);

            return returnMsg(200);
        }
    }

    private function checkPassword($inputPassword, $userPassword) {
        return shaPassword($inputPassword) === $userPassword;
    }

    public function loginOut()
    {
        session('admin_id', null);
        $this->redirect(url('login/index'));
    }

    public function  switchLang(){
        $lang=input('lang');
        switch ($lang) {
            case 'en-us':
                cookie('think_var', 'en-us');
                break;
            case 'zh-cn':
                cookie('think_var', 'zh-cn');
                break;
            default:
                cookie('think_var','zh-cn');
                break;
        }

        $this->redirect(url('index/index'));
    }

}
