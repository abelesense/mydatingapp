<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

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
        $unreadMessagesKey = "unread_messages:" . $userId . ":" . auth()->id();
        $unreadMessagesCount = Redis::get($unreadMessagesKey) ?? 0;

        // Сбрасываем количество непрочитанных сообщений, так как они были прочитаны
        Redis::del($unreadMessagesKey);

        return view('chat', compact('messages', 'otherUser', 'unreadMessagesCount'));
    }

    public function sendMessage(Request $request, $userId)
    {
        $validated = $request->validate(['message' => 'required|string']);

        // Сохраняем сообщение в базе данных
        Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $userId,
            'message' => $validated['message'],
        ]);

        // Обновляем количество непрочитанных сообщений в Redis
        $redisKey = "unread_messages:" . auth()->id() . ":" . $userId;
        Redis::incr($redisKey); // Увеличиваем количество непрочитанных сообщений

        return redirect()->route('chat', ['user' => $userId]);
    }


}
