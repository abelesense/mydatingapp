<?php

namespace App\Console\Commands;

use App\Mail\MatchNotification;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class MatchEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:match-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $connection = new AMQPStreamConnection('rabbitmq', 5672, 'abelesense', '2410');
        $channel = $connection->channel();

        $channel->queue_declare('matchemail', false, false, false, false);

        echo " [*] Waiting for messages. To exit press CTRL+C\n";

        $callback = function ($msg) {
            // Извлекаем и декодируем JSON-данные из тела сообщения
            $data = json_decode($msg->body, true);

            $currentUserId = $data['currentUserId'];
            $matchedUserId = $data['matchedUserId'];

            echo "Получено сообщение: currentUserId = " . $currentUserId . ", matchedUserId = " . $matchedUserId . "\n";

            // Находим пользователей по ID
            $currentUser = User::find($currentUserId);
            $matchedUser = User::find($matchedUserId);

            // Отправляем уведомления каждому пользователю, если они найдены
            if ($currentUser) {
                Mail::to($currentUser->email)->send(new MatchNotification($matchedUser));
            } else {
                echo "Пользователь с ID " . $currentUserId . " не найден.\n";
            }

            if ($matchedUser) {
                Mail::to($matchedUser->email)->send(new MatchNotification($currentUser));
            } else {
                echo "Пользователь с ID " . $matchedUserId . " не найден.\n";
            }

            // Выводим полную информацию о сообщении для отладки
        };

        $channel->basic_consume('matchemail', '', false, true, false, false, $callback);

        while ($channel->is_consuming()) {
            $channel->wait();
        }

        $channel->close();
        $connection->close();
    }
}
