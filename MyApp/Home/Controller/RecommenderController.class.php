<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-07-13
 * Time: 16:07
 */

namespace Home\Controller;

class RecommenderController extends AuthController
{
    /*商家列表---显示*/
    public function index_list(){
        $userinfo_model = D('UserinfoView');
        /* 查询条件 */
        $where = array();
        /* 登陆账号（手机号码） */
        $uloginname = I('u_loginname');
        if ($uloginname) {
            $where['u_loginname'] = $uloginname;
            $this->assign('uloginname',$uloginname);
        }
        /*店铺名称*/
        $unickname = trim(I('u_shopname'));
        if ($unickname) {
            $where['u_shopname'] = array('LIKE','%'.$unickname.'%');
            $this->assign('u_shopname',$unickname);
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
        $where['u_type'] = "3";
        /* 每页显示条数 */
        $num = 20;
        /* 页码 */
        $p = $_GET['p'] ? $_GET['p'] : 1;

        /* 获取分页列表  */
        $userinfo_info = $userinfo_model
            ->where($where)
            ->where($this->level_where)
            ->page($p . ',' . $num)
            ->order('thinkphp.u_time desc')
            ->select();

        /* 获取分页条 */
        $count = $userinfo_model->where($where)->where($this->level_where)->count();
        $page_model = new \Think\Page($count, $num);
        $page_bar = $page_model->show();

        /*查询所有的已经推荐商家的ID*/
        $recommender_model = M('recommender');
        $recommender_info = $recommender_model->field('r_uid')->select();
        $uid_ids = [];
        foreach ($recommender_info as $v){
                unset($v['row_number']);
                $uid_ids[] = $v['r_uid'];
        }
        $this->assign('uidids',$uid_ids);
        /*分页查询数据*/
        $this->assign('userinfo_info', $userinfo_info);
        $this->assign('page_bar', $page_bar);
        $this->assign('count', $count);
        $this->display();
    }
    /*商家列表----添加*/
    public function insert(){
        $uid = I('u_id');
        $this->assign('uid',$uid);
        if(IS_POST){
            $recommender_model = D('recommender');
            $data = $recommender_model->create();
            if(!$data){
                $this->error($recommender_model->getError(), '',1);
            }
            unset($data['r_id']);
            /*数据添加*/
            $rs = $recommender_model->add($data);
            if (!$rs) {
                $this->error("添加失败",'',1);
            }else{
                $this->success('添加成功','',1);
            }
        }else{
            $uid = I('u_id');
            $this->assign('uid',$uid);
            $this->display();
        }

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

    /*用户统计*/
    public function statistics(){

        if(IS_POST){
            $userinfo_model = M('userinfo');
            $year = I('yeararrays');
            $month = I('month');
            if($month&&!$year){
                $this->error('请选择年份！','',1);
            }

            $where="u_type=3";
            if($year){
                $where.=" and year(u_time)=year('$year-01-01')";
                $rs =$userinfo_model->field('count(*) as numbers,CONVERT(varchar(7),u_time,111) as times')->where($where)->group('(CONVERT(varchar(7),u_time,111))')->select();
            }
            if ($month){
                $where.=" and month(u_time)=month('2017-$month-01')";
                $rs =$userinfo_model->field('count(*) as numbers,CONVERT(varchar(10),u_time,111) as times')->where($where)->group('(CONVERT(varchar(10),u_time,111))')->select();
            }
            if(!$year&&!$month){
                $rs =$userinfo_model->field('count(*) as numbers,CONVERT(varchar(4),u_time,111) as times')->where('u_type=3')->group('(CONVERT(varchar(4),u_time,111))')->select();
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

            $rs =$userinfo_model->field('count(*) as numbers,CONVERT(varchar(4),u_time,111) as times')->where('u_type=3')->group('(CONVERT(varchar(4),u_time,111))')->select();
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

    /*取消推荐商家*/
    public function del_recommender(){
        $recommender_model = M('recommender');
        $find['r_uid'] = I('r_uid');
        $rs = $recommender_model->where($find)->delete();
        if($rs){
            $this->success('取消成功','',1);
        }else{
            $this->error('取消失败','',1);
        }
    }
}