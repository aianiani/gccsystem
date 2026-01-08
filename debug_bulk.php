<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$colleges = User::role('student')->distinct()->pluck('college')->filter()->toArray();
echo "COLLEGES_START\n";
foreach ($colleges as $c) {
    echo trim($c) . "\n";
}
echo "COLLEGES_END\n";
