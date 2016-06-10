<?php
namespace Service\Controller\Admin;


use Common\Service\PassportService;
use Common\Service\AdminService;
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
            $adminService = new AdminService();
            $adminName = wms_get_valid_param($param,"admin_name");
            $adminPwd = wms_get_valid_param($param,"admin_pwd");
            $condition = array("admin_name"=>$adminName,"admin_pwd"=>$adminPwd);
            $admin = $adminService->getItem($condition);
            if (!empty($admin)) {
                $result = PassportService::login($admin["admin_code"], array(
                    "admin_code"     => $admin["admin_code"],
                    "admin_name"     => $admin["admin_name"],
                    "admin_email"    => $admin["admin_role"],
                ),"aid");
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
        $result = PassportService::logout("aid");
        return wms_get_rpc_result(0,$result,"退出登陆成功!");
    }

    //注册,ServiceClientPassportRegister
    public function register($param){
        try{
            wms_get_valid_param($param,"admin_name");
            wms_get_valid_param($param,"admin_pwd");
            wms_get_valid_param($param,"admin_role");
            $adminService = new AdminService();
            $result = $adminService->register($param);
            return wms_get_rpc_result(0,$result,"注册成功");
        }catch(Exception $e){
            return wms_get_rpc_result(1,"",$e->getMessage());
        }
    }
    public function status(){
        try{
            $passInfo = PassportService::status("aid");
            $result = empty($passInfo)?0:1;
            return wms_get_rpc_result(0,$result,"登录状态");
        }catch(Exception $e){
            return wms_get_rpc_result(1,"",$e->getMessage());
        }
    }

}
