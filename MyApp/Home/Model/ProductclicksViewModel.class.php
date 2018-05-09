<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-07-11
 * Time: 17:48
 */

namespace Home\Model;


use Think\Model\ViewModel;

class ProductclicksViewModel extends ViewModel
{
    public $viewFields = array(
        'productclicks'=>array('*','_type'=>'LEFT'),
        'product'=>array('p_name'=>'pid_name', '_on'=>'productclicks.pt_pid = product.p_id','_type'=>'LEFT'),
        'userinfo'=>array('u_nickname'=>'uid_name', '_on'=>'productclicks.pt_uid = userinfo.u_id')
    );
}