<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-07-12
 * Time: 09:10
 */

namespace Home\Model;


use Think\Model\ViewModel;

class ReviewedhistoryViewModel extends ViewModel
{
    public $viewFields = array(
        'reviewedhistory'=>array('*','_type'=>'LEFT'),
        'userinfo'=>array('u_nickname'=>'uid_name','u_sheng'=>'uid_sheng','u_shi'=>'uid_shi','u_xian'=>'uid_xian', '_on'=>'reviewedhistory.th_uid = userinfo.u_id')
    );
}