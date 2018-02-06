<?php



/**
 * Created by PhpStorm.
 * User: apple
 * Date: 23/1/18
 * Time: AM9:23
 */



class Reload
{
    private $_serv;
    public $test;

    public function __construct()
    {
        $this->_serv = new \Swoole\Server("127.0.0.1",9502);
        $this->_serv->set([
            'worker_num' => 1
        ]);
        $this->_serv->on('Receive', [$this, 'onReceive']);
        $this->test = new \common\models\You();
    }

    public function onReceive($serv, $fd, $fromId, $data)
    {
       $this->_serv->send($fd,'youweiqi.'.$data);
        $this->test->run($data);
    }

    public function start()
    {
        $this->_serv->start();
    }
}


$Reload = new Reload();
$Reload->start();