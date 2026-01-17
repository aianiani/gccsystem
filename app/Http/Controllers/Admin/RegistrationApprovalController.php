<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationApprovedMail;
use App\Mail\RegistrationRejectedMail;

class RegistrationApprovalController extends Controller
{
    /**
     * Show pending registrations
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'student');

        // Apply Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('student_id', 'like', "%{$search}%");
            });
        }

        // Apply Filter by Status (Default to all if not specified, but we separate them in tabs usually)
        // However, the original code had 3 separate queries for tabs. 
        // We will keep the 3 variables but apply filters to them if needed, or better:
        // The tabs act as the primary status filter. 
        // The additional filters (college, course) should apply to ALL lists.

        $filterClosure = function ($q) use ($request) {
            if ($request->has('college') && $request->college != '') {
                $q->where('college', $request->college);
            }
            if ($request->has('course') && $request->course != '') {
                $q->where('course', $request->course);
            }
            // Date Range Filter
            if ($request->has('date_from') && $request->date_from != '') {
                $q->whereDate('created_at', '>=', $request->date_from);
            }
            if ($request->has('date_to') && $request->date_to != '') {
                $q->whereDate('created_at', '<=', $request->date_to);
            }
        };

        // Apply Sorting
        $sortColumn = 'created_at';
        $sortDirection = 'desc';

        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'oldest':
                    $sortDirection = 'asc';
                    break;
                case 'name_asc':
                    $sortColumn = 'name';
                    $sortDirection = 'asc';
                    break;
                case 'name_desc':
                    $sortColumn = 'name';
                    $sortDirection = 'desc';
                    break;
                case 'latest':
                default:
                    $sortDirection = 'desc';
                    break;
            }
        }

        // Pending
        $pendingQuery = User::where('role', 'student')
            ->where('registration_status', 'pending')
            ->with(['approvedBy']);

        // Apply search/filters to pending
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $pendingQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('student_id', 'like', "%{$search}%");
            });
        }
        $filterClosure($pendingQuery);
        $pendingQuery->orderBy($sortColumn, $sortDirection);
        $pendingRegistrations = $pendingQuery->paginate(15, ['*'], 'pending_page');

        // Detect duplicates for pending registrations
        foreach ($pendingRegistrations as $user) {
            // Check for users with similar email (exact match) or similar name (fuzzy match)
            $duplicateCount = User::where('role', 'student')
                ->where('id', '!=', $user->id)
                ->where(function ($q) use ($user) {
                    $q->where('email', $user->email)
                        ->orWhere('name', 'like', "%{$user->name}%");

                    // Also check for duplicate student_id if it exists
                    if (!empty($user->student_id)) {
                        $q->orWhere('student_id', $user->student_id);
                    }
                })
                ->count();

            $user->has_potential_duplicate = $duplicateCount > 0;
            $user->duplicate_count = $duplicateCount;
        }

        // Approved
        $approvedQuery = User::where('role', 'student')
            ->where('registration_status', 'approved')
            ->with(['approvedBy']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $approvedQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('student_id', 'like', "%{$search}%");
            });
        }
        $filterClosure($approvedQuery);
        $approvedQuery->orderBy($sortColumn, $sortDirection);
        $approvedRegistrations = $approvedQuery->paginate(15, ['*'], 'approved_page');


        // Rejected
        $rejectedQuery = User::where('role', 'student')
            ->where('registration_status', 'rejected')
            ->with(['approvedBy']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $rejectedQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('student_id', 'like', "%{$search}%");
            });
        }
        $filterClosure($rejectedQuery);
        $rejectedQuery->orderBy($sortColumn, $sortDirection);
        $rejectedRegistrations = $rejectedQuery->paginate(15, ['*'], 'rejected_page');

        // Get unique colleges and courses for filter dropdowns
        $colleges = User::where('role', 'student')->whereNotNull('college')->distinct()->pluck('college');
        $courses = User::where('role', 'student')->whereNotNull('course')->distinct()->pluck('course');

        return view('admin.registration-approvals.index', compact(
            'pendingRegistrations',
            'approvedRegistrations',
            'rejectedRegistrations',
            'colleges',
            'courses'
        ));
    }

    /**
     * Show registration details
     */
    public function show(User $user)
    {
        if ($user->role !== 'student') {
            return redirect()->back()->with('error', 'Only student registrations can be reviewed.');
        }

        return view('admin.registration-approvals.show', compact('user'));
    }

