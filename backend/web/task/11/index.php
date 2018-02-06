<?php

require_once __DIR__ . "/Mailer.php";

$data = [
    'to' => '360063842@qq.com',
    'subject' => 'just a test',
    'content' => 'This is just a test.',
];
$mailer = new Mailer;
$mailer->send($data);