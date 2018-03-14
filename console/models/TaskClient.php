<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 23/1/18
 * Time: PM2:27
 *业务实现的时候都通过实例这个swoole客户端 进行数据加工去把数据传给服务端
 */

namespace console\models;
class TaskClient
{
    private $_client;
    const EVENT_TYPE_SEND_MAIL = 'send-mail';
    const EVENT_TYPE_SEND_REDEEM = 'send-redeem';

    /*
     * 客户端实例化
     */
    public function __construct()
    {
        $this->_client = new \swoole\client(SWOOLE_SOCK_TCP);

        if(!$this->_client->connect('127.0.0.1',9509)){
            $msg = 'swoole client connect failed.';
            throw new \Exception("Error: {$msg}.");
        }

    }
    /*
     * 对数据末尾拼接EOF标记
     */
    public function togetherDataByEof($data)
    {
        if(!is_array($data)){
            return false;
        }
        return json_encode($data).PHP_EOL;
    }
 // 发送到服务端
    public function sendData($data){
        $data = $this->togetherDataByEof($data);
        $this->_client->send($data);
    }

}