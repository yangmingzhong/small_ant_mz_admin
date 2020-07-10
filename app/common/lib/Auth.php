<?php
/**
 * Author: @Small Ant mz
 * Date: 2020年7月4日 0004下午 06:11:50
 * Q-Email:1306643459@qq.com
 */
namespace app\common\lib;
use app\adminback\model\AdminUser;
use app\adminback\model\Role;

Class Auth{

    public static function checkAccess($rule)
    {
        // 如果当前role是1，则无需判断
        $user_admin = new AdminUser();
        $user_role_id = $user_admin->getAdminRoleByID();
        $roleModel = new Role();
        if ($user_role_id == 1 ) {
            return true;
        }
        $roleAuthNodeMap = $roleModel->getRoleAuthNodeAuth($user_role_id);

        if (empty($roleAuthNodeMap)) {
            return false;
        }
        if (!isset($roleAuthNodeMap[strtolower($rule)])) {
            return false;
        }
        return true;
    }
}