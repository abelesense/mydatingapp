<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Разрешаем выполнение запроса
    }

    public function rules()
    {
        return [
            'username' => 'required|string|max:255',
            'age' => 'required|integer',
            'bio' => 'required|string|max:500',
        ];
    }
}
