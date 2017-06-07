<?php
/**
 * Created by PhpStorm.
 * User: suns
 * Date: 2017/3/14
 * Time: 下午6:12
 */

namespace console\controllers;
use backend\modules\finance\models\search\RefundSearch;
use common\models\QueueTasks;
use yii\console\Controller;
use backend\modules\order\models\search\OrderDetailSearch;
use backend\modules\member\models\search\CUserSearch;
use Yii;
class TaskController extends Controller
{

    public function actionExport()
    {
        ini_set('memory_limit', '512M');

        \Yii::$app->amqp->consume("yugou_exchange","export_queue","export_routing_key",
            function($payload){
                $this->runTask($payload);
            });
    }

    public function runTask($payload)
    {
        $task = json_decode($payload->getBody(),1);
        $this->reconnectDb();
        $queueTask = QueueTasks::findOne($task['task_id']);
        if(!$queueTask)
        {
            echo "task_id:\t".$task['task_id']."\t not find !!!\n";
            return;
        }
        switch ($queueTask->task_type)
        {
            case 1:{ //订单导出任务
                $result = (new OrderDetailSearch())->doExport(QueueTasks::dropDown('task_type',$queueTask->task_type),$task["task_content"]);
                break;
            }
            case 2:{//财务退款订单导出
                $result = (new RefundSearch())->doExport(QueueTasks::dropDown('task_type',$queueTask->task_type),$task["task_content"]);
                break;
            }
            default:{
                echo "task_id:\t".$queueTask->task_id."\thave no action !!!\n";
                return;
            }

        }
        if($result[0]) //成功
        {
            $queueTask->task_status = 2;
        }else{//失败
            $queueTask->task_status = 3;
        }
        $queueTask->task_result = $result[1];
        $queueTask->over_time = date("Y-m-d H:i:s");
        $queueTask->save();
        echo "task_id:\t".$queueTask->task_id."\tover !!!\n";
    }
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