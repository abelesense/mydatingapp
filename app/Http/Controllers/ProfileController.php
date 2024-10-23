<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function showProfileForm()
    {
        $user = auth()->user();
        $interests = $user->interests; // Получаем интересы пользователя через связь

        return view('profile.index', [
            'user' => $user,
            'interests' => $interests
        ]);
    }

    public function update(Request $request)
    {
        // Валидация данных
        $request->validate([
            'username' => 'required|string|max:255',
            'age' => 'required|integer',
            'bio' => 'required|string|max:500',
        ]);

        // Обновление данных пользователя
        $userId = Auth::id();
        $user = User::find($userId);
        $user->username = $request->username;
        $user->age = $request->age;
        $user->bio = $request->bio;
        $user->save();

        // Уведомление о успешном обновлении
        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function logout()
    {
        Auth::logout();

        // Перенаправление на главную страницу после выхода
        return redirect('/')->with('success', 'You have been logged out successfully!');
    }

}
