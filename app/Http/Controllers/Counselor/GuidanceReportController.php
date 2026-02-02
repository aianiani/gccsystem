<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Seminar;
use App\Models\SeminarAttendance;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GuidanceReportExport; // We might need to create this later if using Excel package classes

class GuidanceReportController extends Controller
{
    public function index()
    {
        $seminars = Seminar::all();
        return view('counselor.guidance.reports.index', compact('seminars'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'report_type' => 'required|in:missing,completed,summary',
            'year_level' => 'nullable|integer|min:1|max:4',
            'seminar_id' => 'nullable|exists:seminars,id',
            'format' => 'required|in:pdf,excel',
        ]);

        $data = $this->getReportData($request);
        $filename = 'guidance_report_' . date('Ymd_His');

        if ($request->input('format') === 'pdf') {
            $pdf = Pdf::loadView('counselor.guidance.reports.pdf', $data);
            return $pdf->download($filename . '.pdf');
        } else {
            // Simple CSV export for now if Excel class not ready, or use a generic export class
            // For simplicity in this step, let's do a raw CSV stream or use the package if simple
            // Let's stick to PDF first as primary, and maybe simple CSV for Excel

            return response()->streamDownload(function () use ($data) {
                $handle = fopen('php://output', 'w');

                // Header
                fputcsv($handle, ['Student Name', 'ID Number', 'Year Level', 'Status', 'Details']);

                foreach ($data['students'] as $student) {
                    fputcsv($handle, [
                        $student->name,
                        $student->id_number,
                        $student->year_level,
                        $student->status ?? 'N/A',
                        $student->details ?? ''
                    ]);
                }
                fclose($handle);
            }, $filename . '.csv');
        }
    }

    private function getReportData(Request $request)
    {
        $query = User::role('student');

        if ($request->year_level) {
            $query->where('year_level', $request->year_level);
        }

        $students = $query->orderBy('name')->get();
        $reportTitle = 'Guidance Attendance Report';
        $seminar = $request->seminar_id ? Seminar::find($request->seminar_id) : null;

        // Filter and Process Data based on Report Type
        $filteredStudents = collect();

        foreach ($students as $student) {
            $include = false;
            $status = '';
            $details = '';

            if ($request->report_type === 'missing') {
                // Students who MISSED a specific seminar or ANY required seminar
                if ($seminar) {
                    $attended = $student->seminarAttendances()
                        ->where('seminar_name', $seminar->name)
                        ->exists();
                    if (!$attended && $student->year_level >= $seminar->target_year_level) {
                        $include = true;
                        $status = 'Missing ' . $seminar->name;
                    }
                } else {
                    // Check all required seminars for their year
                    // Simplified logic: Check if they missed the seminar for their CURRENT year
                    // (Assuming 1 seminar per year for simplicity as per requirements)
                    $requiredSeminars = $this->getRequiredSeminarForYear($student->year_level);
                    foreach ($requiredSeminars as $seminarName) {
                        $attended = $student->seminarAttendances()
                            ->where('seminar_name', $seminarName)
                            ->exists();
                        if (!$attended) {
                            $include = true;
                            $status = 'Missing ' . $seminarName;
                            // If missing multiple, maybe concatenate or just show one. 
                            // For simplicity, last missing one overwrites or we break.
                            // Let's break to just show at least one missing.
                            break;
                        }
                    }
                }
            } elseif ($request->report_type === 'completed') {
                // Students who COMPLETED specific or all
                if ($seminar) {
                    $attended = $student->seminarAttendances()
                        ->where('seminar_name', $seminar->name)
                        ->exists();
                    if ($attended) {
                        $include = true;
                        $status = 'Completed ' . $seminar->name;
                        $attendanceRecord = $student->seminarAttendances()->where('seminar_name', $seminar->name)->first();
                        $date = $attendanceRecord->attended_at;
                        // If it's a string, parse it. If it's a Carbon object, format it.
                        $details = $date instanceof \Carbon\Carbon ? $date->format('M d, Y') : \Carbon\Carbon::parse($date)->format('M d, Y');
                    }
                } else {
                    // Completed ALL required up to their level?
                    // Let's just list completed seminars
                    $attendedCount = $student->seminarAttendances()->count();
                    if ($attendedCount > 0) {
                        $include = true;
                        $status = $attendedCount . ' Seminars Completed';
                        $details = $student->seminarAttendances->pluck('seminar_name')->join(', ');
                    }
                }
            } elseif ($request->report_type === 'summary') {
                $include = true;
                $attendedNames = $student->seminarAttendances->pluck('seminar_name')->toArray();
                $status = count($attendedNames) . ' Attended';
                $details = implode(', ', $attendedNames);
            }

            if ($include) {
                $student->status = $status;
                $student->details = $details;
                $filteredStudents->push($student);
            }
        }

        return [
            'students' => $filteredStudents,
            'title' => $reportTitle,
            'type' => ucfirst($request->report_type),
            'date' => now()->format('F d, Y'),
            'filters' => [
                'Year Level' => $request->year_level ?? 'All',
                'Seminar' => $seminar ? $seminar->name : 'All',
            ]
        ];
    }

    private function getRequiredSeminarForYear($year)
    {
        $map = [
            1 => ['New Student Orientation Program', 'IDREAMS'],
            2 => ['10C'],
            3 => ['LEADS'],
            4 => ['IMAGE']
        ];
        return $map[$year] ?? [];
    }
}
