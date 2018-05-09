<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>支付记录列表</title>
    <link rel="stylesheet" type="text/css" href="/Public/css/style.css"/>
    <script src="/Public/js/jquery2-1-4.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/layer/layer.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/htglxt.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/iframe.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/ajax-submit.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/My97DatePicker/WdatePicker.js"></script>
</head>
<body>
<h4>支付记录列表</h4>
<div class="toolsBar">
    <!--fgf为工具栏分隔符，刷新没有，离开都有。中间工具每一类第一个添加fgf-->
    <ul>
        <li onclick="reloadPage(window)">
            <img src="/Public/img/arrow_refresh.png"/>
            重置
        </li>
        <li class="fgf" onclick="layerDiv('查询',$('#search-form-div').html(),'560px','360px')">
            <img src="/Public/img/page_white_magnify.png"/>
            查询
        </li>
        <li class="fgf" onclick="modifystate(&#39;all&#39;)">
            <img src="/Public/img/edit.png"/>
            结账处理
        </li>
        <form action="<?php echo U('pay/excel_order');?>" method="post">
            <input type="hidden" name="ids" id="ids1" value=""><li class="fgf" style="padding-bottom: 0">
            <button  type="submit"  style="border:none;background-color: inherit;" onclick="exceldaochu(&#39;all&#39;)">
                <img src="/Public/img/excel_exports.png"/>Excel导出</button></li>
        </form>
    </ul>
</div>
<div class="tableCon">
    <div style="visibility: hidden;display: none;">
        <div id="search-form-div">
            <form action="/Pay/index_list" method="post" id="search-form" class="layui-form">
                <div class="layerCon bg_f">
                    <table class="layerTable" border="0">
                        <tr class="h50">
                            <td><label for="uid_name">用户：</label></td>
                            <td>
                                <input id="uid_name" type="text" name="c_name" value="<?php echo ($uid_name); ?>"  placeholder="请输入用户名称"/>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td><label for="p_time">创建时间：</label></td>
                            <td>
                                开始时间：<input id="p_time" type="text" class="Wdate" onFocus="WdatePicker({lang:'zh-cn'})"
                                            name="p_time1" value="<?php echo ($p_time1); ?>"/>
                                结束时间：<input id="p_time1" type="text" class="Wdate" onFocus="WdatePicker({lang:'zh-cn'})"
                                            name="p_time2" value="<?php echo ($p_time2); ?>"/>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td><label for="p_state">支付类型：</label></td>
                            <td>
                                <select id="p_type" name="p_type" >
                                    <option value="">=====无=====</option>
                                    <option value="10000" <?php if(($p_type) == "10000"): ?>selected<?php endif; ?>>====商城====</option>
                                    <option value="20000" <?php if(($p_type) == "20000"): ?>selected<?php endif; ?>>====维修====</option>
                                    <option value="30000" <?php if(($p_type) == "30000"): ?>selected<?php endif; ?>>====维修保证金====</option>
                                    <option value="50000" <?php if(($p_type) == "50000"): ?>selected<?php endif; ?>>====装修====</option>
                                </select>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td><label for="p_state">支付状态：</label></td>
                            <td>
                                <select id="p_state" name="p_state" >
                                    <option value="">=====无=====</option>
                                    <option value="0" <?php if(($p_state) == "0"): ?>selected<?php endif; ?>>====申请支付====</option>
                                    <option value="1" <?php if(($p_state) == "1"): ?>selected<?php endif; ?>>====支付成功====</option>
                                    <option value="2" <?php if(($p_state) == "2"): ?>selected<?php endif; ?>>====支付失败====</option>
                                </select>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td><label for="p_jiezhang">结账状态：</label></td>
                            <td>
                                <select id="p_jiezhang" name="p_jiezhang" >
                                    <option value="">=====无=====</option>
                                    <option value="0" <?php if(($p_jiezhang) == "0"): ?>selected<?php endif; ?>>====未结账====</option>
                                    <option value="1" <?php if(($p_jiezhang) == "1"): ?>selected<?php endif; ?>>====处理中====</option>
                                    <option value="2" <?php if(($p_jiezhang) == "2"): ?>selected<?php endif; ?>>====已结账====</option>
                                    <option value="3" <?php if(($p_jiezhang) == "3"): ?>selected<?php endif; ?>>====拒绝结账====</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                    <div class="layerBtns1">
                        <button class="btn" type="submit">提交</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="search-form-div2">
            <form action="<?php echo U('state_modify');?>" method="post" class="js-ajax-form" >
                <div class="layerCon bg_f">
                    <table class="layerTable" border="0">
                        <input type="hidden" name="p_id" id="pdidtxt" value="">
                        <tr class="h50">
                            <td><label>结账状态：</label></td>
                            <td>
                                <select  name="p_jiezhang" class="pdstatetxt" onchange="kdstate(this)" >
                                    <option value="0">未结账</option>
                                    <option value="2">已结账</option>
                                    <option value="3">拒绝结账</option>
                                </select>
                            </td>
                        </tr>
                        <tr class="h50 kd" style="display: none">
                            <td>拒绝理由：</td>
                            <td><textarea name="p_jjcontent" class="kuaidival" id="p_jjcontent" cols="10" rows="5">
                            </textarea></td>
                        </tr>
                    </table>
                    <div class="layerBtns">
                        <button type="submit" class="btn js-ajax-form-btn layui-btn" data-layer="true">提交</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <em class="xian"></em>
    <form action="/Pay/index_list" method="post" class="js-ajax-form" id="js-ajax-form">
        <table class="table" border="0">
            <thead>
            <tr class="noSelect">
                <th class="tc" width="35px">
                    <input class="va_m" type="checkbox" name="" id="allCheck" value="" data-falg="allCheck" onclick="checkBoxOp(this)"/>
                </th>
                <th width="40">ID</th>
                <th>用户昵称</th>
                <th>商家店铺名</th>
                <th>创建时间</th>
                <th>支付类型</th>
                <th>支付类型ID</th>
                <th>支付方式</th>
                <th>支付金额</th>
                <th>支付状态</th>
                <th>支付回调时间</th>
                <th>支付回执码</th>
                <th>是否结账</th>
                <th>结账状态改变时间</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($pay_info)): $i = 0; $__LIST__ = $pay_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$info): $mod = ($i % 2 );++$i;?><tr>
                    <td>
                        <input class="va_m" type="checkbox" name="ids[]" value="<?php echo ($info["p_id"]); ?>" onclick="checkBoxOp(this)" />
                    </td>
                    <td><?php echo ($info["p_id"]); ?></td>
                    <td><?php if(!empty($info["uid_name"])): echo ($info["uid_name"]); else: ?>无昵称或账号已被删除<?php endif; ?></td>
                    <td><?php if(($info["p_type"]) == "10000"): echo ($info["uidname"]); else: ?>暂无内容<?php endif; ?></td>
                    <td><?php echo (date('Y-m-d H:i',strtotime($info["p_time"]))); ?></td>
                    <td><?php if(($info["p_type"]) == "10000"): ?>商城<?php endif; if(($info["p_type"]) == "20000"): ?>维修<?php endif; ?>
                        <?php if(($info["p_type"]) == "30000"): ?>维修保证金<?php endif; if(($info["p_type"]) == "50000"): ?>装修<?php endif; ?></td>
                    <td><?php echo ($info["p_ddid"]); ?></td>
                    <td><?php if(($info["p_paytype"]) == "10000"): ?>支付宝<?php endif; if(($info["p_paytype"]) == "20000"): ?>微信<?php endif; ?>
                        <?php if(($info["p_paytype"]) == "0"): ?>暂未支付<?php endif; ?></td>
                    <td><?php echo (number_format($info["p_money"],2)); ?></td>
                    <td><?php if(($info["p_state"]) == "0"): ?>申请支付<?php endif; if(($info["p_state"]) == "1"): ?>支付成功<?php endif; ?>
                        <?php if(($info["p_state"]) == "2"): ?>支付失败<?php endif; ?></td>
                    <td><?php echo (date('Y-m-d H:i',strtotime($info["p_backtime"]))); ?></td>
                    <td><?php echo ($info["p_backnumber"]); if(empty($info["p_backnumber"])): ?>暂无回执码<?php endif; ?></td>
                    <td><?php if(($info["p_jiezhang"]) == "0"): ?>未结账<?php endif; ?>
                        <?php if(($info["p_jiezhang"]) == "1"): ?>处理中<?php endif; ?>
                        <?php if(($info["p_jiezhang"]) == "2"): ?>已结账<?php endif; ?>
                        <?php if(($info["p_jiezhang"]) == "3"): ?>拒绝结账<?php endif; ?>
                    </td>
                    <td><?php if(empty($info["p_jztime"])): ?>暂无<?php else: if(($info["p_jztime"]) == "1900-01-01 00:00:00.000"): ?>暂无<?php else: echo (date('Y-m-d H:i',strtotime($info["p_jztime"]))); endif; endif; ?></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
    </form>
