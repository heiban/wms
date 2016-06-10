<?php
namespace Api\Controller\Data;

use Think\Controller;

class SyncController extends Controller{

    private $passInfo;
    public function _init($passInfo){
        $this->passInfo=$passInfo;
    }

    


}