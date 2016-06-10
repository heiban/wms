<?php
namespace Api\Controller\Data;

use Common\Service\SkuService;
use Think\Controller;
use Think\Exception;

class SkuController extends Controller{
    //查询SKU,ApiDataSkuSearch
    public function search(){
        try{
            $param = array(
                "type"  =>  I('get.type'),
                "word"  =>  I('get.word'),
            );
            $type = wms_get_valid_param($param,"type");
            $word = wms_get_valid_param($param,"word");
            $skuService = new SkuService();

            if($type == "sku_name"){
                $result = $skuService->getList(array("sku_name"=>array("like","%".$word."%")));

            }elseif($type == "sku_barcode"){
                $result = $skuService->getList(array("sku_barcode"=>$word));
            }else{
                throw new Exception("参数不正确!");
            }
            return wms_set_http_result(0,$result);
        }catch(Exception $e){
            return wms_set_http_result(1,"",$e->getMessage());
        }
    }
    public function gencode(){
        echo wms_get_unique_code('S');
    }
}