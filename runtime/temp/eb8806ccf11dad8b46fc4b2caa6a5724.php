<?php /*a:2:{s:24:"theme/article\index.html";i:1594370311;s:24:"theme/public\header.html";i:1594284627;}*/ ?>
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

        <fieldset class="table-search-fieldset">
            <legend><?php echo lang('SEARCH_MESS'); ?></legend>
            <div style="margin: 10px 10px 10px 10px">
                <form class="layui-form layui-form-pane" action="">
                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <label class="layui-form-label"><?php echo lang('SEARCH_NAME'); ?></label>
                            <div class="layui-input-inline">
                                <input type="text" name="search_name" placeholder='<?php echo lang("TITLE_INPUT"); ?>' autocomplete="off" class="layui-input">
                            </div>
                        </div>

                        <div class="layui-inline">
                            <button type="submit" class="layui-btn layui-btn-primary"  lay-submit lay-filter="data-search-btn"><i class="layui-icon"></i><?php echo lang('SEARCH'); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </fieldset>

        <script type="text/html" id="toolbarDemo">
            <div class="layui-btn-container">
                <?php if((btnAuth('Article/add'))): ?>
                <button class="layui-btn layui-btn-normal layui-btn-sm data-add-btn" lay-event="add"> <?php echo lang('ADD'); ?></button>
                <?php endif; ?>
            </div>
        </script>

        <table class="layui-hide" id="currentTableId" lay-filter="currentTableFilter"></table>

        <script type="text/html" id="statusTxt">
            {{#  if(d.status == 1){ }}
            <button class="layui-btn layui-btn-success layui-btn-xs" lay-event="close_status" > <?php echo lang('ENABLED'); ?></button>
            {{#  } else { }}
            <button class="layui-btn layui-btn-danger layui-btn-xs" lay-event="open_status" > <?php echo lang('DISABLED'); ?></button>
            {{#  } }}
        </script>
        <script type="text/html" id="currentTableBar">
            {{#  if(d.Article_id != 1){ }}
                    <?php if((btnAuth('Article/edit'))): ?>
                    <a class="layui-btn layui-btn-normal layui-btn-xs data-count-edit" lay-event="edit"><?php echo lang('EDIT'); ?></a>
                    <?php endif; if((btnAuth('Article/delete'))): ?>
                    <a class="layui-btn layui-btn-xs layui-btn-danger data-count-delete" lay-event="delete"><?php echo lang('DELETE'); ?></a>
                    <?php endif; ?>
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
            url: '<?php echo url("Article/index"); ?>',
            toolbar: '#toolbarDemo',
            defaultToolbar: ['filter', 'exports', 'print', {
                title: '<?php echo lang("INFO"); ?>',
                layEvent: 'LAYTABLE_TIPS',
                icon: 'layui-icon-tips'
            }],
            cols: [[
                {field: 'id', width: 80, title: 'ID'},
                {field: 'title', width: 150, title: '<?php echo lang("TITLE"); ?>'},
                {field: 'subtitle', width: 150, title: '<?php echo lang("SUBTITLE"); ?>'},
                {field: 'status', width: 150, title: '<?php echo lang("ENABLED_STATUS"); ?>','templet':'#statusTxt'},
                {field: 'img_url',type: "img", width: 200, title: '<?php echo lang("IMG_URL"); ?>',templet: function (d) {
                        return '<a href="'+d.img_url+'" target="_blank"><img src="'+d.img_url+'" style="width: 30px;height:30px;"></a>';
                    }},
                {field: 'create_time', width: 200, title: '<?php echo lang("ADD_TIME"); ?>'},
                {field: 'update_time', width: 200, title: '<?php echo lang("UPDATE_TIME"); ?>'},

                {title: '<?php echo lang("ACTIONS"); ?>', minWidth: 150, toolbar: '#currentTableBar', align: "center"}
            ]],
            limits: [10, 15, 20, 25, 50, 100],
            limit: 15,
            page: true,
            skin: 'line'
        });

        // 监听搜索操作
        form.on('submit(data-search-btn)', function (data) {
            var result = JSON.stringify(data.field);
            // layer.alert(result, {
            //     title: '<?php echo lang("SEARCH_MESS"); ?>'
            // });

            //执行搜索重载
            table.reload('currentTableId', {
                page: {
                    curr: 1
                }
                , where: {
                    searchParams: result
                }
            }, 'data');

            return false;
        });

        /**
         * toolbar监听事件
         */
        table.on('toolbar(currentTableFilter)', function (obj) {
            if (obj.event === 'add') {  // 监听添加操作
                var index = layer.open({
                    title: '<?php echo lang("ADD"); ?>',
                    type: 2,
                    shade: 0.2,
                    maxmin:true,
                    shadeClose: true,
                    area: ['100%', '100%'],
                    content: '<?php echo url("Article/add"); ?>',
                });
                $(window).on("resize", function () {
                    layer.full(index);
                });
            } else if (obj.event === 'delete') {  // 监听删除操作
                var checkStatus = table.checkStatus('currentTableId')
                    , data = checkStatus.data;
                //layer.alert(JSON.stringify(data));
            }
        });

        //监听表格复选框选择
        table.on('checkbox(currentTableFilter)', function (obj) {
            console.log(obj)
        });

        table.on('tool(currentTableFilter)', function (obj) {
            var data = obj.data;
            if (obj.event === 'edit') {

                var index = layer.open({
                    title: '<?php echo lang("EDIT"); ?>',
                    type: 2,
                    shade: 0.2,
                    maxmin:true,
                    shadeClose: true,
                    area: ['100%', '100%'],
                    content: '<?php echo url("Article/edit"); ?>?id='+data.id,
                });
                $(window).on("resize", function () {
                    layer.full(index);
                });
                return false;
            } else if (obj.event === 'delete') {
                layer.confirm('<?php echo lang("DELETE_CONFIRM_MESSAGE"); ?>', function (index) {
                    $.post('<?php echo url("Article/delete"); ?>', data, function (res) {
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
            }else if(obj.event === 'close_status'){
                layer.confirm('<?php echo lang("BLOCK_USER_CONFIRM_MESSAGE"); ?>', function (index) {
                    $.post('<?php echo url("Article/statusArticle"); ?>', data, function (res) {
                        if(200 == res.code) {

                            // 成功的提示
                            layer.msg(res.msg, {
                                offset: '15px'
                                ,icon: 1
                                ,time: 1500
                            }, function(){
                                window.location.reload()
                            });
                        } else {
                            layer.msg(res.msg, {anim: 6});
                        }
                    }, 'json');
                    return false;
                });
            }else if(obj.event === 'open_status'){
                layer.confirm('<?php echo lang("ACTIVATE_USER_CONFIRM_MESSAGE"); ?>', function (index) {
                    $.post('<?php echo url("Article/statusArticle"); ?>', data, function (res) {
                        if(200 == res.code) {

                            // 成功的提示
                            layer.msg(res.msg, {
                                offset: '15px'
                                ,icon: 1
                                ,time: 1500
                            }, function(){
                                window.location.reload()
                            });
                        } else {
                            layer.msg(res.msg, {anim: 6});
                        }
                    }, 'json');
                    return false;
                });
            }

        });


    });

</script>

</body>
</html>