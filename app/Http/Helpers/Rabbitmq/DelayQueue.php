<?php

namespace App\Http\Helpers\Rabbitmq;


use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Wire\AMQPTable;
use App\Http\Helpers\Rabbitmq\RabbitMQ;

/**
 * 使用RabbitMQ实现延时队列功能
 * Class DelayQueue
 * @package RabbitMQ
 */
class DelayQueue extends RabbitMQ
{
    /**
     * @param $exchangeName
     * @param $type
     * @param $pasive
     * @param $durable 是否持久化
     * @param $autoDelete
     */
    public function createExchange($exchangeName, $type='x-delayed-message', $pasive = false, $durable = false, $autoDelete = false)
    {
//        $this->channel->exchange_declare($exchangeName, $type, $pasive, $durable, $autoDelete);
        $args = new AMQPTable([
            'x-delayed-type' => AMQPExchangeType::TOPIC
        ]);
        $this->channel->exchange_declare($exchangeName, $type, $pasive, $durable, $autoDelete, false, false,$args);
    }

    /**
     * 创建延时队列
     * @param $ttl
     * @param $delayExName
     */
//    public function createQueue($delayExName)
//    {
//        $args = new AMQPTable([
//            'x-delayed-type' => AMQPExchangeType::TOPIC
//        ]);
//        $this->channel->exchange_declare($delayExName, 'x-delayed-message', false, false, false, false, false,$args);
//    }

    /**
     * 生成信息
     * @param $message
     */
    public function sendMessage($message, $routeKey, $exchange = '', $delay = 5, $properties = [])
    {
        $headers = new AMQPTable(array('x-delay' => 1000*$delay));
        $data = new AMQPMessage(
            $message, $properties
        );
        $data->set('application_headers', $headers);
        $this->channel->basic_publish($data, $exchange, $routeKey);
    }
}
