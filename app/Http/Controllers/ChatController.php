<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

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

        return view('chat', compact('messages', 'otherUser'));
    }

    public function sendMessage(Request $request, $userId)
    {
        $validated = $request->validate(['message' => 'required|string']);


        Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $userId,
            'message' => $validated['message'], // Убедитесь, что 'message' используется здесь
        ]);

        return redirect()->route('chat', ['user' => $userId]);
    }


}
