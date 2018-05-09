<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-07-12
 * Time: 09:32
 */

namespace Home\Controller;

class CompanyController extends AuthController
{
    /*单位----列表显示*/
    public function index_list(){
        $company_model = D('company');
        /* 查询条件 */
        $where = array();
        /* 单位 */
        $c_name = I('c_name');
        if($c_name){
            $where['c_name'] = $c_name;
            $this->assign('c_name',$c_name);
        }
        /* 每页显示条数 */
        $num =  20;
        /* 页码 */
        $p = $_GET['p'] ? $_GET['p'] : 1;

        /* 获取分页列表  */
        $company_info = $company_model
            ->where($where)
            ->page($p . ',' . $num)
            ->select();


        /* 获取分页条 */
        $count = $company_model->where($where)->count();
        $page_model = new \Think\Page($count, $num);
        $page_bar = $page_model->show();

        /*分页查询数据*/
        $this->assign('company_info',$company_info);
        $this->assign('page_bar', $page_bar);
        $this->assign('count',$count);
        $this->display();
    }
    /*单位-添加*/
    public function insert()
    {
        if (IS_POST) {
            $company_model = D('company');
            /*数据创建及模型验证*/
            $data = $company_model->create();
            if (!$data) {
                $this->error($company_model->getError(), '', 1);
            }
            unset($data['c_id']);
            /*数据添加*/
            $rs = $company_model->add($data);
            if ($rs) {
                $this->success("添加成功", U('index_list'), 1);
            } else {
                $this->error("添加失败", '', 1);
            }
        } else {
            /*查询所有商家*/
            $userinfo_model = M('userinfo');
            $userinfo_find['u_type'] = '3';
            $userinfo_info = $userinfo_model->where($userinfo_find)->field('u_id,u_shopname')->select();
            $this->assign('userinfo_info',$userinfo_info);
            $this->display();
        }
    }
    /*单位-详情*/
    public function detail()
    {
        /*查询所有商家*/
        $userinfo_model = M('userinfo');
        $userinfo_find['u_type'] = '3';
        $userinfo_info = $userinfo_model->where($userinfo_find)->field('u_id,u_shopname')->select();
        $this->assign('userinfo_info',$userinfo_info);

        $company_model = D('company');
        $find['c_id'] = I('c_id');
        $company_info = $company_model->where($find)->find();
        $this->assign('info',$company_info);
        $this->display('modify');
    }
    /*单位-修改*/
    public function modify()
    {
        if(IS_POST){
            $company_model = D('company');
            /*数据创建及模型验证*/
            $data = I('post.');
            $find['c_id'] = I('c_id');
            unset($data['c_id']);
            /*数据添加*/
            $rs = $company_model->where($find)->save($data);
            if ($rs) {
                $this->success("修改成功", U('index_list'),1);
            }else {
                $this->error("修改失败", '', 1);
            }
        }else{
            /*查询所有商家*/
            $userinfo_model = M('userinfo');
            $userinfo_find['u_type'] = '3';
            $userinfo_info = $userinfo_model->where($userinfo_find)->field('u_id,u_shopname')->select();
            $this->assign('userinfo_info',$userinfo_info);

            $company_model = D('company');
            $find['c_id'] = I('c_id');
            $company_info = $company_model->where($find)->find();
            $this->assign('info',$company_info);
            $this->display('modify');
        }
    }
    

}