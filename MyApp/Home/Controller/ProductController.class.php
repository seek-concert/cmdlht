<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-06-07
 * Time: 14:02
 */

namespace Home\Controller;

class ProductController extends AuthController
{
    /*产品-列表*/
    public function index_list(){
        $product_model = D('ProductView');
        /* 查询条件 */
        $where = array();
        /* 产品名称*/
        $pname = trim(I('p_name'));
        if($pname){
            $where['p_name'] = array('LIKE','%'.$pname.'%');
            $this->assign('pname',$pname);
        }
        /* 品牌*/
        $bidname = I('bid_name');
        if($bidname){
            $where['bid_name'] = array('LIKE','%'.$bidname.'%');
            $this->assign('bidname',$bidname);
        }
        /* 商家*/
        $uidname = I('uid_name');
        if($uidname){
            $where['uid_name'] = array('LIKE','%'.$uidname.'%');
            $this->assign('uidname',$uidname);
        }
        /* 上架状态*/
        $pstate = I('p_state');
        if(is_numeric($pstate)){
            $where['p_state'] = "$pstate";
            $this->assign('pstate',$pstate);
        }
        /* 删除状态*/
        $pdel = I('p_del');
        if(is_numeric($pdel)){
            $where['p_del'] = "$pdel";
            $this->assign('pdel',$pdel);
        }
        if(!$pdel){
            $where['p_del'] = "0";
        }
        /* 添加时间*/
        $ptime1 = I('p_time1');
        $ptime2 = I('p_time2');
        if ($ptime1 && $ptime2) {
            $where['p_time'] = array(
                ['lt', date('Y-m-d H:i:s', strtotime($ptime2) + 24 * 60 * 60)],
                ['gt', date('Y-m-d H:i:s', strtotime($ptime1))]
            );
            $this->assign('ptime1',$ptime1);
            $this->assign('ptime2',$ptime2);
        }

        /* 是否有活动*/
        $pisactivity = I('p_isactivity');
        if(is_numeric($pisactivity)){
            $where['p_isactivity'] = "$pisactivity";
            $this->assign('pisactivity',$pisactivity);
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
        /* 每页显示条数 */
        $num =  20;
        /* 页码 */
        $p = $_GET['p'] ? $_GET['p'] : 1;

        /* 获取分页列表  */
        $product_info = $product_model
            ->where($where)
            ->where($level_wheres)
            ->page($p . ',' . $num)
            ->order('thinkphp.p_id desc')
            ->select();

        /* 获取分页条 */
        $count = $product_model->where($where)->where($level_wheres)->count();
        $page_model = new \Think\Page($count, $num);
        $page_bar = $page_model->show();

        /*查询所有的上级名称*/
        $pidname = $product_model->select();
        $this->assign('pidname',$pidname);

        /*查询当前的所有产品推荐ID*/
        $indexrecommend_model = D('indexrecommend');
        $indexrecommend_info = $indexrecommend_model->select();
        $irpid_ids = [];
        $irstate_ids = [];
        foreach ($indexrecommend_info as $k=>$v){
            $irpid_ids[] = $v['ir_pid'];
            $irstate_ids[$v['ir_state']][] = $v['ir_pid'];
        }
        $this->assign('irpid_ids',$irpid_ids);
        $this->assign('irstate_ids',$irstate_ids);
        /*分页查询数据*/
        $this->assign('product_info',$product_info);
        $this->assign('page_bar', $page_bar);
        $this->assign('count',$count);
        $this->display();
    }

    /* 异步修改状态---逻辑删除 */
    public function status_modify()
    {
        $model = M();
        $model->startTrans();
        $action = $_REQUEST['action'];
        $ids = $_REQUEST['ids'];
        if (!$ids) {
            $this->error('至少选择一项！', '', 1);
        }
        if (!$action) {
            $this->error('操作错误', '', 1);
        }
        $product_model = M('product');
        $where['p_id'] = array('in', $ids);
        if ($action == 'on') {
            $data['p_del'] = '1';
        }
        if ($action == 'off') {
            $data['p_del'] = '0';
        }
        $result = $product_model->where($where)->save($data);
        if(!$result){
            $model->rollback();
            $this->error('操作失败', '', 1);
        }
        $indexrecommend_model = M('indexrecommend');
        $where1['ir_pid'] = array('in', $ids);
        $sc_irpid = $indexrecommend_model->where($where1)->select();
        $sc_irpid = $sc_irpid?$sc_irpid:array();

        if($sc_irpid){
            $rs = $indexrecommend_model->where($where1)->delete();
            if(!$rs) {
                $model->rollback();
                $this->error('操作失败!', '', 1);
            }else{
                $model->commit();
                $this->success('操作成功!', '', 1);
            }
        }else{
            if ($result){
                $model->commit();
                $this->success('操作成功', '', 1);
            } else {
                $model->rollback();
                $this->error('操作失败', '', 1);
            }
        }
    }
    /* 异步修改状态---批量上下架 */
    public function status_modifys()
    {
        $action = $_REQUEST['action'];
        $ids = $_REQUEST['ids'];
        if (!$ids) {
            $this->error('至少选择一项！', '', 1);
        }
        if (!$action) {
            $this->error('操作错误', '', 1);
        }
        $product_model = M('product');
        $where['p_id'] = array('in', $ids);
        if ($action == 'on') {
            $data['p_state'] = '1';
        }
        if ($action == 'off') {
            $data['p_state'] = '0';
        }
        $result = $product_model->where($where)->save($data);
        if ($result) {
            $this->success('操作成功', '', 1);
        } else {
            $this->error('操作失败', '', 1);
        }
    }

    /* 异步修改状态---产品状态 */
    public function modify_qiyong()
    {
        $action = $_REQUEST['action'];
        $ids = $_REQUEST['ids'];
        if (!$ids) {
            $this->error('至少选择一项！', '', 1);
        }
        if (!$action) {
            $this->error('操作错误', '', 1);
        }
        $product_model = M('product');
        $where['p_id'] = array('in', $ids);
        if ($action == 'on') {
            $data['p_qiyong'] = '1';
        }
        if ($action == 'off') {
            $data['p_qiyong'] = '0';
        }
        $result = $product_model->where($where)->save($data);
        if ($result) {
            $this->success('操作成功', '', 1);
        } else {
            $this->error('操作失败', '', 1);
        }
    }
    /*产品-添加*/
    /*产品属性值-添加*/
    /*产品参数值-添加*/
    public function insert(){
        if(IS_POST){
            /*模型==产品==产品属性==产品参数*/
            $product_model = D('product');
            $productattributevalue_model = M('productattributevalue');
            $productparameter_model = M('productparameter');
           /*开始事务处理*/
            $model = M();
            $model->startTrans();
            /*=============产品的添加=============*/
            /*模型创建及数据验证*/
            $data = $product_model->create();
            if(!$data){
                $this->error($product_model->getError(),'',1);
            }
            unset($data['p_id']);
            $data['p_activityendtime']=date('Y-m-d H:i:s', strtotime(I('p_activityendtime')) + 24 * 60 * 60);
            if($data['p_isactivity'] == '0'){
                $data['p_activityname'] = "";
                $data['p_activitystartime']  = '2017-01-01 00:00:00';
                $data['p_activityendtime']  = '2017-01-01 00:00:00';
            }
            /*生成添加时间*/
            $data['p_time'] = date('Y-m-d H:i:s');
            $data['p_content'] = I('p_content','','');
            $data['p_shenhe'] = 1;
            $data['p_noticestate'] = 0;
            $data['p_jjcontent'] = "";
            $data['p_qiyong'] = 1;
            $data['p_searchkeyword'] = rtrim(I('p_searchkeyword'));
            /*执行添加*/
            $pid = $product_model->add($data);
            if(!$pid){
                /*事务回滚*/
                $model->rollback();
                $this->error("添加失败","",1);
            }
            /*=============产品属性的添加=============*/
            /*类型值 json转数组 */
            $typevalue_json = I('atv_typevalue','','');
            $atvtypevalue = json_decode($typevalue_json,true);
            /*获取数据的总条数*/
            $atvcount = $atvtypevalue['length'];
                    unset($atvtypevalue['length']);
            $aaa = array();
            $typeval = array();
            for($j=0;$j<=$atvcount;$j++){
                $stringtypeval[$j] = implode(",",$atvtypevalue[$j]);
                $stringtypeval1[$j] = str_replace(":",'":"',$stringtypeval[$j]);
                $stringtypeval2[$j] = str_replace(",",'","',$stringtypeval1[$j]);
                $stringtypeval3[$j] = str_replace($stringtypeval2[$j],'"'.$stringtypeval2[$j].'"',$stringtypeval2[$j]);
                foreach ($stringtypeval3 as $v){
                    $aaa[$j][] = $stringtypeval3[$j];
                    if(!$stringtypeval3[$j]){
                        unset($aaa[$j]);
                    }
                }
            }
            /*降维*/
            foreach ($aaa as $val){
                foreach ($val as $v){
                    $typeval[] = $v;
                }
            }
            /*去重复  重新排列*/
            $typeval = array_unique($typeval);
            $typeval = array_values($typeval);
            /*类型名称 json转数组 去字段 转字符串*/
            $typename_json =  I('atv_typename','','');
            $atvtypename = json_decode($typename_json,true);
            unset($atvtypename['length']);
            $atvtypename=implode(",",$atvtypename);
            /*价格 字符串转数组*/
            $atvprice = I('atv_price');
            $atvprice = rtrim($atvprice,",");
            $atvprice = explode(",",$atvprice);
            /*库存 字符串转数组*/
            $atvstock = I('atv_stock');
            $atvstock = rtrim($atvstock,",");
            $atvstock = explode(",",$atvstock);
            /*活动价 字符串转数组*/
            $atvactivityprice = I('atv_activityprice');
            $atvactivityprice = rtrim($atvactivityprice,",");
            $atvactivityprice = explode(",",$atvactivityprice);
            /*原价*/
            $atvoriginalprice = I('atv_originalprice');
            $atvoriginalprice = rtrim($atvoriginalprice,",");
            $atvoriginalprice = explode(",",$atvoriginalprice);
            /*产品ID*/
            $atvpid = $pid;
            /*添加时间*/
            $atvtime = date('Y-m-d H:i:s');
            /*上下架*/
            $atvstate = '1';
            /*属性值*/
            $atvavid = '0';
            /*APP图片*/
            $atvimg = I('atv_img');
            $atvimg = rtrim($atvimg,",");
            $atvimg = explode(',',$atvimg);
            /*PC图片*/
            $atvpcimg = I('atv_pcimg');
            $atvpcimg = rtrim($atvpcimg,",");
            $atvpcimg = explode(',',$atvpcimg);
            /*组装数据*/
            $valuearray = array();
            for($i=0;$i<$atvcount;$i++){
                $valuearray[] = array(
                    'atv_pid' =>$atvpid,
                    'atv_avid' =>$atvavid,
                    'atv_stock' =>$atvstock[$i],
                    'atv_price' =>$atvprice[$i],
                    'atv_img' =>$atvimg[$i],
                    'atv_activityprice' =>$atvactivityprice[$i],
                    'atv_time' =>$atvtime,
                    'atv_typename' =>$atvtypename,
                    'atv_typevalue' =>$typeval[$i],
                    'atv_originalprice' =>$atvoriginalprice[$i],
                    'atv_state' =>$atvstate,
                    'atv_pcimg' =>$atvpcimg[$i]
                );
            }
           $rs = $productattributevalue_model->addAll($valuearray);
            if(!$rs){
                /*事务回滚*/
                $model->rollback();
                $this->error("添加失败!","",1);
            }
            /*=============产品参数的添加=============*/
            $ppval = I('pp_val',null);
            if(!$ppval){
                $model->commit();
                $this->success("添加成功!","",1);
            }
            $ppval = rtrim($ppval,",");
            $ppval = explode(",",$ppval);
            $ppvals = [];
            foreach($ppval as $val){
                $ppvals[] =str_replace(":",",name:",$val);
            }
            $ppvals = array_map(create_function('$item', 'return "val:$item";'), $ppvals);
            $ppvals1 = [];
            foreach ($ppvals as $v){
                $ppvals1[] = explode(",",$v);
            }
            $ppvals = json_encode($ppvals1,JSON_UNESCAPED_UNICODE);
            $ppval =str_replace(":",'":"',$ppvals);
            $ppval = ltrim($ppval, "[");
            $ppval = rtrim($ppval,"]");
            $ppval =str_replace("[",'{',$ppval);
            $ppval =str_replace("]",'}',$ppval);
            $ppval = "[{".$ppval."}]";
            $productparameter_data = array(
                'pp_name'=>0,
                'pp_pid'=>$pid,
                'pp_val' =>$ppval,
            );
            $allrs = $productparameter_model->add($productparameter_data);
            if(!$allrs){
                /*事务回滚*/
                $model->rollback();
                $this->error("添加失败!","",1);
            }else{
                $model->commit();
                $this->success("添加成功!","",1);
            }
        }else{
            /*查询所有单位*/
            $company_model = M('company');
            $company_info = $company_model->select();
            $this->assign('company_info',$company_info);
            /*查询所有品牌*/
            $brand_model = M('brand');
            $brand_info = $brand_model->field('b_id,b_name')->select();
            $this->assign('brand_info',$brand_info);
            /*查询所有商家*/
            $userinfo_model = M('userinfo');
            $userinfo_find['u_type'] = '3';
            $userinfo_find['u_toexamine'] = '1';
            $userinfo_info = $userinfo_model->where($userinfo_find)->where($this->level_where)->field('u_id,u_shopname')->select();
            $this->assign('userinfo_info',$userinfo_info);

            /*分别查询深度为2与深度不为2的*/
            $cate=M('producttype');
            $data_find['pt_level'] = array('neq','2');
            $list1=$cate->field("pt_id,pt_receptionname,pt_superior,pt_relation,concat('0',',',pt_relation,',',pt_id) as bpath")->where($data_find)->order('bpath')->select();
            $data_find2['pt_level'] = array('eq','2');
            $list2=$cate->field("pt_id,pt_receptionname,pt_superior,pt_relation,concat(pt_relation,',',pt_id) as bpath")->where($data_find2)->order('bpath')->select();
            /*合并两次查询的数据*/
            $list = array_merge_recursive($list2,$list1);
            /*对数组按bpath排序*/
            $flag = [];
            foreach ($list as $v){
                $flag[] = $v['bpath'];
            }
            array_multisort($flag,SORT_ASC,$list);
            /*遍历*/
            foreach($list as $key=>$value){
                $list[$key]['count']=count(explode(',',$value['bpath']));
            };

            $this->assign('alist',$list);
            $this->display();
        }
    }

    /*产品-修改模板详情*/
    public function detail(){
        /*============获取产品的值=================*/

        /*查询所有商家*/
        $userinfo_model = M('userinfo');
        $userinfo_find['u_type'] = '3';
        $userinfo_find['u_toexamine'] = '1';
        $userinfo_info = $userinfo_model->where($userinfo_find)->where($this->level_where)->field('u_id,u_shopname')->select();
        $this->assign('userinfo_info',$userinfo_info);

        /*分别查询深度为2与深度不为2的*/
        $cate=M('producttype');
        $data_find['pt_level'] = array('neq','2');
        $list1=$cate->field("pt_id,pt_receptionname,pt_superior,pt_relation,concat('0',',',pt_relation,',',pt_id) as bpath")->where($data_find)->order('bpath')->select();
        $data_find2['pt_level'] = array('eq','2');
        $list2=$cate->field("pt_id,pt_receptionname,pt_superior,pt_relation,concat(pt_relation,',',pt_id) as bpath")->where($data_find2)->order('bpath')->select();
        /*合并两次查询的数据*/
        $list = array_merge_recursive($list2,$list1);
        /*对数组按bpath排序*/
        $flag = [];
        foreach ($list as $v){
            $flag[] = $v['bpath'];
        }
        array_multisort($flag,SORT_ASC,$list);

        /*遍历*/
        foreach($list as $key=>$value){
            $list[$key]['count']=count(explode(',',$value['bpath']));
        };
        $this->assign('alist',$list);
        /*查询当前的值*/
        $product_model = D('product');
        $product_find['p_id'] = I('p_id');
        $product_info = $product_model->where($product_find)->find();
        $this->assign('info',$product_info);
        /*查询所有单位*/
        $company_model = M('company');
        $where['c_uid'] = $product_info['p_uid'];
        $company_info = $company_model->where($where)->select();
        $this->assign('company_info',$company_info);
        /*查询所有品牌*/
        $brand_model = M('brand');
        $where1['b_uid'] = $product_info['p_uid'];
        $brand_info = $brand_model->field('b_id,b_name')->where($where1)->select();
        $this->assign('brand_info',$brand_info);
        /*查询当前的APP图片集合*/
        $img_info = $product_model->where($product_find)->getField('p_imglist');
        $img_info = explode(',',$img_info);
        foreach ($img_info as $key=>$value)
        {
            if ($value == '/Public/img/trash.png')
                unset($img_info[$key]);
        }
        $img_info = array_merge($img_info);
        $this->assign('imgs',$img_info);
        /*查询当前的PC图片集合*/
        $pcimg_info = $product_model->where($product_find)->getField('p_pcimglist');
        $pcimg_info = explode(',',$pcimg_info);
        foreach ($pcimg_info as $key=>$value)
        {
            if ($value == '/Public/img/trash.png')
                unset($pcimg_info[$key]);
        }
        $pcimg_info = array_merge($pcimg_info);
        $this->assign('pcimgs',$pcimg_info);
        /*查询关键字*/
        $searchkeyword_info = $product_model->where($product_find)->getField('p_searchkeyword');
        $searchkeyword_info = explode(' ',$searchkeyword_info);
        $this->assign('searchkeyword_info',$searchkeyword_info);
        /*============获取产品属性的值=================*/
        $productattributevalue_model = M('productattributevalue');
        $pid = I('p_id');
        $productattributevalue_find['atv_pid'] = $pid;
        /*查询类型名称*/
        $typename_info = $productattributevalue_model->field('atv_typename')->where($productattributevalue_find)->select();
        foreach($typename_info as $k=>$v){
            unset($v['row_number']);
            foreach($v as $key=>$nameval){
                $nameval;
            }
        }
        /*字符串转数组*/
        $nameval = explode(",",$nameval);
       $this->assign('typenameinfo',$nameval);
        /**获取产品属性-修改模板的值**/
        $productattributevalue_info = $productattributevalue_model->where($productattributevalue_find)->select();
        /*取出集合中的类型值*/
        foreach ($productattributevalue_info as $v){
            $asd[] = $v['atv_typevalue'];
        }
        /*json转数组*/
        $atv_typevalue =array();
        foreach ($asd as $val){
            $atv_typevalue[] = json_decode("{".$val."}",true);
        }
        /*组成新数组-模板显示*/
        $a = array();
        foreach($productattributevalue_info as $k=>$v){
            $a[$k][] = $v;
            $a[$k][] = $atv_typevalue[$k];
        }
        $this->assign('productattributevalueinfo',$a);
        /*============获取产品参数的值=================*/
        $productparameter_model = M('productparameter');
        $productparameter_find['pp_pid'] = $pid;
        $productparameter_info = $productparameter_model->where($productparameter_find)->select();

        /*取出集合中的类型值*/
        foreach ($productparameter_info as $v){
            $asd1[] = $v['pp_val'];
        }
        $asd1 = implode("",$asd1);
        /*json转数组*/
        $pp_val = json_decode($asd1,true);

        $this->assign('ppval',$pp_val);
        $this->display('modify');
    }
    /*产品-修改执行*/
    public function modify(){
            $atv_typename = I('atv_typename');
          if($atv_typename == null){
              /*====================产品属性---修改处理==========================*/
                            /*模型==产品==产品属性==产品参数*/
            $product_model = D('product');
            $productattributevalue_model = M('productattributevalue');
            $productparameter_model = M('productparameter');
            /*开始事务处理*/
            $model = M();
            $model->startTrans();
            /*=============产品的修改=============*/
            /*模型创建及数据验证*/
            $data = $product_model->create();
            if(!$data){
                $this->error($product_model->getError(),'',1);
            }
            $product_find['p_id'] = I('p_id');
            unset($data['p_id']);
            $data['p_activityendtime']=date('Y-m-d H:i:s', strtotime(I('p_activityendtime')) + 24 * 60 * 60);
            if($data['p_isactivity'] == '0'){
                $data['p_activityname'] = "";
                $data['p_activitystartime']  = '2017-01-01 00:00:00';
                $data['p_activityendtime']  = '2017-01-01 00:00:00';
            }
              $data['p_content'] = I('p_content','','');
              $data['p_searchkeyword'] = rtrim(I('p_searchkeyword'));
            /*执行修改*/
            $pid = $product_model->where($product_find)->save($data);
            if(!$pid){
                /*事务回滚*/
                $model->rollback();
                $this->error("修改失败","",1);
            }
            /*=============产品属性的修改=============*/
              /*价格 字符串转数组*/
              $atvprice = I('atv_price');
              $atvprice = rtrim($atvprice,",");
              $atvprice = explode(",",$atvprice);
              /*库存 字符串转数组*/
              $atvstock = I('atv_stock');
              $atvstock = rtrim($atvstock,",");
              $atvstock = explode(",",$atvstock);
              /*活动价 字符串转数组*/
              $atvactivityprice = I('atv_activityprice');
              $atvactivityprice = rtrim($atvactivityprice,",");
              $atvactivityprice = explode(",",$atvactivityprice);
              /*原价*/
              $atvoriginalprice = I('atv_originalprice');
              $atvoriginalprice = rtrim($atvoriginalprice,",");
              $atvoriginalprice = explode(",",$atvoriginalprice);
              /*APP图片*/
              $atvimg = I('atv_img');
              $atvimg = rtrim($atvimg,",");
              $atvimg = explode(',',$atvimg);
              /*PC图片*/
              $atvpcimg = I('atv_pcimg');
              $atvpcimg = rtrim($atvpcimg,",");
              $atvpcimg = explode(',',$atvpcimg);
            /*查询当前产品属性值的条数*/
              $atvcount_find['atv_pid']=I('p_id');
              $atvcount = $productattributevalue_model->where($atvcount_find)->count();
              $atvpid_val = $productattributevalue_model->field('atv_id')->where($atvcount_find)->select();
              $ativid_ids = array();
              foreach ($atvpid_val as $v){
                  unset($v['row_number']);
                  foreach ($v as $val){
                      $ativid_ids['atv_id'][] = $val;
                  }
              }
              /*组装数据*/
            $valuearray = array();
            for($i=0;$i<$atvcount;$i++){
                $valuearray[] = array(
                    'atv_stock' =>$atvstock[$i],
                    'atv_price' =>$atvprice[$i],
                    'atv_img' =>$atvimg[$i],
                    'atv_pcimg' =>$atvpcimg[$i],
                    'atv_activityprice' =>$atvactivityprice[$i],
                    'atv_originalprice' =>$atvoriginalprice[$i],
                );
            }
            $rs = save_all($ativid_ids,$valuearray,'productattributevalue');
            if(!$rs){
                /*事务回滚*/
                $model->rollback();
                $this->error("修改失败!","",1);
            }
            /*=============产品参数的修改=============*/
              $ppval = I('pp_val',null);
              if(!$ppval){
                  $model->commit();
                  $this->success("修改成功!","",1);
              }
              $ppval = rtrim($ppval,",");
              $ppval = explode(",",$ppval);
              $ppvals = [];
              foreach($ppval as $val){
                  $ppvals[] =str_replace(":",",name:",$val);
              }
              $ppvals = array_map(create_function('$item', 'return "val:$item";'), $ppvals);
              $ppvals1 = [];
              foreach ($ppvals as $v){
                  $ppvals1[] = explode(",",$v);
              }
              $ppvals = json_encode($ppvals1,JSON_UNESCAPED_UNICODE);
              $ppval =str_replace(":",'":"',$ppvals);
              $ppval = ltrim($ppval, "[");
              $ppval = rtrim($ppval,"]");
              $ppval =str_replace("[",'{',$ppval);
              $ppval =str_replace("]",'}',$ppval);
              $ppval = "[{".$ppval."}]";
            $productparameter_data = array(
                'pp_val' =>$ppval,
            );
            $productparameter_find1['pp_pid'] = I('p_id');
            $allrs = $productparameter_model->where($productparameter_find1)->save($productparameter_data);
            if(!$allrs){
                /*事务回滚*/
                $model->rollback();
                $this->error("修改失败!","",1);
            }else{
                $model->commit();
                $this->success("修改成功!","",1);
            }
          }else{
              /*====================产品属性---新添加处理==========================*/
                            /*模型==产品==产品属性==产品参数*/
            $product_model = D('product');
            $productattributevalue_model = M('productattributevalue');
            $productparameter_model = M('productparameter');
            /*开始事务处理*/
            $model = M();
            $model->startTrans();
              /*=============产品的修改=============*/
              /*模型创建及数据验证*/
              $data = $product_model->create();
              if(!$data){
                  $this->error($product_model->getError(),'',1);
              }
              $product_find['p_id'] = I('p_id');
              unset($data['p_id']);
              $data['p_activityendtime']=date('Y-m-d H:i:s', strtotime(I('p_activityendtime')) + 24 * 60 * 60);
              if($data['p_isactivity'] == '0'){
                  $data['p_activityname'] = "";
                  $data['p_activitystartime']  = '1970-01-01 00:00:00';
                  $data['p_activityendtime']  = '1970-01-01 00:00:00';
              }
              $data['p_content'] = I('p_content','','');
              $data['p_searchkeyword'] = rtrim(I('p_searchkeyword'));
              /*执行修改*/
              $pid = $product_model->where($product_find)->save($data);
              if(!$pid){
                  /*事务回滚*/
                  $model->rollback();
                  $this->error("修改失败","",1);
              }
            /*=============产品属性的添加=============*/
            /*类型值 json转数组 */
            $typevalue_json = I('atv_typevalue','','');
            $atvtypevalue = json_decode($typevalue_json,true);
            /*获取数据的总条数*/
            $atvcount = $atvtypevalue['length'];
            unset($atvtypevalue['length']);
            $aaa = array();
            $typeval = array();
            for($j=0;$j<=$atvcount;$j++){
                $stringtypeval[$j] = implode(",",$atvtypevalue[$j]);
                $stringtypeval1[$j] = str_replace(":",'":"',$stringtypeval[$j]);
                $stringtypeval2[$j] = str_replace(",",'","',$stringtypeval1[$j]);
                $stringtypeval3[$j] = str_replace($stringtypeval2[$j],'"'.$stringtypeval2[$j].'"',$stringtypeval2[$j]);
                foreach ($stringtypeval3 as $v){
                    $aaa[$j][] = $stringtypeval3[$j];
                    if(!$stringtypeval3[$j]){
                        unset($aaa[$j]);
                    }
                }
            }
            /*降维*/
            foreach ($aaa as $val){
                foreach ($val as $v){
                    $typeval[] = $v;
                }
            }
            /*去重复  重新排列*/
            $typeval = array_unique($typeval);
            $typeval = array_values($typeval);
            /*类型名称 json转数组 去字段 转字符串*/
            $typename_json =  I('atv_typename','','');
            $atvtypename = json_decode($typename_json,true);
            unset($atvtypename['length']);
            $atvtypename=implode(",",$atvtypename);
              /*价格 字符串转数组*/
              $atvprice = I('atv_price');
              $atvprice = rtrim($atvprice,",");
              $atvprice = explode(",",$atvprice);
              /*库存 字符串转数组*/
              $atvstock = I('atv_stock');
              $atvstock = rtrim($atvstock,",");
              $atvstock = explode(",",$atvstock);
              /*活动价 字符串转数组*/
              $atvactivityprice = I('atv_activityprice');
              $atvactivityprice = rtrim($atvactivityprice,",");
              $atvactivityprice = explode(",",$atvactivityprice);
              /*原价*/
              $atvoriginalprice = I('atv_originalprice');
              $atvoriginalprice = rtrim($atvoriginalprice,",");
              $atvoriginalprice = explode(",",$atvoriginalprice);
              /*APP图片*/
              $atvimg = I('atv_img');
              $atvimg = rtrim($atvimg,",");
              $atvimg = explode(',',$atvimg);
              /*PC图片*/
              $atvpcimg = I('atv_pcimg');
              $atvpcimg = rtrim($atvpcimg,",");
              $atvpcimg = explode(',',$atvpcimg);
            /*添加时间*/
            $atvtime = date('Y-m-d H:i:s');
            /*上下架*/
            $atvstate = '1';
            /*属性值*/
            $atvavid = '0';
            /*组装数据*/
            $valuearray = array();
            for($i=0;$i<$atvcount;$i++){
                $valuearray[] = array(
                    'atv_pid' =>I('p_id'),
                    'atv_avid' =>$atvavid,
                    'atv_stock' =>$atvstock[$i],
                    'atv_price' =>$atvprice[$i],
                    'atv_img' =>$atvimg[$i],
                    'atv_pcimg' =>$atvpcimg[$i],
                    'atv_activityprice' =>$atvactivityprice[$i],
                    'atv_time' =>$atvtime,
                    'atv_typename' =>$atvtypename,
                    'atv_typevalue' =>$typeval[$i],
                    'atv_originalprice' =>$atvoriginalprice[$i],
                    'atv_state' =>$atvstate
                );
            }
            $rs = $productattributevalue_model->addAll($valuearray);
            if(!$rs){
                /*事务回滚*/
                $model->rollback();
                $this->error("添加失败!","",1);
            }
              /*=============产品参数的修改=============*/
              $ppval = I('pp_val',null);
              if(!$ppval){
                  $model->commit();
                  $this->success("添加成功!","",1);
              }
              $ppval = rtrim($ppval,",");
              $ppval = explode(",",$ppval);
              $ppvals = [];
              foreach($ppval as $val){
                  $ppvals[] =str_replace(":",",name:",$val);
              }
              $ppvals = array_map(create_function('$item', 'return "val:$item";'), $ppvals);
              $ppvals1 = [];
              foreach ($ppvals as $v){
                  $ppvals1[] = explode(",",$v);
              }
              $ppvals = json_encode($ppvals1,JSON_UNESCAPED_UNICODE);
              $ppval =str_replace(":",'":"',$ppvals);
              $ppval = ltrim($ppval, "[");
              $ppval = rtrim($ppval,"]");
              $ppval =str_replace("[",'{',$ppval);
              $ppval =str_replace("]",'}',$ppval);
              $ppval = "[{".$ppval."}]";
              $productparameter_data = array(
                  'pp_val' =>$ppval,
              );
              $productparameter_find1['pp_pid'] = I('p_id');
              $allrs = $productparameter_model->where($productparameter_find1)->save($productparameter_data);
              if(!$allrs){
                  /*事务回滚*/
                  $model->rollback();
                  $this->error("修改失败!","",1);
              }else{
                  $model->commit();
                  $this->success("修改成功!","",1);
              }
          }
    }

    /*产品审核历史*/
    public function index(){
        $product_model = D('ProductView');
        /* 查询条件 */
        $where = array();
        /* 产品名称*/
        $pname = trim(I('p_name'));
        if($pname){
            $where['p_name'] = array('LIKE','%'.$pname.'%');
            $this->assign('pname',$pname);
        }
        /* 商家*/
        $uidname = I('uid_name');
        if($uidname){
            $where['uid_name'] = array('LIKE','%'.$uidname.'%');
            $this->assign('uidname',$uidname);
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

        $where['p_del'] = 0;
        /* 每页显示条数 */
        $num =  20;
        /* 页码 */
        $p = $_GET['p'] ? $_GET['p'] : 1;

        /* 获取分页列表  */
        $product_info = $product_model
            ->where($where)
            ->where($level_wheres)
            ->page($p . ',' . $num)
            ->order('thinkphp.p_id desc')
            ->select();

        /* 获取分页条 */
        $count = $product_model->where($where)->where($level_wheres)->count();
        $page_model = new \Think\Page($count, $num);
        $page_bar = $page_model->show();

        /*分页查询数据*/
        $this->assign('product_info',$product_info);
        $this->assign('page_bar', $page_bar);
        $this->assign('count',$count);
        $this->display('index');
    }

    /*进行审核*/
    public function modifystate(){
        if(IS_POST){
           $product_model = M('product');
           $data = I('post.');
           $where['p_id'] = I('p_id');
            unset($data['p_id']);
            $rs = $product_model->where($where)->save($data);
            if($rs){
                $this->success('审核成功','',1);
            }else{
                $this->error('审核失败','',1);
            }
        }else{
            /*============获取产品的值=================*/
            /*查询所有单位*/
            $company_model = M('company');
            $company_info = $company_model->select();
            $this->assign('company_info',$company_info);
            /*查询所有品牌*/
            $brand_model = M('brand');
            $brand_info = $brand_model->field('b_id,b_name')->select();
            $this->assign('brand_info',$brand_info);
            /*查询所有商家*/
            $userinfo_model = M('userinfo');
            $userinfo_find['u_type'] = '3';
            $userinfo_info = $userinfo_model->where($userinfo_find)->field('u_id,u_shopname')->select();
            $this->assign('userinfo_info',$userinfo_info);

            /*分别查询深度为2与深度不为2的*/
            $cate=M('producttype');
            $data_find['pt_level'] = array('neq','2');
            $list1=$cate->field("pt_id,pt_receptionname,pt_superior,pt_relation,concat('0',',',pt_relation,',',pt_id) as bpath")->where($data_find)->order('bpath')->select();
            $data_find2['pt_level'] = array('eq','2');
            $list2=$cate->field("pt_id,pt_receptionname,pt_superior,pt_relation,concat(pt_relation,',',pt_id) as bpath")->where($data_find2)->order('bpath')->select();
            /*合并两次查询的数据*/
            $list = array_merge_recursive($list2,$list1);
            /*对数组按bpath排序*/
            $flag = [];
            foreach ($list as $v){
                $flag[] = $v['bpath'];
            }
            array_multisort($flag,SORT_ASC,$list);

            /*遍历*/
            foreach($list as $key=>$value){
                $list[$key]['count']=count(explode(',',$value['bpath']));
            };
            $this->assign('alist',$list);
            /*查询当前的值*/
            $product_model = D('product');
            $product_find['p_id'] = I('p_id');
            $product_info = $product_model->where($product_find)->find();
            $this->assign('info',$product_info);
            /*查询当前的APP图片集合*/
            $img_info = $product_model->where($product_find)->getField('p_imglist');
            $img_info = explode(',',$img_info);
            foreach ($img_info as $key=>$value)
            {
                if ($value == '/Public/img/trash.png')
                    unset($img_info[$key]);
            }
            $img_info = array_merge($img_info);
            $this->assign('imgs',$img_info);
            /*查询当前的PC图片集合*/
            $pcimg_info = $product_model->where($product_find)->getField('p_pcimglist');
            $pcimg_info = explode(',',$pcimg_info);
            foreach ($pcimg_info as $key=>$value)
            {
                if ($value == '/Public/img/trash.png')
                    unset($pcimg_info[$key]);
            }
            $pcimg_info = array_merge($pcimg_info);
            $this->assign('pcimgs',$pcimg_info);
            /*查询关键字*/
            $searchkeyword_info = $product_model->where($product_find)->getField('p_searchkeyword');
            $searchkeyword_info = explode(' ',$searchkeyword_info);
            $this->assign('searchkeyword_info',$searchkeyword_info);
            /*============获取产品属性的值=================*/
            $productattributevalue_model = M('productattributevalue');
            $pid = I('p_id');
            $productattributevalue_find['atv_pid'] = $pid;
            /*查询类型名称*/
            $typename_info = $productattributevalue_model->field('atv_typename')->where($productattributevalue_find)->select();
            foreach($typename_info as $k=>$v){
                unset($v['row_number']);
                foreach($v as $key=>$nameval){
                    $nameval;
                }
            }
            /*字符串转数组*/
            $nameval = explode(",",$nameval);
            $this->assign('typenameinfo',$nameval);
            /**获取产品属性-修改模板的值**/
            $productattributevalue_info = $productattributevalue_model->where($productattributevalue_find)->select();
            /*取出集合中的类型值*/
            foreach ($productattributevalue_info as $v){
                $asd[] = $v['atv_typevalue'];
            }
            /*json转数组*/
            $atv_typevalue =array();
            foreach ($asd as $val){
                $atv_typevalue[] = json_decode("{".$val."}",true);
            }
            /*组成新数组-模板显示*/
            $a = array();
            foreach($productattributevalue_info as $k=>$v){
                $a[$k][] = $v;
                $a[$k][] = $atv_typevalue[$k];
            }
            $this->assign('productattributevalueinfo',$a);
            /*============获取产品参数的值=================*/
            $productparameter_model = M('productparameter');
            $productparameter_find['pp_pid'] = $pid;
            $productparameter_info = $productparameter_model->where($productparameter_find)->select();

            /*取出集合中的类型值*/
            foreach ($productparameter_info as $v){
                $asd1[] = $v['pp_val'];
            }
            $asd1 = implode("",$asd1);
            /*json转数组*/
            $pp_val = json_decode($asd1,true);

            $this->assign('ppval',$pp_val);
            $this->display();
        }
    }

}