<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 23/1/18
 * Time: PM1:53
 */

namespace common\models;


class SwooleServer
{
    private $_ser;
    private $_run;

    public function __construct()
    {
        $this->_ser = new swoole_server("127.0.0.1",9501);
        $this->_ser->set([
            'worker_num'=>2,
            'daemonize'=>false,
            'log_file'=>__DIR__.'/server.log',
            'task_worker_num'=>2,
            'max_request'=>5000,
            'task_max_request'=>5000,
            'open_eof_check'=>true,
            'package_eof'=>PHP_EOL,
            'open_eof_split'=>true
        ]);
        $this->_ser->on('Connect',[$this,'onConnect']);
        $this->_ser->on('Receive',[$this,'onReceive']);
        $this->_ser->on('WorkerStart',[$this,'onWorkerStart']);
        $this->_ser->on('Task',[$this,'onTask']);
        $this->_ser->on('Finish',[$this,'onFinish']);
        $this->_ser->on('Close',[$this,'onClose']);


    }
    public function onConnect($serv, $fd, $fromId)
    {
    }
    public function onWorkerStart($serv, $workerId)
    {
        require_once __DIR__ . "/TaskRun.php";
        $this->_run = new TaskRun;
    }
    public function onReceive($serv, $fd, $fromId, $data)
    {
        $data = $this->unpack($data);
        $this->_run->receive($serv, $fd, $fromId, $data);
        // 投递一个任务到task进程中
        if (!empty($data['event'])) {
            $serv->task(array_merge($data , ['fd' => $fd]));
        }
    }
    public function onTask($serv, $taskId, $fromId, $data)
    {
        $this->_run->task($serv, $taskId, $fromId, $data);
    }
    public function onFinish($serv, $taskId, $data)
    {
        $this->_run->finish($serv, $taskId, $data);
    }
    public function onClose($serv, $fd, $fromId)
    {
    }
    public function unpack($data)
    {
       $data =str_replace(PHP_EOL,'',$data);
        if(!$data){
            return false;
        }
        $data =json_decode($data,true);
        if(!$data||!is_array($data)){
            return false;
        }
        return $data;
    }

    public function start()
    {
        $this->_ser->start();
    }
}

$Reload = new SwooleServer();
$Reload->start();