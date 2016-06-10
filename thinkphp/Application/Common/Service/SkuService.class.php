<?php
namespace Common\Service;
use Common\Dao\SkuDao;


/**
 * Created by PhpStorm.
 * User: wanghui
 * Date: 16/5/21
 * Time: 23:31
 */

class SkuService{
    private $dao;

    /**
     * 构造函数
     * @access public
     */
    public function __construct(){
        $this->dao=new SkuDao();
    }
    /**
     * 注册
     */
    public function register($item){
        $sku_code = wms_get_unique_code("S");
        $result = $this->dao->insert(array(
            "sku_code"      =>  $sku_code,
            "sku_barcode"   =>  $item["sku_barcode"],
            "sku_name"      =>  $item["sku_name"],
            "sku_weight"    =>  $item["sku_weight"],
            "sku_size"      =>  $item["sku_size"],
            "sku_norms"     =>  $item["sku_norms"],
            "sku_imgurl"    =>  $item["sku_imgurl"],
            "needsync"      =>  1,
        ));
        return isset($result)?$sku_code:0;
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
        $condition = array("sku_code"=>array("IN",$codes));
        $data = array("needsync"=>0);
        $result = $this->dao->update($data,$condition);
        return $result;
    }

}
