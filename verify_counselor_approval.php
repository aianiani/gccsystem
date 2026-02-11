<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

// 1. Create a pending counselor
$counselor = User::create([
    'name' => 'Test Counselor',
    'email' => 'test_counselor_' . time() . '@example.com',
    'password' => Hash::make('password'),
    'role' => 'counselor',
    'is_active' => true, // Default for manual creation, but pending status is key
    'registration_status' => 'pending',
]);

echo "Created Counselor: {$counselor->email} (ID: {$counselor->id})\n";

// 2. Simulate the query from RegistrationApprovalController
$pendingCount = User::where('registration_status', 'pending')
    ->where('id', $counselor->id)
    ->count();

if ($pendingCount > 0) {
    echo "SUCCESS: Counselor found in pending query.\n";
} else {
    echo "FAILURE: Counselor NOT found in pending query.\n";
}

// 3. Clean up
$counselor->delete();
echo "Cleaned up test user.\n";
