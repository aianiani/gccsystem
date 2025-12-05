<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SeminarReminder extends Notification
{
    use Queueable;

    public $seminarName;

    /**
     * Create a new notification instance.
     */
    public function __construct($seminarName)
    {
        $this->seminarName = $seminarName;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Urgent: Missing Seminar Attendance')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Our records indicate that you have not yet attended the required seminar for your year level: **' . $this->seminarName . '**.')
            ->line('Please visit the Guidance Office or check the portal for upcoming schedules.')
            ->action('View Guidance Portal', url('/guidance'))
            ->line('Thank you for your attention to this matter.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
