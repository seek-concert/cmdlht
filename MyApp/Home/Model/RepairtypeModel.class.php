<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-06-29
 * Time: 14:37
 */

namespace Home\Model;

use Think\Model;

class RepairtypeModel extends Model
{
    protected $_validate = array(
        array('rt_receptionname','require','展示名称不能为空')
    );

    protected $_auto = array (
        array('rt_receptionname','trim',3,'function')
    );
}