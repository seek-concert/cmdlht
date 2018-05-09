<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-06-05
 * Time: 16:49
 */

namespace Home\Model;

use Think\Model;

class BrandModel extends Model
{
    protected $_validate = array(
        array('b_uid','require','商家不能为空'),
        array('b_name','require','名称不能为空'),
        array('b_img','require','品牌图片不能为空',1),
        array('b_order','require','排序不能为空')
    );

    protected $_auto = array (
        array('b_name','trim',3,'function')
    );
}