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
   /* 'defaultRoute' => 'goods/index',
    'as beforeRequest' => [
        'class' => 'yii\filters\AccessControl',
        'rules' => [
            [
                'allow' => true,
                'actions' => ['login'],
                'roles' => ['?'],
            ],
            [
                'allow' => true,
                'roles' => ['@'],
            ],
        ],
        'denyCallback' => function () {
            return Yii::$app->response->redirect(['site/login']);
        },
    ],*/
   /*
    *
    */
    'components' => [
        /*'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'true',     //  就是这里了
        ],*/

        'response' => [
            'class' => 'yii\web\Response',
            //'cookieValidationKey' => 'true',
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
        ],
        'user' => [
            'identityClass' => 'common\models\ApiUsers',
            'enableAutoLogin' => true,
            'enableSession'=>false,
            'loginUrl' => null,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
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
                    'controller' => ['v1/goods','v1/user'],
                     'extraPatterns' => [
                             'POST login' => 'login',
                             'GET signup-test' => 'signup-test',
                             'GET user-profile' => 'user-profile',
                     ]
                ],
            ],
        ],
    ],
    'params' => $params,
];
