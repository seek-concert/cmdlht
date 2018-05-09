<?php
namespace Home\Model;
use Think\Model;

class ProducttypeModel extends Model
{
    /*自动验证*/
    protected $_validate = array(
        array('pt_receptionname','require','前台展示名称不能为空'),
        array('pt_receptionname','','前台展示名称已存在',0,'unique',1),
        array('pt_order','require','排序不能为空'),
        array('pt_backstagename','require','标语不能为空'),
        array('pt_img','require','图标不能为空')
    );

    protected $_auto = array (
        array('pt_receptionname','trim',3,'function')
    );
}