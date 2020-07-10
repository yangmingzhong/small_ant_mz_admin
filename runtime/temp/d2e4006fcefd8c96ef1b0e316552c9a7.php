<?php /*a:2:{s:26:"theme/usermanage\edit.html";i:1594174203;s:24:"theme/public\header.html";i:1594284627;}*/ ?>
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
        <label class="layui-form-label required"><?php echo lang('USERNAME_OR_EMAIL'); ?></label>
        <div class="layui-input-block">
            <input type="text" name="user_name" lay-verify="required" lay-reqtext="<?php echo lang('USERNAME_OR_EMAIL_EMPTY'); ?>" placeholder="<?php echo lang('USERNAME_OR_EMAIL_EMPTY'); ?>" value="<?php echo htmlentities($save_data['user_name']); ?>" class="layui-input">
            <tip></tip>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label required"><?php echo lang('PASSWORD'); ?></label>
        <div class="layui-input-block">
            <input type="password" name="password" placeholder="<?php echo lang('PASSWORD_INPUT'); ?>" value="" class="layui-input">
            <tip></tip>
        </div>
    </div>
    <div class="layui-form-item">
            <label class="layui-form-label"><?php echo lang('ROLE_NAME'); ?></label>
            <div class="layui-input-inline">
                <select name="role_id" lay-verify="required" lay-reqtext="<?php echo lang('NEED_ROLE'); ?>" lay-search="">
                    <?php foreach($roles as $key=>$vo): ?>
                    <option value="<?php echo htmlentities($vo['role_id']); ?>" <?php if($save_data['role_id']==$vo['role_id']): ?> selected<?php endif; ?>><?php echo htmlentities($vo['role_name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label required"><?php echo lang('ENABLED_STATUS'); ?></label>
        <div class="layui-input-block">
            <input type="radio" name="status" value="1" title="<?php echo lang('ENABLED'); ?>" <?php if($save_data['status']==1): ?>checked<?php endif; ?> >
            <input type="radio" name="status" value="0" title="<?php echo lang('DISABLED'); ?>" <?php if($save_data['status']==0): ?>checked<?php endif; ?> >
        </div>
    </div>

    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label"><?php echo lang('DESCRIPTION'); ?></label>
        <div class="layui-input-block">
            <textarea name="remarks" class="layui-textarea" placeholder="<?php echo lang('REMARK_MESS_INPUT'); ?>"><?php echo htmlentities($save_data['remarks']); ?></textarea>
        </div>
    </div>
    <input type="hidden" name="aid" value="<?php echo htmlentities($save_data['aid']); ?>">
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn layui-btn-normal" lay-submit lay-filter="saveBtn"><?php echo lang('SAVE'); ?></button>
        </div>
    </div>
</div>
</div>
<script>
    //添加连接
    var Save_Url_Form = '<?php echo url("Usermanage/editAdminUser"); ?>';
</script>
<script src="/static/adminback/js/saveFrom.js" charset="utf-8"></script>
</body>
</html>