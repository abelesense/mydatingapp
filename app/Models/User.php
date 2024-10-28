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

    public function interests()
    {
        return $this->belongsToMany(Interest::class, 'user_interests', 'user_id', 'interest_id');
    }

    public function likedUsers()
    {
        return $this->belongsToMany(User::class, 'likes', 'user_id', 'liked_user_id');
    }

    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'likes', 'liked_user_id', 'user_id');
    }

    public function matches()
    {
        return $this->likedUsers()
            ->select('users.id', 'users.username', 'users.age', 'users.location', 'users.bio', 'users.image')
            ->whereIn('users.id', $this->likedByUsers()->pluck('users.id'));
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }
}
