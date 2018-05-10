<?php
namespace Home\Controller;
use Think\Controller;
use OSS\Core\OssException;
class IndexController extends Controller
{
    /*登陆模板...*/
    public function index()
    {
        $this->display('login');
    }
    /*生成验证码*/
    public function code()
    {
        $Verify = new \Think\Verify();
        $Verify->fontSize = 50;
        $Verify->length   = 4;
        $Verify->useNoise = false;
        $Verify->expire = 60;
        $Verify->useCurve = false;
        $Verify->entry();
    }

    /*验证码验证*/
    function check_verify($code, $id = ''){
        $verify = new \Think\Verify();
        return $verify->check($code, $id);
    }

    /* 登录操作 */
    public function dologin()
    {
        if (IS_POST) {
            $user_model = M('proxy');
            /* 表单验证 */
            $data = $user_model->create($_POST, 4);
            if (!$data) {
                $this->error($user_model->getError(), '', 1);
            }
            /*检测验证码*/
            $code = I('code');
            if($code == null){
                $this->error('验证码为空', '', 1);
            }
            if($this->check_verify($code) == false)
            {
                $this->error('验证码错误', '', 1);
            }
            /* 查找用户 */
            $find['p_loginname'] = $data['p_loginname'];
            $result = $user_model->where($find)->find();
            if (!$result) {
                $this->error('用户为空或不存在', '', 1);
            }
            /* 对比密码 */
            if ($result['p_loginpwd'] != md5($data['p_loginpwd'])) {
                $this->error('密码错误,请刷新验证码重试', '', 1);
            }
            /* 生成用户session */
            session('p_loginname', $result);
            session('action_time', time());


            /* 成功跳转 */
            $this->success('登录成功', U('home/index'), 1);
        } else {
            $this->redirect('index/index');
        }
    }

    /* 退出操作 */
    public function logout()
    {
        session(null);
        $this->redirect('index/index');
    }
    /* 清除缓存 */
    public function delete_cache()
    {
        deleteAll('./MyApp/Runtime');
        deleteAll('./MyApp/Html');
        $this->success('清除缓存完成','',1);
    }

    /*消息列表*/
    public function notice(){
        $userinfo_model = M('userinfo');
        /* 区域条件 */
        $user_info = session('p_loginname');
        $level = $user_info['p_level'];
        if($level==1){
            $where['u_sheng'] = $user_info['p_sheng'];
        }
        if($level==2){
            $where['u_sheng'] = $user_info['p_sheng'];
            $where['u_shi'] = $user_info['p_shi'];
        }
        if($level==3){
            $where['u_sheng'] = $user_info['p_sheng'];
            $where['u_shi'] = $user_info['p_shi'];
            $where['u_xian'] = $user_info['p_xian'];
        }
        /* 每页显示条数 */
        $num = 20;
        /* 页码 */
        $p = $_GET['p'] ? $_GET['p'] : 1;
        $info = $userinfo_model
            ->field('u_id,u_time,u_type,u_nickname,u_noticestate')
            ->page($p . ',' . $num)
            ->where($where)
            ->order('thinkphp.u_noticestate asc,thinkphp.u_time desc,thinkphp.u_id desc')
            ->select();

        /* 获取分页条 */
        $count = $userinfo_model->where($where)->count();
        $page_model = new \Think\Page($count, $num);
        $page_bar = $page_model->show();

        /*分页查询数据*/
        $this->assign('infos',$info);
        $this->assign('page_bar', $page_bar);
        $this->assign('count', $count);

        $this->display();
    }
    /*读取消息*/
    public function  read_notice(){
        $userinfo_model = M('userinfo');
        $str = $_REQUEST['u_id'];
        $where['u_id'] = array('in',$str);
        $data['u_noticestate'] = 1;
        $rs = $userinfo_model->where($where)->save($data);
        if($rs){
            $this->success('标记成功','',1);
        }else{
            $this->error('标记失败','',1);
        }
    }
    /*全部已读*/
    public function statusmodify(){
        $userinfo_model = M('userinfo');
        $str = $userinfo_model->field('u_id')->select();
        $newarray = [];
        foreach($str as $v){
            unset($v['row_number']);
            $newarray[]=$v['u_id'];
        }
        $uid = implode(',',$newarray);
        $where['u_id'] = array('in',$uid);
        $data['u_noticestate'] = 1;
        $rs = $userinfo_model->where($where)->save($data);
        if($rs){
            $this->success('标记成功','',1);
        }else{
            $this->error('标记失败','',1);
        }
    }

