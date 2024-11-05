<?php
namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\User;
use Illuminate\Http\Request;

class RouletteController extends Controller
{
    public function showRoulette()
    {
        // Ищем случайного пользователя, который не является текущим авторизованным
        $user = User::where('id', '!=', auth()->id())
            ->inRandomOrder()
            ->first();

        // Если пользователей больше нет, выводим сообщение
        if (!$user) {
            return redirect()->back()->with('message', 'No more users available.');
        }

        return view('users.roulette', ['user' => $user]);
    }

    public function getNextProfile()
    {
        // Ищем следующего случайного пользователя, кроме текущего
        $user = User::where('id', '!=', auth()->id())
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

        return response()->json(['message' => 'Action recorded']);
    }
}


