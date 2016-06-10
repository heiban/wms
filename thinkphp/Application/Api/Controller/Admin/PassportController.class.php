<?php
namespace Api\Controller\Admin;


use Common\Service\PassportService;
use Common\Service\AdminService;
use Think\Controller;
use Think\Exception;

class PassportController extends Controller{

    private $passInfo;
    public function _init($passInfo){
        $this->passInfo=$passInfo;
    }

    //登陆,ApiClientPassportLogin
    public function login(){
        try{
            $param = array(
                "admin_name" =>  I('post.admin_name'),
                "admin_pwd"  =>  I('post.admin_pwd'),
            );
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
        $result = PassportService::logout("aid");
        return wms_set_http_result(0,$result,"退出登陆成功!");
    }

    //注册,ApiClientPassportRegister
    public function register(){
        try{
            $param = array(
                "admin_name"    =>  I('post.admin_name'),
                "admin_pwd"     =>  I('post.admin_pwd'),
                "admin_role"    =>  I('post.admin_role'),
            );
            wms_get_valid_param($param,"admin_name");
            wms_get_valid_param($param,"admin_pwd");
            wms_get_valid_param($param,"admin_role");
            $adminService = new AdminService();
            $existedAdmin = $adminService->getItem(array(
                "admin_name"=>$param["admin_name"],
            ));
            if(!empty($existedAdmin)){
                throw new Exception("该管理员已经存在!");
            }

            $result = $adminService->register($param);
            return wms_set_http_result(0,$result,"注册成功");
        }catch(Exception $e){
            return wms_set_http_result(1,"",$e->getMessage());
        }
    }
    public function status(){
        try{
            $passInfo = PassportService::status("aid");
            $result = empty($passInfo)?0:$passInfo;
            return wms_set_http_result(0,$result,"登录状态");
        }catch(Exception $e){
            return wms_set_http_result(1,"",$e->getMessage());
        }
    }

}
