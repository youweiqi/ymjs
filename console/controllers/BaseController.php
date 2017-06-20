<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;

class BaseController extends Controller
{

    public function beforeAction($action)
    {
        ini_set('memory_limit', '512M');
        set_time_limit(0);
        return parent::beforeAction($action);
    }

    /**
     * 重新连接数据库.
     */
    public function reconnectDb()
    {
        Yii::$app->db->close();
        Yii::$app->db->open();
        Yii::$app->db_order->close();
        Yii::$app->db_order->open();
        Yii::$app->db_goods->close();
        Yii::$app->db_goods->open();
        Yii::$app->db_user->close();
        Yii::$app->db_user->open();
    }
}