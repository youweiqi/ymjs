<?php

namespace console\controllers;

use console\libraries\migration\BusinessCircleLib;
use Yii;
use yii\console\Controller;

/*
 * 商圈迁移
 * Email ：codeloving@qq.com
 */
class BusinessCircleController extends Controller
{
    /*
     * 老预购的商圈进行迁移
     */
    public function actionMigration()
    {
        set_time_limit(0);
        BusinessCircleLib::run();
        return static::EXIT_CODE_NORMAL;
    }

}
