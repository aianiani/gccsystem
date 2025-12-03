<?php
if ($argc < 3) {
    echo "Usage: php set_password.php <email> <new_password>\n";
    exit(1);
}
$email = $argv[1];
$new = $argv[2];
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$user = User::where('email', $email)->first();
if (! $user) {
    echo "User not found: $email\n";
    exit(2);
}
$user->password = Hash::make($new);
$user->save();
echo "Password updated for {$user->email}\n";
