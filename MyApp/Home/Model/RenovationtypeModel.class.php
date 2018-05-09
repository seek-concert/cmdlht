<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-05-23
 * Time: 11:48
 */

namespace Home\Model;


use Think\Model;

class RenovationtypeModel extends Model
{
    /*自动验证字段必须填写*/
    protected $_validate = array(
        array('rt_name','require','装修类型名称必须填写！'),
        array('rt_name','','装修类型名称已经存在！',0,'unique',1),
        array('rt_order','require','排序必须填写！'),
    );
    protected $_auto = array (
        array('rt_name','trim',3,'function'),
    );
}