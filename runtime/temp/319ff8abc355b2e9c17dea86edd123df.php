<?php /*a:2:{s:19:"theme/role\add.html";i:1593851788;s:24:"theme/public\header.html";i:1594284627;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo config('web_title_ant'); ?>----Small Ant</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/static/layuimini/lib/layui-v2.5.5/css/layui.css" media="all">
    <link rel="stylesheet" href="/static/layuimini/lib/font-awesome-4.7.0/css/font-awesome.min.css" media="all">
    <link rel="stylesheet" href="/static/layuimini/css/public.css" media="all">
    <!--[if lt IE 9]>
    <script src="/static/adminback/js/html5shiv.min.js"></script>
    <script src="/static/adminback/js/respond.min.js"></script>
    <![endif]-->
    <script src="/static/layuimini/lib/layui-v2.5.5/layui.js?v=2.5.5" charset="utf-8"></script>
    <script src="/static/layuimini/js/lay-config.js?v=1.0.5" charset="utf-8"></script>

    <style>
        body {
            background-color: #ffffff;
        }
    </style>
</head>
<body>
<div class="layui-form layuimini-form">
    <div class="layui-form-item">
        <label class="layui-form-label required"><?php echo lang('ROLE_NAME'); ?></label>
        <div class="layui-input-block">
            <input type="text" name="role_name" lay-verify="required" lay-reqtext="<?php echo lang('ROLE_NAME_NOTEMPTY'); ?>" placeholder="<?php echo lang('ROLE_NAME_INPUT'); ?>" value="" class="layui-input">
            <tip></tip>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label required"><?php echo lang('ENABLED_STATUS'); ?></label>
        <div class="layui-input-block">
            <input type="radio" name="status" value="1" title="<?php echo lang('ENABLED'); ?>" checked="">
            <input type="radio" name="status" value="0" title="<?php echo lang('DISABLED'); ?>">
        </div>
    </div>

    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label"><?php echo lang('DESCRIPTION'); ?></label>
        <div class="layui-input-block">
            <textarea name="remarks" class="layui-textarea" placeholder="<?php echo lang('REMARK_MESS_INPUT'); ?>"></textarea>
        </div>
    </div>

    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn layui-btn-normal" lay-submit lay-filter="saveBtn"><?php echo lang('ADD'); ?></button>
        </div>
    </div>
</div>
<script>
    //添加连接
    var Save_Url_Form = '<?php echo url("role/add"); ?>';
</script>
<script src="/static/adminback/js/saveFrom.js" charset="utf-8"></script>

</body>
</html>