<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 19/1/18
 * Time: PM4:33
 *  SWOOLE_SOCK_SYNC 同步客户端
 *  SWOOLE_SOCK_ASYNC 异步客户端
 * 客户端去链接服务端 发送信息 最后关闭 客户端;
 */

$client = new swoole_client(SWOOLE_SOCK_TCP,SWOOLE_SOCK_SYNC);

$client->connect('127.0.0.1',9502)|| exit("connect failed. Error: {$client->errCode}\n");

$client->send("just a test .\n");

$response = $client->recv();

echo $response . PHP_EOL;//输出接受服务端返回的通知

$client->close();