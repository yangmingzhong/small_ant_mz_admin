<?php /*a:2:{s:21:"theme/node\index.html";i:1594197598;s:24:"theme/public\header.html";i:1594284627;}*/ ?>
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
<div class="layuimini-container">
    <div class="layuimini-main">
            <div class="layui-btn-container">
                <?php if((btnAuth('node/add'))): ?>
                <button class="layui-btn layui-btn-normal layui-btn-sm data-add-btn" id="addNode"> <?php echo lang('ADD'); ?></button>
                <?php endif; ?>
            </div>
        <div>
            <div class="layui-btn-group">
                <button class="layui-btn" id="btn-expand"><?php echo lang('EXAND_ALL'); ?></button>
                <button class="layui-btn layui-btn-normal" id="btn-fold"><?php echo lang('COLLAPSE_ALL'); ?></button>
            </div>
            <table id="munu-table" class="layui-table" lay-filter="munu-table"></table>
        </div>
    </div>
</div>
<!-- 操作列 -->
<script type="text/html" id="auth-state">
    <?php if((btnAuth('node/add'))): ?>
    <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="add_child"><?php echo lang('ADD_SUB_MENU'); ?></a>
    <?php endif; if((btnAuth('node/edit'))): ?>
    <a class="layui-btn  layui-btn-normal layui-btn-xs" lay-event="edit"><?php echo lang('EDIT'); ?></a>
    <?php endif; if((btnAuth('node/delete'))): ?>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><?php echo lang('DELETE'); ?></a>
    <?php endif; ?>

</script>

<script>
    layui.use(['table', 'treeTable'], function () {
        var $ = layui.jquery;
        var table = layui.table;
        var treetable = layui.treeTable;

        // 渲染表格
        layer.load(2);
        var insTb =treetable.render({
            height: 'full-100',
            tree: {
                iconIndex: 1,
                isPidData: true,
                idName: 'node_id',
                pidName: 'node_pid'
            },
            elem: '#munu-table',
            url: '<?php echo url("index"); ?>',
            page: false,
            cols: [[
                {type: 'numbers'},
                {field: 'node_name', minWidth: 200, title: '<?php echo lang("MENU_NAME"); ?>'},
                {field: 'node_enname', width: 250, title: '<?php echo lang("MENU_NAME_EN"); ?>'},
                {field: 'node_path', width: 250, title: '<?php echo lang("MENU_URL"); ?>'},
                {field: 'node_order', width: 80, title: '<?php echo lang("SORT"); ?>'},
                {field: 'node_icon', width: 250, title: '<?php echo lang("MENU_ICO"); ?>'},
                {
                    field: 'is_menu', width: 100, align: 'center', templet: function (d) {
                        if (d.is_menu == 1) {
                            return '<span class="layui-badge layui-bg-gray"><?php echo lang("BUTTON"); ?></span>';
                        }
                        if (d.is_menu == 2) {
                            return '<span class="layui-badge layui-bg-blue"><?php echo lang("MENU"); ?></span>';
                        }
                    }, title: '<?php echo lang("TYPES_OF"); ?>'
                },
                {field: 'add_time', width: 200, title: '<?php echo lang("ADD_TIME"); ?>'},
                {templet: '#auth-state', width: 250, align: 'center', title: '操作'}
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

        //监听工具条
        treetable.on('tool(munu-table)', function (obj) {
            var data = obj.data;
            var layEvent = obj.event;

            if (layEvent === 'del') {

                layer.confirm('<?php echo lang("DELETE_CONFIRM_MESSAGE"); ?>', function (index) {
                    $.post('<?php echo url("node/delete"); ?>', data, function (res) {
                        if(200 == res.code) {

                            // 成功的提示
                            layer.msg(res.msg, {
                                offset: '15px'
                                ,icon: 1
                                ,time: 1500
                            }, function(){
                                obj.del();
                                layer.close(index);
                            });
                        } else {
                            layer.msg(res.msg, {anim: 6});
                        }
                    }, 'json');
                    return false;
                });
            } else if (layEvent === 'edit') {
                var index = layer.open({
                    title: '<?php echo lang("EDIT"); ?>',
                    type: 2,
                    shade: 0.2,
                    maxmin:true,
                    shadeClose: true,
                    area: ['60%', '80%'],
                    content: '<?php echo url("node/edit"); ?>?id='+data.node_id,
                });
                $(window).on("resize", function () {
                    layer.full(index);
                });
                return false;
            }else if (layEvent === 'add_child') {
                var index = layer.open({
                    title: '<?php echo lang("ADD"); ?>',
                    type: 2,
                    shade: 0.2,
                    maxmin:true,
                    shadeClose: true,
                    area: ['60%', '80%'],
                    content: '<?php echo url("node/add"); ?>?id='+data.node_id,
                });
                $(window).on("resize", function () {
                    layer.full(index);
                });
                return false;
            }
        });
        $('#addNode').click(function () {
            var index = layer.open({
                title: '<?php echo lang("ADD"); ?>',
                type: 2,
                shade: 0.2,
                maxmin:true,
                shadeClose: true,
                area: ['60%', '80%'],
                content: '<?php echo url("node/add"); ?>',
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