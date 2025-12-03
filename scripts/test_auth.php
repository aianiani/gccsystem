<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

$email = 'aianmark1715@gmail.com';
$password = 'Password123!';

// 1. Find the user
$user = User::where('email', $email)->first();
if (! $user) {
    echo "[ERROR] User not found: $email\n";
    exit(1);
}

echo "[OK] Found user: ID={$user->id}, email={$user->email}\n";
echo "     is_active={$user->is_active}, email_verified_at={$user->email_verified_at}\n";
echo "     password hash (first 20 chars): " . substr($user->password, 0, 20) . "...\n";

// 2. Test password manually
$is_correct = Hash::check($password, $user->password);
echo "[CHECK] Password matches: " . ($is_correct ? 'YES' : 'NO') . "\n";

// 3. Test Auth::attempt
$success = Auth::attempt(['email' => $email, 'password' => $password]);
echo "[AUTH] Auth::attempt result: " . ($success ? 'SUCCESS' : 'FAILED') . "\n";

if ($success) {
    echo "[INFO] Authenticated user: " . Auth::user()->email . "\n";
    Auth::logout();
} else {
    echo "[DEBUG] Auth failed. Checking for auth guards...\n";
    $guards = config('auth.guards');
    $providers = config('auth.providers');
    echo "Guards: " . json_encode(array_keys($guards)) . "\n";
    echo "Providers: " . json_encode(array_keys($providers)) . "\n";
}
