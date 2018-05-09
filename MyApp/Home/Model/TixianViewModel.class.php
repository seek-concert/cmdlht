<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-07-13
 * Time: 09:37
 */

namespace Home\Model;

use Think\Model\ViewModel;

class TixianViewModel extends ViewModel
{
    public $viewFields = array(
        'tixian'=>array('*','_type'=>'LEFT'),
        'userinfo'=>array('u_nickname'=>'uid_name','u_type'=>'ttype','u_phone'=>'tphone','u_realname'=>'trealname', '_on'=>'tixian.t_uid = userinfo.u_id')
    );
}