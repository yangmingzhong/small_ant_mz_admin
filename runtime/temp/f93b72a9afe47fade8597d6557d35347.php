<?php /*a:2:{s:26:"theme/log\login_index.html";i:1594276815;s:24:"theme/public\header.html";i:1594284627;}*/ ?>
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

</head>
<body>
<div class="layuimini-container">
    <div class="layuimini-main">


        <table class="layui-hide" id="currentTableId" lay-filter="currentTableFilter"></table>

        <script type="text/html" id="statusTxt">
            {{#  if(d.status == 1){ }}
            <button class="layui-btn layui-btn-success layui-btn-xs">启用</button>
            {{#  } else { }}
            <button class="layui-btn layui-btn-danger layui-btn-xs">禁用</button>
            {{#  } }}
        </script>


    </div>
</div>
<script>
    layui.use(['form', 'table'], function () {
        var $ = layui.jquery,
            form = layui.form,
            table = layui.table;

        table.render({
            elem: '#currentTableId',
            url: '<?php echo url("Log/loginLog"); ?>',
            toolbar: '#toolbarDemo',
            defaultToolbar: ['filter', 'exports', 'print', {
                title: '<?php echo lang("INFO"); ?>',
                layEvent: 'LAYTABLE_TIPS',
                icon: 'layui-icon-tips'
            }],
            cols: [[
                {field: 'log_id', width: 80, title: 'ID'},
                {field: 'user_name', width: 200, title: '<?php echo lang("USERNAME"); ?>'},
                {field: 'login_ip', width: 250, title: '<?php echo lang("LAST_LOGIN_IP"); ?>'},
                {field: 'login_area', width: 450, title: '<?php echo lang("LAST_LOGIN_AREA"); ?>'},
                {field: 'create_time', width: 250, title: '<?php echo lang("LAST_LOGIN_TIME"); ?>'},
            ]],
            limits: [10, 15, 20, 25, 50, 100],
            limit: 15,
            page: true,
            skin: 'line'
        });


    });

</script>

</body>
</html>