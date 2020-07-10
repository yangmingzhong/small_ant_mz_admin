<?php /*a:2:{s:19:"theme/node\add.html";i:1594176947;s:24:"theme/public\header.html";i:1594284627;}*/ ?>
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
        <label class="layui-form-label required"><?php echo lang('MENU_NAME'); ?></label>
        <div class="layui-input-block">
            <input type="text"   class="layui-input" value="<?php echo htmlentities($parent_data['parent_txt']); ?>" readonly style="background: #dda1a1">
            <input type="hidden" name="node_pid" value="<?php echo htmlentities($parent_data['node_pid']); ?>">
            <tip></tip>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label required"><?php echo lang('MENU_NAME'); ?></label>
        <div class="layui-input-block">
            <input type="text" name="node_name" lay-verify="required" lay-reqtext="<?php echo lang('MENU_NAME_NOTEMPTY'); ?>" placeholder="<?php echo lang('MENU_NAME_INPUT'); ?>" value="" class="layui-input">
            <tip></tip>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label required"><?php echo lang('MENU_NAME_EN'); ?></label>
        <div class="layui-input-block">
            <input type="text" name="node_enname" lay-verify="required" lay-reqtext="<?php echo lang('MENU_NAME_EN_NOTEMPTY'); ?>" placeholder="<?php echo lang('MENU_NAME_EN_INPUT'); ?>" value="" class="layui-input">
            <tip></tip>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label required"><?php echo lang('MENU_URL'); ?></label>
        <div class="layui-input-block">
            <input type="text" name="node_path"  placeholder="<?php echo lang('MENU_URL_INPUT'); ?>" value="" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label required"><?php echo lang('MENU_ICO'); ?></label>
        <div class="layui-input-block">
            <input type="text" name="node_icon"  placeholder="layui-icon layui-icon-template-1" value="" class="layui-input">
            <tip></tip>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label required"><?php echo lang('SORT'); ?></label>
        <div class="layui-input-block">
            <input type="number" name="node_order" min="0" placeholder="" value="0" class="layui-input">
            <tip><?php echo lang('SORT_DESC'); ?></tip>

        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label required"><?php echo lang('MENU_STATUS'); ?></label>
        <div class="layui-input-block">
            <input type="radio" name="is_menu" value="1" title="<?php echo lang('NO'); ?>" checked="">
            <?php if($parent_data['node_ppid'] == 0): ?>   <input type="radio" name="is_menu" value="2" title="<?php echo lang('YES'); ?>"> <?php endif; ?>
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
    var Save_Url_Form = '<?php echo url("node/add"); ?>';
</script>
<script src="/static/adminback/js/saveFromTreeTable.js" charset="utf-8"></script>

</body>
</html>