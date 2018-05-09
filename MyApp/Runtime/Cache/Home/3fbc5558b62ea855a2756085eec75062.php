<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>单位列表</title>
    <link rel="stylesheet" type="text/css" href="/Public/css/style.css"/>
    <script src="/Public/js/jquery2-1-4.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/layer/layer.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/htglxt.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/iframe.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/ajax-submit.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/My97DatePicker/WdatePicker.js"></script>
</head>
<body>
<h4>单位列表</h4>
<div class="toolsBar">
    <!--fgf为工具栏分隔符，刷新没有，离开都有。中间工具每一类第一个添加fgf-->
    <ul>
        <li onclick="reloadPage(window)">
            <img src="/Public/img/arrow_refresh.png"/>
            重置
        </li>
        <li class="fgf" onclick="layerDiv('查询',$('#search-form-div').html(),'500px','150px')">
            <img src="/Public/img/page_white_magnify.png"/>
            查询
        </li>
        <li class="fgf" onclick="layerPage('添加单位','<?php echo U('insert');?>','700px','200px')">
            <img src="/Public/img/add.png"/>
            添加单位
        </li>
    </ul>
</div>
<div class="tableCon">
    <div style="visibility: hidden;display: none;">
        <div id="search-form-div">
            <form action="/Company/index_list" method="post" id="search-form" class="layui-form">
                <div class="layerCon bg_f">
                    <table class="layerTable" border="0">
                        <tr class="h50">
                            <td><label for="c_name">单位名称：</label></td>
                            <td>
                                <input id="c_name" type="text" name="c_name" value="<?php echo ($c_name); ?>" placeholder="请输入单位名称"/>
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
    <form action="/Company/index_list" method="post" class="js-ajax-form" id="js-ajax-form">
        <table class="table" border="0">
            <thead>
            <tr class="noSelect">
                <th class="tc" width="35px">
                    <input class="va_m" type="checkbox" name="" id="allCheck" value="" data-falg="allCheck" onclick="checkBoxOp(this)"/>
                </th>
                <th width="40">ID</th>
                <th>单位名称</th>
                <th width="70">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($company_info)): $i = 0; $__LIST__ = $company_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$info): $mod = ($i % 2 );++$i;?><tr>
                    <td>
                        <input class="va_m" type="checkbox" name="ids[]" value="<?php echo ($info["c_id"]); ?>" onclick="checkBoxOp(this)" />
                    </td>
                    <td><?php echo ($info["c_id"]); ?></td>
                    <td><?php echo ($info["c_name"]); ?></td>
                    <td>
                        <a class="table_btn" title="详细" onclick="layerPage('单位信息','<?php echo U('detail',array('c_id'=>$info['c_id']));?>','700px','200px')"><img src="/Public/img/edit.png" alt="详细" title="详细"></a>
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