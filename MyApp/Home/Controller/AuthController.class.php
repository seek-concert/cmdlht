<?php
namespace Home\Controller;
use Think\Controller;
class AuthController extends Controller {
    public $user_info;
    public $level_where;
    public $order_where;
    public function _initialize()
    {
        /* 代理信息 */
         $user_info = session('p_loginname');
         if(!$user_info){
             if(IS_AJAX){
                 $priv = array(
                     'status'=> 1,
                     'info' =>'没有操作权限！'
                 );
                 $this->ajaxReturn($priv); die;
             }else{
                 session(null);
                 $this->redirect('index/index');
             }
         }

         $this->user_info = $user_info;
        /* 用户区域条件 */
        $level = $user_info['p_level'];
        if($level==1){
            $levelwhere['u_sheng'] = $user_info['p_sheng'];
        }
        if($level==2){
            $levelwhere['u_sheng'] = $user_info['p_sheng'];
            $levelwhere['u_shi'] = $user_info['p_shi'];
        }
        if($level==3){
            $levelwhere['u_sheng'] = $user_info['p_sheng'];
            $levelwhere['u_shi'] = $user_info['p_shi'];
            $levelwhere['u_xian'] = $user_info['p_xian'];
        }
        $this->level_where = $levelwhere;
        /* 订单区域条件 */
        if($level==1){
            $levelwheres['sd_province'] = $user_info['p_sheng'];
        }
        if($level==2){
            $levelwheres['sd_province'] = $user_info['p_sheng'];
            $levelwheres['sd_city'] = $user_info['p_shi'];
        }
        if($level==3){
            $levelwheres['sd_province'] = $user_info['p_sheng'];
            $levelwheres['sd_city'] = $user_info['p_shi'];
            $levelwheres['sd_county'] = $user_info['p_xian'];
        }
        $this->order_where = $levelwheres;
    }

}