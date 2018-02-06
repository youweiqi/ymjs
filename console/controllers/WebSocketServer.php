<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 24/1/18
 * Time: AM11:50
 */

namespace console\controllers;


class WebSocketServer
{
    private $_serv;
    public function __construct()
    {
        $this->_serv = new \swoole\websocket\server("127.0.0.1",9503);
        $this->_serv->set([
           'worker_num'=>1,
        ]);
        $this->_serv->on('open',[$this,'onOpen']);
        $this->_serv->on('message',[$this,'onMessage']);
        $this->_serv->on('close',[$this,'onClose']);
    }

    public function onOpen($serv,$request)
    {
        echo "server: handshake success with fd{$request->fd}.\n";
    }

    public function onMessage($serv, $frame)
    {
        // 循环当前的所有连接，并把接收到的客户端信息全部发送
        foreach ($serv->connections as $fd) {
            $serv->push($fd, $frame->data);
        }
    }
    public function onClose($serv, $fd)
    {
        echo "client {$fd} closed.\n";
    }
    public function start()
    {
        $this->_serv->start();
    }
}

$server = new WebSocketServer;
$server->start();