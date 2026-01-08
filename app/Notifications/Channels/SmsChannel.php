<?php

namespace App\Notifications\Channels;

use App\Services\SmsService;
use Illuminate\Notifications\Notification;

class SmsChannel
{
    protected $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        // Get the SMS message from the notification
        $message = $notification->toSms($notifiable);

        // If message is an array, extract the message text
        if (is_array($message)) {
            $messageText = $message['message'] ?? $message['body'] ?? '';
            $notificationType = $message['type'] ?? class_basename($notification);
        } else {
            $messageText = $message;
            $notificationType = class_basename($notification);
        }

        // Send the SMS
        if (!empty($messageText)) {
            $this->smsService->sendToUser($notifiable, $messageText, $notificationType);
        }
    }
}
