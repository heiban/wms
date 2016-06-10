<?php
namespace Service\Controller\Client;

use Common\Base\BaseRpcController;
use Common\Service\IngoodsService;
use Common\Service\ReceiptService;
use Common\Service\TraceService;
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
    public function apply($param){
        try{
            $user = $this->_getPassportUser();
            $receiptService = new ReceiptService();
            $receiptCode = wms_get_valid_param($param,"receipt_code");
            $receiptStatus = wms_get_valid_param($param,"receipt_status");
            $condition = array("receipt_code"=>$receiptCode,"user_code"=>$user["user_code"]);
            $data = array("receipt_status" => $receiptStatus);
            $receipt = $receiptService->getItem($condition);
            if(!empty($receipt) && ( !empty($receipt["receipt_dcode"]) || !empty($receipt["receipt_dcode2"]) )){
                $condition = array("receipt_code"=>$receiptCode,"user_code"=>$user["user_code"]);
                $result = $receiptService->applySync($condition,$data);
            }else{
                throw new Exception("参数有误!");
            }
            return wms_get_rpc_result(0,$result);
        }catch(Exception $e){
            return wms_get_rpc_result(1,"",$e->getMessage());
        }
    }
    /**
     * 查询Receipt,ServiceClientReceiptSearch
     * @access public
     * @param string $param RPC参数(receipt_code|null)
     * @return string
     */
    public function search($param){
        try{
            $user = $this->_getPassportUser();
            $receiptService = new ReceiptService();
            $receiptCode = $param["receipt_code"];

            if(isset($receiptCode)){
                $condition = array("receipt_code"=>$receiptCode,"user_code"=>$user["user_code"]);
                $result = $receiptService->getItem($condition);
                if(empty($result)){
                    throw new Exception("参数有误!");
                }else{
                    $ingoodsService = new IngoodsService();
                    $result["ingoods_list"] = $ingoodsService->getList($condition);
                }
            }else{
                $condition = array("user_code"=>$user["user_code"]);
                $receiptType = $param["receipt_type"];
                if(isset($receiptType)){
                    if($receiptType==0){
                        $condition = array_merge($condition,array("needsync"=>0));
                    }
                    if($receiptType==1){
                        $condition = array_merge($condition,array(
                            "needsync"=>array("in","1,2")
                        ));

                    }
                }

                $result = $receiptService->getList($condition);
            }
            return wms_get_rpc_result(0,$result);
        }catch(Exception $e){
            return wms_get_rpc_result(1,"",$e->getMessage());
        }
    }

    /**
     * 删除Receipt,ServiceClientReceiptDelete
     * @access public
     * @param string $param RPC参数(receipt_code)
     * @return string
     */
    public function del($param){
        try{
            $user = $this->_getPassportUser();
            $receiptService = new ReceiptService();
            $condition = array(
                "receipt_code"  =>  wms_get_valid_param($param,"receipt_code"),
                "user_code"     =>  wms_get_valid_param($user,"user_code"),
                );
            $result = $receiptService->delItem($condition);
            if(empty($result)){
                throw new Exception("删除入仓订单失败!");
            }
            return wms_get_rpc_result(0,$result);
        }catch(Exception $e){
            return wms_get_rpc_result(1,"",$e->getMessage());
        }
    }


    /**
     * 申请Receipt,ServiceClientReceiptCreate
     * @access public
     * @param string $param RPC参数(receipt_dcode,receipt_dcode2,receipt_status,receipt_infor,ingoods_list)
     * @return string
     */
    public function create($param){

        try{

            $user = $this->_getPassportUser();
            $receiptService = new ReceiptService();
            $traceService = new TraceService();
            $data = array(
                "user_code" => wms_get_valid_param($user,"user_code"),
                "trace_code" => $traceService->register(),
                "receipt_dcode" => wms_get_valid_param($param,"receipt_dcode"),
                "receipt_dcode2" => wms_get_valid_param($param,"receipt_dcode2"),
            );
            $receiptCode = $receiptService->register($data);
            if(!empty($receiptCode)){
                $ingoodsList = wms_get_valid_param($param,"ingoods_list");
                $ingoodsService = new IngoodsService();
                $exceptionIngoods = array();
                foreach ($ingoodsList as $ingoodsItem){
                    $ingoodsItem["user_code"] = wms_get_valid_param($user,"user_code");
                    $ingoodsItem["receipt_code"] = $receiptCode;
                    $ingoodsItem["trace_code"] = $traceService->register();
                    $result = $ingoodsService->register($ingoodsItem);
                    if(empty($result)) {
                        array_push($exceptionIngoods, $ingoodsItem);
                    }
                }
                $result = (count($exceptionIngoods)==0);
                if(!$result){
                    throw new Exception("创建入仓订单成功,但其中货品保存失败!");
                }
            }else{
                throw new Exception("创建入仓订单失败!");
            }
            return wms_get_rpc_result(0,$result);
        }catch (Exception $e){
            return wms_get_rpc_result(1,"",$e->getMessage());
        }
    }
    //
    /**
     * 修改Receipt,ServiceClientReceiptUpdate
     * @access public
     * @param string $param RPC参数(receipt_code,ingoods_list)
     * @return string
     */
    public function update($param){
        try{
            $user = $this->_getPassportUser();
            $userCode = wms_get_valid_param($user,"user_code");
            $receiptCode = wms_get_valid_param($param,"receipt_code");
            $receipt_dcode = $param["receipt_dcode"];
            $receipt_dcode2= $param["receipt_dcode2"];
            $receiptService = new ReceiptService();
            $condition = array(
                "receipt_code"=>$receiptCode,
                "user_code"=>$userCode,
                );

            $receipt = $receiptService->getItem($condition);

            if(!empty($receipt)){

                if($receipt["receipt_dcode"]!=$receipt_dcode || $receipt["receipt_dcode2"]!=$receipt_dcode2 ){
                    $data = array("receipt_dcode"=>$receipt_dcode,"receipt_dcode2"=>$receipt_dcode2);
                    $result = $receiptService->updateItem($data,$condition);
                    if(empty($result)){
                        throw new Exception("更改入仓订单时,更新物流单1,2信息未成功,其余操作终止,请注意!");
                    }
                    $receipt["receipt_dcode"]   =   $receipt_dcode;
                    $receipt["receipt_dcode2"]  =   $receipt_dcode2;
                }
                
                $ingoodsService = new IngoodsService();
                $traceService = new TraceService();
                $condition = array(
                    "receipt_code"=>$receiptCode,
                    "user_code"=>$userCode,
                );
                $oldIngoodsList = $ingoodsService->getList($condition);

                $newIngoodsList = wms_get_valid_param($param,"ingoods_list");
                $newIngoodsCodeList = array();
                $delIngoodsCodeList = array();
                $exceptionIngoods = array();
                foreach ($newIngoodsList as $newIngoodsItem){
                    if(!empty($newIngoodsItem["ingoods_code"])){
                        array_push($newIngoodsCodeList,$newIngoodsItem["ingoods_code"]);
                    }else{
                        //添加新ingoodsItem
                        $newIngoodsItem["user_code"] = $userCode;
                        $newIngoodsItem["receipt_code"] = $receiptCode;
                        $newIngoodsItem["trace_code"] = $traceService->register();
                        $result = $ingoodsService->register($newIngoodsItem);
                        if(empty($result)) {
                            array_push($exceptionIngoods, $ingoodsItem);
                        }
                    }
                }
                if(count($exceptionIngoods)>0){
                    throw new Exception("更改入仓订单时,新增的商品数据未添加成功,其余操作终止,请注意!");
                }
                foreach ($oldIngoodsList as $oldIngoodsItem){
                    if( !in_array( $oldIngoodsItem["ingoods_code"],$newIngoodsCodeList)){
                        array_push($delIngoodsCodeList,$oldIngoodsItem["ingoods_code"]);
                    }
                }
                $condition["ingoods_code"] = array("IN",implode(",",$delIngoodsCodeList));
                $result = $ingoodsService->delItem($condition);
                if(empty($result)){
                    throw new Exception("更改入仓订单时,之前的商品数据未删除成功!");
                }
                return wms_get_rpc_result(0,$result);
            }else{
                throw new Exception("不存在该入仓申请单!");
            }
        }catch (Exception $e){
            return wms_get_rpc_result(1,"",$e->getMessage());
        }
    }

    /*
    //创建Receipt,ServiceClientReceiptCreate
    public function create($param){
        try{
            $user = $this->_getPassportUser();
            $receiptService = new ReceiptService();
            $traceService = new TraceService();
            $param["user_code"] = wms_get_valid_param($user,"user_code");
            $param["trace_code"] = $traceService->register();
            $receiptCode = $receiptService->register($param);
            if(!empty($receiptCode)){
                $result = array("receipt_code"=>$receiptCode);
            }else{
                throw new Exception("创建入仓订单失败!");
            }
            return wms_get_rpc_result(0,$result);
        }catch (Exception $e){
            return wms_get_rpc_result(1,"",$e->getMessage());
        }
    }
        //创建Ingoods,ServiceClientReceiptAddgoods
    public function addgoods($param){
        try{
            $user = $this->_getPassportUser();
            $ingoodsService = new IngoodsService();
            $traceService = new TraceService();
            $param["user_code"] = wms_get_valid_param($user,"user_code");
            $param["trace_code"] = $traceService->register();
            $ingoodsCode = $ingoodsService->register($param);
            if(isset($ingoodsCode)){
                $result = array("ingoods_code"=>$ingoodsCode);
            }else{
                throw new Exception("创建入仓货品失败!");
            }
            return wms_get_rpc_result(0,$result);
        }catch (Exception $e){
            return wms_get_rpc_result(1,"",$e->getMessage());
        }
    }

    //删除Ingoods,ServiceClientReceiptDelgoods
    public function delgoods($param){
        try{
            $user = $this->_getPassportUser();
            $userCode = wms_get_valid_param($user,"user_code");
            $receiptCode = wms_get_valid_param($param,"receipt_code");
            $ingoodsCode = wms_get_valid_param($param,"ingoods_code");
            $ingoodsService = new IngoodsService();
            $condition = array(
                "user_code"=>$userCode,
                "receipt_code"=>$receiptCode,
                "ingoods_code"=>$ingoodsCode,
            );
            $result = $ingoodsService->delItem($condition);
            if(!$result){
                throw new Exception("删除操作失败!");
            }
            return wms_get_rpc_result(0,$result);
        }catch (Exception $e){
            return wms_get_rpc_result(1,"",$e->getMessage());
        }
    }
    */
}