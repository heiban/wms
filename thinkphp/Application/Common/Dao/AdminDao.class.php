<?php
namespace Common\Dao;
/**
 * Created by PhpStorm.
 * User: wanghui
 * Date: 16/5/21
 * Time: 18:21
 */

/**
 * admin_id
 * admin_code
 * admin_name
 * admin_pwd
 * admin_role
 * admin_level
 *
 */

class AdminDao{

    /**
     * 构造函数
     * @access public
     */
    public function __construct(){

    }

    //插入新用户
    public function insert($data){
        return M("Admin")->add($data);
    }
    //更新用户数据
    public function update($data,$condition){
        return M("Admin")->where($condition)->save($data);
    }
    //查询用户数据
    public function query($condition){
        return M("Admin")->where($condition)->find();
    }
    //查询用户数据列表
    public function queryList($condition){
        return M("Admin")->where($condition)->select();
    }
    //删除用户数据
    public function delete($condition){
        return M("Admin")->where($condition)->delete();
    }

}
