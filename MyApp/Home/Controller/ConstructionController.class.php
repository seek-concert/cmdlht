<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-07-21
 * Time: 20:05
 */

namespace Home\Controller;

class ConstructionController extends AuthController
{
    /*师傅---列表*/
    public function index_list(){
        $userinfo_model = D('userinfo');
        /* 查询条件 */
        $where = array();
        /* 登陆账号（手机号码） */
        $uloginname = I('u_loginname');
        if ($uloginname) {
            $where['u_loginname'] = $uloginname;
            $this->assign('uloginname',$uloginname);
        }
        /*真实姓名*/
        $unickname = trim(I('u_realname'));
        if ($unickname) {
            $where['u_realname'] = array('LIKE','%'.$unickname.'%');
            $this->assign('u_realname',$unickname);
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
        $where['u_type'] = "2";
        /* 每页显示条数 */
        $num = 20;
        /* 页码 */
        $p = $_GET['p'] ? $_GET['p'] : 1;

        /* 获取分页列表  */
        $userinfo_info = $userinfo_model
            ->where($where)
            ->where($this->level_where)
            ->order('thinkphp.u_time desc')
            ->page($p . ',' . $num)
            ->select();

        /* 获取分页条 */
        $count = $userinfo_model->where($where)->where($this->level_where)->count();
        $page_model = new \Think\Page($count, $num);
        $page_bar = $page_model->show();

//        /*施工类型*/
//        $constructiontype_model = M('constructiontype');
//        $userinfo_count =  $userinfo_model->where($where)->count();
//        $constructiontype_name = [];
//        $constructiontype_count = [];
//       for($i = 0;$i<$userinfo_count;$i++){
//           $constructiontype_find['ct_id'] = array('in',$userinfo_info[$i]['u_sgtype']);
//           $constructiontype_name[] = $constructiontype_model->field('ct_name')->where($constructiontype_find)->select();
//           $constructiontype_count[] = $constructiontype_model->field('ct_name')->where($constructiontype_find)->count();
//
//       }
//        $this->assign('constructiontype_name',$constructiontype_name);
//        $this->assign('constructiontypecount',$constructiontype_count);

        /*分页查询数据*/
        $this->assign('userinfo_info', $userinfo_info);
        $this->assign('page_bar', $page_bar);
        $this->assign('count', $count);
        $this->display();
    }

    /*接单记录*/
    public function jiedan_detail(){
        $uid = I('uid');
       $this->assign('uid',$uid);
        $servicedemand_model = D('servicedemandView');
        /* 查询条件 */
        $where = array();
        /* 用户i*/
        $uidname = I('uid_name');
        if($uidname){
            $where['uid_name'] = array('LIKE','%'.$uidname.'%');
            $this->assign('uidname',$uidname);
        }
        /* 客户电话*/
        $sd_phone = I('sd_phone');
        if($sd_phone){
            $where['sd_phone'] = $sd_phone;
            $this->assign('sd_phone',$sd_phone);
        }
        /* 提交时间 */
        $sdtime1 = I('sd_time1');
        $sdtime2 = I('sd_time2');
        if($sdtime1&&$sdtime2){
            $where['sd_time'] = array(
                ['lt',date('Y-m-d H:i:s',strtotime($sdtime2)+24*60*60)],
                ['gt',date('Y-m-d H:i:s',strtotime($sdtime1))]
            );
            $this->assign('sdtime1',$sdtime1);
            $this->assign('sdtime2',$sdtime2);
        }
        /* 维修类型 */
        $sdwxtype = I('sd_wxtype');
        if($sdwxtype){
            $where['sd_wxtype'] = $sdwxtype;
            $this->assign('sdwxtype',$sdwxtype);
        }
        /* 需求进度 */
        $sd_state = I('sd_state');
        if($sd_state){
            $where['sd_state'] = $sd_state;
            $this->assign('sd_state',$sd_state);
        }
        /* 提交类型 */
        $sdtjtype = I('sd_tjtype');
        if($sdtjtype){
            $where['sd_tjtype'] = $sdtjtype;
            $this->assign('sdtjtype',$sdtjtype);
        }
        /* $where['cuid'] = array('neq','1000000');*/
        $where['cuid'] = $uid;
        /* 每页显示条数 */
        $num =  20;
        /* 页码 */
        $p = $_GET['p'] ? $_GET['p'] : 1;

        /* 获取分页列表  */
        $servicedemand_info = $servicedemand_model
            ->where($where)
            ->page($p . ',' . $num)
            ->order('thinkphp.sd_id desc')
            ->select();
        /* 获取分页条 */
        $count = $servicedemand_model->where($where)->count();
        $page_model = new \Think\Page($count, $num);
        $page_bar = $page_model->show();

        /*查询施工需求中包含的所有用户需求ID*/
        $construction_model = M('construction');
        $csdid_info = $construction_model->field('c_sdid')->select();
        $csdids = [];
        foreach ($csdid_info as $v){
            unset($v['row_number']);
            $csdids[] = $v['c_sdid'];
        }
        $this->assign('csdids',$csdids);
        /*分页查询数据*/
        $this->assign('servicedemand_info',$servicedemand_info);
        $this->assign('page_bar', $page_bar);
        $this->assign('count',$count);
        $this->display();
    }
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

    /*更改维修状态*/
    public function modify_shanggong(){
        $userinfo_model = M('userinfo');
        $where['u_id'] = $_REQUEST['uid'];
        $dstate = I('ushanggong');
        if($dstate=="1"){
            $data['u_shanggong'] = '0';
            $rs = $userinfo_model->where($where)->save($data);
        }else{
            $data['u_shanggong'] = '1';
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
            if($month&&!$year){
                $this->error('请选择年份！','',1);
            }

            $where="u_type=2";
            if($year){
                $where.=" and year(u_time)=year('$year-01-01')";
                $rs =$userinfo_model->field('count(*) as numbers,CONVERT(varchar(7),u_time,111) as times')->where($where)->group('(CONVERT(varchar(7),u_time,111))')->select();
            }
            if ($month){
                $where.=" and month(u_time)=month('2017-$month-01')";
                $rs =$userinfo_model->field('count(*) as numbers,CONVERT(varchar(10),u_time,111) as times')->where($where)->group('(CONVERT(varchar(10),u_time,111))')->select();
            }
            if(!$year&&!$month){
                $rs =$userinfo_model->field('count(*) as numbers,CONVERT(varchar(4),u_time,111) as times')->where('u_type=2')->group('(CONVERT(varchar(4),u_time,111))')->select();
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
                $this->success('','',array('datas'=>$newarray));
            }
        }else{
            $userinfo_model = M('userinfo');
            $rs =$userinfo_model->field('distinct CONVERT(varchar(4),u_time,120) as years')->select();
            $this->assign('yeararray',$rs);

            $rs =$userinfo_model->field('count(*) as numbers,CONVERT(varchar(4),u_time,111) as times')->where('u_type=2')->group('(CONVERT(varchar(4),u_time,111))')->select();
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