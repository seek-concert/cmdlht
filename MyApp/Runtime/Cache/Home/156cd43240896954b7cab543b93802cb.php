<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
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
<h4>商家列表</h4>
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
        <li class="fgf" onclick="layerPage('注册商家折线统计图','<?php echo U('statistics');?>','750px','520px')">
            <img src="/Public/img/chart_bar.png"/>
            统计
        </li>
    </ul>
</div>
<div class="tableCon">
    <div style="visibility: hidden;display: none;">
        <div id="search-form-div">
            <form action="/Recommender/index_list" method="post" id="search-form" class="layui-form">
                <div class="layerCon bg_f">
                    <table class="layerTable" border="0">
                        <tr class="h50">
                            <td><label for="u_loginname"> 登陆账号：</label></td>
                            <td>
                                <input id="u_loginname" type="text" name="u_loginname" value="<?php echo ($uloginname); ?>" placeholder="请输入登陆账号"/>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td><label for="u_shopname">店铺名称：</label></td>
                            <td>
                                <input id="u_shopname" type="text" name="u_shopname" value="<?php echo ($u_shopname); ?>" placeholder="请输入店铺名称"/>
                            </td>
                        </tr>
                        <tr class="h50">
                            <td><label>注册时间：</label></td>
                            <td>
                                开始时间：<input type="text" class="Wdate" onFocus="WdatePicker({lang:'zh-cn'})"
                                            name="u_time1" value="<?php echo ($utime1); ?>"/>
                                结束时间：<input type="text" class="Wdate" onFocus="WdatePicker({lang:'zh-cn'})"
                                            name="u_time2" value="<?php echo ($utime2); ?>"/>
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
                <th width="40">ID</th>
                <th>推荐图片</th>
                <th>头像</th>
                <th>唯一编号</th>
                <th>登陆账号</th>
                <th>电话</th>
                <th>店铺名称</th>
                <th>昵称</th>
                <th>注册时间</th>
                <th>账号状态</th>
                <th>用户等级</th>
                <th>余额</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($userinfo_info)): $i = 0; $__LIST__ = $userinfo_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$info): $mod = ($i % 2 );++$i;?><tr>
                    <td><?php echo ($info["u_id"]); ?></td>
                    <td><img src="<?php echo ($info["rlogo"]); ?>" alt="暂无资源" width="100px" height="100px"></td>
                    <td><img src="<?php echo ($info["u_favicon"]); ?>" alt="暂无资源" width="100px" height="100px"></td>
                    <td><?php echo ($info["u_number"]); ?></td>
                    <td><?php echo ($info["u_loginname"]); ?></td>
                    <td><?php echo ($info["u_phone"]); ?></td>
                    <td><?php if(empty($info["u_shopname"])): ?>暂未填写<?php endif; echo ($info["u_shopname"]); ?></td>
                    <td><?php echo ($info["u_nickname"]); ?></td>
                    <td><?php echo (date('Y-m-d H:i',strtotime($info["u_time"]))); ?></td>
                    <td>
                        <?php if(($info["u_state"]) == "1"): ?><a data-action="<?php echo U('modify_state');?>"
                               data-msg="您确定要更改状态吗？" title="启用" class="table_btn button1 js-ajax-form-btn"
                               data-formdata="uid=<?php echo ($info['u_id']); ?>&ustate=<?php echo ($info['u_state']); ?>">启用</a>
                            <?php else: ?>
                            <a data-action="<?php echo U('modify_state');?>"
                               data-msg="您确定要更改状态吗？" title="停用" class="table_btn button1 js-ajax-form-btn"
                               data-formdata="uid=<?php echo ($info['u_id']); ?>&ustate=<?php echo ($info['u_state']); ?>">停用</a><?php endif; ?>
                    </td>
                    <td><?php echo ($info["u_level"]); ?></td>
                    <td><?php echo (number_format($info["u_money"],2)); ?></td>
                    <td>
                        <?php if(in_array($info['u_id'],$uidids)): ?><input type="button" value="已推荐"> | <input type="button" value="取消推荐" onclick="delrecommender(this)"><?php else: ?><a class="table_btn" title="详细"
                                                                                  onclick="layerPage('推荐商家','<?php echo U('recommender/insert',array('u_id'=>$info['u_id']));?>','700px','440px')"><input type="button" value="推荐商家"></a><?php endif; ?>

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
    /*取消推荐*/
    function delrecommender(obj) {
        var uid = $(obj).parents("tr").find("td").eq(0).html();
       $.ajax({
           type:"post",
           url:"<?php echo U('del_recommender');?>",
           data:{ 'r_uid':uid },
           dataType:"json",
           success:function(e){
               if (e.status == 1) {
                   layer.msg(e.info);
                   window.location.reload();
               }
               if (e.status == 0) {
                   layer.msg(e.info);
               }
           },
           error:function () {
               layer.alert("操作失败！");
           }
       })
    }
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
<input type="hidden" id="hid_ids"  />
</body>
</html>