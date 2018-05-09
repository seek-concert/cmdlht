<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-07-06
 * Time: 11:05
 */

namespace Home\Controller;

class ConstructiontypereviewedController extends AuthController
{
    /*师傅施工类型审核---列表显示*/
    public function index_list(){
        $constructiontypereviewed_model = D('constructiontypereviewedView');
        /* 查询条件 */
        $where = array();
        /* 师傅 */
        $uidname = I('uid_name');
        if($uidname){
            $where['uid_name'] = array('LIKE','%'.$uidname.'%');
            $this->assign('uidname',$uidname);
        }
        /* 申请状态 */
        $ctrstate = I('ctr_state');
        if(is_numeric($ctrstate)){
            $where['ctr_state'] = "$ctrstate";
            $this->assign('ctrstate',$ctrstate);
        }
        /* 每页显示条数 */
        $num =  20;
        /* 页码 */
        $p = $_GET['p'] ? $_GET['p'] : 1;

        /* 获取分页列表  */
        $constructiontypereviewed_info = $constructiontypereviewed_model
            ->where($where)
            ->page($p . ',' . $num)
            ->select();


        /* 获取分页条 */
        $count = $constructiontypereviewed_model->where($where)->count();
        $page_model = new \Think\Page($count, $num);
        $page_bar = $page_model->show();

        /*分页查询数据*/
        $this->assign('constructiontypereviewed_info',$constructiontypereviewed_info);
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
        $constructiontypereviewed_model = M('constructiontypereviewed');
        $where['ctr_id'] = array('in', $ids);
        if ($action == 'on') {
            $data['ctr_state'] = '1';
        }
        if ($action == 'off') {
            $data['ctr_state'] = '2';
        }
        $result = $constructiontypereviewed_model->where($where)->save($data);
        if ($result) {
            $this->success('操作成功', '', 1);
        } else {
            $this->error('操作失败', '', 1);
        }
    }
}