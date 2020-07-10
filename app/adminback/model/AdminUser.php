<?php
/**
 * Author: @Small Ant mz
 * Date: 2020年7月3日 上午 18:34:28
 * Q-Email:1306643459@qq.com
 */
namespace app\adminback\model;

use think\Model;

class AdminUser extends Model
{
    protected $name = 'admin_user';


    /**
     * 获取
     * 信息
     * @param $name
     * @return array
     */
    public function getAdminByName($name)
    {
       return $this->where('user_name', $name)->find();
    }

    //时刻调取静态类
    public static function getAdminRoleByID()
    {
        return AdminUser::where('aid', getSessionAdminId())->value('role_id');
    }


    /**
     * 获取信息
     * @param $adminId
     * @return array
     */
    public function getAdminById($adminId)
    {
           return $this->where('aid', $adminId)->find();
    }

    /**
     * 更新信息
     * @param $id
     */
    public function updateAdminInfoById($id, $param)
    {
       return $this->where('aid', $id)->update($param);
    }

    /**
     * 根据角色id 获取管理员信息
     * @param $roleId
     * @return array
     */
    public function getAdminUserByRoleId($roleId)
    {
        return $this->where('role_id', $roleId)->find();
    }

}