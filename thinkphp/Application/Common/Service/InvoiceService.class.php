<?php
namespace Common\Service;
use Common\Dao\InvoiceDao;


/**
 * Created by PhpStorm.
 * User: wanghui
 * Date: 16/5/21
 * Time: 23:31
 */

class InvoiceService{
    private $dao;

    /**
     * 构造函数
     * @access public
     */
    public function __construct(){
        $this->dao = new InvoiceDao();
    }

    /**
     * 注册
     */
    public function register($item){
        $invoice_code = wms_get_unique_code("I");
        $result = $this->dao->insert(array(
            "invoice_code"              =>  $invoice_code,
            "invoice_createdate"        =>  $item["invoice_createdate"],
            "invoice_dcode"             =>  $item["invoice_dcode"],
            "invoice_dcode2"            =>  $item["invoice_dcode2"],
            "invoice_status"            =>  $item["invoice_status"],
            "invoice_receiver"          =>  $item["invoice_receiver"],
            "invoice_receiver_phone"    =>  $item["invoice_receiver_phone"],
            "invoice_receiver_ucode"    =>  $item["invoice_receiver_ucode"],
            "invoice_receiver_ucard"    =>  $item["invoice_receiver_ucard"],
            "invoice_receiver_ucard2"   =>  $item["invoice_receiver_ucard2"],
            "invoice_addr_nation"       =>  $item["invoice_addr_nation"],
            "invoice_addr_province"     =>  $item["invoice_addr_province"],
            "invoice_addr_city"         =>  $item["invoice_addr_city"],
            "invoice_addr_district"     =>  $item["invoice_addr_district"],
            "invoice_addr_detail"       =>  $item["invoice_addr_detail"],
            "invoice_addr_post"         =>  $item["invoice_addr_post"],
            "invoice_dtype"             =>  $item["invoice_dtype"],
            "invoice_options"           =>  $item["invoice_options"],
            "trace_code"                =>  $item["trace_code"],
            "user_code"                 =>  $item["user_code"],
            "needsync"                  =>  1,
        ));
        return isset($result)?$invoice_code:0;
    }

    public function getList($condition){
        $result = $this->dao->queryList($condition);
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

}