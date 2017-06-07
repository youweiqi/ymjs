<?php
namespace console\libraries;
/**
 * Created by PhpStorm.
 * User: suns
 * Date: 2017/3/16
 * Time: 上午11:48
 */
use Yii;
class StoreFileLib
{
    public static function saveToCsvFile($prefix,$count, $limit, array $title, callable $callback)
    {
        $path = Yii::getAlias("@csv_dir_path");
        if($prefix) {
            $filename = $prefix . date("Y-m-d H:i:s") . substr(md5(time()),0,5). ".csv";
        }else{
            $filename =  date("Y-m-d H:i:s") . '=' . substr(md5(time()),0,5). ".csv";
        }

        if(!file_exists($path)) //创建存储目录
        {
            mkdir($path);
        }
//        file_put_contents($path.$filename, iconv("UTF-8","GB2312",implode(',',$title)."\n"),FILE_APPEND);
        file_put_contents($path.$filename, "\xEF\xBB\xBF".implode(',',$title)."\n",FILE_APPEND);
        $page = ceil($count/$limit);
        for($i = 1; $i<=$page; $i++)
        {
            $pageContent = "";
            $pageData = $callback($i,$limit);
            foreach ($pageData as $line)
            {
//                $pageContent .= mb_convert_encoding (str_replace(["\n","\x0D"],'',implode(',',$line)),"GB2312","UTF-8")."\n";
                $pageContent .= str_replace(["\n","\x0D"],'',implode(',',$line))."\n";
            }
            if($pageContent !== "")
            {
                file_put_contents($path.$filename,$pageContent,FILE_APPEND);
            }
        }
        return $filename;
    }

}