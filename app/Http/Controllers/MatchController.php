<?php

namespace App\Http\Controllers;

class MatchController
{
    public function showMatches()
    {
        $user = auth()->user();
        $matches = $user->matches; // Получаем всех пользователей с взаимными лайками

        return view('matches', ['matches' => $matches]);
    }
}
