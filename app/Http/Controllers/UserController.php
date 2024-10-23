<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
class UserController extends Controller
{
    public function showUsers()
    {
        $currentUserId = Auth::id();
        $users = User::where('id', '!=', $currentUserId)->get();

        return view('users.users', ['users' => $users]);
    }

    public function show($id)
    {
        // Получаем пользователя по ID
        $user = User::findOrFail($id); // Если не найден, вернет 404

        // Возвращаем представление профиля с данными пользователя
        return view('profile.show', compact('user'));
    }

}
