<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-06-02
 * Time: 11:29
 */

namespace Home\Controller;

class ShoppingcartController extends AuthController
{
    /*购物车-列表*/
    public function index_list(){
        $shoppingcart_model = D('shoppingcart');
        /* 查询条件 */
        $where = array();
        /* 商品ID（维修位置ID）*/
        $scpid = I('sc_pid');
        if($scpid){
            $where['sc_pid'] = $scpid;
            $this->assign('scpid',$scpid);
        }
        /* 用户ID*/
        $scuid = I('sc_uid');
        if($scuid){
            $where['sc_uid'] = $scuid;
            $this->assign('scuid',$scuid);
        }
        /* 添加时间 */
        $sctime1 = I('sc_time1');
        $sctime2 = I('sc_time2');
        if($sctime1&&$sctime2){
            $where['sc_time'] = array(
                ['lt',date('Y-m-d H:i:s',strtotime($sctime2)+24*60*60)],
                ['gt',date('Y-m-d H:i:s',strtotime($sctime1))]
            );
            $this->assign('sctime1',$sctime1);
            $this->assign('sctime2',$sctime2);
        }
        /*产品类型*/
        $sctype = I('sc_type');
        if($sctype){
            $where['sc_type'] = $sctype;
            $this->assign('sctype',$sctype);
        }
        /* 每页显示条数 */
        $num =  20;
        /* 页码 */
        $p = $_GET['p'] ? $_GET['p'] : 1;

        /* 获取分页列表  */
        $shoppingcart_info = $shoppingcart_model
            ->where($where)
            ->page($p . ',' . $num)
            ->select();


        /* 获取分页条 */
        $count = $shoppingcart_model->where($where)->count();
        $page_model = new \Think\Page($count, $num);
        $page_bar = $page_model->show();


        /*分页查询数据*/
        $this->assign('shoppingcart_info',$shoppingcart_info);
        $this->assign('page_bar', $page_bar);
        $this->assign('count',$count);
        $this->display();
    }
}