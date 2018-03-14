<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 12/3/18
 * Time: PM2:47
 */

namespace backend\components;


use yii\base\Behavior;

class A extends Behavior
{
    public $aname = 'This is A';
    public function callA()
    {
        var_dump(__METHOD__);
    }
}