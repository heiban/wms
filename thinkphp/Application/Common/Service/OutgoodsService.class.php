<?php
namespace Common\Service;
use Common\Dao\OutgoodsDao;


/**
 * Created by PhpStorm.
 * User: wanghui
 * Date: 16/5/21
 * Time: 23:31
 */

class OutgoodsService{
    private $dao;

    /**
     * 构造函数
     * @access public
     */
    public function __construct(){
        $this->dao=new OutgoodsDao();
    }

    /**
     * 注册
     */
    public function register($item){
        $outgoods_code = wms_get_unique_code("OG");
        $result = $this->dao->insert(array(
            "outgood_code"   =>  $outgoods_code,
            "outgood_num"    =>  $item["outgood_num"],
            "sku_code"       =>  $item["sku_code"],
            "receipt_code"   =>  $item["receipt_code"],
            "trace_code"     =>  $item["trace_code"],
            "user_code"      =>  $item["user_code"],
        ));
        return isset($result)?$outgoods_code:0;
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

}
