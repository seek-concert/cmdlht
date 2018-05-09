<?php
namespace Home\Controller;
class ProductorderController extends AuthController
{
    /*产品订单-列表*/
    public function index_list(){
        $productorder_model = D('productorderView');
        /* 查询条件 */
        $where = array();
        /*产品ID*/
        $pdatvid = I('pd_atvid');
        if($pdatvid){
            $where['pd_atvid'] = $pdatvid;
            $this->assign('pdatvid',$pdatvid);
        }
        /* 订单唯一编号*/
        $pdonlyid = I('pd_onlyid');
        if($pdonlyid){
            $where['pd_onlyid'] = array('like',"%$pdonlyid%");
            $this->assign('pdonlyid',$pdonlyid);
        }
        /* 下单时间 */
        $pdtime1 = I('pd_time1');
        $pdtime2 = I('pd_time2');
        if($pdtime1&&$pdtime2){
            $where['pd_time'] = array(
                ['lt',date('Y-m-d H:i:s',strtotime($pdtime2)+24*60*60)],
                ['gt',date('Y-m-d H:i:s',strtotime($pdtime1))]
            );
            $this->assign('pdtime1',$pdtime1);
            $this->assign('pdtime2',$pdtime2);
        }

        /*订单状态*/
        $pdstate = I('pd_state');
        if(is_numeric($pdstate)){
            $where['pd_state'] = "$pdstate";
            $this->assign('pdstate',$pdstate);
        }
        /*支付类型*/
        $pdtype = I('pd_type');
        if(is_numeric($pdtype)){
            $where['pd_type'] = "$pdtype";
            $this->assign('pdtype',$pdtype);
        }
        /* 支付时间 */
        $pdpaytime1 = I('pd_paytime1');
        $pdpaytime2 = I('pd_paytime2');
        if($pdpaytime1&&$pdpaytime2){
            $where['pd_paytime'] = array(
                ['lt',date('Y-m-d H:i:s',strtotime($pdpaytime2)+24*60*60)],
                ['gt',date('Y-m-d H:i:s',strtotime($pdpaytime1))]
            );
            $this->assign('pdpaytime1',$pdpaytime1);
            $this->assign('pdpaytime2',$pdpaytime2);
        }
        /* 用户区域条件 */
        $user_info = $this->user_info;
        $level = $user_info['p_level'];
        if($level==1){
            $levelwhere['pd_province'] = $user_info['p_sheng'];
        }
        if($level==2){
            $levelwhere['pd_province'] = $user_info['p_sheng'];
            $levelwhere['pd_city'] = $user_info['p_shi'];
        }
        if($level==3){
            $levelwhere['pd_province'] = $user_info['p_sheng'];
            $levelwhere['pd_city'] = $user_info['p_shi'];
            $levelwhere['pd_county'] = $user_info['p_xian'];
        }
        /* 每页显示条数 */
        $num =  20;
        /* 页码 */
        $p = $_GET['p'] ? $_GET['p'] : 1;

        /* 获取分页列表  */
        $productorder_info = $productorder_model
            ->where($where)
            ->where($levelwhere)
            ->page($p . ',' . $num)
            ->order('thinkphp.pd_id desc')
            ->select();

        /* 获取分页条 */
        $count = $productorder_model->where($where)->where($levelwhere)->count();
        $page_model = new \Think\Page($count, $num);
        $page_bar = $page_model->show();

        /*分页查询数据*/
        $this->assign('productorder_info',$productorder_info);
        $this->assign('page_bar', $page_bar);
        $this->assign('count',$count);
        $this->display();
    }

