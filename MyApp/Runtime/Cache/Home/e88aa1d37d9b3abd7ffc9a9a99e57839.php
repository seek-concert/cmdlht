<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="/Public/css/style.css"/>
    <link type="text/css" rel="stylesheet" href="/Public/css/liandong.css">
</head>
<body>
    <div  id="navtab1" style="width: 1000px;  margin-top: -36px;">
                <div position="center">
                    <table class="layerTable" border="0">
                        <tr class="h30">
                            <td>产品名称：</td>
                            <td>
                                <input class="must" type="text" name="p_name" id="pnametxt" value=""  placeholder="请输入产品名称"/>
                            </td>
                            <td>商家：</td>
                            <td>
                                <select name="p_uid" id="puid" onchange="bidcid(this)">
                                    <option value="">------请选择------</option>
                                    <?php if(is_array($userinfo_info)): $i = 0; $__LIST__ = $userinfo_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$userinfoinfo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($userinfoinfo["u_id"]); ?>"><?php if(empty($userinfoinfo["u_shopname"])): ?>商户ID：<?php echo ($userinfoinfo["u_id"]); endif; echo ($userinfoinfo["u_shopname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </td>
                        </tr>
                        <tr class="h30">
                            <td>品牌：</td>
                            <td>
                                <select name="p_bid" id="pbid">
                                    <option value="">暂无</option>
                                </select>
                            </td>
                            <td>单位：</td>
                            <td>
                                <select name="p_cid" id="pcid">
                                    <option value="">暂无</option>
                                </select>
                            </td>
                        </tr>
                        <tr class="h30">
                            <td>上下架：</td>
                            <td>
                                <select name="p_state" id="pstate">
                                    <option value="1">上架</option>
                                    <option value="0">下架</option>
                                </select>
                            </td>
                            <td>是否删除：</td>
                            <td>
                                <select name="p_del" id="pdel">
                                    <option value="1">删除</option>
                                    <option value="0" selected>正常</option>
                                </select>
                            </td>
                        </tr>
                        <tr class="h30">
                            <td>产品类型：</td>
                            <td>
                                <select  name="p_type" id="ptype">
                                    <option value="0">请选择</option>
                                    <?php if(is_array($alist)): $i = 0; $__LIST__ = $alist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo['pt_id']); ?>">
                                            <?php echo str_repeat(" |-",$vo['count']-2);?>
                                            <?php echo ($vo['pt_receptionname']); ?>
                                        </option><?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </td>
                            <td>卖点：</td>
                            <td>
                                <input class="must" type="text" name="p_sellingpoint" id="psellingpoint" value="" placeholder="请输入卖点" />
                            </td>
                        </tr>
                        <tr class="h25">
                            <td>APP图片：</td>
                            <td colspan="3">
                                <form  enctype="multipart/form-data" method="post" id="img1">
                                    <div class="imgadds imgadds1" style="margin-top:10px;width: 520px;"></div>
                                    <div class="imgCon " colspan="5" style="position: relative;height: 150px;width: 150px;float: left;padding: 0px !important;">
                                        <div class="uopImg upBtn upload-btn-a" data-type="avatar" data-is_edit="1" data-inited="1" >
                                            <img src="/Public/img/addimg.png"   width="150px;" height="150px;" style="float:left;">
                                            <input class="upload-input" type="file" size="100" name="upload_file" id="uploadFile"  onchange="uploadImage(this);">
                                        </div>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        <tr class="h25">
                            <td>PC图片：</td>
                            <td colspan="3">
                                <form  enctype="multipart/form-data" method="post" id="img2">
                                    <div class="imgadds imgadds2" style="margin-top:10px;width: 520px;"></div>
                                    <div class="imgCon " colspan="5" style="position: relative;height: 150px;width: 150px;float: left;padding: 0px !important;">
                                        <div class="uopImg upBtn upload-btn-a" data-type="avatar" data-is_edit="1" data-inited="1" >
                                            <img src="/Public/img/addimg.png"   width="150px;" height="150px;" style="float:left;">
                                            <input class="upload-input" type="file" size="100" name="upload_file" id="uploadFiles"  onchange="uploadImage(this);">
                                        </div>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        <tr class="h30">
                            <td>商品描述：</td>
                            <td colspan="3" style="padding: 0;">
                                <textarea  id="contenttxt" name="p_content" style="width: 750px; height: 300px;"></textarea>
                            </td>
                        </tr>
                        <tr class="h30">
                            <td>搜索关键字：</td>
                            <td>
                                <div class="Hui-tags">
                                    <div class="Hui-tags-iptwrap">
                                        <input type="text" class="Hui-tags-input"  name="p_searchkeyword" maxlength="20" value="">
                                        <label class="Hui-tags-label">添加相关标签，用空格或回车分隔</label>
                                    </div>
                                </div>
                            </td>
                            <td>有无活动：</td>
                            <td>
                                <select name="p_isactivity" id="pisactivity" onclick="displaytypes()">
                                    <option value="1">有活动</option>
                                    <option value="0">无活动</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                    <div id="search-form-div" style="display: none;" >
                        <table  class="layerTable" border="0">
                            <tr class="h30">
                                <td>活动名称：</td>
                                <td colspan="3">
                                    <input class="must" type="text" name="p_activityname" id="pactivityname" value=""  placeholder="请输入活动名称"/>
                                </td>
                            </tr>
                            <tr class="h30">
                                <td>开始时间：</td>
                                <td colspan="1">
                                    <input  type="text" name="p_activitystartime"  class="Wdate" onFocus="WdatePicker({lang:'zh-cn'})" id="pactivitystartime" value="" />
                                </td>
                                <td>结束时间：</td>
                                <td>
                                    <input type="text" name="p_activityendtime"  class="Wdate" onFocus="WdatePicker({lang:'zh-cn'})" id="pactivityendtime" value="" />
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div style="padding: 35px 8px; border: 1px solid #A3C0E8;" class="div_content">
                        <div class="div_title"><span style="font-weight: bold;">产品属性：</span>&nbsp;&nbsp;&nbsp;<span style="color: red;">*温馨提示：颜色分类和规格至少勾选一项。</span></div><hr/>
                        <div class="div_contentlist">
                            <ul class="Father_Title"><li><span>颜色分类：</span>&nbsp;&nbsp;&nbsp;<input id="Checkbox" type="text" value="" placeholder="请输入颜色" />&nbsp;<button  id="insertcolor">添加颜色分类</button></li></ul>
                            <ul class="Father_Item0">
                                <li class="li_width"><label><input id="Checkbox3" type="checkbox" class="chcBox_Width" value="军绿色" />军绿色<span class="li_empty"  contentEditable="true"></span></label></li>
                                <li class="li_width"><label><input id="Checkbox1" type="checkbox" class="chcBox_Width" value="花色" />花色<span class="li_empty"> </span></label></li>
                                <li class="li_width"><label><input id="Checkbox2" type="checkbox" class="chcBox_Width" value="蓝色" />蓝色<span class="li_empty"> </span></label></li>
                                <li class="li_width"><label><input id="Checkbox4" type="checkbox" class="chcBox_Width" value="褐色" />褐色<span class="li_empty"> </span></label></li>
                                <li class="li_width"><label><input id="Checkbox5" type="checkbox" class="chcBox_Width" value="黄色" />黄色<span class="li_empty"> </span></label></li>
                                <li class="li_width"><label><input id="Checkbox6" type="checkbox" class="chcBox_Width" value="黑色" />黑色<span class="li_empty"> </span></label></li>
                            </ul>
                            <br/>
                            <hr/>
                            <ul class="Father_Title"><li><span>规格：</span>&nbsp;&nbsp;&nbsp;<input id="Checkbox111" type="text"  value="" placeholder="请输入规格" />&nbsp;<button id="insertsize">添加规格</button></li></ul>
                            <ul class="Father_Item1">
                                <li class="li_width"><label><input id="Checkbox7" type="checkbox" class="chcBox_Width" value="100*100" />100*100<span class="li_empty"> </span></label></li>
                                <li class="li_width"><label><input id="Checkbox8" type="checkbox" class="chcBox_Width" value="200*200" />200*200<span class="li_empty"> </span></label></li>
                                <li class="li_width"><label><input id="Checkbox9" type="checkbox" class="chcBox_Width" value="5KG" />5KG<span class="li_empty"> </span></label></li>
                            </ul>
                            <br/>
                            <hr/>
                        </div>
                        <div class="div_contentlist2">
                            <ul>
                                <li><div id="createTable"></div></li>
                            </ul>
                        </div>
                    </div>
                   <!--<div style="padding: 35px 8px; border: 1px solid #00a0e9;" >-->
                       <!--<div>-->
                           <!--<span style="font-weight: bold;">产品参数：</span><br/>-->
                           <!--<span><input id="newsname" type="text" value="" placeholder="请输入参数名" />：-->
                               <!--<input id="newsval" type="text" value="" placeholder="请输入参数值" />&nbsp;-->
                               <!--<button  id="insertnewval">添加新参数</button>-->
                                <!--<button  id="delnewval" onclick="document.getElementById('newsname').value='';document.getElementById('newsval').value=''" >清空</button></span>-->
                       <!--</div><hr/>-->
                       <!--<div id="newparameter"></div>-->
                   <!--</div>-->
                </div>
                <div class="layerBtns1">
                    <a class="btn" onclick="ajaxform_insert()">提交</a>
                </div>
    </div>
