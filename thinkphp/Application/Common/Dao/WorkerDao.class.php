<?php
namespace Common\Dao;
/**
 * Created by PhpStorm.
 * User: wanghui
 * Date: 16/5/21
 * Time: 18:21
 */

/**
 * worker_id
 * worker_code
 * worker_name
 * worker_pwd
 * worker_role
 * needsync
 *
 */

class WorkerDao{

    /**
     * 构造函数
     * @access public
     */
    public function __construct(){

    }

    //插入新用户
    public function insert($data){
        return M("Worker")->add($data);
    }
    //更新用户数据
    public function update($data,$condition){
        return M("Worker")->where($condition)->save($data);
    }
    //查询用户数据
    public function query($condition){
        return M("Worker")->where($condition)->find();
    }
    //查询用户数据列表
    public function queryList($condition){
        return M("Worker")->where($condition)->select();
    }
    //删除用户数据
    public function delete($condition){
        return M("Worker")->where($condition)->delete();
    }
}
