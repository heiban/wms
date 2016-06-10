<?php
namespace Common\Dao;
/**
 * Created by PhpStorm.
 * User: wanghui
 * Date: 16/5/21
 * Time: 18:21
 */

/**
 * trace_id
 * trace_code
 * trace_history
 * trace_last
 *
 */

class TraceDao{

    /**
     * 构造函数
     * @access public
     */
    public function __construct(){

    }

    //插入
    public function insert($data){
        return M("Trace")->add($data);
    }
    //更新
    public function update($data,$condition){
        return M("Trace")->where($condition)->save($data);
    }
    //查询
    public function query($condition){
        return M("Trace")->where($condition)->find();
    }
    //查询数据列表
    public function queryList($condition){
        return M("Trace")->where($condition)->select();
    }
    //删除用户数据
    public function delete($condition){
        return M("Trace")->where($condition)->delete();
    }

}
