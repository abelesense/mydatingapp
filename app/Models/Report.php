<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $table = 'mainreports';

    protected $fillable = [
        'user_id',
        'reported_user_id',
        'reason',
        'description',
        'status',
    ];

    /**
     * Связь с моделью User, представляющей пользователя, подавшего жалобу.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Связь с моделью User, представляющей пользователя, на которого подана жалоба.
     */
    public function reportedUser()
    {
        return $this->belongsTo(User::class, 'reported_user_id');
    }
}
