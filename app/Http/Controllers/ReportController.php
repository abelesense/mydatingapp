<?php
namespace App\Http\Controllers;

use App\Events\ReportCreated;
use App\Http\Requests\SubmitReportRequest;
use App\Models\Report;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    public function submitReport(SubmitReportRequest $request, User $user)
    {
        $report = Report::create([
            'user_id' => auth()->id(),
            'reported_user_id' => $user->id,
            'reason' => $request->input('reason'),
        ]);

        $yougileData = [
            'title' => 'New complaint submitted',
            'description' => "User ID: {$report->user_id} reported User ID: {$report->reported_user_id}\nReason: {$report->reason}",
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer kzzchVxXhChgdJMtmFXQrnRb+9sFaXI2GRC1w+GiulQl0lSkmbqNPE77jtxCJETH',
        ])->post('https://yougile.com/api-v2/tasks', $yougileData);

        if (!$response->successful()) {
            Log::error('Failed to create task in YouGile', ['response' => $response->body()]);
        }

        return redirect()->route('myprofile')->with('status', 'Complaint submitted successfully.');
    }

    public function showReportForm(User $user)
    {
        return view('report', compact('user'));
    }
}

