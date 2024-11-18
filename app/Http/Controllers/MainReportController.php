<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;


class MainReportController
{
    public function create()
    {
        return view('report_create');
    }

    public function store(Request $request)
    {
        // Валидация входных данных
        $validated = $request->validate([
            'reported_user_id' => 'required|exists:users,id',
            'reason' => 'required|string',
            'description' => 'nullable|string',
        ]);

        // Сохранение жалобы в базе данных
        $report = Report::create([
            'user_id' => auth()->id(),
            'reported_user_id' => $validated['reported_user_id'],
            'reason' => $validated['reason'],
            'description' => $validated['description'],
            'status' => 'pending',
        ]);

        // Формируем данные для отправки
        $data = [
            'title' => 'New Complaint Submitted',
            'description' => "User ID: {$report->user_id} reported User ID: {$report->reported_user_id}\nReason: {$report->reason}\nDescription: {$report->description}",
        ];

        // Преобразуем данные в JSON
        $jsonData = json_encode($data);

        // Отправка данных в RabbitMQ
        $this->sendToRabbitMQ($jsonData);

        return redirect()->route('report.create')->with('success', 'Report submitted successfully');
    }

    /**
     * Отправка данных в RabbitMQ.
     *
     * @param string $message
     */
    private function sendToRabbitMQ(string $message)
    {
        $connection = new AMQPStreamConnection('rabbitmq', 5672, 'abelesense', '2410');
        $channel = $connection->channel();

        // Объявляем очередь
        $channel->queue_declare('reports_queue', false, true, false, false);

        // Создаем сообщение
        $msg = new AMQPMessage($message, [
            'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT, // Делает сообщение долговечным
        ]);

        // Отправляем сообщение в очередь
        $channel->basic_publish($msg, '', 'reports_queue');

        // Закрываем соединение и канал
        $channel->close();
        $connection->close();
    }
}
