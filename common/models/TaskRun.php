<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 23/1/18
 * Time: PM2:21
 */

namespace common\models;
use \common\components\Common;
use Yii;



class TaskRun
{
    private $_client;
    public function receive($ser, $fd, $fromId, $data)
    {

    }

    public function task($ser,$taskId,$fromId,$data)
    {
        try{
            $result = [];
            switch ($data['event'])
            {
                //邮件发送类
                case TaskClient::EVENT_TYPE_SEND_MAIL:
                       // $mailer = new Mailer();
                       // $result = $mailer->sendMail($data);
                       // break;
                    //新增兑换码
                case TaskClient::EVENT_TYPE_SEND_REDEEM:

                    $limit =500;
                    $page = ceil($data['i']/$limit);//总页数

                  for($i = 1; $i<=$page; $i++) {
                      self::callBack($limit,$data);
                  }
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



    /*
     * 写个回调函数一次性处理500个
     */

    public function callBack($limit,$data)
    {
        $data_array = [];

        for ($i=1;$i<=$limit;$i++)
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
        $result = Yii::$app->db_user->createCommand()->batchInsert(RedeemCode ::tableName(), ['redeem_code','promotion_id', 'used_times','usable_times','creater','remark','start_date','end_date','status'], $data_array)->execute();
    }


}