<?php

namespace App\Services;

use App\Models\SmsLog;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class SmsService
{
    protected $provider;
    protected $enabled;

    public function __construct()
    {
        $this->provider = config('sms.provider', 'log');
        $this->enabled = config('sms.enabled', true);
    }

    /**
     * Send SMS to a user
     *
     * @param User $user
     * @param string $message
     * @param string|null $notificationType
     * @return bool
     */
    public function sendToUser(User $user, string $message, ?string $notificationType = null): bool
    {
        // Check if SMS is enabled globally
        if (!$this->enabled) {
            Log::info('SMS disabled globally', ['user_id' => $user->id]);
            return false;
        }

        // Check if user has SMS notifications enabled
        if (!$user->sms_notifications_enabled) {
            Log::info('SMS disabled for user', ['user_id' => $user->id]);
            return false;
        }

        // Check if user has a contact number
        if (empty($user->contact_number)) {
            Log::warning('User has no contact number', ['user_id' => $user->id]);
            return false;
        }

        return $this->send($user->contact_number, $message, $user->id, $notificationType);
    }

    /**
     * Send SMS to a phone number
     *
     * @param string $phoneNumber
     * @param string $message
     * @param int|null $userId
     * @param string|null $notificationType
     * @return bool
     */
    public function send(string $phoneNumber, string $message, ?int $userId = null, ?string $notificationType = null): bool
    {
        // Format phone number
        $formattedPhone = $this->formatPhoneNumber($phoneNumber);

        // Truncate message to 160 characters for SMS
        $message = $this->truncateMessage($message);

        // Create SMS log entry
        $smsLog = SmsLog::create([
            'user_id' => $userId,
            'phone_number' => $formattedPhone,
            'message' => $message,
            'provider' => $this->provider,
            'status' => 'pending',
            'notification_type' => $notificationType,
        ]);

        try {
            $result = match ($this->provider) {
                'twilio' => $this->sendViaTwilio($formattedPhone, $message),
                'semaphore' => $this->sendViaSemaphore($formattedPhone, $message),
                default => $this->sendViaLog($formattedPhone, $message),
            };

            // Update SMS log
            $smsLog->update([
                'status' => $result['success'] ? 'sent' : 'failed',
                'provider_response' => $result['response'] ?? null,
                'sent_at' => $result['success'] ? now() : null,
            ]);

            return $result['success'];
        } catch (Exception $e) {
            Log::error('SMS sending failed', [
                'phone' => $formattedPhone,
                'error' => $e->getMessage(),
            ]);

            $smsLog->update([
                'status' => 'failed',
                'provider_response' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Send SMS via Log driver (for testing)
     */
    protected function sendViaLog(string $phoneNumber, string $message): array
    {
        Log::channel('single')->info('SMS Message', [
            'to' => $phoneNumber,
            'message' => $message,
            'provider' => 'log',
        ]);

        return [
            'success' => true,
            'response' => 'Logged to storage/logs/laravel.log',
        ];
    }

    /**
     * Send SMS via Twilio
     */
    protected function sendViaTwilio(string $phoneNumber, string $message): array
    {
        $sid = config('sms.twilio.sid');
        $token = config('sms.twilio.auth_token');
        $from = config('sms.twilio.phone_number');

        if (empty($sid) || empty($token) || empty($from)) {
            throw new Exception('Twilio credentials not configured');
        }

        $response = Http::asForm()
            ->withBasicAuth($sid, $token)
            ->post("https://api.twilio.com/2010-04-01/Accounts/{$sid}/Messages.json", [
                'From' => $from,
                'To' => $phoneNumber,
                'Body' => $message,
            ]);

        if ($response->successful()) {
            return [
                'success' => true,
                'response' => json_encode($response->json()),
            ];
        }

        throw new Exception('Twilio API error: ' . $response->body());
    }

    /**
     * Send SMS via Semaphore
     */
    protected function sendViaSemaphore(string $phoneNumber, string $message): array
    {
        $apiKey = config('sms.semaphore.api_key');
        $senderName = config('sms.semaphore.sender_name');
        $apiUrl = config('sms.semaphore.api_url');

        if (empty($apiKey)) {
            throw new Exception('Semaphore API key not configured');
        }

        $response = Http::asForm()->post($apiUrl, [
            'apikey' => $apiKey,
            'number' => $phoneNumber,
            'message' => $message,
            'sendername' => $senderName,
        ]);

        if ($response->successful()) {
            $data = $response->json();

            // Semaphore returns array with message_id on success
            if (isset($data[0]['message_id'])) {
                return [
                    'success' => true,
                    'response' => json_encode($data),
                ];
            }
        }

        throw new Exception('Semaphore API error: ' . $response->body());
    }

    /**
     * Format phone number to E.164 format
     */
    protected function formatPhoneNumber(string $phoneNumber): string
    {
        // Remove all non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phoneNumber);

        // If starts with 0, replace with country code
        if (str_starts_with($phone, '0')) {
            $phone = config('sms.default_country_code') . substr($phone, 1);
        }

        // If doesn't start with +, add it
        if (!str_starts_with($phone, '+')) {
            $phone = '+' . $phone;
        }

        return $phone;
    }

    /**
     * Truncate message to fit SMS length (160 characters)
     */
    protected function truncateMessage(string $message): string
    {
        if (strlen($message) <= 160) {
            return $message;
        }

        return substr($message, 0, 157) . '...';
    }

    /**
     * Validate Philippine mobile number
     */
    public function isValidPhilippineNumber(string $phoneNumber): bool
    {
        $phone = preg_replace('/[^0-9]/', '', $phoneNumber);

        // Philippine mobile numbers: 09XX-XXX-XXXX (11 digits starting with 09)
        // Or +639XX-XXX-XXXX (12 digits starting with 639)
        if (preg_match('/^(09|639)\d{9}$/', $phone)) {
            return true;
        }

        return false;
    }
}
