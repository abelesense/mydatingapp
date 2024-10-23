<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; // Не забудьте подключить Eloquent

class Interest extends Model
{
    // Если таблица называется не 'interests', укажите явно
    // protected $table = 'название_таблицы';

    // Функция для получения всех интересов
    public function getAllInterests()
    {
        return self::all(); // Возвращает все записи в виде коллекции объектов
    }
}
