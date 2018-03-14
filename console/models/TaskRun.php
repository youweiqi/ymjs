<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 23/1/18
 * Time: PM2:21
 */

namespace console\models;
use \common\components\Common;
use \common\models\RedeemCode;
use Yii;



class TaskRun
{
    private $_client;
    public function receive($ser, $fd, $fromId, $data)
    {

    }

    public function task($ser,$taskId,$fromId,$data)
    {
        require_once __DIR__ . "/TaskClient.php";
        $TaskClient = new TaskClient();
        try{
            switch ($data['event'])
            {
                //邮件发送类
                case $TaskClient::EVENT_TYPE_SEND_MAIL:
                //    $mailer = new Mailer();
                //    $result = $mailer->sendMail($data);
                //    break;
                //新增兑换码
                case $TaskClient::EVENT_TYPE_SEND_REDEEM:
                //case 'send-redeem':
                    $data_array = [];
                   for ($i=0;$i<$data['i'];$i++)
                   {
                       $array['redeem_code'] ='L'.Common::getUid();
                       $array['promotion_id'] =$data['promotion_id'];
                       $array['used_times'] =$data['used_times'];
                       $array['usable_times'] =$data['usable_times'];
                       $array['creater'] =$data['creater'];
                       $array['remark'] =$data['remark'];
                       $array['start_date'] =$data['start_date'];
                       $array['end_date'] =$data['end_date'];
                       $array['status'] =$data['status'];
                       $data_array[] =$array;
                   }
                $result = Yii::$app->db->createCommand()->batchInsert(RedeemCode ::tableName(), ['promotion_id', 'used_times','usable_times','creater','remark','start_date','end_date','status'], $data_array)->execute();
                    break;
                default:
                    break;
            }
            return $result;
           }catch (\Exception $e){
               throw  new \Exception('task exception :'.$e->getMessage());
        }


    }
    //入队成功后返回结果
    public function finish ($ser,$taskId,$data)
    {
        return $taskId.true;
    }

}