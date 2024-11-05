<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Разрешаем выполнение запроса
    }

    public function rules()
    {
        return [
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'age' => 'required|integer',
            'password' => 'required|string|min:4|confirmed',
            'gender' => 'required|string|max:10',
            'location' => 'required|string|max:255',
            'bio' => 'required|string|max:500',
            'image' => 'required|url',
        ];
    }
}
