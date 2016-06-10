<?php
namespace Common\Service;
use Common\Dao\AdminDao;
use Common\Dao\WorkerDao;

/**
 * Created by PhpStorm.
 * User: wanghui
 * Date: 16/5/21
 * Time: 23:31
 */

class WorkerService{
    private $dao;

    /**
     * 构造函数
     * @access public
     */
    public function __construct(){
        $this->dao=new WorkerDao();
    }

    /**
     * 注册
     */
    public function register($worker){
        $worker_code = wms_get_unique_code("W");
        $result = $this->dao->insert(array(
            "worker_code"   =>  $worker_code,
            "worker_name"   =>  $worker["admin_name"],
            "worker_pwd"    =>  $worker["admin_pwd"],
            "worker_role"   =>  $worker["admin_role"],
            "needsync"      =>  1,
        ));
        return isset($result)?$worker_code:0;
    }

    public function getList($condition){
        $result = $this->dao->queryList($condition);
        return $result;
    }

    public function getItem($condition){
        $result = $this->dao->query($condition);
        return $result;
    }

    public function getNeedSyncList(){
        $condition = array("needsync"=>1);
        $result = $this->dao->queryList($condition);
        return $result;
    }

    public function setNeedSyncDone($codes){
        $condition = array("worker_code"=>array("IN",$codes));
        $data = array("needsync"=>0);
        $result = $this->dao->update($data,$condition);
        return $result;
    }

}
