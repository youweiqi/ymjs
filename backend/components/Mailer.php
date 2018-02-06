<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 20/12/17
 * Time: AM9:47
 邮件类
 调用事件发送邮件demo
 */

namespace backend\components;


use Yii;

class Mailer
{
    /*
     * 单个发送邮件
     */
  public static function sendMail($event){
     $mail = Yii::$app->mailer->compose('test',['title'=>'http://www.manks.top/yii2-swiftMailer.html']);
      //echo "email is {$event->email} <br>";
      //echo "subject is {$event->subject} <br>";
      //echo "content is {$event->content}";
      $mail->setTo($event->email);
      $mail->setSubject($event->subject);
      $mail->setTextBody($event->content);
      $result =$mail->send();
      return $result;
  }

  /*
   * 批量发送邮件
   * 循环待发送的客户 把发送的内容存在一个数组里面
   */
  public static function batchSend(){
      $users =['360063842@qq.com','271461697@qq.com'];
      $message = [];
      foreach ($users as $user)
      {
          $message[] =Yii::$app->mailer->compose()
              ->setTo($user)
              ->setSubject('这是发给燕子和我自己的')
              ->setHtmlBody('你看看你收到没有');
      }
      Yii::$app->mailer->sendMultiple($message);
  }
}