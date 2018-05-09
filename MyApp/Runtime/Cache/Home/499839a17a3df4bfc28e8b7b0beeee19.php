<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>产品订单</title>
    <link rel="stylesheet" type="text/css" href="/Public/css/style.css"/>
    <script src="/Public/js/jquery2-1-4.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/layer/layer.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/htglxt.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/iframe.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/ajax-submit.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/My97DatePicker/WdatePicker.js"></script>
</head>
<body>
<h4>产品订单列表</h4>
<div class="toolsBar">
    <!--fgf为工具栏分隔符，刷新没有，离开都有。中间工具每一类第一个添加fgf-->
    <ul>
        <li onclick="reloadPage(window)">
            <img src="/Public/img/arrow_refresh.png"/>
            重置
        </li>
        <li class="fgf" onclick="layerDiv('查询',$('#search-form-div').html(),'560px','410px')">
            <img src="/Public/img/page_white_magnify.png"/>
            查询
        </li>
        <li class="fgf" onclick="layerPage('统计折线图','<?php echo U('statistics');?>','750px','520px')">
            <img src="/Public/img/chart_bar.png"/>
            统计
        </li>
        <li class="fgf" onclick="modifystate(&#39;all&#39;)">
            <img src="/Public/img/edit.png"/>
            批量修改
        </li>
        <form action="<?php echo U('productorder/excel_order');?>" method="post">
            <input type="hidden" name="ids" id="ids1" value=""><li class="fgf" style="padding-bottom: 0">
             <button  type="submit" style="border:none;background-color: inherit;" onclick="exceldaochu(&#39;all&#39;)">
            <img src="/Public/img/excel_exports.png"/>Excel导出</button></li>
        </form>
    </ul>
