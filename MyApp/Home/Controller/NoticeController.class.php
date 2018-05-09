<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-07-12
 * Time: 14:32
 */

namespace Home\Controller;

class NoticeController extends AuthController
{
    /*系统通知*/
    public function index_list(){
        $notice_model = D('noticeView');
        /* 查询条件 */
        $where = array();
        /*用户*/
        $uidname = I('uid_name');
        if($uidname){
            $where['uid_name'] = array('LIKE','%'.$uidname.'%');
            $this->assign('uid_name',$uidname);
        }
        /*添加时间*/
        $n_time1 = I('n_time1');
        $n_time2 = I('n_time2');
        if($n_time1&&$n_time2){
            $where['n_time'] = array(
                ['lt',date('Y-m-d H:i:s',strtotime($n_time2)+24*60*60)],
                ['gt',date('Y-m-d H:i:s',strtotime($n_time1))]
            );
            $this->assign('n_time1',$n_time1);
            $this->assign('n_time2',$n_time2);
        }
        /*标题*/
        $n_title = I('n_title');
        if($n_title){
            $where['n_title'] = array('LIKE','%'.$n_title.'%');
            $this->assign('n_title',$n_title);
        }
        /* 每页显示条数 */
        $num =  20;
        /* 页码 */
        $p = $_GET['p'] ? $_GET['p'] : 1;

        /* 获取分页列表  */
        $notice_info = $notice_model
            ->where($where)
            ->page($p . ',' . $num)
            ->order('thinkphp.n_id desc')
            ->select();


        /* 获取分页条 */
        $count = $notice_model->where($where)->count();
        $page_model = new \Think\Page($count, $num);
        $page_bar = $page_model->show();

        /*分页查询数据*/
        $this->assign('notice_info',$notice_info);
        $this->assign('page_bar', $page_bar);
        $this->assign('count',$count);
        $this->display();
    }
    /*发送界面*/
    public function inserts(){
        $this->display();
    }
    /*系统通知=====发送*/
    public function insert(){
        $notice_model = D('notice');
        $data = $notice_model->create();
        if(!$data){
            $this->error($notice_model->getError(),'',1);
        }
        $nuid = I('n_uid');
        $nuid = explode(',',$nuid);
        $valLength = count($nuid);
        $n_time= date('Y-m-d H:i:s');
        $n_state= '0';
        $n_del= '1';
        /*创建新数组*/
        $valArray = [];
        for($i=0;$i<$valLength;$i++){
            $valArray[] = array(
                'n_uid'=>$nuid[$i],
                'n_time'=>$n_time,
                'n_title'=>I('n_title'),
                'n_content'=>I('n_content'),
                'n_state'=>$n_state,
                'n_del'=>$n_del,
            );
        }
        $rs = $notice_model->addAll($valArray);
        if($rs){
            $this->success('发送成功','',1);
        }else{
            $this->error('发送失败','',1);
        }
    }
}