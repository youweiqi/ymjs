<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],

    'controllerNamespace' => 'api\controllers',
    'modules' => [
        'v1' => [
            'class' => 'api\modules\v1\Module',
        ],
    ],
    'components' => [
        /*'response' => [
            'class' => 'yii\web\Response',
            'cookieValidationKey' => 'true',
            'on beforeSend' => function ($event) {
                $response = $event->sender;
                $code = $response->getStatusCode();
                $msg = $response->statusText;
                if ($code == 404) {
                    !empty($response->data['message']) && $msg = $response->data['message'];
                }
                $data = [
                    'code' => $code,
                    'msg' => $msg,
                ];
                $code == 200 && $data['data'] = $response->data;
                $response->data = $data;
                $response->format = yii\web\Response::FORMAT_JSON;
            },
        ],*/
        'user' => [
            'identityClass' => 'common\models\ApiUsers',
            'enableAutoLogin' => true,
            'enableSession'=>false,
            'loginUrl' => null,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' =>true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['v1/image'],
                    'extraPatterns' => [
                        'GET test/<image_id:\w+>' => 'test',
                    ]
                ],
            ],
        ],
    ],
    'params' => $params,
];
