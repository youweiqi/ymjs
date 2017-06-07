<?php
/**
 * @link https://github.com/webtoucher/yii2-amqp
 * @copyright Copyright (c) 2014 webtoucher
 * @license https://github.com/webtoucher/yii2-amqp/blob/master/LICENSE.md
 */

namespace common\components;

use yii\base\Component;





class Amqp extends Component
{
    const TYPE_TOPIC = 'topic';
    const TYPE_DIRECT = 'direct';
    const TYPE_HEADERS = 'headers';
    const TYPE_FANOUT = 'fanout';

    /**
     * @var \AMQPConnection
     */
    protected static $ampqConnection;

    /**
     * @var \AMQPChannel
     */
    protected $channel;

    /**
     * @var string
     */
    public $host = '127.0.0.1';

    /**
     * @var integer
     */
    public $port = 5672;

    /**
     * @var string
     */
    public $user;

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $vhost = '/';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }

    /**
     * Returns AMQP connection.
     *配置链接
     * @return \AMQPConnection
     */
    private function getConnection()
    {
        if(is_null(self::$ampqConnection))
        {
            try {
                self::$ampqConnection = new \AMQPConnection(
                    [
                        'host'      => $this->host,
                        'port'      => $this->port,
                        'login'     => $this->user,
                        'password'  => $this->password,
                        'vhost'     => $this->vhost
                    ]
                );
            }catch (\Exception $e)
            {
                echo $e->getMessage();exit;
            }
        }
        self::$ampqConnection->connect();
        return self::$ampqConnection;
    }

    /**
     * Returns AMQP connection.
     *
     * @return \AMQPChannel
     * 获取通道
     */
    private function getChannel()
    {

        if (is_null($this->channel)) {
            $this->channel = new \AMQPChannel(self::getConnection());
        }
        return $this->channel;
    }

    /**
     * 生产者
     * Sends message to the exchange.
     *
     * @param string $exchange
     * @param string $routing_key
     * @param string json $message
     * @return bool
     */
    public function product($exchange_name,$queue_name, $routing_key, $message)
    {
        $ex = $this->declareExchange($exchange_name);
        $this->declareQueue($exchange_name, $queue_name, $routing_key);
        return $ex->publish($message, $routing_key,AMQP_NOPARAM,["content_encoding" => "string"]);
    }

    private function declareQueue($exchange_name,$queue_name,$routing_key)
    {
        $queue = new \AMQPQueue($this->getChannel());
        $queue->setName($queue_name);
        $queue->setFlags(AMQP_DURABLE& AMQP_PASSIVE);
        $queue->declareQueue();
        $queue->bind($exchange_name,$routing_key);
        return $queue;
    }
    //队列消费
    public function consume($exchange_name,$queue_name,$routing_key,callable $callback)
    {
        $this->declareExchange($exchange_name);
        $queue = $this->declareQueue($exchange_name, $queue_name, $routing_key);
        //消费
        $queue->consume($callback= $callback, AMQP_AUTOACK);

    }
    private function declareExchange($exchange_name)
    {
        $ex = new \AMQPExchange($this->getChannel());
        $ex->setName($exchange_name); //设置交换器名称
        $ex->setType('direct');
        $ex->setFlags(AMQP_DURABLE); //持久化
        $ex->declareExchange(); //声明交换器
        return $ex;
    }
}