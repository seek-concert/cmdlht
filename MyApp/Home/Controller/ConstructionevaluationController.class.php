<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-07-06
 * Time: 15:28
 */

namespace Home\Controller;

class ConstructionevaluationController extends AuthController
{
    /*施工评价---列表显示*/
    public function index_list(){
        $constructionevaluation_model = D('constructionevaluationView');
        /* 查询条件 */
        $where = array();
        /* 师傅 */
        $cuidname = I('cuid_name');
        if($cuidname){
            $where['constructionevaluation.cuid_name'] = array('LIKE','%'.$cuidname.'%');
            $this->assign('cuidname',$cuidname);
        }
//        /* 用户 */
//        $uidname = I('uid_name');
//        if($uidname){
//            $where['uid_name'] = array('LIKE','%'.$uidname.'%');
//            $this->assign('uidname',$uidname);
//        }
        /* 评论时间 */
        $cetime1 = I('ce_time1');
        $cetime2 = I('ce_time2');
        if($cetime1&&$cetime2){
            $where['constructionevaluation.ce_time'] = array(
                ['lt',date('Y-m-d H:i:s',strtotime($cetime2)+24*60*60)],
                ['gt',date('Y-m-d H:i:s',strtotime($cetime1))]
            );
            $this->assign('cetime1',$cetime1);
            $this->assign('cetime2',$cetime2);
        }
        /* 状态 */
        $cestate = I('ce_state');
        if(is_numeric($cestate)){
            $where['constructionevaluation.ce_state'] = "$cestate";
            $this->assign('cestate',$cestate);
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
        $constructionevaluation_info = $constructionevaluation_model
            ->join('userinfo as u ON u.u_id = constructionevaluation.ce_uid','left')
            ->join('useraddress as ud ON ud.ua_uid = u.u_id','left')
            ->where($where)
            ->page($p . ',' . $num)
            ->order('thinkphp.ce_time desc')
            ->select();


        /* 获取分页条 */
        $count = $constructionevaluation_model
            ->join('userinfo as u ON u.u_id = constructionevaluation.ce_uid','left')
            ->join('useraddress as ud ON ud.ua_uid = u.u_id','left')
            ->where($where)
            ->count();
        $page_model = new \Think\Page($count, $num);
        $page_bar = $page_model->show();

        /*查询图片*/
        $imgids = [];
        foreach ($constructionevaluation_info as $v){
            $v['ce_imglist'] = explode(",",$v['ce_imglist']);
            $imgids[] = $v;
        }
        $this->assign('img_ids',$imgids);

        /*分页查询数据*/
        $this->assign('constructionevaluation_info',$constructionevaluation_info);
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
        $constructionevaluation_model = M('constructionevaluation');
        $where['ce_id'] = array('in', $ids);
        if ($action == 'on') {
            $data['ce_state'] = '1';
        }
        if ($action == 'off') {
            $data['ce_state'] = '0';
        }
        $result = $constructionevaluation_model->where($where)->save($data);
        if ($result) {
            $this->success('操作成功', '', 1);
        } else {
            $this->error('操作失败', '', 1);
        }
    }
}