<?php
namespace common\components;

use yii\base\InvalidConfigException;
/*
 * $broker_list  路由+端口
 * $topic 队列名
 * $partition
 */
class Kafka
{
    public $broker_list = '127.0.0.1:9092';
    public $topic = "topic";
    public $partition = 0;

    protected $producer = null;
    protected $consumer = null;

/*
 * 构造方法
 * $rk 是生成者
 */
    public function __construct()
    {
        if(empty($this->broker_list)){
            throw new InvalidConfigException('broker is not error');
        }

        $rk = new \RdKafka\Producer();
        if(empty($rk)){
            throw new InvalidConfigException("producer is error");
        }
        $rk->setLogLevel(LOG_DEBUG);
         if(!$rk->addBrokers($this->broker_list)){
             throw new InvalidConfigException('broker error');
         };
         $this->producer =$rk;
    }

/*
 * 发送消息
 * $topic生产者实例化队列
 * return 队列生成消息
 */
    public function send($messages = [])
    {
        $topic = $this->producer->newTopic($this->topic);
        return $topic->produce(RD_KAFKA_PARTITION_UA,$this->partition,json_encode($messages));
    }

/*
 * 消费者
 * ./kafka-console-consumer --bootstrap-server 127.0.0.1:9092 --topic kafka
 * RD_KAFKA_RESP_ERR_NO_ERROR  没有错误
 */
    public function consumer($object,$callback){
        $conf = new \Rdkafka\Conf();
        $conf->set('group.id',0);
        $conf->set('metadata.broker.list',$this->broker_list);

        $topicConf = new \Rdkafka\TopicConf();
        $topicConf->set('auto.offset.reset','smallest');// 重头消费
        $conf->setDefaultTopicConf($topicConf);

        $consumer = new \RdKafka\KafkaConsumer($conf); // 实例化消费对象
        $consumer->subscribe([$this->topic]);//订阅队列

        echo "waiting for messages...\n";// 出现这个说明订阅成功

        while (true){
            $message = $consumer->consume(120*1000);
            switch ($message->err){
                case RD_KAFKA_RESP_ERR_NO_ERROR:
                    echo "message payload...";
                    $object->$callback($message->payload);
                    break;
            }
        }
        sleep(1);
    }

}


