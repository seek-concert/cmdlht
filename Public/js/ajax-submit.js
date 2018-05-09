;
$(function () {
    /* 异步提交登录 */
    $('.js-ajax-login').on('click',function () {
        var btn=$(this),
            form=btn.parents('form.js-ajax-form'),
            url=form.attr('action'),
            data=form.serialize(),
            msg='登录中……';

        if (btn.data("loading")) {
            return false;
        }

        $.ajax({
            url:url,
            data:data,
            type:'POST',
            dataType:'JSON',
            beforeSend:function () {
                btn.data("loading",true).prop('disabled',true).addClass('disabled');
                if(msg){
                    layer.msg(msg);
                }
            },
            success:function (data) {
                btn.data("loading",false).prop('disabled',false).removeClass('disabled');
                layer.msg(data.info);
                if(data.status){
                    location.href=data.url;
                }else{
                    $('input[name=name]').focus();
                }
            },
            error:function (xhr,e,statusText) {
                btn.data("loading",false).prop('disabled',false).removeClass('disabled');
                layer.msg(statusText);
            }
        });
        return false;
    });

    /* 异步提交表单快捷操作-按钮点击 */
    $('.js-ajax-form-btn').on('click',function () {
        js_ajax_btn_action($(this));
    });

});

/* 异步提交表单快捷操作-数据整理 */
function js_ajax_btn_action(btn) {
    var form=btn.data('form')?$('#'+btn.data('form')):btn.parents('form.js-ajax-form'),
        url=btn.data('action')?btn.data('action'):form.attr('action'),
        data=btn.data('formdata')?btn.data('formdata'):form.serialize(),
        returnurl=btn.data('returnurl')?btn.data('returnurl'):'',
        notice=btn.data('msg'),
        is_layer=btn.data('layer'),
        msg='处理中……';

    if (btn.data("loading")) {
        return false;
    }
    if(notice){
        layer.confirm(notice, {
            skin: 'new-layer',
            title: '提示',
            btn: ['确定','取消'] //按钮
        }, function(index){
            layer.close(index);
            js_ajax_form_action(btn,url,data,msg,is_layer,returnurl);
        }, function (index) {
            layer.close(index);
        });
    }else{
        js_ajax_form_action(btn,url,data,msg,is_layer,returnurl);
    }

    return false;
}

/* 异步提交表单快捷操作-表单提交操作 */
function js_ajax_form_action(btn,url,data,msg,is_layer,returnurl) {
    $.ajax({
        url:url,
        data:data,
        type:'POST',
        dataType:'JSON',
        beforeSend:function () {
            btn.data("loading",true).prop('disabled',true).addClass('disabled');
            if(msg){
                layer.msg(msg);
            }
        },
        success:function (resp) {
            btn.data("loading",false).prop('disabled',false).removeClass('disabled');
            layer.msg(resp.info);
            $('input[name=name]').focus();
            if(returnurl){
                if(is_layer){
                    window.parent.location.href=returnurl;
                }else{
                    location.href=returnurl;
                }
                return false;
            }
            if(resp.url){
                if(is_layer){
                    window.parent.location.href=resp.url;
                }else{
                    location.href=resp.url;
                }
                return false;
            }
            if(resp.status){
                if(is_layer){
                    window.parent.location.href=window.parent.location.href;
                    /*reloadPage(window.parent);*/
                }else{
                    window.location.href=window.location.href;
                    /*reloadPage(window);*/
                }
                return false;
            }else{
                $('input[name=name]').focus();
            }
        },
        error:function (xhr,e,statusText) {
            btn.data("loading",false).prop('disabled',false).removeClass('disabled');
            $('input[name=name]').focus();
        }
    });
}
/* 重载页面 */
function reloadPage(win) {
    var location = win.location;
    location.href = location.pathname + location.search;
}


