<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>系统通知列表</title>
    <link rel="stylesheet" type="text/css" href="/Public/css/style.css"/>
    <script src="/Public/js/jquery2-1-4.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/layer/layer.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/htglxt.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/iframe.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/ajax-submit.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/My97DatePicker/WdatePicker.js"></script>
</head>
<body>
<h4>系统通知发送详情列表</h4>
<div class="toolsBar">
    <!--fgf为工具栏分隔符，刷新没有，离开都有。中间工具每一类第一个添加fgf-->
    <ul>
        <li onclick="reloadPage(window)">
            <img src="/Public/img/arrow_refresh.png"/>
            重置
        </li>
        <li class="fgf" onclick="layerDiv('查询',$('#search-form-div').html(),'500px','300px')">
            <img src="/Public/img/page_white_magnify.png"/>
            查询
        </li>
    </ul>
</div>
<div class="tableCon">
    <div style="visibility: hidden;display: none;">
        <div id="search-form-div">
            <form action="/Notice/index_list" method="post" id="search-form" class="layui-form">
                <div class="layerCon bg_f">
                    <table class="layerTable" border="0">
                        <tr class="h50">
                            <td><label for="uid_name">用户名称：</label></td>
                            <td>
                                <input id="uid_name" type="text" name="uid_name" value="<?php echo ($uid_name); ?>" placeholder="请输入用户名称"/>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td><label for="n_time">添加时间：</label></td>
                            <td>
                                开始时间：<input id="n_time" type="text" class="Wdate" onFocus="WdatePicker({lang:'zh-cn'})"
                                            name="n_time1" value="<?php echo ($n_time1); ?>"/>
                                结束时间：<input id="n_time1" type="text" class="Wdate" onFocus="WdatePicker({lang:'zh-cn'})"
                                            name="n_time2" value="<?php echo ($n_time2); ?>"/>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td><label for="n_title">标题：</label></td>
                            <td>
                                <input id="n_title" type="text" name="n_title" value="<?php echo ($n_title); ?>" placeholder="请输入标题"/>
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
        <textarea cols="50" rows="10" class="content1" style="width: 100%;height: 100%;" disabled></textarea>
    </div>
    <em class="xian"></em>
    <form action="/Notice/index_list" method="post" class="js-ajax-form" id="js-ajax-form">
        <table class="table" border="0">
            <thead>
            <tr class="noSelect">
                <th class="tc" width="35px">
                    <input class="va_m" type="checkbox" name="" id="allCheck" value="" data-falg="allCheck" onclick="checkBoxOp(this)"/>
                </th>
                <th width="40">ID</th>
                <th>用户</th>
                <th>添加时间</th>
                <th>标题</th>
                <th>内容</th>
                <th>是否查看</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($notice_info)): $i = 0; $__LIST__ = $notice_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$info): $mod = ($i % 2 );++$i;?><tr>
                    <td>
                        <input class="va_m" type="checkbox" name="ids[]" value="<?php echo ($info["n_id"]); ?>" onclick="checkBoxOp(this)" />
                    </td>
                    <td><?php echo ($info["n_id"]); ?></td>
                    <td><?php echo ($info["uid_name"]); ?></td>
                    <td><?php echo (date('Y-m-d H:i',strtotime($info["n_time"]))); ?></td>
                    <td><?php echo ($info["n_title"]); ?></td>
                    <td><input type="hidden" class="ncontent" value="<?php echo ($info["n_content"]); ?>"><input type="button" value="点击查看" onclick="test1(this)"></td>
                    <td><?php if(($info["n_state"]) == "1"): ?>已查看<?php endif; if(($info["n_state"]) == "0"): ?>未查看<?php endif; ?></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
    </form>
</div>
<div class="pageCon">
    <?php echo ($page_bar); ?>       每页 20 条，共 <?php echo ($count); ?> 条
</div>

<script>
    /*弹出备注说明*/
    function test1(obj) {
        $(".search-form-div1"). find(".content1").html(" ");
        var cfcontent = $(obj).parent("td").find(".ncontent").val();
        $(".search-form-div1"). find(".content1").html(cfcontent);
        layerDiv('通知内容',$('.search-form-div1').html(),'500px','300px');
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