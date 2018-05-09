<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-07-13
 * Time: 09:06
 */

namespace Home\Model;

use Think\Model\ViewModel;

class NoticeViewModel extends ViewModel
{
    public $viewFields = array(
        'notice'=>array('*','_type'=>'LEFT'),
        'userinfo'=>array('u_nickname'=>'uid_name', '_on'=>'notice.n_uid = userinfo.u_id')
    );
}