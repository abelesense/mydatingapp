<?php

namespace App\Services;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQService
{
    protected $connection;
    protected $channel;

    public function __construct()
    {
        // Устанавливаем соединение с RabbitMQ
        $this->connection = new AMQPStreamConnection('rabbitmq', 5672, 'abelesense', '2410');
        $this->channel = $this->connection->channel();
    }

    /**
     * Публикация сообщения в указанную очередь.
     *
     * @param string $queueName Название очереди
     * @param array $data Данные для публикации
     * @return void
     */
    public function publish(string $queueName, array $data): void
    {
        // Объявляем очередь
        $this->channel->queue_declare($queueName, false, false, false, false);

        // Преобразуем данные в JSON и создаем сообщение
        $message = new AMQPMessage(json_encode($data));

        // Отправляем сообщение в очередь
        $this->channel->basic_publish($message, '', $queueName);
    }

    public function consume(string $queueName, callable $callback): void
    {
        // Объявляем очередь
        $this->channel->queue_declare($queueName, false, false, false, false);

        echo " [*] Waiting for messages on queue '{$queueName}'. To exit press CTRL+C\n";

        // Подписываемся на очередь с предоставленным callback
        $this->channel->basic_consume($queueName, '', false, true, false, false, $callback);

        // Ожидание сообщений
        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }
    }

    public function __destruct()
    {
        // Закрываем канал и соединение
        $this->channel->close();
        $this->connection->close();
    }
}