    /*个人中心*/
    public function PersonalCenter(){
        if(IS_POST){
            $admininfo_model = M('admininfo');
            $admininfo_find['a_nikename'] = I('a_nikename');
            $admininfo_find['a_id'] = array('neq',session('a_loginname.a_id'));
            $Inquire = $admininfo_model->where($admininfo_find)->getField('a_id');
            if($Inquire){
                $this->error("修改失败,昵称重复!",'',1);
            }
            $data = I('post.');
            $find['a_id'] = session('a_loginname.a_id');
            unset($data['a_id']);
            $rs = $admininfo_model->where($find)->save($data);
            if($rs){
                $this->success('修改成功','',1);
            }else{
                $this->error('修改失败','',1);
            }
        }else{
            $admininfo_model = D('admininfo');
            $find['a_id'] = session('a_loginname.a_id');
            $admininfo_info = $admininfo_model->where($find)->find();
            $this->assign('admininfo',$admininfo_info);
            $this->display();
        }
    }

    /*修改密码*/
    public function modifypwd(){
        if(IS_POST){
            $admininfo_model = M('admininfo');
            $pwd = session('a_loginname.a_loginpassword');
            if($pwd != md5(I('a_loginpassword'))){
                $this->error('旧密码错误，修改失败！','',1);
            }
            $data['a_loginpassword'] = md5(I('a_loginpassword1'));
            $find['a_id'] = session('a_loginname.a_id');
            unset($data['a_id']);
            $rs = $admininfo_model->where($find)->save($data);
            if($rs){
                session(null);
                $this->success('修改成功',U('index/index'),1);
            }else{
                $this->error('修改失败','',1);
            }
        }else{
            $this->display();
        }
    }

    /*导航类型与权限上级的联动查询*/
    public function search_pid()
    {
        $where['p_ptid'] = I("pt_id");
        $where['p_level'] = 0;
        $rs = M('permissioninfo')->field('p_id,p_name')->where($where)->select();
        $opt = '<option value="0">----------暂无上级-----------</option>';
        foreach($rs as $key=>$val){
            $opt .= "<option value='{$val['p_id']}'>{$val['p_name']}</option>";
        }
        $this->ajaxReturn($opt,"JSON");
    }

    /*维修类型与上下级级的联动查询*/
    public function search_rtpid()
    {
        $where['rt_pid'] = I("rt_id");
        $rs = M('repairtype')->field('rt_id,rt_receptionname')->where($where)->select();
        $opt = '<option value="">----------暂无上级-----------</option>';
        foreach($rs as $key=>$val){
            $opt .= "<option value='{$val['rt_id']}'>{$val['rt_receptionname']}</option>";
        }
        $this->ajaxReturn($opt,"JSON");
    }

    /*产品类型与上下级级的联动查询*/
    public function search_ptsuperior()
    {
        $where['pt_superior'] = I("pt_id");
        $rs = M('producttype')->field('pt_id,pt_receptionname')->where($where)->select();
        $opt = '<option value="">----------暂无上级-----------</option>';
        foreach($rs as $key=>$val){
            $opt .= "<option value='{$val['pt_id']}'>{$val['pt_receptionname']}</option>";
        }
        $this->ajaxReturn($opt,"JSON");
    }

