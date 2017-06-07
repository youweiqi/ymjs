<?php
namespace common\components\PHPExcel;

use PHPExcel_IOFactory;

class Import
{
    public static $err_msg = [];
    public static function getSheetData($file_path)
    {
        $objPHPExcel = PHPExcel_IOFactory::load($file_path);//加载文件
        $data = $objPHPExcel->getSheet(0)->toArray();//读取文件内的第一个sheet的数据
        if(count($data)>1001){
            self::$err_msg[] = '请控制要导入的数据在1000行以内！';
            return false;
        }else{
            return $data;
        }
    }

}