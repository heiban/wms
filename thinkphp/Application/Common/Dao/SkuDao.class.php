<?php
namespace Common\Dao;
/**
 * Created by PhpStorm.
 * User: wanghui
 * Date: 16/5/21
 * Time: 18:21
 */

/**
 * sku_id
 * sku_code
 * sku_barcode
 * sku_name
 * sku_weight
 * sku_size
 * sku_norms
 * sku_imgurl
 * needsync
 *
 */

class SkuDao{

    /**
     * 构造函数
     * @access public
     */
    public function __construct(){

    }

    //插入
    public function insert($data){
        return M("Sku")->add($data);
    }
    //更新
    public function update($data,$condition){
        return M("Sku")->where($condition)->save($data);
    }
    //查询
    public function query($condition){
        return M("Sku")->where($condition)->find();
    }
    //查询数据列表
    public function queryList($condition){
        return M("Sku")->where($condition)->select();
    }
    //删除用户数据
    public function delete($condition){
        return M("Sku")->where($condition)->delete();
    }
    //查询未同步数据
    public function queryNeedSyncList(){
        return $this->queryList(
            array(
                "needsync"=>1
            )
        );
    }
    //设置为已同步数据
    public function updateNeedSync($codelist){
        return $this->update(
            array(
                "needsync"=>0
            ),
            array(
                'sku_code'=>array('IN',$codelist)
            )
        );
    }
}
