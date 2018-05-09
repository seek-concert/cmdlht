<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-07-13
 * Time: 11:53
 */

namespace Home\Controller;

class IndexrecommendController extends AuthController
{
    /*首页产品推荐---添加*/
    public function insert(){
        $indexrecommend_model =D('indexrecommend');
        $data = $indexrecommend_model->create();
        if(!$data){
            $this->error($this->getError,'',1);
        }
        unset($data['ir_id']);
        $rs = $indexrecommend_model->add($data);
        if($rs){
            $this->success('设置首页推荐成功','',1);
        }else{
            $this->error('设置首页推荐失败','',1);
        }
    }
    /*首页产品推荐---修改*/
    public function modify(){
        $indexrecommend_model =D('indexrecommend');
       $data = I('post.');
       $find['ir_pid'] = I('ir_pid');
        unset($data['ir_id']);
        $rs = $indexrecommend_model->where($find)->save($data);
        if($rs){
            $this->success('修改首页推荐成功','',1);
        }else{
            $this->error('修改首页推荐失败','',1);
        }
    }
}