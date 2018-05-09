<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-07-05
 * Time: 16:53
 */

namespace Home\Model;

use Think\Model\ViewModel;

class ServicedemandViewModel extends ViewModel
{
    public $viewFields = array(
        'Servicedemand'=>array('*','(select u_realname from userinfo where servicedemand.sd_pguid = userinfo.u_id)'=>'uidname','_type'=>'LEFT'),
        'Repairdetails'=>array('rd_name'=>'rdid_name', '_on'=>'Servicedemand.sd_rdid = Repairdetails.rd_id','_type'=>'LEFT'),
        'Userinfo'=>array('u_nickname'=>'uid_name', '_on'=>'Servicedemand.sd_uid = Userinfo.u_id','_type'=>'LEFT'),
        'Brand'=>array('b_name'=>'bid_name', '_on'=>'Servicedemand.sd_bid = Brand.b_id','_type'=>'LEFT'),
        'constructiontype'=>array('ct_name'=>'type_name', '_on'=>'Servicedemand.sd_type = constructiontype.ct_id','_type'=>'LEFT'),
        'construction'=>array('c_uid'=>'cuid', '_on'=>'Servicedemand.sd_id = construction.c_sdid')
    );
}