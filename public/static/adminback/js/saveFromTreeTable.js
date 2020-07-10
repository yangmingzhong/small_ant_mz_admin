
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

                    parent.window.location.reload();
                });
            } else {
                layer.msg(res.msg, {anim: 6});
            }
        }, 'json');
        return false;
    });

});