<?php
namespace Home\Controller;

class HomeController extends  AuthController
{
    /*判断是否存在session用户*/
    public function index()
    {
        /*调用后台首页页面*/
        $this->display('home/index');
    }

    /*登陆后的展示模板*/
    public function welcome()
    {
        $ip = get_client_ip();
        $this->assign('ip',$ip);
        $Ips = new \Org\Net\IpLocation('UTFWry.dat');
        $area = $Ips->getlocation('113.250.251.40');
        $country = iconv('GB2312', 'UTF-8', $area['country']) ;
        $area = iconv('GB2312', 'UTF-8', $area['area']) ;
        $this->assign('area',$area);
        $this->assign('country',$country);
        $adminname = $this->user_info;
        $this->assign('adminname',$adminname);
        $this->display();
    }

    /*查询当前的注册用户*/
    public function notices(){
        $userinfo_model = M('userinfo');
        $where['u_noticestate'] = 0;
        $noticecount = $userinfo_model->where($where)->where($this->level_where)->count();
        $this->success('','',array('datas'=>$noticecount));
    }
}