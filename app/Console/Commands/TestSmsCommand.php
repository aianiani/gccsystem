<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SmsService;
use App\Models\User;

class TestSmsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:test {phone?} {--message=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test SMS sending functionality';

    protected $smsService;

    public function __construct(SmsService $smsService)
    {
        parent::__construct();
        $this->smsService = $smsService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('SMS Test Command');
        $this->info('================');
        $this->newLine();

        // Check SMS configuration
        $provider = config('sms.provider');
        $enabled = config('sms.enabled');

        $this->info("SMS Provider: {$provider}");
        $this->info("SMS Enabled: " . ($enabled ? 'Yes' : 'No'));
        $this->newLine();

        if (!$enabled) {
            $this->error('SMS is disabled in configuration!');
            $this->info('Set SMS_ENABLED=true in your .env file');
            return 1;
        }

        // Get phone number
        $phone = $this->argument('phone');

        if (!$phone) {
            // Try to get from first user with contact number
            $user = User::whereNotNull('contact_number')->first();

            if ($user) {
                $phone = $user->contact_number;
                $this->info("Using phone number from user: {$user->name} ({$phone})");
            } else {
                $this->error('No phone number provided and no users with contact numbers found!');
                $this->info('Usage: php artisan sms:test 09171234567');
                return 1;
            }
        }

        // Get message
        $message = $this->option('message') ?: 'This is a test SMS from CMU GCC System. If you receive this, SMS is working!';

        $this->info("Sending SMS to: {$phone}");
        $this->info("Message: {$message}");
        $this->newLine();

        // Send SMS
        $result = $this->smsService->send($phone, $message, null, 'test');

        if ($result) {
            $this->info('✓ SMS sent successfully!');

            if ($provider === 'log') {
                $this->info('Check storage/logs/laravel.log for the message');
            }

            $this->newLine();
            $this->info('Check the sms_logs table for delivery status:');
            $this->info('php artisan tinker');
            $this->info('>>> App\Models\SmsLog::latest()->first()');

            return 0;
        } else {
            $this->error('✗ Failed to send SMS');
            $this->info('Check the logs for error details');
            return 1;
        }
    }
}
