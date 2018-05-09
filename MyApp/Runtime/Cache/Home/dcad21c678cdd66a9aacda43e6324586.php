<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>维修需求管理</title>
    <link rel="stylesheet" type="text/css" href="/Public/css/style.css"/>
    <script src="/Public/js/jquery2-1-4.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/layer/layer.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/htglxt.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/iframe.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/ajax-submit.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/js/My97DatePicker/WdatePicker.js"></script>
</head>
<body>
<h4>维修需求管理</h4>
<div class="toolsBar">
    <!--fgf为工具栏分隔符，刷新没有，离开都有。中间工具每一类第一个添加fgf-->
    <ul>
        <li onclick="reloadPage(window)">
            <img src="/Public/img/arrow_refresh.png"/>
            重置
        </li>
        <li class="fgf" onclick="layerDiv('查询',$('#search-form-div').html(),'500px','330px')">
            <img src="/Public/img/page_white_magnify.png"/>
            查询
        </li>
        <form action="<?php echo U('servicedemand/excel_order');?>" method="post"><input type="hidden" name="ids" id="ids1" value=""><li class="fgf" style="padding-bottom: 0"><button  type="submit"  style="border:none;background-color: inherit;" onclick="exceldaochu(&#39;all&#39;)" >
                <img src="/Public/img/excel_exports.png"/>Excel导出</button></li>
        </form>
    </ul>
