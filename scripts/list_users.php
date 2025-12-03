<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$users = User::select('id','email')->get();
if ($users->isEmpty()) {
    echo "No users found\n";
    exit(0);
}
foreach ($users as $u) {
    echo $u->id . "\t" . ($u->email ?? '(no-email)') . PHP_EOL;
}
