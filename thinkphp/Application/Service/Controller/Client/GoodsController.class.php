<?php
namespace Service\Controller\Client;

use Common\Base\BaseRpcController;
use Common\Service\GoodsService;
use Think\Exception;

class GoodsController extends BaseRpcController{

    public function _init($passInfo){
    }

    //查询GOODS,ServiceClientGoodsSearch
    public function search($param){
        try{
            $user = $this->_getPassportUser();
            $goodsCode = $param["goods_code"];
            $goodsService = new GoodsService();
            if(isset($code)){
                $condition = array("goods_code"=>$goodsCode,"user_code"=>$user["user_code"]);
                $result = $goodsService->getItem($condition);
            }else{
                $condition = array("user_code"=>$user["user_code"]);
                $result = $goodsService->getList($condition);
            }
            return wms_get_rpc_result(0,$result);
        }catch(Exception $e){
            return wms_get_rpc_result(1,"",$e->getMessage());
        }
    }


}