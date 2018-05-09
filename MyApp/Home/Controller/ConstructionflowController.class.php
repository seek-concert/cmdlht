<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-07-06
 * Time: 11:39
 */

namespace Home\Controller;

class ConstructionflowController extends AuthController
{
    /*施工流程---列表显示*/
    public function index_list(){
        $constructionflow_model = D('constructionflow');
        /* 查询条件 */
        $where = array();
        /* 类型名称 */
        $ctname = I('ct_name');
        if($ctname){
            $where['ct_name'] = array('LIKE','%'.$ctname.'%');
            $this->assign('ctname',$ctname);
        }
        /* 状态 */
        $ctstate = I('ct_state');
        if(is_numeric($ctstate)){
            $where['ct_state'] = "$ctstate";
            $this->assign('ctstate',$ctstate);
        }
        /* 每页显示条数 */
        $num =  20;
        /* 页码 */
        $p = $_GET['p'] ? $_GET['p'] : 1;

        /* 获取分页列表  */
        $constructionflow_info = $constructionflow_model
            ->where($where)
            ->page($p . ',' . $num)
            ->select();


        /* 获取分页条 */
        $count = $constructionflow_model->where($where)->count();
        $page_model = new \Think\Page($count, $num);
        $page_bar = $page_model->show();

        /*分页查询数据*/
        $this->assign('constructionflow_info',$constructionflow_info);
        $this->assign('page_bar', $page_bar);
        $this->assign('count',$count);
        $this->display();
    }
}