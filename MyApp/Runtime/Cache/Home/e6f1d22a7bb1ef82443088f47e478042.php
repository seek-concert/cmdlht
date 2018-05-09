<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>崇迈装饰APP代理后台管理系统</title>
	<link rel="stylesheet" type="text/css" href="/Public/css/style.css"/>
	<script src="/Public/js/jquery2-1-4.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="/Public/js/htglxt.js" type="text/javascript" charset="utf-8"></script>
	<link href="/Public/favicon.ico" type="image/x-icon" rel="shortcut icon" />
</head>
<body style="min-width: 1000px;">
<!--头部-->
<div class="header w_100 bg_black">
	<img class="h50 mt10 ml10" src="/Public/img/logo.png"/>
	<ul class="fr f12 nav">
		<li>
			<a href="<?php echo U('home/index');?>">
				<img src="/Public/img/n1.png"/>
				系统首页
			</a>
		</li>
		<li>
			<a data-tit="修改密码" data-src='<?php echo U("index/modifypwd");?>' onclick="leftSubNavManage(this,event)">
				<img src="/Public/img/n3.png"/>
				修改密码
			</a>
		</li>
		<li>
			<a data-tit="个人中心" data-src='<?php echo U("index/PersonalCenter");?>' onclick="leftSubNavManage(this,event)">
				<img src="/Public/img/n5.png"/>
				个人中心
			</a>
		</li>
		<li>
			<a data-tit="清除后台缓存"  onclick="deletecache()">
				<img src="/Public/img/n2.png"/>
				清除后台缓存
			</a>
		</li>
		<li>
			<a href="<?php echo U('index/logout');?>">
				<img src="/Public/img/n4.png"/>
				安全退出
			</a>
		</li>
	</ul>
</div>
<!--tab导航-->
<div class="tabHeader ov bg_f5">
	<div class="fl left f12 tc">
		<span id=localtime></span></div>
	<div class="ov h_100">
		<ul class="tabNav h30 mt5 f12 fl">
			<li class="on" data-tit="欢迎首页" data-src="<?php echo U('welcome');?>" onmousedown="tabManage(this,event)">
				<img src="/Public/img/house.png"/>
				欢迎首页
			</li>
		</ul>
		<ul class="clickRight bg_f">
			<li onclick="refreshIframe()">刷新当前</li>
			<li onclick="closeIframe()">关闭当前</li>
			<li onclick="closeIframeAll()">全部关闭</li>
			<li onclick="closeIframeAllOne()">除此之外全部关闭</li>
			<li onclick="close_clickRight()">退出</li>
		</ul>
	</div>
