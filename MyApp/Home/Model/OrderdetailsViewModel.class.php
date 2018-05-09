<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-06-27
 * Time: 09:19
 */

namespace Home\Model;

use Think\Model\ViewModel;

class OrderdetailsViewModel extends ViewModel
{
    public $viewFields = array(
        'Orderdetails'=>array('*','_type'=>'LEFT'),
        'Product'=>array('p_name'=>'pid_name', '_on'=>'Orderdetails.od_pid = Product.p_id','_type'=>'LEFT'),
        'pay'=>array('p_id'=>'pid', '_on'=>'Orderdetails.od_onlyid = pay.p_onlyid')
    );
}