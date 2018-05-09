<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>修改维修类型</title>
    <link rel="stylesheet" type="text/css" href="/Public/css/style.css"/>
</head>
<body>
    <div class="layerCon bg_f">
        <div id="search-form-div" style="display: none;" >
            <table  class="layerTable" border="0">
                <tr class="h30">
                    <td id="feiyongval"></td>
                    <td colspan="5">
                        <input type="text"  id="rt_artificials" value="<?php echo (number_format($info["rt_artificial"],2)); ?>">
                        <input type="hidden" name="rt_artificial" id="rt_artificial" value="<?php echo ($info["rt_artificial"]); ?>">
                    </td>
                    <td id="feiyongvals"></td>
                    <td colspan="5">
                        <input type="text"  id="rt_thedoors" value="<?php echo (number_format($info["rt_thedoor"],2)); ?>">
                        <input type="hidden" name="rt_thedoor" id="rt_thedoor" value="<?php echo ($info["rt_thedoor"]); ?>">
                    </td>
                </tr>
                <tr class="h30">
                    <td>单位：</td>
                    <td colspan="11">
                        <input type="text" name="rt_company" id="rt_company" value="<?php echo ($info["rt_company"]); ?>">
                    </td>
                </tr>
            </table>
        </div>
        <table class="layerTable" border="0">
            <input type="hidden" name="rt_id" id="rtidtxt" value="<?php echo ($info["rt_id"]); ?>">
            <tr class="h30">
                <td>上级名称：</td>
                <td colspan="5">
                    <select class="select" id="ptidtxt" name="rt_pid" onchange="choicetypestate()" disabled>
                        <option value="0">----------请选择父级-----------</option>
                        <?php if(is_array($repairtype_father)): foreach($repairtype_father as $key=>$v): ?><option value="<?php echo ($v["rt_id"]); ?>" <?php if(($v["rt_id"]) == $info["rt_pid"]): ?>selected<?php endif; ?>><?php echo ($v["rt_receptionname"]); ?></option><?php endforeach; endif; ?>
                    </select>
                </td>
                <td>类型：</td>
                <td colspan="5">
                   <select name="rt_type" id="rttype" disabled>
                       <option value="10000" <?php if(($info["rt_type"]) == "10000"): ?>selected<?php endif; ?>>维修类</option>
                       <option value="20000" <?php if(($info["rt_type"]) == "20000"): ?>selected<?php endif; ?>>安装类</option>
                   </select>
                </td>
            </tr>
            <tr class="h30">
                <td>展示名称：</td>
                <td colspan="11">
                    <input class="must" type="text" name="rt_receptionname" id="rtreceptionname" value="<?php echo ($info["rt_receptionname"]); ?>" disabled />
                </td>
            </tr>
            <tr class="h30">
                <td>提交类型：</td>
                <td colspan="5">
                    <select name="rt_choicetype" id="rt_choicetype" onchange="choicetype()" disabled>
                        <option value="1" <?php if(($info["rt_choicetype"]) == "1"): ?>selected<?php endif; ?>>标价购买</option>
                        <option value="0" <?php if(($info["rt_choicetype"]) == "0"): ?>selected<?php endif; ?>>评估维修</option>
                    </select>
                </td>
                <td>排序：</td>
                <td colspan="5">
                    <input class="must" type="text" name="rt_order" id="rtorder" value="<?php echo ($info["rt_order"]); ?>" disabled/>
                </td>
            </tr>
            <tr class="h30">
                <td>师傅类型：</td>
                <td colspan="11">
                        <?php if(is_array($constructiontype_info)): $i = 0; $__LIST__ = $constructiontype_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$infos): $mod = ($i % 2 );++$i;?><li  style="list-style: none;margin-right:10px;float: left;">
                                <lable style="cursor: pointer;"><input type="checkbox" id="rtctid" style="!important;width: 15px;height: 15px;" disabled class="chcBox_Width" name="rt_ctid" value="<?php echo ($infos["ct_id"]); ?>" <?php if(is_array($ctid)): $i = 0; $__LIST__ = $ctid;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ctids): $mod = ($i % 2 );++$i; if(($infos["ct_id"]) == $ctids): ?>checked<?php endif; endforeach; endif; else: echo "" ;endif; ?>>
                                    <?php echo ($infos["ct_name"]); ?><span class="li_empty"> </span></lable>
                            </li><?php endforeach; endif; else: echo "" ;endif; ?>
                </td>
            </tr>
            <tr class="h30">
                <td>相关描述：</td>
                <td colspan="11">
                    <textarea name="rt_content" id="rtcontent"  cols="10" rows="6" disabled><?php echo ($info["rt_content"]); ?></textarea>
                </td>
            </tr>
            <tr class="h30">
                <td>缩略图：</td>
                <td colspan="11">
                    <div class="imgadd rt_img"  style="margin-top:10px;width: 820px;">
                        <?php if(is_array($imgs)): $i = 0; $__LIST__ = $imgs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$imgs1): $mod = ($i % 2 );++$i;?><img src='<?php echo ($imgs1); ?>' width='150px;' height='150px;' style='float:left;margin:0 0 0 0px;'><?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                    <br/>
                </td>
            </tr>
            <tr class="h30">
                <td>效果轮播图：</td>
                <td colspan="11">
                    <form enctype="multipart/form-data" method="post" class="img1">
                        <div class="imgadd rt_imglist"  style="margin-top:10px;width: 520px;">
                            <?php if(is_array($imglist)): $i = 0; $__LIST__ = $imglist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$imglists): $mod = ($i % 2 );++$i;?><img src='<?php echo ($imglists); ?>' width='150px;' height='150px;' style='float:left;margin:0 0 0 0px;'><?php endforeach; endif; else: echo "" ;endif; ?>
                        </div>
                    </form>

                    <br/>
                </td>
            </tr>
            <tr class="h25"></tr>
            <tr class="h25"></tr>
        </table>
    </div>
