<?php

namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\View;

class GodGoodsAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/statics';
    public $css = [
        'goods/goods.css',
    ];

    public $js = [
        'goods/handlebars.min.js',
        'goods/god_goods.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
    public $jsOptions = [
        'position' => View::POS_HEAD
    ];

}
