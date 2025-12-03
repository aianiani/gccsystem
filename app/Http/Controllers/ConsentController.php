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
        // Always show the consent page so user can review or (re)confirm.
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
        // Update user consent
        auth()->user()->update([
            'consent_agreed' => true,
            'consent_agreed_at' => now(),
        ]);

        // After agreeing to consent, the user should complete the DASS-42 assessment
        return redirect()->route('assessments.dass42')
            ->with('success', 'Consent agreement recorded. Please complete the DASS-42 assessment.');
    }
}
