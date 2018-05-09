<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-06-06
 * Time: 10:32
 */

namespace Home\Controller;

class ProducttypeController extends AuthController
{
    /*产品类型-列表*/
    public function index_list(){
        $producttype_model = D('producttype');
        /* 查询条件 */
        $where = array();
        /* 前台展示名称*/
        $ptreceptionname = trim(I('pt_receptionname'));
        if($ptreceptionname){
            $where['pt_receptionname'] = array('LIKE','%'.$ptreceptionname.'%');
            $this->assign('ptreceptionname',$ptreceptionname);
        }
        /* 添加时间*/
        $pttime1 = I('pt_time1');
        $pttime2 = I('pt_time2');
        if ($pttime1 && $pttime2) {
            $where['pt_time'] = array(
                ['lt', date('Y-m-d H:i:s', strtotime($pttime2) + 24 * 60 * 60)],
                ['gt', date('Y-m-d H:i:s', strtotime($pttime1))]
            );
            $this->assign('pttime1',$pttime1);
            $this->assign('pttime2',$pttime2);
        }
        /* 上级前台名称*/
        $ptsuperior = I('pt_superior');
        if($ptsuperior){
            $where['pt_superior'] = $ptsuperior;
            $this->assign('ptsuperior',$ptsuperior);
        }
        /* 后台展示名称*/
        $ptbackstagename = trim(I('pt_backstagename'));
        if($ptbackstagename){
            $where['pt_backstagename'] = array('LIKE','%'.$ptbackstagename.'%');
            $this->assign('ptbackstagename',$ptbackstagename);
        }
        /* 是否启用*/
        $ptstate = I('pt_state');
        if(is_numeric($ptstate)){
            $where['pt_state'] = "$ptstate";
            $this->assign('ptstate',$ptstate);
        }
        /* 每页显示条数 */
        if($where['pt_superior']!=""){
            $num = 1000;
        }else{
            $num =  20;
        }

        /* 页码 */
        $p = $_GET['p'] ? $_GET['p'] : 1;

        /* 获取分页列表  */
        $producttype_info = $producttype_model
            ->where($where)
            ->page($p . ',' . $num)
            ->order('thinkphp.pt_id desc')
            ->select();

        /* 获取分页条 */
        $count = $producttype_model->where($where)->count();
        $page_model = new \Think\Page($count, $num);
        $page_bar = $page_model->show();

        /*查询所有的上级名称*/
        $pidname = $producttype_model->select();
        $this->assign('pidname',$pidname);
        /*查询所有的上级名称等级为2*/
        $find2['pt_level'] = array('eq','2');
        $pidname2 = $producttype_model->where($find2)->select();
        $this->assign('pidname2',$pidname2);
        /*分页查询数据*/
        $this->assign('producttype_info',$producttype_info);
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
        $producttype_model = M('producttype');
        $where['pt_id'] = array('in', $ids);
        if ($action == 'on') {
            $data['pt_state'] = '1';
        }
        if ($action == 'off') {
            $data['pt_state'] = '0';
        }
        $result = $producttype_model->where($where)->save($data);
        if ($result) {
            $this->success('操作成功', '', 1);
        } else {
            $this->error('操作失败', '', 1);
        }
    }
    /*产品类型-添加*/
    public function insert(){
        if(IS_POST){
            $producttype_model = D('producttype');
            /*模型创建及数据验证*/
            $data = $producttype_model->create();
            if(!$data){
                $this->error($producttype_model->getError(),'',1);
            }
            unset($data['pt_id']);
           /*生成添加时间*/
            $data['pt_time'] = date('Y-m-d H:i:s');

            /*根据上级ID查询深度和等级关联*/
            if($data['pt_superior'] == '0' ){
                $data['pt_level'] = '2';
                $data['pt_relation'] = 0;
            }else{
               $find['pt_id'] = $data['pt_superior'];
               $ptlevel = $producttype_model->where($find)->getField('pt_level');
               if($ptlevel == '2'){
                   $data['pt_relation'] = $data['pt_superior'];
                   $data['pt_level'] = '3';
               }
               if($ptlevel == '3'){
                   $ptsuperior = $producttype_model->where($find)->getField('pt_superior');
                   $data['pt_relation'] = $ptsuperior.",".$data['pt_superior'];
                   $data['pt_level'] = '4';
               }
            }
            $data['pt_img'] = I('pt_img');
            $data['pt_color'] = I('pt_color');
            /*执行添加*/
            $rs = $producttype_model->add($data);
            if($rs){
                $this->success('添加成功',U('index_list'),1);
            }else{
                $this->error('添加失败','',1);
            }
        }else{
            /*查询所有的上级名称等级为2*/
            $producttype_model = D('producttype');
            $find2['pt_level'] = array('eq','2');
            $pidname2 = $producttype_model->where($find2)->select();
            $this->assign('pidname2',$pidname2);
            $this->display();
        }
    }
    /*产品类型-修改模板详情*/
    public function detail(){
        $producttype_model = D('producttype');
        $find['pt_id'] = I('pt_id');
        $producttype_info = $producttype_model->where($find)->find();
        $this->assign('info',$producttype_info);

        /*查询所有的上级名称等级为2*/
        $producttype_model = D('producttype');
        $find2['pt_level'] = array('eq','2');
        $pidname2 = $producttype_model->where($find2)->select();
        $this->assign('pidname2',$pidname2);
        /*查询第一级名称*/
        $find3['pt_id'] = $producttype_info['pt_superior'];
        $pid = $producttype_model->where($find3)->getField('pt_superior');
        $this->assign('pid',$pid);
        /*查询所有的第二级名称*/
        $find4['pt_superior'] = $pid;
        $pid2 = $producttype_model->field('pt_id,pt_receptionname')->where($find4)->select();
        $this->assign('pid2',$pid2);

        $this->display('modify');
    }
    /*产品类型-修改执行*/
    public function modify(){
        if(IS_POST){
            $producttype_model = D('producttype');
            $data = I('post.');
            $where_find['pt_id'] = I('pt_id');

            /*根据上级ID查询深度和等级关联*/
            if($data['pt_superior'] == '0' ){
                $data['pt_level'] = '2';
                $data['pt_relation'] = 0;
            }else{
                $find['pt_id'] = $data['pt_superior'];
                $ptlevel = $producttype_model->where($find)->getField('pt_level');
                if($ptlevel == '2'){
                    $data['pt_relation'] = $data['pt_superior'];
                    $data['pt_level'] = '3';
                }
                if($ptlevel == '3'){
                    $ptsuperior = $producttype_model->where($find)->getField('pt_superior');
                    $data['pt_relation'] = $data['pt_superior'].",".$ptsuperior;
                    $data['pt_level'] = '4';
                }
            }
            $data['pt_img'] = I('pt_img');
            $data['pt_color'] = I('pt_color');
            unset($data['pt_id']);
            $rs = $producttype_model->where($where_find)->save($data);
            if($rs){
                $this->success('修改成功',U('index_list'),1);
            }else{
                $this->error('修改失败','',1);
            }
        }else{
            $producttype_model = D('producttype');
            $find['pt_id'] = I('pt_id');
            $producttype_info = $producttype_model->where($find)->find();
            $this->assign('info',$producttype_info);
            /*查询所有的上级名称等级为2*/
            $producttype_model = D('producttype');
            $find2['pt_level'] = array('eq','2');
            $pidname2 = $producttype_model->where($find2)->select();
            $this->assign('pidname2',$pidname2);
            /*查询第一级名称*/
            $find3['pt_id'] = $producttype_info['pt_superior'];
            $pid = $producttype_model->where($find3)->getField('pt_superior');
            $this->assign('pid',$pid);
            /*查询所有的第二级名称*/
            $find4['pt_superior'] = $pid;
            $pid2 = $producttype_model->field('pt_id,pt_receptionname')->where($find4)->select();
            $this->assign('pid2',$pid2);
            $this->display('modify');
        }
    }

}