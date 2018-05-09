<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>添加维修类型</title>
    <link rel="stylesheet" type="text/css" href="/Public/css/style.css"/>
</head>
<body>
    <div class="layerCon bg_f">
        <div id="search-form-div" style="display: none;" >
            <table  class="layerTable" border="0">
                <tr class="h30">
                    <td id="feiyongval"></td>
                    <td colspan="5">
                        <input type="text" name="rt_artificial" id="rt_artificial" value=""  placeholder="请输入费用">
                    </td>
                    <td id="feiyongvals"></td>
                    <td colspan="5">
                        <input type="text" name="rt_thedoor" id="rt_thedoor" value=""  placeholder="请输入费用">
                    </td>
                </tr>
                <tr class="h30">
                    <td>单位：</td>
                    <td colspan="11">
                        <input type="text" name="rt_company" id="rt_company" value=""  placeholder="请输入单位">
                    </td>
                </tr>
            </table>
        </div>
        <table class="layerTable" border="0">
            <tr class="h30">
                <td>上级名称：</td>
                <td colspan="5">
                    <select class="select" id="ptidtxt" name="rt_pid" onchange="choicetypestate()">
                        <option value="0">----------请选择父级-----------</option>
                        <?php if(is_array($repairtype_father)): foreach($repairtype_father as $key=>$v): ?><option value="<?php echo ($v["rt_id"]); ?>"><?php echo ($v["rt_receptionname"]); ?></option><?php endforeach; endif; ?>
                    </select>
                </td>
                <td>类型：</td>
                <td colspan="5">
                   <select name="rt_type" id="rttype">
                       <option value="10000">维修类</option>
                       <option value="20000">安装类</option>
                   </select>
                </td>
            </tr>
            <tr class="h30">
                <td>展示名称：</td>
                <td colspan="11">
                    <input class="must" type="text" name="rt_receptionname" id="rtreceptionname" value=""  placeholder="请输入展示名称"/>
                </td>
            </tr>
            <tr class="h30">
                <td>提交类型：</td>
                <td colspan="5">
                    <select name="rt_choicetype" id="rt_choicetype" onchange="choicetype()">
                        <option value="1">标价购买</option>
                        <option value="0">评估维修</option>
                    </select>
                </td>
                <td>排序：</td>
                <td colspan="5">
                    <input class="must" type="text" name="rt_order" id="rtorder" value="0" placeholder="请输入排序" />
                </td>
            </tr>
            <tr class="h30">
                <td>师傅类型：</td>
                  <td colspan="11">
                    <ul>
                        <?php if(is_array($constructiontype_info)): $i = 0; $__LIST__ = $constructiontype_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$infos): $mod = ($i % 2 );++$i;?><li  style="list-style: none;margin-right:10px;float: left;">
                                <lable style="cursor: pointer;"><input type="checkbox" id="rtctid" style="!important;width: 15px;height: 15px;" class="chcBox_Width" name="rt_ctid" value="<?php echo ($infos["ct_id"]); ?>">
                                    <?php echo ($infos["ct_name"]); ?><span class="li_empty"> </span></lable>
                            </li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </td>
            </tr>
             <tr class="h30">
                <td>相关描述：</td>
                <td colspan="11">
                    <textarea name="rt_content" id="rtcontent"  cols="10" rows="6"></textarea>
                </td>
            </tr>
            <tr class="h30">
                <td>缩略图：</td>
                <td colspan="11">
                    <form enctype="multipart/form-data" method="post" class="img1" style="float: left;">
                        <div class="imgCon " colspan="5" style="position: relative;height: 150px;width: 150px;">

                            <div class="uopImg upBtn upload-btn-a" data-type="avatar" data-is_edit="1" data-inited="1">
                                <img src="/Public/img/addimg.png" width="150px;" height="150px;"
                                     style="float: left;">
                                <input class="upload-input uploadFile" type="file" size="100" name="upload_file"
                                       onchange="uploadImage(this);">
                            </div>
                        </div>
                    </form>
                    <div class="imgadd rt_img"  style="margin-top:10px;width: 820px;">

                    </div>
                    <br/>
                </td>
            </tr>
            <tr class="h30">
                <td>效果轮播图：</td>
                <td colspan="11">
                    <form enctype="multipart/form-data" method="post" class="img1">
                        <div class="imgadd rt_imglist"  style="margin-top:10px;width: 520px;"></div>
                        <div class="imgCon " style="position: relative;height: 150px;width: 150px;float: left;padding: 0px !important;">
                            <div class="uopImg upBtn upload-btn-a" data-type="avatar" data-is_edit="1" data-inited="1">
                                <img src="/Public/img/addimg.png" width="150px;" height="150px;"
                                     style="float: left;">
                                <input class="upload-input uploadFile" type="file" size="100" name="upload_file"
                                       onchange="uploadImage(this);">
                            </div>
                        </div>
                    </form>
                </td>
            </tr>
           <tr class="h25"></tr>
           <tr class="h25"></tr>
        </table>
    </div>
    <div class="layerBtns">
        <a class="btn"  id="ajaxinsert">提交</a>
    </div>
