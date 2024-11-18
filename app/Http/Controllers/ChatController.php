<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Services\RabbitMQService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ChatController extends Controller
{
    protected $rabbitMQService;

    public function __construct(RabbitMQService $rabbitMQService)
    {
        $this->rabbitMQService = $rabbitMQService;
    }

    public function showChat($userId)
    {
        $otherUser = User::findOrFail($userId);
        $messages = Message::where(function ($query) use ($userId) {
            $query->where('sender_id', auth()->id())
                ->where('receiver_id', $userId);
        })->orWhere(function ($query) use ($userId) {
            $query->where('sender_id', $userId)
                ->where('receiver_id', auth()->id());
        })->orderBy('created_at')->get();

        // Получаем и сбрасываем количество непрочитанных сообщений
        $unreadMessagesKey = "unread_messages:{$userId}:" . auth()->id();
        $unreadMessagesCount = Cache::pull($unreadMessagesKey, 0);

        return view('chat', compact('messages', 'otherUser', 'unreadMessagesCount'));
    }

    public function sendMessage(Request $request, $userId)
    {
        $validated = $request->validate(['message' => 'required|string']);

        // Сохраняем сообщение в базе данных
        $message = Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $userId,
            'message'    => $validated['message'],
        ]);

        // Уведомление о новом сообщении
        $this->notifyMessage($message);

        // Обновляем количество непрочитанных сообщений в Redis
        $redisKey = "unread_messages:{$userId}:" . auth()->id();
        Cache::increment($redisKey);

        return redirect()->route('chat', ['user' => $userId]);
    }

    protected function notifyMessage(Message $message)
    {
        // Публикация сообщения в RabbitMQ
        $this->rabbitMQService->publish('message_notifications', [
            'senderId'   => $message->sender_id,
            'receiverId' => $message->receiver_id,
            'messageText' => $message->message,
        ]);
    }
}

