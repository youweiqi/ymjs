<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 22/1/18
 * Time: PM3:52
 */

$server = new swoole_server("127.0.0.1",9501);

$server->set([
    'worker_num'=>2,
]);
$server->set([
    'task_worker_num' => 1,
]);

$server->on('Connect',function ($server,$fd)
{
    echo "new client connected .".PHP_EOL;
});
//接受客户端发送过来的信息  丢入task
$server->on('Receive',function ($server,$fd,$fromId,$data){
    echo "worker received data111: {$data}" . PHP_EOL;
    $server->task($data);
    $server->send($fd,'This is  as message from server ');
    echo "worker continue run". PHP_EOL;
});

$server->on('Task',function ($server,$taskId,$fromId,$data){
    echo "task start. --- from worker id: {$fromId}." . PHP_EOL;
    for ($i=0; $i < 5; $i++) {
        sleep(1);
        echo "task runing. --- {$i}" . PHP_EOL;
    }
   return "task end." . PHP_EOL;
});
$server->on('Finish', function ($server, $taskId, $data) {
    echo "finish received data '{$data}'" . PHP_EOL;
});

$server->start();