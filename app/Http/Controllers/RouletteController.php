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
        // Получаем ID уже просмотренных пользователей из сессии
        $viewedUserIds = Session::get('viewed_user_ids', []);

        // Ищем пользователя, которого нет в просмотренных
        $user = User::where('id', '!=', auth()->id())
            ->whereNotIn('id', $viewedUserIds)
            ->inRandomOrder()
            ->first();

        // Если пользователей больше нет, выводим сообщение
        if (!$user) {
            return redirect()->back()->with('message', 'No more users available.');
        }

        // Добавляем ID нового пользователя в список просмотренных
        Session::push('viewed_user_ids', $user->id);

        return view('users.roulette', ['user' => $user]);
    }
    public function getNextProfile()
    {
        $viewedUserIds = Session::get('viewed_user_ids', []);

        // Ищем следующего доступного пользователя, которого еще нет в просмотренных
        $user = User::where('id', '!=', auth()->id())
            ->whereNotIn('id', $viewedUserIds)
            ->inRandomOrder()
            ->first();

        // Если доступных пользователей больше нет
        if (!$user) {
            return response()->json([
                'message' => 'No more users available.',
                'noMoreUsers' => true
            ]);
        }

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
        $action = $request->input('action');

        if ($action == 'like') {
            // Сохраняем лайк в базе данных
            Like::create([
                'user_id' => auth()->id(),
                'liked_user_id' => $userId
            ]);
        }

        // Добавляем ID пользователя в список просмотренных после действия
        $viewedUserIds = Session::get('viewed_user_ids', []);
        if (!in_array($userId, $viewedUserIds)) {
            Session::push('viewed_user_ids', $userId);
        }

        return response()->json(['message' => 'Action recorded']);
    }
}
