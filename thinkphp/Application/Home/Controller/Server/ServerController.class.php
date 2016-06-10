<?php
/**
 * Created by PhpStorm.
 * User: wanghui
 * Date: 16/5/15
 * Time: 18:38
 */

namespace Home\Controller\Server;


use Think\Controller\RpcController;

class ServerController extends RpcController{
    public function test1(){
        return "test1result";
    }
    public function test2(){
        return "test2result";
    }
    private function test3(){
        return "test3result";
    }
    protected function test4(){
        return "test4result";
    }
}