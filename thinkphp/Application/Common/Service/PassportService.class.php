<?php
namespace Common\Service;

/**
 * Created by PhpStorm.
 * User: wanghui
 * Date: 16/5/21
 * Time: 23:31
 */

class PassportService{

    /**
     * 构造函数
     * @access public
     */
    public function __construct(){
    }


    public static function login($code,$data,$type="uid",$expire=3600){
        $sessionValue=md5(session_id().$code);
        session($sessionValue,$data,$expire);
        session($code,$sessionValue,$expire);
        cookie($type,$code,$expire);
        return true;
    }

    public static function logout($type="uid"){
        $code = cookie($type);
        $sessionValue = session($code);
        session($code,null);
        session($sessionValue,null);
        cookie($type,null);
        return true;
    }

    public static function status($type="uid"){
        $code = cookie($type);
        if(isset($code)){
            $sessionValue = session($code);
            $data = session($sessionValue);
            $realSessionValue=md5(session_id().$code);
            if(isset($sessionValue) && isset($data) && $realSessionValue==$sessionValue){
                self::login($code,$data);
                return $data;
            }
            self::logout();
        }
        return null;
    }
}
