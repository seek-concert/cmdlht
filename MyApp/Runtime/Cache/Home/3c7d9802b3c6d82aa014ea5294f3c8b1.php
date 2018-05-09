<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>品牌列表</title>
    <link rel="stylesheet" type="text/css" href="/Public/css/style.css"/>
    <script src="/Public/js/jquery2-1-4.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/layer/layer.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/htglxt.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/iframe.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/ajax-submit.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/My97DatePicker/WdatePicker.js"></script>
</head>
<body>
<h4>品牌列表</h4>
<div class="toolsBar">
    <!--fgf为工具栏分隔符，刷新没有，离开都有。中间工具每一类第一个添加fgf-->
    <ul>
        <li onclick="reloadPage(window)">
            <img src="/Public/img/arrow_refresh.png"/>
            重置
        </li>
        <li class="fgf" onclick="layerDiv('查询',$('#search-form-div').html(),'500px','210px')">
            <img src="/Public/img/page_white_magnify.png"/>
            查询
        </li>
        <li class="fgf" onclick="layerPage('添加品牌','<?php echo U('insert');?>','750px','395px')">
            <img src="/Public/img/add.png"/>
            添加品牌
        </li>
    </ul>
</div>
<div class="tableCon">
    <div style="visibility: hidden;display: none;">
        <div id="search-form-div">
            <form action="/Brand/index_list" method="post" id="search-form" class="layui-form">
                <div class="layerCon bg_f">
                    <table class="layerTable" border="0">
                        <tr class="h50">
                            <td><label for="b_name">名称：</label></td>
                            <td>
                                <input id="b_name" type="text" name="b_name" value="<?php echo ($bname); ?>" placeholder="请输入名称"/>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td><label for="b_pinyininitials">拼音首字母：</label></td>
                            <td>
                                <input id="b_pinyininitials" type="text" name="b_pinyininitials" value="<?php echo ($bpinyininitials); ?>" placeholder="请输入拼音首字母"/>
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
                <th>名称</th>
                <th>品牌图片</th>
                <th>拼音</th>
                <th>拼音首字母</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($brand_info)): $i = 0; $__LIST__ = $brand_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$info): $mod = ($i % 2 );++$i;?><tr   class="h25">
                    <td>
                        <input class="va_m" type="checkbox" name="ids[]" value="<?php echo ($info["b_id"]); ?>"
                               onclick="checkBoxOp(this)"/>
                    </td>
                    <td><?php echo ($info["b_id"]); ?></td>
                    <td><?php echo ($info["b_name"]); ?></td>
                    <td><img src="<?php echo ($info["b_img"]); ?>"  width="100px;" height="100px;" alt="无法显示"></td>
                    <td><?php echo ($info["b_pinyin"]); ?></td>
                    <td><?php echo ($info["b_pinyininitials"]); ?></td>
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