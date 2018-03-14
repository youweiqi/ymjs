<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 7/3/18
 * Time: PM5:48
 */

namespace backend\assets;


use yii\web\AssetBundle;

class TestAsset extends AssetBundle
{

    /*
     * css  文件在web 可以直接访问的目录下面 设置 basePath  和  baseUrl
     */
   public $basePath = '@webroot';
   public $baseUrl = '@web';
    //public $sourcePath = 'common/widgets';

   public $css = [
       'css/site_test.css',
       //'common.css'
   ];
}