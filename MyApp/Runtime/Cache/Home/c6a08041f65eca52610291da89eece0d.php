<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="/Public/css/style.css"/>
</head>
<body>
<form action="<?php echo U('insert');?>" method="post" class="js-ajax-form">
    <div class="layerCon bg_f">
        <table class="layerTable" border="0">
            <tr class="h50">
                <td>上上级名称：</td>
                <td colspan="5">
                    <select id="pidname2">
                        <option value="0">====无上级====</option>
                        <?php if(is_array($pidname2)): $i = 0; $__LIST__ = $pidname2;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pidnames2): $mod = ($i % 2 );++$i;?><option value="<?php echo ($pidnames2["pt_id"]); ?>"><?php echo ($pidnames2["pt_receptionname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </td>
                <td>上级名称：</td>
                <td colspan="5">
                    <select name="pt_superior" id="ptsuperior">
                        <option value="0">====无上级====</option>
                        <?php if(is_array($pidname2)): $i = 0; $__LIST__ = $pidname2;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pidnames2): $mod = ($i % 2 );++$i;?><option value="<?php echo ($pidnames2["pt_id"]); ?>"><?php echo ($pidnames2["pt_receptionname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </td>
            </tr>
            <tr class="h50">
                <td>前台名称：</td>
                <td colspan="5">
                    <input class="must" type="text" name="pt_receptionname" id="" value=""  placeholder="请输入前台名称"/>
                </td>
                <td>状态：</td>
                <td colspan="5">
                    <select name="pt_state">
                        <option value="1">启用</option>
                        <option value="0">停用</option>
                    </select>
                </td>
            </tr>
            <tr class="h50">
                <td>排序：</td>
                <td colspan="5">
                    <input class="must" type="text" name="pt_order" id="" value="0" placeholder="请输入排序" />
                </td>
                <td>标语：</td>
                <td colspan="5">
                    <input class="must" type="text" name="pt_backstagename" id="" value="" placeholder="请输入标语"/>
                </td>
            </tr>
            <tr class="h50">
                <td>PC图片地址：</td>
                <td colspan="11">
                    <input type="text" name="pt_pcimg" id="" value=""  placeholder="请输入图片地址，如http://xxx.com/xxxx.png"/>
                </td>
            </tr>
            <tr class="h50">
                <td>类型图片：</td>
                <td colspan="11">
                    <label style="display:inline-block;">
                        <input type="radio" value="1"   style="width: 15px;height: 15px;" name="pt_img1"  onclick="displaytypes(this)"/>
                        <a  style="display: inline-block !important;" onclick="displaytypes()">填写图标地址</a></label>
                    <label style="display:inline-block;">
                        <input type="radio" value="2"   style="width: 15px;height: 15px;" name="pt_img1"  onclick="displaytypes(this)" checked/>
                        <a  style="display: inline-block !important;"  onclick="displaytypes()" >选择图片</a></label>
                </td>
            </tr>
        </table>
              <div  class="search-form-div" style="display: none;">
                  <table class="layerTable" border="0">
                      <tr class="h50">
                          <td>图标地址：</td>
                          <td>
                              <input class="must" type="text" name="pt_img" id="ptimg" value=""  placeholder="请输入图标地址，如http://xxx.com/xxxx.png"/>
                          </td>
                      </tr>
                        <tr class="h50">
                            <td>图标颜色：</td>
                            <td><input type="text" name="pt_color" value="" class="ptcolor" id="nowColor" />
                                <div id="pageColorViews" style="background:#000; width:30px; height:30px;"></div>
                                <a href="javascript:;" onclick="colorSelect('nowColor','pageColorViews',event)">点击选择颜色</a></td>
                        </tr>
                </table>
               </div>
                <div  class="search-form-div2" style="display: none;">
                    <table class="layerTable" border="0">
                        <tr class="h50">
                            <td>选择图标(单图上传)：</td>
                            <td>
                                <form enctype="multipart/form-data" method="post" class="img1">
                                    <div class="imgCon " colspan="5" style="position: relative;height: 80px;width: 80px;">
                                        <div class="uopImg upBtn upload-btn-a" data-type="avatar" data-is_edit="1" data-inited="1">
                                            <img src="/Public/img/addimg.png" width="80px;" height="80px;" style="float: left;">
                                            <input class="upload-input uploadFile" type="file" size="100" name="upload_file"
                                                   onchange="uploadImage(this);">
                                        </div>
                                    </div>
                                </form>

                                <div class="imgadd" id="u_favicon"></div>
                            </td>
                        </tr>

                    </table>
                </div>
        <span style="color: red;">温馨提示：只选择上级名称时，则填写的名称为第二级；同时选择上上级名称和上级名称时，则填写的名称为第三级。</span>
    </div>
    <div class="layerBtns">
        <a class="btn js-ajax-form-btn layui-btn" data-layer="true" >提交</a>
    </div>
</form>
<script src="/Public/js/jquery2-1-4.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/layer/layer.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/js/htglxt.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/js/iframe.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/js/jquery.treetable.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/js/ajax-submit.js"></script>
<script>
    /*根据第一级显示第二级的内容*/
    $("#pidname2").change(function (){
        var pt_id = $("#pidname2").val();
        if(pt_id=="0"){
            $('#ptsuperior').html("<option value='0'>====无上级====</option><?php if(is_array($pidname2)): $i = 0; $__LIST__ = $pidname2;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pidnames2): $mod = ($i % 2 );++$i;?><option value='<?php echo ($pidnames2["pt_id"]); ?>'><?php echo ($pidnames2["pt_receptionname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>");
            return;
        }
        $.ajax({
            type:"post",
            url:"<?php echo U('index/search_ptsuperior');?>",
            data:{pt_id:pt_id},
            dataType:"json",
            success:function(data){
                $('#ptsuperior').html(data);
            }
        });
    });
    function colorSelect(now,page,e){
        if(document.getElementById("colorBoard")){
            return;
        }
       /* //关于出现位置*/
        e=e||event;
        var scrollpos = getScrollPos();
        var l = scrollpos.l + e.clientX;
        var t = scrollpos.t + e.clientY + 10;
        if (l > getBody().clientWidth-253){
            l = getBody().clientWidth-253;
        }
      /*  //创建DOM*/
        var nowColor = document.getElementById(now);
        var pageColorViews = document.getElementById(page);
        var ColorHex=new Array('00','33','66','99','CC','FF');
        var SpColorHex=new Array('FF0000','00FF00','0000FF','FFFF00','00FFFF','FF00FF');
        var colorBank = document.createElement("div");
        colorBank.setAttribute("id","colorBank");
        var colorViews = document.createElement("div");
        colorViews.setAttribute("id","colorViews");
        var colorInput = document.createElement("input");
        colorInput.setAttribute("id","colorInput");
        colorInput.setAttribute("type","text");
        colorInput.setAttribute("disabled","disabled");
        var colorClose = document.createElement("input");
        colorClose.setAttribute("id","colorClose");
        colorClose.setAttribute("value","取消");
        colorClose.setAttribute("type","button");
        colorClose.onclick=function(){document.body.removeChild(colorBoard)};
        var colorBoard =document.createElement("div");
        colorBoard.id="colorBoard";
        colorBoard.style.left = l+"px";
        colorBoard.style.top = t+ "px";
        colorBoard.appendChild(colorViews);
        colorBoard.appendChild(colorInput);
        colorBoard.appendChild(colorClose);
        colorBoard.appendChild(colorBank);
        document.body.appendChild(colorBoard);
        //循环出调色板
        for(b=0;b<6;b++){
            for(a=0;a<3;a++){
                for(i=0;i<6;i++){
                    colorItem = document.createElement("div");
                    colorItem.style.backgroundColor="#"+ColorHex[a]+ColorHex[i]+ColorHex[b];
                    colorBank.appendChild(colorItem);
                }
            }
        }
        for(b=0;b<6;b++){
            for(a=3;a<6;a++){
                for(i=0;i<6;i++){
                    colorItem = document.createElement("div");
                    colorItem.style.backgroundColor="#"+ColorHex[a]+ColorHex[i]+ColorHex[b];
                    colorBank.appendChild(colorItem);
                }
            }
        }
        for(i=0;i<6;i++){
            colorItem = document.createElement("div");
            colorItem.style.backgroundColor="#"+ColorHex[0]+ColorHex[0]+ColorHex[0];
            colorBank.appendChild(colorItem);
        }
        for(i=0;i<6;i++){
            colorItem = document.createElement("div");
            colorItem.style.backgroundColor="#"+ColorHex[i]+ColorHex[i]+ColorHex[i];
            colorBank.appendChild(colorItem);
        }
        for(i=0;i<6;i++){
            colorItem = document.createElement("div");
            colorItem.style.backgroundColor="#"+SpColorHex[i];
            colorBank.appendChild(colorItem);
        }
        var colorItems = colorBank.getElementsByTagName("div");
        for(i=0; i<colorItems.length;i++){
            colorItems[i].onmouseover = function(){
                a = this.style.backgroundColor;
                if(a.length>7){
                    a = formatRgb(a);//
                }
                colorViews.style.background = a.toUpperCase();
                colorInput.value = a.toUpperCase();
            }
            colorItems[i].onclick = function(){
                a = this.style.backgroundColor;
                if(a.length>7){
                    a = formatRgb(a);//
                }
                nowColor.value = a.toUpperCase();
                pageColorViews.style.background = a.toUpperCase();
                document.body.removeChild(colorBoard);
            }
        }
    }
  /*  //格式化函数*/
    function formatRgb(rgb){
        rgb = rgb.replace("rgb","");rgb = rgb.replace("(","");rgb = rgb.replace(")","");
        format = rgb.split(",");
        a = eval(format[0]).toString(16);
        b = eval(format[1]).toString(16);
        c = eval(format[2]).toString(16);
        rgb = "#"+checkFF(a)+checkFF(b)+checkFF(c);
        function checkFF(str){
            if(str.length == 1){
                str = str+""+str;
                return str;
            }else{
                return str;
            }
        }
        return rgb;
    }
  /*  //getBody()*/
    function getBody(){
        var Body;
        if (typeof document.compatMode != 'undefined' && document.compatMode != 'BackCompat') {
            Body = document.documentElement;
        }
        else if (typeof document.body != 'undefined') {
            Body = document.body;
        }
        return Body;
    }
   /* //scrollPos*/
    function getScrollPos(){
        var t,l;
        if (typeof window.pageYOffset != 'undefined'){
            t = window.pageYOffset;
            l = window.pageXOffset;
        }
        else{
            t = getBody().scrollTop;
            l = getBody().scrollLeft;
        }
        return {t:t,l:l};
    }
    /*图片上传-预览*/
    function uploadImage(obj) {
        /*判断是否有选择上传文件*/
        var imgPath = obj.files;
        /* console.log(imgPath);*/
        if (!imgPath.length) {
            layer.msg('请选择需要上传的图片!', {icon: 1, time: 1000});
            return;
        }

        var parent_obj = $(obj).parents('td'),
            addimgs = parent_obj.find('.imgadd');
        /*判断图片的张数*/
        var ufavicon = $(obj).parents('td').find("#u_favicon").find('img').length;
        if(ufavicon>=1){
            layer.msg('图片只能上传一张!', {icon: 1, time: 1000});
            return;
        }
        var ccccc = new FormData();
        ccccc.append('upload_file', imgPath[0]);
        $.ajax({
            type: "POST",
            url: "<?php echo U('banner/ajaxupload');?>",
            data: ccccc,
            processData: false,
            contentType: false,
            success: function (data) {
                addimgs.append("<input name='pt_img' id='pt_img' type='hidden' value='"+data.url+"'><img src='" + data.url + "'   width='80px;' height='80px;'  style='margin-top:-80px;'><img src='/Public/img/trash.png' class='delthis' style='margin-right:2px;'><input name='pt_color' id='pt_color' type='hidden' value=''> ");
                layer.msg(data.info, {icon: 1, time: 1000});
            },
            error: function (e) {
                layer.msg(e.info, {icon: 1, time: 1000});
            }
        });
    };
    /*删除预览图片*/
    $(".imgadd").on("click", '.delthis', function () {
        $(this).prev().remove();
        $(this).next().remove();
        $(this).remove();
        $("#pt_img").remove();
        $("#pt_color").remove();
    });

    /*打开页面执行*/
    window.onload=function(){
        displaytypes(this);
    };
    /*选中类型---显示*/
    function displaytypes(obj) {
        var ptimg = $("input[name=pt_img1]:checked").val();
        if (ptimg == 1) {
            $(".search-form-div").show();
            $(".search-form-div2").hide();
            $("#ptimg").attr("name","pt_img");
            $(".ptcolor").attr("name","pt_color");
            $("#pt_img").attr("name","pt_img1");
            $("#pt_color").attr("name","pt_color1");
        }
        if (ptimg == 2) {
            $(".search-form-div2").show();
            $(".search-form-div").hide();
            $("#ptimg").attr("name","pt_img1");
            $(".ptcolor").attr("name","pt_color1");
            $("#pt_img").attr("name","pt_img");
            $("#pt_color").attr("name","pt_color");
        }
    };
</script>
</body>
</html>