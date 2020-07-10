<?php
/**
 * Author: @Small Ant mz
 * Date: 2020年7月8日  20:34:28
 * Q-Email:1306643459@qq.com
 */
namespace app\adminback\model;

use think\Model;

class Article extends Model
{
    protected $name = 'article';
    /**
     * 获取角色信息
     * @param $id
     * @return array
     */
    public function getInfoById($id)
    {
        return $this->where('id', $id)->find();
    }

    /**
     * 通过id更新
     * @param $roleId
     * @param $param
     * @return array
     */
    public function updateInfoById($roleId, $param)
    {
        return $this->where('id', $roleId)->update($param);
    }


}