<?php
namespace Home\Controller;

class ServicedemandController extends AuthController
{
    /*用户维修需求-列表显示*/
    public function index_list(){
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
        /* 维修类型 */
        $sdwxtype = I('sd_wxtype');
        if($sdwxtype){
            $where['sd_wxtype'] = $sdwxtype;
            $this->assign('sdwxtype',$sdwxtype);
        }
        /* 需求进度 */
        $sd_state = I('sd_state');
        if(is_numeric($sd_state)){
            $where['sd_state'] = "$sd_state";
            $this->assign('sd_state',$sd_state);
        }
        /* 提交类型 */
        $sdtjtype = I('sd_tjtype');
        if($sdtjtype){
            $where['sd_tjtype'] = $sdtjtype;
            $this->assign('sdtjtype',$sdtjtype);
        }
       /* $where['cuid'] = array('neq','1000000');*/
        /* 用户区域条件 */
        $user_info = $this->user_info;
        $level = $user_info['p_level'];
        if($level==1){
            $levelwhere['sd_province'] = $user_info['p_sheng'];
        }
        if($level==2){
            $levelwhere['sd_province'] = $user_info['p_sheng'];
            $levelwhere['sd_city'] = $user_info['p_shi'];
        }
        if($level==3){
            $levelwhere['sd_province'] = $user_info['p_sheng'];
            $levelwhere['sd_city'] = $user_info['p_shi'];
            $levelwhere['sd_county'] = $user_info['p_xian'];
        }
        /* 每页显示条数 */
        $num =  20;
        /* 页码 */
        $p = $_GET['p'] ? $_GET['p'] : 1;

        /* 获取分页列表  */
        $servicedemand_info = $servicedemand_model
            ->where($where)
            ->where($levelwhere)
            ->page($p . ',' . $num)
            ->order('thinkphp.sd_id desc')
            ->select();

        /* 获取分页条 */
        $count = $servicedemand_model->where($where)->where($levelwhere)->count();
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

    /*施工需求======添加*/
    public function insert(){
        /*查询用户维修详情模板值*/
        $servicedemand_model = D('servicedemandView');
        $find['sd_id'] = I('sd_id');
        $servicedemand_info = $servicedemand_model->where($find)->find();
        $this->assign('info',$servicedemand_info);
        /*--------------------查询所有的师傅------------------------*/
//        $userinfo_model = M('userinfo');
//        /*用户表-类型为2师傅-启用-通过审核-上班*/
//        $userinfo_find['u_type'] = '2';
//        $userinfo_find['u_state'] = '1';
//        $userinfo_find['u_toexamine'] = '1';
//        $userinfo_find['u_shangban'] = 1;
//        $userinfo_info = $userinfo_model->field('u_id,u_nickname')->where($userinfo_find)->select();
//        $this->assign('userinfo_info',$userinfo_info);
        if(IS_POST){
            $construction_model = D('construction');
            $stage_model = D('stage');
            $servicedemand_model = D('servicedemand');
            /*开启事务处理*/
            $model = M();
            $model->startTrans();
            $servicedemand_where['sd_id'] = I('sd_id');
            $servicedemand_data['sd_pgstate'] = 2;
            if(I('c_tuisong')==1){
                $servicedemand_data['sd_state'] = 2;
            }
            $servicedemand_rs = $servicedemand_model->where($servicedemand_where)->save($servicedemand_data);
            if(!$servicedemand_rs){
                $model->rollback();
                $this->error('添加失败！','',1);
            }
            /*==================添加施工需求========================*/
            $data = $construction_model->create();
            if(!$data){
                $this->error($construction_model->getError(),'',1);
            }
            $data = I('post.');
            if(I('c_tuisong')==1){
                $data['c_state'] = "2";
            }else{
                $data['c_state'] = "0";
            }
            $data['c_qianming'] = "0";
            $data['c_qianmingimg'] = "";
            $data['c_time'] = date("Y-m-d H:i:s");
            $data['c_jiedantime'] = date("Y-m-d H:i:s");
            $data['c_wangong'] = date("Y-m-d H:i:s");
            $data['c_wancheng'] = "0";

            $data['c_content'] = I('c_content','','');
            $data['c_biaojiabiao'] = I('c_biaojiabiao','','');
            $data['c_biaojiabiao1'] = I('c_biaojiabiao1','','');
           if($data['c_money']){
                $data['c_onemoney'] = bcmul($data['c_money'],'0.60',2);
                $data['c_twomoney'] = bcmul($data['c_money'],'0.40',2);
                $data['c_jieduanpay'] = 0;
           }
            $rs = $construction_model->add($data);
            if(!$rs){
                $model->rollback();
                $this->error('添加失败！','',1);
            }
            /*====================是否添加阶段============================*/
            $c_stagepay = I('c_stagepay');
            if($c_stagepay == 0){
                $model->commit();
                $this->success('添加成功','',1);
            }else{
                /*====================添加阶段的值============================*/
                $stage_data = $stage_model->create();
                if(!$stage_data){
                    $this->error($construction_model->getError(),'',1);
                }
                /*获取数据---转数组*/
                $s_number = I('s_number');
                $s_number = explode(",,,",$s_number);
                $s_price = I('s_price');
                $s_price = explode(",,,",$s_price);
                $s_startime = I('s_startime');
                $s_startime = explode(",,,",$s_startime);
                $s_endtime = I('s_endtime');
                $s_endtime = explode(",,,",$s_endtime);
                $s_content = I('s_content');
                $s_content = explode(",,,",$s_content);
                /*获取添加的条数*/
                $valLength = count($s_number);
                $valArray = [];
                for($i = 0;$i<$valLength;$i++){
                    $valArray[] = array(
                        's_cid'=>$rs,
                        's_number'=>$s_number[$i],
                        's_price'=>$s_price[$i],
                        's_startime'=>$s_startime[$i],
                        's_endtime'=>$s_endtime[$i],
                        's_content'=>$s_content[$i],
                        's_pay'=>'0',
                        's_payid'=>'0',
                        's_state'=>'0',
                        's_buxiucontent'=>'',
                        's_chengguocontent'=>''
                    );
                }
                $stage_rs = $stage_model->addAll($valArray);
                if(!$stage_rs){
                    $model->rollback();
                    $this->error('添加失败','',1);
                }else{
                    $model->commit();
                    $this->success('添加成功','',1);
                }
            }

        }else{
            $this->display();
        }
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

    /*上门评估------用户维修需求----修改*/
    public function modifys_insert(){
        if(IS_POST){
            $servicedemand_model = D('servicedemand');
            $sd_pguid = I('sd_pguid');
            if($sd_pguid == 0||!$sd_pguid){
               $this->error('评估人员不能为空','',1);
            }
            $where['sd_id'] = I('sd_id');
            $data['sd_pguid'] =  $sd_pguid;
            $data['sd_pgstate'] =  1;
            $rs = $servicedemand_model->where($where)->save($data);
            if(!$rs){
               $this->error('添加失败','',1);
            }else{
                $this->success('添加成功','',1);
            }
        }else{
            /*查询用户维修详情模板值*/
            $servicedemand_model = D('servicedemandView');
            $find['sd_id'] = I('sd_id');
            $servicedemand_info = $servicedemand_model->where($find)->find();
            $this->assign('info',$servicedemand_info);
            $imglist = explode(",",$servicedemand_info['sd_imglist']);
            $this->assign('imglist',$imglist);
            /*---------------------------查询所有的评估人员------------------*/
            $userinfo_model = M('userinfo');
            /*==========用户表-类型为4评估人员-启用-通过审核============*/
            $userinfo_find['u_type'] = '4';
            $userinfo_find['u_state'] = '1';
            $userinfo_find['u_toexamine'] = '1';
            $userinfo_info = $userinfo_model->field('u_id,u_latitude,u_longitude')->where($userinfo_find)->select();
            /*查询用户需求的经纬度*/
            $latlong = explode("-",$servicedemand_info['sd_did']);
            $newsgid = '';
            foreach ($userinfo_info as $k=>$v){
                if((6371004*acos((sin(deg2rad($latlong[1]))*sin(deg2rad($v['u_latitude']))+cos(deg2rad($latlong[1]))*cos(deg2rad($v['u_latitude']))*cos(deg2rad($v['u_longitude']-$latlong[0])))))<=10000){
                    $newsgid.=$v['u_id'].",";
                }
            }
            $newsgid = substr($newsgid,0,strlen($newsgid)-1);
            $newsgid = $newsgid?$newsgid:'';
            $userinfo_where['u_id'] = array('in',$newsgid);
            $sgrs = $userinfo_model->where($userinfo_where)->field('u_id,u_nickname')->select();
            $this->assign('userinfo_info',$sgrs);
            $this->display('modifys');
        }
    }

    /*上门评估------用户维修需求------详情*/
    public function modifys_modify(){
        /*查询用户维修详情模板值*/
        $servicedemand_model = D('servicedemandView');
        $find['sd_id'] = I('sd_id');
        $servicedemand_info = $servicedemand_model->where($find)->find();
        $this->assign('info',$servicedemand_info);
        $imglist = explode(",",$servicedemand_info['sd_imglist']);
        $this->assign('imglist',$imglist);
        /*---------------------------查询所有的评估人员------------------*/
        $userinfo_model = M('userinfo');
        /*==========用户表-类型为4评估人员-启用-通过审核============*/
        $userinfo_find['u_type'] = '4';
        $userinfo_find['u_state'] = '1';
        $userinfo_find['u_toexamine'] = '1';
        $userinfo_info = $userinfo_model->field('u_id,u_latitude,u_longitude')->where($userinfo_find)->select();
        /*查询用户需求的经纬度*/
        $latlong = explode("-",$servicedemand_info['sd_did']);
        $newsgid = '';
        foreach ($userinfo_info as $k=>$v){
            if((6371004*acos((sin(deg2rad($latlong[1]))*sin(deg2rad($v['u_latitude']))+cos(deg2rad($latlong[1]))*cos(deg2rad($v['u_latitude']))*cos(deg2rad($v['u_longitude']-$latlong[0])))))<=10000){
                $newsgid.=$v['u_id'].",";
            }
        }
        $newsgid = substr($newsgid,0,strlen($newsgid)-1);
        $newsgid = $newsgid?$newsgid:'';
        $userinfo_where['u_id'] = array('in',$newsgid);
        $sgrs = $userinfo_model->where($userinfo_where)->field('u_id,u_nickname')->select();
        $this->assign('userinfo_info',$sgrs);

        $this->display('modifys');
    }

    /*需求用户信息-----Excel导出*/
    public function excel_order(){
        $servicedemand_model = D('servicedemandView');
        /*获取IDS*/
        $str =  $_REQUEST['ids'];
        if(!$str){
            $this->error('请选择要导出的数据','',1);
        }
        $find['sd_id']=array('in',$str);
        $servicedemand_data = $servicedemand_model->field('sd_time,sd_address,sd_province,sd_city,sd_county,sd_phone,sd_name,sd_payyajin	,sd_yajin,sd_thedoor,sd_weixiuname')->where($find)->select();
        $newarray = [];
        foreach ($servicedemand_data as $k=>$v){
           $v['sd_thedoor'] = sprintf("%.2f", $v['sd_thedoor']);
           $v['sd_yajin'] = sprintf("%.2f", $v['sd_yajin']);
            if($v['sd_payyajin	']==0){
                $v['sd_payyajin'] = '未支付';
            }else{
                $v['sd_payyajin'] = '已支付';
            }
            if(!$v['sd_address']){
                $v['sd_address'] = '未填写';
            }
            $v['sd_time'] = date("Y-m-d H:i",strtotime($v['sd_time']));
            $v['ssx'] = $v['sd_province'].$v['sd_city'].$v['sd_county'];
            unset($v['sd_province']);
            unset($v['sd_city']);
            unset($v['sd_county']);
            ksort($v);
            $newarray[] =  $v;
        }
        // 导出Exl
        $titel_data = array(array_reverse(array('省市县','押金','需维修名称','发布时间','上门费','客户电话','是否支付押金','客户姓名','客户地址','编号')));
        $data = array_merge($titel_data,$newarray);

        $dates = date("Y-m-d",time());
        createservicedemand_xls($data,$dates);
    }

    /*指派人员*/
    public function modify_zhipai(){
        if(IS_POST){
            $construction_model = D('construction');
            $c_wxname = I('c_wxname');
            if(empty($c_wxname)){
                $this->error('维修人员姓名不能为空','',1);
            }
            $c_wxphone = I('c_wxphone');
            if(empty($c_wxphone)){
                $this->error('维修人员电话不能为空','',1);
            }
            $where['c_id'] = I('c_id');
            $data['c_wxname'] =  $c_wxname;
            $data['c_wxphone'] =  $c_wxphone;
            $data['c_uid'] =  3000000;
            $rs = $construction_model->where($where)->save($data);
            if(!$rs){
                $this->error('指派失败','',1);
            }else{
                $this->success('指派成功','',1);
            }
        }
    }

}