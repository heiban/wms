<?php
namespace Common\Service;
use Common\Dao\GoodsDao;

/**
 * Created by PhpStorm.
 * User: wanghui
 * Date: 16/5/21
 * Time: 23:31
 */

class GoodsService{
    private $dao;

    /**
     * 构造函数
     * @access public
     */
    public function __construct(){
        $this->dao=new GoodsDao();
    }

    /**
     * 注册
     */
    public function register($item){
        $goods_code = wms_get_unique_code("G");
        $result = $this->dao->insert(array(
            "goods_code"        =>  $goods_code,
            "goods_num"         =>  $item["goods_num"],
            "goods_createdate"  =>  $item["goods_createdate"],
            "goods_type"        =>  $item["goods_type"],
            "goods_price"       =>  $item["goods_price"],
            "goods_status"      =>  $item["goods_status"],
            "sku_code"          =>  $item["sku_code"],
            "trace_code"        =>  $item["trace_code"],
            "user_code"         =>  $item["user_code"],
        ));
        return isset($result)?$goods_code:0;
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
    public function getgoodsnum($code){
        $condition = array("goods_code"=>$code);
        $result = $this->getItem($condition);
        return $result["goods_num"];
    }
    public function setgoodsnum($code,$num){
        $condition = array("goods_code"=>$code);
        $result = $this->dao->update(array(
            "goods_num"=>$num
        ),$condition);
        return $result;
    }


}
