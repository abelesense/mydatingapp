<?php

namespace App\Http\Controllers;

use App\Models\Like;
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

    public function showUsers()
    {
        $users = User::all();
        return view('users', ['users' => $users]);
    }

    // Отображение страницы рулетки
    public function showRoulette()
    {
        $user = User::where('id', '!=', auth()->id())->first();

        if (!$user) {
            return redirect()->back()->with('message', 'No more users available.');
        }

        return view('roulette.roulette', ['user' => $user]);
    }

    // Получение следующего профиля
    public function getNextProfile()
    {
        // Пример логики получения случайного пользователя
        $user = User::inRandomOrder()->first();

        return response()->json([
            'id' => $user->id,
            'username' => $user->username,
            'age' => $user->age,
            'location' => $user->location,
            'bio' => $user->bio,
            'image' => $user->image,
        ]);
    }

    // Обработка лайка/дизлайка
    public function rouletteAction(Request $request)
    {
        $userId = $request->input('user_id');
        $action = $request->input('action'); // Лайк или дизлайк

        if ($action == 'like') {
            // Сохраняем лайк в базу данных
            Like::create([
                'user_id' => auth()->id(),
                'liked_user_id' => $userId
            ]);
        }

        return response()->json(['message' => 'Action recorded']);
    }

}
