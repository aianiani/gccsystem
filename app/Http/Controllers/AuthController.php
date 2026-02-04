<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin()
    {
        return redirect()->route('home');
    }

    /**
     * Handle login
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            // Log failed login attempt
            $user = User::where('email', $request->email)->first();
            \App\Models\UserActivity::log($user?->id, 'login_failed', 'Validation failed during login');
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Please correct the errors below and try again.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password'))
                ->with('error', 'Please correct the errors below and try again.');
        }

        $credentials = $request->only('email', 'password');
        $user = User::where('email', $request->email)->first();

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // For students, check if registration is approved FIRST (before active check)
            if ($user->role === 'student' && !$user->isApproved()) {
                Auth::logout();
                \App\Models\UserActivity::log($user->id, 'login_failed', 'Login attempt for unapproved student registration');

                $message = 'The GCC admin is reviewing your account. You will be notified via email once your registration is approved.';

                if ($request->expectsJson()) {
                    return response()->json([
                        'status' => 'error',
                        'message' => $message,
                    ], 403);
                }

                return redirect()->route('home')
                    ->with('error', $message);
            }

            // Check if user is active
            if (!$user->isActive()) {
                Auth::logout();
                \App\Models\UserActivity::log($user->id, 'login_failed', 'Login attempt for deactivated account');

                $message = 'Your account has been deactivated. Please contact an administrator for assistance.';

                if ($request->expectsJson()) {
                    return response()->json([
                        'status' => 'error',
                        'message' => $message,
                    ], 403);
                }

                return redirect()->route('home')->with('error', $message);
            }

            // Check if email is verified
            if (!$user->hasVerifiedEmail()) {
                Auth::logout();
                \App\Models\UserActivity::log($user->id, 'login_failed', 'Login attempt with unverified email');

                $message = 'Please verify your email address before logging in.';

                if ($request->expectsJson()) {
                    return response()->json([
                        'status' => 'error',
                        'message' => $message,
                    ], 403);
                }

                return redirect()->route('home')
                    ->with('error', $message . ' <a href="' . route('verification.resend') . '" class="underline">Click here to resend verification email</a>.');
            }

            if ($user->two_factor_enabled) {
                // Check if device is trusted (cookie exists)
                if (Cookie::get('trusted_device_' . $user->id)) {
                    // Log activity and bypass 2FA
                    \App\Models\UserActivity::log($user->id, 'login', 'User logged in via trusted device (2FA skipped)');
                    $request->session()->regenerate();
                    if ($request->expectsJson()) {
                        return response()->json([
                            'status' => 'success',
                            'message' => "Welcome back, {$user->name}! You have successfully logged in.",
                            'redirect' => route('dashboard'),
                        ], 200);
                    }
                    return redirect()->intended(route('dashboard'))
                        ->with('success', "Welcome back, {$user->name}! You have successfully logged in.");
                }

                // Generate 2FA code
                $code = random_int(100000, 999999);
                DB::table('two_factor_codes')->updateOrInsert(
                    ['user_id' => $user->id],
                    [
                        'code' => $code,
                        'created_at' => now(),
                    ]
                );
                // Send code via email
                Mail::to($user->email)->send(new \App\Mail\TwoFactorCodeMail($code, $user->name));
                // Log out the user for now, store user_id in session for 2FA
                Auth::logout();
                $request->session()->put('2fa:user:id', $user->id);
                \App\Models\UserActivity::log($user->id, 'login_2fa', '2FA code sent to user email');

                if ($request->expectsJson()) {
                    return response()->json([
                        'status' => '2fa_required',
                        'message' => 'A 2FA code has been sent to your email.',
                    ], 200);
                }

                return redirect()->route('2fa.form')->with('info', 'A 2FA code has been sent to your email.');
            }

            // Log login activity
            \App\Models\UserActivity::log($user->id, 'login', 'User logged in successfully');

            $request->session()->regenerate();

            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => "Welcome back, {$user->name}! You have successfully logged in.",
                    'redirect' => route('dashboard'),
                ], 200);
            }

            return redirect()->intended(route('dashboard'))
                ->with('success', "Welcome back, {$user->name}! You have successfully logged in.");
        }

        // Log failed login attempt
        \App\Models\UserActivity::log($user?->id, 'login_failed', 'Invalid credentials');
        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'error',
                'message' => 'The provided credentials do not match our records. Please check your email and password and try again.',
            ], 401);
        }

        return redirect()->route('home')
            ->with('error', 'The provided credentials do not match our records. Please check your email and password and try again.')
            ->withInput($request->except('password'));
    }

    /**
     * Show registration form
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle registration
     */
    public function register(Request $request)
    {
        // Build name from first_name, middle_name, last_name if provided, otherwise use name field
        $fullName = $request->name;
        if ($request->filled('first_name') && $request->filled('last_name')) {
            $nameParts = array_filter([
                $request->first_name,
                $request->middle_name,
                $request->last_name
            ]);
            $fullName = implode(' ', $nameParts);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required_without:first_name|string|max:255',
            'first_name' => 'required_without:name|string|max:255',
            'last_name' => 'required_without:name|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'contact_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'student_id' => 'nullable|string|max:50',
            'college' => 'nullable|string|max:255',
            'course' => 'nullable|string|max:255',
            'year_level' => 'nullable|string|max:50',
            'sex' => 'nullable|in:male,female,non-binary,prefer_not_to_say,other',
            'sex_other' => 'required_if:sex,other|nullable|string|max:255',
            'cor_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB max
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Please correct the errors below and try again.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'))
                ->with('error', 'Please correct the errors below and try again.');
        }

        // Handle sex - if "other" is selected, use sex_other value
        $sex = $request->sex;
        if ($request->sex === 'other' && $request->filled('sex_other')) {
            // Store as "other" in enum, but we could also store the custom value
            // For now, we'll keep it as "other" since enum doesn't support custom values
            // You might want to add a separate field for custom sex if needed
            $sex = 'other';
        }

        // Handle COR file upload
        $corFileName = null;
        if ($request->hasFile('cor_file')) {
            $file = $request->file('cor_file');
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            // Create unique filename: timestamp_userid_originalname
            $corFileName = time() . '_' . uniqid() . '.' . $extension;

            // Store in storage/app/public/cor_files using Storage facade
            $path = $file->storeAs('cor_files', $corFileName, 'public');

            if (!$path) {
                // Fallback or error handling if needed
                \Log::error('Failed to store COR file using Storage facade');
            }
        }

        $user = User::create([
            'name' => $fullName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'student', // Always set to student
            'is_active' => false, // Set as inactive until approved
            'registration_status' => 'pending', // Set as pending approval
            'contact_number' => $request->contact_number,
            'address' => $request->address,
            'student_id' => $request->student_id,
            'college' => $request->college,
            'course' => $request->course,
            'year_level' => $request->year_level,
            'sex' => $sex,
            'cor_file' => $corFileName,
        ]);

        // Send email verification
        $user->sendEmailVerificationNotification();

        // Log registration activity
        UserActivity::log($user->id, 'register', 'User registered successfully');

        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => "Welcome to our platform, {$user->name}! We've sent you an email verification link. Please check your email.",
                'redirect' => route('home'),
            ], 201);
        }

        return redirect()->route('home')
            ->with('registration_success_message', "Welcome to our platform, {$user->name}! We've sent you an email verification link. Please check your email and click the verification link. After email verification, your registration will be reviewed by an administrator. You will be notified once your account is approved.");
    }

    /**
     * Handle email verification
     */
    public function verify(Request $request, $id, $hash)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('home')
                ->with('error', 'User account not found or has been deleted.');
        }

        if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return redirect()->route('home')
                ->with('error', 'Invalid verification link.');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('home')
                ->with('info', 'Your email has already been verified.');
        }

        $user->markEmailAsVerified();

        // Log email verification activity
        UserActivity::log($user->id, 'email_verified', 'User email verified successfully');

        return redirect()->route('home')
            ->with('success', 'Your email has been verified successfully! You can now log in to your account.');
    }

    /**
     * Resend email verification
     */
    public function resend(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('home')
                ->with('info', 'Your email has already been verified.');
        }

        $user->sendEmailVerificationNotification();

        // Log resend verification activity
        UserActivity::log($user->id, 'verification_resent', 'Email verification resent');

        return redirect()->route('home')
            ->with('success', 'A new verification link has been sent to your email address.');
    }

    /**
     * Show resend verification form
     */
    public function showResendForm()
    {
        return view('auth.verification.resend');
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        if (Auth::check()) {
            $userName = Auth::user()->name;
            // Log logout activity
            UserActivity::log(Auth::id(), 'logout', 'User logged out');

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => "You have been successfully logged out. Thank you for using our platform, {$userName}!",
                    'redirect' => route('home'),
                ], 200);
            }

            return redirect()->route('home')
                ->with('success', "You have been successfully logged out. Thank you for using our platform, {$userName}!");
        }

        return redirect()->route('home')
            ->with('info', 'You were not logged in.');
    }

    /**
     * Show the form to request a password reset link.
     */
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    /**
     * Handle sending the password reset link email.
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'We can\'t find a user with that email address.']);
        }
        $token = Str::random(60);
        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            [
                'email' => $request->email,
                'token' => $token,
                'created_at' => now(),
            ]
        );
        $resetLink = url("/password/reset/{$token}?email=" . urlencode($request->email));
        // Send email (use Mail facade, to be implemented after SMTP config)
        Mail::to($request->email)->send(new \App\Mail\ResetPasswordMail($resetLink, $user->name));
        return back()->with('status', 'Password reset link has been sent! Please check your email.');
    }

    /**
     * Show the password reset form.
     */
    public function showResetForm(Request $request, $token)
    {
        $email = $request->query('email');
        return view('auth.passwords.reset', compact('token', 'email'));
    }

    /**
     * Handle resetting the password.
     */
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);
        $reset = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();
        if (!$reset) {
            return back()->withErrors(['email' => 'Invalid or expired password reset token.']);
        }
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'We can\'t find a user with that email address.']);
        }
        $user->password = Hash::make($request->password);
        $user->save();
        // Delete the reset token
        DB::table('password_resets')->where('email', $request->email)->delete();
        return redirect()->route('home')->with('success', 'Your password has been reset! You can now log in.');
    }

    /**
     * Show the 2FA code entry form (redirect to home with modal).
     */
    public function showTwoFactorForm(Request $request)
    {
        if (!$request->session()->has('2fa:user:id')) {
            return redirect()->route('home')->with('error', '2FA session expired. Please log in again.');
        }
        // Redirect to home and open 2FA modal instead of showing separate page
        return redirect()->route('home')->with('show_2fa_modal', true);
    }

    /**
     * Verify the 2FA code.
     */
    public function verifyTwoFactorCode(Request $request)
    {
        $request->validate(['code' => 'required|digits:6']);
        $userId = $request->session()->get('2fa:user:id');
        if (!$userId) {
            return redirect()->route('home')->with('error', '2FA session expired. Please log in again.');
        }
        $record = DB::table('two_factor_codes')->where('user_id', $userId)->first();
        if (!$record) {
            return redirect()->route('home')->with('error', 'No 2FA code found. Please log in again.');
        }
        // Check code and expiry (5 minutes)
        if ($record->code == $request->code && now()->diffInMinutes($record->created_at) < 5) {
            // Clean up
            DB::table('two_factor_codes')->where('user_id', $userId)->delete();
            $user = User::find($userId);
            Auth::login($user);
            $request->session()->forget('2fa:user:id');

            // Handle "Remember this device"
            if ($request->has('remember_device')) {
                Cookie::queue('trusted_device_' . $user->id, 'true', 60 * 24 * 30); // 30 days
            }

            // Log login activity
            UserActivity::log($user->id, 'login', 'User logged in with 2FA');
            $request->session()->regenerate();

            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => '2FA verification successful. Welcome!',
                    'redirect' => route('dashboard'),
                ], 200);
            }

            return redirect()->intended(route('dashboard'))->with('success', '2FA verification successful. Welcome!');
        }

        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid or expired 2FA code.',
            ], 422);
        }

        return back()->withErrors(['code' => 'Invalid or expired 2FA code.'])->withInput();
    }

    /**
     * Resend the 2FA code to the user in session.
     */
    public function resendTwoFactorCode(Request $request)
    {
        $userId = $request->session()->get('2fa:user:id');
        if (!$userId) {
            return redirect()->route('home')->with('error', '2FA session expired. Please log in again.');
        }
        $user = User::find($userId);
        if (!$user) {
            return redirect()->route('home')->with('error', 'User not found. Please log in again.');
        }
        // Generate new 2FA code
        $code = random_int(100000, 999999);
        DB::table('two_factor_codes')->updateOrInsert(
            ['user_id' => $user->id],
            [
                'code' => $code,
                'created_at' => now(),
            ]
        );
        // Send code via email
        Mail::to($user->email)->send(new \App\Mail\TwoFactorCodeMail($code, $user->name));
        \App\Models\UserActivity::log($user->id, '2fa_resent', '2FA code resent to user email');

        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'A new 2FA code has been sent to your email.',
            ], 200);
        }

        return redirect()->route('2fa.form')->with('info', 'A new 2FA code has been sent to your email.');
    }
}
