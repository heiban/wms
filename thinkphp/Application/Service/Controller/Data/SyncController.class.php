<?php
namespace Server\Controller\Data;

use Common\Base\BaseRpcController;

class SyncController extends BaseRpcController{

    private $passInfo;
    public function _init($passInfo){
        $this->passInfo=$passInfo;
    }

    


}