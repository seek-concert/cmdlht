<?php
namespace Home\Model;
use Think\Model\ViewModel;

class DingdanViewModel extends ViewModel
{
    public $viewFields = array(
        'dingyueliucheng'=>array('*','_type'=>'LEFT'),
        'productorder'=>array('pd_fuid'=>'pdfuid','pd_onlyid'=>'pdonlyid', '_on'=>'dingyueliucheng.lc_pid = productorder.pd_id')
    );
}