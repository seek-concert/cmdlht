<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-05-27
 * Time: 11:13
 */

namespace Home\Controller;

class UserinfoController extends AuthController
{
    /*用户-列表*/
    public function index_list()
    {
        $userinfo_model = D('userinfo');
        /* 查询条件 */
        $where = array();

        /* 账号类型*/
        $utype = I('u_type');
        if ($utype) {
            $where['userinfo.u_type'] = $utype;
            $this->assign('utype',$utype);
        }
        /* 登陆账号（手机号码） */
        $uloginname = I('u_loginname');
        if ($uloginname) {
            $where['userinfo.u_loginname'] = $uloginname;
            $this->assign('uloginname',$uloginname);
        }
        /*昵称*/
        $unickname = trim(I('u_nickname'));
        if ($unickname) {
            $where['userinfo.u_nickname'] = array('LIKE','%'.$unickname.'%');
            $this->assign('unickname',$unickname);
        }
        /*注册时间*/
        $utime1 = I('u_time1');
        $utime2 = I('u_time2');
        if ($utime1 && $utime2) {
            $where['userinfo.u_time'] = array(
                ['lt', date('Y-m-d H:i:s', strtotime($utime2) + 24 * 60 * 60)],
                ['gt', date('Y-m-d H:i:s', strtotime($utime1))]
            );
            $this->assign('utime1',$utime1);
            $this->assign('utime2',$utime2);
        }
        /*账号状态*/
        $ustate = I('u_state');
        if (is_numeric($ustate)) {
            $where['userinfo.u_state'] = "$ustate";
            $this->assign('ustate',$ustate);
        }
        /*用户*/
        $where['userinfo.u_type'] = "1";
        /* 用户区域条件 */
        $user_info = $this->user_info;
        $level = $user_info['p_level'];
        if($level==1){
            $where['ud.ua_province'] = $user_info['p_sheng'];
        }
        if($level==2){
            $where['ud.ua_province'] = $user_info['p_sheng'];
            $where['ud.ua_city'] = $user_info['p_shi'];
        }
        if($level==3){
            $where['ud.ua_province'] = $user_info['p_sheng'];
            $where['ud.ua_city'] = $user_info['p_shi'];
            $where['ud.ua_county'] = $user_info['p_xian'];
        }
        /*默认地址*/
        $where['ud.ua_moren'] = 1;
        /* 每页显示条数 */
        $num = 20;
        /* 页码 */
        $p = $_GET['p'] ? $_GET['p'] : 1;

        /* 获取分页列表  */
        $userinfo_info = $userinfo_model
            ->join('useraddress as ud ON ud.ua_uid = userinfo.u_id','left')
            ->page($p . ',' . $num)
            ->where($where)
            ->order('thinkphp.u_id desc')
            ->select();

        /* 获取分页条 */
        $count = $userinfo_model
            ->join('useraddress as ud ON ud.ua_uid = userinfo.u_id','left')
            ->where($where)
            ->count();

        $page_model = new \Think\Page($count, $num);
        $page_bar = $page_model->show();


        /*分页查询数据*/
        $this->assign('userinfo_info', $userinfo_info);
        $this->assign('page_bar', $page_bar);
        $this->assign('count', $count);
        $this->display();
    }

