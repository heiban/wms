<?php
namespace Common\Base;

use Common\Service\PassportService;
use Think\Controller\RpcController;
use Think\Exception;
/**
 * Created by PhpStorm.
 * User: wanghui
 * Date: 16/5/21
 * Time: 23:31
 */

class BaseRpcController extends RpcController{
    /**
     * 构造函数
     * @access public
     */
    private $_passInfo;
    public function _initialize(){
        $passportService = new PassportService();
        $this->_passInfo = $passportService->status();
        if (method_exists($this, '_init')) {
            $this->_init($this->_passInfo);
        }
    }
    public function _getPassportUser(){
        if(empty($this->_passInfo)){
            throw new Exception("当前用户未登陆!");
        }
        return $this->_passInfo;
    }
}