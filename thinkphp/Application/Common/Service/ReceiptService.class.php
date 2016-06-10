<?php
namespace Common\Service;
use Common\Dao\ReceiptDao;


/**
 * Created by PhpStorm.
 * User: wanghui
 * Date: 16/5/21
 * Time: 23:31
 */

class ReceiptService{
    private $dao;

    /**
     * 构造函数
     * @access public
     */
    public function __construct(){
        $this->dao = new ReceiptDao();
    }

    /**
     * 注册
     */
    public function register($item){
        $receipt_code = wms_get_unique_code("R");
        $result = $this->dao->insert(array(
            "receipt_code"          =>  $receipt_code,
            "receipt_createdate"    =>  wms_get_now_datetime(),
            "receipt_dcode"         =>  $item["receipt_dcode"],
            "receipt_dcode2"        =>  $item["receipt_dcode2"],
            "receipt_infor"         =>  "",
            "receipt_status"        =>  1,
            "trace_code"            =>  $item["trace_code"],
            "user_code"             =>  $item["user_code"],
            "needsync"              =>  0,
        ));
        return isset($result)?$receipt_code:0;
    }

    public function getList($condition,$page='1'){
        $result = $this->dao->queryList($condition,$page.','.C("PAGE_LIST_COUNT"));
        return $result;
    }
    public function getItem($condition){
        $result = $this->dao->query($condition);
        return $result;
    }
    public function delItem($condition){
        $result = $this->dao->delete($condition);
        return $result;
    }
    public function updateItem($data,$condition){
        $result = $this->dao->update($data,$condition);
        return $result;
    }
    public function getPageNum(){
        $num = $this->dao->count();
        return ceil($num/intval(C("PAGE_LIST_COUNT")));
    }

    public function getNeedSyncList(){
        $condition = array("needsync"=>1);
        $result = $this->dao->queryList($condition);
        return $result;
    }

    public function setNeedSyncDone($codes){
        $condition = array("receipt_code"=>array("IN",$codes));
        $data = array("needsync"=>0);
        $result = $this->dao->update($data,$condition);
        return $result;
    }

    public function applySync($condition,$data=null){
        $defaultData = array("needsync"=>1);
        if(!empty($data)){
            $defaultData=array_merge($defaultData,$data);
        }
        $result = $this->dao->update($defaultData,$condition);
        return $result;
    }

}