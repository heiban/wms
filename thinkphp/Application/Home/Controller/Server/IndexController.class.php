<?php
namespace Home\Controller\Server;

use Think\Controller;
use Think\Upload;
use PHPExcel;
use PHPExcel_IOFactory;

class IndexController extends Controller{
    public function index()
    {
        //echo wms_get_now_datetime();
        $this->exportExcel("testTitle",array("A","B","C"),array(0=>array(1,2,3)));
    }
    public function test(){
        echo wms_get_unique_code("A");
    }

    /**
     * @param $expTitle
     * @param $expCellName
     * @param $expTableData
     */
    public function exportExcel($expTitle, $expCellName, $expTableData){
        $xlsTitle = iconv('utf-8', 'gb2312', $expTitle);//文件名称
        $fileName = $_SESSION['account'].date('_YmdHis');//or $xlsTitle 文件名称可根据自己情况设定
        $cellNum = count($expCellName);
        $dataNum = count($expTableData);
        vendor("PHPExcel.PHPExcel");
        $objPHPExcel = new PHPExcel();

        //$objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$cellName[$cellNum-1].'1');//合并单元格
        //$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle.'  Export time:'.date('Y-m-d H:i:s'));
        $sheet = $objPHPExcel->setActiveSheetIndex(0);
        $sheet->setCellValue('A2', "我叫贝贝");


        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
        header("Content-Disposition:attachment;filename=$fileName.xls");//attachment新窗口打印inline本窗口打印
        vendor("PHPExcel.PHPExcel_IOFactory");
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');//csv,Excel2007,Excel5
        $objWriter->save('php://output');
        exit;
    }

    public function upload(){
        //页面端的参数名是file
        $upload = new Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('xls','xlsx','csv');// 设置附件上传类型
        $upload->rootPath  =     TEMP_PATH; // 设置附件上传根目录
        $upload->savePath  =     ''; // 设置附件上传（子）目录
        // 上传文件
        $info   =   $upload->upload();
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }else{// 上传成功
            //$this->success('上传成功！');
        }
        vendor("PHPExcel.PHPExcel");
        $file_name=TEMP_PATH.$info["file"]['savepath'].$info["file"]['savename'];
        $objReader = PHPExcel_IOFactory::createReader('Excel5');//Excel2007,Excel5
        $objPHPExcel = $objReader->load($file_name,$encode='utf-8');
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow(); // 取得总行数
        $highestColumn = $sheet->getHighestColumn(); // 取得总列
        echo $highestRow." - ".$highestColumn;
        echo $sheet->getCell("A2")->getValue();
    }

}