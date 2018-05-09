<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-07-13
 * Time: 08:53
 */

namespace Home\Controller;

class TixianController extends AuthController
{
    /*提现====列表展示*/
    public function index_list(){
        $tixian_model = D('tixianView');
        /* 查询条件 */
        $where = array();
        /* 用户 */
        $uid_name = I('uid_name');
        if($uid_name){
            $where['uid_name'] = array('LIKE','%'.$uid_name.'%');
            $this->assign('uid_name',$uid_name);
        }
        /*用户类型*/
        $ttype = I('ttype');
        if (is_numeric($ttype)) {
            $where['ttype'] = "$ttype";
            $this->assign('ttype',$ttype);
        }
        /*申请时间*/
        $t_time1 = I('t_time1');
        $t_time2 = I('t_time2');
        if ($t_time1 && $t_time2) {
            $where['t_time'] = array(
                ['lt', date('Y-m-d H:i:s', strtotime($t_time2) + 24 * 60 * 60)],
                ['gt', date('Y-m-d H:i:s', strtotime($t_time1))]
            );
            $this->assign('t_time1',$t_time1);
            $this->assign('t_time2',$t_time2);
        }
        /*提现状态*/
        $t_state = I('t_state');
        if (is_numeric($t_state)) {
            $where['t_state'] = "$t_state";
            $this->assign('t_state',$t_state);
        }
        /* 每页显示条数 */
        $num =  20;
        /* 页码 */
        $p = $_GET['p'] ? $_GET['p'] : 1;

        /* 获取分页列表  */
        $tixian_info = $tixian_model
            ->where($where)
            ->page($p . ',' . $num)
            ->order('thinkphp.t_id desc')
            ->select();

        /* 获取分页条 */
        $count = $tixian_model->where($where)->count();
        $page_model = new \Think\Page($count, $num);
        $page_bar = $page_model->show();

        /*分页查询数据*/
        $this->assign('tixian_info',$tixian_info);
        $this->assign('page_bar', $page_bar);
        $this->assign('count',$count);
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
        $tixian_model = M('tixian');
        $where['t_id'] = array('in', $ids);
        if ($action == 'on') {
            $data['t_state'] = '1';
        }
        if ($action == 'off') {
            $data['t_state'] = '2';
        }
        $result = $tixian_model->where($where)->save($data);
        if ($result) {
            $this->success('操作成功', '', 1);
        } else {
            $this->error('操作失败', '', 1);
        }
    }

    /*订单Excel导出*/
    public function excel_order(){
        $tixian_model = D('tixianView');
        /*获取IDS*/
        $str =  $_REQUEST['ids'];
        if(!$str){
            $this->error('请选择要导出的数据','',1);
        }
        $find['t_id']=array('in',$str);
        $tixian_data = $tixian_model->field('t_zhanghao,t_type,t_money,t_time,t_uid,t_id,tphone,trealname,ttype,uid_name')->where($find)->select();
        $newarray = [];
        foreach ($tixian_data as $k=>$v){
                $v['t_time'] = date("Y-m-d H:i",strtotime($v['t_time']));
                if($v['t_type']==0){
                    $v['t_type'] = '没有账号';
                }
                if($v['t_type']==1){
                    $v['t_type'] = '支付宝';
                 }
                if($v['t_type']==2){
                    $v['t_type'] = '微信';
                }
                if(!$v['trealname']){
                    $v['trealname'] = '未填写';
                }
                if(!$v['tphone']){
                    $v['tphone'] = '未填写';
                }
                if($v['ttype']==1){
                    $v['ttype'] = '用户';
                }
                if($v['ttype']==2){
                    $v['ttype'] = '师傅';
                }
                if($v['ttype']==3){
                    $v['ttype'] = '商家';
                }

            $newarray[] =  array_values(array_reverse($v));
        }
        // 导出Exl
        $titel_data = array(array_reverse(array('提现账号','收款类型','提现金额','申请时间','用户ID','提现ID','用户电话','真实姓名','用户类型','用户昵称','编号')));
        $data = array_merge($titel_data,$newarray);

        $dates = date("Y-m-d",time());
        createtixian_xls($data,$dates);
    }
}