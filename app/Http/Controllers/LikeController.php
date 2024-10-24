<?php

namespace App\Http\Controllers;

class LikeController
{
    public function showLikes()
    {
        $likedUsers = auth()->user()->likes; // Предполагается, что у пользователя есть связь likes

        return view('profile.like', [
            'likedUsers' => $likedUsers
        ]);

    }

}
