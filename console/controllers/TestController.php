<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 1/4/17
 * Time: PM4:43
 */
namespace console\controllers;

use yii\console\Controller;

class TestController extends Controller{

    public function actionTest()
    {
       $c=\Yii::$app->image->test();
        var_dump($c);exit;
    }

}