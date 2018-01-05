<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 26/12/17
 * Time: PM4:50
 */

namespace common\test;


class EmailSenderBy163 implements EmailSender
{
    public function send()
    {
        return '我是163发送邮件';
    }
}