<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-05-23
 * Time: 10:51
 */

namespace Home\Controller;

class RenovationtypeController extends AuthController
{
    /*装修类型-列表显示*/
    public function index_list()
    {
        $renovationtype_model = D('renovationtype');
        /* 查询条件 */
        $where = array();
        /* 名称 */
        $rtname = trim(I('rt_name'));
        if($rtname){
            $where['rt_name'] = array('LIKE','%'.$rtname.'%');
            $this->assign('rtname',$rtname);
        }
        /*上级名称*/
        $pidname = I('pid_name');
        $pidname_find['rt_name'] = $pidname;
        $rtpid = $renovationtype_model->where($pidname_find)->getField('rt_id');
        if($rtpid){
            $where['rt_pid'] = $rtpid;
            $this->assign('pidname',$pidname);
        }
        /* 每页显示条数 */
        $num =  20;
        /* 页码 */
        $p = $_GET['p'] ? $_GET['p'] : 1;

        /* 获取分页列表  */
        $renovationtype_info = $renovationtype_model
            ->where($where)
            ->page($p . ',' . $num)
            ->select();

        /* 获取分页条 */
        $count = $renovationtype_model->where($where)->count();
        $page_model = new \Think\Page($count, $num);
        $page_bar = $page_model->show();
        /*查询所有pid*/
        $renovationtype_father = $renovationtype_model->select();
        $this->assign('renovationtype_father',$renovationtype_father);

        /*分页查询数据*/
        $this->assign('renovationtype_info',$renovationtype_info);
        $this->assign('page_bar', $page_bar);
        $this->assign('count',$count);
        $this->display();
    }
    /*装修类型-添加*/
    public function insert()
    {
        if(IS_POST)
        {
            $renovationtype_model = D('renovationtype');
            /*数据创建及模型验证*/
            $data = $renovationtype_model->create();
            if(!$data){
                $this->error($renovationtype_model->getError(), '',1);
            }
            unset($data['rt_id']);
            $data['rt_pid'] = I('rt_pid');
            /*数据添加*/
            $rs = $renovationtype_model->add($data);
            if ($rs) {
                $this->success("添加成功", U('index_list'),1);
            }else{
                $this->error("添加失败",'',1);
            }
        }else{
            /*查询所有pid*/
            $renovationtype_model = D('renovationtype');
            $find['rt_pid'] = "0";
            $renovationtype_father = $renovationtype_model->where($find)->select();
            $this->assign('renovationtype_father',$renovationtype_father);
            /*调用添加模板*/
            $this->display('modify');
        }
    }


}