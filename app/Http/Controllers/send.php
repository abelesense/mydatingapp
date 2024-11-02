<?php


require 'vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

// Подключение к серверу RabbitMQ
$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
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
