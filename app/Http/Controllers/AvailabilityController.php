<?php

namespace App\Http\Controllers;

use App\Models\Availability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvailabilityController extends Controller
{
    // Return all availabilities for the logged-in counselor
    public function index()
    {
        $availabilities = Availability::where('user_id', Auth::id())->get();
        return response()->json($availabilities);
    }

    // Replace all availabilities for the user with the provided list
    public function store(Request $request)
    {
        $user = Auth::user();
        $data = $request->validate([
            'availabilities' => 'required|array',
            'availabilities.*.title' => 'required|string',
            'availabilities.*.start' => 'required|date',
            'availabilities.*.end' => 'required|date|after:availabilities.*.start',
        ]);
        // Remove old
        Availability::where('user_id', $user->id)->delete();
        // Insert new
        foreach ($data['availabilities'] as $slot) {
            Availability::create([
                'user_id' => $user->id,
                'title' => $slot['title'],
                'start' => $slot['start'],
                'end' => $slot['end'],
            ]);
        }
        return response()->json(['success' => true]);
    }
} 