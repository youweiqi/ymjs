<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 26/12/17
 * Time: PM4:51
 * 通过构造函数注入的方式
 */

namespace common\test;


class User
{
    public $emailSendClass;

    public function __construct(EmailSender $emailSenderObject)
    {
        $this->emailSendClass = $emailSenderObject;
    }

    /*
     * 调用go方法就可以发送邮件
     */
    public function go(){
        $this->emailSendClass->send();
    }

}



$user = new User(new EmailSenderByQq);
$user->go();