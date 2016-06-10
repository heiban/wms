<?php
namespace Service\Controller\Data;

use Common\Service\TraceService;
use Think\Controller\RpcController;
use Think\Exception;

class TraceController extends RpcController{

    //查询TRACE,ServiceClientTraceSearch
    public function search($param){
        try{

            $trace_code = $param["trace_code"];
            $traceService = new TraceService();
            $traceService->addtrace($trace_code,"已经创建成功");
            $traceService->addtrace($trace_code,"修改数据");
            $result = $traceService->getItem(array("trace_code"=>$trace_code));
            return wms_get_rpc_result(0,$result);
        }catch(Exception $e){
            return wms_get_rpc_result(1,"",$e->getMessage());
        }

    }


}