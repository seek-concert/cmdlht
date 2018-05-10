<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-06-02
 * Time: 15:28
 */

namespace Home\Controller;

class ProductevaluationController extends AuthController
{
    /*产品评价-列表*/
    public function index_list(){
        $productevaluation_model = D('productevaluationView');
        /* 查询条件 */
        $where = array();
        /* 订单ID*/
        $pepdid = I('pe_pdid');
        if($pepdid){
            $where['productevaluation.pe_pdid'] = $pepdid;
            $this->assign('pepdid',$pepdid);
        }
        /* 用户ID*/
        $peuid = I('uid_name');
        if($peuid){
            $where['productevaluation.uid_name'] = array('LIKE',"%$peuid%");
            $this->assign('uid_name',$peuid);
        }
        /* 评价时间 */
        $petime1 = I('pe_time1');
        $petime2 = I('pe_time2');
        if($petime1&&$petime2){
            $where['productevaluation.pe_time'] = array(
                ['lt',date('Y-m-d H:i:s',strtotime($petime2)+24*60*60)],
                ['gt',date('Y-m-d H:i:s',strtotime($petime1))]
            );
            $this->assign('petime1',$petime1);
            $this->assign('petime2',$petime2);
        }
        /* 追评时间 */
        $pectime1 = I('pe_ctime1');
        $pectime2 = I('pe_ctime2');
        if($pectime1&&$pectime2){
            $where['productevaluation.pe_ctime'] = array(
                ['lt',date('Y-m-d H:i:s',strtotime($pectime2)+24*60*60)],
                ['gt',date('Y-m-d H:i:s',strtotime($pectime1))]
            );
            $this->assign('pectime1',$pectime1);
            $this->assign('pectime2',$pectime2);
        }
        /*订单详情ID*/
        $peodid = I('pe_odid');
        if($peodid){
            $where['productevaluation.pe_odid'] = $peodid;
            $this->assign('peodid',$peodid);
        }
        /*是否显示*/
        $pestate = I('pe_state');
        if(is_numeric($pestate)){
            $where['productevaluation.pe_state'] = "$pestate";
            $this->assign('pestate',$pestate);
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
        $productevaluation_info = $productevaluation_model
            ->join('userinfo as u ON u.u_id = productevaluation.pe_uid','left')
            ->join('useraddress as ud ON ud.ua_uid = u.u_id','left')
            ->where($where)
            ->page($p . ',' . $num)
            ->order('thinkphp.pe_id desc')
            ->select();

        /* 获取分页条 */
        $count = $productevaluation_model
            ->join('userinfo as u ON u.u_id = productevaluation.pe_uid','left')
            ->join('useraddress as ud ON ud.ua_uid = u.u_id','left')
            ->where($where)
            ->count();
        $page_model = new \Think\Page($count, $num);
        $page_bar = $page_model->show();


        /*分页查询数据*/
        $this->assign('productevaluation_info',$productevaluation_info);
        $this->assign('page_bar', $page_bar);
        $this->assign('count',$count);
        $this->display();
    }
    /*修改详情模板*/
    public function detail()
    {
        /*获取模板的所有值*/
        $productevaluation_model = D('productevaluationView');
        $find['pe_id'] = I('pe_id');
        $productevaluation_info = $productevaluation_model->where($find)->find();
        $this->assign('info',$productevaluation_info);

        /*获取评价图片的值*/
        $productevaluation_info['pe_imglist']= $productevaluation_info['pe_imglist']?explode(',', $productevaluation_info['pe_imglist']):array();
        $imglist = $productevaluation_info['pe_imglist'];

        $this->assign('imglist',$imglist);
        $this->display('modify');
    }

    /*执行修改*/
    public function modify()
    {
        if(IS_POST)
        {
            $productevaluation_model = D('productevaluation');
            $find['pe_id'] = I('pe_id');
            $productevaluation_info = $productevaluation_model->where($find)->find();
            /*执行修改*/
            $data = I('post.');
            if($productevaluation_info['pe_systemtime'] == '2017-01-01 00:00:00.000'){
                $data['pe_systemtime'] = date('Y-m-d H:i:s');
            }
            if($productevaluation_info['pe_csystemtime'] == '2017-01-01 00:00:00.000'&&I('pe_csystemcontent')){
                $data['pe_csystemtime'] = date('Y-m-d H:i:s');
            }
            $where = array(
                'pe_id' => I('pe_id')
            );
            unset($data['pe_id']);
          $rs = $productevaluation_model->where($where)->save($data);
            if ($rs) {
                $this->success("修改成功",U('index_list'),1);
            } else {
                $this->error("修改失败",'',1);
            }
        }else{
            $this->display('modify');
        }
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
        $productevaluation_model = M('productevaluation');
        $where['pe_id'] = array('in', $ids);
        if ($action == 'on') {
            $data['pe_state'] = '1';
        }
        if ($action == 'off') {
            $data['pe_state'] = '0';
        }
        $result = $productevaluation_model->where($where)->save($data);
        if ($result) {
            $this->success('操作成功', '', 1);
        } else {
            $this->error('操作失败', '', 1);
        }
    }

}