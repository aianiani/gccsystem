<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsentController extends Controller
{
    /**
     * Show the consent page
     */
    public function show()
    {
        // Check if user has completed DASS-42
        $hasDass42 = \App\Models\Assessment::where('user_id', auth()->id())
            ->where('type', 'DASS-42')
            ->exists();

        if (!$hasDass42) {
            return redirect()->route('assessments.index')
                ->with('error', 'Please complete the DASS-42 assessment first before proceeding to consent.');
        }

        // If already agreed, redirect to appointment booking
        if (auth()->user()->consent_agreed) {
            return redirect()->route('appointments.create')
                ->with('info', 'You have already agreed to the consent. Proceeding to appointment booking.');
        }

        return view('consent');
    }

    /**
     * Store consent agreement
     */
    public function store(Request $request)
    {
        $request->validate([
            'consent_agreed' => 'required|accepted',
        ]);

        // Check if user has completed DASS-42
        $hasDass42 = \App\Models\Assessment::where('user_id', auth()->id())
            ->where('type', 'DASS-42')
            ->exists();

        if (!$hasDass42) {
            return redirect()->route('assessments.index')
                ->with('error', 'Please complete the DASS-42 assessment first before proceeding to consent.');
        }

        // Update user consent
        auth()->user()->update([
            'consent_agreed' => true,
            'consent_agreed_at' => now(),
        ]);

        return redirect()->route('appointments.create')
            ->with('success', 'Consent agreement recorded. You can now book an appointment.');
    }
}
