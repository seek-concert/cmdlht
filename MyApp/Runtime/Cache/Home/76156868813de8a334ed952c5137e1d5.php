<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>添加单位</title>
    <link rel="stylesheet" type="text/css" href="/Public/css/style.css"/>
</head>
<body>
    <div class="layerCon bg_f">
        <table class="layerTable" border="0">
            <tr class="h50">
                <td>单位：</td>
                <td colspan="5">
                    <input class="must" type="text" name="c_name" id="c_name" value=""  placeholder="请输入单位名称"/>
                </td>
            </tr>
            <tr class="h50">
                <td>商家：</td>
                <td colspan="5">
                    <select name="c_uid" id="cuid">
                        <?php if(is_array($userinfo_info)): $i = 0; $__LIST__ = $userinfo_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$userinfoinfo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($userinfoinfo["u_id"]); ?>"><?php echo ($userinfoinfo["u_shopname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </td>
            </tr>
        </table>
    <div class="layerBtns">
        <a class="btn"  id="ajaxinsert">提交</a>
    </div>
    </div>
<script src="/Public/js/jquery2-1-4.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/layer/layer.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/js/htglxt.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/js/iframe.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/js/jquery.treetable.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/js/ajax-submit.js"></script>
<script>


    /*================ajax添加====================*/
    $(function(){
        $("#ajaxinsert").click(function(){
            var c_name = $("#c_name").val();
            var c_uid = $("#cuid").val();
            var data = {
                'c_name':c_name,
                'c_uid':c_uid
            };
            var index = layer.load({ shade: [0.5, '#fff'] });
            $.ajax({
                type: "post",
                url: "<?php echo U('company/insert');?>",
                data: data,
                dataType: "json",
                success: function (e) {
                    layer.close(index);
                    if (e.status == 1) {
                        layer.msg(e.info);
                        window.parent.location.reload();
                    }
                    if(e.status == 0){
                        layer.msg(e.info);
                    }
                },
                error: function () {
                    layer.close(index);
                    layer.alert('操作失败！');
                }
            });
        })
    })
</script>
</body>
</html>