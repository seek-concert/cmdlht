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
<h4>师傅列表</h4>
<div class="toolsBar">
    <!--fgf为工具栏分隔符，刷新没有，离开都有。中间工具每一类第一个添加fgf-->
    <ul>
        <li onclick="reloadPage(window)">
            <img src="/Public/img/arrow_refresh.png"/>
            重置
        </li>
        <li class="fgf" onclick="layerDiv('查询',$('#search-form-div').html(),'500px','270px')">
            <img src="/Public/img/page_white_magnify.png"/>
            查询
        </li>
        <li class="fgf" onclick="layerPage('注册师傅折线统计图','<?php echo U('statistics');?>','750px','520px')">
            <img src="/Public/img/chart_bar.png"/>
            统计
        </li>
    </ul>
</div>
<div class="tableCon">
    <div style="visibility: hidden;display: none;">
        <div id="search-form-div">
            <form action="/Construction/index_list" method="post" id="search-form" class="layui-form">
                <div class="layerCon bg_f">
                    <table class="layerTable" border="0">
                        <tr class="h50">
                            <td><label for="u_loginname"> 登陆账号：</label></td>
                            <td>
                                <input id="u_loginname" type="text" name="u_loginname" value="<?php echo ($uloginname); ?>" placeholder="请输入登陆账号"/>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td><label for="u_realname">真实姓名：</label></td>
                            <td>
                                <input id="u_realname" type="text" name="u_realname" value="<?php echo ($u_realname); ?>" placeholder="请输入真实姓名"/>
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
                <th width="40">ID</th>
                <th>唯一编号</th>
                <th>登陆账号</th>
                <th>电话</th>
                <th>真实姓名</th>
                <th>昵称</th>
                <th>注册时间</th>
                <th>账号状态</th>
                <th>用户等级</th>
                <th>余额</th>
                <th>师傅类型</th>
                <th>是否正在维修</th>
                <th>接单记录</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($userinfo_info)): $k = 0; $__LIST__ = $userinfo_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$info): $mod = ($k % 2 );++$k;?><tr>
                    <td><?php echo ($info["u_id"]); ?></td>
                    <td><?php echo ($info["u_number"]); ?></td>
                    <td><?php echo ($info["u_loginname"]); ?></td>
                    <td><?php echo ($info["u_phone"]); ?></td>
                    <td><?php if(empty($info["u_realname"])): ?>暂未填写<?php else: echo ($info["u_realname"]); endif; ?></td>
                    <td><?php echo ($info["u_nickname"]); ?></td>
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
                    <td><?php if(($info["u_appoint"]) == "1"): ?>团体<?php else: ?>个人<?php endif; ?></td>
                    <td><?php if(($info["u_shanggong"]) == "1"): ?><a data-action="<?php echo U('modify_shanggong');?>"
                           data-msg="您确定要更改状态吗？" title="是" class="table_btn button1 js-ajax-form-btn"
                           data-formdata="uid=<?php echo ($info['u_id']); ?>&ushanggong=<?php echo ($info['u_shanggong']); ?>">是</a>
                        <?php else: ?>
                            <a data-action="<?php echo U('modify_shanggong');?>"
                               data-msg="您确定要更改状态吗？" title="否" class="table_btn button1 js-ajax-form-btn"
                               data-formdata="uid=<?php echo ($info['u_id']); ?>&ushanggong=<?php echo ($info['u_shanggong']); ?>">否</a><?php endif; ?>
                    </td>
                    <td><a class="table_btn button1" style="background-color: #00a0e9 !important;" title="详细" onclick="layerPage('接单记录','<?php echo U('jiedan_detail',array('uid'=>$info['u_id']));?>','700px','580px',true)">查看记录</a></td>
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
</script>
<input type="hidden" id="hid_ids"  />
</body>
</html>