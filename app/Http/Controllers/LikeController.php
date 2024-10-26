<?php

namespace App\Http\Controllers;

use App\Models\Like;

class LikeController
{
    public function showLikes()
    {
        $likedUsers = auth()->user()->likedUsers; // Предполагается, что у пользователя есть связь likes

        return view('profile.like', [
            'likedUsers' => $likedUsers
        ]);

    }

    public function whoLikesMe()
    {
        // Получаем ID текущего пользователя
        $currentUserId = auth()->id();

        // Получаем пользователей, которые лайкнули текущего пользователя
        $likes = Like::where('liked_user_id', $currentUserId)->with('user')->get();

        return view('profile.wholikesme', ['likes' => $likes]);
    }


}
