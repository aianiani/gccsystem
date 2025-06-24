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

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin()
    {
        return view('auth.login');
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
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password'))
                ->with('error', 'Please correct the errors below and try again.');
        }

        $credentials = $request->only('email', 'password');
        $user = User::where('email', $request->email)->first();
        
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            if (!$user->isActive()) {
                Auth::logout();
                \App\Models\UserActivity::log($user->id, 'login_failed', 'Login attempt for deactivated account');
                return redirect()->route('login')
                    ->with('error', 'Your account has been deactivated. Please contact an administrator for assistance.');
            }

            // Check if email is verified
            if (!$user->hasVerifiedEmail()) {
                Auth::logout();
                \App\Models\UserActivity::log($user->id, 'login_failed', 'Login attempt with unverified email');
                return redirect()->route('login')
                    ->with('error', 'Please verify your email address before logging in. <a href="' . route('verification.resend') . '" class="underline">Click here to resend verification email</a>.');
            }

            if ($user->two_factor_enabled) {
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
                return redirect()->route('2fa.form')->with('info', 'A 2FA code has been sent to your email.');
            }

            // Log login activity
            \App\Models\UserActivity::log($user->id, 'login', 'User logged in successfully');

            $request->session()->regenerate();
            
            return redirect()->intended(route('dashboard'))
                ->with('success', "Welcome back, {$user->name}! You have successfully logged in.");
        }

        // Log failed login attempt
        \App\Models\UserActivity::log($user?->id, 'login_failed', 'Invalid credentials');
        return redirect()->route('login')
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
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
            'role' => 'user', // Default role
        ]);

        // Send email verification
        $user->sendEmailVerificationNotification();

        // Log registration activity
        UserActivity::log($user->id, 'register', 'User registered successfully');

        return redirect()->route('login')
            ->with('success', "Welcome to our platform, {$user->name}! We've sent you an email verification link. Please check your email and click the verification link to activate your account.");
    }

    /**
     * Handle email verification
     */
    public function verify(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);

        if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return redirect()->route('login')
                ->with('error', 'Invalid verification link.');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('login')
                ->with('info', 'Your email has already been verified.');
        }

        $user->markEmailAsVerified();

        // Log email verification activity
        UserActivity::log($user->id, 'email_verified', 'User email verified successfully');

        return redirect()->route('login')
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
            return redirect()->route('login')
                ->with('info', 'Your email has already been verified.');
        }

        $user->sendEmailVerificationNotification();

        // Log resend verification activity
        UserActivity::log($user->id, 'verification_resent', 'Email verification resent');

        return redirect()->route('login')
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

            return redirect()->route('login')
                ->with('success', "You have been successfully logged out. Thank you for using our platform, {$userName}!");
        }

        return redirect()->route('login')
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
        return redirect()->route('login')->with('success', 'Your password has been reset! You can now log in.');
    }

    /**
     * Show the 2FA code entry form.
     */
    public function showTwoFactorForm(Request $request)
    {
        if (!$request->session()->has('2fa:user:id')) {
            return redirect()->route('login')->with('error', '2FA session expired. Please log in again.');
        }
        return view('auth.twofactor');
    }

    /**
     * Verify the 2FA code.
     */
    public function verifyTwoFactorCode(Request $request)
    {
        $request->validate(['code' => 'required|digits:6']);
        $userId = $request->session()->get('2fa:user:id');
        if (!$userId) {
            return redirect()->route('login')->with('error', '2FA session expired. Please log in again.');
        }
        $record = DB::table('two_factor_codes')->where('user_id', $userId)->first();
        if (!$record) {
            return redirect()->route('login')->with('error', 'No 2FA code found. Please log in again.');
        }
        // Check code and expiry (5 minutes)
        if ($record->code == $request->code && now()->diffInMinutes($record->created_at) < 5) {
            // Clean up
            DB::table('two_factor_codes')->where('user_id', $userId)->delete();
            $user = User::find($userId);
            Auth::login($user);
            $request->session()->forget('2fa:user:id');
            // Log login activity
            UserActivity::log($user->id, 'login', 'User logged in with 2FA');
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'))->with('success', '2FA verification successful. Welcome!');
        }
        return back()->withErrors(['code' => 'Invalid or expired 2FA code.'])->withInput();
    }
}
