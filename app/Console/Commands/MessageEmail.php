<?php

namespace App\Console\Commands;

use App\Mail\MessageNotification;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Services\RabbitMQService;

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

    protected $rabbitMQService;

    public function __construct(RabbitMQService $rabbitMQService)
    {
        parent::__construct();
        $this->rabbitMQService = $rabbitMQService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $queueName = 'message_notifications';

        $this->rabbitMQService->consume($queueName, function ($msg) {
            $this->processMessage($msg);
        });
    }

    /**
     * Обработка сообщения из очереди.
     *
     * @param $msg
     */
    protected function processMessage($msg): void
    {
        $data = json_decode($msg->body, true);

        $senderId = $data['senderId'];
        $receiverId = $data['receiverId'];
        $messageText = $data['messageText'];

        echo "Получено сообщение: senderId = $senderId, receiverId = $receiverId\n";

        $sender = User::find($senderId);
        $receiver = User::find($receiverId);

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
    }
}


