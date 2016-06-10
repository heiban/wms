<?php
namespace Common\Service;
use Common\Dao\TraceDao;
use Common\Dao\UserDao;

/**
 * Created by PhpStorm.
 * User: wanghui
 * Date: 16/5/21
 * Time: 23:31
 */

class TraceService{
    private $dao;

    /**
     * 构造函数
     * @access public
     */
    public function __construct(){
        $this->dao=new TraceDao();
    }

    /**
     * 注册
     */
    public function register(){
        $trace_code = wms_get_unique_code("T");
        $result = $this->dao->insert(array(
            "trace_code"     =>  $trace_code,
            "trace_records"  =>  "",
            "trace_last"     =>  "",
        ));
        return $result?$trace_code:0;
    }
    public function getList($condition){
        $result = $this->dao->queryList($condition);
        return $result;
    }
    public function getItem($condition){
        $result = $this->dao->query($condition);
        return $result;
    }
    public function addtrace($code,$info){
        $condition = array("trace_code"=>$code);
        $trace = $this->getItem($condition);
        $info = wms_get_now_datetime().":".$info;
        $result = $this->dao->update(array(
            "trace_records" =>  empty($trace["trace_records"])?$info:($trace["trace_records"]."|".$info),
            "trace_last"    =>  $info,
        ),$condition);
        return $result;
    }

}
