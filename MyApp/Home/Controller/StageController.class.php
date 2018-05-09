<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-07-06
 * Time: 09:07
 */

namespace Home\Controller;

class StageController extends AuthController
{
    /*付款阶段---列表显示*/
    public function index_list(){
        $stage_model = D('stage');
        /* 查询条件 */
        $where = array();
        /* 开始时间 */
        $sstartime1 = I('s_startime1');
        $sstartime2 = I('s_startime2');
        if($sstartime1&&$sstartime2){
            $where['s_startime'] = array(
                ['lt',date('Y-m-d H:i:s',strtotime($sstartime2)+24*60*60)],
                ['gt',date('Y-m-d H:i:s',strtotime($sstartime1))]
            );
            $this->assign('sstartime1',$sstartime1);
            $this->assign('sstartime2',$sstartime2);
        }
        /* 结束时间 */
        $sendtime1 = I('s_endtime1');
        $sendtime2 = I('s_endtime2');
        if($sendtime1&&$sendtime2){
            $where['s_endtime'] = array(
                ['lt',date('Y-m-d H:i:s',strtotime($sendtime2)+24*60*60)],
                ['gt',date('Y-m-d H:i:s',strtotime($sendtime1))]
            );
            $this->assign('sendtime1',$sendtime1);
            $this->assign('sendtime2',$sendtime2);
        }
        /* 支付状态 */
        $spay = I('s_pay');
        if(is_numeric($spay)){
            $where['s_pay'] = "$spay";
            $this->assign('spay',$spay);
        }
        /* 每页显示条数 */
        $num =  20;
        /* 页码 */
        $p = $_GET['p'] ? $_GET['p'] : 1;

        /* 获取分页列表  */
        $stage_info = $stage_model
            ->where($where)
            ->page($p . ',' . $num)
            ->select();


        /* 获取分页条 */
        $count = $stage_model->where($where)->count();
        $page_model = new \Think\Page($count, $num);
        $page_bar = $page_model->show();

        /*分页查询数据*/
        $this->assign('stage_info',$stage_info);
        $this->assign('page_bar', $page_bar);
        $this->assign('count',$count);
        $this->display();
    }
    /*付款阶段---模板详情*/
    public function detail(){
        $stage_model = D('stage');
        $find['s_id'] = I('s_id');
        $stage_info = $stage_model->where($find)->find();
        $this->assign('info',$stage_info);
        $this->display('modify');
    }
}