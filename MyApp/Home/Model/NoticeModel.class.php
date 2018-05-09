<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-07-12
 * Time: 15:32
 */

namespace Home\Model;

use Think\Model;

class NoticeModel extends Model
{
    protected $_validate = array(
        array('n_title','require','标题不能为空'),
        array('n_content	','require','内容不能为空'),
    );

}