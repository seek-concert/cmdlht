<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>品牌</title>
    <link rel="stylesheet" type="text/css" href="/Public/css/style.css"/>
</head>
<body>
<form action="<?php if(empty($brand_info)): echo U('insert'); else: echo U('modify'); endif; ?>" method="post" class="js-ajax-form">
    <div class="layerCon bg_f">
        <input type="hidden" name="b_id" value="<?php echo ($brand_info["b_id"]); ?>">
        <table class="layerTable" border="0">
            <tr class="h50">
                <td>名称：</td>
                <td>
                    <input class="must" type="text" name="b_name" id="" value="<?php echo ($brand_info["b_name"]); ?>"  placeholder="请输入名称"/>
                </td>
            </tr>
            <tr class="h50">
                <td>商家：</td>
                <td>
                    <select name="b_uid" id="buid">
                        <option value="">------请选择------</option>
                        <?php if(is_array($userinfo_info)): $i = 0; $__LIST__ = $userinfo_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$userinfoinfo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($userinfoinfo["u_id"]); ?>" <?php if(($userinfoinfo["u_id"]) == $brand_info["b_uid"]): ?>selected<?php endif; ?>><?php if(empty($userinfoinfo["u_shopname"])): echo ($userinfoinfo["u_nickname"]); endif; echo ($userinfoinfo["u_shopname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </td>
            </tr>
            <tr class="h30">
                <td>品牌图片（单图上传）：</td>
                <td>
                    <form  enctype="multipart/form-data" method="post" id="img1">
                        <div class="imgCon " colspan="5" style="position: relative;height: 150px;width: 150px;">

                            <div class="uopImg upBtn upload-btn-a" data-type="avatar" data-is_edit="1" data-inited="1" >
                                <img src="/Public/img/addimg.png"   width="150px;" height="150px;" style="float: left;">
                                <input class="upload-input" type="file" size="100" name="upload_file" id="uploadFile" onchange="uploadImage(this);">
                            </div>
                        </div>
                    </form>

                    <div id="imgadd">
                        <?php if(empty($brand_info)): else: ?>
                            <img src='<?php echo ($brand_info["b_img"]); ?>'   width='150px;' height='150px;'  style='margin-top:-1000px;'>
                            <img src='/Public/img/trash.png' class='delthis' style='margin-right:20px;'><?php endif; ?>
                    </div>
                </td>
            </tr>

            <tr class="h50">
                <td>排序：</td>
                <td>
                    <input class="must" type="text" name="b_order" id="" value='<?php if(empty($brand_info["b_order"])): ?>0<?php else: echo ($brand_info["b_order"]); endif; ?>'  placeholder="请输入排序"/>
                </td>
            </tr>
        </table>
    </div>
    <div class="layerBtns">
        <a class="btn js-ajax-form-btn layui-btn" data-layer="true" >提交</a>
    </div>
</form>
<script src="/Public/js/jquery2-1-4.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/layer/layer.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/js/htglxt.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/js/iframe.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/js/jquery.treetable.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/js/ajax-submit.js"></script>
<script>
    /*图片上传-预览*/
    function uploadImage(obj) {
        /*判断是否有选择上传文件*/
        var imgPath = obj.files;
        /* console.log(imgPath);*/
        if (!imgPath.length) {
            layer.msg('请选择需要上传的图片!', {icon: 1, time: 1000});
            return;
        }
        var parent_obj = $(obj).parents('td'),
            addimgs = parent_obj.find('#imgadd');

        /*判断品牌图的张数*/
        var ufavicon = $(obj).parents('td').find("#imgadd").find('img').length;
        if(ufavicon>=1){
            layer.msg('品牌图片只能上传一张!', {icon: 1, time: 1000});
            return;
        }
        var ccccc = new FormData();
        ccccc.append('upload_file', imgPath[0]);
        $.ajax({
            type: "POST",
            url: "<?php echo U('banner/ajaxupload');?>",
            data: ccccc,
            processData: false,
            contentType: false,
            success: function (data) {
                console.log(data.url);
                addimgs.append("<input type='hidden' id='bimgs' name='b_img' value='"+data.url+"'/><img src='" + data.url + "'   width='150px;' height='150px;'  style='margin-top:-1000px;'><img src='/Public/img/trash.png' class='delthis' style='margin-right:20px;'> ");
                layer.msg(data.info, {icon: 1, time: 1000});
            },
            error: function (e) {
                layer.msg(e.info, {icon: 1, time: 1000});
            }
        });
    };
    /*删除对应图片预览*/
    $("#imgadd").on("click",'.delthis',function(){
        $(this).prev().remove(); $(this).next().remove();$(this).remove();
        $("#bimgs").remove();
    });
</script>
</body>
</html>