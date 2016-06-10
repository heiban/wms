<?php
namespace Api\Controller\Admin;

use Common\Base\BaseHttpController;
use Common\Service\ReceiptService;
use Common\Service\IngoodsService;
use Common\Service\TraceService;
use Think\Exception;

class ReceiptController extends BaseHttpController{

    public function _init($passInfo){

    }
    /**
     * 申请Receipt,ServiceClientReceiptApply
     * @access public
     * @param string $param RPC参数(receipt_code)
     * @return string
     */
    public function search(){
        try{
            //$this->_getPassportUser();
            $param = array(
                "receipt_code"      =>  I('get.receipt_code'),  //可选,有则查询一条,没有则查询全部
                "receipt_status"    =>  I('get.receipt_status'),//查询条件,根据状态查询
                "user_code"         =>  I('get.user_code'),     //查询条件,根据用户查询
                "page"              =>  I('get.page'),          //当前页数
            );
            $receiptService = new ReceiptService();
            $receiptCode    = $param["receipt_code"];
            $receiptStatus  = $param["receipt_status"];
            $userCode       = $param["user_code"];
            $page           = $param["page"];
            if(!empty($receiptCode)){
                $condition = array("receipt_code"=>$receiptCode);
                $result = $receiptService->getItem($condition);
                if(empty($result)){
                    throw new Exception("参数有误!");
                }else{
                    $ingoodsService = new IngoodsService();
                    $result["ingoods_list"] = $ingoodsService->getList($condition);
                }
            }else {
                $condition = array();
                if(!empty($userCode)){
                    $condition = array_merge($condition,array("user_code"=>$userCode));
                }
                if(!empty($receiptStatus)){
                    $condition = array_merge($condition,array("receipt_status"=>$receiptStatus));
                }
                if(empty($page)){
                    $page = 1;
                }
                $result =array(
                    "list"  =>  $receiptService->getList($condition,$page),
                    "pn"    =>  $receiptService->getPageNum(),
                    "p"     =>  intval($page),
                );
            }
            return wms_set_http_result(0,$result);
        }catch(Exception $e){
            return wms_set_http_result(1,"",$e->getMessage());
        }
    }
    public function approval(){
        try{
            //$this->_getPassportUser();
            $param = array(
                "receipt_code"      =>  I('get.receipt_code'),
            );
            $receiptService = new ReceiptService();
            $receiptCode    = wms_get_valid_param($param,"receipt_code");
            $condition      = array("receipt_code"=>$receiptCode);
            $statusCode     = 3;//标识确认申请,等待入仓,具体看全局wms_get_status_message函数
            $data           = array("receipt_status"=>$statusCode);
            $result         = $receiptService->updateItem($data,$condition);
            if($result){
                $receiptItem = $receiptService->getItem($condition);
                if(!empty($receiptItem)){
                    $traceService   = new TraceService();
                    $traceService->addtrace(
                        $receiptItem["trace_code"],
                        wms_get_status_message($statusCode)
                    );
                }
            }
            return wms_set_http_result(0,$result);
        }catch(Exception $e){
            return wms_set_http_result(1,"",$e->getMessage());
        }
    }
}
