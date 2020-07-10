
//UploadDom绑定元素 ,UploadDomHide 隐藏域的标识 ,UploadURL上传链接 , ImgFile文件域的字段名 Multiple 是否开启多图片上传
function uploadImg(UploadDom,UploadDomHide,UploadURL,Multiple=false,ImgFile='img_file'){
    layui.use('upload', function(){
        var upload = layui.upload;
        var $ = layui.$;
        //执行实例
        var uploadInst = upload.render({
            elem: UploadDom //绑定元素
            ,url: UploadURL,//上传接口
            acceptMime: 'image/*',
            accept:'images',
            field:ImgFile,
            multiple:Multiple,
            choose: function(obj){
                obj.preview(function(index, file, result){
                    //对上传失败的单个文件重新上传，一般在某个事件中使用
                    obj.upload(index, file);
                });
            }
            ,done: function(res, index, upload){  //成功后执行函数
                if(res.code ==  0){ //存入作用域
                    $(UploadDomHide).val(res.code.data.src);
                }
                layer.closeAll('loading'); //关闭loading
            }
            ,error: function(){
                uploadInst.upload();
                layer.closeAll('loading');
            }
        });
    });
}