    /*产品订单-批量修改状态*
    *状态改变时间的修改*
     * */
    public function status_modify(){
        $productorder_model = M('productorder');
        /*获取IDS*/
        $str =  I('pd_id');
        $find['pd_id']=array('in',$str);
        /*查询支付类型*/
        $pdtype_info = $productorder_model->field('pd_type')->where($find)->select();
        $typeids = array();
        foreach ($pdtype_info as $v){
            unset($v['row_number']);
            $typeids[$v['pd_type']][] = $v;
        }
        if(count($typeids)>1){
            $this->error("请选择相同支付方式进行修改！",'',1);
        }
        $pdtypeids = array();
        foreach ($typeids as $v){
            unset($v['row_number']);
            foreach ($v as $val){
                $pdtypeids[] = $val;
            }
        }
        /*开始事务处理*/
        $model = M();
        $model->startTrans();

        if($pdtypeids[0]['pd_type'] == '0'){
            if(I('pd_state')!="-1"){
                $this->error("买家未支付，只能取消订单！",'',1);
            }
            /*取消订单删除分销提成记录*/
            $pay_model = M('pay');
            $pay_where['p_type'] = 10000;
            $pay_where['p_ddid'] = array('in',$str);
            $pay_ids = $pay_model->where($pay_where)->getField('p_id',true);

            $commission_model = M('commission');
            $del_where['c_pid'] = array('in',$pay_ids);
            $rs2 = $commission_model->where($del_where)->delete();
            if(!$rs2){
                /*事务回滚*/
                $model->rollback();
                $this->error("修改失败","",1);
            }
            $data['pd_state'] = '-1';
            $data['pd_changechangetime'] = date('Y-m-d H:i:s');
            $rs = $productorder_model->where($find)->save($data);
        }else{
            $data['pd_state'] = I('pd_state');
            if($data['pd_state']=='-1'){
                $this->error("买家已支付，无法取消订单！",'',1);
            }
            if($data['pd_state']=='2'){
               $data['pd_kuaidinumber'] = I('pd_kuaidinumber');
            }
            $data['pd_changechangetime'] = date('Y-m-d H:i:s');
            $rs = $productorder_model->where($find)->save($data);
        }
        if(!$rs){
            /*事务回滚*/
            $model->rollback();
            $this->error("修改失败","",1);
        }
        /*订单详情---状态修改*/
        $orderdetails_model = M('orderdetails');
        $orderdetails_find['od_pdid'] = array('in',$str);
        $orderdetails_data['od_state'] = I('pd_state');
        $rs1 = $orderdetails_model->where($orderdetails_find)->save($orderdetails_data);
        if ($rs1)
        {
            $model->commit();
            $this->success("修改成功",'',1);
        } else {
            $model->rollback();
            $this->error("修改失败",'',1);
        }
    }
    /* 异步修改状态 */
    public function del_modify()
    {
        $action = $_REQUEST['action'];
        $ids = $_REQUEST['ids'];
        if (!$ids) {
            $this->error('至少选择一项！', '', 1);
        }
        if (!$action) {
            $this->error('操作错误', '', 1);
        }
        $productorder_model = M('productorder');
        $where['pd_id'] = array('in', $ids);
        if ($action == 'on') {
            $data['pd_del'] = '0';
        }
        if ($action == 'off') {
            $data['pd_del'] = '1';
        }
        $result = $productorder_model->where($where)->save($data);
        if ($result) {
            $this->success('操作成功', '', 1);
        } else {
            $this->error('操作失败', '', 1);
        }
    }