</div>
<!--主体内容-->
<div class="content bg_f5" id="menu">
	<!--左边导航-->
	<div class="leftNav ov">
		<!--一级导航-->
	<ul class="leftNav_1 ov f12">
		<li onclick="leftNavToggle(this)">
			<div class="link">
				<img src="/Public/img/group_gear.png">
				用户记录管理					<i></i>
			</div>
			<!--二级导航-->
			<ul class="leftNav_2 bg_f">
				<li data-tit="用户管理" data-src="/index.php/userinfo/index_list.html" onclick="leftSubNavManage(this,event)">
					<div class="link">
						<img src="/Public/img/monitor_window_3d.png">
						用户管理								</div>
				</li><li data-tit="用户审核管理" data-src="/index.php/reviewedhistory/index_list.html" onclick="leftSubNavManage(this,event)">
				<div class="link">
					<img src="/Public/img/monitor_window_3d.png">
					用户审核管理								</div>
				</li><li data-tit="投诉记录" data-src="/index.php/complaint/index_list.html" onclick="leftSubNavManage(this,event)">
					<div class="link">
						<img src="/Public/img/monitor_window_3d.png">
						投诉记录								</div>
				</li><li data-tit="意见反馈" data-src="/index.php/feedback/index_list.html" onclick="leftSubNavManage(this,event)">
					<div class="link">
						<img src="/Public/img/monitor_window_3d.png">
						意见反馈								</div>
				</li><li data-tit="查看系统通知" data-src="/index.php/notice/index_list.html" onclick="leftSubNavManage(this,event)">
					<div class="link">
						<img src="/Public/img/monitor_window_3d.png">
						查看系统通知							</div>
				</li>
			</ul>

		</li>
	</ul><ul class="leftNav_1 ov f12">
		<li onclick="leftNavToggle(this)">
			<div class="link">
				<img src="/Public/img/chart_pie.png">
				维修装修管理					<i></i>
			</div>
			<!--二级导航-->
			<ul class="leftNav_2 bg_f">
				<li data-tit="维修类型管理" data-src="/index.php/repairtype/index_list.html" onclick="leftSubNavManage(this,event)">
					<div class="link">
						<img src="/Public/img/monitor_window_3d.png">
						维修类型管理								</div>
				</li>
				<li data-tit="维修需求管理" data-src="/index.php/servicedemand/index_list.html" onclick="leftSubNavManage(this,event)">
				<div class="link">
					<img src="/Public/img/monitor_window_3d.png">
					维修需求管理								</div>
				</li>
				<li data-tit="装修报价类型" data-src="/index.php/quotationcontent/index_list.html" onclick="leftSubNavManage(this,event)">
				<div class="link">
					<img src="/Public/img/monitor_window_3d.png">
					装修报价类型								</div>
				</li>
			</ul>

		</li>
	</ul><ul class="leftNav_1 ov f12">
		<li onclick="leftNavToggle(this)">
			<div class="link">
				<img src="/Public/img/bricks.png">
				产品管理					<i></i>
			</div>
			<!--二级导航-->
			<ul class="leftNav_2 bg_f">
				<li data-tit="品牌管理" data-src="/index.php/brand/index_list.html" onclick="leftSubNavManage(this,event)">
					<div class="link">
						<img src="/Public/img/monitor_window_3d.png">
						品牌管理								</div>
				</li><li data-tit="产品类型" data-src="/index.php/producttype/index_list.html" onclick="leftSubNavManage(this,event)">
				<div class="link">
					<img src="/Public/img/monitor_window_3d.png">
					产品类型								</div>
			</li><li data-tit="产品管理" data-src="/index.php/product/index_list.html" onclick="leftSubNavManage(this,event)">
				<div class="link">
					<img src="/Public/img/monitor_window_3d.png">
					产品管理								</div>
			</li><li data-tit="单位管理" data-src="/index.php/company/index_list.html" onclick="leftSubNavManage(this,event)">
				<div class="link">
					<img src="/Public/img/monitor_window_3d.png">
					单位管理								</div>
			</li><li data-tit="产品审核管理" data-src="/index.php/product/index.html" onclick="leftSubNavManage(this,event)">
				<div class="link">
					<img src="/Public/img/monitor_window_3d.png">
					产品审核管理								</div>
			</li>					</ul>

		</li>
	</ul><ul class="leftNav_1 ov f12">
		<li onclick="leftNavToggle(this)">
			<div class="link">
				<img src="/Public/img/application_view_detail.png">
				订单管理					<i></i>
			</div>
			<!--二级导航-->
			<ul class="leftNav_2 bg_f">
				<li data-tit="订单评价管理" data-src="/index.php/productevaluation/index_list.html" onclick="leftSubNavManage(this,event)">
					<div class="link">
						<img src="/Public/img/monitor_window_3d.png">
						订单评价管理								</div>
				</li><li data-tit="产品订单管理" data-src="/index.php/productorder/index_list.html" onclick="leftSubNavManage(this,event)">
				<div class="link">
					<img src="/Public/img/monitor_window_3d.png">
					产品订单管理								</div>
			</li><li data-tit="系统接单管理" data-src="/index.php/systemorders/index.html" onclick="leftSubNavManage(this,event)">
				<div class="link">
					<img src="/Public/img/monitor_window_3d.png">
					系统接单管理								</div>
			</li><li data-tit="订单物流管理" data-src="/index.php/dingyueliucheng/index_list.html" onclick="leftSubNavManage(this,event)">
				<div class="link">
					<img src="/Public/img/monitor_window_3d.png">
					订单物流管理								</div>
			</li>					</ul>

		</li>
	</ul><ul class="leftNav_1 ov f12">
		<li onclick="leftNavToggle(this)">
			<div class="link">
				<img src="/Public/img/insert_element.png">
				结账支付管理					<i></i>
			</div>
			<!--二级导航-->
			<ul class="leftNav_2 bg_f">
				<li data-tit="支付记录" data-src="/index.php/pay/index_list.html" onclick="leftSubNavManage(this,event)">
					<div class="link">
						<img src="/Public/img/monitor_window_3d.png">
						支付记录								</div>
				</li><li data-tit="提现记录" data-src="/index.php/tixian/index_list.html" onclick="leftSubNavManage(this,event)">
				<div class="link">
					<img src="/Public/img/monitor_window_3d.png">
					提现记录								</div>
			</li><li data-tit="结账记录" data-src="/index.php/jzrecording/index_list.html" onclick="leftSubNavManage(this,event)">
				<div class="link">
					<img src="/Public/img/monitor_window_3d.png">
					结账记录								</div>
			</li>					</ul>

		</li>
	</ul>
		<ul class="leftNav_1 ov f12">
			<li onclick="leftNavToggle(this)">
				<div class="link">
					<img src="/Public/img/database_table.png">
					案例管理					<i></i>
				</div>
				<!--二级导航-->
				<ul class="leftNav_2 bg_f">
					<li data-tit="案例类型" data-src="/index.php/renovationtype/index_list.html" onclick="leftSubNavManage(this,event)">
						<div class="link">
							<img src="/Public/img/monitor_window_3d.png">
							案例类型								</div>
					</li><li data-tit="案例管理" data-src="/index.php/renovation/index_list.html" onclick="leftSubNavManage(this,event)">
					<div class="link">
						<img src="/Public/img/monitor_window_3d.png">
						案例管理								</div>
				</li>					</ul>

			</li>
		</ul><ul class="leftNav_1 ov f12">
		<li onclick="leftNavToggle(this)">
			<div class="link">
				<img src="/Public/img/user_edit.png">
				施工队管理					<i></i>
			</div>
			<!--二级导航-->
			<ul class="leftNav_2 bg_f">
			<li data-tit="施工评价管理" data-src="/index.php/constructionevaluation/index_list.html" onclick="leftSubNavManage(this,event)">
				<div class="link">
					<img src="/Public/img/monitor_window_3d.png">
					施工评价管理								</div>
			</li><li data-tit="施工队列表" data-src="/index.php/construction/index_list.html" onclick="leftSubNavManage(this,event)">
				<div class="link">
					<img src="/Public/img/monitor_window_3d.png">
					施工队列表								</div>
			</li>					</ul>

		</li>
	</ul><ul class="leftNav_1 ov f12">
		<li onclick="leftNavToggle(this)">
			<div class="link">
				<img src="/Public/img/folder_user.png">
				服务商管理					<i></i>
			</div>
			<!--二级导航-->
			<ul class="leftNav_2 bg_f">
				<li data-tit="服务商列表" data-src="/index.php/recommender/index_list.html" onclick="leftSubNavManage(this,event)">
					<div class="link">
						<img src="/Public/img/monitor_window_3d.png">
						服务商列表								</div>
				</li>					</ul>

		</li>
	</ul>
	</div>
	<!--iframe-->
	<div class="rightIframe">
		<div class="rightIframeCon">
			<iframe src="<?php echo U('welcome');?>" class="iframe homeIframe on"></iframe>
		</div>
	</div>
