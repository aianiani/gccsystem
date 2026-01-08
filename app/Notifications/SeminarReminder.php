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
        $user = $notifiable;
        // Note: This notification currently only has seminar name, not full seminar object
        // If you have a full seminar object, pass it instead
        $seminar = (object) [
            'title' => $this->seminarName,
            'date' => now()->addDays(7), // Placeholder
            'start_time' => 'TBA',
            'end_time' => 'TBA',
            'venue' => 'TBA',
            'speaker' => null,
            'description' => null,
            'id' => null,
        ];

        return (new MailMessage)
            ->subject('Seminar Reminder: ' . $this->seminarName)
            ->view('emails.seminars.reminder', compact('user', 'seminar'));
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