<link rel="stylesheet" type="text/css" href="/Public/kindeditor-4.1.10/themes/default/default.css"/>
<script src="/Public/js/jquery2-1-4.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/layer/layer.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/js/htglxt.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/js/iframe.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/js/jquery.treetable.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/js/ajax-submit.js"></script>
<script src="/Public/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/kindeditor-4.1.10/kindeditor.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/kindeditor-4.1.10/lang/zh_CN.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/kindeditor-4.1.10/plugins/code/prettify.js"></script>
<script type="text/javascript" src="/Public/js/liandong.js"></script>
<script type="text/javascript" src="/Public/js/json2.js"></script>
<script>
    if($("#pbid").html()==""){
        $("#pbid").html("<option value=''>暂无</option>");
    }
    if($("#pcid").html()==""){
        $("#pcid").html("<option value=''>暂无</option>");
    }
    /*==========文本编辑器部分============*/
    var editor1;
    KindEditor.ready(function (K) {
        editor1 =kd('#contenttxt',K);
        editor_imgs = kdimg(K);
        K('#tianjiatupian').click(function () {
            editor_imgs.loadPlugin('image', function () {
                editor_imgs.plugin.imageDialog({
                    imageUrl: "",
                    clickFn: function (url, title, width, height, border, align) {
                        K("#tupiandiv").append("<div class=\"img\"><img class=\"w_100 h_100\" src=\"" + url + "\" /><p><span onclick=\"editormove(this,1)\">左移</span><span onclick=\"editormove(this,0)\">删除</span><span onclick=\"editormove(this,2)\">右移</span></p></div>");
                        editor_imgs.hideDialog();
                    }
                });
            });
        });
    });


    var a = $("#puid").val();
    var data = {
        'p_uid':a
    };
    $.ajax({
        type: "post",
        url: "<?php echo U('index/search_bidcid');?>",
        data: data,
        dataType: "json",
        success: function (e) {
            if(e!=","){
                $("#pbid").html(e[0]);
                $("#pcid").html(e[1]);
                if($("#pbid").html()==""){
                    $("#pbid").html("<option value=''>暂无</option>");
                }
                if($("#pcid").html()==""){
                    $("#pcid").html("<option value=''>暂无</option>");
                }
            }else{
                $("#pbid").html("<option value=''>暂无</option>");
                $("#pcid").html("<option value=''>暂无</option>");
            }


        },
        error: function () {
            layer.alert('操作失败！');
        }
    });
    /*商家品牌与单位的联动查询*/
    function bidcid(obj) {
        var a = $(obj).val();
        var data = {
            'p_uid':a
        };
        $.ajax({
            type: "post",
            url: "<?php echo U('index/search_bidcid');?>",
            data: data,
            dataType: "json",
            success: function (e) {
               if(e!=","){
                   $("#pbid").html(e[0]);
                   $("#pcid").html(e[1]);
               }else{
                   $("#pbid").html("<option value=''>暂无</option>");
                   $("#pcid").html("<option value=''>暂无</option>");
               }

            },
            error: function () {
                layer.alert('操作失败！');
            }
        });
    }
    /*====图片上传-预览====*/
    function uploadImage(obj) {
        /*判断是否有选择上传文件*/
        var imgPath = obj.files;
        if (!imgPath.length) {
            layer.msg('请选择需要上传的图片!', {icon: 1, time: 1000});
            return;
        }
        /*判断APP张数*/
        var ucardedimg = $(obj).parents('td').find(".imgadds1").find('img').length;
        if(ucardedimg>=8){
            layer.msg('APP图片只能上传四张!', {icon: 1, time: 1000});
            return;
        }
        /*判断pc张数*/
        var ucardedimg1 = $(obj).parents('td').find(".imgadds2").find('img').length;
        if(ucardedimg1>2){
            layer.msg('PC图片只能上传两张!', {icon: 1, time: 1000});
            return;
        }
        var parent_obj = $(obj).parents('td'),
            addimgs = parent_obj.find('.imgadds');

        var ccccc = new FormData();
        ccccc.append('upload_file', imgPath[0]);
        $.ajax({
            type: "POST",
            url: "<?php echo U('banner/ajaxupload');?>",
            data: ccccc,
            processData: false,
            contentType: false,
            success: function (data) {
                addimgs.append("<img src='" + data.url + "'  width='150px;' height='150px;' style='float:left;margin:0 0 0 0px;'><img src='/Public/img/trash.png' onclick='delimgs1(this)' class='delthis' style='float:left;margin-top:0px;margin-right: 2px;'> ");
                layer.msg(data.info, {icon: 1, time: 1000});
            },
            error: function (e) {
                layer.msg(e.info, {icon: 1, time: 1000});
            }
        });
    }
    /*====删除预览图片====*/
    function delimgs1(omg){
        $(omg).prev().remove();
        $(omg).remove();
    }
    /*====表格中图片上传-预览====*/
    function uploadImages(obj) {
        /*判断是否有选择上传文件*/
        var imgPath = obj.files;
        /* console.log(imgPath);*/
        if (!imgPath.length) {
            layer.msg('请选择需要上传的图片!', {icon: 1, time: 1000});
            return;
        }

        var parent_obj = $(obj).parents('td'),
            addimgs = parent_obj.find('.imgadd');

        /*判断APP张数*/
        var ucardedimg1 = $(obj).parents('td').find(".appimg").find('img').length;
        if(ucardedimg1>=1){
            layer.msg('APP图片只能上传一张!', {icon: 1, time: 1000});
            return;
        }
        /*判断pc张数*/
        var ucardedimg1 = $(obj).parents('td').find(".pcimg").find('img').length;
        if(ucardedimg1>=1){
            layer.msg('PC图片只能上传一张!', {icon: 1, time: 1000});
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
                addimgs.append("<img src='" + data.url + "'  width='50px;' height='50px;' style='float:left;margin:0 0 0 0px;'><img src='/Public/img/trash.png' onclick='delimgs(this)' class='delthis' style='float:left;margin-top:0px;margin-right: 2px;'> ");
                layer.msg(data.info, {icon: 1, time: 1000});
            },
            error: function (e) {
                layer.msg(e.info, {icon: 1, time: 1000});
            }
        });
    }
    /*====表格删除预览图片====*/
    function delimgs(omg){
        $(omg).prev().remove();
        $(omg).remove();
    }

    /*打开网页执行displaytypes()*/
    window.onload=function(){
        displaytypes();
    };
    /*有无活动选中类型---显示与隐藏*/
    function displaytypes() {
        var pttype = $("#pisactivity").val();
//        console.log(pttype);
        if (pttype == '0'){
            $("#search-form-div").hide();
        }
        if (pttype == '1') {
            $("#search-form-div").show();
        }
    }

    /*====产品的添加-ajax部分====*/
    function ajaxform_insert(){
        /*===========获取产品值===========*/
        var pname = $("#pnametxt").val();
        var pcid = $("#pcid option:selected").val();
        var pbid = $("#pbid option:selected").val();
        var puid = $("#puid option:selected").val();
        var pstate = $("#pstate option:selected").val();
        var pdel = $("#pdel option:selected").val();
        var pcontent = editor1.html();
        var ptype = $("#ptype option:selected").val();
        var psellingpoint = $("#psellingpoint").val();
        /*获取APP图片*/
        var pimglist = "";
        $(".imgadds1").find("img").each(function () {
            pimglist += $(this).attr("src") + ",";
            pimglist =  pimglist.replace(',/Public/img/trash.png',"");
        });
        if (pimglist.length > 0) pimglist = pimglist.substr(0, pimglist.length - 1);

        /*获取PC图片*/
        var ppcimglist = "";
        $(".imgadds2").find("img").each(function () {
            ppcimglist += $(this).attr("src") + ",";
            ppcimglist =  ppcimglist.replace(',/Public/img/trash.png',"");
        });
        if (ppcimglist.length > 0) ppcimglist = ppcimglist.substr(0, ppcimglist.length - 1);

        /*获取关键字*/
        var psearchkeyword = "";
        $(".Hui-tags-token").each(function () {
            psearchkeyword += $(this).text() + " ";
        });

        var pisactivity = $("#pisactivity option:selected").val();
        var pactivityname = $("#pactivityname").val();
        var pactivitystartime = $("#pactivitystartime").val();
        var pactivityendtime = $("#pactivityendtime").val();
        if(pisactivity == '0'){
            pactivityname = "0";
            pactivitystartime = "0";
            pactivityendtime = "0";
        }
        /*===============获取产品属性值============*/
        /*获取类型名称的值*/
        var typenamearray = [];
        $("#createTable table tr th").each(function(i){
            $(this).each(function(i){
                typenamearray.push($(this).text());
            });
            /*去掉不需要的字段*/
            for(var i=0;i<=typenamearray.length-1;i++){
                if(typenamearray[i]=='价格'||typenamearray[i]=='库存'||typenamearray[i]=='活动价'||typenamearray[i]=='原价'||typenamearray[i]=='APP图上传'||typenamearray[i]=='PC图上传'){
                    typenamearray.splice(i,1);
                }
            }
        });
        var typename = $(typenamearray).stringify();

            /*获取类型名称+类型值*/
        var tablearray = [];
        var typenames = [];
        var typevals = [];
        var atvtypevalue = [];
        $("#createTable table tr:gt(0)").each(function(i){
            $("#createTable table tr th").each(function(j){
                typenames.push($(this).text());
            });
            $(this).children("td").each(function(i){
                typevals.push($(this).text());
            });
            for (var i = 0; i < typenames.length; i++) {
                tablearray[i] = typenames[i]+":"+typevals[i];
            }
            for(var h=0;h<=tablearray.length-1;h++){
                if(tablearray[h]=='价格:'){
                    tablearray.splice(h,1);
                }
                if(tablearray[h]=='活动价:'){
                    tablearray.splice(h,1);
                }
                if(tablearray[h]=='库存:'){
                    tablearray.splice(h,1);
                }
                if(tablearray[h]=='原价:'){
                    tablearray.splice(h,1);
                }
                if(tablearray[h]=='APP图上传:  '){
                    tablearray.splice(h,1);
                }
                if(tablearray[h]=='PC图上传:  '){
                    tablearray.splice(h,1);
                }
            }
            for(var m=0;m<=tablearray.length-1;m++){
                if(tablearray[m]=='活动价:'){
                    tablearray.splice(m,1);
                }
                if(tablearray[m]=='APP图上传:   '){
                    tablearray.splice(m,1);
                }
                if(tablearray[m]=='PC图上传:   '){
                    tablearray.splice(m,1);
                }
            }
            var p = tablearray.length/typenamearray.length;
            var typevalue = [];
            for (var i = 0; i < p; i++) {
                var lk = [];
                for (var n = 0; n < tablearray.length; n++) {
                    if (n >= (i) * typenamearray.length && n < ((i + 1) * typenamearray.length)) {
                        lk.push(tablearray[n]);
                    }
                }
                typevalue.push(lk);
            }
            atvtypevalue = $(typevalue).stringify();
        });
        /*获取input的值*/
        var price = "";
        var stock = "";
        var activityprice = "";
        var originalprice = "";
        var atvimg = "";
        var atvpcimg = "";
        $("#createTable table tr:gt(0)").each(function(j){
            /*获取input价格的值*/
            $(this).children("td").children("input[name=Txt_PriceSon]").each(function(l){
                    price+=$(this).val()+",";
            });
            /*获取input库存的值*/
            $(this).children("td").children("input[name=Txt_CountSon]").each(function(i) {
                stock+=$(this).val()+",";
            });
            /*获取input活动价的值*/
            $(this).children("td").children("input[name=Txt_NumberSon]").each(function(k) {
                activityprice+=$(this).val()+",";
            });
            /*获取input原价的值*/
            $(this).children("td").children("input[name=Txt_SnSon]").each(function(h) {
                originalprice+=$(this).val()+",";
            });
            /*获取APP图片的值*/
            $(this).children("td").children(".appimg").find("img").each(function(n) {
                atvimg += $(this).attr("src")+",";
                atvimg =  atvimg.replace(',/Public/img/trash.png',"");
            });
            /*获取PC图片的值*/
            $(this).children("td").children(".pcimg").find("img").each(function(n) {
                atvpcimg += $(this).attr("src")+",";
                atvpcimg =  atvpcimg.replace(',/Public/img/trash.png',"");
            });
        });
            if(price==""||stock==""||activityprice==""||originalprice==""||atvimg==""||atvpcimg==""){
                layer.msg('产品属性输入不完整,请输入后再提交!', { icon: 2, time: 1500 });
                return;
            }
        /*===============获取参数值===============*/
    /*    var parameter = "";
        $("#newparameter span a").text("");
        $("#newparameter span").each(function(j){
                parameter += $(this).text()+",";
        });
        if (parameter.length > 0) parameter = parameter.substr(0, parameter.length - 1);*/
        /*=========组合获取值===========*/
        var data = {
            /*产品的值*/
            'p_name':pname,
            'p_cid':pcid,
            'p_bid':pbid,
            'p_uid':puid,
            'p_state':pstate,
            'p_del':pdel,
            'p_content':pcontent,
            'p_type':ptype,
            'p_sellingpoint':psellingpoint,
            'p_imglist':pimglist,
            'p_searchkeyword':psearchkeyword,
            'p_isactivity':pisactivity,
            'p_activityname':pactivityname,
            'p_activitystartime':pactivitystartime,
            'p_activityendtime':pactivityendtime,
            'p_pcimglist':ppcimglist,
            /*产品属性值*/
            'atv_stock':stock,
            'atv_price':price,
            'atv_img':atvimg,
            'atv_activityprice':activityprice,
            'atv_typename':typename,
            'atv_typevalue':atvtypevalue,
            'atv_originalprice':originalprice,
            'atv_pcimg':atvpcimg
            /*产品参数值*/
         /*   'pp_val':parameter*/
        };
        var index = layer.load({ shade: [0.5, '#fff'] });
        $.ajax({
            type: "post",
            url: "<?php echo U('product/insert');?>",
            data: data,
            dataType: "json",
            success: function (e) {
                layer.close(index);
                if (e.status == 1) {
                    layer.msg(e.info);
                    window.parent.location.reload();
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
    /*=====点击添加属性值====*/
    $(document).ready(function(){
        $("#insertvalue").click(function(){
            addval = $("#Cbox").val();
            /*统计当前页面中的当前元素个数，生成ID*/
            id2 = $("[class^='Father_Item']").size();
            id = $("[id^='insertvals']").size()+1;
            ids =  $("[id^='Checkbox']").size()+1;

            /*生成新元素，追加到ID值为div_contentlist的元素中*/
            $(box.getButton(id,ids,id2,addval)).appendTo($(".div_contentlist"));
            /*绑定click事件*/
            /*$("#insertvals"+id).on('click',function(){
                console.log("#insertvals"+id);
                console.log(".Father_Item"+id2);
               $(box.getClick()).appendTo($(".Father_Item"+id2)); ;
            });*/
        });
    });
    /*生成一个对象盒子,封装函数*/
    var box = {};
    box.getButton = function(id,ids,id2,addval){
        return ' <ul class="Father_Title"><li><span>'+addval+'：</span>&nbsp;&nbsp;&nbsp;<input id="Checkbox'+ids+'"  type="text" class="newvals"  value="" />&nbsp;<button onclick="insertvals(this)" id="insertvals'+id+'">添加'+addval+'</button></li></ul> ' +
            '<ul class="Father_Item'+id2+'"></ul><br/><hr/>';
    };
    /*=====点击添加新属性的值====*/
    function insertvals(obj) {
            var newval = $(obj).parents("li").find(".newvals").val();
            $(obj).parents(".Father_Title").next("ul").append('<li class="li_width" style="float: left;"><label><input  type="checkbox" class="chcBox_Width" value="'+newval+'" />'+newval+'<span class="li_empty"> </span></label></li>');
    }
    /*=====点击添加颜色分类====*/
    $("#insertcolor").click(function(){
        var colorval = $("#Checkbox").val();
        if($.trim(colorval)){
            $(".Father_Item0").append('<li class="li_width"><label><input  type="checkbox" class="chcBox_Width" value="'+colorval+'" />'+colorval+'<span class="li_empty"> </span></label></li>');
        }else{
            layer.alert("请输入颜色");
        }
       });
    /*=====点击添加尺寸====*/
    $("#insertsize").click(function(){
        var sizeval = $("#Checkbox111").val();
        if($.trim(sizeval)){
            $(".Father_Item1").append('<li class="li_width"><label><input  type="checkbox" class="chcBox_Width" value="'+sizeval+'" />'+sizeval+'<span class="li_empty"> </span></label></li>');
        }else{
            layer.alert("请输入规格");
        }
       });
    // /*=====点击添加新的参数====*/
    // $("#insertnewval").click(function(){
    //     var newname = $("#newsname").val();
    //     var newval = $("#newsval").val();
    //     if($.trim(newname)&&$.trim(newval)){
    //         $("#newparameter").append("<span>"+newname+":"+newval+"<a id='dels' href='javascript:void(0)'>删除参数</a></span>&nbsp;&nbsp;");
    //     }else{
    //         layer.alert("请输入参数和参数值");
    //     }
    //    });
    // /*=====点击删除参数====*/
    // $("#newparameter").on("click", '#dels', function () {
    //     $(this).parent("span").remove();
    // });
    /*-----搜索关键字效果部分--------*/
    var time1;
    $(".Hui-tags-lable").show();
    $(".Hui-tags-input").val("");
    $(document).on("blur",".Hui-tags-input",function(){
        time1 = setTimeout(function(){
            $(this).parents(".Hui-tags").find(".Hui-tags-list").slideUp();
        }, 400);
    });
    $(document).on("focus",".Hui-tags-input",function(){
        clearTimeout(time1);
    });
    $(document).on("click",".Hui-tags-input",function(){
        $(this).find(".Hui-tags-input").focus();
        $(this).find(".Hui-tags-list").slideDown();
    });
    function gettagval(obj){
        var str ="";
        var token =$(obj).parents(".Hui-tags").find(".Hui-tags-token");
        //alert(token.length)
        if(token.length<1){
            $(obj).parents(".Hui-tags").find(".Hui-tags-val").val("");
            return false;
        }
        for(var i = 0;i< token.length;i++){
            str += token.eq(i).text() + ",";
            $(obj).parents(".Hui-tags").find(".Hui-tags-val").val(str);
        }
    }
    $(document).on("keydown",".Hui-tags-input",function(event){
        $(this).next().hide();
        var v = $(this).val().replace(/\s+/g, "");
        var reg=/^,|,$/gi;
        v=v.replace(reg,"");
        v=$.trim(v);
        var token =$(this).parents(".Hui-tags").find(".Hui-tags-token");
        if(v!=''){
            if(event.keyCode==13||event.keyCode==108||event.keyCode==32){
                $('<span class="Hui-tags-token">'+v+'</span>').insertBefore($(this).parents(".Hui-tags").find(".Hui-tags-iptwrap"));
                $(this).val("");
                gettagval(this);
            }
        }else{
            if(event.keyCode==8){
                if(token.length>=1){
                    $(this).parents(".Hui-tags").find(".Hui-tags-token:last").remove();
                    gettagval(this);
                }
                else{
                    $(this).parents(".Hui-tags").find(".Hui-tags-lable").show();
                    return false;
                }

            }
        }
    });
    $(document).on("click",".Hui-tags-has span",function(){
        var taghasV = $(this).text();
        taghasV=taghasV.replace(/(^\s*)|(\s*$)/g,"");
        $('<span class="Hui-tags-token">'+taghasV+'</span>').insertBefore($(this).parents(".Hui-tags").find(".Hui-tags-iptwrap"));
        gettagval(this);
        $(this).parents(".Hui-tags").find(".Hui-tags-input").focus();
    });
    $(document).on("click",".Hui-tags-token",function(){
        var token =$(this).parents(".Hui-tags").find(".Hui-tags-token");
        var it = $(this).parents(".Hui-tags");
        $(this).remove();
        switch(token.length){
            case 1 : it.find(".Hui-tags-lable").show();
                break;
        }
        var str ="";
        var token =it.find(".Hui-tags-token");
        //alert(token.length)
        if(token.length<1){
            it.find(".Hui-tags-val").val("");
            return false;
        }
        for(var i = 0;i< token.length;i++){
            str += token.eq(i).text() + ",";
            it.find(".Hui-tags-val").val(str);
        }
    });
</script>
</body>
</html>