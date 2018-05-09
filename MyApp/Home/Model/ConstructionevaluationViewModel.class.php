<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-07-06
 * Time: 15:42
 */

namespace Home\Model;

use Think\Model\ViewModel;

class ConstructionevaluationViewModel extends ViewModel
{
    public $viewFields = array(
        'Constructionevaluation'=>array('*','(select u_nickname from userinfo where userinfo.u_id=constructionevaluation.ce_uid)'=>'uid_name','_type'=>'LEFT'),
        'Userinfo'=>array('u_nickname'=>'cuid_name', '_on'=>'Constructionevaluation.ce_cuid = Userinfo.u_id')
    );
}