    /*用户-下级列表*/
    public function xiaji_detail(){
        $uid = I('uid');
        $this->assign('uid',$uid);
      $lv = I('lv');
      $lv = $lv-1;
        $this->assign('lv',$lv);
        $userinfo_model = D('userinfo');
        /* 查询条件 */
        $where = array();

        /* 账号类型*/
        $utype = I('u_type');
        if ($utype) {
            $where['u_type'] = $utype;
            $this->assign('utype',$utype);
        }
        /* 登陆账号（手机号码） */
        $uloginname = I('u_loginname');
        if ($uloginname) {
            $where['u_loginname'] = $uloginname;
            $this->assign('uloginname',$uloginname);
        }
        /*昵称*/
        $unickname = trim(I('u_nickname'));
        if ($unickname) {
            $where['u_nickname'] = array('LIKE','%'.$unickname.'%');
            $this->assign('unickname',$unickname);
        }
        /*注册时间*/
        $utime1 = I('u_time1');
        $utime2 = I('u_time2');
        if ($utime1 && $utime2) {
            $where['u_time'] = array(
                ['lt', date('Y-m-d H:i:s', strtotime($utime2) + 24 * 60 * 60)],
                ['gt', date('Y-m-d H:i:s', strtotime($utime1))]
            );
            $this->assign('utime1',$utime1);
            $this->assign('utime2',$utime2);
        }
        /*账号状态*/
        $ustate = I('u_state');
        if (is_numeric($ustate)) {
            $where['u_state'] = "$ustate";
            $this->assign('ustate',$ustate);
        }

        $where['u_superior'] = $uid;
        /* 每页显示条数 */
        $num = 20;
        /* 页码 */
        $p = $_GET['p'] ? $_GET['p'] : 1;

        /* 获取分页列表  */
        $userinfo_info = $userinfo_model
            ->where($where)
            ->where($this->level_where)
            ->page($p . ',' . $num)
            ->order('thinkphp.u_id desc')
            ->select();

        /* 获取分页条 */
        $count = $userinfo_model->where($where)->where($this->level_where)->count();
        $page_model = new \Think\Page($count, $num);
        $page_bar = $page_model->show();


        /*分页查询数据*/
        $this->assign('userinfo_info', $userinfo_info);
        $this->assign('page_bar', $page_bar);
        $this->assign('count', $count);
        $this->display();
    }

    /*用户下级人数查询*/
    public function next_count(){
        $uid = I('uid');
        $this->assign('uid',$uid);
        if(IS_POST){
            $utype = I('utype');
            if($utype==1){
                /*注册时间*/
                    $utime1 = strtotime(I('u_time1')) + 24 * 60 * 60;
                    $utime2 = strtotime(I('u_time2'));

                $rs = M()->query("WITH cte_ct(u_id,u_superior,lv)as(select u_id, u_superior,0 as lv from userinfo
                            where u_id = $uid union all select b.u_id,b.u_superior,t.lv + 1 as lv from userinfo
                            b join cte_ct t on b.u_superior = t.u_id where lv<3)select b.u_time as utime from (select u_id, lv, row_number()
                            over(order by cte_ct.u_id) as rid  from cte_ct)a,userinfo b where a.u_id = b.u_id and b.u_id!= $uid");
                if ($utime1 && $utime2) {
                    $time_count = 0;
                    foreach ($rs as $k=>$v){
                        if($utime2<strtotime($v['utime'])&&$utime1>strtotime($v['utime'])){
                            $time_count++;
                        }
                    }
                }else{
                    $time_count = count($rs);
                }
                $data['time_count'] = $time_count;
            }else{
                $utime1 = I('u_time1');
                $utime2 = I('u_time2');
                if ($utime1 && $utime2) {
                    $where['u_time'] = array(
                        ['lt', date('Y-m-d H:i:s', strtotime($utime2) + 24 * 60 * 60)],
                        ['gt', date('Y-m-d H:i:s', strtotime($utime1))]
                    );
                    $this->assign('utime1',$utime1);
                    $this->assign('utime2',$utime2);
                }
                $where['u_superior'] = $uid;
                $time_count =  D('userinfo')->where($where)->count();
                $data['time_count'] = $time_count;
            }

           $this->success('获取成功','',$data);
        }

        $this->display();
    }

    /* 异步修改状态 */
    public function status_modify()
    {
        $action = $_REQUEST['action'];
        $ids = $_REQUEST['ids'];
        if (!$ids) {
            $this->error('至少选择一项！', '', 1);
        }
        if (!$action) {
            $this->error('操作错误', '', 1);
        }
        $userinfo_model = M('userinfo');
        $where['u_id'] = array('in', $ids);
        if ($action == 'on') {
            $data['u_state'] = '1';
        }
        if ($action == 'off') {
            $data['u_state'] = '0';
        }
        $result = $userinfo_model->where($where)->save($data);
        if ($result) {
            $this->success('操作成功', '', 1);
        } else {
            $this->error('操作失败', '', 1);
        }
    }

