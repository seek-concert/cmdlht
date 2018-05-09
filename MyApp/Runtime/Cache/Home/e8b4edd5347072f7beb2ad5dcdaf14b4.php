<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>产品审核管理</title>
    <link rel="stylesheet" type="text/css" href="/Public/css/style.css"/>
    <script src="/Public/js/jquery2-1-4.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/layer/layer.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/htglxt.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/iframe.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/ajax-submit.js" type="text/javascript" charset="utf-8"></script>
</head>
<body>
<h4>产品审核管理列表</h4>
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
            <form action="/Product/index" method="post" id="search-form" class="layui-form">
                <div class="layerCon bg_f">
                    <table class="layerTable" border="0">
                        <tr class="h50">
                            <td><label for="uid_name">商家：</label></td>
                            <td>
                                <input id="uid_name" type="text" name="uid_name" value="<?php echo ($uidname); ?>" placeholder="请输入商家名称"/>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td><label for="p_name">产品名称：</label></td>
                            <td>
                                <input id="p_name" type="text" name="p_name" value="<?php echo ($pname); ?>"  placeholder="请输入产品名称"/>
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
    <form action="/Product/index" method="post" class="js-ajax-form" id="js-ajax-form">
        <table class="table" border="0">
            <thead>
            <tr class="noSelect">
                <th class="tc" width="35px">
                    <input class="va_m" type="checkbox" name="" id="allCheck" value="" data-falg="allCheck" onclick="checkBoxOp(this)"/>
                </th>
                <th width="40">ID</th>
                <th>产品名称</th>
                <th>商家名称</th>
                <th>产品审核状态</th>
                <th width="70">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($product_info)): $i = 0; $__LIST__ = $product_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$info): $mod = ($i % 2 );++$i;?><tr>
                    <td>
                        <input class="va_m" type="checkbox" name="ids[]" value="<?php echo ($info["p_id"]); ?>" onclick="checkBoxOp(this)" />
                    </td>
                    <td><?php echo ($info["p_id"]); ?></td>
                    <td><?php echo ($info["p_name"]); ?></td>
                    <td><?php if(empty($info["uid_name"])): ?>店铺名称不存在或账号已被删除【ID:<?php echo ($info["p_uid"]); ?>】<?php endif; echo ($info["uid_name"]); ?></td>
                    <td><?php if(($info["p_shenhe"]) == "0"): ?>申请中<?php endif; ?>
                        <?php if(($info["p_shenhe"]) == "1"): ?>已通过<?php endif; ?>
                        <?php if(($info["p_shenhe"]) == "2"): ?>已拒绝<?php endif; ?></td>
                    <td>
                        <a class="table_btn" title="详细" onclick="layerPage('产品信息','<?php echo U('modifystate',array('p_id'=>$info['p_id']));?>','880px','520px')"><img src="/Public/img/edit.png" alt="详细" title="详细"></a>
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