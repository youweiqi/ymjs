<?php
use console\models\TaskRun;

/**
 * Created by PhpStorm.
 * User: apple
 * Date: 28/2/18
 * Time: AM8:54
 */



class Swoole
{
    private $_ser;
    private $_run;
    public function __construct()
    {
        $this->_ser = new  \swoole\server("127.0.0.1",9509);
        $this->_ser->set([
            'worker_num'=>2,
            'daemonize'=>false,//进程守护
            'log_file'=>__DIR__.'/server.log',
            'task_worker_num'=>2,
            'max_request'=>5000,
            'task_max_request'=>5000,
            'open_eof_check'=>true,//打开EOF检测
            'package_eof'=>PHP_EOL,//设置EOF
            'open_eof_split'=>true // 自动分包
        ]);

        $this->_ser->on('Connect',[$this,'onConnect']);// 有新的客户端连接时，worker进程内会触发该回调
        $this->_ser->on('Receive',[$this,'onReceive']);// server接收到客户端的数据后，worker进程内触发该回调
        $this->_ser->on('WorkerStart',[$this,'onWorkerStart']);//work进程启动后在引入我们的处理类;只有这样才能热重启
        $this->_ser->on('Task',[$this,'onTask']);//队列
        $this->_ser->on('Finish',[$this,'onFinish']);
        $this->_ser->on('Close',[$this,'onClose']);


    }
    //服务端检测
    public function onConnect($serv, $fd, $fromId)
    {
        echo "new client connected.".$fd . PHP_EOL;
    }
    //task进程其实是要在worker进程内发起的，即我们把需要投递的任务，通过worker进程投递到task进程中去处理。
    public function onWorkerStart($serv, $workerId)
    {
        require_once __DIR__ . "/TaskRun.php";
        $this->_run = new TaskRun;
    }
    public function onReceive($serv, $fd, $fromId, $data)
    {

        //把解包后的真实的数组
        $data = $this->unpack($data);
        //让逻辑处理类去处理数据
        $this->_run->receive($serv, $fd, $fromId, $data);

        if (!empty($data['event'])) {
            //把客户端来源跟数据合并组成一个新的数组丢给下面的服务端的task 队列
            $serv->task(array_merge($data , ['fd' => $fd]));
        }
    }
    public function onTask($serv, $taskId, $fromId, $data)
    {    // 让逻辑处理类处理队列
        $this->_run->task($serv, $taskId, $fromId, $data);
    }
    public function onFinish($serv, $taskId, $data)
    {
        $this->_run->finish($serv, $taskId, $data);
    }
    public function onClose($serv, $fd, $fromId)
    {
        echo $fd."Client close." . PHP_EOL;
    }
    /*
     * 解包
     */
    public function unpack($data)
    {
        $data =str_replace(PHP_EOL,'',$data);
        if(!$data){
            return false;
        }
        $data =json_decode($data,true);//接受一个 JSON 编码的字符串并且把它转换为 PHP 变量
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

$Reload = new Swoole();
$Reload->start();