    /*产品订单及详情模板*/
    public function detail(){
        /*=========查询订单管理的信息==========*/
        $productorder_model = D('productorderView');
        $productorder_find['pd_id'] = I('pd_id');
        $productorder_info = $productorder_model->where($productorder_find)->find();
        $this->assign('info',$productorder_info);
        /*=========查询订单详情的信息==========*/
        $orderdetails_model = D('orderdetailsView');
        $orderdetails_find['od_onlyid'] = $productorder_info['pd_onlyid'];
        $orderdetails_info = $orderdetails_model->where($orderdetails_find)->select();
        $this->assign('orderdetails_info',$orderdetails_info);
        /*查询单号*/

        /*=========查询产品订单流程的信息==========*/
        $productorderstate_model = D('productorderstate');
        $productorderstate_find['pos_pdonlyid'] = $productorder_info['pd_onlyid'];
        $productorderstate_info = $productorderstate_model->where($productorderstate_find)->select();
        $state_info = [];
        foreach($productorderstate_info as $k=>$v){
            $state_info[] = $v['pos_img'];
        }
        $state_info = implode(",",array_filter($state_info));
        $state_info = explode(',',$state_info);
        $this->assign('state_info',$state_info);
//        /*字符串转换*/
//        $productorderstateinfo = htmlspecialchars_decode("<br/>".$productorderstate_info['pos_remarks']);
//        $productorderstateinfo_data = explode(" ",$productorderstateinfo);
//        $this->assign('productorderstate_info',$productorderstateinfo_data);
        /*调用修改模板*/
        $this->display('modify');
    }
    /*订单详情----状态修改*/
    public function state_modify(){
        $orderdetails_model = M('orderdetails');
        $productorder_model = M('productorder');
        /*开始事务处理*/
        $model = M();
        $model->startTrans();

        $find['od_id'] = I('od_id');
        $data['od_state'] = I('od_state');
        if($data['od_state']=="22"){
            $data['od_tuihuoname'] = I('od_tuihuoname');
            $data['od_tuihuonumber'] = I('od_tuihuonumber');
        }
        $rs = $orderdetails_model->where($find)->save($data);
        if(!$rs){
            $model->rollback();
            $this->error('修改失败','',1);
        }
        /*查询订单ID*/
        $where['od_id'] = I('od_id');
        $pd_id = $orderdetails_model->field('od_pdid')->where($where)->find();
        /*修改订单状态*/
        $productorder_where['pd_id'] = $pd_id['od_pdid'];
        $productorder_data['pd_state'] = I('od_state');
        $rs1 = $productorder_model->where($productorder_where)->save($productorder_data);
        if($rs1){
            $model->commit();
            $this->success('修改成功','',1);
        }else{
            $model->rollback();
            $this->error('修改失败','',1);
        }

    }
    /*订单详情----退货完成*/
    public function state_modifys(){
        $orderdetails_model = M('orderdetails');
        $productorder_model = M('productorder');
        /*开始事务处理*/
        $model = M();
        $model->startTrans();

        $find['od_id'] = I('od_id');
        $data['od_state'] = I('od_state');
        $data['od_tuikuandanhao'] = "";
        $data['od_tuikuanstate'] = 1;
        $rs = $orderdetails_model->where($find)->save($data);
        if(!$rs){
            $model->rollback();
            $this->error('修改失败','',1);
        }
        /*查询订单ID*/
        $where['od_id'] = I('od_id');
        $pd_id = $orderdetails_model->field('od_pdid')->where($where)->find();
        /*修改订单状态*/
        $productorder_where['pd_id'] = $pd_id['od_pdid'];
        $productorder_data['pd_state'] = I('od_state');
        $rs1 = $productorder_model->where($productorder_where)->save($productorder_data);
        if($rs1){
            $model->commit();
            $this->success('修改成功','',1);
        }else{
            $model->rollback();
            $this->error('修改失败','',1);
        }

    }
    /*订单统计*/
    public function statistics(){
        if(IS_POST){
            $productorder_model = M('productorder');
            $year = I('yeararrays');
            $month = I('month');
            if($month&&!$year){
                $this->error('请选择年份！','',1);
            }
            $where="1=1";
            if($year){
                $where.=" and year(pd_time)=year('$year-01-01')";
                $rs =$productorder_model->field('count(*) as numbers,CONVERT(varchar(7),pd_time,111) as times')->where($where)->group('(CONVERT(varchar(7),pd_time,111))')->select();
            }
            if ($month){
                $where.=" and month(pd_time)=month('2017-$month-01')";
                $rs =$productorder_model->field('count(*) as numbers,CONVERT(varchar(10),pd_time,111) as times')->where($where)->group('(CONVERT(varchar(10),pd_time,111))')->select();
            }
            if(!$year&&!$month){
                $rs =$productorder_model->field('count(*) as numbers,CONVERT(varchar(4),pd_time,111) as times')->group('(CONVERT(varchar(4),pd_time,111))')->select();
            }
            $newarray = [];
            foreach ($rs as $v){
                unset($v['row_number']);
                if(strlen($v['times'])==4){
                    $newarray[] = array($v['times'],$v['numbers']);
                }
                if(strlen($v['times'])==7){
                    $newarray[] = array(substr($v['times'],5,2),$v['numbers']);
                }
                if(strlen($v['times'])==10){
                    $newarray[] = array(substr($v['times'],8,2),$v['numbers']);
                }
            }
            if($newarray){
                $this->success('','',array('datas'=>$newarray));
            }
        }else{
            $productorder_model = M('productorder');
            $rs =$productorder_model->field('distinct CONVERT(varchar(4),pd_time,120) as years')->select();
            $this->assign('yeararray',$rs);

            $rs =$productorder_model->field('count(*) as numbers,CONVERT(varchar(4),pd_time,111) as times')->group('(CONVERT(varchar(4),pd_time,111))')->select();
            $newarray = [];
            foreach ($rs as $v){
                unset($v['row_number']);
                $newarray[] = array($v['times'],$v['numbers']);
            }
            $a = json_encode($newarray);
            $this->assign('timedata',$a);
            $this->display();
        }
    }

    /*订单Excel导出*/
    public function excel_order(){
        $productorder_model = D('productorderView');
        /*获取IDS*/
        $str =  $_REQUEST['ids'];
        if(!$str){
            $this->error('请选择要导出的数据','',1);
        }
        $find['pd_id']=array('in',$str);
        $productorder_data = $productorder_model->field('pd_allonlyid,pd_paytime,pd_type,pd_money,pd_fuid,pd_id,fphone,frealname,fuid_name')->where($find)->select();
         $newarray = [];
        unset($productorder_data[0]);
        unset($productorder_data[1]);
        foreach ($productorder_data as $k=>$v){
            $v['pd_money'] = sprintf("%.2f", $v['pd_money']);
           if($v['pd_allonlyid']==$v['pd_allonlyid']){
                unset($productorder_data[$k]);
           }
            if($v['pd_type']==0){
                $v['pd_paytime'] = '暂未支付';
                $v['pd_type'] = '未支付';
            }else{
                $v['pd_paytime'] = date("Y-m-d H:i",strtotime($v['pd_paytime']));
                if($v['pd_type']==1){
                    $v['pd_type'] = '线上支付';
                }
                if($v['pd_type']==2){
                    $v['pd_type'] = '线下支付';
                }
            }
            $newarray[] =  array_values(array_reverse($v));
        }
        $newarrays = [];
        foreach ($newarray as $k=>$v){
            $v[0]=$k+1;
            $newarrays[] = $v;
        }
        // 导出Exl
        $titel_data = array(array_reverse(array('订单唯一编号','支付时间','支付方式','总金额','商家ID','订单ID','商家电话','商家姓名','商家昵称','编号')));
        $data = array_merge($titel_data,$newarrays);

       $dates = date("Y-m-d",time());
        create_xls($data,$dates);
    }
}