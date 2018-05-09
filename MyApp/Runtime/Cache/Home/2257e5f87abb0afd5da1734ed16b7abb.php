<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>订单评价</title>
    <link rel="stylesheet" type="text/css" href="/Public/css/style.css"/>
    <script src="/Public/js/jquery2-1-4.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/layer/layer.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/htglxt.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/iframe.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/ajax-submit.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/My97DatePicker/WdatePicker.js"></script>
</head>
<body>
<h4>订单评价列表</h4>
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
        <li class="fgf js-ajax-form-btn" data-form="js-ajax-form"
            data-action="<?php echo U('status_modify',array('action'=>'on'));?>">
            <img src="/Public/img/enable.png"/>
            批量显示
        </li>
        <li class="fgf js-ajax-form-btn" data-form="js-ajax-form"
            data-action="<?php echo U('status_modify',array('action'=>'off'));?>">
            <img src="/Public/img/unable.png"/>
            批量隐藏
    </ul>
</div>
<div class="tableCon">
    <div style="visibility: hidden;display: none;">
        <div id="search-form-div">
            <form action="/Productevaluation/index_list" method="post" id="search-form" class="layui-form">
                <div class="layerCon bg_f">
                    <table class="layerTable" border="0">
                        <tr class="h50">
                            <td><label for="pe_pdid">订单ID：</label></td>
                            <td>
                                <input id="pe_pdid" type="text" name="pe_pdid" value="<?php echo ($pepdid); ?>" placeholder="请输入订单ID"/>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td><label for="uid_name">用户昵称：</label></td>
                            <td>
                                <input id="uid_name" type="text" name="uid_name" value="<?php echo ($uid_name); ?>" placeholder="请输入用户昵称"/>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td><label for="pe_time">评价时间：</label></td>
                            <td>
                                开始时间： <input id="pe_time" type="text" class="Wdate"
                                             onFocus="WdatePicker({lang:'zh-cn'})" name="pe_time1" value="<?php echo ($petime1); ?>"/>
                                结束时间： <input id="pe_time1" type="text" class="Wdate"
                                             onFocus="WdatePicker({lang:'zh-cn'})" name="pe_time2" value="<?php echo ($petime2); ?>"/>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td><label for="pe_ctime">追评时间：</label></td>
                            <td>
                                开始时间： <input id="pe_ctime" type="text" class="Wdate"
                                             onFocus="WdatePicker({lang:'zh-cn'})" name="pe_ctime1" value="<?php echo ($pectime1); ?>"/>
                                结束时间： <input id="pe_ctime1" type="text" class="Wdate"
                                             onFocus="WdatePicker({lang:'zh-cn'})" name="pe_ctime2" value="<?php echo ($pectime2); ?>"/>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td><label for="pe_odid">订单详情ID：</label></td>
                            <td>
                                <input id="pe_odid" type="text" name="pe_odid" value="<?php echo ($peodid); ?>" placeholder="请输入订单详情ID"/>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td><label for="pe_state">是否显示：</label></td>
                            <td>
                                <select name="pe_state" id="pe_state">
                                    <option value="">---无---</option>
                                    <option value="1" <?php if(($pestate) == "1"): ?>selected<?php endif; ?>>---显示---</option>
                                    <option value="0" <?php if(($pestate) == "0"): ?>selected<?php endif; ?>>---隐藏---</option>
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
    </div>
    <em class="xian"></em>
    <form action="<?php echo U('sort');?>" method="post" class="js-ajax-form" id="js-ajax-form">
        <table class="table" border="0">
            <thead>
            <tr class="noSelect">
                <th class="tc" width="35px">
                    <input class="va_m" type="checkbox" name="" id="allCheck" value="" data-falg="allCheck"
                           onclick="checkBoxOp(this)"/>
                </th>
                <th width="40">ID</th>
                <th>订单ID</th>
                <th>评价用户</th>
                <th>商品评分</th>
                <th>评价时间</th>
                <th>回复时间</th>
                <th>匿名评价</th>
                <th>是否显示</th>
                <th>追评时间</th>
                <th>回复追评时间</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($productevaluation_info)): $i = 0; $__LIST__ = $productevaluation_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$info): $mod = ($i % 2 );++$i;?><tr>
                    <td>
                        <input class="va_m" type="checkbox" name="ids[]" value="<?php echo ($info["pe_id"]); ?>"
                               onclick="checkBoxOp(this)"/>
                    </td>
                    <td><?php echo ($info["pe_id"]); ?></td>
                    <td><?php echo ($info["pe_pdid"]); ?></td>
                    <td><?php if(empty($info["uid_name"])): ?>账号无昵称或账号已被删除，用户ID【<?php echo ($info["pe_uid"]); ?>】<?php endif; echo ($info["uid_name"]); ?></td>
                    <td>
                        <?php if(($info["pe_score"]) == "1"): ?>差评<?php endif; ?>
                        <?php if(($info["pe_score"]) == "2"): ?>中评<?php endif; ?>
                        <?php if(($info["pe_score"]) == "3"): ?>中评<?php endif; ?>
                        <?php if(($info["pe_score"]) == "4"): ?>好评<?php endif; ?>
                        <?php if(($info["pe_score"]) == "5"): ?>好评<?php endif; ?>
                    </td>
                    <td><?php echo (date('Y-m-d H:i',strtotime($info["pe_time"]))); ?></td>
                    <td><?php if(($info["pe_systemtime"]) == "2017-01-01 00:00:00.000"): ?>暂无<?php else: if(empty($info["pe_systemcontent"])): ?>暂无<?php else: echo (date('Y-m-d H:i',strtotime($info["pe_systemtime"]))); endif; endif; ?></td>
                    <td>
                        <?php if(($info["pe_state"]) == "1"): ?>是<?php endif; ?>
                        <?php if(($info["pe_state"]) == "0"): ?>否<?php endif; ?>
                    </td>
                    <td>
                        <?php if(($info["pe_state"]) == "1"): ?>显示<?php endif; ?>
                        <?php if(($info["pe_state"]) == "0"): ?>隐藏<?php endif; ?>
                    </td>
                    <td><?php if(($info["pe_ctime"]) == "2017-01-01 00:00:00.000"): ?>暂无<?php else: if(empty($info["pe_chaseratings"])): ?>暂无<?php else: echo (date('Y-m-d H:i',strtotime($info["pe_ctime"]))); endif; endif; ?></td>
                    <td><?php if(($info["pe_csystemtime"]) == "2017-01-01 00:00:00.000"): ?>暂无<?php else: if(empty($info["pe_chaseratings"])): ?>暂无<?php else: echo (date('Y-m-d H:i',strtotime($info["pe_csystemtime"]))); endif; endif; ?></td>
                    <td>
                        <a class="table_btn" title="详细"
                           onclick="layerPage('订单评价信息','<?php echo U('detail',array('pe_id'=>$info['pe_id']));?>','720px','500px')"><img
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