<?php

namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\View;

class GoodsAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/statics';
    public $css = [
        'goods/css/goods.css',
    ];

    public $js = [
        'goods/js/handlebars.min.js',
        'goods/js/goods.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
    public $jsOptions = [
        'position' => View::POS_HEAD
    ];

}
