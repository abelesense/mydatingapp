<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQController
{
    public function send()
    {
        $connection = new AMQPStreamConnection('rabbitmq', 5672, 'abelesense', '2410');
        $channel = $connection->channel();

// Объявляем очередь
        $channel->queue_declare('hello', false, false, false, false);

// Создаем сообщение
        $msg = new AMQPMessage('Hello, RabbitMQ!');

// Отправляем сообщение в очередь
        $channel->basic_publish($msg, '', 'hello');

        echo " [x] Sent 'Hello, RabbitMQ!'\n";

// Закрываем соединение и канал
        $channel->close();
        $connection->close();

    }

    public function receive()
    {
        $connection = new AMQPStreamConnection('rabbitmq', 5672, 'abelesense', '2410');
        $channel = $connection->channel();

        $channel->queue_declare('hello', false, false, false, false);

        echo " [*] Waiting for messages. To exit press CTRL+C\n";

        $callback = function ($msg) {
            echo ' [x] Received ', $msg->body, "\n";
        };

        $channel->basic_consume('hello', '', false, true, false, false, $callback);

        $channel->wait(null,false);


        // Закрываем соединение после завершения
        $channel->close();
        $connection->close();
    }

}
