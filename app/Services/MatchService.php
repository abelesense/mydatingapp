<?php

namespace App\Services;

use App\Mail\MatchNotification;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class MatchService
{
    public function handleMatch(User $user1, User $user2)
    {
        // Проверка на взаимный match (логика может варьироваться)
        if ($this->isMutualMatch($user1, $user2)) {
            // Отправка email для первого пользователя с информацией о втором пользователе
            Mail::to($user1->email)->send(new MatchNotification($user2));

            // Отправка email для второго пользователя с информацией о первом пользователе
            Mail::to($user2->email)->send(new MatchNotification($user1));
        }
    }

    private function isMutualMatch(User $user1, User $user2)
    {
        // Пример логики взаимного совпадения
        return $user1->likes()->where('liked_user_id', $user2->id)->exists() &&
            $user2->likes()->where('liked_user_id', $user1->id)->exists();
    }

    public function someMethodToCheckMatches()
    {
        $user1 = User::find(1); // Пример пользователя 1
        $user2 = User::find(2); // Пример пользователя 2

        $matchService = new MatchService();
        $matchService->handleMatch($user1, $user2);
    }
}
