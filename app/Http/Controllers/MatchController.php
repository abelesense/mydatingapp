<?php
namespace App\Http\Controllers;







class MatchController extends Controller
{
    public function showMatches()
    {
        $user = auth()->user();
        $matches = $user->matches; // Получаем всех пользователей с взаимными лайками

//        $matchesWithUnreadCount = $matches->map(function ($match) {
//            $unreadMessagesKey = "unread_messages:" . auth()->id() . ":" . $match->id;
//            $unreadMessagesCount = Redis::get($unreadMessagesKey) ?? 0;
//            $match->unread_messages_count = $unreadMessagesCount;
//            return $match;
//        });

        return view('matches', compact('matches'));
    }
}




