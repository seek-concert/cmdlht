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
<h4>投诉记录列表</h4>
<div class="toolsBar">
    <!--fgf为工具栏分隔符，刷新没有，离开都有。中间工具每一类第一个添加fgf-->
    <ul>
        <li onclick="reloadPage(window)">
            <img src="/Public/img/arrow_refresh.png"/>
            重置
        </li>
        <li class="fgf" onclick="layerDiv('查询',$('#search-form-div').html(),'500px','410px')">
            <img src="/Public/img/page_white_magnify.png"/>
            查询
        </li>
        <li class="fgf js-ajax-form-btn" data-form="js-ajax-form" data-action="<?php echo U('status_modify',array('action'=>'on'));?>" >
            <img src="/Public/img/enable.png"/>
            批量|处理已完成
        </li>
        <li class="fgf js-ajax-form-btn" data-form="js-ajax-form" data-action="<?php echo U('status_modify',array('action'=>'off'));?>" >
            <img src="/Public/img/unable.png"/>
            批量|投诉处理中
    </ul>
</div>
<div class="tableCon">
    <div style="visibility: hidden;display: none;">
        <div id="search-form-div">
            <form action="/Complaint/index_list" method="post" id="search-form" class="layui-form">
                <div class="layerCon bg_f">
                    <table class="layerTable" border="0">
                        <tr class="h50">
                            <td><label for="c_onlyid">投诉订单号：</label></td>
                            <td>
                                <input id="c_onlyid" type="text" name="c_onlyid" value="<?php echo ($c_onlyid); ?>" placeholder="请输入投诉订单号"/>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td>投诉名称类型：</td>
                            <td>
                                <select  name="c_type" >
                                    <option value="0">--无--</option>
                                    <option value="1" <?php if(($ctype) == "1"): ?>selected<?php endif; ?>>建材商</option>
                                    <option value="2" <?php if(($ctype) == "2"): ?>selected<?php endif; ?>>师傅</option>
                                </select>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td><label for="c_time">投诉时间：</label></td>
                            <td>
                                开始时间：<input id="c_time" type="text" class="Wdate" onFocus="WdatePicker({lang:'zh-cn'})" name="c_time1" value="<?php echo ($ctime1); ?>"/>
                                结束时间：<input id="c_time1" type="text" class="Wdate" onFocus="WdatePicker({lang:'zh-cn'})" name="c_time2" value="<?php echo ($ctime2); ?>"/>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td><label for="uid_name">投诉用户：</label></td>
                            <td>
                                <input id="uid_name" type="text" name="uid_name" value="<?php echo ($uid_name); ?>" placeholder="请输入投诉用户"/>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td><label for="c_state">投诉状态：</label></td>
                            <td>
                                <select  name="c_state" id="c_state" >
                                    <option value="0">----无----</option>
                                    <option value="1" <?php if(($cstate) == "1"): ?>selected<?php endif; ?>>投诉处理中</option>
                                    <option value="2" <?php if(($cstate) == "2"): ?>selected<?php endif; ?>>投诉已完成</option>
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
    <em class="xian"></em>
    <form action="/Complaint/index_list" method="post" class="js-ajax-form" id="js-ajax-form">
        <table class="table" border="0">
            <thead>
            <tr class="noSelect">
                <th class="tc" width="35px">
                    <input class="va_m" type="checkbox" name="" id="allCheck" value="" data-falg="allCheck" onclick="checkBoxOp(this)"/>
                </th>
                <th width="40">ID</th>
                <th>投诉订单</th>
                <th>投诉名称类型</th>
                <th>投诉内容</th>
                <th>投诉证据</th>
                <th>投诉时间</th>
                <th>投诉用户</th>
                <th>投诉状态</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($complaint_info)): $i = 0; $__LIST__ = $complaint_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$info): $mod = ($i % 2 );++$i;?><tr>
                    <td>
                        <input class="va_m" type="checkbox" name="ids[]" value="<?php echo ($info["c_id"]); ?>" onclick="checkBoxOp(this)" />
                    </td>
                    <td><?php echo ($info["c_id"]); ?></td>
                    <td><?php echo ($info["c_onlyid"]); ?></td>
                    <td><?php if(($info["c_type"]) == "1"): ?>建材商<?php endif; if(($info["c_type"]) == "2"): ?>师傅<?php endif; ?></td>
                    <td><input type="button" value="点击查看" onclick="test1(this)"><input type="hidden" class="content123" value="<?php echo ($info["c_content"]); ?>"></td>
                    <td><?php echo ($info["c_evidence"]); ?></td>
                    <td><?php echo (date('Y-m-d H:i',strtotime($info["c_time"]))); ?></td>
                    <td><?php echo ($info["uid_name"]); ?></td>
                    <td><?php if(($info["c_state"]) == "1"): ?><img src="/Public/img/unable.png"/>投诉处理中<?php endif; ?>
                        <?php if(($info["c_state"]) == "2"): ?><img src="/Public/img/enable.png"/>处理已完成<?php endif; ?></td>

                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
    </form>
</div>
<div class="pageCon">
    <?php echo ($page_bar); ?>       每页 20 条，共 <?php echo ($count); ?> 条
</div>

<script>
    /*弹出备注说明*/
    function test1(obj) {
        $(".search-form-div1"). find(".content1").html(" ");
        var cfcontent = $(obj).parent("td").find(".content123").val();
        $(".search-form-div1"). find(".content1").html(cfcontent);
        layerDiv('投诉内容',$('.search-form-div1').html(),'500px','300px');
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

    /*批量修改状态*/
    function state_modify(rs) {
        layer.confirm('确认要修改状态吗？', function (index) {
            var ids = "";
            if (rs == "all") {
                var checkedlist = $("input[name=\"ids[]\"]:checked");
                for (var i = 0; i < checkedlist.length; i++) {
                    ids += $(checkedlist[i]).val();
                    if (i < checkedlist.length - 1) ids += ",";
                }
            } else {
                ids = rs;
            }
            if (ids == "") {
                layer.msg('请选择要修改的数据!', { icon: 1, time: 1000 });
                return;
            }
            var index = layer.load({ shade: [0.5, '#fff'] });
            $.ajax({
                type: "post",
                url: "<?php echo U('complaint/status_modify');?>",
                data: {  ids: ids  },
                dataType: "json",
                success: function (e) {
                    if(e.status == 1){
                        layer.close(index);
                        layer.msg(e.info);
                        window.parent.location.reload();
                        window.localtion.herf = 'complaint/index_list';
                    }
                    if(e.status == 0){
                        layer.close(index);
                        layer.msg(e.info);
                    }
                },
                error: function (e) {
                    layer.close(index);
                    layer.alert('操作失败！');
                }
            });

        });
    }

</script>
</body>
</html>