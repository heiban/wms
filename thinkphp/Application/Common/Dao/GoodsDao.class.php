<?php
namespace Common\Dao;
/**
 * Created by PhpStorm.
 * User: wanghui
 * Date: 16/5/21
 * Time: 18:21
 */

/**
 * goods_id
 * goods_code
 * goods_num
 * goods_createdate
 * goods_type
 * goods_price
 * goods_status
 * sku_code
 * trace_code
 * user_code
 */

class GoodsDao{

    /**
     * 构造函数
     * @access public
     */
    public function __construct(){

    }

    //插入
    public function insert($data){
        return M("Goods")->add($data);
    }
    //更新
    public function update($data,$condition){
        return M("Goods")->where($condition)->save($data);
    }
    //查询
    public function query($condition){
        return M("Goods")->where($condition)->find();
    }
    //查询数据列表
    public function queryList($condition){
        return M("Goods")->where($condition)->select();
    }
    //删除
    public function delete($condition){
        return M("Goods")->where($condition)->delete();
    }


}
