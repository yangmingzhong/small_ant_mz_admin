<?php
/**
 * Author: @Small Ant mz
 * Date: 2020年7月2日  14:34:28
 * Q-Email:1306643459@qq.com
 */
namespace app\adminback\controller;

use app\adminback\controller\AdminBase;
use app\adminback\model\AdminUser;
use app\adminback\model\Node;
use think\Db;

class Index extends AdminBase
{

    public function initialize()
    {
        parent::initialize();
    }
    public function index()
    {
        if($this->request->isAjax()){

                //保持并获取当前最新角色，保证角色还未被超管改变
                $user_admin = new AdminUser();
                $nodeMod = new Node();
                $user_role_id = $user_admin->getAdminRoleByID();
                $menu = $nodeMod->getRoleMenu($user_role_id,detectLang());
                return json($menu);
        }
        return view();
    }

    public function welcome()
    {
        return view();
    }
    public function welcome_index()
    {
        return view();
    }

   //清除菜单缓存
    public function clearMenuCache(){
        $user_admin = new AdminUser();
        $user_role_id =  $user_admin->getAdminRoleByID();
        cache('menuData'.$user_role_id.detectLang(),null);
        return json(['code'=>'1','msg'=>'Cleared successfully']);
    }
}
