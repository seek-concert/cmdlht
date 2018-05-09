<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>装修报价类型</title>
    <link rel="stylesheet" type="text/css" href="/Public/css/style.css"/>
    <script src="/Public/js/jquery2-1-4.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/layer/layer.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/htglxt.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/iframe.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/ajax-submit.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/My97DatePicker/WdatePicker.js"></script>
</head>
<body>
<h4>装修报价类型列表</h4>
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
        <li class="fgf" onclick="layerPage('添加类型','<?php echo U('insert');?>','700px','200px')">
            <img src="/Public/img/add.png"/>
            添加类型
        </li>
    </ul>
</div>
<div class="tableCon">
    <div style="visibility: hidden;display: none;">
        <div id="search-form-div">
            <form action="/Quotationcontent/index_list" method="post" id="search-form" class="layui-form">
                <div class="layerCon bg_f">
                    <table class="layerTable" border="0">
                        <tr class="h50">
                            <td><label for="qc_title">报价名称：</label></td>
                            <td>
                                <input id="qc_title" type="text" name="qc_title" value="<?php echo ($qc_title); ?>" placeholder="请输入报价名称"/>
                            </td>
                        </tr>
                        <tr class="h50">
                        <td><label for="qc_type">类型：</label></td>
                        <td>
                            <select id="qc_type" name="qc_type">
                                <option value="">=======无========</option>
                                <option value="10000" <?php if(($qc_type) == "10000"): ?>selected<?php endif; ?>>========[地区]========</option>
                                <option value="20000" <?php if(($qc_type) == "20000"): ?>selected<?php endif; ?>>========[面积]========</option>
                                <option value="30000" <?php if(($qc_type) == "30000"): ?>selected<?php endif; ?>>========[厅]========</option>
                                <option value="40000" <?php if(($qc_type) == "40000"): ?>selected<?php endif; ?>>========[室]========</option>
                                <option value="50000" <?php if(($qc_type) == "50000"): ?>selected<?php endif; ?>>========[卫]========</option>
                                <option value="60000" <?php if(($qc_type) == "60000"): ?>selected<?php endif; ?>>========[风格]========</option>
                            </select>
                        </td>
                    </tr>
                        <tr class="h50">
                            <td><label for="qc_state">状态：</label></td>
                            <td>
                                <select id="qc_state" name="qc_state">
                                    <option value="">=======无========</option>
                                    <option value="1" <?php if(($qc_state) == "1"): ?>selected<?php endif; ?>>========[启用]========</option>
                                    <option value="0" <?php if(($qc_state) == "0"): ?>selected<?php endif; ?>>========[停用]========</option>
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
    <form action="/Quotationcontent/index_list" method="post" class="js-ajax-form" id="js-ajax-form">
        <table class="table" border="0">
            <thead>
            <tr class="noSelect">
                <th class="tc" width="35px">
                    <input class="va_m" type="checkbox" name="" id="allCheck" value="" data-falg="allCheck" onclick="checkBoxOp(this)"/>
                </th>
                <th width="40">ID</th>
                <th>报价名称</th>
                <th>价格</th>
                <th>类型</th>
                <th>状态</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($quotationcontent_list)): $i = 0; $__LIST__ = $quotationcontent_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$info): $mod = ($i % 2 );++$i;?><tr>
                    <td>
                        <input class="va_m" type="checkbox" name="ids[]" value="<?php echo ($info["qc_id"]); ?>" onclick="checkBoxOp(this)" />
                    </td>
                    <td><?php echo ($info["qc_id"]); ?></td>
                    <td><?php echo ($info["qc_title"]); ?></td>
                    <td><?php echo ($info["qc_price"]); ?></td>
                    <td>
                        <?php if(($info["qc_type"]) == "10000"): ?>地区<?php endif; ?>
                        <?php if(($info["qc_type"]) == "20000"): ?>面积<?php endif; ?>
                        <?php if(($info["qc_type"]) == "30000"): ?>厅<?php endif; ?>
                        <?php if(($info["qc_type"]) == "40000"): ?>室<?php endif; ?>
                        <?php if(($info["qc_type"]) == "50000"): ?>卫<?php endif; ?>
                        <?php if(($info["qc_type"]) == "60000"): ?>风格<?php endif; ?>
                    </td>
                    <td><?php if(($info["qc_state"]) == "1"): ?>启用<?php endif; if(($info["qc_state"]) == "0"): ?>停用<?php endif; ?></td>
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