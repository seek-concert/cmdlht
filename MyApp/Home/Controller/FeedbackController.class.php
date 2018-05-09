<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-05-22
 * Time: 11:27
 */

namespace Home\Controller;

class FeedbackController extends AuthController
{
    /*意见反馈-列表显示*/
    public function index_list()
    {
        $feedback_model = D('feedbackView');
        /* 查询条件 */
        $where = array();
        /* 用户id */
        $fbuid = I('uid_name');
        if($fbuid){
            $where['uid_name'] = $fbuid;
            $this->assign('uid_name',$fbuid);
        }
        /* 反馈时间 */
        $fbtime1 = I('fb_time1');
        $fbtime2 = I('fb_time2');
        if($fbtime1&&$fbtime2){
            $where['fb_time'] = array(
                ['lt',date('Y-m-d H:i:s',strtotime($fbtime2)+24*60*60)],
                ['gt',date('Y-m-d H:i:s',strtotime($fbtime1))]
            );
            $this->assign('fbtime1',$fbtime1);
            $this->assign('fbtime2',$fbtime2);
        }
        /* 回复时间 */
        $fbsystemtime1 = I('fb_systemtime1');
        $fbsystemtime2 = I('fb_systemtime2');
        if($fbsystemtime1&&$fbsystemtime2){
            $where['fb_systemtime'] = array(
                ['lt',date('Y-m-d H:i:s',strtotime($fbsystemtime2)+24*60*60)],
                ['gt',date('Y-m-d H:i:s',strtotime($fbsystemtime1))]
            );
            $this->assign('fbsystemtime1',$fbsystemtime1);
            $this->assign('fbsystemtime2',$fbsystemtime2);
        }
        /* 状态 */
        $fbstate = I('fb_state');
        if($fbstate){
            $where['fb_state'] = $fbstate;
            $this->assign('fbstate',$fbstate);
        }
        /* 每页显示条数 */
        $num =  20;
        /* 页码 */
        $p = $_GET['p'] ? $_GET['p'] : 1;

        /* 获取分页列表  */
        $feedback_info = $feedback_model
            ->where($where)
            ->page($p . ',' . $num)
            ->select();


        /* 获取分页条 */
        $count = $feedback_model->where($where)->count();
        $page_model = new \Think\Page($count, $num);
        $page_bar = $page_model->show();

        /*分页查询数据*/
        $this->assign('feedback_info',$feedback_info);
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
        if(!$action){
            $this->error('操作错误', '', 1);
        }
        $feedback_model = M('feedback');
        $where['fb_id'] = array('in', $ids);
        if ($action == 'on') {
            $data['fb_state'] = '3';
        }
        if ($action == 'off') {
            $data['fb_state'] = '2';
        }
        if ($action == 'off2') {
            $data['fb_state'] = '1';
        }
        $result = $feedback_model->where($where)->save($data);
        if ($result) {
            $this->success('操作成功', '', 1);
        } else {
            $this->error('操作失败', '', 1);
        }
    }

}