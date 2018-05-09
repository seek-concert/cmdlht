<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>案例管理</title>
    <link rel="stylesheet" type="text/css" href="/Public/css/style.css"/>
    <script src="/Public/js/jquery2-1-4.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/layer/layer.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/htglxt.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/iframe.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/ajax-submit.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/My97DatePicker/WdatePicker.js"></script>
</head>
<body>
<h4>案例列表</h4>
<div class="toolsBar">
    <!--fgf为工具栏分隔符，刷新没有，离开都有。中间工具每一类第一个添加fgf-->
    <ul>
        <li onclick="reloadPage(window)">
            <img src="/Public/img/arrow_refresh.png"/>
            重置
        </li>
        <li class="fgf" onclick="layerDiv('查询',$('#search-form-div').html(),'500px','280px')">
            <img src="/Public/img/page_white_magnify.png"/>
            查询
        </li>
        <li class="fgf" onclick="layerPage('添加案例','<?php echo U('insert');?>','700px','440px')">
            <img src="/Public/img/add.png"/>
            添加案例
        </li>
    </ul>
</div>
<div class="tableCon">
    <div style="visibility: hidden;display: none;">
        <div id="search-form-div">
            <form action="/Renovation/index_list" method="post" id="search-form" class="layui-form">
                <div class="layerCon bg_f">
                    <table class="layerTable" border="0">
                        <tr class="h50">
                            <td><label for="r_title">标题：</label></td>
                            <td>
                                <input id="r_title" type="text" name="r_title" value="<?php echo ($rtitle); ?>" placeholder="请输入标题"/>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td><label for="r_time">添加时间：</label></td>
                            <td>
                               开始时间：<input id="r_time" type="text" class="Wdate" onFocus="WdatePicker({lang:'zh-cn'})"  name="r_time1" value="<?php echo ($rtime1); ?>"/>
                               结束时间：<input id="r_time1" type="text" class="Wdate" onFocus="WdatePicker({lang:'zh-cn'})"  name="r_time2" value="<?php echo ($rtime2); ?>"/>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td><label for="r_estate">楼盘：</label></td>
                            <td>
                                <input id="r_estate" type="text" name="r_estate" value="<?php echo ($restate); ?>" placeholder="请输入楼盘"/>
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
    <form action="/Renovation/index_list" method="post" class="js-ajax-form" id="js-ajax-form">
        <table class="table" border="0">
            <thead>
            <tr class="noSelect">
                <th class="tc" width="35px">
                    <input class="va_m" type="checkbox" name="" id="allCheck" value="" data-falg="allCheck" onclick="checkBoxOp(this)"/>
                </th>
                <th width="40">ID</th>
                <th>标题</th>
                <th>是否显示</th>
                <th>楼盘</th>
                <th>面积</th>
                <th>展示类型 </th>
                <th width="70">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($renovation_info)): $i = 0; $__LIST__ = $renovation_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$info): $mod = ($i % 2 );++$i;?><tr>
                    <td>
                        <input class="va_m" type="checkbox" name="ids[]" value="<?php echo ($info["r_id"]); ?>" onclick="checkBoxOp(this)" />
                    </td>
                    <td><?php echo ($info["r_id"]); ?></td>
                    <td><?php echo ($info["r_title"]); ?></td>
                    <td><?php if(($info["r_state"]) == "1"): ?>显示<?php else: ?>隐藏<?php endif; ?></td>
                    <td><?php if(empty($info["r_estate"])): ?>暂无<?php endif; echo ($info["r_estate"]); ?></td>
                    <td><?php echo ($info["r_has"]); ?></td>
                    <td><?php if(($info["r_type"]) == "1"): ?>图片滑动<?php else: ?>图片混排<?php endif; ?></td>
                    <td>
                        <a class="table_btn" title="详细" onclick="layerPage('案例信息','<?php echo U('detail',array('r_id'=>$info['r_id']));?>','700px','470px')"><img src="/Public/img/edit.png" alt="详细" title="详细"></a>
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