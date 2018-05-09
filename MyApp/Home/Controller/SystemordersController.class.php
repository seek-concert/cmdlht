<?php
namespace Home\Controller;

class SystemordersController extends AuthController
{
    /*系统接单-----列表显示*/
    public function index(){
        $servicedemand_model = D('servicedemandView');
        /* 查询条件 */
        $where = array();
        /* 订单号*/
        $sd_onlyid = I('sd_onlyid');
        if(is_numeric($sd_onlyid)){
            $where['sd_onlyid'] = array('LIKE','%'.$sd_onlyid.'%');
            $this->assign('sd_onlyid',$sd_onlyid);
        }
        /* 用户i*/
        $uidname = I('uid_name');
        if($uidname){
            $where['uid_name'] = array('LIKE','%'.$uidname.'%');
            $this->assign('uidname',$uidname);
        }
        /* 客户电话*/
        $sd_phone = I('sd_phone');
        if(is_numeric($sd_phone)){
            $where['sd_phone'] = array('LIKE','%'.$sd_phone.'%');;
            $this->assign('sd_phone',$sd_phone);
        }
        /* 提交时间 */
        $sdtime1 = I('sd_time1');
        $sdtime2 = I('sd_time2');
        if($sdtime1&&$sdtime2){
            $where['sd_time'] = array(
                ['lt',date('Y-m-d H:i:s',strtotime($sdtime2)+24*60*60)],
                ['gt',date('Y-m-d H:i:s',strtotime($sdtime1))]
            );
            $this->assign('sdtime1',$sdtime1);
            $this->assign('sdtime2',$sdtime2);
        }
        /* 需求进度 */
        $sd_state = I('sd_state');
        if(is_numeric($sd_state)){
            $where['sd_state'] = "$sd_state";
            $this->assign('sd_state',$sd_state);
        }
        /* 维修类型 */
        $sdwxtype = I('sd_wxtype');
        if($sdwxtype){
            $where['sd_wxtype'] = $sdwxtype;
            $this->assign('sdwxtype',$sdwxtype);
        }
        /* 提交类型 */
        $sdtjtype = I('sd_tjtype');
        if($sdtjtype){
            $where['sd_tjtype'] = $sdtjtype;
            $this->assign('sdtjtype',$sdtjtype);
        }
        $where['cuid'] = '1000000';
        /* 每页显示条数 */
        $num =  20;
        /* 页码 */
        $p = $_GET['p'] ? $_GET['p'] : 1;

        /* 获取分页列表  */
        $servicedemand_info = $servicedemand_model
            ->where($where)
            ->where($this->order_where)
            ->page($p . ',' . $num)
            ->order('thinkphp.sd_id desc')
            ->select();
        /* 获取分页条 */
        $count = $servicedemand_model->where($where)->where($this->order_where)->count();
        $page_model = new \Think\Page($count, $num);
        $page_bar = $page_model->show();

        /*查询施工需求中包含的所有用户需求ID*/
        $construction_model = M('construction');
        $csdid_info = $construction_model->field('c_sdid')->select();
        $csdids = [];
        foreach ($csdid_info as $v){
            unset($v['row_number']);
            $csdids[] = $v['c_sdid'];
        }
        $this->assign('csdids',$csdids);
        /*分页查询数据*/
        $this->assign('servicedemand_info',$servicedemand_info);
        $this->assign('page_bar', $page_bar);
        $this->assign('count',$count);
        $this->display();
    }

