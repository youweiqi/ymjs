<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 19/12/17
 * Time: PM5:57
 */

namespace backend\components;


use Yii;
use yii\base\ActionFilter;

class MyBehavior extends ActionFilter
{
    public function beforeAction ($action)
    {
        //var_dump(111);
        return true;
    }



    public function isGuest ()
    {
        return Yii::$app->user->isGuest;
    }
}