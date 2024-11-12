<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'username', 'email', 'password', 'age', 'gender', 'location', 'bio', 'image',
    ];

    protected $hidden = [
        'password',
    ];

    // Связь с интересами пользователя
    public function interests()
    {
        return $this->belongsToMany(Interest::class, 'user_interests', 'user_id', 'interest_id');
    }

    // Пользователи, которым текущий пользователь поставил лайк
    public function likedUsers()
    {
        return $this->belongsToMany(User::class, 'likes', 'user_id', 'liked_user_id');
    }

    // Пользователи, которые поставили лайк текущему пользователю
    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'likes', 'liked_user_id', 'user_id');
    }

    // Метод для получения взаимных совпадений
    public function matches()
    {
        return $this->likedUsers()
            ->whereIn('users.id', $this->likedByUsers()->pluck('users.id'))
            ->select('users.id', 'users.username', 'users.age', 'users.location', 'users.bio', 'users.image');
    }

    // Проверка взаимного совпадения
    public function isMutualMatch(User $otherUser)
    {
        return $this->likedUsers()->where('liked_user_id', $otherUser->id)->exists() &&
            $otherUser->likedUsers()->where('liked_user_id', $this->id)->exists();
    }

    // Отправленные сообщения
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    // Полученные сообщения
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }
}


