<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>用户审核管理</title>
    <link rel="stylesheet" type="text/css" href="/Public/css/style.css"/>
    <script src="/Public/js/jquery2-1-4.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/layer/layer.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/htglxt.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/iframe.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/ajax-submit.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/My97DatePicker/WdatePicker.js"></script>
</head>
<body>
<h4>用户审核管理</h4>
<div class="toolsBar">
    <!--fgf为工具栏分隔符，刷新没有，离开都有。中间工具每一类第一个添加fgf-->
    <ul>
        <li onclick="reloadPage(window)">
            <img src="/Public/img/arrow_refresh.png"/>
            重置
        </li>
        <li class="fgf" onclick="layerDiv('查询',$('#search-form-div').html(),'500px','410px')">
            <img src="/Public/img/page_white_magnify.png"/>
            查询
        </li>
        <li class="fgf" onclick="insertNotice(&#39;all&#39;)">
            <img src="/Public/img/email_at_sign.png"/>
            发送通知
        </li>
    </ul>
</div>
<div class="tableCon">
    <div style="visibility: hidden;display: none;">
        <div id="search-form-div">
            <form action="/Reviewedhistory/index_list" method="post" id="search-form" class="layui-form">
                <div class="layerCon bg_f">
                    <table class="layerTable" border="0">
                        <tr class="h50">
                            <td><label>申请操作时间：</label></td>
                            <td>
                                开始时间：<input  type="text" class="Wdate" onFocus="WdatePicker({lang:'zh-cn'})"  name="rh_time1" value="<?php echo ($rhtime1); ?>"/>
                                结束时间：<input  type="text" class="Wdate" onFocus="WdatePicker({lang:'zh-cn'})"  name="rh_time2" value="<?php echo ($rhtime2); ?>"/>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td><label for="th_state">操作状态：</label></td>
                            <td>
                                <select  id="th_state"  name="th_state">
                                    <option value="">=====无=====</option>
                                    <option value="1" <?php if(($thstate) == "1"): ?>selected<?php endif; ?>>=====申请=====</option>
                                    <option value="2" <?php if(($thstate) == "2"): ?>selected<?php endif; ?>>=====审核中=====</option>
                                    <option value="3" <?php if(($thstate) == "3"): ?>selected<?php endif; ?>>=====通过=====</option>
                                    <option value="4" <?php if(($thstate) == "4"): ?>selected<?php endif; ?>>=====拒绝=====</option>
                                </select>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td><label for="th_type">申请类型：</label></td>
                            <td>
                                <select  id="th_type"  name="th_type">
                                    <option value="">=====无=====</option>
                                    <option value="1" <?php if(($thtype) == "1"): ?>selected<?php endif; ?>>=====师傅=====</option>
                                    <option value="2" <?php if(($thtype) == "2"): ?>selected<?php endif; ?>>=====商家=====</option>
                                </select>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td><label for="uid_name">申请人：</label></td>
                            <td>
                                <input id="uid_name" type="text" name="uid_name" value="<?php echo ($uid_name); ?>" placeholder="请输入申请人"/>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td><label>系统操作时间：</label></td>
                            <td>
                                开始时间：<input  type="text" class="Wdate" onFocus="WdatePicker({lang:'zh-cn'})"  name="rh_systemtime1" value="<?php echo ($rhsystemtime1); ?>"/>
                                结束时间：<input  type="text" class="Wdate" onFocus="WdatePicker({lang:'zh-cn'})"  name="rh_systemtime2" value="<?php echo ($rhsystemtime2); ?>"/>
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
    <em class="xian"></em>
    <form action="" method="post" class="js-ajax-form" id="js-ajax-form">
        <table class="table" border="0">
            <thead>
            <tr class="noSelect">
                <th class="tc" width="35px">
                    <input class="va_m" type="checkbox" name="" id="allCheck" value="" data-falg="allCheck" />
                </th>
                <th width="40">ID</th>
                <th>申请人</th>
                <th>申请类型</th>
                <th>申请操作时间</th>
                <th>操作状态</th>
                <th>拒绝说明</th>
                <th>系统操作时间</th>
                <th>审核信息</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($reviewedhistory_info)): $i = 0; $__LIST__ = $reviewedhistory_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$info): $mod = ($i % 2 );++$i;?><tr>
                    <td>
                        <input class="va_m" type="checkbox" name="ids[]" value="<?php echo ($info["rh_ctrid"]); ?>"/>
                    </td>
                    <td><?php echo ($info["rh_ctrid"]); ?></td>
                    <td><input class="va_m" type="checkbox" name="idss[]" value="<?php echo ($info["th_uid"]); ?>" /><?php if(empty($info["uid_name"])): ?>账号无昵称或已被删除【ID:<?php echo ($info["th_uid"]); ?>】<?php endif; echo ($info["uid_name"]); ?></td>
                    <td><?php if(($info["th_type"]) == "1"): ?>商家<?php endif; ?>
                        <?php if(($info["th_type"]) == "2"): ?>师傅<?php endif; ?></td>
                    <td><?php echo (date('Y-m-d H:i',strtotime($info["rh_time"]))); ?></td>
                    <td><?php if(($info["th_state"]) == "1"): ?>申请<?php endif; ?>
                        <?php if(($info["th_state"]) == "2"): ?>审核中<?php endif; ?>
                        <?php if(($info["th_state"]) == "3"): ?>通过<?php endif; ?>
                        <?php if(($info["th_state"]) == "4"): ?>拒绝<?php endif; ?></td>
                    <td><?php echo ($info["th_content"]); if(empty($info["th_content"])): ?>暂无内容<?php endif; ?></td>
                    <td><?php if(($info["th_state"]) == "1"): ?>等待审核<?php else: if(($info["th_state"]) == "2"): ?>等待审核<?php else: echo (date('Y-m-d H:i',strtotime($info["rh_systemtime"]))); endif; endif; ?></td>
                    <td><a class="button1" onclick="layerPage('申请人信息','<?php echo U('detail',array('th_uid'=>$info['th_uid'],'rh_ctrid'=>$info['rh_ctrid'],'th_type'=>$info['th_type'],'thstate'=>$info['th_state']));?>','700px','500px')">查看信息</a></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
    </form>
