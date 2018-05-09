<?php
namespace Home\Model;
use Think\Model\ViewModel;

class PcdesignworksDesignclickViewModel extends ViewModel
{
    public $viewFields = array(
        'designclick'=>array('*','_type'=>'LEFT'),
        'PcDesignworks'=>array('dw_title'=>'dwid_name', '_on'=>'designclick.dc_dwid = PcDesignworks.dw_id')
    );
}