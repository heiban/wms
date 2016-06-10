<?php
namespace Common\Service;
use Common\Dao\AdminDao;

/**
 * Created by PhpStorm.
 * User: wanghui
 * Date: 16/5/21
 * Time: 23:31
 */

class AdminService{
    private $dao;

    /**
     * 构造函数
     * @access public
     */
    public function __construct(){
        $this->dao=new AdminDao();
    }

    /**
     * 注册
     */
    public function register($admin){
        $admin_code = wms_get_unique_code("A");
        $result = $this->dao->insert(array(
            "admin_code"   =>  $admin_code,
            "admin_name"   =>  $admin["admin_name"],
            "admin_pwd"    =>  $admin["admin_pwd"],
            "admin_role"   =>  $admin["admin_role"],
            "admin_level"  =>  $admin["admin_level"],
        ));
        return isset($result)?$admin_code:0;
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