<?php
namespace App\Http\Controllers;

use App\Events\ReportCreated;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    public function submitReport(Request $request, User $user)
    {
        // Валидация входных данных
        $request->validate([
            'reason' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Создание записи в таблице reports
        $report = Report::create([
            'user_id' => auth()->id(),
            'reported_user_id' => $user->id,
            'reason' => $request->input('reason'),
        ]);

        // Данные для отправки в API YouGile
        $yougileData = [
            'title' => 'New complaint submitted', // Название задачи
            'description' => "User ID: {$report->user_id} reported User ID: {$report->reported_user_id}\nReason: {$report->reason}", // Описание задачиу
        ];

        // Отправка данных в API YouGile
        $response = Http::withHeaders([
            'Authorization' => 'Bearer kzzchVxXhChgdJMtmFXQrnRb+9sFaXI2GRC1w+GiulQl0lSkmbqNPE77jtxCJETH', // Замените на ваш токен API YouGile
        ])->post('https://yougile.com/api-v2/tasks', $yougileData);

        // Проверка ответа от YouGile
        if ($response->successful()) {
            // Можно добавить логику в случае успешного выполнения запроса
        } else {
            // Логирование ошибки, если запрос не удался
            Log::error('Failed to create task in YouGile', ['response' => $response->body()]);
        }

        // Перенаправление с сообщением об успешной отправке жалобы
        return redirect()->route('myprofile')->with('status', 'Complaint submitted successfully.');
    }

    public function showReportForm(User $user)
    {
        // Здесь $user — это объект пользователя, на которого отправляется жалоба
        return view('report', compact('user'));
    }
}
