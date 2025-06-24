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
    public function index()
    {
        $users = User::with('activities')->paginate(10);
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
            'role' => 'required|in:admin,user',
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
            'role' => 'required|in:admin,user',
            'is_active' => 'boolean',
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
        ];

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'is_active' => $request->has('is_active'),
        ]);

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
        return view('profile', compact('user', 'activities'));
    }

    /**
     * Update the authenticated user's profile info.
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);
        $user->update($request->only('name', 'email'));
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
            $avatarName = $user->id . '_' . $originalName;
            $destinationDir = storage_path('app/public/avatars');
            $destination = $destinationDir . DIRECTORY_SEPARATOR . $avatarName;

            // Ensure the directory exists
            if (!file_exists($destinationDir)) {
                mkdir($destinationDir, 0777, true);
                \Log::info('Created avatars directory', ['dir' => $destinationDir]);
            }

            $file->move($destinationDir, $avatarName);
            \Log::info('Avatar manually moved', ['destination' => $destination]);

            $user->update(['avatar' => $avatarName]);
            \Log::info('User updated with avatar', ['user' => $user]);
            UserActivity::log($user->id, 'upload_avatar', 'Uploaded new profile avatar');
            return back()->with('success', 'Avatar updated successfully.');
        } catch (\Exception $e) {
            \Log::error('Avatar upload failed', ['error' => $e->getMessage()]);
            return back()->with('error', 'Avatar upload failed: ' . $e->getMessage());
        }
    }
}
