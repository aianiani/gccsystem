<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserActivity;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show dashboard
     */
    public function index()
    {
        $user = auth()->user();
        $recentActivities = $user->activities()->latest()->take(5)->get();
        
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('is_active', true)->count(),
            'admin_users' => User::where('role', 'admin')->count(),
            'total_activities' => UserActivity::count(),
        ];

        return view('dashboard', compact('user', 'recentActivities', 'stats'));
    }

    /**
     * Show user profile
     */
    public function profile()
    {
        $user = auth()->user();
        $activities = $user->activities()->latest()->paginate(10);
        
        return view('profile', compact('user', 'activities'));
    }

    /**
     * Show activity logs (admin only)
     */
    public function activities()
    {
        $activities = UserActivity::with('user')->latest()->paginate(15);
        
        return view('activities', compact('activities'));
    }
}
