<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title></title>
    <link rel="stylesheet" type="text/css" href="/Public/css/style.css"/>
    <script src="/Public/js/jquery2-1-4.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/layer/layer.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/htglxt.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/iframe.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/ajax-submit.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/My97DatePicker/WdatePicker.js"></script>
</head>
<body>
<h4>用户列表</h4>
<div class="toolsBar">
    <!--fgf为工具栏分隔符，刷新没有，离开都有。中间工具每一类第一个添加fgf-->
    <ul>
        <li onclick="reloadPage(window)">
            <img src="/Public/img/arrow_refresh.png"/>
            重置
        </li>
        <li class="fgf" onclick="layerDiv('查询',$('#search-form-div').html(),'500px','340px')">
            <img src="/Public/img/page_white_magnify.png"/>
            查询
        </li>
        <li class="fgf" onclick="layerPage('注册用户折线统计图','<?php echo U('statistics');?>','750px','520px')">
            <img src="/Public/img/chart_bar.png"/>
            统计
        </li>
        <li class="fgf js-ajax-form-btn" data-form="js-ajax-form"
            data-action="<?php echo U('status_modify',array('action'=>'on'));?>">
            <img src="/Public/img/enable.png"/>
            批量启用
        </li>
        <li class="fgf js-ajax-form-btn" data-form="js-ajax-form"
            data-action="<?php echo U('status_modify',array('action'=>'off'));?>">
            <img src="/Public/img/unable.png"/>
            批量停用
        </li>
        <!--<li class="fgf" onclick="layerPage('添加用户','<?php echo U('insert');?>','750px','440px')">-->
            <!--<img src="/Public/img/add.png"/>-->
            <!--添加用户-->
        <!--</li>-->
        <li class="fgf" onclick="insertNotice(&#39;all&#39;)">
            <img src="/Public/img/email_at_sign.png"/>
            发送系统通知
        </li>
    </ul>
