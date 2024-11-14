<?php
namespace App\Console\Commands;

use App\Models\User;
use App\Models\Message;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class ProcessMessageNotifications extends Command
{
    protected $signature = 'notifications:process-messages';
    protected $description = 'Process message notifications from RabbitMQ and send email alerts';

    public function handle()
    {
        $connection = new AMQPStreamConnection('rabbitmq', 5672, 'abelesense', '2410');
        $channel = $connection->channel();

        $channel->queue_declare('message_notifications', false, false, false, false);

        $callback = function ($msg) {
            $data = json_decode($msg->body, true);
            $receiver = User::find($data['receiverId']);
            $sender = User::find($data['senderId']);

            if ($receiver && $sender) {
                // Здесь мы отправляем письмо получателю
                Mail::to($receiver->email)->send(new \App\Mail\MessageNotification($sender, $data['messageText']));
            }
        };

        $channel->basic_consume('message_notifications', '', false, true, false, false, $callback);

        while ($channel->is_consuming()) {
            $channel->wait();
        }

        $channel->close();
        $connection->close();
    }
}


