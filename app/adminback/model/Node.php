<?php
/**
 * Author: @Small Ant mz
 * Date: 2020年7月4日 19:34:28
 * Q-Email:1306643459@qq.com
 */
namespace app\adminback\model;

use think\facade\Cache;
use think\facade\Log;
use think\Model;

class Node extends Model
{
    protected $name = 'node';



    /**
     * 根据节点id获取节点信息
     * @param $ids
     * @return array
     */
    public function getNodeInfoByIds($ids)
    {
            if(!$ids){
                return  false;
            }
            return  $this->whereIn('node_id', $ids)->select();
    }


    /**
     * 根据id 获取节点信息
     * @param $id
     * @return array
     */
    public function getNodeInfoById($id)
    {
            return $this->where('node_id', $id)->find();

    }


    /**
     * 获取角色菜单集合
     * @param $roleId
     * @return array
     */
    public function getRoleMenu($roleId,$lang='zh-cn')
    {

            $node_data = [];
            if (1 == $roleId) {

                $node_data = $this->field('node_id,node_name,node_enname,node_pid,node_path,node_icon')
                    ->where('is_menu', 2)->order('node_order','DESC')->select();
            } else {

                $roleModel = new Role();
                $roleInfo = $roleModel->getRoleInfoById($roleId);

                if (!empty($roleInfo)) {

                    $node_data = $this->field('node_id,node_name,node_enname,node_pid,node_path,node_icon')
                        ->whereIn('node_id', $roleInfo['role_node'])->where('is_menu', 2)->order('node_order','DESC')->select();
                }
            }
            $menuData = unserialize(cache('menuData'.$roleId.$lang));
            if(!$menuData) {
                $menuData = ['homeInfo' => ['title' => lang('HMOE'), 'href' => url('index/welcome')], 'logoInfo' => ['title' => config('web_title_ant'), 'image' =>config('web_img_ant'), 'href' => url('index/index')]];
                //拼接成layuimini需要的json格式

                $menuInfo = [];
                $titleType =$lang == 'en-us' ? 'node_enname' : 'node_name';

                $i = 0;
                //先找出父亲，在找出儿子
                if ($node_data) {
                    foreach ($node_data as $v) {
                        $menuF = [];
                        if ($v['node_pid']) {
                            continue;
                        }
                        $menuF['title'] = $v[$titleType];
                        $menuF['icon'] = $v['node_icon'];
                        $menuF['href'] = ($v['node_path']=='#' || $v['node_path']=='' )?'':$v['node_path'];
                        $menuF['target'] = '_self';
                        $menuF['child'] = [];

                        $menuInfo[$i] = $menuF;
                        //考虑一下，只能循环套循环了，本不想这样干的,目前支持二级就好
                        foreach ($node_data as $z) {
                            if ($v['node_id'] == $z['node_pid']) {
                                $menuC = [];
                                $menuC['title'] = $z[$titleType];
                                $menuC['icon'] = $z['node_icon'];
                                $menuC['href'] = $z['node_path'];
                                $menuC['target'] = '_self';
                                $menuC['child'] = [];
                                $menuInfo[$i]['child'][] = $menuC;
                            }
                        }
                        $i++;
                    }

                    $menuData['menuInfo'] = $menuInfo;

                    cache('menuData'.$roleId.$lang,serialize($menuData),120);

                    //                foreach ($node_data as $v) {
                    //                    $menuC = [];
                    //                    if ($v['node_pid']) {
                    //                        continue;
                    //                    }
                    //                    $menuC['title'] = $v[$titleType];
                    //                    $menuC['icon'] = $v['node_icon'];
                    //                    $menuC['href'] = $v['node_path'];
                    //                    $menuC['target'] = '_blank';
                    //                    $menuC['child'] = [];
                    //
                    //                    $i++;
                    //                }
                }
            }
             return ($menuData);
    }


    public function getAllMenu($lang='zh-cn'){
        $menuData = unserialize(cache('allMenuData'.$lang));
        if(!$menuData) {
            $nodeModel = new Node();
            $titleType = $lang == 'en-us' ? 'node_enname' : 'node_name';

            $menuData = $nodeModel->field("node_id,is_menu,{$titleType} as menuname,node_pid")
                ->order('node_order', 'DESC')->select();

            //获取选中项
            cache('allMenuData'.$lang,serialize($menuData),60);
        }
        return  $menuData;
    }
}