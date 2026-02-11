$counselor = App\Models\User::create([
'name' => 'Test Counselor',
'email' => 'test_counselor_tinker_' . time() . '@example.com',
'password' => Illuminate\Support\Facades\Hash::make('password'),
'role' => 'counselor',
'is_active' => true,
'registration_status' => 'pending',
]);

$pendingCount = App\Models\User::where('registration_status', 'pending')
->where('id', $counselor->id)
->count();

echo $pendingCount > 0 ? "SUCCESS: Counselor found in pending query.\n" : "FAILURE: Counselor NOT found in pending
query.\n";

$counselor->delete();