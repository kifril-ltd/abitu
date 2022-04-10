<?php

namespace App\RpcConnection;

use Exception;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RpcClient
{
    private $connection;
    private $channel;
    private $callback_queue;
    private $callback_queue_name;
    private $response;
    private $corr_id;

    public function __construct($callback_queue_name, $durable)
    {
        $this->callback_queue_name = $callback_queue_name;
        $this->connection = new AMQPStreamConnection(
            'rabbitmq',
            5672,
            'guest',
            'guest'
        );
        $this->channel = $this->connection->channel();
       $this->channel->queue_declare(
            (string) $this->callback_queue_name,
            false,
            $durable,
            false,
            false
        );

        $this->channel->basic_consume(
            $this->callback_queue_name,
            '',
            false,
            true,
            false,
            false,
            array(
                $this,
                'onResponse'
            )
        );
    }

    public function onResponse($rep)
    {
        $this->response[] = $rep->body;
    }

    public function call($n)
    {
        $this->response = null;

        $msg = new AMQPMessage(
            (string) $n,
            array(
                'reply_to' => (string) $this->callback_queue_name
            )
        );
        $this->channel->basic_publish($msg, '', 'rpc_queue');
    }

    public function get()
    {
        try
        {
            while (count($this->channel->callbacks))
            {
                $this->channel->wait(non_blocking: true, timeout: 1);
            }
        }
        catch (Exception $e)
        {

        }
        return $this->response;
    }

    public function close()
    {
        $this->channel->close();
        $this->connection->close();
    }
}