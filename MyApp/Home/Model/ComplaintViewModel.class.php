<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-07-11
 * Time: 15:27
 */

namespace Home\Model;


use Think\Model\ViewModel;

class ComplaintViewModel extends ViewModel
{
    public $viewFields = array(
        'complaint'=>array('*','_type'=>'LEFT'),
        'userinfo'=>array('u_nickname'=>'uid_name', '_on'=>'complaint.c_uid = userinfo.u_id'),
    );
}