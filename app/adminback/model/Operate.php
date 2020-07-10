<?php
/**
 * Author: @Small Ant mz
 * Date: 2020年7月5日  20:34:28
 * Q-Email:1306643459@qq.com
 */
namespace app\adminback\model;

use think\Model;

class Operate extends Model
{
    protected $name = 'operate_log';

    /**
     * 写操作日志
     * @param $param
     * @return array
     */
    public function writeLog($request)
    {
        $param = $request->post();
        $param['ControllerMethod']  = $request->module().'/'. $request->controller().'/'.$request->action();

        $this->save([
            'uid' => getSessionAdminId(),
            'operator_ip' => $request->ip(),
            'operate_desc' => json_encode($param),
        ]);
    }

    public function getAdminUser()
    {
        return $this->belongsTo('AdminUser','uid','aid');
    }
}