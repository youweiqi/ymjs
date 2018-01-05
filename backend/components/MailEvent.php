<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 20/12/17
 * Time: PM1:51
 * 邮件事件参数类
 * 继承base事件类
 */

namespace backend\components;


use yii\base\Event;

class MailEvent extends Event
{
    public $email;

    public $subject;

    public $content;
}