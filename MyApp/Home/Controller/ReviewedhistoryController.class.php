<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-05-26
 * Time: 17:51
 */

namespace Home\Controller;

class ReviewedhistoryController extends AuthController
{
    /*申请审核历史*/
    public function index_list()
    {
        $reviewedhistory_model = D('reviewedhistoryView');
        /* 查询条件 */
        $where = array();
        /* 申请操作时间 */
        $rhtime1 = I('rh_time1');
        $rhtime2 = I('rh_time2');
        if ($rhtime1 && $rhtime2) {
            $where['rh_time'] = array(
                ['lt', date('Y-m-d H:i:s', strtotime($rhtime2) + 24 * 60 * 60)],
                ['gt', date('Y-m-d H:i:s', strtotime($rhtime1))]
            );
            $this->assign('rhtime1',$rhtime1);
            $this->assign('rhtime2',$rhtime2);
        }
        /* 操作状态*/
        $thstate = I('th_state');
        if ($thstate) {
            $where['th_state'] = $thstate;
            $this->assign('thstate',$thstate);
        }
        /*申请类型*/
        $thtype = I('th_type');
        if ($thtype) {
            $where['th_type'] = $thtype;
            $this->assign('thtype',$thtype);
        }
        /*申请人id*/
        $thuid = I('uid_name');
        if ($thuid) {
            $where['uid_name'] = $thuid;
            $this->assign('uid_name',$thuid);
        }
        /* 用户区域条件 */
        $user_info = $this->user_info;
        $level = $user_info['p_level'];
        if($level==1){
            $level_wheres['uid_sheng'] = $user_info['p_sheng'];
        }
        if($level==2){
            $level_wheres['uid_sheng'] = $user_info['p_sheng'];
            $level_wheres['uid_shi'] = $user_info['p_shi'];
        }
        if($level==3){
            $level_wheres['uid_sheng'] = $user_info['p_sheng'];
            $level_wheres['uid_shi'] = $user_info['p_shi'];
            $level_wheres['uid_xian'] = $user_info['p_xian'];
        }
        /*系统操作时间*/
        $rhsystemtime1 = I('rh_systemtime1');
        $rhsystemtime2 = I('rh_systemtime2');
        if ($rhsystemtime1 && $rhsystemtime2) {
            $where['rh_systemtime'] = array(
                ['lt', date('Y-m-d H:i:s', strtotime($rhsystemtime2) + 24 * 60 * 60)],
                ['gt', date('Y-m-d H:i:s', strtotime($rhsystemtime1))]
            );
            $this->assign('rhsystemtime1',$rhsystemtime1);
            $this->assign('rhsystemtime2',$rhsystemtime2);
        }
        /* 每页显示条数 */
        $num = 20;
        /* 页码 */
        $p = $_GET['p'] ? $_GET['p'] : 1;

        /* 获取分页列表  */
        $reviewedhistory_info = $reviewedhistory_model
            ->where($where)
            ->where($level_wheres)
            ->page($p . ',' . $num)
            ->order('thinkphp.rh_ctrid desc')
            ->select();

        /* 获取分页条 */
        $count = $reviewedhistory_model->where($where)->where($level_wheres)->count();
        $page_model = new \Think\Page($count, $num);
        $page_bar = $page_model->show();


        /*分页查询数据*/
        $this->assign('reviewedhistory_info', $reviewedhistory_info);
        $this->assign('page_bar', $page_bar);
        $this->assign('count', $count);
        $this->display();
    }

    /*申请审核历史-批量修改状态*
    *系统操作时间的修改*
     * */
    public function status_modify()
    {
        $reviewedhistory_model = D('reviewedhistory');
        /*获取IDS*/
        $str = I('rh_ctrid');
        $find['rh_ctrid'] = array('in', $str);
        $data['th_state'] = I('th_state');
        $data['rh_systemtime'] = date('Y-m-d H:i:s');
        $rs = $reviewedhistory_model->where($find)->save($data);
        if ($rs) {
            $this->success("修改成功", U('index_list'), 1);
        } else {
            $this->error("修改失败", '', 1);
        }
    }

