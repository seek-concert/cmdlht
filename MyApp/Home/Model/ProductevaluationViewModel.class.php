<?php
namespace Home\Model;
use Think\Model\ViewModel;

class ProductevaluationViewModel extends ViewModel
{
    public $viewFields = array(
        'productevaluation'=>array('*','_type'=>'LEFT'),
        'userinfo'=>array('u_nickname'=>'uid_name', '_on'=>'productevaluation.pe_uid = userinfo.u_id')
    );
}