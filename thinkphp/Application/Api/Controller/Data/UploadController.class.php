<?php
namespace Api\Controller\Data;

use Think\Controller;
use Common\Base\BaseHttpController;
use Think\Upload;

class UploadController extends BaseHttpController{

    public function _init(){
        //$admin = $this->_getPassportUser();
        //wms_get_valid_param($admin,"admin_code");

    }
    public function image(){
        $upload = new Upload();     // 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('png','jpg','jpeg','gif');// 设置附件上传类型
        $upload->rootPath  =     TEMP_PATH; // 设置附件上传根目录
        $upload->savePath  =     ''; // 设置附件上传（子）目录
        // 上传文件
        $info   =   $upload->upload();
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }else{// 上传成功
            //echo('上传成功！');
        }
        $filePath=TEMP_PATH.$info["file"]['savepath'].$info["file"]['savename'];
        $fileContent = file_get_contents($filePath);

        $fPath = "./Public/image/";
        $fName = $info["file"]['md5'];
        $fExt = $info["file"]['ext'];
        //$filePath = $fPath.$fName.'.'.$fExt;
        $result = file_put_contents($filePath,$fileContent);
        if (file_exists($filePath))
            echo "ok";
        else
            echo "no";
        echo "$fPath$fName.$fExt";
    }

}