    /*用户-添加*/
//    public function insert()
//    {
//        if(IS_POST)
//        {
//            $userinfo_model = D('userinfo');
//            $useraddress_model = D('useraddress');
//            /*====开启事务处理=====*/
//            $model = M();
//            $model->startTrans();
//            /*===========================添加用户====================================*/
//            /*数据创建及模型验证*/
//            $data = $userinfo_model->create();
//            if(!$data){
//                $this->error($userinfo_model->getError(), '',1);
//            }
//            /*生成16位随机字符串*/
//            $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01111456789';
//            $unumber = '';
//            for ( $i = 0; $i < 16; $i++ )
//            {
//                $unumber .= $chars[mt_rand(0,strlen($chars)-1)];
//            }
//            $data['u_number'] = $unumber;
//            $data['u_time'] = date('Y-m-d H:i:s');
//            $data['u_level'] = 0;
//            $data['u_money'] = 0;
//            $data['u_sgtype'] = "";
//            $data['u_tuiguang'] = "";
//            $data['u_noticestate'] = 0;
//            $data['u_fenxiaomoney'] = 0;
//            $utype = I('u_type');
//            /*当前为用户时-数据的默认设置*/
//            if($utype == 1){
//               $data['u_toexamine'] = 1;
//               $data['u_tel'] = "";
//               $data['u_address'] = "";
//               $data['u_longitude'] = "";
//               $data['u_latitude'] = "";
//               $data['u_shopname'] = "";
//               $data['u_superior'] = 0;
//               $data['u_psuperior'] = 0;
//               $data['u_aftermarketcalls'] = "";
//               $data['u_appoint']  = 0;
//               $data['u_businesslicense'] = "";
//               $data['u_storemap']= "";
//               $data['u_environmental']= "";
//               $data['u_bankcard'] = "";
//               $data['u_carded'] = "";
//               $data['u_realname'] = "";
//               $data['u_cardedimg'] = "";
//               $data['u_shangban'] = 0;
//               $data['u_shanggong'] = 0;
//               $data['u_bankname'] = "";
//               $data['u_bankaddress'] = "";
//            }
//            /*当为师傅时-数据的默认设置*/
//            if($utype == 2||$utype == 4){
//                if($data['u_appoint']==0){
//                    $data['u_shopname'] = "";
//                    $data['u_aftermarketcalls'] = "";
//                    $data['u_businesslicense'] = "";
//                    $data['u_storemap']= "";
//                    $data['u_environmental']= "";
//                    $data['u_superior'] = 0;
//                    $data['u_psuperior'] = 0;
//                }else{
//                    $data['u_shopname'] = "";
//                    $data['u_aftermarketcalls'] = "";
//                    $data['u_environmental']= "";
//                    $data['u_superior'] = 0;
//                    $data['u_psuperior'] = 0;
//                }
//                if(empty($data['u_realname'])){
//                    $this->error('真实姓名不能为空!', '',1);
//                }
//            }
//            /*当为商家时-数据的默认设置*/
//            if($utype == 3){
//                $data['u_bankname'] = I('u_bankname');
//                $data['u_bankcard'] = I('u_bankcard');
//                $data['u_carded'] = "";
//                $data['u_cardedimg'] = "";
//                $data['u_shangban'] = 0;
//                $data['u_shanggong'] = 0;
//                $data['u_superior'] = 0;
//                $data['u_psuperior'] = 0;
//                $data['u_appoint'] = 0;
//                if(empty($data['u_shopname'])){
//                    $this->error('店铺名称不能为空!', '',1);
//                }
//            }
//            unset($data['u_id']);
//            /*数据添加*/
//            $rs = $userinfo_model->add($data);
//
//            if (!$rs) {
//                $model->rollback();
//                $this->error("添加失败",'',1);
//            }
//
//            /*================添加用户地址=======================*/
//            /*数据创建及模型验证*/
//            $useraddress_data = $useraddress_model->create();
//            if(!$useraddress_data){
//                $this->error($useraddress_model->getError(), '',1);
//            }
//            $useraddress_data['ua_uid'] = $rs;
//            $useraddress_rs = $useraddress_model->add($useraddress_data);
//            if(!$useraddress_rs){
//                $model->rollback();
//                $this->error('添加失败','',1);
//            }else{
//                $model->commit();
//                $this->success('添加成功',U('index_list'),1);
//            }
//        }else{
//            /*调用添加模板*/
//            $this->display('insert');
//        }
//    }