</div>
<div class="pageCon">
    <?php echo ($page_bar); ?>       每页 20 条，共 <?php echo ($count); ?> 条
</div>

<script>
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
    function insertNotice(rs) {
        var ids = "";
        if (rs == "all") {
            var checkedlist = $("input[name=\"idss[]\"]:checked");
            for (var i = 0; i < checkedlist.length; i++) {
                ids += $(checkedlist[i]).val();
                if (i < checkedlist.length - 1) ids += ",";
            }
        } else {
            ids = rs;
        }
        if (ids == "") {
            layer.msg('请选择要发送的用户!', {icon: 1, time: 1000});
            return;
        }
        $("#hid_ids").val(ids);
        layerPage("发送系统通知","<?php echo U('Notice/inserts');?>",'700px','240px');
    }
    /*================ajax添加====================*/
    function  ajaxinsert(n_title,n_content) {
        var data = {
            'n_uid':$("#hid_ids").val(),
            'n_title':n_title,
            'n_content':n_content
        };
        console.log(data);
        var index = layer.load({ shade: [0.5, '#fff'] });
        $.ajax({
            type: "post",
            url: "<?php echo U('notice/insert');?>",
            data: data,
            dataType: "json",
            success: function (e) {
                layer.close(index);
                if (e.status == 1) {
                    layer.msg(e.info);
                    window.location="<?php echo U('reviewedhistory/index_list');?>";
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
    }

</script>
<input type="hidden" id="hid_ids"  />
</body>
</html>