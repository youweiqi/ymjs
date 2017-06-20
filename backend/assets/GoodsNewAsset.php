<?php

namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\View;

class GoodsNewAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/statics';
    public $css = [
        'goods/css/newgoods.css',
    ];

    public $js = [
//        'goods/js/handlebars.min.js',
//        'goods/js/newgoods.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
    public $jsOptions = [
        'position' => View::POS_HEAD
    ];

}
