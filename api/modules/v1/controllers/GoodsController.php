<?php

namespace api\modules\v1\controllers;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;

class GoodsController extends ActiveController
{
    public $modelClass = 'common\models\ApiGoods';
    public function behaviors() {
        return ArrayHelper::merge (parent::behaviors(), [
            'authenticator' => [
                'class' => HttpBearerAuth::className(),
                //'tokenParam' => 'token',
            ],
             'corsFilter'  => [
            'class' => Cors::className(),
            'cors'  => [
                'Origin' => ['*'],
                'Access-Control-Request-Headers' => ['authorization'],
            ],
        ]
    ]);
    }

}