</div>
<div class="pageCon">
    <?php echo ($page_bar); ?>       每页 20 条，共 <?php echo ($count); ?> 条
</div>

<script>
    /*拒绝理由的显示与隐藏*/
    function  kdstate(obj) {
        var a = $(obj).val();
        if(a==3){
            $(".kd").show();
        }else{
            $(".kuaidival").val("");
            $(".kd").hide();
        }
    }
    /*excel导出*/
    function exceldaochu(rs) {
        var ids = "";
        if (rs == "all") {
            var checkedlist = $("input[name=\"ids[]\"]:checked");
            for (var i = 0; i < checkedlist.length; i++) {
                ids += $(checkedlist[i]).val();
                if (i < checkedlist.length - 1) ids += ",";
            }
        } else {
            ids = rs;
        }
        if (ids == "") {
            layer.msg('请选择要导出的数据!', { icon: 1, time: 1000 });
            return;
        }
        $("#ids1").val(ids);
    }
    /*批量修改状态*/
    function modifystate(rs) {
        var ids = "";
        if (rs == "all") {
            var checkedlist = $("input[name=\"ids[]\"]:checked");
            for (var i = 0; i < checkedlist.length; i++) {
                ids += $(checkedlist[i]).val();
                if (i < checkedlist.length - 1) ids += ",";
            }
        } else {
            ids = rs;
        }
        if (ids == "") {
            layer.msg('请选择要处理的数据!', { icon: 1, time: 1000 });
            return;
        }else{
            layer.closeAll('dialog');
            $('#pdidtxt').val(ids);
            layerDiv('批量修改',$('.search-form-div2').html(),'500px','260px');
            var pdid =  $('.search-form-div2 #pdidtxt').val(ids);
        }
    }

    $(function () {
        $('.pageCon').find('a').on('click',function () {
            $('#search-form').attr('action',$(this).attr('href')).submit();
            return false;
        });
    });

    /* 重载页面 */
    function reloadPage(win) {
        var location = win.location;
        location.href = location.pathname + location.search;
    }
</script>
</body>
</html>