</div>
<div class="tableCon">
    <div style="visibility: hidden;display: none;">
        <div id="search-form-div">
            <form action="/Userinfo/index_list" method="post" id="search-form" class="layui-form">
                <div class="layerCon bg_f">
                    <table class="layerTable" border="0">
                        <tr class="h50">
                            <td><label for="u_loginname"> 登陆账号：</label></td>
                            <td>
                                <input id="u_loginname" type="text" name="u_loginname" value="<?php echo ($uloginname); ?>" placeholder="请输入登陆账号"/>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td><label for="u_nickname">昵称：</label></td>
                            <td>
                                <input id="u_nickname" type="text" name="u_nickname" value="<?php echo ($unickname); ?>" placeholder="请输入昵称"/>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td><label>注册时间：</label></td>
                            <td>
                                开始时间：<input type="text" class="Wdate" onFocus="WdatePicker({lang:'zh-cn'})"
                                            name="u_time1" value="<?php echo ($utime1); ?>"/>
                                结束时间：<input type="text" class="Wdate" onFocus="WdatePicker({lang:'zh-cn'})"
                                            name="u_time2" value="<?php echo ($utime2); ?>"/>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td><label for="u_state">账号状态：</label></td>
                            <td>
                                <select id="u_state" name="u_state">
                                    <option value="">=====无=====</option>
                                    <option value="0" <?php if(($ustate) == "0"): ?>selected<?php endif; ?>>停用</option>
                                    <option value="1" <?php if(($ustate) == "1"): ?>selected<?php endif; ?>>启用</option>
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
    <em class="xian"></em>
    <form action="" method="post" class="js-ajax-form" id="js-ajax-form">
        <table class="table" border="0">
            <thead>
            <tr class="noSelect">
                <th class="tc" width="35px">
                    <input class="va_m" type="checkbox" name="" id="allCheck" value="" data-falg="allCheck"
                           onclick="checkBoxOp(this)"/>
                </th>
                <th width="40">ID</th>
                <th>地区</th>
                <th>唯一编号</th>
                <th>账号类型</th>
                <th>账号登陆</th>
                <th>昵称</th>
                <th>电话</th>
                <th>注册时间</th>
                <th>账号状态</th>
                <th>用户等级</th>
                <th>余额</th>
                <th>查看下级</th>
                <th>下级总人数</th>
                <!--<th>操作</th>-->
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($userinfo_info)): $i = 0; $__LIST__ = $userinfo_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$info): $mod = ($i % 2 );++$i;?><tr>
                    <td>
                        <input class="va_m" type="checkbox" name="ids[]" value="<?php echo ($info["u_id"]); ?>"
                               onclick="checkBoxOp(this)"/>
                    </td>
                    <td><?php echo ($info["u_id"]); ?></td>
                    <td><?php echo ($info["u_sheng"]); echo ($info["u_shi"]); echo ($info["u_xian"]); ?></td>
                    <td><?php echo ($info["u_number"]); ?></td>
                    <td>
                        <?php if(($info["u_type"]) == "1"): ?>用户<?php endif; ?>
                        <?php if(($info["u_type"]) == "2"): ?>师傅<?php endif; ?>
                        <?php if(($info["u_type"]) == "3"): ?>商家<?php endif; ?>
                        <?php if(($info["u_type"]) == "4"): ?>评估人员<?php endif; ?>
                    </td>
                    <td><?php if(empty($info["u_loginname"])): ?>暂无<?php else: echo ($info["u_loginname"]); endif; ?></td>
                    <td><?php echo ($info["u_nickname"]); ?></td>
                    <td><?php if(empty($info["u_loginname"])): ?>暂未填写<?php else: echo ($info["u_loginname"]); endif; ?></td>
                    <td><?php echo (date('Y-m-d H:i',strtotime($info["u_time"]))); ?></td>
                    <td>
                        <?php if(($info["u_state"]) == "1"): ?><a data-action="<?php echo U('modify_state');?>"
                               data-msg="您确定要更改状态吗？" title="启用" class="table_btn button1 js-ajax-form-btn"
                               data-formdata="uid=<?php echo ($info['u_id']); ?>&ustate=<?php echo ($info['u_state']); ?>">启用</a>
                            <?php else: ?>
                            <a data-action="<?php echo U('modify_state');?>"
                               data-msg="您确定要更改状态吗？" title="停用" class="table_btn button1 js-ajax-form-btn"
                               data-formdata="uid=<?php echo ($info['u_id']); ?>&ustate=<?php echo ($info['u_state']); ?>">停用</a><?php endif; ?>
                    </td>
                    <td><?php echo ($info["u_level"]); ?></td>
                    <td><?php echo (number_format($info["u_money"],2)); ?></td>
                    <td><a class="table_btn button1" style="background-color: #00a0e9 !important;" title="详细" onclick="layerPage('下级用户','<?php echo U('xiaji_detail',array('uid'=>$info['u_id'],'lv'=>3));?>','700px','580px',true)">查看下级</a></td>
                    <td style="text-align: center;"><a class="table_btn button1"  title="详细" onclick="layerPage('下级数量查询','<?php echo U('next_count',array('uid'=>$info['u_id']));?>','370px','260px')">
                        <?php $rs = M()->query("WITH cte_ct(u_id,u_superior,lv)as(select u_id, u_superior,0 as lv from userinfo
                            where u_id = ".$info['u_id']." union all select b.u_id,b.u_superior,t.lv + 1 as lv from userinfo
                            b join cte_ct t on b.u_superior = t.u_id where lv<3)select count(*) as next_count from (select u_id, lv, row_number()
                            over(order by cte_ct.u_id) as rid  from cte_ct)a,userinfo b where a.u_id = b.u_id and b.u_id!=".$info['u_id']); echo $rs[0]["next_count"]; ?>人</a>
                    </td>
                    <!--<td>-->
                        <!--<a class="table_btn" title="详细"-->
                           <!--onclick="layerPage('用户信息详情','<?php echo U('detail',array('u_id'=>$info['u_id']));?>','700px','470px')"><img-->
                                <!--src="/Public/img/edit.png" alt="详细" title="详细"></a>-->
                    <!--</td>-->
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
    </form>
</div>
<div class="pageCon">
    <?php echo ($page_bar); ?>       每页 20 条，共 <?php echo ($count); ?> 条   每页 20 条，共 <?php echo ($count); ?> 条
</div>

<script>
    $(function () {
        $('.pageCon').find('a').on('click', function () {
            $('#search-form').attr('action', $(this).attr('href')).submit();
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
                var checkedlist = $("input[name=\"ids[]\"]:checked");
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
       // function  ajaxinsert(n_title,n_content) {
       //     var data = {
       //         'n_uid':$("#hid_ids").val(),
       //         'n_title':n_title,
       //         'n_content':n_content
       //     };
       //     var index = layer.load({ shade: [0.5, '#fff'] });
       //     $.ajax({
       //         type: "post",
       //         url: "<?php echo U('notice/insert');?>",
       //         data: data,
       //         dataType: "json",
       //         success: function (e) {
       //             layer.close(index);
       //             if (e.status == 1) {
       //                 layer.msg(e.info);
       //                 window.location="<?php echo U('userinfo/index_list');?>";
       //             }
       //             if(e.status == 0){
       //                 layer.msg(e.info);
       //             }
       //         },
       //         error: function () {
       //             layer.close(index);
       //             layer.alert('操作失败！');
       //         }
       //     });
       // }

</script>
<input type="hidden" id="hid_ids"  />
</body>
</html>