    /*商家与单位和品牌的联动查询*/
    public function search_bidcid(){
        $where['b_uid'] = I("p_uid");
        $rs = M('brand')->field('b_id,b_name')->where($where)->select();
        $opt = '<option value="">-----请选择-----</option>';
        foreach($rs as $key=>$val){
            $opt .= "<option  value='{$val['b_id']}'>{$val['b_name']}</option>";
        }
        $where1['c_uid'] = I("p_uid");
        $rs1 = M('company')->field('c_id,c_name')->where($where1)->select();
        $opt1 = '<option value="">-----请选择-----</option>';
        foreach($rs1 as $key=>$val){
            $opt1 .= "<option  value='{$val['c_id']}'>{$val['c_name']}</option>";
        }
        $opts = array_merge(explode(",,,",$opt),explode(",,,",$opt1));
        $this->ajaxReturn($opts,"JSON");
    }
    /***
     *实现图片上传
     */
    public function ajaxupload() {
        $upload = new \Think\Upload(); /*// 实例化上传类*/
        $upload->maxSize = 3145728; /*// 设置附件上传大小*/
        $upload->exts = array('jpg', 'gif', 'png', 'jpeg'); /*// 设置附件上传类型*/
        $upload->rootPath = './Public/upload/banner/'; /*// 设置附件上传根目录*/
        $upload->subName= array('date','Ymd');
        $upload->savePath = ''; /*// 设置附件上传（子）目录*/
        /*  // 上传文件*/
        $info = $upload->upload();

        if (!$info) {/*// 上传错误提示错误信息*/
            $this->error($upload->getError());
        } else {//*/ 上传成功*/
            /*阿里云处理*/
            vendor('aliyunoss.autoload');
            $accessKeyId = "W3DcrNkgNRf6poJu";//去阿里云后台获取秘钥 W3DcrNkgNRf6poJu
            $accessKeySecret = "zgNuEiuEs8Vd8yBbIMCMWAeOirAzTa";//去阿里云后台获取秘钥 zgNuEiuEs8Vd8yBbIMCMWAeOirAzTa
            $endpoint = "http://oss-cn-shanghai.aliyuncs.com ";//你的阿里云OSS地址
            $ossClient = new \OSS\OssClient($accessKeyId, $accessKeySecret, $endpoint);

            $bucket= "chongmai";//oss中的文件上传空间 fengkuanglueduo
            $object = 'imgall/'.date('Ymd').'/'.$info['upload_file']['savename'];//想要保存文件的名称
            try{
                $info=$ossClient->uploadFile($bucket,$object,'./Public/upload/banner/'. $info['upload_file']['savepath'] . $info['upload_file']['savename']);
                $aliyun_url=$info['oss-request-url'];
                $this->success('上传成功',$aliyun_url,1);
            } catch(OssException $e) {
                $this->error($e->getMessage(),'',1);
            }
        }
    }
    /***
     *实现图片上传2
     */
    public function ajaxuploads() {
        $upload = new \Think\Upload(); /*// 实例化上传类*/
        $upload->maxSize = 3145728; /*// 设置附件上传大小*/
        $upload->exts = array('jpg', 'gif', 'png', 'jpeg'); /*// 设置附件上传类型*/
        $upload->rootPath = './Public/upload/banner/'; /*// 设置附件上传根目录*/
        $upload->subName= array('date','Ymd');
        $upload->savePath = ''; /*// 设置附件上传（子）目录*/
        /*  // 上传文件*/
        $info = $upload->upload();

        $key=array_keys($info);
        $file_path='./Public/upload/banner/'.$info[$key[0]]['savepath'];
        $savename=$info[$key[0]]['savename'];
        $file=$file_path.$savename;

        if (!$info) {/*// 上传错误提示错误信息*/
            $this->error($upload->getError());
        } else {//*/ 上传成功*/
            /*阿里云处理*/
            vendor('aliyunoss.autoload');
            $accessKeyId = "W3DcrNkgNRf6poJu";//去阿里云后台获取秘钥 W3DcrNkgNRf6poJu
            $accessKeySecret = "zgNuEiuEs8Vd8yBbIMCMWAeOirAzTa";//去阿里云后台获取秘钥 zgNuEiuEs8Vd8yBbIMCMWAeOirAzTa
            $endpoint = "http://oss-cn-shanghai.aliyuncs.com ";//你的阿里云OSS地址
            $ossClient = new \OSS\OssClient($accessKeyId, $accessKeySecret, $endpoint);

            $bucket= "chongmai";//oss中的文件上传空间 fengkuanglueduo
            $object = 'imgall/'.date('Ymd').'/'.$savename;//想要保存文件的名称

            try{
                $info=$ossClient->uploadFile($bucket,$object,$file);
                $aliyun_url=$info['oss-request-url'];
                unlink($file);
                rmdir($file_path);
                $this->ajaxReturn(array('error' => 0, 'url' => $aliyun_url));
            } catch(OssException $e) {
                unlink($file);
                rmdir($file_path);
                $this->ajaxReturn(array('error' => 1, 'message' => $e->getMessage()));
            }
        }
    }

