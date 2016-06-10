<?php
namespace Service\Controller\Data;

use Common\Service\SkuService;
use Think\Controller\RpcController;
use Think\Exception;

class SkuController extends RpcController{
    //查询SKU,ServiceDataSkuSearch
    public function search($param){
        try{
            $type = $param["type"];
            $word = $param["word"];
            $skuService = new SkuService();
            if($type == "sku_name"){
                $result = $skuService->getList(array("sku_name"=>array("like","%".$word."%")));
            }elseif($type == "sku_barcode"){
                $result = $skuService->getList(array("sku_barcode"=>$word));
            }else{
                throw new Exception("参数不正确!");
            }
            return wms_get_rpc_result(0,$result);
        }catch(Exception $e){
            return wms_get_rpc_result(1,"",$e->getMessage());
        }
    }
}