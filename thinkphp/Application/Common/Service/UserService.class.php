<?php
namespace Common\Service;
use Common\Dao\UserDao;

/**
 * Created by PhpStorm.
 * User: wanghui
 * Date: 16/5/21
 * Time: 23:31
 */

class UserService{
    private $dao;

    /**
     * 构造函数
     * @access public
     */
    public function __construct(){
        $this->dao=new UserDao();
    }

    /**
     * 注册
     */
    public function register($user){
        $user_code = wms_get_unique_code("U");
        $result = $this->dao->insert(array(
            "user_code"     =>  $user_code,
            "user_name"     =>  $user["user_name"],
            "user_pwd"      =>  $user["user_pwd"],
            "user_sender"   =>  "",
            "user_email"    =>  $user["user_email"],
            "user_phone"    =>  $user["user_phone"],
            "user_area"     =>  "",
            "user_account"  =>  0,
            "user_infor"    =>  "",
        ));
        return isset($result)?$user_code:0;
    }
    public function getList($condition){
        $result = $this->dao->queryList($condition);
        return $result;
    }
    public function getItem($condition){
        $result = $this->dao->query($condition);
        return $result;
    }

}
