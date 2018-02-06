<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 19/1/18
 * Time: PM3:13
 */
$server = new swoole_server("127.0.0.1",9501);

$server->set([
    'worker_num'=>2,
]);

$server->on('Connect',function ($server,$fd)
{
    echo "new client connected1122 .".PHP_EOL;
});

$server->on('Receive',function ($server,$fd,$fromId,$data){
    $server->send($fd,'Server.'.$data);
});

$server->on('Close',function ($server,$fd){
   echo "Client close.".PHP_EOL;
});


$server->start();