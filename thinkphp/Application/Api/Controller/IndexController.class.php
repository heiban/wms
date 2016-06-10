<?php
namespace Api\Controller;

use Common\Base\BaseHttpController;
use Common\Dao\IngoodsDao;
use Common\Service\UserService;
use Think\Exception;

class IndexController extends BaseHttpController{

    private $userinfor;
    private $userService;
    public function _init($userInfor){
        $this->userinfor = $userInfor;
        $this->userService = new UserService();
    }

    public function login(){
        try{
            $user_name = I("name");
            $user_pwd = I("pwd");
            $result = $this->userService->login($user_name,$user_pwd);
            wms_set_request_result(0,$result,"");
        }catch(Exception $e){
            wms_set_request_result(1,$e->getCode(),$e->getMessage());
        }
    }

    public function register(){
        try{
            $user_name  = I("name");
            $user_pwd   = I("pwd");
            //$user_pwd2   = I("pwd2");
            $user_sender = I("sender");
            $user_email = I("email");
            $user_phone = I("phone");
            $user_area  = I("area");
            $user_account = I("account");
            $user_infor =I("infor");
            $result = $this->userService->register($user_name,$user_pwd,
                $user_sender,$user_email, $user_phone,
                $user_area,$user_account,$user_infor);
            wms_set_http_result(0,$result,"");
        }catch(Exception $e){
            wms_set_http_result(1,$e->getCode(),$e->getMessage());
        }
    }

    public function logout(){
        try{
            $result = $this->userService->logout();
            wms_set_http_result(0,$result,"");
        }catch(Exception $e){
            wms_set_http_result(1,$e->getCode(),$e->getMessage());
        }
    }
    public function infor(){
        try{
            //$this->userService->logout();
            $result = $this->userService->loginuser();
            wms_set_http_result(0,$result,"");
        }catch(Exception $e){
            wms_set_http_result(1,$e->getCode(),$e->getMessage());
        }
    }
    public function test(){
       var_dump($_GET);
    }

}