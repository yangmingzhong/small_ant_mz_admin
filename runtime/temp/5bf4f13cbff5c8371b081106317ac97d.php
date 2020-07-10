<?php /*a:2:{s:22:"theme/article\add.html";i:1594264383;s:24:"theme/public\header.html";i:1594284627;}*/ ?>
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
        <label class="layui-form-label required"><?php echo lang('TITLE'); ?></label>
        <div class="layui-input-block">
            <input type="text" name="title" lay-verify="required" lay-reqtext="<?php echo lang('TITLE_NOTEMPTY'); ?>" placeholder="<?php echo lang('TITLE_INPUT'); ?>" value="" class="layui-input">
            <tip></tip>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label "><?php echo lang('SUBTITLE'); ?></label>
        <div class="layui-input-block">
            <input type="text" name="subtitle"  placeholder="<?php echo lang('SUBTITLE_INPUT'); ?>" value="" class="layui-input">
            <tip></tip>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label required"><?php echo lang('IMG_URL'); ?></label>
        <div class="layui-input-block" id="upload_img">

        </div>

        <div class="layui-input-block"></div>
        <div class="layui-input-block">
            <button type="button" class="layui-btn"  id="upload_one">
               <i class="layui-icon">&#xe67c;</i><?php echo lang('IMAGE_UPLOAD'); ?>
            </button>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label "><?php echo lang('IMGS_URL'); ?></label>
        <div class="layui-input-block" id="upload_imgs">
        </div>
        <div class="layui-input-block"></div>
        <div class="layui-input-block">
            <!--            <button type="button" class="layui-btn" onclick="uploadImg('#upload_one','#upload_one_hide','<?php echo url('Article/uploadImg'); ?>')" id="upload_one">-->
            <button type="button" class="layui-btn"  id="upload_ones">

                <i class="layui-icon">&#xe67c;</i><?php echo lang('IMAGE_UPLOAD'); ?>
            </button>
        </div>
    </div>


    <div class="layui-form-item">
        <label class="layui-form-label required"><?php echo lang('ENABLED_STATUS'); ?></label>
        <div class="layui-input-block">
            <input type="radio" name="status" value="1" title="<?php echo lang('ENABLED'); ?>" checked="">
            <input type="radio" name="status" value="0" title="<?php echo lang('DISABLED'); ?>">
        </div>
    </div>

    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label"><?php echo lang('CONTENT'); ?></label>
        <div class="layui-input-block">
            <div id="editorWang"></div>
            <textarea name="content" id="content"  class="layui-textarea" placeholder="<?php echo lang('CONTENT_INPUT'); ?>" style="display: none"></textarea>
        </div>
    </div>

    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn layui-btn-normal" lay-submit lay-filter="saveBtn"><?php echo lang('ADD'); ?></button>
        </div>
    </div>
</div>
<script>
    //UploadDom绑定元素 ,UploadDomHide 隐藏域的标识 要上传服务端 的值 ,UploadURL上传链接 ,UploadDomImg 图片展示位置,ImgFile文件域的字段名 Multiple 是否开启多图片上传
    //单图
    var UploadDom="#upload_one",UploadDomHide="img_url",UploadDomImg="#upload_img",UploadURLIMG= "<?php echo url('Article/uploadImg'); ?>",Multiple=false,ImgFile='img_file';
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

        //执行实例
        var uploadInsts = upload.render({
            elem: '#upload_ones' //绑定元素
            ,url: UploadURLIMG,//上传接口
            acceptMime: 'image/*',
            accept:'images',
            field:ImgFile,
            multiple:true,

            done: function(res, index, upload){  //成功后执行函数
                if(res.code ==  0){ //存入作用域

                        var html = ' <div style="display: inline-block">\n' +
                            '<a href="'+res.data.src+'" target="_blank"> <img src="'+res.data.src+'" class="upload-down-img"></a>\n' +
                            '  <div class="upload-down-img-delete layui-icon layui-icon-delete" onclick="clearImgData(this)"></div>\n' +
                            '  <input type="hidden" name="imgs_url_a[]" value="'+res.data.src+'">\n' +
                            ' </div>';
                        $('#upload_imgs').append(html);

                }
                layer.closeAll('loading'); //关闭loading
            }
            ,error: function(){
                uploadInsts.upload();
                layer.closeAll('loading');
            }
        });



    });

</script>

<!--<script>-->
<!--    //不支持重复重载   layui upload-->
<!--    //UploadDom绑定元素 ,UploadDomHide 隐藏域的标识 要上传服务端 的值 ,UploadURL上传链接 ,UploadDomImg 图片展示位置,ImgFile文件域的字段名 Multiple 是否开启多图片上传-->
<!--    //多图，加载不同参数-->
<!--    var UploadDom="#upload_ones",UploadDomHide="imgs_url",UploadDomImg="#upload_imgs",UploadURLIMG= "<?php echo url('Article/uploadImg'); ?>",Multiple=true,ImgFile='img_file';-->
<!--</script>-->
<!--<script src="/static/adminback/js/uploadImg.js" charset="utf-8"></script>-->
<script>

    //添加连接
    var Save_Url_Form = '<?php echo url("Article/add"); ?>';
    var EditorID = '#content';
    var EditorWangID = '#editorWang';
    var UploadFileName = 'img_file_editor';
    var UploadURL = '<?php echo url("Article/uploadImgEditor"); ?>';
</script>
<script src="/static/adminback/js/saveFrom.js" charset="utf-8"></script>
<script src="/static/adminback/js/wangEditor.js" charset="utf-8"></script>

</body>
</html>