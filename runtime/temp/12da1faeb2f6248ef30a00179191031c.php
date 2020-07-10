<?php /*a:2:{s:25:"theme/role\role_auth.html";i:1594108453;s:24:"theme/public\header.html";i:1594284627;}*/ ?>
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
        .layui-btn:not(.layui-btn-lg ):not(.layui-btn-sm):not(.layui-btn-xs) {
            height: 34px;
            line-height: 34px;
            padding: 0 8px;
        }
    </style>
</head>
<body>
<div class="layuimini-container layui-form">
    <div class="layuimini-main">

        <div>
            <div class="layui-btn-group">
                <button class="layui-btn" id="btn-expand"><?php echo lang('EXAND_ALL'); ?></button>
                <button class="layui-btn layui-btn-normal" id="btn-fold"><?php echo lang('COLLAPSE_ALL'); ?></button>
            </div>
            <table id="munu-table" class="layui-table" lay-filter="munu-table"></table>
        </div>


    </div>

    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn layui-btn-normal" style="width: 150px;" lay-submit lay-filter="save_data"><?php echo lang('SAVE'); ?></button>
        </div>
    </div>
</div>


<script>
    layui.use(['form', 'treeTable'], function () {
        var $ = layui.jquery;
        var form = layui.form;
        var treetable = layui.treeTable;

        // 渲染表格
        layer.load(2);
       var insTb = treetable.render({
            elem: '#munu-table',
            url: '<?php echo url("roleSetting"); ?>?role_id=<?php echo htmlentities($role_info['role_id']); ?>',
           height: 'full-100',
           tree: {
               iconIndex: 1,
               isPidData: true,
               idName: 'node_id',
               pidName: 'node_pid'
           },
            cols: [[
                {type: "checkbox", width: 50},
                {field: 'menuname', minWidth: 200, title: '<?php echo lang("MENU_NAME"); ?>'},
                {
                    field: 'is_menu', width: 400, align: 'center', templet: function (d) {
                        if (d.is_menu == 1) {
                            return '<span class="layui-badge layui-bg-gray"><?php echo lang("BUTTON"); ?></span>';
                        }
                        if (d.is_menu == 2) {
                            return '<span class="layui-badge layui-bg-blue"><?php echo lang("MENU"); ?></span>';
                        }
                    }, title: '<?php echo lang("TYPES_OF"); ?>'
                }

            ]],
            done: function () {
                layer.closeAll('loading');
            }
        });

        $('#btn-expand').click(function () {
            insTb.expandAll('#munu-table');
        });

        $('#btn-fold').click(function () {
            insTb.foldAll('#munu-table');
        });


        form.on('submit(save_data)', function(obj){
            var saveRoleid = [];
            JSON.stringify(insTb.checkStatus().map(function (d) {

                saveRoleid.push(d.node_id);
            }), null, 3)

            $.post('<?php echo url("roleSetting"); ?>', {saveRoleid:JSON.stringify(saveRoleid),role_id:'<?php echo htmlentities($role_info['role_id']); ?>'}, function (res) {
                if(200 == res.code) {

                    // 成功的提示
                    layer.msg(res.msg, {
                        offset: '15px'
                        ,icon: 1
                        ,time: 1500
                    }, function(){
                        var iframeIndex = parent.layer.getFrameIndex(window.name);
                        parent.layer.close(iframeIndex);
                    });
                } else {
                    layer.msg(res.msg, {anim: 6});
                }
            }, 'json');
            return false;

        });

    });
</script>
</body>
</html>