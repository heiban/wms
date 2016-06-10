<?php
namespace Common\Dao;
/**
 * Created by PhpStorm.
 * User: wanghui
 * Date: 16/5/21
 * Time: 18:21
 */

/**
 * invoice_id
 * invoice_code
 * invoice_createdata
 * invoice_dcode
 * invoice_dcode2
 * invoice_status
 * invoice_receiver
 * invoice_receiver_phone
 * invoice_receiver_ucode
 * invoice_receiver_ucard
 * invoice_receiver_ucard2
 * invoice_addr_nation
 * invoice_addr_province
 * invoice_addr_city
 * invoice_addr_district
 * invoice_addr_detail
 * invoice_addr_post
 * invoice_dtype
 * invoice_options
 * trace_code
 * user_code
 * needsync
 */

class InvoiceDao{

    /**
     * 构造函数
     * @access public
     */
    public function __construct(){

    }

    //插入
    public function insert($data){
        return M("Invoice")->add($data);
    }
    //更新
    public function update($data,$condition){
        return M("Invoice")->where($condition)->save($data);
    }
    //查询
    public function query($condition){
        return M("Invoice")->where($condition)->find();
    }
    //查询数据列表
    public function queryList($condition){
        return M("Invoice")->where($condition)->select();
    }
    //删除
    public function delete($condition){
        return M("Invoice")->where($condition)->delete();
    }


}
