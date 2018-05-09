<?php
namespace Home\Model;

use Think\Model\ViewModel;

class ProductViewModel extends ViewModel
{
    public $viewFields = array(
        'Product'=>array('*','_type'=>'LEFT'),
        'Brand'=>array('b_name'=>'bid_name', '_on'=>'Product.p_bid = Brand.b_id','_type'=>'LEFT'),
        'Userinfo'=>array('u_shopname'=>'uid_name','u_sheng'=>'uid_sheng','u_shi'=>'uid_shi','u_xian'=>'uid_xian', '_on'=>'Product.p_uid = Userinfo.u_id','_type'=>'LEFT'),
        'Company'=>array('c_name'=>'cid_name', '_on'=>'Product.p_cid = Company.c_id'),
    );
}