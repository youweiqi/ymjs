<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 26/12/17
 * Time: PM4:50
 */

namespace common\test;


class EmailSenderByQq implements EmailSender
{
    public function send()
    {
        return '我是QQ发送邮件';
    }
}