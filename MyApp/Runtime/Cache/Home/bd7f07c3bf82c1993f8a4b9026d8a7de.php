<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>施工评价</title>
    <link rel="stylesheet" type="text/css" href="/Public/css/style.css"/>
    <script src="/Public/js/jquery2-1-4.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/layer/layer.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/htglxt.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/iframe.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/ajax-submit.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/My97DatePicker/WdatePicker.js"></script>
</head>
<body>
<h4>施工评价</h4>
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
        <li class="fgf js-ajax-form-btn" data-form="js-ajax-form"
            data-action="<?php echo U('status_modify',array('action'=>'on'));?>">
            <img src="/Public/img/enable.png"/>
            批量显示
        </li>
        <li class="fgf js-ajax-form-btn" data-form="js-ajax-form"
            data-action="<?php echo U('status_modify',array('action'=>'off'));?>">
            <img src="/Public/img/unable.png"/>
            批量隐藏
        </li>
    </ul>
</div>
<div class="tableCon">
    <div style="visibility: hidden;display: none;">
        <div id="search-form-div">
            <form action="/Constructionevaluation/index_list" method="post" id="search-form" class="layui-form">
                <div class="layerCon bg_f">
                    <table class="layerTable" border="0">
                        <tr class="h50">
                            <td><label for="cuid_name">师傅：</label></td>
                            <td>
                                <input id="cuid_name" type="text" name="cuid_name" value="<?php echo ($cuidname); ?>" placeholder="请输入师傅名称"/>
                            </td>
                        </tr>
                <!--        <tr class="h50">
                            <td><label for="uid_name">用户：</label></td>
                            <td>
                                <input id="uid_name" type="text" name="uid_name" value="<?php echo ($uidname); ?>"/>
                            </td>
                        </tr>-->
                        <tr class="h50">
                            <td><label for="ce_time">评论时间：</label></td>
                            <td>
                                开始时间：<input id="ce_time" type="text" class="Wdate" onFocus="WdatePicker({lang:'zh-cn'})"  name="ce_time1" value="<?php echo ($cetime1); ?>"/>
                                结束时间：<input id="ce_time1" type="text" class="Wdate" onFocus="WdatePicker({lang:'zh-cn'})"  name="ce_time2" value="<?php echo ($cetime2); ?>"/>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td><label for="ce_state">状态：</label></td>
                            <td>
                                <select  id="ce_state"  name="ce_state">
                                    <option value="">=====无=====</option>
                                    <option value="1" <?php if(($cestate) == "1"): ?>selected<?php endif; ?>>=====显示=====</option>
                                    <option value="0" <?php if(($cestate) == "0"): ?>selected<?php endif; ?>>=====隐藏=====</option>
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
    <div class="search-form-div1" style="display: none;">
        <textarea cols="50" rows="10" class="content1" style="width: 100%;height: 100%;"  disabled></textarea>
    </div>
    <div class="search-form-div2" style="display: none;">
        <div class="ceimglist1"></div>
    </div>
    <em class="xian"></em>
    <form action="<?php echo U('sort');?>" method="post" class="js-ajax-form" id="js-ajax-form">
        <table class="table" border="0">
            <thead>
            <tr class="noSelect">
                <th class="tc" width="35px">
                    <input class="va_m" type="checkbox" name="" id="allCheck" value="" data-falg="allCheck" onclick="checkBoxOp(this)"/>
                </th>
                <th width="40">ID</th>
                <th>师傅</th>
                <th>用户</th>
                <th>服务评分</th>
                <th>质量评分</th>
                <th>评论</th>
                <th>评论时间</th>
                <th>施工图片</th>
                <th>是否显示</th>
                <th>是否匿名</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($img_ids)): $i = 0; $__LIST__ = $img_ids;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$info): $mod = ($i % 2 );++$i;?><tr>
                    <td>
                        <input class="va_m" type="checkbox" name="ids[]" value="<?php echo ($info["ce_id"]); ?>" onclick="checkBoxOp(this)" />
                    </td>
                    <td><?php echo ($info["ce_id"]); ?></td>
                    <td><?php echo ($info["cuid_name"]); ?></td>
                    <td><?php echo ($info["uid_name"]); ?></td>
                    <td><?php echo ($info["ce_servicescore"]); ?></td>
                    <td><?php echo ($info["ce_qualityscore"]); ?></td>
                    <td><input type="hidden" class="cfcontent" value="<?php echo ($info["ce_content"]); ?>"><input type="button"  value="点击查看" onclick="test1(this)">
                    </td>
                    <td><?php echo (date('Y-m-d H:i',strtotime($info["ce_time"]))); ?></td>
                    <td><div style="display: none" class="ceimglist">
                        <?php if(is_array($info['ce_imglist'])): $i = 0; $__LIST__ = $info['ce_imglist'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$imgids): $mod = ($i % 2 );++$i;?><img src="<?php echo ($imgids); ?>" onclick="moveImg(this)" style="margin-left: 3px;" width="150px;" height="150px;"><br/><?php endforeach; endif; else: echo "" ;endif; ?>
                    </div><input type="button"  value="点击查看" onclick="test2(this)"></td>
                    <td><?php if(($info["ce_state"]) == "1"): ?>显示<?php endif; if(($info["ce_state"]) == "0"): ?>隐藏<?php endif; ?></td>
                    <td><?php if(($info["ce_anonymous"]) == "1"): ?>是<?php endif; if(($info["ce_anonymous"]) == "0"): ?>否<?php endif; ?></td>
                   </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
    </form>
</div>
<div class="pageCon">
    <?php echo ($page_bar); ?>       每页 20 条，共 <?php echo ($count); ?> 条
</div>

<script>
    /*图片放大与缩小*/
    function moveImg(obj)
    {
        var width = $(obj).width();
        if(width==150) {
            $(obj).width(500);
            $(obj).height(500);
        }else {
            $(obj).width(150);
            $(obj).height(150);
        }
    }
    /*弹出评论*/
    function test1(obj) {
        $(".search-form-div1"). find(".content1").html(" ");
        var cfcontent = $(obj).parent("td").find(".cfcontent").val();
        $(".search-form-div1"). find(".content1").html(cfcontent);
        layerDiv('评论',$('.search-form-div1').html(),'500px','300px');
    }
    /*弹出图片*/
    function test2(objs) {
        $(".search-form-div2").find(".ceimglist1").html(" ");
        var cfyanshoucontent = $(objs).parent("td").find(".ceimglist").html();
        $(".search-form-div2").find(".ceimglist1").html(cfyanshoucontent);
        layerDiv('施工图片',$('.search-form-div2').html(),'700px','500px');
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