<?php

namespace app\adminback\controller;

use app\adminback\model\LoginLog;
use app\adminback\model\Operate;

class Log extends AdminBase
{
    public function initialize()
    {
        parent::initialize();
    }
    // 登录日志
    public function loginLog()
    {
        $log = new LoginLog();
        if($this->request->isAjax()) {
            $limit =  $this->request->param('limit')?$this->request->param('limit'):20;
            $page =  $this->request->param('page')?$this->request->param('page'):1;
            $where = [];

            $listCount = $log->where($where)->count();
            $list = $log->alias('a')->field('a.*,b.user_name')->where($where)->leftJoin('AdminUser b','a.uid=b.aid')->order('create_time', 'desc')->page($page)->limit($limit)->select();

            return returnTableData($listCount,$list);
        }

        return $this->fetch('login_index');
    }

    // 操作日志
    public function operateLog()
    {
        $log = new Operate();
        if($this->request->isAjax()) {
            $limit =  $this->request->param('limit')?$this->request->param('limit'):20;
            $page =  $this->request->param('page')?$this->request->param('page'):1;
            $where = [];

            $listCount = $log->where($where)->count();
            $list = $log->alias('a')->field('a.*,b.user_name')->where($where)->leftJoin('AdminUser b','a.uid=b.aid')->order('create_time', 'desc')->page($page)->limit($limit)->select();
            if($list) {
                foreach ($list as $key => $val) {
                    $operate_desc_arr = json_decode($val['operate_desc'], true);
                    if(!is_array($operate_desc_arr)){
                        $list[$key]['operate_desc'] ='';
                    }else{
                        $list[$key]['operate_desc'] = arrToString($operate_desc_arr);
                    }
                }
            }

            return returnTableData($listCount,$list);
        }

        return view('op_index');
    }

}