</div>
<!--底部-->
<div class="footer f12 cr_f h25 lh25 w_100 bg_black ov">
	<div class="pd0_5">技术支持：步联科技有限公司</div>
	<div class="tc">CopyRight © 2017 - <?php echo date('Y');?> By Bulian</div>
	<div class="ov right">
		<a href="javascript:void(0)"  data-tit="系统接单管理" data-src="<?php echo U('systemorders/index');?>" onclick="leftSubNavManage(this,event)" >
			<img src="/Public/img/youjian.png"/><em class="inum3"></em>
		</a>
		<a href="javascript:void(0)" data-tit="产品消息" data-src="<?php echo U('index/productnotice');?>" onclick="leftSubNavManage(this,event)" >
			<img src="/Public/img/bottom_icon_message.png"/><em class="inum2"></em>
		</a>
		<a href="javascript:void(0)" data-tit="消息列表" data-src="<?php echo U('index/notice');?>" onclick="leftSubNavManage(this,event)">
			<img src="/Public/img/bottom_icon_usergroup.png"/><em class="inum1"></em>
		</a>
		<a href="javascript:void(0)">
			<img src="/Public/img/bottom_icon_userinfo.png"/>
		</a>
	</div>
</div>
<script type="text/javascript">
    /*时间更新*/
    function showLocale(objD){
        var str,colorhead,colorfoot;
        var yy = objD.getYear();
        if(yy<1900) yy = yy+1900;
        var MM = objD.getMonth()+1;
        if(MM<10) MM = '0' + MM;
        var dd = objD.getDate();
        if(dd<10) dd = '0' + dd;
        var hh = objD.getHours();
        if(hh<10) hh = '0' + hh;
        var mm = objD.getMinutes();
        if(mm<10) mm = '0' + mm;
        var ss = objD.getSeconds();
        if(ss<10) ss = '0' + ss;
        var ww = objD.getDay();
        if  ( ww==0 )  colorhead="<font color=\"#000000\">";
        if  ( ww > 0 && ww < 6 )  colorhead="<font color=\"#000000\">";
        if  ( ww==6 )  colorhead="<font color=\"#000000\">";
        if  (ww==0)  ww="星期日";
        if  (ww==1)  ww="星期一";
        if  (ww==2)  ww="星期二";
        if  (ww==3)  ww="星期三";
        if  (ww==4)  ww="星期四";
        if  (ww==5)  ww="星期五";
        if  (ww==6)  ww="星期六";
        colorfoot="</font>";
        str = colorhead + yy + "-" + MM + "-" + dd + " " + hh + ":" + mm + ":" + ss + "  " + ww + colorfoot;
        return(str);
    }
    function tick(){
        var today;
        today = new Date();
        document.getElementById("localtime").innerHTML = showLocale(today);
        window.setTimeout("tick()", 1000);
    }
    tick();

    /*清理后台缓存*/
    function deletecache(){
        $.ajax({
            type: "get",
            url: "<?php echo U('Index/delete_cache');?>",
            data:"",
            dataType: "json",
            success: function (rs) {
                if (rs.status == 1) {
                    alert(rs.info);
                }
            },
            error: function () {
                alert('操作失败！');
            }
        });
    }

    /*用户消息提示*/
    function notice() {
        $.ajax({
            type: "get",
            url: "<?php echo U('home/notices');?>",
            data:"",
            dataType: "json",
            success: function (e){
                if (e.status == 1) {
                    if(e.datas>0){
                        $(".inum1").html(e.datas);
                    }else{
                        $(".inum1").html("");
                    }

                }
            }
        });
        window.setTimeout("notice()", 30000);
    }
    notice();

    /*用户闪动效果*/
    function notices() {
        $(".inum1").fadeToggle( 500, function(){
            $(".inum1").show();
        });
        window.setTimeout("notices()", 500);
    }
    notices();

    /*产品消息提示*/
    function productnotice() {
        $.ajax({
            type: "get",
            url: "<?php echo U('index/productnotices');?>",
            data:"",
            dataType: "json",
            success: function (data){
                if (data.status == 1) {
                    if(data.datas>0){
                        $(".inum2").html(data.datas);
                    }else{
                        $(".inum2").html("");
                    }

                }
            }
        });

        window.setTimeout("productnotice()", 30000);
    }
    productnotice();

    /*产品闪动效果*/
    function productnotices() {
        $(".inum2").fadeToggle( 500, function(){
            $(".inum2").show();
        });
        window.setTimeout("productnotices()", 500);
    }
    productnotices();

    /*系统接单提示*/
    function systemordersnotice() {
        $.ajax({
            type: "get",
            url: "<?php echo U('index/systemordersnotices');?>",
            data:"",
            dataType: "json",
            success: function (data){
                if (data.status == 1) {
                    if(data.datas>0){
                        $(".inum3").html(data.datas);
                    }else{
                        $(".inum3").html("");
                    }

                }
            }
        });

        window.setTimeout("systemordersnotice()", 30000);
    }
    systemordersnotice();

    /*系统接单闪动效果*/
    function systemordersnotices() {
        $(".inum3").fadeToggle( 500, function(){
            $(".inum3").show();
        });
        window.setTimeout("systemordersnotices()", 500);
    }
    systemordersnotices();
</script>
</body>
</html>