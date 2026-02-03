<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsentController extends Controller
{
    /**
     * Show the consent page
     */
    public function show(Request $request)
    {
        // Always show the consent page so user can review or (re)confirm.
        $context = $request->query('context');
        return view('consent', compact('context'));
    }

    /**
     * Store consent agreement
     */
    public function store(Request $request)
    {
        $request->validate([
            'consent_agreed' => 'required|accepted',
        ]);
        // Update user consent explicitly to ensure it's persisted before redirect
        $user = auth()->user();
        $user->consent_agreed = true;
        $user->consent_agreed_at = now();
        $user->save();

        // Refresh the user instance to ensure the session and model are in sync
        $user->refresh();

        // After agreeing to consent, the user should complete the DASS-42 assessment
        $routeParams = [];
        if ($request->has('context')) {
            $routeParams['context'] = $request->input('context');
        }

        return redirect()->route('assessments.dass42', $routeParams)
            ->with('success', 'Consent agreement recorded. Please complete the DASS-42 assessment.')
            ->with('just_consented', true);
    }

}
