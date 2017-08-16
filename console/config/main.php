<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',
    'components' => [
        'kafka' => [
            'class' => 'common\components\Kafka',
            'broker_host' => '127.0.0.1:9092',
            'topic' => 'kafka',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info'], // 日志等级
                    'categories' =>['test_kafka'],//分类
                    'logVars' => [],// 被收集记录的额外数据
                    'logFile' =>'@app/runtime/logs/kafka/info.log'// 指定日志保存的文件名

                ]
            ],
        ],
        'session' => [ // for use session in console application
            'class' => 'yii\web\Session'
        ],
    ],
    'controllerMap' => [
        'migrate' => [
            'class' => 'e282486518\migration\ConsoleController',
        ],
    ],
    'params' => $params,
];
