<?php
namespace Service\Controller\Client;


use Common\Service\PassportService;
use Common\Service\UserService;
use Think\Controller\RpcController;
use Think\Exception;

class PassportController extends RpcController{

    private $passInfo;
    public function _init($passInfo){
        $this->passInfo=$passInfo;
    }

    //登陆,ServiceClientPassportLogin
    public function login($param){
        try{
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
                return wms_get_rpc_result(0,$result,"登陆成功");
            }else{
                return wms_get_rpc_result(0,0,"登陆失败,用户名或密码不正确");
            }
        }catch(Exception $e){
            return wms_get_rpc_result(1,"",$e->getMessage());
        }
    }

    //注销,ServiceClientPassportLogout
    public function logout(){
        $result = PassportService::logout("uid");
        return wms_get_rpc_result(0,$result,"退出登陆成功!");
    }

    //注册,ServiceClientPassportRegister
    public function register($param){
        try{
            wms_get_valid_param($param,"user_name");
            wms_get_valid_param($param,"user_pwd");
            wms_get_valid_param($param,"user_email");
            wms_get_valid_param($param,"user_phone");
            $userService = new UserService();
            $result = $userService->register($param);
            return wms_get_rpc_result(0,$result,"注册成功");
        }catch(Exception $e){
            return wms_get_rpc_result(1,"",$e->getMessage());
        }
    }
    public function status(){
        try{
            $passInfo = PassportService::status("uid");
            $result = empty($passInfo)?0:1;
            return wms_get_rpc_result(0,$result,"登录状态");
        }catch(Exception $e){
            return wms_get_rpc_result(1,"",$e->getMessage());
        }
    }

}
