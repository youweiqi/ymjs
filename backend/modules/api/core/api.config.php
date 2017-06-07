<?php
$config = [
    'bootstrap' => [
        [
            'class' => 'yii\filters\ContentNegotiator',
            'formats' => [
                'application/json' => 'json',
                'application/xml' => 'xml',
            ],
            'languages' => [
                'zh-CN',
                'en',
            ],
        ]
    ],
    'components' => [
        'response' =>  [
            'class' => 'yii\web\Response',
            'on beforeSend' => function ($event) {
                $response = $event->sender;
                $response->data = [
                    'code' => $response->getStatusCode(),
                    'message' => $response->statusText,
                    'data' => $response->data,
                ];
                $response->format = yii\web\Response::FORMAT_JSON;
            }
        ],
        'errorHandler' => [
            'class'=>'backend\modules\api\core\ErrorHandler'
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                //模块化的路径
                "GET,POST,PUT,DELETE <module>/<controller:[\w-]+>/<action:[\w-]+>" => "<module>/<controller>/<action>",
                //基本路径
                "GET,POST,PUT,DELETE <controller:[\w-]+>/<action:[\w-]+>" => "<controller>/<action>",
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['api/goods'],
                    'extraPatterns' => [
                        'POST receive' => 'receive',
                    ]
                ],
            ],
        ],
        'request' => [
            'class' => '\yii\web\Request',
            'enableCookieValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
                'text/json' => 'yii\web\JsonParser',
            ],
        ],
    ],
];

return $config;
