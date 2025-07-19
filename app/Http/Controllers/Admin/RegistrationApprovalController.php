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
    public function index()
    {
        $pendingRegistrations = User::where('role', 'student')
            ->where('registration_status', 'pending')
            ->with(['approvedBy'])
            ->latest()
            ->paginate(15);

        $approvedRegistrations = User::where('role', 'student')
            ->where('registration_status', 'approved')
            ->with(['approvedBy'])
            ->latest()
            ->paginate(15);

        $rejectedRegistrations = User::where('role', 'student')
            ->where('registration_status', 'rejected')
            ->with(['approvedBy'])
            ->latest()
            ->paginate(15);

        return view('admin.registration-approvals.index', compact(
            'pendingRegistrations',
            'approvedRegistrations',
            'rejectedRegistrations'
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

        return redirect()->route('admin.registration-approvals.index')
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

        return redirect()->route('admin.registration-approvals.index')
            ->with('success', "Registration for {$user->name} has been rejected.");
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