    /*用户维修需求详情---施工需求详情*/
    public function detail(){
        /*查询用户维修详情模板值*/
        $servicedemand_model = D('servicedemandView');
        $find['sd_id'] = I('sd_id');
        $servicedemand_info = $servicedemand_model->where($find)->find();
        $this->assign('info',$servicedemand_info);
        $imglist = explode(",",$servicedemand_info['sd_imglist']);
        $this->assign('imglist',$imglist);
        /*查询施工需求中包含的所有用户需求ID*/
        $construction_model = M('construction');
        $csdid_info = $construction_model->select();
        $csdids = [];
        foreach ($csdid_info as $v){
            unset($v['row_number']);
            $csdids[] = $v['c_sdid'];
        }
        $this->assign('csdids',$csdids);
        /*查询所有的师傅*/
        $userinfo_model = M('userinfo');
        /*用户表-类型为2师傅-启用-通过审核-上班*/
        $userinfo_find['u_type'] = '2';
        $userinfo_find['u_state'] = '1';
        $userinfo_find['u_toexamine'] = '1';
        $userinfo_find['u_shangban'] = 1;
        $userinfo_find['u_shanggong'] = 0;
        $userinfo_info = $userinfo_model->field('u_id,u_nickname,u_longitude,u_latitude')->where($userinfo_find)->select();
        $this->assign('userinfo_info',$userinfo_info);
        /*查询用户需求的经纬度*/
        $latlong = explode("-",$servicedemand_info['sd_did']);
        $newsgid = '';
        foreach ($userinfo_info as $k=>$v){
            if((6371004*acos((sin(deg2rad($latlong[1]))*sin(deg2rad($v['u_latitude']))+cos(deg2rad($latlong[1]))*cos(deg2rad($v['u_latitude']))*cos(deg2rad($v['u_longitude']-$latlong[0])))))<=5000){
                $newsgid.=$v['u_id'].",";
            }
        }
        $newsgid = substr($newsgid,0,strlen($newsgid)-1);
        $newsgid = $newsgid?$newsgid:'';
        $userinfo_where['u_id'] = array('in',$newsgid);
        $sgrs = $userinfo_model->where($userinfo_where)->field('u_id,u_nickname')->select();
        $this->assign('sguser',$sgrs);


        if($servicedemand_info['sd_tjtype'] == '20000'||$servicedemand_info['sd_tjtype'] == '30000'){
            /*判断当前存不存在*/
            if(in_array(I('sd_id'),$csdids)){
                /*查询模板的值*/
                $construction_model1 = D('constructionView');
                $construction_find['c_sdid'] = I('sd_id');
                $csdids_info = $construction_model1->where($construction_find)->find();
                $this->assign('csdidsinfo',$csdids_info);
                $str = $csdids_info['c_content'];
                $str = str_replace('imgs-qianmingimg',$csdids_info['c_qianmingimg'],$str);
                $this->assign('strs',$str);
                /*查询阶段的值*/
                $stage_model = M('stage');
                $stage_find['s_cid'] = $csdids_info['c_id'];
                $stage_info = $stage_model->field("s_id,s_number,s_price,s_startime,s_endtime,s_pay,s_content")->where($stage_find)->select();
                $this->assign('stage_info',$stage_info);
                $this->display('detail');
            }else{
                /*查询模板的值*/
                $construction_model1 = D('constructionView');
                $construction_find['c_sdid'] = I('sd_id');
                $csdids_info = $construction_model1->where($construction_find)->find();
                $this->assign('csdidsinfo',$csdids_info);
                /*查询施工状态的值*/
                $constructionflow_model = M('constructionflow');
                $constructionflow_where['cf_cid'] = $csdids_info['c_id'];
                $constructionflow_info = $constructionflow_model->where($constructionflow_where)->find();
                $this->assign('constructionflow_info',$constructionflow_info);
                /*查询阶段的值*/
                $stage_model = M('stage');
                $stage_find['s_cid'] = $csdids_info['c_id'];
                $stage_info = $stage_model->field("s_id,s_number,s_price,s_startime,s_endtime,s_pay,s_content")->where($stage_find)->select();
                $this->assign('stage_info',$stage_info);
                $this->display('modify');
            }
        }else{
            /*查询模板的值*/
            $construction_model1 = D('constructionView');
            $construction_find['c_sdid'] = I('sd_id');
            $csdids_info = $construction_model1->where($construction_find)->find();
            $this->assign('csdidsinfo',$csdids_info);
            /*查询施工状态的值*/
            $constructionflow_model = M('constructionflow');
            $constructionflow_where['cf_cid'] = $csdids_info['c_id'];
            $constructionflow_info = $constructionflow_model->where($constructionflow_where)->find();
            $this->assign('constructionflow_info',$constructionflow_info);
            /*查询阶段的值*/
            $stage_model = M('stage');
            $stage_find['s_cid'] = $csdids_info['c_id'];
            $stage_info = $stage_model->field("s_id,s_number,s_price,s_startime,s_endtime,s_pay,s_content")->where($stage_find)->select();
            $this->assign('stage_info',$stage_info);
            $this->display('modify');
        }
    }

