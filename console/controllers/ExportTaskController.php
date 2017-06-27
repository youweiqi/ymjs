<?php
/**
 * Created by PhpStorm.
 * User: suns
 * Date: 2017/3/14
 * Time: 下午6:12
 */

namespace console\controllers;

use backend\modules\finance\models\search\UserJournalsSearch;
use backend\modules\goods\models\search\GoodsApiSearch;
use backend\modules\goods\models\search\GoodsSearch;
use backend\modules\goods\models\search\ProductSearch;
use backend\modules\order\models\search\OrderDetailSearch;
use common\models\Product;
use common\models\QueueTasks;
use Yii;

/**
 * 导出任务命令
 * Class NewTaskController
 * @package console\controllers
 */
class ExportTaskController extends BaseController
{
    public $queueTask;
    /**
     * 订单导出|1|  nohup php ./yii export-task/order-export >> log/1order-export.log 2>&1 &
     * @return mixed
     */
    public function actionOrderExport()
    {
        \Yii::$app->amqp->consume("ayn_exchange","export_1_queue_ayn","export_1_routing_key_ayn",
            function ($payload)
            {
                $task_content = $this->taskBefore($payload);
                if($task_content == false)
                {
                    return ;
                }
                $result = (new OrderDetailSearch())->doExport(QueueTasks::dropDown('task_type',$this->queueTask->task_type),$task_content);
                $this->taskAfter($result);
            });
    }
    /**
     * 导出分佣记录|2|  nohup php ./yii export-task/commision-export >> log/2commision-export.log 2>&1 &
     * @return mixed
     */
    public function actionCommisionExport()
    {
        \Yii::$app->amqp->consume("xz_exchange","export_2_queue","export_2_routing_key",
            function ($payload)
            {
                $task_content = $this->taskBefore($payload);
                if($task_content == false)
                {
                    return ;
                }
                $result = (new CommisionSearch())->doExport(QueueTasks::dropDown('task_type',$this->queueTask->task_type),$task_content);
                $this->taskAfter($result);
            });
    }
    /**
     * 导出妆币流水表|3|  nohup php ./yii export-task/member-journal-export >> log/3member-journal-export.log 2>&1 &
     * @return mixed
     */
    public function actionMemberJournalExport()
    {
        \Yii::$app->amqp->consume("xz_exchange","export_3_queue","export_3_routing_key",
            function ($payload)
            {
                $task_content = $this->taskBefore($payload);
                if($task_content == false)
                {
                    return ;
                }
                $result = (new UserJournalsSearch())->doExport(QueueTasks::dropDown('task_type',$this->queueTask->task_type),$task_content);
                $this->taskAfter($result);
            });
    }

    /**
     * 导出API商品列表|4|  nohup php ./yii export-task/goods-api-export >> log/4goods-c-export.log 2>&1 &
     * @return mixed
     */
    public function actionGoodsApiExport()
    {
        \Yii::$app->amqp->consume("ayn_exchange","export_4_queue_ayn","export_4_routing_key_ayn",
            function ($payload)
            {
                $task_content = $this->taskBefore($payload);
                if($task_content == false)
                {
                    return '';
                }
                $result = (new GoodsApiSearch())->doExport(QueueTasks::dropDown('task_type',$this->queueTask->task_type),$task_content);
                $this->taskAfter($result);
            });
    }
    /**
     * 导出商品|5|  nohup php ./yii export-task/goods-export >> log/5goods-export.log 2>&1 &
     * @return mixed
     */
    public function actionGoodsExport()
    {
        \Yii::$app->amqp->consume("ayn_exchange","export_5_queue_ayn","export_5_routing_key_ayn",
            function ($payload)
            {
                $task_content = $this->taskBefore($payload);
                if($task_content == false)
                {
                    return ;
                }
                $result = (new GoodsSearch())->doExport(QueueTasks::dropDown('task_type',$this->queueTask->task_type),$task_content);
                $this->taskAfter($result);
            });
    }
    /**
     * 导出妆币快照列表|6|  nohup php ./yii export-task/member-money-snapshot-export >> log/6member-money-snapshot-export.log 2>&1 &
     * @return mixed
     */
    public function actionMemberMoneySnapshotExport()
    {
        \Yii::$app->amqp->consume("xz_exchange","export_6_queue","export_6_routing_key",
            function ($payload)
            {
                $task_content = $this->taskBefore($payload);
                if($task_content == false)
                {
                    return ;
                }
                $result = (new MemberMoneySnapshotSearch())->doExport(QueueTasks::dropDown('task_type',$this->queueTask->task_type),$task_content);
                $this->taskAfter($result);
            });
    }

