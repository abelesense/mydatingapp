<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Queue;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;


class ChatController extends Controller
{
    public function showChat($userId)
    {
        $otherUser = User::findOrFail($userId);
        $messages = Message::where(function($query) use ($userId) {
            $query->where('sender_id', auth()->id())
                ->where('receiver_id', $userId);
        })->orWhere(function($query) use ($userId) {
            $query->where('sender_id', $userId)
                ->where('receiver_id', auth()->id());
        })->orderBy('created_at')->get();

        // Получаем количество непрочитанных сообщений
//        $unreadMessagesKey = "unread_messages:" . $userId . ":" . auth()->id();
//        $unreadMessagesCount = Redis::get($unreadMessagesKey) ?? 0;
//
//        // Сбрасываем количество непрочитанных сообщений, так как они были прочитаны
//        Redis::del($unreadMessagesKey);

        return view('chat', compact('messages', 'otherUser'));
    }

    public function sendMessage(Request $request, $userId)
    {
        $validated = $request->validate(['message' => 'required|string']);

        // Сохраняем сообщение в базе данных
        $message = Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $userId,
            'message' => $validated['message'],
        ]);

        $this->notifyMessage($message);
//        // Обновляем количество непрочитанных сообщений в Redis
//        $redisKey = "unread_messages:" . auth()->id() . ":" . $userId;
//        Redis::incr($redisKey); // Увеличиваем количество непрочитанных сообщений

        return redirect()->route('chat', ['user' => $userId]);
    }

    public function notifyMessage(Message $message)
    {
        // Устанавливаем соединение с RabbitMQ
        $connection = new AMQPStreamConnection('rabbitmq', 5672, 'abelesense', '2410');
        $channel = $connection->channel();

        // Объявляем очередь для уведомлений о сообщениях
        $channel->queue_declare('message_notifications', false, false, false, false);

        // Создаем сообщение с ID отправителя, ID получателя и текстом сообщения в формате JSON
        $data = json_encode([
            'senderId' => $message->sender_id,
            'receiverId' => $message->receiver_id,
            'messageText' => $message->message,
        ]);

        $msg = new AMQPMessage($data);

        // Отправляем сообщение в очередь
        $channel->basic_publish($msg, '', 'message_notifications');

        // Закрываем канал и соединение
        $channel->close();
        $connection->close();
    }
}