<script src="/Public/js/jquery2-1-4.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/layer/layer.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/js/htglxt.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/js/iframe.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/js/jquery.treetable.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/js/ajax-submit.js"></script>
<script>
    window.onload=function(){
        $("#feiyongval").html("维修费<br/>(用户查看)");
        $("#feiyongvals").html("维修费<br/>(师傅查看)");
    };
    /*根据提交类型改变值*/
    function choicetype() {
        if($("#rt_choicetype").val()=="1"){
           $("#feiyongval").html("维修费<br/>(用户查看)");
           $("#feiyongvals").html("维修费<br/>(师傅查看)");
        }else{
            $("#feiyongval").html("上门费<br/>(用户查看)");
            $("#feiyongvals").html("上门费<br/>(师傅查看)");
        }
    }
    /*根据上级名称显示是否在前台展示下拉框的内容*/
    function choicetypestate(){
        var ptidtxt = $("#ptidtxt").val();
        if(ptidtxt!='0'){
            $("#rtchoicetype").html("<option value='0'>否</option>");
        }
        if(ptidtxt=='0'){
            $("#rtchoicetype").html("<option value='1'>是</option><option value='0'>否</option>");
        }
    }
    /*根据上级名称判断品牌是否显示*/
    $("#ptidtxt").change(function(){
      if($(this).val()!='0'){
          $("#search-form-div").show();
      }
      if($(this).val()=='0'){
          $("#search-form-div").hide();
      }
    });
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
        /*判断缩略图的张数*/
        var ufavicon = $(obj).parents('td').find(".rt_img").find('img').length;
        if(ufavicon>=1){
            layer.msg('缩略图只能上传一张!', {icon: 1, time: 1000});
            return;
        }
        /*判断效果图的张数*/
        var ufavicon1 = $(obj).parents('td').find(".rt_imglist").find('img').length;
        if(ufavicon1>10){
            layer.msg('效果图只能上传十张!', {icon: 1, time: 1000});
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
                addimgs.append("<img src='" + data.url + "'   width='150px;' height='150px;'  style='float:left;margin:0 0 0 0px;'><img src='/Public/img/trash.png' class='delthis' style='float:left;margin-top:0px;margin-right: 2px;'>  ");
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
        $(this).remove();
    });
    /*================ajax添加====================*/
    $(function(){
        $("#ajaxinsert").click(function(){
            var rtpid = $("#ptidtxt").val();
            var rttype = $("#rttype").val();
            var rt_choicetype = $("#rt_choicetype").val();
            var rtreceptionname = $("#rtreceptionname").val();
            var rtbackstagename = "";
            var rtorder = $("#rtorder").val();
            var rt_company = $("#rt_company").val();
            var rt_artificial = $("#rt_artificial").val();
            var rt_thedoor = $("#rt_thedoor").val();

            /*获取施工类型*/
            var rtctid = "";
            $('input[name="rt_ctid"]:checked').each(function () {
                rtctid += $(this).val() + ",";
            });
            var rtcontent = $("#rtcontent").val();
            /*获取缩略图*/
            var pimglist = "";
            $(".rt_img").find("img").each(function () {
                pimglist += $(this).attr("src") + ",";
            });
            if (pimglist.length > 0) pimglist = pimglist.substr(0, pimglist.length - 1);
            pimglist =  pimglist.replace(',/Public/img/trash.png',"");
            /*获取图片*/
            var pimglist1 = "";
            $(".rt_imglist").find("img").each(function () {
                pimglist1 += $(this).attr("src") + ",";
                pimglist1 =  pimglist1.replace(',/Public/img/trash.png',"");
            });
            if (pimglist1.length > 0) pimglist1 = pimglist1.substr(0, pimglist1.length - 1);

            /*获取品牌*/
            var rtbid = 0;

            var data = {
                'rt_pid':rtpid,
                'rt_type':rttype,
                'rt_choicetype':rt_choicetype,
                'rt_receptionname':rtreceptionname,
                'rt_backstagename':rtbackstagename,
                'rt_order':rtorder,
                'rt_ctid':rtctid,
                'rt_content':rtcontent,
                'rt_img':pimglist,
                'rt_bid':rtbid,
                'rt_imglist':pimglist1,
                'rt_company':rt_company,
                'rt_artificial':rt_artificial,
                'rt_thedoor':rt_thedoor
            };
            var index = layer.load({ shade: [0.5, '#fff'] });
            $.ajax({
                type: "post",
                url: "<?php echo U('repairtype/insert');?>",
                data: data,
                dataType: "json",
                success: function (e) {
                    layer.close(index);
                    if (e.status == 1) {
                        layer.msg(e.info);
                        window.parent.location.reload();
                    }
                },
                error: function () {
                    layer.close(index);
                    layer.alert('操作失败！');
                }
            });
        })
    })
</script>
</body>
</html>