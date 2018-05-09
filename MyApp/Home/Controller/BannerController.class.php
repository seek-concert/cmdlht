<?php
namespace Home\Controller;

use OSS\Core\OssException;
class BannerController extends AuthController {

    /***
     *实现图片上传
     */
    public function ajaxupload() {

        if (IS_POST) {
            $upload = new \Think\Upload(); /*// 实例化上传类*/
            $upload->maxSize = 3145728; /*// 设置附件上传大小*/
            $upload->exts = array('jpg', 'gif', 'png', 'jpeg'); /*// 设置附件上传类型*/
            $upload->rootPath = './Public/upload/banner/'; /*// 设置附件上传根目录*/
            $upload->subName= array('date','Ymd');
            $upload->savePath = ''; /*// 设置附件上传（子）目录*/
          /*  // 上传文件*/
            $info = $upload->upload();

            if (!$info) {/*// 上传错误提示错误信息*/
                $this->error($upload->getError());
            } else {//*/ 上传成功*/
                /*阿里云处理*/
                vendor('aliyunoss.autoload');
                $accessKeyId = "W3DcrNkgNRf6poJu";//去阿里云后台获取秘钥 W3DcrNkgNRf6poJu
                $accessKeySecret = "zgNuEiuEs8Vd8yBbIMCMWAeOirAzTa";//去阿里云后台获取秘钥 zgNuEiuEs8Vd8yBbIMCMWAeOirAzTa
                $endpoint = "http://oss-cn-shanghai.aliyuncs.com ";//你的阿里云OSS地址
                $ossClient = new \OSS\OssClient($accessKeyId, $accessKeySecret, $endpoint);

                $bucket= "chongmai";//oss中的文件上传空间 fengkuanglueduo
                $object = 'imgall/'.date('Ymd').'/'.$info['upload_file']['savename'];//想要保存文件的名称
              try{
                    $info=$ossClient->uploadFile($bucket,$object,'./Public/upload/banner/'. $info['upload_file']['savepath'] . $info['upload_file']['savename']);
                    $aliyun_url=$info['oss-request-url'];
                    $this->success('上传成功',$aliyun_url,1);
                } catch(OssException $e) {
                    $this->error($e->getMessage(),'',1);
                }
          }
        } else {
            $this->display('uploadframe');
        }
    }

    /*     * *
   * 实现图片上传--含缩略图
   * 400*400   800*800
   */
    public function ajaxuploads() {
        if (IS_POST) {
            $upload = new \Think\Upload(); /*// 实例化上传类*/
            $upload->maxSize = 3145728; /*// 设置附件上传大小*/
            $upload->exts = array('jpg', 'gif', 'png', 'jpeg'); /*// 设置附件上传类型*/
            $upload->rootPath = './Public/upload/banner/'; /*// 设置附件上传根目录*/
            $upload->savePath = ''; /*// 设置附件上传（子）目录*/
            /*// 上传文件*/
            $info = $upload->upload();
            if (!$info) {/*// 上传错误提示错误信息*/
                $this->error($upload->getError());
            } else {/*// 上传成功*/
                $abbreviated_url = './Public/upload/banner/'. $info['upload_file']['savepath'] . $info['upload_file']['savename'];
                $image = new \Think\Image();
                $image->open($abbreviated_url);
                $image->thumb(400, 400)->save($abbreviated_url.'400x400.png');
                $image->open($abbreviated_url);
                $image->thumb(800, 800)->save($abbreviated_url.'800x800.png');
                $url = '/Public/upload/banner/'. $info['upload_file']['savepath'] . $info['upload_file']['savename'];
                $abbreviated4_url = $url.'400x400.png';
                $abbreviated8_url = $url.'800x800.png';
                $a = explode(" ",$url);
                $b = explode(" ",$abbreviated4_url);
                $c = explode(" ",$abbreviated8_url);
                $abbreviated_urls = array_merge($b, $c);
                $urls = array_merge($a,$abbreviated_urls);
                /*图片名称数组*/
                $imgname = implode(',',$urls);
                $imgname = str_replace('/Public/upload/banner/'. $info['upload_file']['savepath'],'', $imgname);
                $imgname = str_replace(".jpg","",$imgname);
                $imgname = explode(',',$imgname);
                /*阿里云处理*/
                vendor('aliyunoss.autoload');
                $accessKeyId = "W3DcrNkgNRf6poJu";//去阿里云后台获取秘钥 W3DcrNkgNRf6poJu
                $accessKeySecret = "zgNuEiuEs8Vd8yBbIMCMWAeOirAzTa";//去阿里云后台获取秘钥 zgNuEiuEs8Vd8yBbIMCMWAeOirAzTa
                $endpoint = "http://oss-cn-shanghai.aliyuncs.com ";//你的阿里云OSS地址
                $ossClient = new \OSS\OssClient($accessKeyId, $accessKeySecret, $endpoint);

                $bucket= "chongmai";//oss中的文件上传空间 fengkuanglueduo
                $object0 = 'imgall/'.date('Ymd').'/'.$info['upload_file']['savename'];//想要保存文件的名称
                $object1 = 'imgall/'.date('Ymd').'/'.$imgname[1];//想要保存文件的名称
                $object2 = 'imgall/'.date('Ymd').'/'.$imgname[2];//想要保存文件的名称
                try{
                    $info0=$ossClient->uploadFile($bucket,$object0,'.'.$urls[0]);
                    $aliyun_url0=$info0['oss-request-url'];
                    $info1=$ossClient->uploadFile($bucket,$object1,'.'.$urls[1]);
                    $aliyun_url1=$info1['oss-request-url'];
                    $info2=$ossClient->uploadFile($bucket,$object2,'.'.$urls[2]);
                    $aliyun_url2=$info2['oss-request-url'];
                    $aliyun_url = $aliyun_url0.",".$aliyun_url1.",".$aliyun_url2;
                    $aliyun_url = explode(',',$aliyun_url);
                    $this->success('上传成功',$aliyun_url,1);
                } catch(OssException $e) {
                    $this->error($e->getMessage(),'',1);
                }
            }
        } else {
            $this->display('uploadframe');
        }
    }

}
