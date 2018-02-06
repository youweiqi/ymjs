<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 23/1/18
 * Time: PM2:27
 */

namespace common\models;


class TaskClient
{
    private $client;
    const EVENT_TYPE_SEND_MAIL = 'send-mail';

    public function __construct()
    {
        $this->client = new swoole_client(SWOOLE_SOCK_TCP);
        if($this->client->connect('127.0.0.1',9501)){
            $msg = 'swoole client connect failed.';
            throw new \Exception("Error: {$msg}.");
        }

    }

    public function togetherDataByEof($data)
    {
        if(!is_array($data)){
            return false;
        }
        return json_encode($data).PHP_EOL;
    }

    public function sendData($data){
        $data = $this->togetherDataByEof($data);
        $this->client->send($data);
    }

}