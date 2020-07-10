<?php /*a:1:{s:22:"theme/login\index.html";i:1594364641;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo config('web_title_ant'); ?>后台管理-SMALL-ANT</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="Access-Control-Allow-Origin" content="*">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="/static/layuimini/lib/layui-v2.5.5/css/layui.css" media="all">
    <!--[if lt IE 9]>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        html, body {width: 100%;height: 100%;overflow: hidden}
        body {background: #1E9FFF;}
        body:after {content:'';background-repeat:no-repeat;background-size:cover;-webkit-filter:blur(3px);-moz-filter:blur(3px);-o-filter:blur(3px);-ms-filter:blur(3px);filter:blur(3px);position:absolute;top:0;left:0;right:0;bottom:0;z-index:-1;}
        .layui-container {width: 100%;height: 100%;overflow: hidden}
        .admin-login-background {width:360px;height:300px;position:absolute;left:50%;top:40%;margin-left:-180px;margin-top:-100px;}
        .logo-title {text-align:center;letter-spacing:2px;padding:14px 0;}
        .logo-title h1 {color:#1E9FFF;font-size:25px;font-weight:bold;}
        .login-form {background-color:#fff;border:1px solid #fff;border-radius:3px;padding:14px 20px;box-shadow:0 0 8px #eeeeee;}
        .login-form .layui-form-item {position:relative;}
        .login-form .layui-form-item label {position:absolute;left:1px;top:1px;width:38px;line-height:36px;text-align:center;color:#d2d2d2;}
        .login-form .layui-form-item input {padding-left:36px;}
        .captcha {width:60%;display:inline-block;}
        .captcha-img {display:inline-block;width:34%;float:right;}
        .captcha-img img {height:34px;border:1px solid #e6e6e6;height:36px;width:100%;}
    </style>
</head>
<body>
<div class="layui-container">
    <div class="admin-login-background">
        <div class="layui-form login-form">
            <form class="layui-form" action="">
                <div class="layui-form-item logo-title">
                    <h1><?php echo lang('ADMIN_CENTER'); ?></h1>
                </div>
                <div class="layui-form-item">
                    <label class="layui-icon layui-icon-username" ></label>
                    <input type="text" name="username"  placeholder="<?php echo lang('USERNAME_OR_EMAIL'); ?>" autocomplete="off" class="layui-input" value="admin_ant">
                </div>
                <div class="layui-form-item">
                    <label class="layui-icon layui-icon-password" ></label>
                    <input type="password" name="password"  placeholder="<?php echo lang('PASSWORD'); ?>" autocomplete="off" class="layui-input" value="ant_admin123">
                </div>
                <div class="layui-form-item">
                    <label class="layui-icon layui-icon-vercode"></label>
                    <input type="text" name="captcha"  placeholder="<?php echo lang('ENTER_VERIFY_CODE'); ?>" autocomplete="off" class="layui-input verification captcha" value="">
                    <div class="captcha-img">
                        <div><img src="<?php echo captcha_src(); ?>" alt="captcha" id="captcha" onclick="Captcha(this)" style="cursor: pointer"/></div>
                    </div>
                </div>


                <div class="layui-form-item">
                    <button class="layui-btn layui-btn layui-btn-normal layui-btn-fluid" id="loginBtn" lay-submit="" lay-filter="user_login"><?php echo lang('LOGIN'); ?></button>
                </div>
                 <?php if(config('lang_switch_on')): ?>
                <div class="layui-form-item" >
                    <?php if(detectLang() == 'zh-cn'): ?>
                    <a class="layui-btn layui-btn-warm layui-layout-right" href='<?php echo url("login/switchLang"); ?>?lang=en-us'><?php echo lang('SWITCH_LANG_EN'); ?></a>
                    <?php else: ?>
                    <a class="layui-btn layui-btn-warm layui-layout-right" href='<?php echo url("login/switchLang"); ?>?lang=zh-cn'><?php echo lang('SWITCH_LANG_ZH'); ?></a>
                    <?php endif; ?>
                </div>
                <br /> <br />
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>
<script src="/static/layuimini/lib/jquery-3.4.1/jquery-3.4.1.min.js" charset="utf-8"></script>
<script src="/static/layuimini/lib/layui-v2.5.5/layui.js" charset="utf-8"></script>
<script src="/static/layuimini/lib/jq-module/jquery.particleground.min.js" charset="utf-8"></script>
<script>
    document.onkeydown=function(event){
        var e = event || window.event || arguments.callee.caller.arguments[0];
        if(e && e.keyCode==13){ // enter 键
            $('#loginBtn').click();
        }
    };
    layui.use(['form'], function () {
        var form = layui.form,
            layer = layui.layer;

        // 登录过期的时候，跳出ifram框架
        if (top.location != self.location) top.location = self.location;

        // 粒子线条背景
        $(document).ready(function(){
            $('.layui-container').particleground({
                dotColor:'#7ec7fd',
                lineColor:'#7ec7fd'
            });
        });

        // 进行登录操作
        form.on('submit(user_login)', function (result) {
            var data = result.field
            if (data.username == '') {
                layer.msg('<?php echo lang("USERNAME_OR_EMAIL_EMPTY"); ?>');
                return false;
            }
            if (data.password == '') {
                layer.msg('<?php echo lang("PASSWORD_REQUIRED"); ?>');
                return false;
            }
            if (data.captcha == '') {
                layer.msg('<?php echo lang("ENTER_VERIFY_CODE"); ?>');
                return false;
            }
            $.post('<?php echo url("login/doLogin"); ?>', data, function (res) {
                if(200 == res.code) {

                    // 登入成功的提示与跳转
                    layer.msg('<?php echo lang("LOGIN_SUCCESS"); ?>', {
                        offset: '15px'
                        ,icon: 1
                        ,time: 1500
                    }, function(){
                        location.href = '<?php echo url("index/index"); ?>';
                    });
                } else {
                    layer.msg(res.msg, {anim: 6});
                    $("#captcha").click();
                }
            }, 'json');
            return false;
        });
    });

    function Captcha(obj) {
        $(obj).attr('src', $(obj).attr('src') + '?t=' + Math.random());
    }
</script>
</body>
</html>