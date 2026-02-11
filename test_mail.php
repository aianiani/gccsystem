try {
Illuminate\Support\Facades\Mail::raw('Test email from Artisan Tinker', function ($message) {
$message->to('aianmark1715@gmail.com')
->subject('SMTP Test');
});
echo "Mail sent successfully.\n";
} catch (\Exception $e) {
echo "Error sending mail: " . $e->getMessage() . "\n";
}