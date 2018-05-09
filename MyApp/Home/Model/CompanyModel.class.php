<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-07-12
 * Time: 10:19
 */

namespace Home\Model;

use Think\Model;

class CompanyModel extends Model
{
    protected $_validate = array(
        array('c_name','require','单位名称不能为空')
    );

    protected $_auto = array (
        array('c_name','trim',3,'function')
    );
}