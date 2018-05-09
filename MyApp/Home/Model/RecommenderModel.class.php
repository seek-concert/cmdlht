<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-07-21
 * Time: 19:59
 */
namespace Home\Model;
use Think\Model;

class RecommenderModel extends Model
{
    protected $_validate = array(
        array('r_title','require','标题不能为空'),
        array('r_futitle','require','副标题不能为空'),
        array('r_biaoyu','require','推广标语不能为空'),
        array('r_int','require','排序不能为空')
    );

    protected $_auto = array (
        array('r_title','trim',3,'function'),
    );
}