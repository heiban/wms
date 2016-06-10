<?php
namespace Common\Dao;
/**
 * Created by PhpStorm.
 * User: wanghui
 * Date: 16/5/21
 * Time: 18:21
 */

/**
 * ingoods_id
 * ingoods_code
 * ingoods_num
 * sku_code
 * receipt_code
 * user_code
 */

class IngoodsDao{

    /**
     * 构造函数
     * @access public
     */
    public function __construct(){

    }

    //插入
    public function insert($data){
        return M("Ingoods")->add($data);
    }
    //更新
    public function update($data,$condition){
        return M("Ingoods")->where($condition)->save($data);
    }
    //查询
    public function query($condition){
        return M("Ingoods")->table("wms_ingoods G")->join("LEFT JOIN wms_sku S on S.sku_code=G.sku_code")->where($condition)->find();
    }
    //查询数据列表
    public function queryList($condition){
        return M("Ingoods")->table("wms_ingoods G")->join("LEFT JOIN wms_sku S on S.sku_code=G.sku_code")->where($condition)->join()->select();
    }
    //删除
    public function delete($condition){
        return M("Ingoods")->where($condition)->delete();
    }


}