    /*修改模板获取值*/
//    public function detail(){
//        /*获取模板对应的值*/
//        $userinfo_model = D('userinfo');
//        $uid = I('u_id');
//        $find['u_id'] = array('eq',$uid);
//        $userinfo_info = $userinfo_model->where($find)->find();
//        $this->assign('userinfo_info',$userinfo_info);
//        /*获取头像图片的值*/
//        $userinfo_info['u_favicon']= !empty($userinfo_info['u_favicon'])?explode(',', $userinfo_info['u_favicon']):array();
//        $ufavicon_imglist = $userinfo_info['u_favicon'];
//        $this->assign('ufaviconimg',$ufavicon_imglist);
//        /*获取身份证图片的值*/
//        $u_cardedimg = str_replace(",/Public/img/trash.png","",$userinfo_info['u_cardedimg']);
//        $ucardedimg_imglist = !empty($u_cardedimg)?explode(',', $u_cardedimg):array();
//        $this->assign('ucardedimg',$ucardedimg_imglist);
//        /*获取营业执照图片的值*/
//        $userinfo_info['u_businesslicense']= !empty($userinfo_info['u_businesslicense'])?explode(',', $userinfo_info['u_businesslicense']):array();
//        $ubusinesslicense_imglist = $userinfo_info['u_businesslicense'];
//        $this->assign('ubusinesslicenseimg',$ubusinesslicense_imglist);
//        /*获取实体店门面图片的值*/
//        $u_storemap = str_replace(",/Public/img/trash.png","",$userinfo_info['u_storemap']);
//        $ustoremap_imglist = !empty($u_storemap)?explode(',', $u_storemap):array();
//        $this->assign('ustoremapimg',$ustoremap_imglist);
//        /*获取产品销售环境图片的值*/
//        $u_environmental = str_replace(",/Public/img/trash.png","",$userinfo_info['u_environmental']);
//        $uenvironmental_imglist = !empty($u_environmental)?explode(',', $u_environmental):array();
//        $this->assign('uenvironmentalimg',$uenvironmental_imglist);
//        /*======================获取当前用户地址=====================*/
//        $useraddress_model = M('useraddress');
//        $useraddress_find['ua_uid'] = $uid;
//        $useraddress_info = $useraddress_model->where($useraddress_find)->find();
//        $this->assign('useraddress_info',$useraddress_info);
//        /*调用修改模板*/
//        $this->display('modify');
//    }