    /*查询新添加的产品*/
    public function productnotices(){
        $product_model = D('ProductView');
        $where['p_noticestate'] = 0;
        /* 区域条件 */
        $user_info = session('p_loginname');
        $level = $user_info['p_level'];
        if($level==1){
            $where['uid_sheng'] = $user_info['p_sheng'];
        }
        if($level==2){
            $where['uid_sheng'] = $user_info['p_sheng'];
            $where['uid_shi'] = $user_info['p_shi'];
        }
        if($level==3){
            $where['uid_sheng'] = $user_info['p_sheng'];
            $where['uid_shi'] = $user_info['p_shi'];
            $where['uid_xian'] = $user_info['p_xian'];
        }
        $noticecount = $product_model->where($where)->count();
        $this->success('','',array('datas'=>$noticecount));
    }
    /*产品消息列表*/
    public function productnotice(){
        $product_model = D('ProductView');
        /* 区域条件 */
        $user_info = session('p_loginname');
        $level = $user_info['p_level'];
        if($level==1){
            $where['uid_sheng'] = $user_info['p_sheng'];
        }
        if($level==2){
            $where['uid_sheng'] = $user_info['p_sheng'];
            $where['uid_shi'] = $user_info['p_shi'];
        }
        if($level==3){
            $where['uid_sheng'] = $user_info['p_sheng'];
            $where['uid_shi'] = $user_info['p_shi'];
            $where['uid_xian'] = $user_info['p_xian'];
        }
        /* 每页显示条数 */
        $num = 20;
        /* 页码 */
        $p = $_GET['p'] ? $_GET['p'] : 1;
        $info = $product_model
            ->field('p_id,p_time,p_uid,p_name,uid_name,p_noticestate')
            ->page($p . ',' . $num)
            ->where($where)
            ->order('thinkphp.p_noticestate asc,thinkphp.p_time desc,thinkphp.p_id desc')
            ->select();

        /* 获取分页条 */
        $count = $product_model->where($where)->count();
        $page_model = new \Think\Page($count, $num);
        $page_bar = $page_model->show();

        /*分页查询数据*/
        $this->assign('infos',$info);
        $this->assign('page_bar', $page_bar);
        $this->assign('count', $count);

        $this->display();
    }
    /*产品读取消息*/
    public function  productread_notice(){
        $product_model = M('product');
        $str = $_REQUEST['p_id'];
        $where['p_id'] = array('in',$str);
        $data['p_noticestate'] = 1;
        $rs = $product_model->where($where)->save($data);
        if($rs){
            $this->success('标记成功','',1);
        }else{
            $this->error('标记失败','',1);
        }
    }
    /*产品全部已读*/
    public function productstatusmodify(){
        $product_model = M('product');
        $str = $product_model->field('p_id')->select();
        $newarray = [];
        foreach($str as $v){
            unset($v['row_number']);
            $newarray[]=$v['p_id'];
        }
        $uid = implode(',',$newarray);
        $where['p_id'] = array('in',$uid);
        $data['p_noticestate'] = 1;
        $rs = $product_model->where($where)->save($data);
        if($rs){
            $this->success('标记成功','',1);
        }else{
            $this->error('标记失败','',1);
        }
    }
    /*查询新添加的系统承接订单条数*/
    public function systemordersnotices(){
        $servicedemand_model = D('servicedemandView');
        $where['cuid'] = '1000000';
        $where['sd_state'] = array('not in','-1,-2');
        /* 区域条件 */
        $user_info = session('p_loginname');
        $level = $user_info['p_level'];
        if($level==1){
            $where['uid_sheng'] = $user_info['p_sheng'];
        }
        if($level==2){
            $where['uiduid_sheng'] = $user_info['p_sheng'];
            $where['uiduid_shi'] = $user_info['p_shi'];
        }
        if($level==3){
            $where['uid_sheng'] = $user_info['p_sheng'];
            $where['uid_shi'] = $user_info['p_shi'];
            $where['uid_xian'] = $user_info['p_xian'];
        }
        $noticecount = $servicedemand_model->where($where)->count();
        $this->success('','',array('datas'=>$noticecount));
    }

}