<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 26/12/17
 * Time: PM4:48
 * 接口的方法必须是公共方法 不实现让子类自己实现
 */

namespace common\test;


interface EmailSender
{
  public function send();
}