<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Illuminate\Support\Facades\Http;

class RabbitMQWorker extends Command
{
    protected $signature = 'rabbitmq:work';
    protected $description = 'Process messages from RabbitMQ';

    public function handle()
    {
        $connection = new AMQPStreamConnection('rabbitmq', 5672, 'abelesense', '2410');
        $channel = $connection->channel();

        $channel->queue_declare('reports_queue', false, true, false, false);

        $this->info(" [*] Waiting for messages. To exit press CTRL+C");

        $callback = function ($msg) {
            $data = json_decode($msg->body, true);

            if (!$data) {
                $this->error("Invalid message format");
                return;
            }

            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer kzzchVxXhChgdJMtmFXQrnRb+9sFaXI2GRC1w+GiulQl0lSkmbqNPE77jtxCJETH',
                ])->post('https://yougile.com/api-v2/tasks', [
                    'title' => $data['title'],
                    'description' => $data['description'],
                ]);

                if ($response->successful()) {
                    $this->info(" [x] Task created in YouGile");
                } else {
                    $this->error(" [!] Failed to create task in YouGile");
                }
            } catch (\Exception $e) {
                $this->error(" [!] Error: {$e->getMessage()}");
            }

            $msg->ack(); // Подтверждение обработки сообщения
        };

        $channel->basic_consume('reports_queue', '', false, false, false, false, $callback);

        while ($channel->is_consuming()) {
            $channel->wait();
        }

        $channel->close();
        $connection->close();
    }
}





