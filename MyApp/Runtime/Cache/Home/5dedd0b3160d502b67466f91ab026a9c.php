<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>提现记录列表</title>
    <link rel="stylesheet" type="text/css" href="/Public/css/style.css"/>
    <script src="/Public/js/jquery2-1-4.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/layer/layer.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/htglxt.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/iframe.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/ajax-submit.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/My97DatePicker/WdatePicker.js"></script>
</head>
<body>
<h4>提现记录列表</h4>
<div class="toolsBar">
    <!--fgf为工具栏分隔符，刷新没有，离开都有。中间工具每一类第一个添加fgf-->
    <ul>
        <li onclick="reloadPage(window)">
            <img src="/Public/img/arrow_refresh.png"/>
            重置
        </li>
        <li class="fgf" onclick="layerDiv('查询',$('#search-form-div').html(),'520px','320px')">
            <img src="/Public/img/page_white_magnify.png"/>
            查询
        </li>
        <li class="fgf js-ajax-form-btn" data-form="js-ajax-form"
            data-action="<?php echo U('status_modify',array('action'=>'on'));?>">
            <img src="/Public/img/enable.png"/>
            批量通过
        </li>
        <li class="fgf js-ajax-form-btn" data-form="js-ajax-form"
            data-action="<?php echo U('status_modify',array('action'=>'off'));?>">
            <img src="/Public/img/unable.png"/>
            批量退回
        </li>
        <form action="<?php echo U('tixian/excel_order');?>" method="post">
            <input type="hidden" name="ids" id="ids1" value=""><li class="fgf" style="padding-bottom: 0">
            <button  type="submit"  style="border:none;background-color: inherit;" onclick="exceldaochu(&#39;all&#39;)">
                <img src="/Public/img/excel_exports.png"/>Excel导出</button></li>
        </form>
    </ul>
</div>
<div class="tableCon">
    <div style="visibility: hidden;display: none;">
        <div id="search-form-div">
            <form action="/Tixian/index_list" method="post" id="search-form" class="layui-form">
                <div class="layerCon bg_f">
                    <table class="layerTable" border="0">
                        <tr class="h50">
                            <td><label for="uid_name">用户：</label></td>
                            <td>
                                <input id="uid_name" type="text" name="uid_name" value="<?php echo ($uid_name); ?>" placeholder="请输入用户名称"/>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td><label for="ttype">用户类型：</label></td>
                            <td>
                                <select id="ttype" name="ttype" >
                                    <option value="">=====无=====</option>
                                    <option value="1" <?php if(($ttype) == "1"): ?>selected<?php endif; ?>>====用户====</option>
                                    <option value="2" <?php if(($ttype) == "2"): ?>selected<?php endif; ?>>====师傅====</option>
                                    <option value="3" <?php if(($ttype) == "3"): ?>selected<?php endif; ?>>====商家====</option>
                                </select>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td><label for="t_time">申请时间：</label></td>
                            <td>
                                开始时间：<input id="t_time" type="text" class="Wdate" onFocus="WdatePicker({lang:'zh-cn'})"
                                            name="t_time1" value="<?php echo ($t_time1); ?>"/>
                                结束时间：<input id="t_time1" type="text" class="Wdate" onFocus="WdatePicker({lang:'zh-cn'})"
                                            name="t_time2" value="<?php echo ($t_time2); ?>"/>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td><label for="t_state">提现状态：</label></td>
                            <td>
                                <select id="t_state" name="t_state" >
                                    <option value="">=====无=====</option>
                                    <option value="0" <?php if(($t_state) == "0"): ?>selected<?php endif; ?>>====申请====</option>
                                    <option value="1" <?php if(($t_state) == "1"): ?>selected<?php endif; ?>>====通过====</option>
                                    <option value="2" <?php if(($t_state) == "2"): ?>selected<?php endif; ?>>====退回====</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                    <div class="layerBtns">
                        <button class="btn" type="submit">提交</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="search-form-div1" style="display: none;">
        <textarea cols="50" rows="10" class="content1" style="width: 100%;height: 100%;padding: 2px 2px;"  disabled></textarea>
    </div>
    <em class="xian"></em>
    <form action="/Tixian/index_list" method="post" class="js-ajax-form" id="js-ajax-form">
        <table class="table" border="0">
            <thead>
            <tr class="noSelect">
                <th class="tc" width="35px">
                    <input class="va_m" type="checkbox" name="" id="allCheck" value="" data-falg="allCheck" onclick="checkBoxOp(this)"/>
                </th>
                <th width="40">ID</th>
                <th>用户昵称</th>
                <th>用户类型</th>
                <th>申请时间</th>
                <th>金额类型</th>
                <th>提现金额</th>
                <th>提现状态</th>
                <th>提现说明</th>
                <th>收款类型</th>
                <th>收款账号</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($tixian_info)): $i = 0; $__LIST__ = $tixian_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$info): $mod = ($i % 2 );++$i;?><tr>
                    <td>
                        <input class="va_m" type="checkbox" name="ids[]" value="<?php echo ($info["t_id"]); ?>" onclick="checkBoxOp(this)" />
                    </td>
                    <td><?php echo ($info["t_id"]); ?></td>
                    <td><?php if(empty($info["ttype"])): ?>账号已被删除<?php endif; echo ($info["uid_name"]); ?></td>
                    <td>
                        <?php if(($info["ttype"]) == "1"): ?>用户<?php endif; ?>
                        <?php if(($info["ttype"]) == "2"): ?>师傅<?php endif; ?>
                        <?php if(($info["ttype"]) == "3"): ?>商家<?php endif; ?></td>
                    <td><?php echo (date('Y-m-d H:i',strtotime($info["t_time"]))); ?></td>
                    <td><?php if(($info["t_moneytype"]) == "1"): ?>账户余额<?php endif; if(($info["t_moneytype"]) == "2"): ?>分销金额<?php endif; ?></td>
                    <td><?php echo (number_format($info["t_money"],2)); ?></td>
                    <td><?php if(($info["t_state"]) == "0"): ?>申请<?php endif; if(($info["t_state"]) == "1"): ?>通过<?php endif; if(($info["t_state"]) == "2"): ?>退回<?php endif; ?></td>
                    <td><input type="hidden" class="ncontent" value="&nbsp;<?php echo ($info["t_content"]); ?>"><input type="button" value="点击查看" onclick="test1(this)"></td>
                    <td><?php if(($info["t_type"]) == "0"): ?>没有账号<?php endif; if(($info["t_type"]) == "1"): ?>支付宝<?php endif; if(($info["t_type"]) == "2"): ?>微信<?php endif; ?></td>
                    <td><?php echo ($info["t_zhanghao"]); ?></td>
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

    /*弹出备注说明*/
    function test1(obj) {
        $(".search-form-div1"). find(".content1").html(" ");
        var cfcontent = $(obj).parent("td").find(".ncontent").val();
        $(".search-form-div1"). find(".content1").html(cfcontent);
        layerDiv('提现说明',$('.search-form-div1').html(),'500px','300px');
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