<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 1/4/17
 * Time: PM4:43
 */
namespace console\controllers;

use yii\console\Controller;

class KafkaController extends Controller{

    public function actionTest()
    {
        \Yii::$app->kafka->consumer($this,'callback');
    }

    public function callback($message){
        \Yii::info($message,'test_kafka');
        \Yii::$app->log->setFlushInterval(1);
    }

}