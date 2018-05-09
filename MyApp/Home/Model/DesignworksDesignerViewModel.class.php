<?php
namespace Home\Model;
use Think\Model\ViewModel;

class DesignworksDesignerViewModel extends ViewModel
{
    public $viewFields = array(
        'pc_designworks'=>array('*','_type'=>'LEFT'),
        'pc_designer'=>array('d_name'=>'did_name', '_on'=>'pc_designworks.dw_did = pc_designer.d_id')
    );
}