    /**
     * 导出妆币流水归档|7|  nohup php ./yii export-task/member-journal-export >> log/7member-journal-export.log 2>&1 &
     * @return mixed
     */
    public function actionArchiveMemberJournalExport()
    {
        \Yii::$app->amqp->consume("xz_exchange","export_7_queue","export_7_routing_key",
            function ($payload)
            {
                $task_content = $this->taskBefore($payload);
                if($task_content == false)
                {
                    return ;
                }
                $result = (new ArchiveMemberJournalExport())->doExport(QueueTasks::dropDown('task_type',$this->queueTask->task_type),$task_content);
                $this->taskAfter($result);
            });
    }

    /**
     * 导出妆币快照汇总列表|8|  nohup php ./yii export-task/member-money-summary-export >> log/8member-money-summary-export.log 2>&1 &
     * @return mixed
     */
    public function actionMemberMoneySummaryExport()
    {
        \Yii::$app->amqp->consume("xz_exchange","export_8_queue","export_8_routing_key",
            function ($payload)
            {
                $task_content = $this->taskBefore($payload);
                if($task_content == false)
                {
                    return ;
                }
                $result = (new MemberMoneySummaryExport($task_content))->doExport(QueueTasks::dropDown('task_type',$this->queueTask->task_type));
                $this->taskAfter($result);
            });
    }

    /**
     * 导出提现记录|9|  nohup php ./yii export-task/with-draw-cash-export  >> log/9with-draw-cash-export.log 2>&1 &
     * @return mixed
     */
    public function actionWithdrawCashExport()
    {
        \Yii::$app->amqp->consume("xz_exchange","export_9_queue","export_9_routing_key",
            function ($payload)
            {
                $task_content = $this->taskBefore($payload);
                if($task_content == false)
                {
                    return ;
                }
                $result = (new WithdrawCashSearch())->doExport(QueueTasks::dropDown('task_type',$this->queueTask->task_type),$task_content);
                $this->taskAfter($result);
            });
    }

    /**
     * 讲师佣金统计|10|  nohup php ./yii export-task/statement-export >> log/10statement-export.log 2>&1 &
     * @return mixed
     */
    public function actionStatementExport()
    {
        \Yii::$app->amqp->consume("xz_exchange","export_10_queue","export_10_routing_key",
            function ($payload)
            {
                $task_content = $this->taskBefore($payload);
                if($task_content == false)
                {
                    return ;
                }
                $result = (new StatementSearch())->doExport(QueueTasks::dropDown('task_type',$this->queueTask->task_type),$task_content);
                $this->taskAfter($result);
            });
    }






    //任务标记为执行中 解析队列数据返回
    public function taskBefore($payload)
    {
        $this->queueTask = null;
        echo $payload->getBody();echo "\n";
        $task = json_decode($payload->getBody(),1);
        $this->reconnectDb();
        /** @var QueueTasks $queueTask */
        $this->queueTask = QueueTasks::findOne($task['task_id']);
        echo "task type: ".$this->queueTask->task_type."\n";
        if(!$this->queueTask)
        {
            echo "task_id:\t".$task['task_id']."\t not find !!!\n";
            return false;
        }
        $this->queueTask->task_status = 1;
        $this->queueTask->save();
        return $task['task_content'];
    }


    //处理任务结果
    public function taskAfter($result)
    {
        $this->reconnectDb();
        if($result[0]) //成功
        {
            $this->queueTask->task_status = 2;
        }else{//失败
            $this->queueTask->task_status = 3;
        }
        $this->queueTask->task_result = $result[1];
        $this->queueTask->over_time = date("Y-m-d H:i:s");
        $this->queueTask->save();
        echo "task_id:\t".$this->queueTask->task_id."\tover !!!\n";
    }}