<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-07-07
 * Time: 11:18
 */

namespace Home\Model;

use Think\Model\ViewModel;

class ConstructionViewModel extends ViewModel
{
    public $viewFields = array(
        'construction'=>array('*','(select u_nickname from userinfo where userinfo.u_id=construction.c_uid)'=>'cuid_name','_type'=>'LEFT'),
        'userinfo'=>array('u_nickname'=>'uid_name', '_on'=>'construction.c_userid = userinfo.u_id','_type'=>'LEFT'),
        'brand'=>array('b_name'=>'bid_name', '_on'=>'construction.c_bid = brand.b_id','_type'=>'LEFT'),
        'pay'=>array('p_shoukuantime'=>'pshoukuantime','p_weikuantime'=>'pweikuantime','_on'=>'construction.c_onlyid = pay.p_onlyid','_type'=>'LEFT'),
        'servicedemand'=>array('sd_weixiuname'=>'sdid_name', '_on'=>'construction.c_sdid = servicedemand.sd_id','_type'=>'LEFT'),
        'repairdetails'=>array('rd_name'=>'did_name', '_on'=>'construction.c_did = repairdetails.rd_id'),
    );
}