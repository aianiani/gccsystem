<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::with('activities');

        // Apply filters
        $this->applyFilters($query, $request);

        // Sorting
        $sortField = $request->get('sort', 'created_at');
        // Validate sort field
        $allowedSorts = ['name', 'email', 'role', 'is_active', 'created_at'];
        if (!in_array($sortField, $allowedSorts)) {
            $sortField = 'created_at';
        }
        $sortDirection = $request->get('direction', 'desc');
        $sortDirection = in_array(strtolower($sortDirection), ['asc', 'desc']) ? strtolower($sortDirection) : 'desc';

        // Apply sorting priority
        $query->orderByRaw("CASE 
            WHEN role = 'admin' THEN 1 
            WHEN role = 'counselor' THEN 2 
            ELSE 3 
        END ASC");

        $query->orderBy($sortField, $sortDirection);

        // Paginate with dynamic per_page
        $perPage = $request->get('per_page', 15);
        $perPage = in_array($perPage, [15, 30, 50, 100]) ? $perPage : 15;
        $users = $query->paginate($perPage)->withQueryString();

        // Get unique colleges and courses for filter dropdowns (like Registration Approval)
        $colleges = User::where('role', 'student')->whereNotNull('college')->distinct()->pluck('college');
        $courses = User::where('role', 'student')->whereNotNull('course')->distinct()->pluck('course');
        $sexes = User::whereNotNull('sex')->distinct()->pluck('sex');

        return view('users.index', compact('users', 'colleges', 'courses', 'sexes'));
    }

    /**
     * Apply common filters to user query
     */
    private function applyFilters($query, Request $request)
    {
        // Default: Exclude pending and rejected registrations (only show approved users)
        if (!$request->filled('registration_status')) {
            $query->where(function ($q) {
                $q->where('registration_status', 'approved')
                    ->orWhereNull('registration_status');
            });
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('student_id', 'like', '%' . $search . '%');
            });
        }

        // Role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Registration Status
        if ($request->filled('registration_status')) {
            $query->where('registration_status', $request->registration_status);
        }

        // Student Filters
        if ($request->filled('college')) {
            $query->where('college', $request->college);
        }
        if ($request->filled('course')) {
            $query->where('course', $request->course); // Exact match for dropdown
        }
        if ($request->filled('year_level')) {
            $query->where('year_level', $request->year_level);
        }
        if ($request->filled('sex')) {
            $query->where('sex', $request->sex);
        }

        // Date Range Filter (Registered)
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,student,counselor',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'))
                ->with('error', 'Please correct the errors below and try again.');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_active' => true,
        ]);

        // Log activity
        UserActivity::log(auth()->id(), 'create_user', "Created user: {$user->name}", [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'role' => $user->role
        ]);

        return redirect()->route('users.index')
            ->with('success', "User '{$user->name}' has been created successfully with {$user->role} role.");
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $activities = $user->activities()->latest()->paginate(10);
        return view('users.show', compact('user', 'activities'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,student,counselor',
            'is_active' => 'nullable|boolean',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please correct the errors below and try again.');
        }

        $oldData = [
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'is_active' => $user->is_active,
            'avatar' => $user->avatar,
        ];

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'is_active' => $request->has('is_active'),
        ];

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            if ($file->isValid()) {
                $avatarName = $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                $destinationDir = storage_path('app/public/avatars');
                if (!file_exists($destinationDir)) {
                    mkdir($destinationDir, 0777, true);
                }
                $file->move($destinationDir, $avatarName);
                $updateData['avatar'] = $avatarName;
            }
        }

        $user->update($updateData);

        // Log activity
        UserActivity::log(auth()->id(), 'update_user', "Updated user: {$user->name}", [
            'user_id' => $user->id,
            'old_data' => $oldData,
            'new_data' => $user->toArray()
        ]);

        $statusMessage = $user->is_active ? 'active' : 'inactive';
        $roleMessage = $user->role === 'admin' ? 'administrator' : 'regular user';

        return redirect()->route('users.index')
            ->with('success', "User '{$user->name}' has been updated successfully. They are now a {$roleMessage} with {$statusMessage} status.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                ->with('error', 'You cannot delete your own account. Please contact another administrator if you need to remove your account.');
        }

        $userName = $user->name;
        $userEmail = $user->email;
        $user->delete();

        // Log activity
        UserActivity::log(auth()->id(), 'delete_user', "Deleted user: {$userName}", [
            'deleted_user_id' => $user->id,
            'deleted_user_email' => $user->email
        ]);

        return redirect()->route('users.index')
            ->with('success', "User '{$userName}' ({$userEmail}) has been permanently deleted from the system.");
    }

    /**
     * Toggle user active status
     */
    public function toggleStatus(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                ->with('error', 'You cannot deactivate your own account. Please contact another administrator if you need to deactivate your account.');
        }

        $oldStatus = $user->is_active;
        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'activated' : 'deactivated';
        $statusText = $user->is_active ? 'active' : 'inactive';

        // Log activity
        UserActivity::log(auth()->id(), 'toggle_user_status', "{$status} user: {$user->name}", [
            'user_id' => $user->id,
            'old_status' => $oldStatus,
            'new_status' => $user->is_active
        ]);

        return redirect()->route('users.index')
            ->with('success', "User '{$user->name}' has been {$status} successfully. Their account is now {$statusText}.");
    }

    /**
     * Export users to Excel
     */
    public function export(Request $request)
    {
        // Build the same query as index with filters
        $query = User::query();

        // Apply filters
        $this->applyFilters($query, $request);

        // Apply same sorting as index
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $allowedSorts = ['name', 'email', 'role', 'is_active', 'created_at'];
        if (!in_array($sortField, $allowedSorts)) {
            $sortField = 'created_at';
        }
        $sortDirection = in_array(strtolower($sortDirection), ['asc', 'desc']) ? strtolower($sortDirection) : 'desc';
        $query->orderBy($sortField, $sortDirection);

        // Generate filename with timestamp
        $filename = 'users_' . now()->format('Y-m-d_His') . '.xlsx';

        return Excel::download(new UsersExport($query), $filename);
    }

    /**
     * Bulk activate users
     */
    public function bulkActivate(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        $count = 0;
        $authId = auth()->id();

        foreach ($request->user_ids as $userId) {
            if ($userId == $authId)
                continue; // Skip current user

            $user = User::find($userId);
            if ($user && !$user->is_active) {
                $user->update(['is_active' => true]);
                UserActivity::log($authId, 'bulk_activate_user', "Bulk activated user: {$user->name}", ['user_id' => $userId]);
                $count++;
            }
        }

        return redirect()->back()->with('success', "Successfully activated {$count} user(s).");
    }

    /**
     * Bulk deactivate users
     */
    public function bulkDeactivate(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        $count = 0;
        $authId = auth()->id();

        foreach ($request->user_ids as $userId) {
            if ($userId == $authId)
                continue; // Skip current user

            $user = User::find($userId);
            if ($user && $user->is_active) {
                $user->update(['is_active' => false]);
                UserActivity::log($authId, 'bulk_deactivate_user', "Bulk deactivated user: {$user->name}", ['user_id' => $userId]);
                $count++;
            }
        }

        return redirect()->back()->with('success', "Successfully deactivated {$count} user(s).");
    }

    /**
     * Bulk delete users
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        $count = 0;
        $authId = auth()->id();

        foreach ($request->user_ids as $userId) {
            if ($userId == $authId)
                continue; // Skip current user

            $user = User::find($userId);
            if ($user) {
                $userName = $user->name;
                $user->delete();
                UserActivity::log($authId, 'bulk_delete_user', "Bulk deleted user: {$userName}", ['deleted_user_id' => $userId]);
                $count++;
            }
        }

        return redirect()->back()->with('success', "Successfully deleted {$count} user(s).");
    }

    /**
     * Bulk change user roles
     */
    public function bulkRoleChange(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'new_role' => 'required|in:admin,student,counselor',
        ]);

        $count = 0;
        $authId = auth()->id();

        foreach ($request->user_ids as $userId) {
            if ($userId == $authId)
                continue; // Skip current user (can't change own role)

            $user = User::find($userId);
            if ($user && $user->role !== $request->new_role) {
                $oldRole = $user->role;
                $user->update(['role' => $request->new_role]);
                UserActivity::log($authId, 'bulk_role_change', "Bulk changed role for: {$user->name} from {$oldRole} to {$request->new_role}", [
                    'user_id' => $userId,
                    'old_role' => $oldRole,
                    'new_role' => $request->new_role
                ]);
                $count++;
            }
        }

        return redirect()->back()->with('success', "Successfully changed role for {$count} user(s) to " . ucfirst($request->new_role) . ".");
    }

    /**
     * Show the authenticated user's profile.
     */
    public function profile()
    {
        $user = auth()->user();
        $activities = $user->activities()->latest()->paginate(10);

        // Return different views based on role
        if ($user->role === 'counselor') {
            return view('counselor.profile', compact('user', 'activities'));
        }

        // Fetch Seminar Attendance for students
        if ($user->role === 'student') {
            $attendances = \App\Models\SeminarAttendance::where('user_id', $user->id)->get();
            $attendanceMatrix = [];
            foreach ($attendances as $attendance) {
                $attendanceMatrix[$attendance->year_level][$attendance->seminar_name] = [
                    'attended' => true,
                    'schedule_id' => $attendance->seminar_schedule_id,
                ];
            }
            return view('profile', compact('user', 'activities', 'attendanceMatrix'));
        }

        return view('profile', compact('user', 'activities'));
    }

    /**
     * Update the authenticated user's profile info.
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        // Base validation rules for all users
        $rules = [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
            'contact_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ];

        // Add role-specific validation rules
        if ($user->role === 'student') {
            $rules = array_merge($rules, [
                'student_id' => 'nullable|string|max:50',
                'college' => 'nullable|string|max:255',
                'course' => 'nullable|string|max:255',
                'year_level' => 'nullable|string|max:50',
            ]);
        } elseif ($user->role === 'counselor') {
            $rules = array_merge($rules, [
                'license_number' => 'nullable|string|max:100',
                'specialization' => 'nullable|string|max:255',
                'years_of_experience' => 'nullable|integer|min:0',
                'education' => 'nullable|string|max:1000',
                'passkey' => 'nullable|string|max:50',
            ]);
        }

        $request->validate($rules);

        // Base update data for all users
        $updateData = $request->only([
            'name',
            'email',
            'contact_number',
            'address'
        ]);

        // Add role-specific fields
        if ($user->role === 'student') {
            $updateData = array_merge($updateData, $request->only([
                'student_id',
                'college',
                'course',
                'year_level'
            ]));
        } elseif ($user->role === 'counselor') {
            $updateData = array_merge($updateData, $request->only([
                'license_number',
                'specialization',
                'years_of_experience',
                'education',
                'passkey'
            ]));
        }

        $user->update($updateData);
        UserActivity::log($user->id, 'update_profile', 'Updated profile information');
        return back()->with('success', 'Profile updated successfully.');
    }

    /**
     * Change the authenticated user's password.
     */
    public function changePassword(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }
        $user->update(['password' => Hash::make($request->password)]);
        UserActivity::log($user->id, 'change_password', 'Changed account password');
        return back()->with('success', 'Password changed successfully.');
    }

    /**
     * Upload and update the authenticated user's avatar.
     */
    public function uploadAvatar(Request $request)
    {
        \Log::info('uploadAvatar method triggered');
        $user = auth()->user();
        if (!$user) {
            \Log::error('No authenticated user found for avatar upload.');
            return redirect()->back()->with('error', 'You must be logged in to upload an avatar.');
        }

        $validated = $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if (!$request->hasFile('avatar')) {
            \Log::error('No avatar file found in request.');
            return redirect()->back()->with('error', 'No file uploaded.');
        }

        $file = $request->file('avatar');
        if (!$file->isValid()) {
            \Log::error('Uploaded avatar file is not valid.');
            return redirect()->back()->with('error', 'Uploaded file is not valid.');
        }

        try {
            $originalName = $file->getClientOriginalName();
            $avatarName = $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();

            // Use Storage facade to store the file
            $path = $file->storeAs('avatars', $avatarName, 'public');

            if ($path) {
                // Delete old avatar if it exists and is not the default
                if ($user->avatar && \Storage::disk('public')->exists('avatars/' . $user->avatar)) {
                    \Storage::disk('public')->delete('avatars/' . $user->avatar);
                }

                $user->update(['avatar' => $avatarName]);
                \Log::info('User updated with avatar', ['user' => $user]);
                UserActivity::log($user->id, 'upload_avatar', 'Uploaded new profile avatar');
                return back()->with('success', 'Avatar updated successfully.');
            } else {
                throw new \Exception('Failed to store file.');
            }
        } catch (\Exception $e) {
            \Log::error('Avatar upload failed', ['error' => $e->getMessage()]);
            return back()->with('error', 'Avatar upload failed: ' . $e->getMessage());
        }
    }

    /**
     * Verify import file for bulk deletion
     */
    public function verifyImportDelete(Request $request)
    {
        $request->validate([
            'import_file' => 'required|file|mimes:xlsx,xls,csv|max:5120' // Max 5MB
        ]);

        try {
            $file = $request->file('import_file');
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

            // Extract file data (skip header row)
            $fileData = [];
            for ($i = 1; $i < count($rows); $i++) {
                $row = $rows[$i];
                $fileData[] = [
                    'student_id' => $studentIdCol !== null && isset($row[$studentIdCol]) ? trim($row[$studentIdCol]) : null,
                    'name' => $nameCol !== null && isset($row[$nameCol]) ? trim($row[$nameCol]) : null,
                    'email' => $emailCol !== null && isset($row[$emailCol]) ? trim($row[$emailCol]) : null,
                ];
            }

            // Get all students to match against
            // Optimization: In a real large-scale app, we might query only relevant subsets, 
            // but for typical school usage load all students (id, name, email, student_id) is okay.
            $students = User::where('role', 'student')->get(['id', 'name', 'email', 'student_id']);

            $matchedIds = [];
            $matchDetails = [];

            foreach ($fileData as $fileRow) {
                foreach ($students as $student) {
                    $matchScore = 0;
                    $matchReasons = [];

                    // Student ID match (highest priority)
                    if (!empty($fileRow['student_id']) && $student->student_id == $fileRow['student_id']) {
                        $matchScore = 100;
                        $matchReasons[] = 'Student ID';
                    }

                    // Name match (case-insensitive, partial)
                    if (!empty($fileRow['name']) && !empty($student->name)) {
                        $fName = strtolower($fileRow['name']);
                        $sName = strtolower($student->name);
                        if ($fName == $sName || strpos($fName, $sName) !== false || strpos($sName, $fName) !== false) {
                            $matchScore = max($matchScore, 70);
                            $matchReasons[] = 'Name';
                        }
                    }

                    // Email match
                    if (!empty($fileRow['email']) && strtolower($student->email) == strtolower($fileRow['email'])) {
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
                        break; // Stop checking this file row against other students (1-to-1 assumption for row)
                    }
                }
            }

            return response()->json([
                'success' => true,
                'matched_ids' => $matchedIds,
                'match_details' => $matchDetails,
                'total_in_file' => count($fileData),
                'count' => count($matchedIds)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error processing file: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Helper to find column index by possible names
     */
    private function findColumn($headers, $possibleNames)
    {
        foreach ($headers as $index => $header) {
            foreach ($possibleNames as $name) {
                if (str_contains($header, $name) || $header === $name) {
                    return $index;
                }
            }
        }
        return null;
    }
}
