<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-06-03
 * Time: 14:42
 */

namespace Home\Controller;

class BrandController extends AuthController
{
    /*品牌-列表显示*/
    public function index_list(){
        $brand_model = D('brand');
        /* 查询条件 */
        $where = array();
        /* 名称*/
        $bname = I('b_name');
        if($bname){
            $where['b_name'] = array('LIKE','%'.$bname.'%');
            $this->assign('bname',$bname);
        }
        /* 拼音首字母*/
        $bpinyininitials = I('b_pinyininitials');
        if($bpinyininitials){
            $where['b_pinyininitials'] = $bpinyininitials;
            $this->assign('bpinyininitials',$bpinyininitials);
        }

        /* 每页显示条数 */
        $num =  20;
        /* 页码 */
        $p = $_GET['p'] ? $_GET['p'] : 1;

        /* 获取分页列表  */
        $brand_info = $brand_model
            ->where($where)
            ->page($p . ',' . $num)
            ->select();

        /* 获取分页条 */
        $count = $brand_model->where($where)->count();
        $page_model = new \Think\Page($count, $num);
        $page_bar = $page_model->show();


        /*分页查询数据*/
        $this->assign('brand_info',$brand_info);
        $this->assign('page_bar', $page_bar);
        $this->assign('count',$count);
        $this->display();
    }

    /*品牌-添加*/
    public function insert()
    {
        if(IS_POST)
        {
            $brand_model = D('brand');
            /*数据创建及模型验证*/
            $data = $brand_model->create();
            if(!$data){
                $this->error($brand_model->getError(), '',1);
            }

            $data['b_name'] = I('b_name');
            /*生成汉字拼音和汉字首字母*/
            $py = new \Org\Util\ChinesePinyin();
          /*  echo $Pinyin->TransformWithTone("带声调的汉语拼音");
            echo $Pinyin->TransformWithoutTone("无声调的汉语拼音");
            echo $Pinyin->TransformUcwordsOnlyChar("首字母只包括汉字BuHanPinYin");
            echo $Pinyin->TransformUcwords("首字母和其他字符如B区32号");*/
            $data['b_pinyin'] = $py->TransformWithoutTone($data['b_name']);
            $data['b_pinyininitials'] = $py->TransformUcwordsOnlyChar($data['b_name']);

            /*数据添加*/
            unset($data['b_id']);
            $rs = $brand_model->add($data);
            if ($rs) {
                $this->success("添加成功", U('index_list'),1);
            }else{
                $this->error("添加失败",'',1);
            }
        }else{
            /*查询所有商家*/
            $userinfo_model = M('userinfo');
            $userinfo_find['u_type'] = '3';
            $userinfo_find['u_toexamine'] = '1';
            $userinfo_info = $userinfo_model->where($userinfo_find)->where($this->level_where)->field('u_id,u_shopname,u_nickname')->select();
            $this->assign('userinfo_info',$userinfo_info);
            /*调用添加模板*/
            $this->display('modify');
        }
    }
}