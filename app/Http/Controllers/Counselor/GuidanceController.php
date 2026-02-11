<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SeminarAttendance;
use Illuminate\Http\Request;

class GuidanceController extends Controller
{
    public function index(Request $request)
    {
        $query = User::role('student');

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('student_id', 'like', "%{$search}%");
            });
        }

        if ($request->filled('year_level')) {
            $yearLevel = $request->year_level;
            $query->where(function ($q) use ($yearLevel) {
                $q->where('year_level', $yearLevel)
                    ->orWhere('year_level', (string) $yearLevel)
                    ->orWhere('year_level', $yearLevel . 'st Year')
                    ->orWhere('year_level', $yearLevel . 'nd Year')
                    ->orWhere('year_level', $yearLevel . 'rd Year')
                    ->orWhere('year_level', $yearLevel . 'th Year');
            });
        }

        if ($request->filled('college')) {
            $query->where('college', 'like', '%' . $request->college . '%');
        }

        // Filter by Attendance Status
        if ($request->filled('status')) {
            $seminarName = $request->filled('seminar_name') ? $request->seminar_name : null;
            $status = $request->status;

            if ($seminarName) {
                if ($status === 'attended') {
                    $query->whereHas('seminarAttendances', function ($q) use ($seminarName) {
                        $q->where('seminar_name', $seminarName)->where('status', 'completed');
                    });
                } elseif ($status === 'unlocked') {
                    $query->whereHas('seminarAttendances', function ($q) use ($seminarName) {
                        $q->where('seminar_name', $seminarName)->where('status', 'unlocked');
                    });
                } elseif ($status === 'pending') {
                    $query->whereDoesntHave('seminarAttendances', function ($q) use ($seminarName) {
                        $q->where('seminar_name', $seminarName);
                    });
                }
            } else {
                // If no seminar selected but status is requested, use year-level specific seminar logic
                $query->where(function ($q) use ($status) {
                    $seminarMap = ['1' => 'IDREAMS', '2' => '10C', '3' => 'LEADS', '4' => 'IMAGE'];
                    foreach ($seminarMap as $year => $name) {
                        $q->orWhere(function ($inner) use ($year, $name, $status) {
                            $inner->where('year_level', 'like', "%$year%")
                                ->when($status === 'attended', function ($sub) use ($name) {
                                    $sub->whereHas('seminarAttendances', fn($a) => $a->where('seminar_name', $name)->where('status', 'completed'));
                                })
                                ->when($status === 'unlocked', function ($sub) use ($name) {
                                    $sub->whereHas('seminarAttendances', fn($a) => $a->where('seminar_name', $name)->where('status', 'unlocked'));
                                })
                                ->when($status === 'pending', function ($sub) use ($name) {
                                    $sub->whereDoesntHave('seminarAttendances', fn($a) => $a->where('seminar_name', $name));
                                });
                        });
                    }
                });
            }
        }

        // Filter by Evaluation Status
        if ($request->filled('eval_status')) {
            $seminarName = $request->filled('seminar_name') ? $request->seminar_name : null;
            $evalStatus = $request->eval_status;

            if ($seminarName) {
                $seminar = \App\Models\Seminar::where('name', $seminarName)->first();
                if ($seminar) {
                    if ($evalStatus === 'done') {
                        $query->whereHas('seminarEvaluations', function ($q) use ($seminar) {
                            $q->where('seminar_id', $seminar->id);
                        });
                    } elseif ($evalStatus === 'missing') {
                        $query->whereDoesntHave('seminarEvaluations', function ($q) use ($seminar) {
                            $q->where('seminar_id', $seminar->id);
                        });
                    }
                }
            } else {
                // If no seminar selected but eval_status is requested, use year-level specific seminar logic
                $query->where(function ($q) use ($evalStatus) {
                    $seminarMap = ['1' => 'IDREAMS', '2' => '10C', '3' => 'LEADS', '4' => 'IMAGE'];
                    foreach ($seminarMap as $year => $name) {
                        $seminar = \App\Models\Seminar::where('name', $name)->first();
                        if (!$seminar)
                            continue;
                        $q->orWhere(function ($inner) use ($year, $seminar, $evalStatus) {
                            $inner->where('year_level', 'like', "%$year%")
                                ->when($evalStatus === 'done', function ($sub) use ($seminar) {
                                    $sub->whereHas('seminarEvaluations', fn($e) => $e->where('seminar_id', $seminar->id));
                                })
                                ->when($evalStatus === 'missing', function ($sub) use ($seminar) {
                                    $sub->whereDoesntHave('seminarEvaluations', fn($e) => $e->where('seminar_id', $seminar->id));
                                });
                        });
                    }
                });
            }
        }

        $perPage = $request->input('per_page', 15);
        $students = $query->with(['seminarAttendances', 'seminarEvaluations.seminar'])
            ->paginate($perPage)
            ->withQueryString();

        $allSeminars = \App\Models\Seminar::all();
        $selectedIds = session('guidance_selected_ids', []);

        return view('counselor.guidance.index', compact('students', 'allSeminars', 'perPage', 'selectedIds'));
    }

    public function clearSelection()
    {
        session()->forget(['guidance_selected_ids', 'guidance_target_seminar', 'guidance_target_year']);
        return redirect()->back()->with('success', 'Selection cleared.');
    }

    public function show(User $student)
    {
        if (!$student->hasRole('student')) {
            abort(404);
        }

        $attendances = SeminarAttendance::where('user_id', $student->id)->get();

        $attendanceMatrix = [];
        // Map seminars to their target year level for display
        $seminarYearMap = [
            'New Student Orientation Program' => 1,
            'IDREAMS' => 1,
            '10C' => 2,
            'LEADS' => 3,
            'IMAGE' => 4,
            // Add other seminars if any
        ];

        foreach ($attendances as $attendance) {
            // Determine the correct year level for this seminar
            // Use mapped year if available, otherwise fallback to stored year_level
            $displayYear = $seminarYearMap[$attendance->seminar_name] ?? $attendance->year_level;

            $attendanceMatrix[$displayYear][$attendance->seminar_name] = [
                'attended' => true, // Still needed?
                'schedule_id' => $attendance->seminar_schedule_id ?? null,
                'status' => $attendance->status,
                'attended_at' => $attendance->attended_at,
            ];
        }

        $seminars = \App\Models\Seminar::with('schedules')->get();

        $evaluations = \App\Models\SeminarEvaluation::with('seminar')
            ->where('user_id', $student->id)
            ->get()
            ->keyBy(function ($item) {
                return $item->seminar->name;
            });

        return view('counselor.guidance.show', compact('student', 'attendanceMatrix', 'seminars', 'evaluations'));
    }

    public function update(Request $request, User $student)
    {
        $request->validate([
            'seminar_name' => 'required|string',
            'year_level' => 'required|integer|min:1|max:4',
            'attended' => 'required|boolean',
            'seminar_schedule_id' => 'nullable|exists:seminar_schedules,id',
            'status' => 'nullable|string|in:attended,unlocked,completed',
        ]);

        if ($request->attended) {
            $attendance = SeminarAttendance::where([
                'user_id' => $student->id,
                'seminar_name' => $request->seminar_name,
                'year_level' => $request->year_level,
            ])->first();

            // Default status is 'attended' (Locked) for new records.
            // If explicit status is provided, use it.
            // If record exists, preserve current status unless explicit status provided.
            $defaultStatus = $attendance ? $attendance->status : 'attended';
            $status = $request->input('status', $defaultStatus);

            SeminarAttendance::updateOrCreate(
                [
                    'user_id' => $student->id,
                    'seminar_name' => $request->seminar_name,
                    'year_level' => $request->year_level,
                ],
                [
                    'attended_at' => now(),
                    'seminar_schedule_id' => $request->seminar_schedule_id,
                    'status' => $status,
                ]
            );

            // Only notify if status is explicitly becoming 'unlocked'
            if ($status === 'unlocked' && (!$attendance || $attendance->status !== 'unlocked')) {
                $student->notify(new \App\Notifications\SeminarUnlocked($request->seminar_name));
            }
        } else {
            SeminarAttendance::where('user_id', $student->id)
                ->where('seminar_name', $request->seminar_name)
                ->where('year_level', $request->year_level)
                ->delete();
        }

        return response()->json(['success' => true]);
    }

    public function updateProfile(Request $request, User $student)
    {
        $request->validate([
            'student_id' => 'nullable|string|max:255',
            'year_level' => 'required|integer|min:1|max:4',
            'college' => 'nullable|string|max:255',
            'course' => 'nullable|string|max:255',
            'sex' => 'nullable|string|in:male,female,other',
            'contact_number' => 'nullable|string|max:20',
        ]);

        $student->update([
            'student_id' => $request->student_id,
            'year_level' => $request->year_level,
            'college' => $request->college,
            'course' => $request->course,
            'sex' => $request->sex,
            'contact_number' => $request->contact_number,
        ]);

        return redirect()->back()->with('success', 'Student profile updated successfully.');
    }
}
