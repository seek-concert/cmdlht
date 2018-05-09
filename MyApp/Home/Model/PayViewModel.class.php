<?php
namespace Home\Model;
use Think\Model\ViewModel;

class PayViewModel extends ViewModel
{
    public $viewFields = array(
        'pay'=>array('*','(select u_nickname from userinfo where pay.p_uid = userinfo.u_id)'=>'uid_name','_type'=>'LEFT'),
        'userinfo'=>array('u_bankcard'=>'ubankcard','u_bankname'=>'ubankname','u_phone'=>'uphone','u_realname'=>'urealname','u_shopname'=>'uidname','_on'=>'pay.p_fuid = userinfo.u_id','_type'=>'LEFT'),
        'productorder'=>array('pd_money'=>'pdmoney', '_on'=>'pay.p_ddid = productorder.pd_id')
    );
}