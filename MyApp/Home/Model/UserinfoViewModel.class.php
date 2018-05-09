<?php
namespace Home\Model;
use Think\Model\ViewModel;

class UserinfoViewModel extends ViewModel
{
    public $viewFields = array(
        'userinfo'=>array('*','_type'=>'LEFT'),
        'recommender'=>array('r_logo'=>'rlogo', '_on'=>'userinfo.u_id = recommender.r_uid')
    );
}