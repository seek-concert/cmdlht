<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
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
<h4>产品类型列表</h4>
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
        <li class="fgf" onclick="layerPage('添加产品类型','<?php echo U('insert');?>','700px','440px')">
            <img src="/Public/img/add.png"/>
            添加产品类型
        </li>
    </ul>
</div>
<div class="tableCon">
    <div style="visibility: hidden;display: none;">
        <div id="search-form-div">
            <form action="/Producttype/index_list" method="post" id="search-form" class="layui-form">
                <div class="layerCon bg_f">
                    <table class="layerTable" border="0">
                        <tr class="h50">
                            <td><label for="pt_receptionname">展示名称：</label></td>
                            <td>
                                <input id="pt_receptionname" type="text" name="pt_receptionname" value="<?php echo ($ptreceptionname); ?>" placeholder="请输入展示名称"/>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td><label for="pt_time">添加时间：</label></td>
                            <td>
                                开始时间：<input id="pt_time" type="text" class="Wdate" onFocus="WdatePicker({lang:'zh-cn'})"
                                            name="pt_time1" value="<?php echo ($pttime1); ?>"/>
                                结束时间：<input id="pt_time1" type="text" class="Wdate" onFocus="WdatePicker({lang:'zh-cn'})"
                                            name="pt_time2" value="<?php echo ($pttime2); ?>"/>
                            </td>
                        </tr>
                   <tr class="h50">
                            <td>上上级名称：</td>
                            <td>
                                <select class="pidname2" onchange="modifysuprtior(this)">
                                    <option value="0">====无上级====</option>
                                    <?php if(is_array($pidname2)): $i = 0; $__LIST__ = $pidname2;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pidnames2): $mod = ($i % 2 );++$i;?><option value="<?php echo ($pidnames2["pt_id"]); ?>"><?php echo ($pidnames2["pt_receptionname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td>上级名称：</td>
                            <td>
                                <select name="pt_superior" class="ptsuperior">
                                    <option value="">====无上级====</option>
                                    <?php if(is_array($pidname2)): $i = 0; $__LIST__ = $pidname2;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pidnames2): $mod = ($i % 2 );++$i;?><option value="<?php echo ($pidnames2["pt_id"]); ?>" <?php if(($pidnames2["pt_id"]) == $ptsuperior): ?>selected<?php endif; ?>><?php echo ($pidnames2["pt_receptionname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td><label for="pt_state">是否启用：</label></td>
                            <td>
                                <select id="pt_state" name="pt_state">
                                    <option value="">无</option>
                                    <option value="1"  <?php if(($ptstate) == "1"): ?>selected<?php endif; ?>>启用</option>
                                    <option value="0"  <?php if(($ptstate) == "0"): ?>selected<?php endif; ?>>停用</option>
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
    <form action="/Producttype/index_list" method="post" class="js-ajax-form" id="js-ajax-form">
        <table class="table" border="0">
            <thead>
            <tr class="noSelect">
                <th class="tc" width="35px">
                    <input class="va_m" type="checkbox" name="" id="allCheck" value="" data-falg="allCheck" onclick="checkBoxOp(this)"/>
                </th>
                <th width="40">ID</th>
                <th>展示名称</th>
                <th>添加时间</th>
                <th>上级前台名称</th>
                <th>是否启用</th>
                <th>标语</th>
                <th>图标</th>
                <th>图标颜色</th>
                <th>图片</th>
                <th width="70">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($producttype_info)): $i = 0; $__LIST__ = $producttype_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$info): $mod = ($i % 2 );++$i;?><tr>
                    <td>
                        <input class="va_m" type="checkbox" name="ids[]" value="<?php echo ($info["pt_id"]); ?>" onclick="checkBoxOp(this)" />
                    </td>
                    <td><?php echo ($info["pt_id"]); ?></td>
                    <td><?php echo ($info["pt_receptionname"]); ?></td>
                    <td><?php echo (date('Y-m-d H:i',strtotime($info["pt_time"]))); ?></td>
                    <td><?php if(is_array($pidname)): $i = 0; $__LIST__ = $pidname;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pidnames): $mod = ($i % 2 );++$i; if(($pidnames["pt_id"]) == $info["pt_superior"]): echo ($pidnames["pt_receptionname"]); endif; endforeach; endif; else: echo "" ;endif; if(($info["pt_superior"]) == "0"): ?>无上级<?php endif; ?>
                    </td>
                    <td><?php if(($info["pt_state"]) == "1"): ?>启用<?php endif; if(($info["pt_state"]) == "0"): ?>停用<?php endif; ?></td>
                    <td><?php echo ($info["pt_backstagename"]); ?></td>
                    <td><?php if(($info["pt_img"]) == "1"): ?>暂无<?php else: if(empty($info["pt_img"])): ?>暂无<?php else: ?><img src="<?php echo ($info["pt_img"]); ?>" width="50px" height="50px;" alt="图标资源丢失"/><?php endif; endif; ?></td>
                    <td><?php if(empty($info["pt_color"])): ?>无颜色<?php else: ?><div style='width:50px;height:20px;background-color:<?php echo ($info["pt_color"]); ?>;'></div><?php endif; ?></td>
                    <td><?php if(($info["pt_pcimg"]) == ""): ?>暂无<?php else: ?><img src="<?php echo ($info["pt_pcimg"]); ?>" width="50px" height="50px;" alt="图片资源丢失"/><?php endif; ?></td>
                    <td>
                        <a class="button1" title="详细" onclick="layerPage('产品类型信息','<?php echo U('detail',array('pt_id'=>$info['pt_id']));?>','700px','470px')">查看信息</a>
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
    /*根据第一级显示第二级的内容*/
    function modifysuprtior(obj){
        var pt_id = $(obj).val();

        if(pt_id=="0" ){
            $('.ptsuperior').html("<option value='0'>====无上级====</option><?php if(is_array($pidname2)): $i = 0; $__LIST__ = $pidname2;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pidnames2): $mod = ($i % 2 );++$i;?><option value='<?php echo ($pidnames2["pt_id"]); ?>' <?php if(($pidnames2["pt_id"]) == $ptsuperior): ?>selected<?php endif; ?>><?php echo ($pidnames2["pt_receptionname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>");
            return false;
        }
        $.ajax({
            type:"post",
            url:"<?php echo U('index/search_ptsuperior');?>",
            data:{pt_id:pt_id},
            dataType:"json",
            success:function(data){
                $('.ptsuperior').html(data);
            }
        });
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