    /*修改施工需求*/
    public  function modify(){
        if(IS_POST){
            $construction_model = D('construction');
            /*==================修改施工需求的值=========================*/
            $data = I('post.');
            $cid['c_id'] = I('c_id');
            $data['c_content'] = I('c_content','','');
            $data['c_biaojiabiao'] = I('c_biaojiabiao','','');
            $data['c_biaojiabiao1'] = I('c_biaojiabiao1','','');
            unset($data['c_id']);
            $rs = $construction_model->where($cid)->save($data);
            if(!$rs){
                $this->error('修改失败','',1);
            }else{
                $this->success('修改成功','',1);
            }
        }else{
            /*查询用户维修详情模板值*/
            $servicedemand_model = D('servicedemandView');
            $find['sd_id'] = I('sd_id');
            $servicedemand_info = $servicedemand_model->where($find)->find();
            $this->assign('info',$servicedemand_info);
            $imglist = explode(",",$servicedemand_info['sd_imglist']);
            $this->assign('imglist',$imglist);

            /*查询施工需求中包含的所有用户需求ID*/
            $construction_model = M('construction');
            $csdid_info = $construction_model->select();
            $csdids = [];
            foreach ($csdid_info as $v){
                unset($v['row_number']);
                $csdids[] = $v['c_sdid'];
            }
            $this->assign('csdids',$csdids);
            /*查询所有的师傅*/
            $userinfo_model = M('userinfo');
            /*用户表-类型为2师傅-启用-通过审核-上班*/
            $userinfo_find['u_type'] = '2';
            $userinfo_find['u_state'] = '1';
            $userinfo_find['u_toexamine'] = '1';
            $userinfo_find['u_shangban'] = 1;
            $userinfo_find['u_shanggong'] = 0;
            $userinfo_info = $userinfo_model->field('u_id,u_nickname,u_longitude,u_latitude')->where($userinfo_find)->select();
            $this->assign('userinfo_info',$userinfo_info);
            /*查询用户需求的经纬度*/
            $latlong = explode("-",$servicedemand_info['sd_did']);
            $newsgid = '';
            foreach ($userinfo_info as $k=>$v){
                if((6371004*acos((sin(deg2rad($latlong[1]))*sin(deg2rad($v['u_latitude']))+cos(deg2rad($latlong[1]))*cos(deg2rad($v['u_latitude']))*cos(deg2rad($v['u_longitude']-$latlong[0])))))<=5000){
                    $newsgid.=$v['u_id'].",";
                }
            }
            $newsgid = substr($newsgid,0,strlen($newsgid)-1);
            $newsgid = $newsgid?$newsgid:'';
            $userinfo_where['u_id'] = array('in',$newsgid);
            $sgrs = $userinfo_model->where($userinfo_where)->field('u_id,u_nickname')->select();
            $this->assign('sguser',$sgrs);

            if($servicedemand_info['sd_tjtype'] == '20000'||$servicedemand_info['sd_tjtype'] == '30000'){
                if(in_array(I('sd_id'),$csdids)){
                    /*查询模板的值*/
                    $construction_model1 = D('constructionView');
                    $construction_find['c_sdid'] = I('sd_id');
                    $csdids_info = $construction_model1->where($construction_find)->find();
                    $this->assign('csdidsinfo',$csdids_info);
                    $str = $csdids_info['c_content'];
                    $str = str_replace('imgs-qianmingimg',$csdids_info['c_qianmingimg'],$str);
                    $this->assign('strs',$str);
                    /*查询阶段的值*/
                    $stage_model = M('stage');
                    $stage_find['s_cid'] = $csdids_info['c_id'];
                    $stage_info = $stage_model->field("s_id,s_number,s_price,s_startime,s_endtime,s_pay,s_content")->where($stage_find)->select();
                    $this->assign('stage_info',$stage_info);
                    $this->display('detail');
                }else{
                    /*查询模板的值*/
                    $construction_model1 = D('constructionView');
                    $construction_find['c_sdid'] = I('sd_id');
                    $csdids_info = $construction_model1->where($construction_find)->find();
                    $this->assign('csdidsinfo',$csdids_info);
                    /*查询施工状态的值*/
                    $constructionflow_model = M('constructionflow');
                    $constructionflow_where['cf_cid'] = $csdids_info['c_id'];
                    $constructionflow_info = $constructionflow_model->where($constructionflow_where)->select();
                    $this->assign('constructionflow_info',$constructionflow_info);
                    /*查询阶段的值*/
                    $stage_model = M('stage');
                    $stage_find['s_cid'] = $csdids_info['c_id'];
                    $stage_info = $stage_model->field("s_id,s_number,s_price,s_startime,s_endtime,s_pay,s_content")->where($stage_find)->select();
                    $this->assign('stage_info',$stage_info);
                    $this->display('modify');
                }
            }else{
                /*查询模板的值*/
                $construction_model1 = D('constructionView');
                $construction_find['c_sdid'] = I('sd_id');
                $csdids_info = $construction_model1->where($construction_find)->find();
                $this->assign('csdidsinfo',$csdids_info);
                /*查询施工状态的值*/
                $constructionflow_model = M('constructionflow');
                $constructionflow_where['cf_cid'] = $csdids_info['c_id'];
                $constructionflow_info = $constructionflow_model->where($constructionflow_where)->find();
                $this->assign('constructionflow_info',$constructionflow_info);
                /*查询阶段的值*/
                $stage_model = M('stage');
                $stage_find['s_cid'] = $csdids_info['c_id'];
                $stage_info = $stage_model->field("s_id,s_number,s_price,s_startime,s_endtime,s_pay,s_content")->where($stage_find)->select();
                $this->assign('stage_info',$stage_info);
                $this->display('modify');
            }
        }
    }

