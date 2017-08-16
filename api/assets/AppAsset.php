<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/';
    public $css = [
        'css/buttons/buttons.css',
        'css/bootstrap/bootstrap.min.css',
        'css/main.css',
        'css/style.css',
        'js/responsive-nav/responsive-nav.css',
        'js/bootstrap-switch/css/bootstrap3/bootstrap-switch.css',
        'js/messenger/css/messenger.css',
        'js/messenger/css/messenger-theme-flat.css',
        'js/swiper/swiper-3.3.1.min.css',
    ];

    public $js = [
        ['js/jquery.js','position'=>\Yii\web\View::POS_HEAD],
        'js/bootstrap/bootstrap.min.js',
        'js/responsive-nav/responsive-nav.min.js',
        'js/bootstrap-switch/js/bootstrap-switch.min.js',
        'js/iCheck/icheck.min.js',
        'js/public.js',
        'js/messenger/js/messenger.min.js',
        ['js/swiper/swiper-3.3.1.min.js','position'=>\Yii\web\View::POS_HEAD],
        ['js/html5shiv.min.js' ,'condition' => 'lt IE9','position'=>\Yii\web\View::POS_HEAD],
        ['js/respond.min.js' ,'condition' => 'lt IE9','position'=>\Yii\web\View::POS_HEAD],


    ];
      
    public $depends = [
       'yii\web\YiiAsset',
       'yii\bootstrap\BootstrapAsset',
    ];


}
