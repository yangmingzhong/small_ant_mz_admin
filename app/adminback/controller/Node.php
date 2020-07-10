<?php
/**
 * Author: @Small Ant mz
 * Date: 2020年7月4日  8:32:28
 * Q-Email:1306643459@qq.com
 */
namespace app\adminback\controller;

use app\adminback\model\Node as NodMod;

class Node extends AdminBase
{
    public function initialize()
    {
        parent::initialize();
    }
    // 菜单列表
    public function index()
    {

        if($this->request->isAjax()) {
            $NodModel = new NodMod();
            $listCount = $NodModel->count();
            $list = $NodModel->order('node_order', 'desc')->select();
            return returnTableData($listCount,$list);
        }

        return $this->fetch();
    }

    // 添加菜单
    public function add()
    {
        $NodModel = new NodMod();
        if ($this->request->isPost()) {

            $param = $this->request->post();
            if (empty($param['node_name'])) {
                return returnMsg(204, '', lang('MENU_NAME_NOTEMPTY'));
            }
            if (empty($param['node_enname'])) {
                return returnMsg(204, '', lang('MENU_NAME_EN_NOTEMPTY'));
            }

            //判断菜单名称是否已经存在

            $hasData = $NodModel->where('node_name', $param['node_name'])->find();
            if(!empty($hasData)) {
                return returnMsg(205, '', lang('ROLE_NAME_EXIST'));
            }
            if(!$param['node_path']){
                $param['node_path'] = '#';
            }
            $param['add_time'] = date('Y-m-d H:i:s');
            $result = $NodModel->insert($param);
            if($result){
                return returnMsg(200, '', lang('ADD_SUCCESS'));
            }else{
                return returnMsg(202, '', lang('ADD_FAILED'));
            }
            return json($res);
        }
        $id = $this->request->param('id');
        if(empty($id)){
            $parent_data['parent_txt'] = lang('P_MENU_NAME');
            $parent_data['node_pid'] = 0;
            //判断上上级pid   用来做是否可以选则菜单操作
            $parent_data['node_ppid'] = 0;
        }else{
            $parent_data_DB = $NodModel->getNodeInfoById($id);
            $titleType = detectLang() == 'en-us' ? 'node_enname' : 'node_name';
            $parent_data['parent_txt'] = $parent_data_DB[$titleType];
            $parent_data['node_pid'] = $parent_data_DB['node_id'];
            //判断上上级pid
            if($parent_data_DB['node_pid'] == 0){
                $parent_data['node_ppid'] = 0;
            }else{
                $parent_data['node_ppid'] = 1;
            }
            $parent_data['node_pid'] = $parent_data_DB['node_id'];

        }

        $this->assign([
            'parent_data' => $parent_data,
        ]);
        return $this->fetch();
    }

    // 编辑菜单
    public function edit()
    {
        $NodModel = new NodMod();
        if ($this->request->isPost()) {

            $param = $this->request->post();
            if (empty($param['node_name'])) {
                return returnMsg(204, '', lang('MENU_NAME_NOTEMPTY'));
            }
            if (empty($param['node_enname'])) {
                return returnMsg(204, '', lang('MENU_NAME_EN_NOTEMPTY'));
            }

            //判断菜单名称是否已经存在

            $hasData = $NodModel->where('node_name', $param['node_name'])->where('node_id', '<>', $param['node_id'])->find();
            if(!empty($hasData)) {
                return returnMsg(205, '', lang('MENU_NAME_EXIST'));
            }
            if(!$param['node_path']){
                $param['node_path'] = '#';
            }
            $result = $NodModel->save($param,['node_id'=>$param['node_id']]);
            if($result){
                return returnMsg(200, '', lang('EDIT_SUCCESS'));
            }else{
                return returnMsg(202, '', lang('EDIT_FAILED'));
            }
        }

        $id = $this->request->param('id');
        $save_data =$NodModel->getNodeInfoById($id);
        //我们做只支持两级菜单  //获取上级菜单
        $parent_data = [];
        if($save_data['node_pid'] == 0) {
            $parent_data['parent_txt'] = lang('P_MENU_NAME');
            $parent_data['node_pid'] = 0;
            //判断上上级pid   用来做是否可以选则菜单操作
            $parent_data['node_ppid'] = 0;
        }else{
            $parent_data_DB = $NodModel->getNodeInfoById($save_data['node_pid']);
            $titleType = detectLang() == 'en-us' ? 'node_enname' : 'node_name';

            $parent_data['parent_txt'] = $parent_data_DB[$titleType];
            $parent_data['node_pid'] = $parent_data_DB['node_id'];
            if($parent_data_DB['node_pid'] == 0){
                $parent_data['node_ppid'] = 0;
            }else{
                $parent_data['node_ppid'] = 1;
            }
        }
        $this->assign([
            'save_data' => $save_data,
            'parent_data' => $parent_data,
        ]);

        return $this->fetch();
    }

    // 删除菜单
    public function delete()
    {
        if ($this->request->isPost()) {

            $id = $this->request->post('node_id');

            $NodModel = new NodMod();

            // 检测菜单下是否有其他的菜单
            $hasOther = $NodModel->where('node_pid', $id)->count();
            if (!empty($hasOther)) {
                return returnMsg(208, '', lang('HAVE_OTHER_MENU'));
            }

            $result = $NodModel->where('node_id', $id)->delete();

            if($result){
                return returnMsg(200, '', lang('DELETE_SUCCESS'));
            }else{
                return returnMsg(202, '', lang('DELETE_FAILED'));
            }
        }
    }
}
