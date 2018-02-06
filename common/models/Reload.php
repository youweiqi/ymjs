<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 23/1/18
 * Time: AM9:23
 */



require_once("You.php");
class Reload
{
    private $_serv;
    private $_test;

    public function __construct()
    {
        $this->_serv = new swoole_server("127.0.0.1",9501);
        $this->_serv->set([
            'worker_num' => 1
        ]);
        $this->_serv->on('Receive', [$this, 'onReceive']);
    }

    public function onReceive($serv, $fd, $fromId, $data)
    {
        $this->_test->run($data);
    }

    public function start()
    {
        $this->_serv->start();
    }
}


$Reload = new Reload();
$Reload->start();