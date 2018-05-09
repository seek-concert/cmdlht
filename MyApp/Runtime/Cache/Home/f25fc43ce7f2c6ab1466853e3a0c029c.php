<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>申请人信息</title>
    <link rel="stylesheet" type="text/css" href="/Public/css/style.css"/>
    <script src="/Public/js/jquery2-1-4.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/layer/layer.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/htglxt.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/iframe.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/ajax-submit.js" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" href="/Public/xzimg/viewer.min.css">
    <script src="/Public/xzimg/viewer-jquery.min.js" charset="utf-8"></script>

</head>
<body>
<div class="layerCon bg_f">
    <form action="<?php echo U('modify');?>" method="post" class="js-ajax-form">
        <table class="layerTable" border="0">
            <input type="hidden" name="th_uid" value="<?php echo ($infos["th_uid"]); ?>">
            <input type="hidden" name="rh_ctrid" value="<?php echo ($infos["rh_ctrid"]); ?>">
            <input type="hidden" name="th_type" value="<?php echo ($infos["th_type"]); ?>">
            <input type="hidden" name="thstate" value="<?php echo ($infos["thstate"]); ?>">
            <tr class="h50">
                <td>唯一编号：</td>
                <td colspan="5"><?php echo ($info["u_number"]); ?></td>
                <td>账号类型：</td>
                <td colspan="5"><?php if(($info["u_type"]) == "2"): ?>师傅<?php if(($info["u_appoint"]) == "0"): ?>（个人）<?php else: ?>（团队）<?php endif; endif; if(($info["u_type"]) == "3"): ?>商家<?php endif; ?></td>
            </tr>
            <tr class="h50">
                <td>登陆账号：</td>
                <td colspan="5"><?php echo ($info["u_loginname"]); ?></td>
                <td>电话：</td>
                <td colspan="5"><?php echo ($info["u_phone"]); ?></td>
            </tr>
            <tr class="h50">
                <td>昵称：</td>
                <td colspan="5"><?php echo ($info["u_nickname"]); ?></td>
                <td>注册时间：</td>
                <td colspan="5"><?php echo ($info["u_time"]); ?></td>
            </tr>
            <tr class="h50">
                <td>银行名称：</td>
                <td colspan="5"><?php echo ($info["u_bankname"]); ?></td>
                <td>银行卡号：</td>
                <td colspan="5"><?php echo ($info["u_bankcard"]); ?></td>
            </tr>
            <tr class="h50">
                <td>联系电话：</td>
                <td colspan="5"><?php echo ($info["u_tel"]); ?></td>
                <td>联系地址：</td>
                <td colspan="5"><?php echo ($info["u_address"]); ?></td>
            </tr>

            <?php if(($infos["th_type"]) == "1"): ?><tr class="h50">
                <td>店铺名称：</td>
                <td colspan="5"><?php echo ($info["u_shopname"]); ?></td>
                <td>售后电话：</td>
                <td colspan="5"><?php echo ($info["u_aftermarketcalls"]); ?></td>
                <tr class="h50">
                    <td>产品销售环境图：</td>
                    <td colspan="11">
                        <div class="doweboks">
                        <?php if(is_array($uenvironmental_imglist)): $i = 0; $__LIST__ = $uenvironmental_imglist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$uenvironmentalimglist): $mod = ($i % 2 );++$i;?><img data-original="<?php echo ($uenvironmentalimglist); ?>" src="<?php echo ($uenvironmentalimglist); ?>" width="220px;" height="200px;"  alt="产品销售环境图">&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?>
                        </div>
                    </td>
                </tr>
            </tr><?php endif; ?>
            <?php if(($infos["th_type"]) == "2"): ?><tr class="h50">
                    <td>真实姓名：</td>
                    <td colspan="5"><?php echo ($info["u_realname"]); ?></td>
                    <td>身份证：</td>
                    <td colspan="5"><?php echo ($info["u_carded"]); ?></td>
                </tr>
                <tr class="h50">
                    <td>申请类型：</td>
                    <td colspan="11">
                        <div class="doweboks">
                        <?php if(is_array($ctname)): $i = 0; $__LIST__ = $ctname;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ctnames): $mod = ($i % 2 );++$i; if(!empty($ctnames["0"])): ?><div style="height: 200px;">
                                         <div style="height: 200px; width:50px;padding:100px auto; float: left;"><?php echo ($ctnames["1"]); ?>&nbsp;</div>
                                         <img src="<?php echo ($ctnames["0"]); ?>" data-original="<?php echo ($ctnames["0"]); ?>" alt="资源未加载" width="200px;" height="200px;"  style="float: left;" >
                                    </div><hr/><?php endif; ?>
                                <?php if(empty($ctnames["0"])): ?><div style="height: 30px;">
                                         <div style="height: 30px; width:50px;padding:auto; float: left;"><?php echo ($ctnames["1"]); ?>&nbsp;</div>
                                    </div><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                        </div>
                    </td>
                </tr><?php endif; ?>
            <tr>
                <td>身份证图片：</td>
                <td colspan="11">
                    <div class="doweboks">
                        <?php if(empty($ucardedimg)): ?>暂无身份证图片<?php endif; ?>
                    <?php if(is_array($ucardedimg)): $i = 0; $__LIST__ = $ucardedimg;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ucardedimgs): $mod = ($i % 2 );++$i;?><img src="<?php echo ($ucardedimgs); ?>" data-original="<?php echo ($ucardedimgs); ?>" width="220px;" height="220px;"   alt="暂无身份证图片">&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </td>
            </tr>
            <tr class="h50">
                <td>营业执照图片：</td>
                <td colspan="11">
                    <div class="doweboks">
                        <?php if(empty($ubusinesslicense_imglist)): ?>暂无营业执照图片<?php endif; ?>
                    <?php if(is_array($ubusinesslicense_imglist)): $i = 0; $__LIST__ = $ubusinesslicense_imglist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ubusinesslicenseimglist): $mod = ($i % 2 );++$i;?><img src="<?php echo ($ubusinesslicenseimglist); ?>" data-original="<?php echo ($ubusinesslicenseimglist); ?>"  width="220px;" height="220px;"   alt="暂无营业执照图片" >&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </td>
            </tr>
            <tr class="h50">
                <td>实体店门面图：</td>
                <td colspan="11">
                    <div class="doweboks">
                        <?php if(empty($ustoremap_imglist)): ?>暂无实体店门面图<?php endif; ?>
                    <?php if(is_array($ustoremap_imglist)): $i = 0; $__LIST__ = $ustoremap_imglist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ustoremapimglist): $mod = ($i % 2 );++$i;?><img src="<?php echo ($ustoremapimglist); ?>"  data-original="<?php echo ($ustoremapimglist); ?>" width="220px;" height="220px;" alt="暂无实体店门面图">&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </td>
            </tr>
            <tr class="h50">
                <td>账号状态：</td>
                <td colspan="5"><?php if(($info["u_toexamine"]) == "0"): ?>新注册的号<?php endif; ?>
                    <?php if(($info["u_toexamine"]) == "1"): ?>通过审核<?php endif; ?>
                    <?php if(($info["u_toexamine"]) == "2"): ?>资料不合格未通过<?php endif; ?>
                    <?php if(($info["u_toexamine"]) == "3"): ?>编辑资料待审核<?php endif; ?></td>
                <td>审核状态：</td>
                <td colspan="5">
                    <select name="th_state" id="th_state" onchange="thstates()">
                        <option value="3" <?php if(($state_content["th_state"]) == "3"): ?>selected<?php endif; ?>>=====通过=====</option>
                        <option value="4" <?php if(($state_content["th_state"]) == "4"): ?>selected<?php endif; ?>>=====拒绝=====</option>
                    </select>
                </td>
            </tr>
            <tr class="h50" id="thcontent" style="display: none;">
                <td>拒绝理由：</td>
                <td colspan="11">
                    <textarea name="th_content" id="th_content" cols="30" rows="6"><?php echo ($state_content["th_content"]); ?></textarea>
                </td>
            </tr>
            <tr class="h30"></tr>
        </table>
        <div class="layerBtns">
            <a class="btn js-ajax-form-btn layui-btn" data-layer="true" >审核</a>
        </div>
    </form>
</div>
<script>
    $(function() {
        $('.doweboks').viewer({
            url: 'data-original'
        });
    });
    var thstate = $("#th_state").val();
        if(thstate=="3"){
            $("#thcontent").hide()
        }
        if(thstate=="4"){
            $("#thcontent").show()
        }

        function thstates() {
            var thstate = $("#th_state").val();
            if(thstate=="3"){
                $("#thcontent").hide()
            }
            if(thstate=="4"){
                $("#thcontent").show()
            }
        }

</script>
</body>
</html>