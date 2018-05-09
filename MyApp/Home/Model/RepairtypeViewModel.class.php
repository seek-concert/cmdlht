<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-07-21
 * Time: 09:19
 */
namespace Home\Model;
use Think\Model\ViewModel;

class RepairtypeViewModel extends ViewModel
{
    public $viewFields = array(
        'repairtype'=>array('*','_type'=>'LEFT'),
        'brand'=>array('b_name'=>'bid_name', '_on'=>'repairtype.rt_bid = brand.b_id'),
    );
}