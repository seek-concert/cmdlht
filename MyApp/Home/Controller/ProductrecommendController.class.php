<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-07-13
 * Time: 14:18
 */

namespace Home\Controller;


class ProductrecommendController extends AuthController
{
    /*产品推荐*/
    public function index_list(){
        /*查询产品*/
        $product_model = D('Product');
        /*当前产品名称*/
        $pidwhere['p_id'] = I('p_id');
        $info = $product_model->where($pidwhere)->field('p_id,p_name')->find();
        $this->assign('infos',$info);
        /*查询当前产品的推荐副产品*/
        $productrecommend_model = D('productrecommend');
        $prpidwhere['pr_pid'] = I('p_id');
        $prcommendpid =$productrecommend_model->where($prpidwhere)->field('pr_commendpid')->select();
        $prcommendpids = [];
        foreach($prcommendpid as $v){
            $prcommendpids[] = $v['pr_commendpid'];
       }
       $this->assign('prcommendpids',$prcommendpids);
        /* 查询条件 */
        $where = array();
        /* 产品名称*/
        $pname = trim(I('pnames'));
        if($pname){
            $where['p_name'] = array('LIKE','%'.$pname.'%');
            $this->assign('pnames',$pname);
        }
        /* 每页显示条数 */
        $num =  6;
        /* 页码 */
        $p = $_GET['p'] ? $_GET['p'] : 1;

        /* 获取分页列表  */
        $product_info = $product_model
            ->field('p_id,p_name')
            ->where($where)
            ->page($p . ',' . $num)
            ->select();

        /* 获取分页条 */
        $count = $product_model->where($where)->count();
        $page_model = new \Think\Page($count, $num);
        $page_bar = $page_model->show();

        /*分页查询数据*/
        $this->assign('product_info',$product_info);
        $this->assign('page_bar', $page_bar);
        $this->assign('count',$count);
        $this->display('productrecommend/index_list');
    }
    /*产品推荐------添加*/
    public function insert(){
        $productrecommend_model = D('productrecommend');
        /*数据创建及模型验证*/
        $data = $productrecommend_model->create();
        if(!$data){
            $this->error($productrecommend_model->getError(), '',1);
        }
        $data['pr_time'] = date("Y-m-d H:i:s");
        $data['pr_state'] = '1';
        if($data['pr_pid']==$data['pr_commendpid']){
            $this->error("产品相同，添加失败！",'',1);
        }
        /*数据添加*/
        unset($data['pr_id']);
        $rs = $productrecommend_model->add($data);
        if ($rs) {
            $this->success("添加成功",'',1);
        }else{
            $this->error("添加失败",'',1);
        }
    }
}