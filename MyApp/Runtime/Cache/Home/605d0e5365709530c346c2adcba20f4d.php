<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="/Public/css/style.css"/>
    <link type="text/css" rel="stylesheet" href="/Public/css/liandong.css">
</head>
<body>
<div id="navtab1" style="width: 100%;  margin-top: -36px;">
    <div position="center">
        <table class="layerTable" border="0">
            <input type="hidden" id="pidtxt" name="p_id" value="<?php echo ($info["p_id"]); ?>"/>
            <tr class="h30">
                <td>产品名称：</td>
                <td>
                    <input class="must" type="text" name="p_name" id="pnametxt" value="<?php echo ($info["p_name"]); ?>" disabled/>
                </td>
                <td>单位：</td>
                <td>
                    <select name="p_cid" id="pcid" disabled>
                        <option value="">暂无数据</option>
                        <?php if(is_array($company_info)): $i = 0; $__LIST__ = $company_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$companyinfo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($companyinfo["c_id"]); ?>"
                            <?php if(($companyinfo["c_id"]) == $info["p_cid"]): ?>selected<?php endif; ?>
                            ><?php echo ($companyinfo["c_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </td>
            </tr>
            <tr class="h30">
                <td>品牌：</td>
                <td>
                    <select name="p_bid" id="pbid" disabled>
                        <option value="">暂无数据</option>
                        <?php if(is_array($brand_info)): $i = 0; $__LIST__ = $brand_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$brandinfo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($brandinfo["b_id"]); ?>"
                            <?php if(($brandinfo["b_id"]) == $info["p_bid"]): ?>selected<?php endif; ?>
                            ><?php echo ($brandinfo["b_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </td>
                <td>商家：</td>
                <td>
                    <select name="p_uid" id="puid" disabled>
                        <option value="">暂无数据</option>
                        <?php if(is_array($userinfo_info)): $i = 0; $__LIST__ = $userinfo_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$userinfoinfo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($userinfoinfo["u_id"]); ?>"
                            <?php if(($userinfoinfo["u_id"]) == $info["p_uid"]): ?>selected<?php endif; ?>
                            ><?php echo ($userinfoinfo["u_shopname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </td>
            </tr>
            <tr class="h30">
                <td>上下架：</td>
                <td>
                    <select name="p_state" id="pstate" disabled>
                        <option value="1"
                        <?php if(($info["p_state"]) == "1"): ?>selected<?php endif; ?>
                        >上架</option>
                        <option value="0"
                        <?php if(($info["p_state"]) == "0"): ?>selected<?php endif; ?>
                        >下架</option>
                    </select>
                </td>
                <td>是否删除：</td>
                <td>
                    <select name="p_del" id="pdel" disabled>
                        <option value="1"
                        <?php if(($info["p_del"]) == "1"): ?>selected<?php endif; ?>
                        >删除</option>
                        <option value="0"
                        <?php if(($info["p_del"]) == "0"): ?>selected<?php endif; ?>
                        >正常</option>
                    </select>
                </td>
            </tr>
            <tr class="h30">
                <td>产品类型：</td>
                <td>
                    <select name="p_type" id="ptype" disabled>
                        <option value="0">请选择</option>
                        <?php if(is_array($alist)): $i = 0; $__LIST__ = $alist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["pt_id"]); ?>"
                            <?php if(($vo["pt_id"]) == $info["p_type"]): ?>selected<?php endif; ?>
                            >
                            <?php echo str_repeat(" |-",$vo['count']-2);?>
                            <?php echo ($vo['pt_receptionname']); ?>
                            </option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </td>
                <td>卖点：</td>
                <td>
                    <input class="must" type="text" name="p_sellingpoint" id="psellingpoint"
                           value="<?php echo ($info["p_sellingpoint"]); ?>" disabled/>
                </td>
            </tr>
            <tr class="h25">
                <td>APP图片：</td>
                <td colspan="3">
                    <div id="imgadd" style="margin-top:10px;width: 520px;">
                        <?php if(is_array($imgs)): $i = 0; $__LIST__ = $imgs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$imgs): $mod = ($i % 2 );++$i;?><img src='<?php echo ($imgs); ?>' width='150px;' height='150px;' style='float:left;margin:0 0 0 0px;'><?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </td>
            </tr>
            <tr class="h25">
                <td>PC图片：</td>
                <td colspan="3">
                    <div class="imgadds imgadds2" style="margin-top:10px;width: 520px;">
                        <?php if(is_array($pcimgs)): $i = 0; $__LIST__ = $pcimgs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$imgs2): $mod = ($i % 2 );++$i;?><img src='<?php echo ($imgs2); ?>' width='150px;' height='150px;' style='float:left;margin:0 0 0 0px;'><?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </td>
            </tr>
            <tr class="h30">
                <td>商品描述：</td>
                <td colspan="3" style="padding: 0;">
                    <textarea id="contenttxt" name="p_content" style="width: 100%;height: 300px;" disabled>
                        <?php echo ($info["p_content"]); ?>
                    </textarea>
                </td>
            </tr>
            <tr class="h30">
                <td>搜索关键字：</td>
                <td>
                    <div class="Hui-tags">
                        <?php if(is_array($searchkeyword_info)): $i = 0; $__LIST__ = $searchkeyword_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$searchinfo): $mod = ($i % 2 );++$i;?><span class="Hui-tags-token"><?php echo ($searchinfo); ?></span><?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </td>
                <td>有无活动：</td>
                <td>
                    <select name="p_isactivity" id="pisactivity" onclick="displaytypes()" disabled>
                        <option value="1"
                        <?php if(($info["p_isactivity"]) == "1"): ?>selected<?php endif; ?>
                        >有活动</option>
                        <option value="0"
                        <?php if(($info["p_isactivity"]) == "0"): ?>selected<?php endif; ?>
                        >无活动</option>
                    </select>
                </td>
            </tr>
        </table>
        <div id="search-form-div" style="display: none;">
            <table class="layerTable" border="0">
                <tr class="h30">
                    <td>活动名称：</td>
                    <td colspan="3">
                        <input class="must" type="text" name="p_activityname" id="pactivityname" value="<?php echo ($info["p_activityname"]); ?>" disabled/>
                    </td>
                </tr>
                <tr class="h30">
                    <td>活动开始时间：</td>
                    <td>
                        <input type="text" name="p_activitystartime" class="Wdate" onFocus="WdatePicker({lang:'zh-cn'})"
                               id="pactivitystartime" value="<?php echo ($info["p_activitystartime"]); ?>" disabled/>
                    </td>
                    <td>活动结束时间：</td>
                    <td>
                        <input type="text" name="p_activityendtime" class="Wdate" onFocus="WdatePicker({lang:'zh-cn'})"
                               id="pactivityendtime" value="<?php echo ($info["p_activityendtime"]); ?>" disabled/>
                    </td>
                </tr>
            </table>
        </div>
        <div style="padding: 35px 8px; border: 1px solid #A3C0E8;" class="div_content">
            <div class="div_title"><span style="font-weight: bold;">产品属性：</span></div>
            <hr/>
            <div class="div_contentlist3">
                <ul>
                    <li>
                        <div id="createTable1">
                            <table id="process" style="width:100%;padding:5px;" cellspacing="0" cellpadding="1"
                                   border="1">
                                <thead>
                                <tr>
                                    <?php if(is_array($typenameinfo)): $i = 0; $__LIST__ = $typenameinfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$typename): $mod = ($i % 2 );++$i;?><th><?php echo ($typename); ?></th><?php endforeach; endif; else: echo "" ;endif; ?>
                                    <th style="width:10%;">价格</th>
                                    <th style="width:10%;">库存</th>
                                    <th style="width:10%;">活动价</th>
                                    <th style="width:10%;">原价</th>
                                    <th style="width:10%;">APP图上传</th>
                                    <th style="width:10%;">PC图上传</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(is_array($productattributevalueinfo)): $i = 0; $__LIST__ = $productattributevalueinfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$productattributevalueinfos): $mod = ($i % 2 );++$i;?><tr>
                                        <?php if(is_array($typenameinfo)): $k = 0; $__LIST__ = $typenameinfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$typename): $mod = ($k % 2 );++$k;?><td><?php echo ($productattributevalueinfos["1"]["$typename"]); ?></td><?php endforeach; endif; else: echo "" ;endif; ?>
                                        <td>￥<?php echo (number_format($productattributevalueinfos["0"]["atv_price"],2)); ?></td>
                                        <td><?php echo ($productattributevalueinfos["0"]["atv_stock"]); ?></td>
                                        <td>￥<?php echo (number_format($productattributevalueinfos["0"]["atv_activityprice"],2)); ?></td>
                                        <td>￥<?php echo (number_format($productattributevalueinfos["0"]["atv_originalprice"],2)); ?></td>
                                        <td>
                                            <div class="imgadd appimg"  style="margin-top:10px;">
                                                <img src='<?php echo ($productattributevalueinfos["0"]["atv_img"]); ?>' width='50px;' height='50px;' style='float:left;margin:0 0 0 0px;'>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="imgadd pcimg"  style="margin-top:10px;">
                                                <img src='<?php echo ($productattributevalueinfos["0"]["atv_pcimg"]); ?>' width='50px;' height='50px;' style='float:left;margin:0 0 0 0px;'>
                                            </div>
                                        </td>
                                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="div_contentlist2">
                <ul>
                    <li>
                        <div id="createTable"></div>
                    </li>
                </ul>
            </div>
        </div>

        <div style="padding: 35px 8px; border: 1px solid #00a0e9;">
            <div>
                <span style="font-weight: bold;">产品参数：</span><br/>
            </div>
            <hr/>
            <div id="newparameter">
                <?php if(empty($ppval)): ?>暂无参数<?php endif; ?>
                <?php if(is_array($ppval)): $i = 0; $__LIST__ = $ppval;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ppvals): $mod = ($i % 2 );++$i;?><span><?php echo ($ppvals["val"]); ?>:<?php echo ($ppvals["name"]); ?></span>&nbsp;&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        </div>
    </div>
    <form action="" method="post" class="js-ajax-form">
        <div style="padding: 10px 8px; border: 1px solid #00a0e9;">
            <div>
                <span style="font-weight: bold;">进行审核：</span><br/>
            </div>
            <table class="layerTable" border="0">
                <input type="hidden" id="pidtxt1" name="p_id" value="<?php echo ($info["p_id"]); ?>"/>
                <tr class="h30">
                    <td>审核状态：</td>
                    <td colspan="3">
                        <select name="p_shenhe" id="p_shenhe" onclick="jjcont()" <?php if($info['p_shenhe'] == 1||$info['p_shenhe'] == 2): ?>disabled<?php endif; ?>>
                             <option value="1"  <?php if(($info["p_shenhe"]) == "1"): ?>selected<?php endif; ?>>  通过</option>
                             <option value="2"  <?php if(($info["p_shenhe"]) == "2"): ?>selected<?php endif; ?>>  拒绝</option>
                        </select>
                    </td>
                </tr>
                <tr class="h30 jjcontent" style="display: none;">
                    <td>拒绝理由：</td>
                    <td colspan="3">
                        <textarea name="p_jjcontent" id="p_jjcontent" cols="30" rows="10" <?php if($info['p_shenhe'] == 1||$info['p_shenhe'] == 2): ?>disabled<?php endif; ?>><?php echo ($info["p_jjcontent"]); ?></textarea>
                    </td>
                </tr>
            </table>
        </div>
        <?php if($info['p_shenhe'] == 1||$info['p_shenhe'] == 2): else: ?>
            <div class="layerBtns1" id="bt1" >
                <a  class="btn js-ajax-form-btn layui-btn" data-layer="true">提交</a>
            </div><?php endif; ?>
    </form>
