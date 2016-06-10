<?php
namespace Service\Controller\Client;

use Common\Base\BaseRpcController;
use Think\Exception;

class ReceiptController extends BaseRpcController{

    public function _init($passInfo){

    }
    /**
     * 申请Receipt,ServiceClientReceiptApply
     * @access public
     * @param string $param RPC参数(receipt_code)
     * @return string
     */
    public function search($param){
        try{
            $result = $param;
            return wms_get_rpc_result(0,$result);
        }catch(Exception $e){
            return wms_get_rpc_result(1,"",$e->getMessage());
        }
    }
}