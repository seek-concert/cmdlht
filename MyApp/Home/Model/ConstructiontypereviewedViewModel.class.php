<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-07-06
 * Time: 11:16
 */

namespace Home\Model;

use Think\Model\ViewModel;

class ConstructiontypereviewedViewModel extends ViewModel
{
    public $viewFields = array(
        'Constructiontypereviewed'=>array('*','_type'=>'LEFT'),
        'Userinfo'=>array('u_nickname'=>'uid_name', '_on'=>'Constructiontypereviewed.ctr_uid = Userinfo.u_id','_type'=>'LEFT'),
        'Constructiontype'=>array('ct_name'=>'ctid_name', '_on'=>'Constructiontypereviewed.ctr_ctid = Constructiontype.ct_id')
    );
}