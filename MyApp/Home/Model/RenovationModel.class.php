<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-06-05
 * Time: 16:05
 */

namespace Home\Model;


use Think\Model;

class RenovationModel extends Model
{
    protected $_validate = array(
        array('r_title','require','标题不能为空'),
        array('r_label','require','介绍不能为空'),
        array('r_imglist','require','图片不能为空'),
        array('r_img','require','缩略图不能为空')
    );

    protected $_auto = array (
        array('r_title','trim',3,'function'),
    );
}