//EditorWangID  编辑器识别标识       EditorID隐藏域识别标识  UploadURL上传链接 UploadFileName服务端识别字段
layui.use(['wangEditor','form'], function () {
    var $ = layui.$;
    var E = layui.wangEditor;
    var editor = new E(EditorWangID);
    var $text1 = $(EditorID);
    editor.customConfig.uploadImgServer = UploadURL;
    editor.customConfig.uploadFileName = UploadFileName;
    editor.customConfig.onchange = function (html) {
        // 监控变化，同步更新到 textarea
        $text1.val(html)
    }
    editor.create();
    // 初始化 html 的值
    editor.txt.html( $text1.val());

});