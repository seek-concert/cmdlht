<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-06-29
 * Time: 14:36
 */

namespace Home\Model;

use Think\Model\ViewModel;

class RepairattributeViewModel extends ViewModel
{
    public $viewFields = array(
        'Repairattribute'=>array('*','_type'=>'LEFT'),
        'Repairtype'=>array('rt_receptionname'=>'atid_name', '_on'=>'Repairtype.rt_id = Repairattribute.rt_atid'),
    );
}