<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-05-22
 * Time: 09:12
 */

namespace Home\Controller;

class ComplaintController extends AuthController
{
    /*投诉记录-列表显示*/
    public function index_list()
    {
        $complaint_model = D('complaintView');
        /* 查询条件 */
        $where = array();
        /* 投诉订单号 */
        $onlyid = I('c_onlyid');
        if($onlyid){
            $where['complaint.c_onlyid'] = $onlyid;
            $this->assign('c_onlyid',$onlyid);
        }
        /* 投诉名称类型 */
        $type = I('c_type');
        if($type){
            $where['complaint.c_type'] = $type;
            $this->assign('ctype',$type);
        }
        /* 投诉时间 */
        $ctime1 = I('c_time1');
        $ctime2 = I('c_time2');
        if($ctime1&&$ctime2){
            $where['complaint.c_time'] = array(
                    ['lt',date('Y-m-d H:i:s',strtotime($ctime2)+24*60*60)],
                    ['gt',date('Y-m-d H:i:s',strtotime($ctime1))]
                );
            $this->assign('ctime1',$ctime1);
            $this->assign('ctime2',$ctime2);
        }
        /* 投诉用户 */
        $cuid = I('uid_name');
        if($cuid){
            $where['complaint.uid_name'] = $cuid;
            $this->assign('uid_name',$cuid);
        }
        /* 投诉状态 */
        $cstate = I('c_state');
        if($cstate){
            $where['complaint.c_state'] = $cstate;
            $this->assign('cstate',$cstate);
        }
        /*用户*/
        $where['u.u_type'] = "1";
        /* 用户区域条件 */
        $user_info = $this->user_info;
        $level = $user_info['p_level'];
        if($level==1){
            $where['ud.ua_province'] = $user_info['p_sheng'];
        }
        if($level==2){
            $where['ud.ua_province'] = $user_info['p_sheng'];
            $where['ud.ua_city'] = $user_info['p_shi'];
        }
        if($level==3){
            $where['ud.ua_province'] = $user_info['p_sheng'];
            $where['ud.ua_city'] = $user_info['p_shi'];
            $where['ud.ua_county'] = $user_info['p_xian'];
        }
        /*默认地址*/
        $where['ud.ua_moren'] = 1;
        /* 每页显示条数 */
        $num =  20;
        /* 页码 */
        $p = $_GET['p'] ? $_GET['p'] : 1;

        /* 获取分页列表  */
        $complaint_info = $complaint_model
            ->join('userinfo as u ON u.u_id = complaint.c_uid','left')
            ->join('useraddress as ud ON ud.ua_uid = u.u_id','left')
            ->where($where)
            ->page($p . ',' . $num)
            ->select();

        /* 获取分页条 */
        $count = $complaint_model
            ->join('userinfo as u ON u.u_id = complaint.c_uid','left')
            ->join('useraddress as ud ON ud.ua_uid = u.u_id','left')
            ->where($where)
            ->count();
        $page_model = new \Think\Page($count, $num);
        $page_bar = $page_model->show();

        /*分页查询数据*/
        $this->assign('complaint_info',$complaint_info);
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
        $complaint_model = M('complaint');
        $where['c_id'] = array('in', $ids);
        if ($action == 'on') {
            $data['c_state'] = '2';
        }
        if ($action == 'off') {
            $data['c_state'] = '1';
        }
        $result = $complaint_model->where($where)->save($data);
        if ($result) {
            $this->success('操作成功', '', 1);
        } else {
            $this->error('操作失败', '', 1);
        }
    }

}