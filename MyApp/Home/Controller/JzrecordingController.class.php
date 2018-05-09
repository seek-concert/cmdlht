<?php
namespace Home\Controller;

class JzrecordingController extends AuthController
{
    /*结账记录*/
    public function index_list(){
        $jzrecording_model = D('JzrecordingView');
        /* 查询条件 */
        $where = array();
        /* 店铺名称*/
        $bname = I('shopname');
        if($bname){
            $where['shopname'] = array('LIKE','%'.$bname.'%');
            $this->assign('shopname',$bname);
        }
        /*结账时间*/
        $jz_time1 = I('jz_time1');
        $jz_time2 = I('jz_time2');
        if ($jz_time1 && $jz_time2) {
            $where['jz_time'] = array(
                ['lt', date('Y-m-d H:i:s', strtotime($jz_time2) + 24 * 60 * 60)],
                ['gt', date('Y-m-d H:i:s', strtotime($jz_time1))]
            );
            $this->assign('jz_time1',$jz_time1);
            $this->assign('jz_time2',$jz_time2);
        }
        /* 每页显示条数 */
        $num =  20;
        /* 页码 */
        $p = $_GET['p'] ? $_GET['p'] : 1;

        /* 获取分页列表  */
        $jzrecording_info = $jzrecording_model
            ->where($where)
            ->page($p . ',' . $num)
            ->select();

        /* 获取分页条 */
        $count = $jzrecording_model->where($where)->count();
        $page_model = new \Think\Page($count, $num);
        $page_bar = $page_model->show();


        /*分页查询数据*/
        $this->assign('jzrecording_info',$jzrecording_info);
        $this->assign('page_bar', $page_bar);
        $this->assign('count',$count);
        $this->display();
    }
}