    /*执行修改*/
//    public function modify()
//    {
//        $uid = I('u_id');
//        if(IS_POST)
//        {
//            $userinfo_model = M('userinfo');
//            /*====开启事务处理=====*/
//            $model = M();
//            $model->startTrans();
//            /*=====================用户信息修改===========================*/
//            /*用户名判断*/
//            $name_find['u_loginname'] = I('u_loginname');
//            $name_find['u_id'] = array('neq',I('u_id'));
//            $Inquire = $userinfo_model->where($name_find)->field('u_id')->find();
//            if($Inquire){
//                $this->error("修改失败,登陆账号重复!",'',1);
//            }
//            /*密码修改判断*/
//            $password = I('u_loginpassword');
//            $where['u_id'] = I('u_id');
//            $password_info = $userinfo_model->where($where)->getField('u_loginpassword');
//            if($password != $password_info){
//                $pwd = md5($password);
//            }else{
//                $pwd = $password_info;
//            }
//            $data['u_loginpassword'] = $pwd;
//            /*执行修改*/
//            $where = array(
//                'u_id' => $uid
//            );
//            $data = I('post.');
//            unset($data['u_id']);
//            $utype = I('u_type');
//            /*当前为用户时-数据的默认设置*/
//            if($utype == 1){
//                $data['u_toexamine'] = 1;
//                $data['u_tel'] = "";
//                $data['u_address'] = "";
//                $data['u_longitude'] = "";
//                $data['u_latitude'] = "";
//                $data['u_shopname'] = "";
//                $data['u_superior'] = 0;
//                $data['u_psuperior'] = 0;
//                $data['u_aftermarketcalls'] = "";
//                $data['u_appoint']  = 0;
//                $data['u_businesslicense'] = "";
//                $data['u_storemap']= "";
//                $data['u_environmental']= "";
//                $data['u_bankcard'] = "";
//                $data['u_carded'] = "";
//                $data['u_realname'] = "";
//                $data['u_cardedimg'] = "";
//                $data['u_shangban'] = 0;
//                $data['u_shanggong'] = 0;
//                $data['u_bankname'] = "";
//            }
//            /*当为师傅时-数据的默认设置*/
//            if($utype == 2||$utype == 4){
//                if($data['u_appoint']==0){
//                    $data['u_shopname'] = "";
//                    $data['u_aftermarketcalls'] = "";
//                    $data['u_businesslicense'] = "";
//                    $data['u_storemap']= "";
//                    $data['u_environmental']= "";
//                    $data['u_superior'] = 0;
//                    $data['u_psuperior'] = 0;
//                }else{
//                    $data['u_shopname'] = "";
//                    $data['u_aftermarketcalls'] = "";
//                    $data['u_environmental']= "";
//                    $data['u_superior'] = 0;
//                    $data['u_psuperior'] = 0;
//                }
//            }
//            /*当为商家时-数据的默认设置*/
//            if($utype == 3){
//                $data['u_bankname'] = I('u_bankname');
//                $data['u_bankcard'] = I('u_bankcard');
//                $data['u_carded'] = "";
//                $data['u_shangban'] = 0;
//                $data['u_shanggong'] = 0;
//                $data['u_superior'] = 0;
//                $data['u_psuperior'] = 0;
//            }
//            $rs = $userinfo_model->where($where)->save($data);
//            if (!$rs) {
//                $model->rollback();
//                $this->error("修改失败",'',1);
//            }
//            /*================修改用户地址=======================*/
//            $useraddress_model = M('useraddress');
//            $useraddress_find['ua_uid'] = $uid;
//            $useraddress_data['ua_province'] = I('ua_province');
//            $useraddress_data['ua_city'] = I('ua_city');
//            $useraddress_data['ua_county'] = I('ua_county');
//            $useraddress_data['ua_address'] = I('ua_address');
//            $useraddress_data['ua_phone'] = I('ua_phone');
//            $useraddress_data['ua_name'] = I('ua_name');
//            $useraddress_data['ua_moren'] = I('ua_moren');
//            $uidcount = $useraddress_model->where($useraddress_find)->select();
//            if($uidcount){
//                $useraddress_rs = $useraddress_model->where($useraddress_find)->save($useraddress_data);
//            }else{
//                $useraddress_data['ua_uid'] = $uid;
//                $useraddress_rs = $useraddress_model->add($useraddress_data);
//            }
//
//            if(!$useraddress_rs){
//                $model->rollback();
//                $this->error('修改失败','',1);
//            }else{
//                $model->commit();
//                $this->success('修改成功','',1);
//            }
//        }else{
//            /*获取模板对应的值*/
//            $userinfo_model = D('userinfo');
//            $uid = I('u_id');
//            $find['u_id'] = array('eq',$uid);
//            $userinfo_info = $userinfo_model->where($find)->find();
//            $this->assign('userinfo_info',$userinfo_info);
//            /*获取头像图片的值*/
//            $userinfo_info['u_favicon']= !empty($userinfo_info['u_favicon'])?explode(',', $userinfo_info['u_favicon']):array();
//            $ufavicon_imglist = $userinfo_info['u_favicon'];
//            $this->assign('ufaviconimg',$ufavicon_imglist);
//            /*获取身份证图片的值*/
//            $u_cardedimg = str_replace(",/Public/img/trash.png","",$userinfo_info['u_cardedimg']);
//            $ucardedimg_imglist = !empty($u_cardedimg)?explode(',', $u_cardedimg):array();
//            $this->assign('ucardedimg',$ucardedimg_imglist);
//            /*获取营业执照图片的值*/
//            $userinfo_info['u_businesslicense']= !empty($userinfo_info['u_businesslicense'])?explode(',', $userinfo_info['u_businesslicense']):array();
//            $ubusinesslicense_imglist = $userinfo_info['u_businesslicense'];
//            $this->assign('ubusinesslicenseimg',$ubusinesslicense_imglist);
//            /*获取实体店门面图片的值*/
//            $u_storemap = str_replace(",/Public/img/trash.png","",$userinfo_info['u_storemap']);
//            $ustoremap_imglist = !empty($u_storemap)?explode(',', $u_storemap):array();
//            $this->assign('ustoremapimg',$ustoremap_imglist);
//            /*获取产品销售环境图片的值*/
//            $u_environmental = str_replace(",/Public/img/trash.png","",$userinfo_info['u_environmental']);
//            $uenvironmental_imglist = !empty($u_environmental)?explode(',', $u_environmental):array();
//            $this->assign('uenvironmentalimg',$uenvironmental_imglist);
//            /*======================获取当前用户地址=====================*/
//            $useraddress_model = M('useraddress');
//            $useraddress_find['ua_uid'] = $uid;
//            $useraddress_info = $useraddress_model->where($useraddress_find)->find();
//            $this->assign('useraddress_info',$useraddress_info);
//            /*调用修改模板*/
//            $this->display('modify');
//        }
//    }


