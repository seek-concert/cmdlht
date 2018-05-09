<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-07-11
 * Time: 16:55
 */

namespace Home\Model;
use Think\Model\ViewModel;

class FeedbackViewModel extends  ViewModel
{
    public $viewFields = array(
        'feedback'=>array('*','_type'=>'LEFT'),
        'userinfo'=>array('u_nickname'=>'uid_name', '_on'=>'feedback.fb_uid = userinfo.u_id'),
    );
}