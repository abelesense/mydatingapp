<?php

namespace App\Console\Commands;

use App\Mail\MessageNotification;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class MessageEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:message-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email notification to the recipient of a new message';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $connection = new AMQPStreamConnection('rabbitmq', 5672, 'abelesense', '2410');
        $channel = $connection->channel();

        $channel->queue_declare('message_notifications', false, false, false, false);

        echo " [*] Waiting for message notifications. To exit press CTRL+C\n";

        $callback = function ($msg) {
            // Извлекаем и декодируем JSON-данные из тела сообщения
            $data = json_decode($msg->body, true);

            $senderId = $data['senderId'];
            $receiverId = $data['receiverId'];
            $messageText = $data['messageText'];

            echo "Получено сообщение: senderId = $senderId, receiverId = $receiverId\n";

            // Находим отправителя и получателя по их ID
            $sender = User::find($senderId);
            $receiver = User::find($receiverId);

            // Отправляем уведомление получателю, если он найден
            if ($receiver && $sender) {
                Mail::to($receiver->email)->send(new MessageNotification($sender, $messageText));
                echo "Уведомление отправлено пользователю с ID $receiverId.\n";
            } else {
                if (!$receiver) {
                    echo "Получатель с ID $receiverId не найден.\n";
                }
                if (!$sender) {
                    echo "Отправитель с ID $senderId не найден.\n";
                }
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

