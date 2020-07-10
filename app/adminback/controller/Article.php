<?php
/**
 * Author: @Small Ant mz
 * Date: 2020年7月8日  15:32:28
 * Q-Email:1306643459@qq.com
 */
namespace app\adminback\controller;

use app\adminback\model\AdminUser;
use app\adminback\model\Node as NodMod;
use app\adminback\model\Article as ArticleMod;

class Article extends AdminBase
{
    public function initialize()
    {
        parent::initialize();
    }
    // 文章列表
    public function index()
    {

        if($this->request->isAjax()) {
            $limit =  $this->request->post('limit')?$this->request->post('limit'):20;
            $page =  $this->request->post('page')?$this->request->post('page'):1;
            $ArticleName = json_decode($this->request->post('searchParams'),true);
            $where = [];
            if (!empty($ArticleName['search_name'])) {
                $where[] = ['title', 'like', '%'.$ArticleName['search_name'] . '%'];
            }

            $ArticleModel = new ArticleMod();
            $listCount = $ArticleModel->where($where)->count();
            $list = $ArticleModel->where($where)->order('id', 'desc')->page($page)->limit($limit)->select();
            foreach ($list as $key=>$val){
                $list[$key]['img_url'] = imgRealURL($val['img_url']);
            }
            return returnTableData($listCount,$list);
        }

        return $this->fetch();
    }

    // 添加文章
    public function add()
    {
        if ($this->request->isPost()) {

            $param = $this->request->post();

            if (empty($param['title'])) {
                return returnMsg(204, '', lang('Article_NAME_NOTEMPTY'));
            }
            if (empty($param['img_url'])) {
                return returnMsg(204, '', lang('IMG_URL_NOTEMPTY'));
            }
            $param['imgs_url'] ='';
            if(!empty($param['imgs_url_a'])){
                foreach ($param['imgs_url_a'] as $val){
                    $param['imgs_url'] .= $val.';';
                }
                $param['imgs_url'] = rtrim($param['imgs_url'] ,';');
            }
            unset($param['imgs_url_a']);
            $ArticleModel = new ArticleMod();
            $param['add_uid'] =$param['update_uid'] = getSessionAdminId();
            $result = $ArticleModel->save($param);
            if($result){
                return returnMsg(200, '', lang('ADD_SUCCESS'));
            }else{
                return returnMsg(202, '', lang('ADD_FAILED'));
            }
            return json($res);
        }
        return $this->fetch();
    }

    // 编辑文章
    public function edit()
    {
        $ArticleModel = new ArticleMod();
        if ($this->request->isPost()) {

            $param = $this->request->post();
            if (empty($param['title'])) {
                return returnMsg(204, '', lang('TITLE_NOTEMPTY'));
            }

            if (empty($param['img_url'])) {
                return returnMsg(204, '', lang('IMG_URL_NOTEMPTY'));
            }
            $param['imgs_url'] ='';
            if(!empty($param['imgs_url_a'])){

                foreach ($param['imgs_url_a'] as $val){
                    $param['imgs_url'] .= $val.';';
                }
                $param['imgs_url'] = rtrim($param['imgs_url'] ,';');
            }
            unset($param['imgs_url_a']);
            $param['update_uid'] = getSessionAdminId();

            $result = $ArticleModel->save($param,['id'=>$param['id']]);
            if($result){
                return returnMsg(200, '', lang('EDIT_SUCCESS'));
            }else{
                return returnMsg(202, '', lang('EDIT_FAILED'));
            }
        }

        $id = $this->request->param('id');
        $save_data  = $ArticleModel->getInfoById($id);
        if($save_data['imgs_url']){
            $save_data['imgs_url_arr'] = explode(';',$save_data['imgs_url']);
        }
        $this->assign([
            'save_data' => $save_data,
        ]);

        return $this->fetch();
    }

    // 删除文章
    public function delete()
    {
        if ($this->request->isPost()) {

            $id = $this->request->post('id');

            $ArticleModel = new ArticleMod();
            $result = $ArticleModel->where('id', $id)->delete();
            if($result){
                return returnMsg(200, '', lang('DELETE_SUCCESS'));
            }else{
                return returnMsg(202, '', lang('DELETE_FAILED'));
            }
        }

    }

    /**
     * 拉黑，启用文章
     * @return \think\response\Json
     */
    public function statusArticle()
    {
        if(request()->isAjax()) {

            $Id = $this->request->param('id');


            $ArticleModel = new ArticleMod();
            $findExist = $ArticleModel->where('id',$Id)->find();
            if(empty($findExist)){
                returnMsg(205,'',lang('ARTICLE_NOTEXIST'));
            }
            $result = $ArticleModel->updateInfoById($Id,['status'=>$findExist['status']?0:1]);
            if($result){
                return returnMsg(200, '', lang('EDIT_SUCCESS'));
            }else{
                return returnMsg(202, '', lang('EDIT_FAILED'));
            }
        }
    }


}
