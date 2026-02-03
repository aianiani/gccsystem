<?php

use App\Models\Seminar;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$seminars = Seminar::all();

echo "Seminars found: " . $seminars->count() . "\n";
foreach ($seminars as $seminar) {
    echo "- " . $seminar->name . " (ID: " . $seminar->id . ")\n";
}
