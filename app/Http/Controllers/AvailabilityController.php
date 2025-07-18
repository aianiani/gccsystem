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
        // Output as stored, no timezone conversion
        return response()->json($availabilities->map(function($a) {
            return [
                'id' => $a->id,
                'title' => $a->title,
                'start' => $a->start ? $a->start->toIso8601String() : null,
                'end' => $a->end ? $a->end->toIso8601String() : null,
            ];
        }));
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
                // Interpret the incoming time as Asia/Manila local time (do not convert from UTC)
                'start' => \Carbon\Carbon::parse($slot['start'])->timezone('Asia/Manila'),
                'end' => \Carbon\Carbon::parse($slot['end'])->timezone('Asia/Manila'),
            ]);
        }
        return response()->json(['success' => true]);
    }

    // Delete all availabilities for the logged-in counselor
    public function destroy()
    {
        $user = Auth::user();
        Availability::where('user_id', $user->id)->delete();
        return response()->json(['success' => true, 'message' => 'All availability slots have been deleted.']);
    }
} 