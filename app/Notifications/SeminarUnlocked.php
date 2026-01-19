<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SeminarUnlocked extends Notification
{
    use Queueable;

    protected $seminarName;

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
        return ['database', 'broadcast'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => "Your evaluation form for the seminar \"{$this->seminarName}\" has been unlocked. Please complete it now.",
            'seminar_name' => $this->seminarName,
            'type' => 'seminar_unlocked',
            'action_url' => route('student.seminars.index'),
        ];
    }
}
