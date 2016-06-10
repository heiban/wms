<?php
namespace Common\Dao;
/**
 * Created by PhpStorm.
 * User: wanghui
 * Date: 16/5/21
 * Time: 18:21
 */

/**
 * user_id
 * user_code
 * user_name
 * user_pwd
 * user_sender
 * user_email
 * user_phone
 * user_area
 * user_account
 * user_infor
 *
 */

class UserDao{

    /**
     * 构造函数
     * @access public
     */
    public function __construct(){

    }

    //插入新用户
    public function insert($data){
        return M("User")->add($data);
    }
    //更新用户数据
    public function update($data,$condition){
        return M("User")->where($condition)->save($data);
    }
    //查询用户数据
    public function query($condition){
        return M("User")->where($condition)->find();
    }
    //查询用户数据列表
    public function queryList($condition){
        return M("User")->where($condition)->select();
    }
    //删除用户数据
    public function delete($condition){
        return M("User")->where($condition)->delete();
    }
}
