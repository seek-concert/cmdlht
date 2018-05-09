<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>产品管理</title>
    <link rel="stylesheet" type="text/css" href="/Public/css/style.css"/>
    <script src="/Public/js/jquery2-1-4.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/layer/layer.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/htglxt.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/iframe.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/ajax-submit.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/My97DatePicker/WdatePicker.js"></script>
</head>
<body>
<h4>产品列表</h4>
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
        <?php if(($pdel) == "1"): else: ?>
        <li class="fgf" onclick="layerPage('添加产品','<?php echo U('insert');?>','1020px','750px')">
            <img src="/Public/img/add.png"/>
            添加产品
        </li>
            <li class="fgf js-ajax-form-btn"></li>
        <li class="fgf js-ajax-form-btn" data-form="js-ajax-form" id="dels1"
            data-action="<?php echo U('status_modifys',array('action'=>'on'));?>">
            <img src="/Public/img/enable.png"/>
            批量上架
        </li>
        <li class="fgf js-ajax-form-btn" data-form="js-ajax-form" id="dels2"
            data-action="<?php echo U('status_modifys',array('action'=>'off'));?>">
            <img src="/Public/img/unable.png"/>
            批量下架
        </li>
         <li class="fgf js-ajax-form-btn"></li>
        <li class="fgf js-ajax-form-btn" data-form="js-ajax-form"
            data-action="<?php echo U('modify_qiyong',array('action'=>'on'));?>">
            <img src="/Public/img/enable.png"/>
            批量启用
        </li>
        <li class="fgf js-ajax-form-btn" data-form="js-ajax-form"
            data-action="<?php echo U('modify_qiyong',array('action'=>'off'));?>">
            <img src="/Public/img/unable.png"/>
            批量停用
        </li>
            <li class="fgf js-ajax-form-btn"></li>
        <li class="fgf" onclick="insertNotice(&#39;all&#39;)">
            <img src="/Public/img/email_at_sign.png"/>
            发送通知
        </li><?php endif; ?>
    </ul>
