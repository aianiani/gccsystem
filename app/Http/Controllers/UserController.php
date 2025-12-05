<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::with('activities');

        // Search by name, email, or student_id
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('student_id', 'like', '%' . $search . '%');
            });
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter by status (active/inactive)
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Filter by registration status
        if ($request->filled('registration_status')) {
            $query->where('registration_status', $request->registration_status);
        }

        // Order by role (admin first), then by created_at descending (newest first)
        $users = $query->orderByRaw("CASE WHEN role = 'admin' THEN 0 ELSE 1 END")
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('users.index', compact('users'));
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
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
                'education'
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
}