</div>
<script src="/Public/js/jquery2-1-4.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/layer/layer.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/js/htglxt.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/js/iframe.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/js/ajax-submit.js"></script>
<script src="/Public/js/My97DatePicker/WdatePicker.js"></script>
<link rel="stylesheet" type="text/css" href="/Public/kindeditor-4.1.10/themes/default/default.css"/>
<script type="text/javascript" charset="utf-8" src="/Public/kindeditor-4.1.10/kindeditor.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/kindeditor-4.1.10/lang/zh_CN.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/kindeditor-4.1.10/plugins/code/prettify.js"></script>
<script type="text/javascript" src="/Public/js/liandong.js"></script>
<script type="text/javascript" src="/Public/js/json2.js"></script>
<script>
    /*==========文本编辑器部分============*/
    var editor1;
    KindEditor.ready(function (K) {
        editor1 = kd('#contenttxt', K);
        editor_imgs = kdimg(K);
        K('#tianjiatupian').click(function () {
            editor_imgs.loadPlugin('image', function () {
                editor_imgs.plugin.imageDialog({
                    imageUrl: "",
                    clickFn: function (url, title, width, height, border, align) {
                        K("#tupiandiv").append("<div class=\"img\"><img class=\"w_100 h_100\" src=\"" + url + "\" /><p><span onclick=\"editormove(this,1)\">左移</span><span onclick=\"editormove(this,0)\">删除</span><span onclick=\"editormove(this,2)\">右移</span></p></div>");
                        editor_imgs.hideDialog();
                    }
                });
            });
        });
    });

    /*打开网页执行*/
    window.onload = function () {
        $("#p_shenhe").find("option:selected").trigger('click');
        displaytypes();
    };
    /*选中类型---显示与隐藏*/
    function displaytypes() {
        var pttype = $("#pisactivity").val();
        if (pttype == '0') {
            $("#search-form-div").hide();
        }
        if (pttype == '1') {
            $("#search-form-div").show();
        }
    }
    /*审核状态-------拒绝理由的显示与隐藏*/
    function jjcont() {
        var shenhe = $("#p_shenhe").find("option:selected").val();
        if(shenhe == 1){
            $(".jjcontent").hide();
        }
        if(shenhe == 2){
            $(".jjcontent").show();
        }
    }
</script>
</body>
</html>