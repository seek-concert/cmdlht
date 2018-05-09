<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-05-31
 * Time: 16:21
 */

namespace Home\Model;
use Think\Model;

class UserinfoModel extends  Model
{
    protected $_validate = array(
        array('u_loginname','require','登陆账号不能为空'),
        array('u_loginpassword','require','密码不能为空'),
        array('u_loginname','','登陆账号已存在',0,'unique',1),
        array('u_number','','编号已存在',0,'unique',1),
        array('u_nickname','require','昵称不能为空'),
        array('u_nickname','','昵称已存在',0,'unique',1),
        array('u_phone','require','电话不能为空'),
        array('u_favicon','require','头像不能为空')
    );

    protected $_auto = array (
        array('u_loginname','trim',3,'function'),
        array('u_loginpassword','md5',3,'function'),
    );
}