<?php
namespace Home\Controller;
use think\Controller;

class DesignclickController extends Controller
{
    /*作品点击量----列表*/
    public function index(){
        $designclick_model = D('PcdesignworksDesignclickView');
        /* 每页显示条数 */
        $num =  20;
        /* 页码 */
        $p = $_GET['p'] ? $_GET['p'] : 1;
        /* 获取分页列表  */
        $designclick_list = $designclick_model
            ->page($p . ',' . $num)
            ->select();
        /* 获取分页条 */
        $count = $designclick_model->count();
        $page_model = new \Think\Page($count, $num);
        $page_bar = $page_model->show();

        $this->assign('designclick',$designclick_list);
        $this->assign('page_bar', $page_bar);
        $this->assign('count',$count);
        $this->display();
    }
}