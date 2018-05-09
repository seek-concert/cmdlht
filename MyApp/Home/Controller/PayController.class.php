<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-07-12
 * Time: 10:22
 */

namespace Home\Controller;

class PayController extends AuthController
{
    /*支付记录*/
    public function index_list(){
        $pay_model = D('payView');
        /* 查询条件 */
        $where = array();
        /* 用户 */
        $uid_name = I('uid_name');
        if($uid_name){
            $where['uid_name'] = array('LIKE','%'.$uid_name.'%');
            $this->assign('uid_name',$uid_name);
        }
        /*创建时间*/
        $p_time1 = I('p_time1');
        $p_time2 = I('p_time2');
        if ($p_time1 && $p_time2) {
            $where['p_time'] = array(
                ['lt', date('Y-m-d H:i:s', strtotime($p_time2) + 24 * 60 * 60)],
                ['gt', date('Y-m-d H:i:s', strtotime($p_time1))]
            );
            $this->assign('p_time1',$p_time1);
            $this->assign('p_time2',$p_time2);
        }
        /*支付种类*/
        $p_type = I('p_type');
        if (is_numeric($p_type)) {
            $where['p_type'] = "$p_type";
            $this->assign('p_type',$p_type);
        }
        /*支付状态*/
        $p_state = I('p_state');
        if (is_numeric($p_state)) {
            $where['p_state'] = "$p_state";
            $this->assign('p_state',$p_state);
        }
        /*结账状态*/
        $p_jiezhang = I('p_jiezhang');
        if (is_numeric($p_jiezhang)) {
            $where['p_jiezhang'] = "$p_jiezhang";
            $this->assign('p_jiezhang',$p_jiezhang);
        }
        /* 每页显示条数 */
        $num =  20;
        /* 页码 */
        $p = $_GET['p'] ? $_GET['p'] : 1;

        /* 获取分页列表  */
        $pay_info = $pay_model
            ->where($where)
            ->page($p . ',' . $num)
            ->order('thinkphp.p_id desc')
            ->select();
        /* 获取分页条 */
        $count = $pay_model->where($where)->count();
        $page_model = new \Think\Page($count, $num);
        $page_bar = $page_model->show();

        /*分页查询数据*/
        $this->assign('pay_info',$pay_info);
        $this->assign('page_bar', $page_bar);
        $this->assign('count',$count);
        $this->display();
    }

    /*订单Excel导出*/
    public function excel_order(){
        $pay_model = D('payView');
        /*获取IDS*/
        $str =  $_REQUEST['ids'];
        if(!$str){
            $this->error('请选择要导出的数据','',1);
        }
        $find['p_id']=array('in',$str);
        $pay_data = $pay_model->field('p_jiezhang,p_state,p_ddid,p_id,pdmoney,ubankcard,ubankname,uphone,urealname,uidname')->where($find)->select();
        $newarray = [];
        foreach ($pay_data as $k=>$v){
            $v['pdmoney'] = sprintf("%.2f", $v['pdmoney']);
            if(!$v['uidname']){
                $v['uidname'] = '未填写';
            }
            if(!$v['ubankname']){
                $v['ubankname'] = '未填写';
            }
            if(!$v['urealname']){
                $v['urealname'] = '未填写';
            }
            if(!$v['uphone']){
                $v['uphone'] = '未填写';
            }
            if(!$v['ubankcard']){
                $v['ubankcard'] = '未填写';
            }
            /*是否结账*/
            if($v['p_jiezhang']==0){
                $v['p_jiezhang'] = '未结账';
            }
            if($v['p_jiezhang']==1){
                $v['p_jiezhang'] = '处理中';
            }
            if($v['p_jiezhang']==2){
                $v['p_jiezhang'] = '已结账';
            }
            if($v['p_jiezhang']==3){
                $v['p_jiezhang'] = '拒绝结账';
            }
            /*支付状态*/
            if($v['p_state']==0){
                $v['p_state'] = '申请支付';
            }
            if($v['p_state']==1){
                $v['p_state'] = '支付成功';
            }
            if($v['p_state']==2){
                $v['p_state'] = '支付失败';
            }

            $newarray[] =  array_values(array_reverse($v));
        }
        // 导出Exl
        $titel_data = array(array_reverse(array('是否结账','订单支付状态','订单ID','支付ID','商家银行卡号','银行卡名称','商家电话','商家真实姓名','店铺名称','订单金额','编号')));
        $data = array_merge($titel_data,$newarray);
        $dates = date("Y-m-d",time());
        $pay_model = M('pay');
        $jiezhangdata['p_jiezhang'] = '1';
        $jiezhangdata['p_jztime'] = date('Y-m-d H:i:s');
        $rs = $pay_model->where($find)->save($jiezhangdata);
        if($rs){
            createpay_xls($data,$dates);
        }else{
            $this->error('导出失败',U('index'),1);
        }

    }
    /*结账----状态修改*/
    public function state_modify(){
        $pay_model = D('pay');
        $find['p_id'] = array('in',I('p_id'));
        $data['p_jztime'] = date('Y-m-d H:i:s');
         $data['p_jiezhang'] = I('p_jiezhang');
        if($data['p_jiezhang']=="3"){
            $data['p_jjcontent'] = I('p_jjcontent');
        }
        $rs = $pay_model->where($find)->save($data);
        if($rs){
            $this->success('修改成功','',1);
        }else{
            $this->error('修改失败','',1);
        }

    }
}