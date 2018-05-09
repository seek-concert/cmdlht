//多选操作
function checkBoxOp(e){
	var op = $(".table input[type='checkbox']");//多选按钮集
	var isAll = $(e).attr("data-falg") == 'allCheck'?true:false;//是否全选按钮
	var isCheck = $(e).prop("checked");//是否选中
	if(isAll){//全选按钮
		if(isCheck){
			$(op).prop("checked","checked");
		}else{
			$(op).prop("checked","");
		}
	}else{//非全选按钮
		if(isCheck){
			var num = 0;
			for (var i = 0; i < op.length; i++) {
				if($(op).eq(i).prop("checked")){
					num += 1;
				}
			}
			if(num == op.length-1){
				$(op).eq(0).prop("checked","checked");
			}
		}else{
			$(op).eq(0).prop("checked","");
		}
	}
}

//layer询问层
function layerConfirm(cont){
	//询问框
	layer.confirm(cont, {
		skin: 'new-layer',
		title: '提示',
	  	btn: ['确定','取消'] //按钮
	}, function(index){
	  	layer.close(index);
	});
}
/*图片放大*/
function bigimg(obj){
    var width,
        height,
        imgsrc=obj.src,
        dom='<img style="width:99%;height:99%;" src="'+imgsrc+'"/>',
        imgobj=document.createElement('img');
    imgobj.src=imgsrc;

    width=document.body.clientWidth<imgobj.width?parseInt(document.body.clientWidth/1.05):imgobj.width;
    height=document.body.clientHeight<imgobj.height?parseInt(document.body.clientHeight/1.05):imgobj.height;

    layer.open({
        type:1,
        skin: 'layui-layer-nobg', //没有背景色
        area:[width+'px',height+'px'],//宽高
        fix:false,
        shadeClose:true,
        title:false,
        resize:true,
        content:dom
    });
}
//layer页面层
function layerDiv(tit,dom,width,height){
    layer.open({
        type: 1,
        skin: 'layui-layer-rim', //加上边框
        shadeClose: true, //开启遮罩关闭
        title: tit,
        area: [width, height],
        content: dom
    });
}

function layerwindow(tit,url) {
    var width=arguments[2]?arguments[2]:"800px",
        height=arguments[3]?arguments[3]:"450px",
        is_full=arguments[4]?arguments[4]:false;
    if(window.screen.width<1080 && parseInt(width)>=800){
        width='750px';
    }
    if(window.screen.height<1080 && parseInt(height)>450){
        height='450px';
    }
    var index=layer.open({
        type: 2,
        skin: 'new-layer',
        title: tit,
        shadeClose: false,
        shade: 0.5,
        maxmin: true, //开启最大化最小化按钮
        area: [width, height],
        content: [url, 'yes'], //iframe的url，no代表不显示滚动条
        yes: function(index,layero){
            layer.close(index);
        }
    });
    if(is_full){
        layer.full(index);
    }

}

//layer页面层
function layerPage(tit,url){
    var width=arguments[2]?arguments[2]:"800px",
        height=arguments[3]?arguments[3]:"450px",
        is_full=arguments[4]?arguments[4]:false;
    if(window.screen.width<1080 && parseInt(width)>=800){
        width='750px';
    }
    if(window.screen.height<1080 && parseInt(height)>450){
        height='450px';
    }
    var index=layer.open({
        type: 2,
        skin: 'new-layer',
        title: tit,
        shadeClose: false,
        shade: 0.5,
        maxmin: true, //开启最大化最小化按钮
        area: [width, height],
        content: [url, 'yes'], //iframe的url，no代表不显示滚动条
        yes: function(index,layero){
            layer.close(index);
        }
    });
    if(is_full){
        layer.full(index);
    }
}

//layer页面层2
function layerPage2(tit,url,width,height){
    layer.open({
        type: 2,
        skin: 'new-layer',
        title: tit,
        area: [width, height],
        content: [url],
        yes: function(index,layero){
            layer.close(index);
        }
    });
}

function loading(){
	
	layer.msg('玩命提示中');
}

$(function(){
	//关闭右键菜单
	$(document,'body').mousedown(function(event){
		parent.close_clickRight();
	});
	//设置table高度
	$(".tableCon").height($("body").height()-101);
	//table 点击背景
	$(".table td").click(function(){
		if(!$(this).find("input").hasClass("va_m")){
			$(this).addClass("on").siblings().addClass("on");
			$(this).parent().siblings().find("td").removeClass("on");
		}		
	});
	
	//拉伸时禁用复制
	document.onselectstart = function(event){
		if($(event.target).parents().hasClass("noSelect") || $(event.target).parent().hasClass("noSelect") || $(event.target).hasClass("xian")){
			return false
		}
	};
	
	//table拉伸
	var stretch = $(".table th .stretch");//拉伸点
	var xian = $(".tableCon>.xian");//对比线
	var oldX = 0,newX = 0;
	var oldW = 0,newW = 0;
	var this_ = null;
	for (var i = 0; i < stretch.length; i++) {//初始化设置th宽度最小40
		var thW = $(stretch).eq(i).parents("th").width() < 35?35:$(stretch).eq(i).parents("th").width();
		$(stretch).eq(i).parents("th").width(thW);
	}
	$(stretch).mousedown(function(event){
		this_ = this;
		oldW = $(this_).parents("th").width()-2;
		oldX = event.pageX;//拉伸前的th位置
		$(xian).css("left",event.pageX+"px").show();			
	});
	
	$("body").mousemove(function(event){
		newX = event.pageX;//拉伸后的th位置
		newW = newX - oldX + oldW;
		var xianX = $(this_).parents("th").offset() + 35;//宽度最小时线的位置
		if(newW < 35){
			$(xian).css("left",xianX+"px");
			newW = 35;
			if(newX < 30){
				$(this_).parents(".table").width($(this_).parents(".table").width() + newW - oldW);
				$(this_).parents("th").width(newW);
				$(xian).hide();
				this_ = null;
			}
		}else{
			$(xian).css("left",event.pageX+"px");
		}		
	});
	
	$("body").mouseup(function(event){
		$(this_).parents(".table").width($(this_).parents(".table").width() + newW - oldW);
		$(this_).parents("th").width(newW);
		$(xian).hide();
		this_ = null;
	});
	
	
	//首页TAB切换
	var tabs = $(".homeTab li");//首页TAB集
	var tabCon = $(".homeCon table");//首页TAB内容集
	$(tabs).each(function(index,e){
		$(e).click(function(){
			$(this).addClass("on").siblings().removeClass("on");
			$(tabCon).eq(index).addClass("on").siblings().removeClass("on");
		})
	});


    //tabs
    var tabsPage = $(".homeTab li");//TAB集
    var tabConPage = $(".homeCon .tabPage");//TAB内容集
    $(tabsPage).each(function(index,e){
        $(e).click(function(){
            $(this).addClass("on").siblings().removeClass("on");
            $(tabConPage).eq(index).addClass("on").siblings().removeClass("on");
        })
    })

});