    /*========开始施工========*/
    public function modify_sgstatus(){
        $construction_model = D('construction');
        $servicedemand_model = D('servicedemand');
        $model = M();
        $model->startTrans();
        $servicedemand_where['sd_id'] = I('sd_id');
        $servicedemand_data['sd_state'] = '9';
        $rs1 = $servicedemand_model->where($servicedemand_where)->save($servicedemand_data);
        if(!$rs1){
            $model->rollback();
            $this->error('申请失败！','',1);
        }
        $construction_where['c_id'] = I('c_id');
        $construction_data['c_state'] = '9';
        $rs2 = $construction_model->where($construction_where)->save($construction_data);
        if(!$rs2){
            $model->rollback();
            $this->error('申请失败！','',1);
        }else{
            $model->commit();
            $this->success('申请成功','',1);
        }
    }
    /*========申请完工========*/
    public function modify_wgstatus(){
        $construction_model = D('construction');
        $servicedemand_model = D('servicedemand');
        $model = M();
        $model->startTrans();
        $servicedemand_where['sd_id'] = I('sd_id');
        $servicedemand_data['sd_state'] = '17';
        $rs1 = $servicedemand_model->where($servicedemand_where)->save($servicedemand_data);
        if(!$rs1){
            $model->rollback();
            $this->error('申请失败！','',1);
        }
        /*====================添加施工流程============================*/
        $constructionflow_model = M('constructionflow');
        $flow_data['cf_cid'] = I('c_id');
        $flow_data['cf_state'] = '17';
        $flow_data['cf_content'] = '';
        $flow_data['cf_time'] = date('Y-m-d H:i:s');
        $flow_data['cf_needconsent'] = 0;
        $flow_data['cf_agree'] = 3;
        $flow_data['cf_pay'] = 0;
        $flow_data['cf_stageid'] = 0;
        $flow_data['cf_ispay'] = 0;
        $flow_data['cf_yanshoucontent'] = '';
        $rs111 = $constructionflow_model->add($flow_data);
        if(!$rs111){
            $model->rollback();
            $this->error('申请失败！','',1);
        }

        $construction_where['c_id'] = I('c_id');
        $construction_data['c_state'] = '17';
        $rs2 = $construction_model->where($construction_where)->save($construction_data);
        if(!$rs2){
            $model->rollback();
            $this->error('申请失败！','',1);
        }else{
            $model->commit();
            $this->success('申请成功','',1);
        }
    }

}