</div>
<div class="tableCon">
    <div style="visibility: hidden;display: none;">
        <div id="search-form-div">
            <form action="/Product/index_list" method="post" id="search-form" class="layui-form">
                <div class="layerCon bg_f">
                    <table class="layerTable" border="0">
                        <tr class="h50">
                            <td><label for="p_name">产品名称：</label></td>
                            <td>
                                <input id="p_name" type="text" name="p_name" value="<?php echo ($pname); ?>" placeholder="请输入产品名称"/>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td><label for="bid_name">品牌：</label></td>
                            <td>
                                <input id="bid_name" type="text" name="bid_name" value="<?php echo ($bidname); ?>" placeholder="请输入品牌名称"/>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td><label for="uid_name">商家：</label></td>
                            <td>
                                <input id="uid_name" type="text" name="uid_name" value="<?php echo ($uidname); ?>" placeholder="请输入商家名称"/>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td><label for="p_state">上架状态：</label></td>
                            <td>
                                <select id="p_state" name="p_state">
                                    <option value="">=====无=====</option>
                                    <option value="0" <?php if(($pstate) == "0"): ?>selected<?php endif; ?>>=====下架=====</option>
                                    <option value="1" <?php if(($pstate) == "1"): ?>selected<?php endif; ?>>=====上架=====</option>
                                </select>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td><label for="p_del">删除状态：</label></td>
                            <td>
                                <select id="p_del" name="p_del">
                                    <option value="">=====无=====</option>
                                    <option value="0" <?php if(($pdel) == "0"): ?>selected<?php endif; ?>>=====正常=====</option>
                                    <option value="1" <?php if(($pdel) == "1"): ?>selected<?php endif; ?>>=====删除=====</option>
                                </select>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td><label for="p_time">添加时间：</label></td>
                            <td>
                                开始时间：<input id="p_time" type="text" class="Wdate" onFocus="WdatePicker({lang:'zh-cn'})"
                                            name="p_time1" value="<?php echo ($ptime1); ?>"/>
                                结束时间：<input id="p_time1" type="text" class="Wdate" onFocus="WdatePicker({lang:'zh-cn'})"
                                            name="p_time2" value="<?php echo ($ptime2); ?>"/>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td><label for="p_isactivity">是否有活动：</label></td>
                            <td>
                                <select id="p_isactivity" name="p_isactivity">
                                    <option value="">=====无=====</option>
                                    <option value="0" <?php if(($pisactivity) == "0"): ?>selected<?php endif; ?>>=====无活动=====</option>
                                    <option value="1" <?php if(($pisactivity) == "1"): ?>selected<?php endif; ?>>=====有活动=====</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                    <div class="layerBtns1" onclick="searchdel()">
                        <button class="btn" type="submit">提交</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <em class="xian"></em>
    <form action="/Product/index_list" method="post" class="js-ajax-form" id="js-ajax-form-del" style="display: none;">
        <table class="table" border="0">
            <thead>
            <tr class="noSelect">
                <th class="tc" width="35px">
                    <input class="va_m" type="checkbox" name="" id="allCheck1" value="" data-falg="allCheck" onclick="checkBoxOp(this)"/>
                </th>
                <th width="40">ID</th>
                <th>产品名称</th>
                <th>单位</th>
                <th>品牌</th>
                <th>商家</th>
                <th>上架状态</th>
                <th>卖点</th>
                <th>添加时间</th>
                <th>搜索关键字</th>
                <th>是否有活动</th>
                <th>活动名称</th>
                <th>产品状态</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($product_info)): $i = 0; $__LIST__ = $product_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$info): $mod = ($i % 2 );++$i; if(($info["p_del"]) == "0"): else: ?>
                    <tr>
                        <td>
                            <input class="va_m" type="checkbox" name="ids[]" value="<?php echo ($info["p_id"]); ?>"  />
                        </td>
                        <td><?php echo ($info["p_id"]); ?></td>
                        <td><?php echo ($info["p_name"]); ?></td>
                        <td><?php if($info["cid_name"] == null): ?>暂无<?php else: echo ($info["cid_name"]); endif; ?></td>
                        <td><?php echo ($info["bid_name"]); ?></td>
                        <td><?php echo ($info["uid_name"]); ?></td>
                        <td><?php if(($info["p_state"]) == "1"): ?>上架<?php endif; ?>
                            <?php if(($info["p_state"]) == "0"): ?>下架<?php endif; ?></td>
                        <td><?php if($info["p_sellingpoint"] == null): ?>暂无<?php else: echo ($info["p_sellingpoint"]); endif; ?></td>
                        <td><?php echo (date('Y-m-d H:i',strtotime($info["p_time"]))); ?></td>
                        <td><?php echo ($info["p_searchkeyword"]); ?></td>
                        <td><?php if(($info["p_isactivity"]) == "1"): ?>有活动<?php endif; ?>
                            <?php if(($info["p_isactivity"]) == "0"): ?>无活动<?php endif; ?></td>
                        <td><?php if($info["p_activityname"] == null): ?>暂无<?php else: echo ($info["p_activityname"]); endif; ?></td>
                        <td><?php if(($info["p_qiyong"]) == "1"): ?>启用<?php endif; ?>
                            <?php if(($info["p_qiyong"]) == "0"): ?>停用<?php endif; ?></td>
                    </tr><?php endif; endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
    </form>
    <form action="/Product/index_list" method="post" class="js-ajax-form" id="js-ajax-form">
        <table class="table" border="0">
            <thead>
            <tr class="noSelect">
                <th class="tc" width="35px">
                    <input class="va_m" type="checkbox" name="" id="allCheck" value="" data-falg="allCheck" />
                </th>
                <th width="40">ID</th>
                <th>产品名称</th>
                <th>单位</th>
                <th>品牌</th>
                <th>商家</th>
                <th>上架状态</th>
                <th>卖点</th>
                <th>添加时间</th>
                <th>搜索关键字</th>
                <th>是否有活动</th>
                <th>活动名称</th>
                <th>产品状态</th>
                <th width="70">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($product_info)): $i = 0; $__LIST__ = $product_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$info): $mod = ($i % 2 );++$i; if(($info["p_del"]) == "1"): else: ?>
                <tr>
                    <td>
                        <input class="va_m" type="checkbox" name="ids[]" value="<?php echo ($info["p_id"]); ?>" />
                    </td>
                    <td class="pid"><?php echo ($info["p_id"]); ?></td>
                    <td><?php echo ($info["p_name"]); ?></td>
                    <td><?php if($info["cid_name"] == null): ?>暂无<?php else: echo ($info["cid_name"]); endif; ?></td>
                    <td><?php if(empty($info["bid_name"])): ?>暂无<?php endif; echo ($info["bid_name"]); ?></td>
                    <td><input class="va_m" type="checkbox" name="idss[]" value="<?php echo ($info["p_uid"]); ?>" /><?php if(empty($info["uid_name"])): ?>商户ID：<?php echo ($info["p_uid"]); endif; echo ($info["uid_name"]); ?></td>
                    <td><?php if(($info["p_state"]) == "1"): ?>上架<?php endif; ?>
                        <?php if(($info["p_state"]) == "0"): ?>下架<?php endif; ?></td>
                    <td><?php if($info["p_sellingpoint"] == null): ?>暂无<?php else: echo ($info["p_sellingpoint"]); endif; ?></td>
                    <td><?php echo (date('Y-m-d H:i',strtotime($info["p_time"]))); ?></td>
                    <td><?php echo ($info["p_searchkeyword"]); ?></td>
                    <td><?php if(($info["p_isactivity"]) == "1"): ?>有活动<?php endif; ?>
                        <?php if(($info["p_isactivity"]) == "0"): ?>无活动<?php endif; ?></td>
                    <td><?php if($info["p_activityname"] == null and $info["p_activityname"] == 0): ?>暂无<?php else: echo ($info["p_activityname"]); endif; ?></td>
                    <td><?php if(($info["p_qiyong"]) == "1"): ?>启用<?php endif; ?>
                        <?php if(($info["p_qiyong"]) == "0"): ?>停用<?php endif; ?></td>
                    <td><a class="table_btn" title="详细" onclick="layerPage('产品信息','<?php echo U('detail',array('p_id'=>$info['p_id']));?>','1020px','750px')">
                        <img src="/Public/img/edit.png" alt="详细" title="详细"></a> |
                        <?php if(in_array($info['p_id'],$irpid_ids)): if(in_array($info['p_id'],$irstate_ids[1])): ?><input type="hidden" class="irstate" value="0">
                                <input type="button" onclick="modifyRecommend(this)" class="fgf js-ajax-form-btn" value="取消首页推荐"><?php else: ?><input type="hidden" class="irstate" value="1"><input type="button" class="fgf js-ajax-form-btn" onclick="modifyRecommend(this)" value="设置首页推荐"><?php endif; ?>
                        <?php else: ?>
                            <input type="hidden" class="irstate" value="1">
                            <input type="button" onclick="insertRecommend(this)" class="fgf js-ajax-form-btn"  value="设置首页推荐"><?php endif; ?>
                        |<a class="table_btn" title="添加产品推荐" onclick="layerPage('添加产品推荐','<?php echo U('productrecommend/index_list',array('p_id'=>$info['p_id']));?>','700px','470px')">
                           <input type="button" value="添加产品推荐"></a></td>
                </tr><?php endif; endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
    </form>
