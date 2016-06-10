<?php
/**
 * Created by PhpStorm.
 * User: wanghui
 * Date: 16/5/18
 * Time: 23:21
 */


//生成随机唯一编码
function wms_get_unique_code($prefix){
    return $prefix.(date('y')-15).date("mdHis",time()).rand(100,999);
}
//生成统一格式结果
function wms_set_http_result($error,$result="",$message=""){
    echo json_encode(array(
        "error" =>  $error,
        "result" =>  $result,
        "message" =>  $message,
    ));
    return 1;
}
function wms_get_rpc_result($error,$result="",$message=""){
    return json_encode(array(
        "error" =>  $error,
        "result" =>  $result,
        "message" =>  $message,
    ));
}
//获取当前系统时间
function wms_get_now_datetime(){
    return date("Y-m-d H:i:s",time());
}

//统一获取参数的过滤函数
function wms_get_valid_param($param,$key){
    if(!isset($param[$key])  || empty($param[$key] )){
        throw new Exception("却少".$key."参数!");
    }
    return $param[$key];
}

function wms_get_status_message($code){
    $statusCodeMap=array(
        "1"=>"已创建入仓申请单，尚未提交",
        "2"=>"已提交入仓申请单，暂未同步到仓库",
        "3"=>"入仓申请单已同步至仓库，等待物流到仓",
        "4"=>"已物流到仓库，等待人工验货",
        "5"=>"已完成验货，等待搬运至仓位",
        "6"=>"已完成搬运，入仓完成",
    );
    $message=$statusCodeMap[$code];
    if(empty($message)){
        throw new Exception("状态码".$code."无效!");
    }
    return $message;
}

/**对excel里的日期进行格式转化*/
function wms_excel_getdate($val){
    $jd = GregorianToJD(1, 1, 1970);
    $gregorian = JDToGregorian($jd+intval($val)-25569);
    return $gregorian;/**显示格式为 “月/日/年” */
}