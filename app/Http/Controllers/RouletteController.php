<?php
namespace App\Http\Controllers;

use App\Mail\MatchNotification;
use App\Models\Like;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

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

        // Сохраняем лайк в базе данных
        if ($action == 'like') {
            Like::create([
                'user_id' => auth()->id(),
                'liked_user_id' => $userId
            ]);

            // Получаем текущего пользователя и пользователя, которому поставили лайк
            $currentUser = auth()->user();
            $likedUser = User::find($userId);

            // Проверяем взаимное совпадение (match) и отправляем уведомления, если есть
            if ($currentUser->isMutualMatch($likedUser)) {
                // Отправка уведомлений о совпадении
                $this->notifyMatch($currentUser, $likedUser);
            }
        }

        return response()->json(['message' => 'Action recorded']);
    }

    // Метод для отправки уведомлений
    public function notifyMatch(User $currentUser, User $matchedUser)
    {
        $connection = new AMQPStreamConnection('rabbitmq', 5672, 'abelesense', '2410');
        $channel = $connection->channel();

// Объявляем очередь
        $channel->queue_declare('matchemail', false, false, false, false);

// Создаем сообщение с ID обоих пользователей в формате JSON
        $data = json_encode([
            'currentUserId' => $currentUser->id,
            'matchedUserId' => $matchedUser->id,
        ]);

        $msg = new AMQPMessage($data);

// Отправляем сообщение в очередь
        $channel->basic_publish($msg, '', 'matchemail');

// Закрываем соединение и канал
        $channel->close();
        $connection->close();
    }
}




