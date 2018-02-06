<?php

class TaskServer
{
    private $_serv;
    private $_run;

    /**
     * init
     */
    public function __construct()
    {
        $this->_serv = new Swoole\Server("127.0.0.1", 9501);
        $this->_serv->set([
            'worker_num' => 2,
            'daemonize' => false,
            'log_file' => __DIR__ . '/server.log',
            'task_worker_num' => 2,
            'max_request' => 5000,
            'task_max_request' => 5000,
            'open_eof_check' => true, //打开EOF检测
            'package_eof' => "\r\n", //设置EOF
            'open_eof_split' => true, // 自动分包
        ]);
        $this->_serv->on('Connect', [$this, 'onConnect']);
        $this->_serv->on('Receive', [$this, 'onReceive']);
        $this->_serv->on('WorkerStart', [$this, 'onWorkerStart']);
        $this->_serv->on('Task', [$this, 'onTask']);
        $this->_serv->on('Finish', [$this, 'onFinish']);
        $this->_serv->on('Close', [$this, 'onClose']);
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

    /**
     * 对数据包单独处理，数据包经过`json_decode`处理之后，只能是数组
     * @param $data
     * @return bool|mixed
     */
    public function unpack($data)
    {
        $data = str_replace("\r\n", '', $data);
        if (!$data) {
            return false;
        }
        $data = json_decode($data, true);
        if (!$data || !is_array($data)) {
            return false;
        }
        return $data;
    }

    public function start()
    {
        $this->_serv->start();
    }
}

$reload = new TaskServer;
$reload->start();