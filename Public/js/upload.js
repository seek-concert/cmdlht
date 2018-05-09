var _upload = function(options){
    if(!(this instanceof arguments.callee)){
        return new arguments.callee(options);
    }
    this.entry(options);
}
_upload.prototype = {
    entry:function(options){
        this.obj = options.obj;
        this.success = options.success;
        this.uploading = options.uploading;
        this.upload_url = options.upload_url;
        this.domain = options.domain;
        this.server = options.server;
        this.uuid = new Date();
        this.create_upload_btn();
    },
    create_upload_btn:function(){
        this.upload_input = $('<input   class="upload-input" type="file" size="100" name="upload_file">').appendTo(this.obj);
        var self = this;
        this.upload_input.bind('change',function(){
            //alert(0);
            self.submit();
        });
    },
    create_upload_form:function(){
        this.upload_iframe = $('<iframe name="upload_iframe" width="0" height="0" frameborder="0" style="dispaly:none;"></iframe>').appendTo(document.body);
        var callback = 'upload_callback_'+(this.uuid++);
        var self = this;
        window[callback]= function(json){
            self.upload_iframe.remove();
            self.upload_form.remove();
            self.upload_iframe = null;
            self.upload_form = null;
            if(self.success){
                self.success(json);
            }
        };
        document.domain = this.domain;
        this.upload_form   = $('<form action="'+this.upload_url+'?server='+this.server+'&domain='+this.domain+'&callback='+callback+'" target="upload_iframe" method="post" enctype="multipart/form-data" style="display:none;"></form>').appendTo(document.body);
    },
    submit:function(){
        this.create_upload_form();
        this.upload_input.appendTo(this.upload_form);
        this.upload_form.submit();
        //上传中的回调
        if(this.uploading){
            this.uploading();
        }
        this.create_upload_btn();
    }
}