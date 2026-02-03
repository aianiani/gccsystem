<?php

use App\Models\Seminar;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$seminar = Seminar::find(5);
if ($seminar && $seminar->name === 'NSOP') {
    $seminar->name = 'New Student Orientation Program';
    $seminar->save();
    echo "Successfully updated Seminar ID 5 to 'New Student Orientation Program'.\n";
} else {
    echo "Seminar ID 5 not found or name is already correct/different.\n";
    if ($seminar)
        echo "Current name: " . $seminar->name . "\n";
}
