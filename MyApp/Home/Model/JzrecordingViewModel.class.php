<?php
namespace Home\Model;
use Think\Model\ViewModel;

class JzrecordingViewModel extends ViewModel
{
    public $viewFields = array(
        'jzrecording'=>array('*','_type'=>'LEFT'),
        'userinfo'=>array('u_nickname'=>'nickname','u_shopname'=>'shopname', '_on'=>'jzrecording.jz_uid = userinfo.u_id'),
    );
}