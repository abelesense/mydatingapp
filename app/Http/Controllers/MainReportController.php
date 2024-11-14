<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class MainReportController
{
    public function create()
    {
        return view('report_create');
    }

    public function store(Request $request)
    {
        // Валидация запроса
        $validated = $request->validate([
            'reported_user_id' => 'required|exists:users,id',
            'reason' => 'required|string',
            'description' => 'nullable|string',
        ]);

        // Создание жалобы в базе данных
        $report = Report::create([
            'user_id' => auth()->id(),
            'reported_user_id' => $validated['reported_user_id'],
            'reason' => $validated['reason'],
            'description' => $validated['description'],
            'status' => 'pending',
        ]);

        // Данные для задачи в YouGile
        $yougileData = [
            'title' => 'New Complaint Submitted',
            'description' => "User ID: {$report->user_id} reported User ID: {$report->reported_user_id}\nReason: {$report->reason}\nDescription: {$report->description}",
        ];

        // Отправка запроса в API YouGile
        $response = Http::withHeaders([
            'Authorization' => 'Bearer kzzchVxXhChgdJMtmFXQrnRb+9sFaXI2GRC1w+GiulQl0lSkmbqNPE77jtxCJETH',
        ])->post('https://yougile.com/api-v2/tasks', $yougileData);

        // Проверка успешности запроса и запись ошибки в лог, если запрос не удался
        if (!$response->successful()) {
            Log::error('Failed to create task in YouGile', ['response' => $response->body()]);
        }

        return redirect()->route('report.create')->with('success', 'Report submitted successfully');
    }
}
