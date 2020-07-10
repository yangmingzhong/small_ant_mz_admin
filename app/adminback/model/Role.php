<?php
/**
 * Author: @Small Ant mz
 * Date: 2020年7月3日  22:34:28
 * Q-Email:1306643459@qq.com
 */
namespace app\adminback\model;

use think\Model;

class Role extends Model
{
    protected $name = 'role';

    /**
     * 获取角色信息
     * @param $id
     * @return array
     */
    public function getRoleInfoById($id)
    {
           return $this->where('role_id', $id)->find();
    }


    /**
     * 通过id更新角色信息
     * @param $roleId
     * @param $param
     * @return array
     */
    public function updateRoleInfoById($roleId, $param)
    {
          return $this->where('role_id', $roleId)->update($param);
    }

    /**
     * 获取角色的权限节点数组
     * @param $roleId
     * @return array
     */
    public function getRoleAuthNodeAuth($roleId)
    {
        $auth_role_data = unserialize(cache("role_" . $roleId.'_auth'));
        if (empty($auth_role_data)) {
                $res = $this->where('role_id', $roleId)->find();
                if (!empty($res)) {
                    //获取当前节点信息
                    $nodeModel = new Node();
                    $nodeInfo = $nodeModel->getNodeInfoByIds($res['role_node']);
                    $auth_role_data = [];
                    if (!empty($nodeInfo)) {

                        foreach ($nodeInfo as $vo) {
                            if (empty($vo['node_path']) || '#' == $vo['node_path']) continue;
                            //清除前后斜杠，增加匹配程度
                            $vo['node_path'] = strtolower(trim( $vo['node_path'] ,'/'));
                            $auth_role_data[$vo['node_path']] = $vo['node_id'];
                        }
                        //十分钟一次重新生成一次验证当前角色权限
                        cache("role_" . $roleId.'_auth',serialize($auth_role_data),600);
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }
        }
        return $auth_role_data ;

    }


}