</div>
<div class="pageCon">
    <?php echo ($page_bar); ?>       每页 20 条，共 <?php echo ($count); ?> 条
</div>

<script>
    /*ajax修改首页推荐*/
    function modifyRecommend(obj) {
       var irstate = $(obj).parents("tr").find(".irstate").val();
       var irpid = $(obj).parents("tr").find(".pid").text();
       var data = {
           'ir_state':irstate,
           'ir_pid':irpid
       };
        $.ajax({
            type: "post",
            url: "<?php echo U('Indexrecommend/modify');?>",
            data: data,
            dataType: "json",
            success: function (e) {
                if (e.status == 1) {
                    layer.msg(e.info);
                    window.location.reload();
                }
                if(e.status == 0){
                    layer.msg(e.info);
                }
            },
            error: function () {
                layer.alert('操作失败！');
            }
        })
    }
    /*ajax添加首页推荐*/
    function insertRecommend(objs) {
        var irstate = $(objs).parents("tr").find(".irstate").val();
        var irpid = $(objs).parents("tr").find(".pid").text();
        var data = {
            'ir_state':irstate,
            'ir_pid':irpid
        };
        $.ajax({
            type: "post",
            url: "<?php echo U('Indexrecommend/insert');?>",
            data: data,
            dataType: "json",
            success: function (e) {
                if (e.status == 1) {
                    layer.msg(e.info);
                    window.location.reload();
                }
                if(e.status == 0){
                    layer.alert(e.info);
                }
            },
            error: function () {
                layer.alert('操作失败！');
            }
        })
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

    window.onload=function(){
        searchdel();
    };
    /*删除状态-查询状态为删除的*
    * 当状态为删除时显示删除的页面*
    * 当状态为正常或状态无条件时显示正常的页面*
    * */
    function searchdel(){
        var  pdel = $("#p_del").val();
       if(pdel == 1){
           $("#js-ajax-form-del").show();
           $("#js-ajax-form").hide();
           $("#dels").hide();
       }
       if(pdel == '0' || pdel == null){
           $("#js-ajax-form").show();
           $("#js-ajax-form-del").hide();
       }
    }

    function insertNotice(rs) {
        var ids = "";
        if (rs == "all") {
            var checkedlist = $("input[name=\"idss[]\"]:checked");
            for (var i = 0; i < checkedlist.length; i++) {
                ids += $(checkedlist[i]).val();
                if (i < checkedlist.length - 1) ids += ",";
            }
        } else {
            ids = rs;
        }
        if (ids == "") {
            layer.msg('请选择要发送的用户!', {icon: 1, time: 1000});
            return;
        }
        $("#hid_ids").val(ids);
        layerPage("发送系统通知","<?php echo U('Notice/inserts');?>",'700px','240px');
    }
    /*================ajax添加====================*/
    function  ajaxinsert(n_title,n_content) {
        var data = {
            'n_uid':$("#hid_ids").val(),
            'n_title':n_title,
            'n_content':n_content
        };
        var index = layer.load({ shade: [0.5, '#fff'] });
        $.ajax({
            type: "post",
            url: "<?php echo U('notice/insert');?>",
            data: data,
            dataType: "json",
            success: function (e) {
                layer.close(index);
                if (e.status == 1) {
                    layer.msg(e.info);
                    window.location="<?php echo U('product/index_list');?>";
                }
                if(e.status == 0){
                    layer.msg(e.info);
                }
            },
            error: function () {
                layer.close(index);
                layer.alert('操作失败！');
            }
        });
    }

</script>
<input type="hidden" id="hid_ids"  />
</body>
</html>