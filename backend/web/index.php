<?php
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require(__DIR__ . '/../../vendor/autoload.php');
require(__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/../../common/config/bootstrap.php');
require(__DIR__ . '/../../common/config/constants.php');
require(__DIR__ . '/../config/bootstrap.php');

$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../common/config/main.php'),
    require(__DIR__ . '/../../common/config/main-local.php'),
    require(__DIR__ . '/../config/main.php'),
    require(__DIR__ . '/../config/main-local.php')
);

//print_r(__DIR__);exit();//   __DIR__=>  /data/webapp/Oms/backend/web  项目根目录
$app =new yii\web\Application($config);

Yii::$app->on(yii\base\Application::EVENT_BEFORE_REQUEST, function ($event) {
    Yii::info('This is beforeRequest event.');
});
Yii::$app->on(yii\base\Application::EVENT_AFTER_REQUEST, function ($event) {
    Yii::info('This is afterRequest event.');
});

$app->run();