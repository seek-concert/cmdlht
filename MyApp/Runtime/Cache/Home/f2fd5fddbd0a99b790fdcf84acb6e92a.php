<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>订单物流列表</title>
    <link rel="stylesheet" type="text/css" href="/Public/css/style.css"/>
    <script src="/Public/js/jquery2-1-4.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/layer/layer.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/htglxt.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/iframe.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/ajax-submit.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/My97DatePicker/WdatePicker.js"></script>
</head>
<body>
<h4>订单物流列表</h4>
<div class="toolsBar">
    <!--fgf为工具栏分隔符，刷新没有，离开都有。中间工具每一类第一个添加fgf-->
    <ul>
        <li onclick="reloadPage(window)">
            <img src="/Public/img/arrow_refresh.png"/>
            重置
        </li>
        <li class="fgf" onclick="layerDiv('查询',$('#search-form-div').html(),'500px','220px')">
            <img src="/Public/img/page_white_magnify.png"/>
            查询
        </li>
    </ul>
</div>
<div class="tableCon">
    <div style="visibility: hidden;display: none;">
        <div id="search-form-div">
            <form action="/Dingyueliucheng/index_list" method="post" id="search-form" class="layui-form">
                <div class="layerCon bg_f">
                    <table class="layerTable" border="0">
                        <tr class="h50">
                            <td><label for="lc_pid">订单ID：</label></td>
                            <td>
                                <input id="lc_pid" type="text" name="lc_pid" value="<?php echo ($lc_pid); ?>" placeholder="请输入订单ID"/>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td><label>发货时间：</label></td>
                            <td>
                                开始时间：<input type="text" class="Wdate" onFocus="WdatePicker({lang:'zh-cn'})"
                                            name="pd_time1" value="<?php echo ($pd_time1); ?>"/>
                                结束时间：<input type="text" class="Wdate" onFocus="WdatePicker({lang:'zh-cn'})"
                                            name="pd_time2" value="<?php echo ($pd_time2); ?>"/>
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
                <th>订单ID</th>
                <th>订单编号</th>
                <th>内容</th>
                <th>发货时间</th>
                <th>快递变动时间</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($dingyueliucheng_info)): $i = 0; $__LIST__ = $dingyueliucheng_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$info): $mod = ($i % 2 );++$i;?><tr   class="h25">
                    <td>
                        <input class="va_m" type="checkbox" name="ids[]" value="<?php echo ($info["lc_id"]); ?>"
                               onclick="checkBoxOp(this)"/>
                    </td>
                    <td><?php echo ($info["lc_id"]); ?></td>
                    <td><?php echo ($info["lc_pid"]); ?></td>
                    <td><?php echo ($info["pdonlyid"]); ?></td>
                    <td><?php echo ($info["lc_content"]); ?></td>
                    <td><?php echo (date('Y-m-d H:i',strtotime($info["lc_time"]))); ?></td>
                    <td><?php echo (date('Y-m-d H:i',strtotime($info["lc_ftime"]))); ?></td>

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
</body>
</html>