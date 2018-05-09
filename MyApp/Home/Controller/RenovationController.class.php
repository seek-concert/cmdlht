<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-05-22
 * Time: 16:10
 */

namespace Home\Controller;

class RenovationController extends AuthController
{
    /*装修案例-列表显示*/
    public function index_list()
    {
        $renovation_model = D('renovation');
        /* 查询条件 */
        $where = array();
        /* 标题*/
        $rtitle = trim(I('r_title'));
        if($rtitle){
            $where['r_title'] = array('LIKE','%'.$rtitle.'%');
            $this->assign('rtitle',$rtitle);
        }
        /* 添加时间 */
        $rtime1 = I('r_time1');
        $rtime2 = I('r_time2');
        if($rtime1&&$rtime2){
            $where['r_time'] = array(
                ['lt',date('Y-m-d H:i:s',strtotime($rtime2)+24*60*60)],
                ['gt',date('Y-m-d H:i:s',strtotime($rtime1))]
            );
            $this->assign('rtime1',$rtime1);
            $this->assign('rtime2',$rtime2);
        }
        /* 楼盘*/
        $restate = trim(I('r_estate'));
        if($restate){
            $where['r_estate'] = array('LIKE','%'.$restate.'%');
            $this->assign('restate',$restate);
        }
        /* 每页显示条数 */
        $num =  20;
        /* 页码 */
        $p = $_GET['p'] ? $_GET['p'] : 1;

        /* 获取分页列表  */
        $renovation_info = $renovation_model
            ->where($where)
            ->page($p . ',' . $num)
            ->order('thinkphp.r_id desc')
            ->select();


        /* 获取分页条 */
        $count = $renovation_model->where($where)->count();
        $page_model = new \Think\Page($count, $num);
        $page_bar = $page_model->show();

        /*查询装修类型名称*/
        $renovationtype_model = D('renovationtype');
        $renovationtype_info = $renovationtype_model->select();
        $this->assign('renovationtype_info',$renovationtype_info);

        /*分页查询数据*/
        $this->assign('renovation_info',$renovation_info);
        $this->assign('page_bar', $page_bar);
        $this->assign('count',$count);
        $this->display();
    }

    /*装修案例-添加*/
    public function insert()
    {
        if(IS_POST)
        {
            $renovation_model = D('renovation');
            /*数据创建及模型验证*/
            $data = $renovation_model->create();
            if(!$data){
                $this->error($renovation_model->getError(), '',1);
            }
            $data['r_time'] = date('Y-m-d H:i:s');
            $data['r_content'] = I('r_content','','');
            $data['r_label'] = I('r_label','','');
            $data['r_type'] = "2";
            /*数据添加*/
            $rs = $renovation_model->add($data);
            if ($rs) {
                $this->success("添加成功", U('index_list'),1);
            }else{
                $this->error("添加失败",'',1);
            }
        }else{
            /*查询装修类型*/
            $renovationtype_model = D('renovationtype');
            $renovationtype_info = $renovationtype_model->select();
            $this->assign('renovationtype_info',$renovationtype_info);
            /*查询装修类型所有父级*/
            $father_find['rt_pid'] = 0;
            $renovationtype_father = $renovationtype_model->where($father_find)->select();
            $this->assign('renovationtype_father',$renovationtype_father);
            /*查询装修类型所有子级*/
            $find['rt_pid'] = array('neq',0);
            $renovationtype_child = $renovationtype_model->where($find)->select();
            $this->assign('renovationtype_child',$renovationtype_child);
            /*设计师列表*/ /* 设计师姓名*/
            $pcdesigner_model = D('pc_designer');
            $where = array();
            $dname = trim(I('d_name'));
            if($dname){
                $where['d_name'] = array('LIKE','%'.$dname.'%');
                $this->assign('dname',$dname);
            }
            $where['d_type']=1;
            /* 获取分页列表  */
            $num =  5;
            $p = $_GET['p'] ? $_GET['p'] : 1;
            $pcdesigner_list = $pcdesigner_model
                ->where($where)
                ->page($p . ',' . $num)
                ->select();
            /* 获取分页条 */
            $count = $pcdesigner_model->where($where)->count();
            $page_model = new \Think\Page($count, $num);
            $page_bar = $page_model->show();

            $this->assign('pcdesigner',$pcdesigner_list);
            $this->assign('page_bar', $page_bar);
            $this->assign('count',$count);
            /*调用添加模板*/
            $this->display();
        }
    }

