<?php

require_once __DIR__ . '/vendor/autoload.php';

class Mailer
{
    public $transport;
    public $mailer;

    /**
     * 发送邮件类 参数 $data 需要三个必填项 包括 邮件主题`$data['subject']`、接收邮件的人`$data['to']`和邮件内容 `$data['content']`
     * @param Array $data
     * @return bool $result 发送成功 or 失败
     */
    public function send($data)
    {
        $this->transport = (new Swift_SmtpTransport('smtp.qq.com', 25))
            ->setEncryption('tls')
            ->setUsername('360063842@qq.com')
            ->setPassword('ouhkqugxnsmhbieg');
        $this->mailer = new Swift_Mailer($this->transport);

        $message = (new Swift_Message($data['subject']))
            ->setFrom(array('360063842@qq.com' => '掌盟'))
            ->setTo(array($data['to']))
            ->setBody($data['content']);

        $result = $this->mailer->send($message);
        // 释放
        $this->destroy();

        return $result;
    }

    public function destroy()
    {
        $this->transport = null;
        $this->mailer = null;
    }
}