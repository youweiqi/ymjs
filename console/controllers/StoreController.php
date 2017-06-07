<?php

namespace console\controllers;

use console\libraries\migration\StoreLib;
use Yii;
use yii\console\Controller;

/*
 * 店铺处理控制器
 * Email ：codeloving@qq.com
 */
class StoreController extends Controller
{
    /*
     * 老预购的店铺进行迁移
     */
    public function actionMigration()
    {
        set_time_limit(0);
        StoreLib::run();
        return static::EXIT_CODE_NORMAL;
    }

}
