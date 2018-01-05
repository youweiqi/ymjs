<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    /* 控制器默认命名空间 */
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    /**
     * 模块
     */
    'modules' => [
        'admin' => [
            'class' => 'backend\modules\admin\Module',
        ],
        'goods' => [
            'class' => 'backend\modules\goods\Module',
        ],
        'warehouse' => [
            'class' => 'backend\modules\warehouse\Module',
        ],
        'order' => [
            'class' => 'backend\modules\order\Module',
        ],
        'member' => [
            'class' => 'backend\modules\member\Module',
        ],
        'content' => [
            'class' => 'backend\modules\content\Module',
        ],
        'discount' => [
            'class' => 'backend\modules\discount\Module',
        ],
        'aftersale' => [
            'class' => 'backend\modules\aftersale\Module',
        ],
        'finance' => [
            'class' => 'backend\modules\finance\Module',
        ],
        'thirdparty' => [
            'class' => 'backend\modules\thirdparty\Module',
        ],
        'api' => [
            'class' => 'backend\modules\api\Module',
        ],
        'v1' => [
            'class' => 'backend\modules\v1\Module',
        ],
        'tgtools' => [
            'class' => 'backend\modules\tgtools\Module'
        ],
        
    ],
//    'on beforeRequest' => function($event) {
//        \yii\base\Event::on(\yii\db\BaseActiveRecord::className(), \yii\db\BaseActiveRecord::EVENT_AFTER_INSERT, ['common\components\Log', 'write']);
//        \yii\base\Event::on(\yii\db\BaseActiveRecord::className(), \yii\db\BaseActiveRecord::EVENT_AFTER_UPDATE, ['common\components\Log', 'write']);
//        \yii\base\Event::on(\yii\db\BaseActiveRecord::className(), \yii\db\BaseActiveRecord::EVENT_AFTER_DELETE, ['common\components\Log', 'write']);
//    },
    /* 默认路由 */
    'defaultRoute' => 'index',
    /* 默认布局文件 优先级 控制器>配置文件>系统默认 */
    'layout' => 'main',
    /**
     * 组件
     */
    'components' => [
        'session'=> [
                'class' => 'yii\redis\Session',
                'redis' => [
                 'hostname' => 'localhost',
                 'port' => 6379,
                 'database' => 3,
             ],
                'keyPrefix'=>'shop_'
        ],

        'cache' => [
            'class' => 'yii\redis\Cache',
            'redis' => [
                 'hostname' => 'localhost',
                 'port' => 6379,
                 'database' => 2,
              ]
        ],

        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => '127.0.0.1',
            'port' => 6379,
            'database' => 0,
        ],
        'elasticsearch' => [
            'class' => 'yii\elasticsearch\Connection',
            'nodes' => [
                ['http_address' => '127.0.0.1:9200'],
                // configure more hosts if you have a cluster
            ],
        ],
        /* 七牛上传图片 */
        'qiniu' => [
            'class' => 'common\components\QiNiuU'
        ],
        'logger' => [
            'class' => 'common\components\Log',
        ],
        /* 身份认证类 默认yii\web\user */
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'backend\models\Admin',
            'enableAutoLogin' => true,
            'loginUrl' => ['login/login'], //默认登录url
        ],
        /* 身份认证类 默认yii\web\user */
        'user_api' => [
            'class' => 'yii\web\User',
            'identityClass' => 'common\models\ApiUsers',
            'enableAutoLogin' => true,
            'enableSession'=>false
            //'loginUrl' => ['login/login'], //默认登录url
        ],
        /* 修改默认的request组件 */
        'request' => [
            'class' => 'common\core\Request',
            'enableCsrfValidation' => false,
            'baseUrl' => Yii::getAlias('@backendUrl'), //等于 Yii::getAlias('@web')
        ],
        /* 数据库RBAC权限控制 */
        'authManager' => [
            'class' => 'common\core\rbac\DbManager',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,

            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class' => 'common\components\FileTarget',
                    // 日志等级
                    'levels' => ['info'],
                    // 被收集记录的额外数据
                    'logVars' => [],
                    // 指定日志保存的文件名
                    'logFile' => '@app/runtime/logs/info/app.log',
                    // 是否开启日志 (@app/runtime/logs/api/20151223_app.log)
                    'enableDatePrefix' => true,
                    'maxFileSize' => 1024 * 10,
                    'maxLogFiles' => 15,
                ],
            ],
        ],

        'errorHandler' => [
            //'errorAction' => 'public/404',
        ],

        /* 链接管理 */
        'urlManager' => [
            //'class' => 'common\core\UrlManager',
            'enablePrettyUrl' => true, //开启url规则
            'showScriptName' => false, //是否显示链接中的index.php
            'enableStrictParsing' =>false,//是否严格解析
            //'suffix' => '.html', //后缀
            'rules' => [
                'class' => 'yii\rest\UrlRule',
               // 'controller' => ['v1/app-users'],
              //  'extraPatterns' => [
               //     'POST login' => 'login',
               //     'GET signup-test' => 'signup-test',
              //  ]
                //'controller' => ['goods']
            ],
        ],
    ],
    /**
     * 该属性允许你用一个数组定义多个 别名 代替 Yii::setAlias()
     */
    'aliases' => [],
    /**
     * 通过配置文件附加行为，全局
     */
    'as rbac' => [
        'class' => 'backend\behaviors\RbacBehavior',
        'allowActions' => [
            // 不需要权限检测
            'login/login','login/logout','public*','debug/*','gii/*',
            'api/*','v1/*'
        ]
    ],

    'params' => $params,
]
;
