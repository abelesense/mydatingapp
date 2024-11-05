<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitReportRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Разрешаем выполнение запроса
    }

    public function rules()
    {
        return [
            'reason' => 'required|string|max:255',
            'description' => 'nullable|string',
        ];
    }
}

