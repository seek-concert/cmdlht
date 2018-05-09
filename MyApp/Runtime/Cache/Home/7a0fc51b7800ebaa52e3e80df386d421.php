<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>装修报价类型</title>
    <link rel="stylesheet" type="text/css" href="/Public/css/style.css"/>
    <link rel="stylesheet" type="text/css" href="/Public/layer/skin/default/layer.css"/>
</head>
<body>
<form action="<?php if(empty($info)): echo U('insert'); else: echo U('modify'); endif; ?>" method="post" class="js-ajax-form">
<div class="layerCon bg_f">
    <table class="layerTable" border="0">
        <input type="hidden" name="qc_id" value="<?php echo ($info["qc_id"]); ?>">
        <tr class="h50">
            <td>报价名称：</td>
            <td colspan="5">
                <input class="must" type="text" name="qc_title" id="" value="<?php echo ($info["qc_title"]); ?>"  placeholder="请输入报价名称"/>
            </td>
            <td>价格：</td>
            <td colspan="5">
                <input class="must" type="text" name="qc_price" id="" value="<?php echo ($info["qc_price"]); ?>"  placeholder="请输入价格"/>
            </td>
        </tr>
        <tr class="h50">
            <td>类型：</td>
            <td colspan="5">
                <select name="qc_type" id="qc_type" >
                    <option value="10000" <?php if(($info["qc_type"]) == "10000"): ?>selected<?php endif; ?>>地区</option>
                    <option value="20000" <?php if(($info["qc_type"]) == "20000"): ?>selected<?php endif; ?>>面积</option>
                    <option value="30000" <?php if(($info["qc_type"]) == "30000"): ?>selected<?php endif; ?>>厅</option>
                    <option value="40000" <?php if(($info["qc_type"]) == "40000"): ?>selected<?php endif; ?>>室</option>
                    <option value="50000" <?php if(($info["qc_type"]) == "50000"): ?>selected<?php endif; ?>>卫</option>
                    <option value="60000" <?php if(($info["qc_type"]) == "60000"): ?>selected<?php endif; ?>>风格</option>
                </select>
            </td>
            <td>状态：</td>
            <td colspan="5">
                <label style="display:inline-block;"><input  type="radio" name="qc_state" style="width: 15px;height: 15px;" value="1" <?php if(($info["qc_state"]) == "1"): ?>checked<?php endif; ?>/>启用</label>
                <label style="display:inline-block;"><input  type="radio" name="qc_state" style="width: 15px;height: 15px;" value="0" <?php if(($info["qc_state"]) == "0"): ?>checked<?php endif; ?> />停用</label>
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
<script type="text/javascript">
    var layerNav = $(".layerNav a");
    var lytbCon = $(".lytbCon");
    $(layerNav).each(function(index, e) {
        $(e).click(function() {
            $(this).addClass("on").siblings().removeClass("on");
            $(lytbCon).eq(index).addClass("on").siblings().removeClass("on");
        });
    });
    $("#example-advanced").treetable({
        expandable : true
    });
    //    $('input').on('change',function () {
    //        checkbox_change($(this));
    //    }) ;

</script>
</body>
</html>