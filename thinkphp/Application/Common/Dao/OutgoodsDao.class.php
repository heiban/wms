<?php
namespace Common\Dao;
/**
 * Created by PhpStorm.
 * User: wanghui
 * Date: 16/5/21
 * Time: 18:21
 */

/**
 * outgood_id
 * outgood_code
 * outgood_num
 * sku_code
 * receipt_code
 * user_code
 */

class OutgoodsDao{

    /**
     * 构造函数
     * @access public
     */
    public function __construct(){

    }

    //插入
    public function insert($data){
        return M("Outgoods")->add($data);
    }
    //更新
    public function update($data,$condition){
        return M("Outgoods")->where($condition)->save($data);
    }
    //查询
    public function query($condition){
        return M("Outgoods")->where($condition)->find();
    }
    //查询数据列表
    public function queryList($condition){
        return M("Outgoods")->where($condition)->select();
    }
    //删除
    public function delete($condition){
        return M("Outgoods")->where($condition)->delete();
    }


}
