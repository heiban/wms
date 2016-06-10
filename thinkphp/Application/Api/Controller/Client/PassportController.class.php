<?php
namespace Api\Controller\Client;

use Think\Exception;
use Think\Controller;
use Common\Service\PassportService;
use Common\Service\UserService;

class PassportController extends Controller{

    private $passInfo;
    public function _init($passInfo){
        $this->passInfo=$passInfo;
    }

    //登陆,ApiClientPassportLogin
    public function login(){
        try{
            $param = array(
                "user_name" =>  I('post.user_name'),
                "user_pwd"  =>  I('post.user_pwd'),
            );
            $userService = new UserService();
            $userName = wms_get_valid_param($param,"user_name");
            $userPwd = wms_get_valid_param($param,"user_pwd");
            $condition = array("user_name"=>$userName,"user_pwd"=>$userPwd);
            $user = $userService->getItem($condition);
            if (!empty($user)) {
                $result = PassportService::login($user["user_code"], array(
                    "user_code"     => $user["user_code"],
                    "user_name"     => $user["user_name"],
                    "user_email"    => $user["user_email"],
                    "user_phone"    => $user["user_phone"],
                ),"uid");
                return wms_set_http_result(0,$result?1:0,"登陆成功");
            }else{
                return wms_set_http_result(0,0,"登陆失败,用户名或密码不正确");
            }
        }catch(Exception $e){
            return wms_set_http_result(1,"",$e->getMessage());
        }
    }

    //注销,ApiClientPassportLogout
    public function logout(){
        $result = PassportService::logout("uid");
        return wms_set_http_result(0,$result,"退出登陆成功!");
    }

    //注册,ApiClientPassportRegister
    public function register(){
        try{
            $param = array(
                "user_name"     =>  I('post.user_name'),
                "user_pwd"      =>  I('post.user_pwd'),
                "user_email"    =>  I('post.user_email'),
                "user_phone"    =>  I('post.user_phone'),
            );
            wms_get_valid_param($param,"user_name");
            wms_get_valid_param($param,"user_pwd");
            wms_get_valid_param($param,"user_email");
            wms_get_valid_param($param,"user_phone");
            $userService = new UserService();

            $existedUser = $userService->getItem(array(
                "user_name"=>$param["user_name"],
            ));
            if(!empty($existedUser)){
                throw new Exception("用户已经存在!");
            }

            $result = $userService->register($param);
            return wms_set_http_result(0,$result,"注册成功");
        }catch(Exception $e){
            return wms_set_http_result(1,"",$e->getMessage());
        }
    }
    public function status(){
        try{
            $passInfo = PassportService::status("uid");
            $result = empty($passInfo)?0:$passInfo;
            //$result =1;
            return wms_set_http_result(0,$result,"登录状态");
        }catch(Exception $e){
            return wms_set_http_result(1,"",$e->getMessage());
        }
    }

}
