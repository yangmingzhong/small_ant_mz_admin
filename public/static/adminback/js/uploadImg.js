function clearImgData(obj) {
    obj.parentNode.remove()
}
//UploadDom绑定元素 ,UploadDomHide 隐藏域的标识 ,UploadURL上传链接 , ImgFile文件域的字段名 Multiple 是否开启多图片上传
layui.use('upload', function(){
    var upload = layui.upload;
    var $ = layui.$;
    //执行实例
    var uploadInst = upload.render({
        elem: UploadDom //绑定元素
        ,url: UploadURLIMG,//上传接口
        acceptMime: 'image/*',
        accept:'images',
        field:ImgFile,
        multiple:Multiple,

        done: function(res, index, upload){  //成功后执行函数
            if(res.code ==  0){ //存入作用域
                if(Multiple == false) {
                    var html = ' <div >\n' +
                        ' <a href="'+res.data.src+'" target="_blank"> <img src="'+res.data.src+'" class="upload-down-img"></a>\n' +
                        '  <div class="upload-down-img-delete layui-icon layui-icon-delete" onclick="clearImgData(this)"></div>\n' +
                        '  <input type="hidden" name="'+UploadDomHide+'" value="'+res.data.src+'">\n' +
                        ' </div>';
                    $(UploadDomImg).html(html);
                }else{
                    var html = ' <div style="display: inline-block">\n' +
                        ' <a href="'+res.data.src+'" target="_blank"><img src="'+res.data.src+'" class="upload-down-img"></a>\n' +
                        '  <div class="upload-down-img-delete layui-icon layui-icon-delete" ></div>\n' +
                        '  <input type="hidden" name="'+UploadDomHide+'[]" value="'+res.data.src+'">\n' +
                        ' </div>';
                    $(UploadDomImg).append(html);
                }
            }
            layer.closeAll('loading'); //关闭loading
        }
        ,error: function(){
            uploadInst.upload();
            layer.closeAll('loading');
        }
    });
});