</div>
<div class="tableCon">
    <div style="visibility: hidden;display: none;">
        <div id="search-form-div">
            <form action="/Servicedemand/index_list" method="post" id="search-form" class="layui-form">
                <div class="layerCon bg_f">
                    <table class="layerTable" border="0">
                        <tr class="h50">
                            <td><label for="sd_onlyid">订单号：</label></td>
                            <td>
                                <input id="sd_onlyid" type="text" name="sd_onlyid" value="<?php echo ($sd_onlyid); ?>" placeholder="请输入订单号"/>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td><label for="sc_uid">用户名称：</label></td>
                            <td>
                                <input id="sc_uid" type="text" name="uid_name" value="<?php echo ($uidname); ?>" placeholder="请输入用户名称"/>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td><label for="sd_phone">客户电话：</label></td>
                            <td>
                                <input id="sd_phone" type="text" name="sd_phone" value="<?php echo ($sd_phone); ?>" placeholder="请输入客户电话"/>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td><label for="sd_time">提交时间：</label></td>
                            <td>
                                开始时间： <input id="sd_time" type="text" class="Wdate" onFocus="WdatePicker({lang:'zh-cn'})"  name="sd_time1" value="<?php echo ($sdtime1); ?>"/>
                                结束时间： <input id="sd_time1" type="text" class="Wdate" onFocus="WdatePicker({lang:'zh-cn'})"  name="sd_time2" value="<?php echo ($sdtime2); ?>"/>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td><label for="sd_wxtype">维修类型：</label></td>
                            <td>
                                <select  id="sd_wxtype"  name="sd_wxtype">
                                    <option value="">=====无=====</option>
                                    <option value="10000" <?php if(($sdwxtype) == "10000"): ?>selected<?php endif; ?>>=====维修=====</option>
                                    <option value="20000" <?php if(($sdwxtype) == "20000"): ?>selected<?php endif; ?>>=====装修=====</option>
                                </select>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td><label for="sd_state">需求进度：</label></td>
                            <td>
                                <select  id="sd_state"  name="sd_state">
                                    <option value="">=====无=====</option>
                                    <option value="-1" <?php if(($sd_state) == "-1"): ?>selected<?php endif; ?>>=====取消订单=====</option>
                                    <option value="0" <?php if(($sd_state) == "0"): ?>selected<?php endif; ?>>=====新的需求=====</option>
                                    <option value="1" <?php if(($sd_state) == "1"): ?>selected<?php endif; ?>>=====已支付押金=====</option>
                                    <option value="9" <?php if(($sd_state) == "9"): ?>selected<?php endif; ?>>=====施工中=====</option>
                                    <option value="10" <?php if(($sd_state) == "10"): ?>selected<?php endif; ?>>=====暂停中=====</option>
                                    <option value="17" <?php if(($sd_state) == "17"): ?>selected<?php endif; ?>>=====申请完工=====</option>
                                    <option value="18" <?php if(($sd_state) == "18"): ?>selected<?php endif; ?>>=====验收不合格=====</option>
                                    <option value="20" <?php if(($sd_state) == "20"): ?>selected<?php endif; ?>>=====已完成=====</option>
                                    <option value="21" <?php if(($sd_state) == "21"): ?>selected<?php endif; ?>>=====拒绝=====</option>
                                </select>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td><label for="sd_tjtype">提交类型：</label></td>
                            <td>
                                <select  id="sd_tjtype"  name="sd_tjtype">
                                    <option value="">=====无=====</option>
                                    <option value="10000" <?php if(($sdtjtype) == "10000"): ?>selected<?php endif; ?>>====直接购买====</option>
                                    <option value="20000" <?php if(($sdtjtype) == "20000"): ?>selected<?php endif; ?>>====提交需求====</option>
                                    <option value="30000" <?php if(($sdtjtype) == "30000"): ?>selected<?php endif; ?>>====上门评估====</option>
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
                    <input class="va_m" type="checkbox" name="" id="allCheck" value="" data-falg="allCheck" onclick="checkBoxOp(this)"/>
                </th>
                <th width="40">ID</th>
                <th>订单号</th>
                <th>用户名称</th>
                <th>需维修名称</th>
                <th>客户电话</th>
                <th>客户姓名</th>
                <th>省 市 县</th>
                <th>客户地址</th>
                <th>提交时间</th>
                <th>需求进度</th>
                <th>是否自备材料</th>
                <th>维修大小</th>
                <th>单位价格</th>
                <th>维修总价</th>
                <th>维修类型</th>
                <th>提交类型</th>
                <th>用户取消理由</th>
                <th>师傅取消理由</th>
                <th>查看详情</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($servicedemand_info)): $i = 0; $__LIST__ = $servicedemand_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$info): $mod = ($i % 2 );++$i;?><tr>
                    <td>
                        <input class="va_m" type="checkbox" name="ids[]" value="<?php echo ($info["sd_id"]); ?>" onclick="checkBoxOp(this)" />
                    </td>
                    <td><?php echo ($info["sd_id"]); ?></td>
                    <td><?php echo ($info["sd_onlyid"]); ?></td>
                    <td><?php echo ($info["uid_name"]); ?></td>
                    <td><?php echo ($info["sd_weixiuname"]); ?></td>
                    <td><?php echo ($info["sd_phone"]); ?></td>
                    <td><?php echo ($info["sd_name"]); ?></td>
                    <td><?php echo ($info["sd_province"]); echo ($info["sd_city"]); echo ($info["sd_county"]); ?></td>
                    <td><?php echo ($info["sd_address"]); ?></td>
                    <td><?php echo (date('Y-m-d H:i',strtotime($info["sd_time"]))); ?></td>
                    <td><?php if(($info["sd_state"]) == "-2"): ?>已删除<?php endif; if(($info["sd_state"]) == "-1"): ?>订单已取消<?php endif; if(($info["sd_state"]) == "0"): ?>新的需求<?php endif; if(($info["sd_state"]) == "1"): ?>已支付押金<?php endif; if(($info["sd_state"]) == "2"): ?>已接单/等待客户签字<?php endif; if(($info["sd_state"]) == "3"): ?>赶赴工地/等待客户支付<?php endif; if(($info["sd_state"]) == "4"): ?>已支付<?php endif; if(($info["sd_state"]) == "5"): ?>等待支付下一阶段<?php endif; if(($info["sd_state"]) == "9"): ?>施工中<?php endif; if(($info["sd_state"]) == "10"): ?>暂停中<?php endif; if(($info["sd_state"]) == "17"): ?>申请完工<?php endif; if(($info["sd_state"]) == "18"): ?>验收不合格<?php endif; if(($info["sd_state"]) == "19"): ?>等待评论<?php endif; if(($info["sd_state"]) == "20"): ?>完成<?php endif; if(($info["sd_state"]) == "21"): ?>拒绝<?php endif; ?></td>
                    <td><?php if(($info["sd_material"]) == "1"): ?>用户自备材料<?php else: ?>师傅带材料<?php endif; ?></td>
                    <td><?php echo ($info["sd_count"]); ?></td>
                    <td><?php echo (number_format($info["sd_price"],2)); ?></td>
                    <td><?php echo (number_format($info["sd_repairtotal"],2)); ?></td>
                    <td><?php if(($info["sd_wxtype"]) == "10000"): ?>维修<?php else: ?>装修<?php endif; ?></td>
                    <td>
                        <?php if(($info["sd_tjtype"]) == "10000"): ?>直接购买<?php endif; ?>
                        <?php if(($info["sd_tjtype"]) == "20000"): ?>提交需求<?php endif; ?>
                        <?php if(($info["sd_tjtype"]) == "30000"): ?>上门评估<?php endif; ?>
                    </td>
                    <td>
                        <?php if(!empty($info["sd_userliyou"])): echo ($info["sd_userliyou"]); else: ?>暂无内容<?php endif; ?>
                    </td>
                    <td>
                        <?php if(!empty($info["sd_sgliyou"])): echo ($info["sd_sgliyou"]); else: ?>暂无内容<?php endif; ?>
                    </td>
                    <td><?php if(($info["sd_tjtype"]) == "10000"): ?><a class="table_btn button1" style="background-color: #00a0e9 !important;" title="详细" onclick="layerPage('施工需求详情','<?php echo U('modify',array('sd_id'=>$info['sd_id'],));?>','700px','580px')">施工需求详情</a><?php endif; ?>
                        <?php if(($info["sd_tjtype"]) == "20000"): if($info['sd_pguid'] != 0): if(in_array($info['sd_id'],$csdids)): ?><a class="table_btn button1" style="background-color: #00a0e9 !important;" title="详细" onclick="layerPage('施工需求详情','<?php echo U('detail',array('sd_id'=>$info['sd_id']));?>','700px','580px')">施工需求详情</a>
                                    <?php else: ?>
                                         <a class="table_btn button1" style="background-color: #fd2b37 !important;"  title="添加" onclick="layerPage('添加施工需求','<?php echo U('insert',array('sd_id'=>$info['sd_id']));?>','800px','575px')"><span>添加施工需求</span></a><?php endif; ?>
                                <?php else: ?>
                                          <a class="table_btn button1" style="background-color: #0a6999 !important;"  title="添加" onclick="layerPage('添加上门评估','<?php echo U('modifys_insert',array('sd_id'=>$info['sd_id']));?>','750px','480px')"><span>添加上门评估</span></a><?php endif; endif; ?>
                        <?php if(($info["sd_tjtype"]) == "30000"): if($info['sd_pguid'] != 0): if(in_array($info['sd_id'],$csdids)): ?><a class="table_btn button1" style="background-color: #00a0e9 !important;" title="详细" onclick="layerPage('施工需求详情','<?php echo U('detail',array('sd_id'=>$info['sd_id']));?>','700px','580px')">施工需求详情</a>
                                        <?php else: ?>
                                        <a class="table_btn button1" style="background-color: #fd2b37 !important;"  title="添加" onclick="layerPage('添加施工需求','<?php echo U('insert',array('sd_id'=>$info['sd_id']));?>','800px','575px')"><span>添加施工需求</span></a><?php endif; ?>
                               <?php else: ?>
                                          <a class="table_btn button1" style="background-color: #0a6999 !important;"  title="添加" onclick="layerPage('添加上门评估','<?php echo U('modifys_insert',array('sd_id'=>$info['sd_id']));?>','750px','480px')"><span>添加上门评估</span></a><?php endif; endif; ?>
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
    /*excel导出*/
    function exceldaochu(rs) {
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
            layer.msg('请选择要导出的数据!', { icon: 1, time: 1000 });
            return;
        }
        $("#ids1").val(ids);
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