    /**
     * Approve a registration
     */
    public function approve(Request $request, User $user)
    {
        if ($user->role !== 'student') {
            return redirect()->back()->with('error', 'Only student registrations can be approved.');
        }

        if ($user->registration_status !== 'pending') {
            return redirect()->back()->with('error', 'This registration is not pending approval.');
        }

        $request->validate([
            'registration_notes' => 'nullable|string|max:1000',
        ]);

        $user->update([
            'registration_status' => 'approved',
            'is_active' => true,
            'registration_notes' => $request->registration_notes,
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        // Log the approval
        UserActivity::log(auth()->id(), 'registration_approved', "Approved registration for {$user->name} ({$user->email})");

        // Send approval email to student
        try {
            Mail::to($user->email)->send(new RegistrationApprovedMail($user));
        } catch (\Exception $e) {
            // Log email sending error but don't fail the approval
            \Log::error('Failed to send approval email: ' . $e->getMessage());
        }

        return redirect()->back()
            ->with('success', "Registration for {$user->name} has been approved successfully.");
    }

    /**
     * Reject a registration
     */
    public function reject(Request $request, User $user)
    {
        if ($user->role !== 'student') {
            return redirect()->back()->with('error', 'Only student registrations can be rejected.');
        }

        if ($user->registration_status !== 'pending') {
            return redirect()->back()->with('error', 'This registration is not pending approval.');
        }

        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        $user->update([
            'registration_status' => 'rejected',
            'is_active' => false,
            'rejection_reason' => $request->rejection_reason,
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        // Log the rejection
        UserActivity::log(auth()->id(), 'registration_rejected', "Rejected registration for {$user->name} ({$user->email})");

        // Send rejection email to student
        try {
            Mail::to($user->email)->send(new RegistrationRejectedMail($user, $request->rejection_reason));
        } catch (\Exception $e) {
            // Log email sending error but don't fail the rejection
            \Log::error('Failed to send rejection email: ' . $e->getMessage());
        }

        return redirect()->back()
            ->with('success', "Registration for {$user->name} has been rejected.");
    }

    /**
     * Bulk Approve Registrations
     */
    public function bulkApprove(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id'
        ]);

        $count = 0;
        foreach ($request->user_ids as $id) {
            $user = User::find($id);
            if ($user && $user->role === 'student' && $user->registration_status === 'pending') {
                $user->update([
                    'registration_status' => 'approved',
                    'is_active' => true,
                    'approved_by' => auth()->id(),
                    'approved_at' => now(),
                ]);

                // Log activity
                UserActivity::log(auth()->id(), 'registration_approved', "Bulk Approved registration for {$user->name} ({$user->email})");

                // Send email
                try {
                    Mail::to($user->email)->send(new RegistrationApprovedMail($user));
                } catch (\Exception $e) {
                    \Log::error('Failed to send bulk approval email: ' . $e->getMessage());
                }
                $count++;
            }
        }

        return redirect()->back()->with('success', "Successfully approved {$count} students.");
    }

    /**
     * Bulk Reject Registrations
     */
    public function bulkReject(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'rejection_reason' => 'required|string|max:1000'
        ]);

        $count = 0;
        foreach ($request->user_ids as $id) {
            $user = User::find($id);
            if ($user && $user->role === 'student' && $user->registration_status === 'pending') {
                $user->update([
                    'registration_status' => 'rejected',
                    'is_active' => false,
                    'rejection_reason' => $request->rejection_reason,
                    'approved_by' => auth()->id(),
                    'approved_at' => now(),
                ]);

                // Log activity
                UserActivity::log(auth()->id(), 'registration_rejected', "Bulk Rejected registration for {$user->name} ({$user->email})");

                // Send email
                try {
                    Mail::to($user->email)->send(new RegistrationRejectedMail($user, $request->rejection_reason));
                } catch (\Exception $e) {
                    \Log::error('Failed to send bulk rejection email: ' . $e->getMessage());
                }
                $count++;
            }
        }

        return redirect()->back()->with('success', "Successfully rejected {$count} students.");
    }

