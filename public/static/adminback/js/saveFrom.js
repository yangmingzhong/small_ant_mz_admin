
layui.use(['form'], function () {
    var form = layui.form,
        layer = layui.layer,
        $ = layui.$;

    //监听提交
    form.on('submit(saveBtn)', function (data) {

        $.post(Save_Url_Form, data.field, function (res) {
            if(200 == res.code) {

                // 成功的提示
                layer.msg(res.msg, {
                    offset: '15px'
                    ,icon: 1
                    ,time: 1500
                }, function(){
                    if(res.url !=''){
                        window.location.href=res.url;
                    }
                    var iframeIndex = parent.layer.getFrameIndex(window.name);
                    parent.layer.close(iframeIndex);
                    parent.layui.table.reload("currentTableId");
                });
            } else {
                layer.msg(res.msg, {anim: 6});
            }
        }, 'json');
        return false;
    });

});