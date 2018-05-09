<?php
namespace Home\Model;
use Think\Model\ViewModel;

class ConstructionsiteViewModel extends ViewModel
{
    public $viewFields = array(
        'constructionsite'=>array('*','(select d_name from pc_designer where pc_designer.d_id=constructionsite.cs_gdid)'=>'gdid_name','_type'=>'LEFT'),
        'pc_designer'=>array('d_name'=>'sdid_name', '_on'=>'constructionsite.cs_sdid = pc_designer.d_id')
    );
}