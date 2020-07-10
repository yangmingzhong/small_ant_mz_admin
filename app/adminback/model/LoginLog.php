<?php
/**
 * Author: @Small Ant mz
 * Date: 2020年7月3日  15:34:28
 * Q-Email:1306643459@qq.com
 */
namespace app\adminback\model;

use think\Model;

class LoginLog extends Model
{
    protected $name = 'login_log';

    /**
     * 写登录日志
     * @param $user
     * @param $status
     */
    public function writeLoginLog($user)
    {
            $this->save([
                'uid' => $user,
                'login_ip' => request()->ip(),
                'login_area' => getLocationByIp(request()->ip()),
            ]);
    }


    public function getAdminUser()
    {
        return $this->belongsTo('AdminUser','uid','aid');
    }
}