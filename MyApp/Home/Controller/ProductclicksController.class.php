<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-06-02
 * Time: 14:45
 */

namespace Home\Controller;

class ProductclicksController extends AuthController
{
    /*产品点击记录-列表*/
    public function index_list(){
        $productclicks_model = D('productclicksView');
        /* 查询条件 */
        $where = array();
        /* 产品ID*/
        $ptpid = I('pid_name');
        if($ptpid){
            $where['pid_name'] = $ptpid;
            $this->assign('pid_name',$ptpid);
        }
        /* 点击时间 */
        $pttime1 = I('pt_time1');
        $pttime2 = I('pt_time2');
        if($pttime1&&$pttime2){
            $where['pt_time'] = array(
                ['lt',date('Y-m-d H:i:s',strtotime($pttime2)+24*60*60)],
                ['gt',date('Y-m-d H:i:s',strtotime($pttime1))]
            );
            $this->assign('pttime1',$pttime1);
            $this->assign('pttime2',$pttime2);
        }
        /*用户ID*/
        $ptuid = I('uid_name');
        if($ptuid){
            $where['uid_name'] = $ptuid;
            $this->assign('uid_name',$ptuid);
        }
        /* 每页显示条数 */
        $num =  20;
        /* 页码 */
        $p = $_GET['p'] ? $_GET['p'] : 1;

        /* 获取分页列表  */
        $productclicks_info = $productclicks_model
            ->where($where)
            ->page($p . ',' . $num)
            ->select();


        /* 获取分页条 */
        $count = $productclicks_model->where($where)->count();
        $page_model = new \Think\Page($count, $num);
        $page_bar = $page_model->show();


        /*分页查询数据*/
        $this->assign('productclicks_info',$productclicks_info);
        $this->assign('page_bar', $page_bar);
        $this->assign('count',$count);
        $this->display();
    }
}