    /*申请人信息*/
    public function detail(){
        $infos['th_uid'] = I('th_uid');
        $infos['rh_ctrid'] = I('rh_ctrid');
        $infos['th_type'] = I('th_type');
        $infos['thstate'] = I('thstate');
        $this->assign('infos',$infos);

        $userinfo_model = M('userinfo');
        $find['u_id'] = I('th_uid');
        $userinfo = $userinfo_model->where($find)->find();
        $this->assign('info',$userinfo);
        /*获取身份证图片的值*/
        $u_cardedimg = str_replace(",/Public/img/trash.png","",$userinfo['u_cardedimg']);
        $ucardedimg_imglist = !empty($u_cardedimg)?explode(',', $u_cardedimg):array();
        $this->assign('ucardedimg',$ucardedimg_imglist);
        /*获取营业执照*/
        $u_businesslicense = str_replace(",/Public/img/trash.png","",$userinfo['u_businesslicense']);
        $ubusinesslicense_imglist = !empty($u_businesslicense)?explode(',', $u_businesslicense):array();
        $this->assign('ubusinesslicense_imglist',$ubusinesslicense_imglist);
        /*获取门面图片*/
        $u_storemap = str_replace(",/Public/img/trash.png","",$userinfo['u_storemap']);
        $ustoremap_imglist = !empty($u_storemap)?explode(',', $u_storemap):array();
        $this->assign('ustoremap_imglist',$ustoremap_imglist);
        /*获取产品销售环境图*/
        $u_environmental = str_replace(",/Public/img/trash.png","",$userinfo['u_environmental']);
        $uenvironmental_imglist = !empty($u_environmental)?explode(',', $u_environmental):array();
        $this->assign('uenvironmental_imglist',$uenvironmental_imglist);
        /*查询要申请的施工类型*/
        $reviewedhistory_model = M('reviewedhistory');
        $where['rh_ctrid'] = I('rh_ctrid');
        $rhtypeid = $reviewedhistory_model->where($where)->field('rh_typeid,th_state,th_content')->find();
        $this->assign('state_content',$rhtypeid);
        $rhtypeid = json_decode($rhtypeid['rh_typeid'],true);
        $rhtypeids = [];
        $rhtypeidimg = [];
        foreach($rhtypeid as $k=>$v){
            $rhtypeids[] = $v['id'];
            $rhtypeidimg[] = $v['imgs'];
        }
        $rhtypeids = implode(",",$rhtypeids);
        /*查询施工类型名称*/
        $constructiontype_model = M('constructiontype');
        $finds['ct_id'] = array('in',$rhtypeids);
        $ctname = $constructiontype_model->where($finds)->field('ct_name')->select();
        $a = [];
        foreach($rhtypeidimg as $k=>$v){
            $a[$k][] = $rhtypeidimg[$k];
            foreach($ctname as $key=>$val){
                unset($ctname[$k]['row_number']);
                $a[$k][] = $ctname[$k]['ct_name'];
            }
        }
        $this->assign('ctname',$a);

        /*查询模板的值*/
        $this->display('modify');
    }
    /*审核信息*/
    public function modify(){
        $reviewedhistory_model = D('reviewedhistory');
        $userinfo_model = M('userinfo');
        $notice_model = M('notice');
        /*开始事务处理*/
        $model = M();
        $model->startTrans();
        /*模型创建及数据验证*/
        $data = $reviewedhistory_model->create();
        if(!$data){
            $this->error($reviewedhistory_model->getError(),'',1);
        }
        $where['rh_ctrid'] = I('rh_ctrid');
        $type = I('th_type');
        unset($data['rh_ctrid']);
        $type_rs = $reviewedhistory_model->where($where)->save($data);
        /*拒绝二次提交*/
        if(I('thstate')=='3'|| I('thstate')=='4'){
            $model->rollback();
            $this->error('已经审核','',1);
        }
        $noticedata['n_time']= date('Y-m-d H:i:s');
        $noticedata['n_state']= '0';
        $noticedata['n_del']= '1';
        $noticedata['n_uid']= I('th_uid');
        $jjcont = I('th_content');

        /*-------------------------商家--------------------------------*/
        if($type == '1'){
            if($type_rs){
                if(I('th_state')=="4"){
                    $uidfind1['u_id'] = I('th_uid');
                    $uiddata1['u_toexamine'] = '2';
                    $userinfors1 = $userinfo_model->where($uidfind1)->save($uiddata1);
                    if(!$userinfors1){
                        $model->rollback();
                        $this->error('审核失败','',1);
                    }else{
                        $noticedata['n_title'] = '您好，您的认证请求已被拒绝！';
                        $noticedata['n_content'] = "很遗憾，您的认证请求因".$jjcont."被拒绝了，请重新确认后提交！";
                        $notice_rs = $notice_model->add($noticedata);
                        if($notice_rs){
                            $model->commit();
                            $this->success('审核成功','',1);
                        }else{
                            $model->rollback();
                            $this->error('审核失败','',1);
                        }
                    }
                }
                if(I('th_state')=="3"){
                    $uidfind1['u_id'] = I('th_uid');
                    $uiddata1['u_toexamine'] = '1';
                    $userinfors1 = $userinfo_model->where($uidfind1)->save($uiddata1);
                    if(!$userinfors1){
                        $model->rollback();
                        $this->error('审核失败','',1);
                    }else {
                        $noticedata['n_title'] = '您好，您的认证请求已被通过！';
                        $noticedata['n_content'] = "恭喜您，您的认证请求已通过！请登录后台地址fw.chongmaiwang.com,账号密码就是您商家登录账号密码。如有疑问请致电崇迈公司咨询。感谢您的加入！";
                        $notice_rs = $notice_model->add($noticedata);
                        if($notice_rs){
                            $model->commit();
                            $this->success('审核成功','',1);
                        }else{
                            $model->rollback();
                            $this->error('审核失败','',1);
                        }
                    }
                }
            }else{
                $model->rollback();
                $this->error('审核失败','',1);
            }
        }
        /*-------------------------师傅--------------------------------*/
        if($type == '2'){
            if(!$type_rs){
                $model->rollback();
                $this->error('审核失败','',1);
            }
            if(I('th_state')=="4"){
                $uidfind1['u_id'] = I('th_uid');
                $uiddata1['u_toexamine'] = '2';
                $userinfors1 = $userinfo_model->where($uidfind1)->save($uiddata1);
                if(!$userinfors1){
                    $model->rollback();
                    $this->error('审核失败','',1);
                }else{
                    if(I('th_state')=="4"){
                        $noticedata['n_title'] = '您好，您的认证请求已被拒绝！';
                        $noticedata['n_content'] = "很遗憾，您的认证请求因".$jjcont."被拒绝了，请重新确认后提交！";
                    }
                    if(I('th_state')=="3"){
                        $noticedata['n_title'] = '您好，您的认证请求已被通过！';
                        $noticedata['n_content'] = "恭喜您，您的认证请求已通过！";
                    }

                    $notice_rs = $notice_model->add($noticedata);
                    if($notice_rs){
                        $model->commit();
                        $this->success('审核成功','',1);
                    }else{
                        $model->rollback();
                        $this->error('审核失败','',1);
                    }
                }
            }
            if(I('th_state')=="3"){
                $uid_find['u_id'] = I('th_uid');
                $u_sgtype = $userinfo_model->where($uid_find)->field('u_sgtype')->find();
                $rhtypeid_find['rh_ctrid'] = I('rh_ctrid');
                $rhtypeid = $reviewedhistory_model->where($rhtypeid_find)->field('rh_typeid')->find();
                $rhtypeid = json_decode($rhtypeid['rh_typeid'],true);
                $rhtypeids = [];
                foreach($rhtypeid as $k=>$v){
                    $rhtypeids[] = $v['id'];
                }
                $rhtypeids = implode(",",$rhtypeids);
                if(empty($u_sgtype['u_sgtype'])){
                    $uid_data['u_sgtype'] = $rhtypeids;
                    $uid_data['u_toexamine'] = '1';
                    $userinfo_rs = $userinfo_model->where($uid_find)->save($uid_data);
                    if (!$userinfo_rs) {
                        $model->rollback();
                        $this->error('审核失败', '', 1);
                    } else {
                        if(I('th_state')=="4"){
                            $noticedata['n_title'] = '您好，您的认证请求已被拒绝！';
                            $noticedata['n_content'] = "很遗憾，您的认证请求因".$jjcont."被拒绝了，请重新确认后提交！";
                        }
                        if(I('th_state')=="3"){
                            $noticedata['n_title'] = '您好，您的认证请求已被通过！';
                            $noticedata['n_content'] = "恭喜您，您的认证请求已通过！";
                        }

                        $notice_rs = $notice_model->add($noticedata);
                        if($notice_rs){
                            $model->commit();
                            $this->success('审核成功','',1);
                        }else{
                            $model->rollback();
                            $this->error('审核失败','',1);
                        }
                    }
                }else{
                    $usgtype = explode(",", $u_sgtype['u_sgtype']);
                    $rhtypeid = explode(",", $rhtypeids);
                    $uid_data['u_sgtype'] = implode(",", array_filter(array_unique(array_merge($usgtype, $rhtypeid))));
                    $uid_data['u_toexamine'] = '1';
                    $userinfo_rs = $userinfo_model->where($uid_find)->save($uid_data);
                    if (!$userinfo_rs) {
                        $model->rollback();
                        $this->error('审核失败', '', 1);
                    } else {
                        if(I('th_state')=="4"){
                            $noticedata['n_title'] = '您好，您的认证请求已被拒绝！';
                            $noticedata['n_content'] = "很遗憾，您的认证请求因".$jjcont."被拒绝了，请重新确认后提交！";
                        }
                        if(I('th_state')=="3"){
                            $noticedata['n_title'] = '您好，您的认证请求已被通过！';
                            $noticedata['n_content'] = "恭喜您，您的认证请求已通过！";
                        }

                        $notice_rs = $notice_model->add($noticedata);
                        if($notice_rs){
                            $model->commit();
                            $this->success('审核成功','',1);
                        }else{
                            $model->rollback();
                            $this->error('审核失败','',1);
                        }
                    }
                }
            }
        }
    }
}