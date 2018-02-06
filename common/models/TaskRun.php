<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 23/1/18
 * Time: PM2:21
 */

namespace common\models;


use backend\components\Mailer;

class TaskRun
{
    public function receive($ser, $fd, $fromId, $data)
    {

    }

    public function task($ser,$taskId,$fromId,$data)
    {
        try{
            switch ($data['event'])
            {
                case TaskClient::EVENT_TYPE_SEND_MAIL:
                    $mailer = new Mailer();
                    $result = $mailer->sendMail($data);
                    break;
                default:
                    break;
            }
            return $result;
           }catch (\Exception $e){
               throw  new \Exception('task exception :'.$e->getMessage());
        }


    }

    public function finish ($ser,$taskId,$data)
    {
        return true;
    }

}