<script src="/Public/js/jquery2-1-4.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/layer/layer.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/js/htglxt.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/js/iframe.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/js/jquery.treetable.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/js/ajax-submit.js"></script>
<script>
    /*价格显示*/
    $('#rt_artificials').on('keyup',function () {
        var _this = $(this).val();
        $('#rt_artificial').val(_this);
    });
    $('#rt_thedoors').on('keyup',function () {
        var _this = $(this).val();
        $('#rt_thedoor').val(_this);
    });

    /*打开网页执行*/
    window.onload=function(){
        choicetypestate();
        if($("#rt_choicetype").val()=="1"){
            $("#feiyongval").html("维修费<br/>(用户查看)");
            $("#feiyongvals").html("维修费<br/>(师傅查看)");
        }else{
            $("#feiyongval").html("上门费<br/>(用户查看)");
            $("#feiyongvals").html("上门费<br/>(师傅查看)");
        }
    };
    /*根据提交类型改变值*/
    function choicetype() {
        if($("#rt_choicetype").val()=="1"){
            $("#feiyongval").html("维修费<br/>(用户查看)");
            $("#feiyongvals").html("维修费<br/>(师傅查看)");
        }else{
            $("#feiyongval").html("上门费<br/>(用户查看)");
            $("#feiyongvals").html("上门费<br/>(师傅查看)");
        }
    }

    /*根据上级名称判断品牌是否显示*/
    $(".layerCon").on('click', '#ptidtxt', function () {
        if ($(this).val() != '0') {
            $("#search-form-div").show();
        }
        if ($(this).val() == '0') {
            $("#search-form-div").hide();
        }
    });

        /*根据上级名称显示是否在前台展示下拉框的内容*/
    function choicetypestate(){
        var ptidtxt = $("#ptidtxt").val();
        if(ptidtxt!='0'){
            $("#rtchoicetype").html("<option value='0'>否</option>");
        }
        if(ptidtxt=='0'){
            $("#rtchoicetype").html("<option value='1'>是</option><option value='0'>否</option>");
        }
        $("#ptidtxt").trigger("click");
    }
</script>
</body>
</html>