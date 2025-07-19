<?php

namespace App\Http\Controllers;

use App\Exports\LogsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class AdminLogsController extends Controller
{
    // Export all logs as PDF, Excel, or CSV
    public function export($format)
    {
        $data = [
            'users' => \App\Models\User::all(),
            'appointments' => \App\Models\Appointment::all(),
            'assessments' => \App\Models\Assessment::all(),
            'session_notes' => \App\Models\SessionNote::all(),
            'session_feedbacks' => \App\Models\SessionFeedback::all(),
            'messages' => \App\Models\Message::all(),
            'activities' => \App\Models\UserActivity::all(),
        ];

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('admin.logs.export_pdf', $data);
            return $pdf->download('logs.pdf');
        } elseif ($format === 'csv' || $format === 'excel') {
            $ext = $format === 'csv' ? Excel::CSV : Excel::XLSX;
            return Excel::download(new LogsExport($data), "logs.$format", $ext);
        }
        return back()->with('error', 'Invalid export format.');
    }

    // Reset all logs and data (dangerous!)
    public function reset(Request $request, $type = null)
    {
        $models = [
            'users' => \App\Models\User::class,
            'appointments' => \App\Models\Appointment::class,
            'assessments' => \App\Models\Assessment::class,
            'session_notes' => \App\Models\SessionNote::class,
            'session_feedbacks' => \App\Models\SessionFeedback::class,
            'messages' => \App\Models\Message::class,
            'activities' => \App\Models\UserActivity::class,
        ];

        if ($type && isset($models[$type])) {
            $models[$type]::truncate();
            return back()->with('success', 'All ' . str_replace('_', ' ', $type) . ' have been reset.');
        }

        return back()->with('error', 'Invalid log type.');
    }
} 