    /**
     * Verify enrollment by uploading file
     */
    public function verifyEnrollment(Request $request)
    {
        $request->validate([
            'enrollment_file' => 'required|file|mimes:xlsx,xls,csv|max:5120' // Max 5MB
        ]);

        try {
            $file = $request->file('enrollment_file');
            $extension = $file->getClientOriginalExtension();

            // Parse file based on extension
            if (in_array($extension, ['xlsx', 'xls'])) {
                $data = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getRealPath());
                $sheet = $data->getActiveSheet();
                $rows = $sheet->toArray();
            } else { // csv
                $rows = [];
                if (($handle = fopen($file->getRealPath(), 'r')) !== false) {
                    while (($row = fgetcsv($handle)) !== false) {
                        $rows[] = $row;
                    }
                    fclose($handle);
                }
            }

            if (empty($rows) || count($rows) < 2) {
                return response()->json([
                    'success' => false,
                    'message' => 'File is empty or has no data rows.'
                ], 400);
            }

            // Detect column indices
            $headers = array_map('trim', array_map('strtolower', $rows[0]));
            $studentIdCol = $this->findColumn($headers, ['student id', 'student_id', 'id number', 'id', 'student number']);
            $nameCol = $this->findColumn($headers, ['full name', 'name', 'student name', 'complete name']);
            $emailCol = $this->findColumn($headers, ['email', 'email address', 'student email']);

            if ($studentIdCol === null && $nameCol === null && $emailCol === null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Could not find Student ID, Name, or Email columns in the file.'
                ], 400);
            }

            // Extract enrollment data (skip header row)
            $enrollmentData = [];
            for ($i = 1; $i < count($rows); $i++) {
                $row = $rows[$i];
                $enrollmentData[] = [
                    'student_id' => $studentIdCol !== null && isset($row[$studentIdCol]) ? trim($row[$studentIdCol]) : null,
                    'name' => $nameCol !== null && isset($row[$nameCol]) ? trim($row[$nameCol]) : null,
                    'email' => $emailCol !== null && isset($row[$emailCol]) ? trim($row[$emailCol]) : null,
                ];
            }

            // Match against pending registrations
            $pendingStudents = User::where('role', 'student')
                ->where('registration_status', 'pending')
                ->get();

            $matchedIds = [];
            $matchDetails = [];

            foreach ($enrollmentData as $enrollmentRow) {
                foreach ($pendingStudents as $student) {
                    $matchScore = 0;
                    $matchReasons = [];

                    // Student ID match (highest priority)
                    if (!empty($enrollmentRow['student_id']) && $student->student_id == $enrollmentRow['student_id']) {
                        $matchScore = 100;
                        $matchReasons[] = 'Student ID';
                    }

                    // Name match (case-insensitive, partial)
                    if (!empty($enrollmentRow['name']) && !empty($student->name)) {
                        $enrollName = strtolower($enrollmentRow['name']);
                        $studentName = strtolower($student->name);
                        if ($enrollName == $studentName || strpos($enrollName, $studentName) !== false || strpos($studentName, $enrollName) !== false) {
                            $matchScore = max($matchScore, 70);
                            $matchReasons[] = 'Name';
                        }
                    }

                    // Email match
                    if (!empty($enrollmentRow['email']) && strtolower($student->email) == strtolower($enrollmentRow['email'])) {
                        $matchScore = max($matchScore, 90);
                        $matchReasons[] = 'Email';
                    }

                    // Consider it a match if score >= 70
                    if ($matchScore >= 70) {
                        if (!in_array($student->id, $matchedIds)) {
                            $matchedIds[] = $student->id;
                            $matchDetails[] = [
                                'id' => $student->id,
                                'name' => $student->name,
                                'student_id' => $student->student_id,
                                'email' => $student->email,
                                'score' => $matchScore,
                                'reasons' => implode(' + ', $matchReasons)
                            ];
                        }
                        break;
                    }
                }
            }

            return response()->json([
                'success' => true,
                'matched_ids' => $matchedIds,
                'match_details' => $matchDetails,
                'total_enrollment' => count($enrollmentData),
                'total_matched' => count($matchedIds)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error processing file: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Helper function to find column index by possible names
     */
    private function findColumn($headers, $possibleNames)
    {
        foreach ($possibleNames as $name) {
            $index = array_search(strtolower($name), $headers);
            if ($index !== false) {
                return $index;
            }
        }
        return null;
    }

    /**
     * Get registration statistics
     */
    public function statistics()
    {
        $stats = [
            'total_pending' => User::where('role', 'student')->where('registration_status', 'pending')->count(),
            'total_approved' => User::where('role', 'student')->where('registration_status', 'approved')->count(),
            'total_rejected' => User::where('role', 'student')->where('registration_status', 'rejected')->count(),
            'pending_today' => User::where('role', 'student')
                ->where('registration_status', 'pending')
                ->whereDate('created_at', today())
                ->count(),
            'approved_today' => User::where('role', 'student')
                ->where('registration_status', 'approved')
                ->whereDate('approved_at', today())
                ->count(),
        ];

        return response()->json($stats);
    }
}
