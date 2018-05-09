<?php
namespace Home\Controller;

class DingyueliuchengController extends AuthController
{
    /*订阅流程-列表*/
    public function index_list(){
        $dingyueliucheng_model = D('DingdanView');
        /* 查询条件 */
        $where = array();
        /*订单ID*/
        $pdatvid = I('lc_pid');
        if($pdatvid){
            $where['lc_pid'] = $pdatvid;
            $this->assign('lc_pid',$pdatvid);
        }
        /* 订阅时间 */
        $pdtime1 = I('pd_time1');
        $pdtime2 = I('pd_time2');
        if($pdtime1&&$pdtime2){
            $where['lc_time'] = array(
                ['lt',date('Y-m-d H:i:s',strtotime($pdtime2)+24*60*60)],
                ['gt',date('Y-m-d H:i:s',strtotime($pdtime1))]
            );
            $this->assign('pd_time1',$pdtime1);
            $this->assign('pd_time2',$pdtime2);
        }
        /* 每页显示条数 */
        $num =  20;
        /* 页码 */
        $p = $_GET['p'] ? $_GET['p'] : 1;

        /* 获取分页列表  */
        $dingyueliucheng_info = $dingyueliucheng_model
            ->where($where)
            ->page($p . ',' . $num)
            ->order('thinkphp.lc_pid desc,thinkphp.lc_ftime desc')
            ->select();

        /* 获取分页条 */
        $count = $dingyueliucheng_model->where($where)->count();
        $page_model = new \Think\Page($count, $num);
        $page_bar = $page_model->show();

        /*分页查询数据*/
        $this->assign('dingyueliucheng_info',$dingyueliucheng_info);
        $this->assign('page_bar', $page_bar);
        $this->assign('count',$count);
        $this->display();
    }
}