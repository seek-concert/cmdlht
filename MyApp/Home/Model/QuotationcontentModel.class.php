<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-07-17
 * Time: 14:42
 */

namespace Home\Model;
use Think\Model;

class QuotationcontentModel extends Model
{
    protected $_validate = array(
        array('qc_title','require','报价名称不能为空'),
        array('qc_price','require','价格不能为空'),
        array('qc_type','require','类型不能为空'),
        array('qc_state','require','请勾选状态'),
        array('qc_pricetype','require','请勾选是否按数量算')
    );

    protected $_auto = array (
        array('qc_title','trim',3,'function'),
        array('qc_price','trim',3,'function')
    );
}