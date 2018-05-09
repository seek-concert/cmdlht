<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-06-12
 * Time: 14:35
 */

namespace Home\Model;

use Think\Model;

class ProductModel extends Model
{
    protected $_validate = array(
        array('p_name','require','产品名称不能为空'),
        array('p_uid','require','商家不能为空'),
        array('p_content','require','描述不能为空'),
        array('p_type','require','产品类型不能为空'),
        array('p_sellingpoint','require','卖点不能为空'),
        array('p_searchkeyword','require','关键字不能为空'),
    );

    protected $_auto = array (
        array('p_name','trim',3,'function'),
    );
}