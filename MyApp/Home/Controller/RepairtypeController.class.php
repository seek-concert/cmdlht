<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-06-28
 * Time: 15:18
 */

namespace Home\Controller;

class RepairtypeController extends AuthController
{
    /*维修类型---------列表展示*/
    public function index_list(){
        $repairtype_model = D('repairtype');
        /* 查询条件 */
        $where = array();
        /* 展示名称 */
        $rtbackstagename = trim(I('rt_receptionname'));
        if($rtbackstagename){
            $where['rt_receptionname'] = array('LIKE','%'.$rtbackstagename.'%');
            $this->assign('rt_receptionname',$rtbackstagename);
        }
        /*上级名称*/
        $pidname = I('pid_name');
        $pidname_find['rt_receptionname'] = $pidname;
        $rtpid = $repairtype_model->where($pidname_find)->getField('rt_id');
        if($rtpid){
            $where['rt_pid'] = $rtpid;
            $this->assign('pidname',$pidname);
        }
        /* 添加时间*/
        $rttime1 = I('rt_time1');
        $rttime2 = I('rt_time2');
        if ($rttime1 && $rttime2) {
            $where['rt_time'] = array(
                ['lt', date('Y-m-d H:i:s', strtotime($rttime2) + 24 * 60 * 60)],
                ['gt', date('Y-m-d H:i:s', strtotime($rttime1))]
            );
            $this->assign('rttime1',$rttime1);
            $this->assign('rttime2',$rttime2);
        }
        /* 是否在前台展示*/
        $rtchoicetype = I('rt_choicetype');
        if(is_numeric($rtchoicetype)){
            $where['rt_choicetype'] = "$rtchoicetype";
            $this->assign('rtchoicetype',$rtchoicetype);
        }
        /* 每页显示条数 */
        $num =  20;
        /* 页码 */
        $p = $_GET['p'] ? $_GET['p'] : 1;

        /* 获取分页列表  */
        $repairtype_info = $repairtype_model
            ->where($where)
            ->page($p . ',' . $num)
            ->select();

        /* 获取分页条 */
        $count = $repairtype_model->where($where)->count();
        $page_model = new \Think\Page($count, $num);
        $page_bar = $page_model->show();
        /*查询所有pid*/
        $repairtype_father = $repairtype_model->select();
        $this->assign('repairtype_father',$repairtype_father);
        /*查询所有id*/
        $repairtype_id = $repairtype_model->getField('rt_id',true);
        $this->assign('repairtype_id',$repairtype_id);

        /*分页查询数据*/
        $this->assign('repairtype_info',$repairtype_info);
        $this->assign('page_bar', $page_bar);
        $this->assign('count',$count);
        $this->display();
    }

    /*维修类型-添加*/
    public function insert()
    {
        if(IS_POST)
        {
            $repairtype_model = D('repairtype');
            /*数据创建及模型验证*/
            $data = $repairtype_model->create();
            if(!$data){
                $this->error($repairtype_model->getError(), '',1);
            }
            unset($data['rt_id']);
            $data['rt_shendu'] = "";
            $data['rt_time'] = date("Y-m-d H:i:s");
            /*数据添加*/
            $rs = $repairtype_model->add($data);
            if ($rs) {
                $this->success("添加成功", U('index_list'),1);
            }else{
                $this->error("添加失败",'',1);
            }
        }else{
            /*查询所有值*/
            $repairtype_model = D('repairtype');
            $repairtype_info = $repairtype_model->select();
            $this->assign('info',$repairtype_info);
            /*查询所有pid*/
            $pid_find['rt_pid'] = '0';
            $repairtype_father = $repairtype_model->where($pid_find)->select();
            $this->assign('repairtype_father',$repairtype_father);
            /*查询师傅类型*/
            $constructiontype_model = D('constructiontype');
            $constructiontype_info = $constructiontype_model->select();
            $this->assign('constructiontype_info',$constructiontype_info);
            /*查询品牌*/
            $brand_model = M('brand');
            $brand_info = $brand_model->select();
            $this->assign('brand_info',$brand_info);
            /*调用添加模板*/
            $this->display('insert');
        }
    }
    /*维修类型-详情展示*/
    public function detail()
    {
        /*查询所有值*/
        $repairtype_model = D('repairtype');
        $repairtype_find['rt_id'] = I('rt_id');
        $repairtype_info = $repairtype_model->where($repairtype_find)->find();
        $this->assign('info',$repairtype_info);
        /*获取默认勾选的施工类型*/
       $ctid =  explode(',',$repairtype_info["rt_ctid"]);
       foreach ($ctid as $k=>$v){
           if(!$v){
               unset($ctid[$k]);
           }
       }
       $this->assign('ctid',$ctid);
        /*获取默认勾选的品牌*/
        $bid =  explode(',',$repairtype_info["rt_bid"]);
        foreach ($bid as $k=>$v){
            if(!$v){
                unset($bid[$k]);
            }
        }
        $this->assign('bid',$bid);
        /*查询所有pid*/
        $pid_find['rt_pid'] = '0';
        $repairtype_father = $repairtype_model->where($pid_find)->select();
        $this->assign('repairtype_father',$repairtype_father);
        /*查询师傅类型*/
        $constructiontype_model = D('constructiontype');
        $constructiontype_info = $constructiontype_model->select();
        $this->assign('constructiontype_info',$constructiontype_info);
        /*查询当前的图片集合*/
        $repairtypeimg_find['rt_id'] = I('rt_id');
        $img_info = $repairtype_model->where($repairtypeimg_find)->getField('rt_img');
        $img_info = explode(',',$img_info);
        foreach ($img_info as $key=>$value)
        {
            if ($value == '/Public/img/trash.png'||$value=="")
                unset($img_info[$key]);
        }
        $img_info = array_merge($img_info);
        $this->assign('imgs',$img_info);
        /*查询当前的图片集合*/
        $imglist_info = $repairtype_model->where($repairtypeimg_find)->getField('rt_imglist');
        $imglist_info = explode(',',$imglist_info);
        foreach ($imglist_info as $key=>$value)
        {
            if ($value == '/Public/img/trash.png'||$value=="")
                unset($imglist_info[$key]);
        }
        $imglist_info = array_merge($imglist_info);
        $this->assign('imglist',$imglist_info);
        /*查询品牌*/
        $brand_model = M('brand');
        $brand_info = $brand_model->select();
        $this->assign('brand_info',$brand_info);
        /*调用添加模板*/
        $this->display('modify');
    }

}