</div>
<div class="tableCon">
    <div style="visibility: hidden;display: none;">
        <div id="search-form-div">
            <form action="/Productorder/index_list" method="post" id="search-form" class="layui-form">
                <div class="layerCon bg_f">
                    <table class="layerTable" border="0">
                        <tr class="h50">
                            <td><label for="pd_onlyid">订单唯一编号：</label></td>
                            <td>
                                <input id="pd_onlyid" type="text" name="pd_onlyid" value="<?php echo ($pdonlyid); ?>" placeholder="请输入订单唯一编号"/>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td><label>下单时间：</label></td>
                            <td>
                                开始时间：<input  type="text" class="Wdate" onFocus="WdatePicker({lang:'zh-cn'})"  name="pd_time1" value="<?php echo ($pdtime1); ?>"/>
                                结束时间：<input  type="text" class="Wdate" onFocus="WdatePicker({lang:'zh-cn'})"  name="pd_time2" value="<?php echo ($pdtime2); ?>"/>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td><label for="pd_state">订单状态：</label></td>
                            <td>
                                <select  id="pd_state"  name="pd_state">
                                    <option value="">=====无=====</option>
                                    <option value="-1" <?php if(($pdstate) == "0"): ?>selected<?php endif; ?>>订单取消</option>
                                    <option value="0" <?php if(($pdstate) == "0"): ?>selected<?php endif; ?>>下单--->待付款</option>
                                    <option value="1" <?php if(($pdstate) == "1"): ?>selected<?php endif; ?>>付款--->待发货</option>
                                    <option value="2" <?php if(($pdstate) == "2"): ?>selected<?php endif; ?>>发货--->待收货</option>
                                    <option value="3" <?php if(($pdstate) == "3"): ?>selected<?php endif; ?>>----已收货---</option>
                                    <option value="4" <?php if(($pdstate) == "4"): ?>selected<?php endif; ?>>----已评论---</option>
                                </select>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td><label for="pd_type">支付状态：</label></td>
                            <td>
                                <select  id="pd_type"  name="pd_type">
                                    <option value="" <?php if(($pdtype) == "0"): ?>selected<?php endif; ?>>=====无=====</option>
                                    <option value="0" <?php if(($pdtype) == "1"): ?>selected<?php endif; ?>>未支付</option>
                                    <option value="1" <?php if(($pdtype) == "1"): ?>selected<?php endif; ?>>线上支付</option>
                                    <option value="2" <?php if(($pdtype) == "2"): ?>selected<?php endif; ?>>线下支付</option>
                                </select>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td><label>支付时间：</label></td>
                            <td>
                                开始时间：<input  type="text" class="Wdate" onFocus="WdatePicker({lang:'zh-cn'})"  name="pd_paytime1" value="<?php echo ($pdpaytime1); ?>"/>
                                结束时间：<input  type="text" class="Wdate" onFocus="WdatePicker({lang:'zh-cn'})"  name="pd_paytime2" value="<?php echo ($pdpaytime2); ?>"/>
                            </td>
                        </tr>
                    </table>
                    <div class="layerBtns">
                        <button class="btn" type="submit">提交</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="search-form-div2">
            <form action="<?php echo U('status_modify');?>" method="post" class="js-ajax-form" >
                <div class="layerCon bg_f">
                    <table class="layerTable" border="0">
                        <input type="hidden" name="pd_id" id="pdidtxt" value="">
                        <tr class="h50">
                            <td><label>订单状态：</label></td>
                            <td>
                                <select  name="pd_state" class="pdstatetxt" onchange="kdstate(this)" >
                                    <option value="-1">订单取消</option>
                                    <option value="0">下单--->待付款</option>
                                    <option value="1">付款--->待发货</option>
                                    <option value="2">发货--->待收货</option>
                                </select>
                            </td>
                        </tr>
                        <tr class="h50 kd" style="display: none">
                            <td>快递名称：</td>
                            <td><input type="text" name="pd_kuaidname" class="kuaidival" value=""></td>
                        </tr>
                        <tr class="h50 kd" style="display: none">
                            <td>快递单号：</td>
                            <td><input type="text" name="pd_kuaidinumber" class="kuaidival" value=""></td>
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
    <form action="" method="post" class="js-ajax-form" id="js-ajax-form">
        <table class="table" border="0">
            <thead>
            <tr class="noSelect">
                <th class="tc" width="35px">
                    <input class="va_m" type="checkbox" name="" id="allCheck" value="" data-falg="allCheck" onclick="checkBoxOp(this)"/>
                </th>
                <th width="40">ID</th>
                <th>订单地址</th>
                <th>订单唯一编号</th>
                <th>订单状态</th>
                <th>状态改变时间</th>
                <th>商家</th>
                <th>总金额</th>
                <th>用户昵称</th>
                <th>下单时间</th>
                <th>支付状态</th>
                <th>支付时间</th>
                <th>收货人电话</th>
                <th>收货人姓名</th>
                <th>收货人地址</th>
                <th>是否删除</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($productorder_info)): $i = 0; $__LIST__ = $productorder_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$info): $mod = ($i % 2 );++$i;?><tr>
                    <td>
                        <input class="va_m" type="checkbox" name="ids[]" value="<?php echo ($info["pd_id"]); ?>" onclick="checkBoxOp(this)" />
                    </td>
                    <td><?php echo ($info["pd_id"]); ?></td>
                    <td><?php echo ($info["pd_province"]); echo ($info["pd_city"]); echo ($info["pd_county"]); ?></td>
                    <td><?php echo ($info["pd_onlyid"]); ?></td>
                    <td>
                        <?php if(($info["pd_state"]) == "-1"): ?>取消订单<?php endif; ?>
                        <?php if(($info["pd_state"]) == "0"): ?>下单--->待付款<?php endif; ?>
                        <?php if(($info["pd_state"]) == "1"): ?>付款--->待发货<?php endif; ?>
                        <?php if(($info["pd_state"]) == "2"): ?>发货--->待收货<?php endif; ?>
                        <?php if(($info["pd_state"]) == "3"): ?>已收货<?php endif; ?>
                        <?php if(($info["pd_state"]) == "4"): ?>已评论<?php endif; ?>
                        <?php if($info["pd_state"] == 10||$info["pd_state"] == 11||$info["pd_state"] == 15||$info["pd_state"] == 20||$info["pd_state"] == 21||$info["pd_state"] == 22||$info["pd_state"] == 25 ): ?>退换货处理中<?php endif; ?>
                        <?php if($info["pd_state"] == 12||$info["pd_state"] == 23): ?>退换货已完成<?php endif; ?>
                    </td>
                    <td><?php echo (date('Y-m-d H:i',strtotime($info["pd_changechangetime"]))); ?></td>
                    <td><?php echo ($info["fuid_name"]); ?></td>
                    <td><?php echo (number_format($info["pd_money"],2)); ?></td>
                    <td><?php echo ($info["uid_name"]); ?></td>
                    <td><?php echo (date('Y-m-d H:i',strtotime($info["pd_time"]))); ?></td>
                    <td><?php if(($info["pd_type"]) == "0"): ?>未支付<?php endif; ?>
                        <?php if(($info["pd_type"]) == "1"): ?>线上支付<?php endif; ?>
                        <?php if(($info["pd_type"]) == "2"): ?>线下支付<?php endif; ?></td>
                    <td><?php if(($info["pd_type"]) == "0"): ?>暂未支付<?php else: echo (date('Y-m-d H:i',strtotime($info["pd_paytime"]))); endif; ?></td>
                    <td><?php echo ($info["pd_phone"]); ?></td>
                    <td><?php echo ($info["pd_consigneename"]); ?></td>
                    <td><?php echo ($info["pd_province"]); echo ($info["pd_city"]); echo ($info["pd_county"]); echo ($info["pd_address"]); ?></td>
                    <td><?php if(($info["pd_del"]) == "0"): ?>是<?php endif; ?>
                        <?php if(($info["pd_del"]) == "1"): ?>否<?php endif; ?>
                    </td>
                    <td>
                        <a class="table_btn" title="详细"
                           onclick="layerPage('订单详情','<?php echo U('detail',array('pd_id'=>$info['pd_id']));?>','970px','475px')"><img
                                src="/Public/img/edit.png" alt="详细" title="详细"></a>
                    </td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
    </form>
</div>
<div class="pageCon">
    <?php echo ($page_bar); ?>       每页 20 条，共 <?php echo ($count); ?> 条
</div>

<script>
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

    function  kdstate(obj) {
            var a = $(obj).val();
           if(a==2){
               $(".kd").show();
           }else{
               $(".kuaidival").val("");
               $(".kd").hide();
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
//            console.log(ids);
        if (ids == "") {
            layer.msg('请选择要修改的数据!', { icon: 1, time: 1000 });
            return;
        }else{
            layer.closeAll('dialog');
            $('#pdidtxt').val(ids);
            layerDiv('批量修改',$('.search-form-div2').html(),'500px','260px');
            var pdid =  $('.search-form-div2 #pdidtxt').val(ids);
        }
    }


</script>
</body>
</html>