    /*修改模板获取值*/
    public function detail(){
        /*设计师列表*/ /* 设计师姓名*/
        $pcdesigner_model = D('pc_designer');
        $where = array();
        $dname = trim(I('d_name'));
        if($dname){
            $where['d_name'] = array('LIKE','%'.$dname.'%');
            $this->assign('dname',$dname);
        }
        $where['d_type']=1;
        /* 获取分页列表  */
        $num =  5;
        $p = $_GET['p'] ? $_GET['p'] : 1;
        $pcdesigner_list = $pcdesigner_model
            ->where($where)
            ->page($p . ',' . $num)
            ->select();
        /* 获取分页条 */
        $count = $pcdesigner_model->where($where)->count();
        $page_model = new \Think\Page($count, $num);
        $page_bar = $page_model->show();

        $this->assign('pcdesigner',$pcdesigner_list);
        $this->assign('page_bar', $page_bar);
        $this->assign('count',$count);
        /*获取模板对应的值*/
        $renovation_model = D('renovation');
        $rid = I('r_id');
        $find['r_id'] = array('eq',$rid);
        $renovation_info = $renovation_model->where($find)->find();
        $this->assign('renovation_info',$renovation_info);
        /*获取图片的值*/
        $renovation_info['r_img']= !empty($renovation_info['r_img'])?explode(',', $renovation_info['r_img']):array();
        $imglist = $renovation_info['r_img'];
        $this->assign('imglist',$imglist);
        /*获取缩略图的值*/
        $renovation_info['r_imglist']= !empty($renovation_info['r_imglist'])?explode(',', $renovation_info['r_imglist']):array();
        $renovationimg = $renovation_info['r_imglist'];
        $renovationimg_ids1 = [];
        $renovationimg_ids2 = [];
        foreach ($renovationimg as $k=>$v){
            if($k%2==0){
                $renovationimg_ids1[]= $v;
            }else{
                $renovationimg_ids2[]=$v;
            }
        }
        $imglength = count($renovationimg_ids1);
        $this->assign('imglength',$imglength);
        $this->assign('renovationimg_ids1',$renovationimg_ids1);
        $this->assign('renovationimg_ids2',$renovationimg_ids2);
        /*查询装修类型*/
        $renovationtype_model = D('renovationtype');
        $renovationtype_info = $renovationtype_model->select();
        $this->assign('renovationtype_info',$renovationtype_info);
        /*查询装修类型所有父级*/
        $father_find['rt_pid'] = 0;
        $renovationtype_father = $renovationtype_model->where($father_find)->select();
        $this->assign('renovationtype_father',$renovationtype_father);
        /*查询装修类型所有子级*/
        $find['rt_pid'] = array('neq',0);
        $renovationtype_child = $renovationtype_model->where($find)->select();
        $this->assign('renovationtype_child',$renovationtype_child);
        /*获取3D图片的值*/
        $renovation_info['r_quanxi']= $renovation_info['r_quanxi']?explode(',', $renovation_info['r_quanxi']):array();
        $quanxilist = $renovation_info['r_quanxi'];
        $this->assign('quanxilist',$quanxilist);
        /*调用修改模板*/
        $this->display('modify');
    }

    /*执行修改*/
    public function modify()
    {
        $rid = I('r_id');

        $renovation_model = D('renovation');
        $data = $renovation_model->create();
        if(!$data) {
            $this->error($renovation_model->getError(),'',1);
        }
        /*执行修改*/
        $where['r_id'] = $rid;
        $data['r_content'] = I('r_content','','');
        $data['r_label'] = I('r_label','','');
        unset($data['r_id']);
        $rs = $renovation_model->where($where)->save($data);
        if ($rs) {
            $this->success("修改成功",U('index_list'),1);
        } else {
            $this->error("修改失败",'',1);
        }
    }


}