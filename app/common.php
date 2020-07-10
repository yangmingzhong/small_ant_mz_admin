<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件


/**
 * json返回
 * @param $code
 * @param $data
 * @param $msg
 * @return \think\response\Json
 */
function returnMsg($code, $data='', $msg='',$url='') {

    return json(['code' => $code, 'data' => $data, 'msg' => $msg,'url' => $url]);exit;
}

function returnTableData($count=0,$data='', $msg='ok') {

    return json(['code' => 0, 'count'=>$count,'data' => $data, 'msg' => $msg]);exit;
}
function returnImgData($data='', $msg='ok') {

    return json(['code' => 0, 'data' => $data, 'msg' => $msg]);exit;
}
function returnImgEditorData($data=[],$errno = 0) {

    return json(['errno' => $errno, 'data' => $data]);exit;
}

/**
 * 获取登录用户id
 */
function getSessionAdminId(){
       return session('admin_id');
}

/**
 * 加盐密码
 * @param $password
 * @return string
 */
function shaPassword($password) {
    return sha1($password . config('sha1_salt'));
}
/**
 * 根据ip定位
 * @param $ip
 * @return string
 * @throws Exception
 */
function getLocationByIp($ip)
{
    $ip2region = new \Ip2Region();
    $info = $ip2region->btreeSearch($ip);

    $info = explode('|', $info['region']);

    $address = '';
    foreach($info as $vo) {
        if('0' !== $vo) {
            $address .= $vo . '-';
        }
    }

    return rtrim($address, '-');
}

/**
 * 按钮认证
 */
function btnAuth($rule){
    $auth = new \app\common\lib\Auth();
    return $auth->checkAccess(request()->module().'/'.$rule);
}
/**
 * 获取图片真实地址
 */
function imgRealURL($url){

     return 'http://'.$_SERVER['SERVER_NAME'].'/'.$url;
}

//没有切割符的情况下，数组转字符串
 function arrToString($arr){
      if(!is_array($arr) || empty($arr)){
          return '';
      }
      $str = '';
      foreach ($arr as $key=>$val){
          //多层数组的情况下用递归
          if(is_array($val)){
              $str .= $key.'='.arrToString($val);
          }else{
              $str .= $key.'='.$val;
          }

      }
      return $str;

 }
/**
 * 检测当前的语言
 * @access public
 * @return string
 */
function detectLang()
{

    $langSet = '';

    if (isset($_GET['lang'])) {
        // url中设置了语言变量
        $langSet = strtolower($_GET['lang']);
    } elseif (isset($_COOKIE['think_var'])) {
        // Cookie中设置了语言变量
        $langSet = strtolower($_COOKIE['think_var']);
    } elseif (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
        // 自动侦测浏览器语言
        preg_match('/^([a-z\d\-]+)/i', $_SERVER['HTTP_ACCEPT_LANGUAGE'], $matches);
        $langSet = strtolower($matches[1]);

    }
    $langSet = $langSet?$langSet:'zh-cn';
    return $langSet;
}





