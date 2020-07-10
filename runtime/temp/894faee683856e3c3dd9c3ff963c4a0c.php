<?php /*a:1:{s:22:"theme/index\index.html";i:1594365034;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo config('web_title_ant'); ?>----Small Ant</title>
    <meta name="keywords" content=" <?php echo config('web_title_ant'); ?>--Small Ant">
    <meta name="description" content="<?php echo config('web_title_ant'); ?>--Small Ant">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="Access-Control-Allow-Origin" content="*">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="icon" href="images/favicon.ico">
    <link rel="stylesheet" href="/static/layuimini/lib/layui-v2.5.5/css/layui.css" media="all">
    <link rel="stylesheet" href="/static/layuimini/css/layuimini.css?v=2.0.4.2" media="all">
    <link rel="stylesheet" href="/static/layuimini/css/themes/default.css" media="all">
    <link rel="stylesheet" href="/static/layuimini/lib/font-awesome-4.7.0/css/font-awesome.min.css" media="all">
    <!--[if lt IE 9]>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style id="layuimini-bg-color">
    </style>
</head>
<body class="layui-layout-body layuimini-all">
<div class="layui-layout layui-layout-admin">

    <div class="layui-header header">
        <div class="layui-logo layuimini-logo"></div>

        <div class="layuimini-header-content">
            <a>
                <div class="layuimini-tool"><i title="展开" class="fa fa-outdent" data-side-fold="1"></i></div>
            </a>

            <!--电脑端头部菜单-->
            <ul class="layui-nav layui-layout-left layuimini-header-menu layuimini-menu-header-pc layuimini-pc-show">
            </ul>

            <!--手机端头部菜单-->
            <ul class="layui-nav layui-layout-left layuimini-header-menu layuimini-mobile-show">
                <li class="layui-nav-item">
                    <a href="javascript:;"><i class="fa fa-list-ul"></i> SELECT MODEL</a>
                    <dl class="layui-nav-child layuimini-menu-header-mobile">
                    </dl>
                </li>
            </ul>

            <ul class="layui-nav layui-layout-right">

                <li class="layui-nav-item" lay-unselect>
                    <a href="javascript:;" data-refresh="刷新"><i class="fa fa-refresh"></i></a>
                </li>
                <li class="layui-nav-item" lay-unselect>
                    <a href="javascript:;" data-clear="清理" class="layuimini-clear"><i class="fa fa-trash-o"></i></a>
                </li>
                <li class="layui-nav-item mobile layui-hide-xs" lay-unselect>
                    <a href="javascript:;" data-check-screen="full"><i class="fa fa-arrows-alt"></i></a>
                </li>
                <li class="layui-nav-item layuimini-setting">
                    <a href="javascript:;"><?php echo htmlentities($admin_user['user_name']); ?></a>
                    <dl class="layui-nav-child">

                        <dd>
                            <a href="javascript:;" id="changePassword" data-title="<?php echo lang('CHANGE_PASSWORD'); ?>" data-icon="fa fa-gears"><?php echo lang('CHANGE_PASSWORD'); ?></a>
                        </dd>
                        <dd>
                            <hr>
                        </dd>
                        <dd>

                            <?php if(config('lang_switch_on')): if(detectLang() == 'zh-cn'): ?>
                                <a href='<?php echo url("login/switchLang"); ?>?lang=en-us' data-title="<?php echo lang('SWITCH_LANG_EN'); ?>" data-icon="fa fa-gears"><?php echo lang('SWITCH_LANG_EN'); ?></a>
                                <?php else: ?>
                            <a href='<?php echo url("login/switchLang"); ?>?zh-cn' data-title="<?php echo lang('SWITCH_LANG_ZH'); ?>" data-icon="fa fa-gears"><?php echo lang('SWITCH_LANG_ZH'); ?></a>
                                <?php endif; ?>

                            <?php endif; ?>
                        </dd>
                        <dd>
                            <hr>
                        </dd>
                        <dd>
                            <a href="<?php echo url('Login/loginOut'); ?>" class="login-out"><?php echo lang('LOGOUT'); ?></a>
                        </dd>
                    </dl>
                </li>
                <li class="layui-nav-item layuimini-select-bgcolor" lay-unselect>
                    <a href="javascript:;" data-bgcolor="配色方案"><i class="fa fa-ellipsis-v"></i></a>
                </li>
            </ul>
        </div>
    </div>

    <!--无限极左侧菜单-->
    <div class="layui-side layui-bg-black layuimini-menu-left">
    </div>

    <!--初始化加载层-->
    <div class="layuimini-loader">
        <div class="layuimini-loader-inner"></div>
    </div>

    <!--手机端遮罩层-->
    <div class="layuimini-make"></div>

    <!-- 移动导航 -->
    <div class="layuimini-site-mobile"><i class="layui-icon"></i></div>

    <div class="layui-body">

        <div class="layuimini-tab layui-tab-rollTool layui-tab" lay-filter="layuiminiTab" lay-allowclose="true">
            <ul class="layui-tab-title">
                <li class="layui-this" id="layuiminiHomeTabId" lay-id=""></li>
            </ul>
            <div class="layui-tab-control">
                <li class="layuimini-tab-roll-left layui-icon layui-icon-left"></li>
                <li class="layuimini-tab-roll-right layui-icon layui-icon-right"></li>
                <li class="layui-tab-tool layui-icon layui-icon-down">
                    <ul class="layui-nav close-box">
                        <li class="layui-nav-item">
                            <a href="javascript:;"><span class="layui-nav-more"></span></a>
                            <dl class="layui-nav-child">
                                <dd><a href="javascript:;" layuimini-tab-close="current"><?php echo lang('CLOSE_CURRENT'); ?></a></dd>
                                <dd><a href="javascript:;" layuimini-tab-close="other"><?php echo lang('CLOSE_OTHER'); ?></a></dd>
                                <dd><a href="javascript:;" layuimini-tab-close="all"><?php echo lang('CLOSE_ALL'); ?></a></dd>
                            </dl>
                        </li>
                    </ul>
                </li>
            </div>
            <div class="layui-tab-content">
                <div id="layuiminiHomeTabIframe" class="layui-tab-item layui-show"></div>
            </div>
        </div>

    </div>
</div>
<script src="/static/layuimini/lib/layui-v2.5.5/layui.js" charset="utf-8"></script>
<script src="/static/layuimini/js/lay-config.js?v=2.0.0" charset="utf-8"></script>
<script>
    layui.use(['jquery', 'layer', 'miniAdmin','miniTongji'], function () {
        var $ = layui.jquery,

            layer = layui.layer,
            miniAdmin = layui.miniAdmin,
            miniTongji = layui.miniTongji;
        var options = {
            iniUrl: '<?php echo url("index"); ?>',    // 初始化接口
            clearUrl:'<?php echo url("clearMenuCache"); ?>', // 缓存清理接口
            urlHashLocation: true,      // 是否打开hash定位
            bgColorDefault: false,      // 主题默认配置
            multiModule: false,          // 是否开启多模块
            menuChildOpen: false,       // 是否默认展开菜单
            loadingTime: 0,             // 初始化加载时间
            pageAnim: true,             // iframe窗口动画
            maxTabNum: 20,              // 最大的tab打开数量
        };
        miniAdmin.render(options);



        $('.login-out').on("click", function () {
            window.location = 'login/loginOut';

        });
        $('#changePassword').on("click", function () {
            var index = layer.open({
                title: '<?php echo lang("CHANGE_PASSWORD"); ?>',
                type: 2,
                shade: 0.2,
                maxmin:true,
                shadeClose: true,
                area: ['40%', '50%'],
                content: "<?php echo url('Usermanage/editPassword'); ?>",
            });
            $(window).on("resize", function () {
                layer.full(index);
            });
            return false;

        });



    });


</script>
</body>
</html>
