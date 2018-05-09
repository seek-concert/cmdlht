<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-07-17
 * Time: 11:08
 */

namespace Home\Controller;

class QuotationcontentController extends AuthController
{
    /*装修报价内容*/
    public function index_list(){
        $quotationcontent_model = D('quotationcontent');
        /* 查询条件 */
        $where = array();
        /*报价名称*/
        $qc_title = I('qc_title');
        if($qc_title){
          $where['qc_title'] = array('LIKE','%'.$qc_title.'%');
          $this->assign('qc_title',$qc_title);
        }
        /*类型*/
        $qc_type = I('qc_type');
        if($qc_type){
            $where['qc_type'] = $qc_type;
            $this->assign('qc_type',$qc_type);
        }
        /*状态*/
        $qc_state = I('qc_state');
        if(is_numeric($qc_state)){
            $where['qc_state'] = "$qc_state";
            $this->assign('qc_state',$qc_state);
        }
        /* 每页显示条数 */
        $num = 20;
        /* 页码 */
        $p = $_GET['p'] ? $_GET['p'] : 1;
        /* 获取分页列表  */
        $quotationcontent_list = $quotationcontent_model
            ->where($where)
            ->page($p . ',' . $num)
            ->order('thinkphp.qc_id desc')
            ->select();
        /* 获取分页条 */
        $count = $quotationcontent_model->where($where)->count();
        $page_model = new \Think\Page($count, $num);
        $page_bar = $page_model->show();

        $this->assign('quotationcontent_list', $quotationcontent_list);
        $this->assign('page_bar', $page_bar);
        $this->assign('count', $count);
        $this->display();
    }
    /*装修报价内容----添加*/
    public function insert(){
        if(IS_POST){
            $quotationcontent_model = D('quotationcontent');
            $data = $quotationcontent_model->create();
            if(!$data){
                $this->error($quotationcontent_model->getError(),'',1);
            }
            $data['qc_pricetype'] = '0';
            unset($data['qc_id']);
            $rs = $quotationcontent_model->add($data);
            if($rs){
                $this->success('添加成功','',1);
            }else{
                $this->error('添加失败','',1);
            }
        }else{
            $this->display('modify');
        }
    }
}