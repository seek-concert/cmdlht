function  Creat_Table() {
    /*//开始创建Table表*/
/*        //创建表头*/
        var thead = $("<thead></thead>");
        var table=$("#process");
        thead.appendTo(table);

        var trHead = $("<tr></tr>");
        var itemColumHead0 = $("<th style='text-align: center;'>名称</th>");
        itemColumHead0.appendTo(trHead);
        var itemColumHead4 = $("<th style='text-align: center;'>类型描述</th>");
        itemColumHead4.appendTo(trHead);
        var itemColumHead1 = $("<th style='text-align: center;'>规格</th>");
        itemColumHead1.appendTo(trHead);
        var itemColumHead = $("<th style=\"width:10%;text-align: center;\">单位</th><th style=\"width:10%;text-align: center;\">排序</th> ");
        itemColumHead.appendTo(trHead);
        var itemColumHead2 = $("<th style=\"width:10%;text-align: center;\">人工费(新装)</th><th style=\"width:10%;text-align: center;\">新装价格<br/></th>");
        itemColumHead2.appendTo(trHead);
        var itemColumHead3 = $("<th style=\"width:10%;text-align: center;\">人工费(维修)</th><th style=\"width:10%;text-align: center;\">维修价格<br/></th>");
        itemColumHead3.appendTo(trHead);
        trHead.appendTo(thead);
    /*        //获取值*/
        var tbody = $("<tbody></tbody>");
        tbody.appendTo($("<table></table>"));
        var tbody=$("#process");
        $.each($(".Father_Title"), function (i) {
            var first=$(this);
           $.each($(".Father_Item"+i+" li"),function(j){
               var tr = $("<tr></tr>");
               /*第一行显示数据*/
               var infor1 = first.find("span").html().replace("：", "");


               /*当前属性的个数====判断几行合并在一起*/
              var liLength = $(".Father_Item"+i+" li").size();
              if(j==0) {
                  var td0 = $("<td style='text-align: center;' " + (j == 0 ? "rowspan = '" + liLength + "'" : "") + " ><span class='receptionname'>" + (j == 0 ? infor1 : "") + "</span></td>");
                  td0.appendTo(tr);
              }else {
                  var td0 = $("<td style='display: none; text-align: center;' " + (j == 0 ? "rowspan = '" + liLength + "'" : "") + " ><span class='receptionname'>" + infor1 + "</span></td>");
                  td0.appendTo(tr);
              }
              /*类型描述*/
               if(j==0) {
                   var td7 = $("<td style='text-align: center;' " + (j == 0 ? "rowspan = '" + liLength + "'" : "") + " ><textarea class='rtcontent' style='!important;width:100%;'></textarea></td>");
                   td7.appendTo(tr);
               }
               var td = $("<td style='text-align: center;'><span class='rtname'>"+$(this).find(".showname").html().replace(",", "")+"</span></td>");

               td.appendTo(tr);
               var td1 = $("<td ><input style='!important;width:100%;' name=\"Txt_CompanySon\" class=\"l-text\" type=\"text\" value=\"\"></td>");
               td1.appendTo(tr);
               var td2 = $("<td ><input style='!important;width:100%;' name=\"Txt_OrderSon\" class=\"l-text\" type=\"text\" value=\"0\"></td>");
               td2.appendTo(tr);
               var td3 = $("<td ><input style='!important;width:100%;' name=\"Txt_ArtificialSon\"  class=\"l-text\" type=\"text\" value=\"\"></td>");
               td3.appendTo(tr);
               var td4 = $("<td ><input style='!important;width:100%;' name=\"Txt_PriceSon\" class=\"l-text\" type=\"text\" value=\"\"></td>");
               td4.appendTo(tr);
               var td5 = $("<td ><input style='!important;width:100%;' name=\"Txt_ArtificialSon1\"  class=\"l-text\" type=\"text\" value=\"\"></td>");
               td5.appendTo(tr);
               var td6 = $("<td ><input style='!important;width:100%;' name=\"Txt_PriceSon1\" class=\"l-text\" type=\"text\" value=\"\"></td>");
               td6.appendTo(tr);
               tr.appendTo(tbody);
            })
        });

   /* }*/
}
function  Creat_Tables() {
    /*开始创建Table表*/
    /* 创建表头*/
    var thead = $("<thead></thead>");
    var table=$("#process");
    thead.appendTo(table);

    var trHead = $("<tr></tr>");
    var itemColumHead0 = $("<th style='text-align: center;'>名称</th>");
    itemColumHead0.appendTo(trHead);
    var itemColumHead4 = $("<th style='text-align: center;'>类型描述</th>");
    itemColumHead4.appendTo(trHead);
    var itemColumHead1 = $("<th style='text-align: center;'>规格</th>");
    itemColumHead1.appendTo(trHead);
    var itemColumHead = $("<th style=\"width:10%;text-align: center;\">单位</th><th style=\"width:10%;text-align: center;\">排序</th> ");
    itemColumHead.appendTo(trHead);
    var itemColumHead2 = $("<th style=\"width:10%;text-align: center;\">人工费(新装)</th><th style=\"width:10%;text-align: center;\">新装价格<br/></th>");
    itemColumHead2.appendTo(trHead);
    var itemColumHead3 = $("<th style=\"width:10%;text-align: center;\">人工费(维修)</th><th style=\"width:10%;text-align: center;\">维修价格<br/></th>");
    itemColumHead3.appendTo(trHead);
    trHead.appendTo(thead);
    /*获取值*/
    var tbody = $("<tbody></tbody>");
    tbody.appendTo($("<table></table>"));
    var tbody=$("#process");
    var tr = $("<tr></tr>");
    /*第一行显示数据*/
    var infor1 = $("#rt_atid").find("option:selected").html();
    var td0 = $("<td style='text-align: center;'><span class='receptionname'>" + infor1 + "</span></td>");
    td0.appendTo(tr);

    /*类型描述*/
    var td7 = $("<td style='text-align: center;'><textarea class='rtcontent' style='!important;width:100%;'></textarea></td>");
    td7.appendTo(tr);
    var td = $("<td style='text-align: center;'><span class='rtname'>当前暂无维修规格</span></td>");
    td.appendTo(tr);
    var td1 = $("<td ><input style='!important;width:100%;' name=\"Txt_CompanySon\" class=\"l-text\" type=\"text\" value=\"\"></td>");
    td1.appendTo(tr);
    var td2 = $("<td ><input style='!important;width:100%;' name=\"Txt_OrderSon\" class=\"l-text\" type=\"text\" value=\"0\"></td>");
    td2.appendTo(tr);
    var td3 = $("<td ><input style='!important;width:100%;' name=\"Txt_ArtificialSon\"  class=\"l-text\" type=\"text\" value=\"\"></td>");
    td3.appendTo(tr);
    var td4 = $("<td ><input style='!important;width:100%;' name=\"Txt_PriceSon\" class=\"l-text\" type=\"text\" value=\"\"></td>");
    td4.appendTo(tr);
    var td5 = $("<td ><input style='!important;width:100%;' name=\"Txt_ArtificialSon1\"  class=\"l-text\" type=\"text\" value=\"\"></td>");
    td5.appendTo(tr);
    var td6 = $("<td ><input style='!important;width:100%;' name=\"Txt_PriceSon1\" class=\"l-text\" type=\"text\" value=\"\"></td>");
    td6.appendTo(tr);
    tr.appendTo(tbody);
}
/*添加表格数据*/
function Insert_Table_Tr() {
    /*获取值*/
    // var tbody = $("<tbody></tbody>");
    // tbody.appendTo($("#process"));
    var tr = $("<tr></tr>");
    /*第一行显示数据*/
    var infor = $(".div_contentlist").find("span").html().replace("：", "");
    var rtatid = $("#rt_atid").val();

        var infor1 = rtatid+" "+infor;
    var td0 = $("<td style='display: none; text-align: center;' ><span class='receptionname1'>" + infor1 + "</span></td>");
    td0.appendTo(tr);
    var td = $("<td style='text-align: center;'><span class='rtname1'>"+$(".newvals").val().replace(",","")+"</span></td>");
    console.log($(".newvals").val());
    td.appendTo(tr);
    var td1 = $("<td ><input style='!important;width:100%;' name=\"Txt_CompanySon1\" class=\"l-text\" type=\"text\" value=\"\"></td>");
    td1.appendTo(tr);
    var td2 = $("<td ><input style='!important;width:100%;' name=\"Txt_OrderSon1\" class=\"l-text\" type=\"text\" value=\"0\"></td>");
    td2.appendTo(tr);
    var td3 = $("<td ><input type='hidden' name='rd_id' class='rdidtxt3' value='0'><input style='!important;width:100%;' name=\"Txt_ArtificialSon3\"  class=\"l-text\" type=\"text\" value=\"\"></td>");
    td3.appendTo(tr);
    var td4 = $("<td ><input style='!important;width:100%;' name=\"Txt_PriceSon3\" class=\"l-text\" type=\"text\" value=\"\"></td>");
    td4.appendTo(tr);
    var td5 = $("<td ><input type='hidden' name='rd_id' class='rdidtxt2' value='0'><input style='!important;width:100%;' name=\"Txt_ArtificialSon2\"  class=\"l-text\" type=\"text\" value=\"\"></td>");
    td5.appendTo(tr);
    var td6 = $("<td ><input style='!important;width:100%;' name=\"Txt_PriceSon2\" class=\"l-text\" type=\"text\" value=\"\"></td>");
    td6.appendTo(tr);
    tr.appendTo($("#process").find("tbody"));
    console.log($("#process").find("tbody"));
}
/*添加表格数据*/
function Insert_Table() {
    /*获取值*/
    var tr = $("<tr></tr>");
    /*第一行显示数据*/
    var td1 = $("<td ><input type='hidden' class='s_id' value='0'><input type='hidden' class='s_pay' value='0'><input style='!important;width:100%;' name='s_number' class='l-text' type='text' value=''></td>");
    td1.appendTo(tr);
    var td2 = $("<td ><input style='!important;width:100%;' name='s_price' class='l-text' type='text' value=''></td>");
    td2.appendTo(tr);
    var td3 = $("<td ><input style='!important;width:100%;' name='s_startime' class='l-text Wdate'  onFocus=\"WdatePicker({lang:'zh-cn'})\" type='text' value=''></td>");
    td3.appendTo(tr);
    var td4 = $(" <td ><input style='!important;width:100%;' name='s_endtime' class='l-text Wdate'  onFocus=\"WdatePicker({lang:'zh-cn'})\" type='text' value=''></td>");
    td4.appendTo(tr);
    var td5 = $("<td ><textarea style='!important;width:100%;' name='s_content' class='l-text s_content' ></textarea></td>");
    td5.appendTo(tr);
    tr.appendTo($("#process").find("tbody"));
}
/***数组去空*/
function trimArray(arr){
    var a = [];
    $.each(arr,function(i,v){
        var data = $.trim(v);//$.trim()函数来自jQuery
        if('' != data){
            a.push(data);
        }
    });
    return a;
}
