<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-07-11
 * Time: 11:24
 */
namespace Home\Model;

use Think\Model;

class UseraddressModel extends Model
{
    protected $_validate = array(
        array('ua_province','require','省市不能为空'),
        array('ua_city','require','省市不能为空'),
        array('ua_county','require','区县不能为空'),
        array('ua_address','require','地址不能为空'),
        array('ua_phone','require','电话不能为空'),
        array('ua_name','require','收货人不能为空')
    );
}