<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-06-26
 * Time: 16:02
 */

namespace Home\Model;

use Think\Model\ViewModel;

class ProductorderViewModel extends ViewModel
{
    public $viewFields = array(
        'Productorder'=>array('*','(select u_nickname from Userinfo where Userinfo.u_id=Productorder.pd_uid)'=>'uid_name','_type'=>'LEFT'),
        'Userinfo'=>array('u_shopname'=>'fuid_name','u_realname'=>'frealname','u_phone'=>'fphone','_on'=>'Productorder.pd_fuid = Userinfo.u_id','_type'=>'LEFT'),
        'orderdetails'=>array('od_state'=>'pdstate', '_on'=>'Productorder.pd_onlyid = orderdetails.od_onlyid')
    );
}