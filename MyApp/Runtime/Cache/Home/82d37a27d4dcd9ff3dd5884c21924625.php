<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>个人中心-密码修改</title>
    <link rel="stylesheet" type="text/css" href="/Public/css/style.css"/>
</head>
<body>
<div class="layerCon bg_f">
    <h4>个人中心----->密码修改</h4>
    <table class="layerTable" border="0">
        <tr class="h30">
            <td>旧密码：</td>
            <td colspan="5">
                <input class="must" type="password" name="a_loginpassword" id="a_loginpassword" value="" />
            </td>
        </tr>
        <tr class="h30">
            <td>新密码：</td>
            <td colspan="5">
                <input class="must" type="password" name="a_loginpassword1" id="a_loginpassword1" value="" />
            </td>
        </tr>
        <tr class="h30">
            <td>重复新密码：</td>
            <td colspan="5">
                <input class="must" type="password" name="a_loginpassword2" id="a_loginpassword2" value="" />
            </td>
        </tr>
                <span id="ts" style="color: red;"></span>
        <div class="layerBtns">
            <a class="btn"  id="ajaxmodify">修改</a>
        </div>
    </table>
</div>
<script src="/Public/js/jquery2-1-4.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/layer/layer.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/js/htglxt.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/js/iframe.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/js/jquery.treetable.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/js/ajax-submit.js"></script>
<script>
    /*判断新密码和重复密码是否相同*/
    $("#a_loginpassword2").on('blur',function() {
      var a = $("#a_loginpassword1").val();
      var b = $("#a_loginpassword2").val();
      if(a!=b){
          layer.msg("新密码和重复密码不相同！");
      }
    });
    /*================ajax修改====================*/
    $("#ajaxmodify").click(function(){
            var a_loginpassword = $("#a_loginpassword").val();
            var a_loginpassword1 = $("#a_loginpassword1").val();
            var data = {
                'a_loginpassword':a_loginpassword,
                'a_loginpassword1':a_loginpassword1
            };
            console.log(data);
            var index = layer.load({ shade: [0.5, '#fff'] });
            $.ajax({
                type: "post",
                url: "<?php echo U('index/modifypwd');?>",
                data: data,
                dataType: "json",
                success: function (e) {
                    layer.close(index);
                    if (e.status == 1) {
                        layer.msg(e.info);
                        location.href=e.url;
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
</script>
</body>
</html>