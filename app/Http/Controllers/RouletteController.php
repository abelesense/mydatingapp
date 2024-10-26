<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RouletteController extends Controller
{
    public function showRoulette()
    {
        // Получаем ID уже просмотренных пользователей из сессии, если они есть
        $viewedUserIds = Session::get('viewed_user_ids', []);

        // Ищем пользователя, который не находится в просмотренных
        $user = User::where('id', '!=', auth()->id())
            ->whereNotIn('id', $viewedUserIds)
            ->inRandomOrder()
            ->first();

        // Если пользователей больше нет, очищаем сессию и начинаем заново
        if (!$user) {
            Session::forget('viewed_user_ids');
            return redirect()->back()->with('message', 'No more users available.');
        }

        // Добавляем ID нового пользователя в список просмотренных
        Session::push('viewed_user_ids', $user->id);

        return view('users.roulette', ['user' => $user]);
    }
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