    /*更改状态*/
    public function modify_state(){
        $userinfo_model = M('userinfo');
        $where['u_id'] = $_REQUEST['uid'];
        $dstate = I('ustate');
        if($dstate=="1"){
            $data['u_state'] = '0';
            $rs = $userinfo_model->where($where)->save($data);
        }else{
            $data['u_state'] = '1';
            $rs = $userinfo_model->where($where)->save($data);
        }
        if($rs){
            $this->success('更改成功','',1);
        }else{
            $this->error('更改失败','',1);
        }
    }

    /*用户统计*/
    public function statistics(){

        if(IS_POST){
            $userinfo_model = M('userinfo');
            $year = I('yeararrays');
            $month = I('month');
            $types = I('types');
            if($month&&!$year){
                $this->error('请选择年份！','',1);
            }
            if($types){
                $where="u_type=$types";
            }else{
                $where="1=1";
            }
            if($year){
                $where.=" and year(u_time)=year('$year-01-01')";
                $rs_count = $userinfo_model->where($where)->count();
                $rs =$userinfo_model->field('count(*) as numbers,CONVERT(varchar(7),u_time,111) as times')->where($where)->group('(CONVERT(varchar(7),u_time,111))')->select();
            }
            if ($month){
                $where.=" and month(u_time)=month('2017-$month-01')";
                $rs_count = $userinfo_model->where($where)->count();
                $rs =$userinfo_model->field('count(*) as numbers,CONVERT(varchar(10),u_time,111) as times')->where($where)->group('(CONVERT(varchar(10),u_time,111))')->select();
            }
            if(!$year&&!$month){
                $rs_count = $userinfo_model->where($where)->count();
                $rs =$userinfo_model->field('count(*) as numbers,CONVERT(varchar(4),u_time,111) as times')->group('(CONVERT(varchar(4),u_time,111))')->select();
            }
            $newarray = [];
            foreach ($rs as $v){
                unset($v['row_number']);
                if(strlen($v['times'])==4){
                    $newarray[] = array($v['times'],$v['numbers']);
                }
                if(strlen($v['times'])==7){
                    $newarray[] = array(substr($v['times'],5,2),$v['numbers']);
                }
                if(strlen($v['times'])==10){
                    $newarray[] = array(substr($v['times'],8,2),$v['numbers']);
                }
            }
            if($newarray){
                $this->success('','',array('datas'=>$newarray,'man_count'=>$rs_count));
            }
        }else{
            $userinfo_model = M('userinfo');
            $rs =$userinfo_model->field('distinct CONVERT(varchar(4),u_time,120) as years')->select();
            $this->assign('yeararray',$rs);

            $rs =$userinfo_model->field('count(*) as numbers,CONVERT(varchar(4),u_time,111) as times')->group('(CONVERT(varchar(4),u_time,111))')->select();
            $newarray = [];
            foreach ($rs as $v){
                unset($v['row_number']);
                $newarray[] = array($v['times'],$v['numbers']);
            }
            $a = json_encode($newarray);
            $this->assign('timedata',$a);
            $this->display();
        }
    }


}