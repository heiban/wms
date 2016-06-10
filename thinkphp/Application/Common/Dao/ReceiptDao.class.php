<?php
namespace Common\Dao;
/**
 * Created by PhpStorm.
 * User: wanghui
 * Date: 16/5/21
 * Time: 18:21
 */

/**
 * receipt_id
 * receipt_code
 * receipt_createdate
 * receipt_dcode
 * receipt_dcode2
 * receipt_infor
 * receipt_status
 * trace_code
 * user_code
 * needsync
 */

class ReceiptDao{

    /**
     * 构造函数
     * @access public
     */
    public function __construct(){

    }

    //插入
    public function insert($data){
        return M("Receipt")->add($data);
    }
    //更新
    public function update($data,$condition){
        return M("Receipt")->where($condition)->save($data);
    }
    //查询
    public function query($condition){
        return M("Receipt")->where($condition)->find();
    }
    //查询数据列表
    public function queryList($condition,$page='1,10'){
        return M("Receipt")->where($condition)->order("receipt_createdate DESC")->page($page)->select();
    }
    //删除
    public function delete($condition){
        return M("Receipt")->where($condition)->delete();
    }

    public function count(){
        return M("Receipt")->count();
    }


}
