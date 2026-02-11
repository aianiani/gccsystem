<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\User;
use App\Models\Assessment;

class AssessmentCompletedNotification extends Notification
{
    use Queueable;

    public $user;
    public $assessment;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $user, Assessment $assessment)
    {
        $this->user = $user;
        $this->assessment = $assessment;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable)
    {
        return [
            'message' => "You have successfully completed the {$this->assessment->type} assessment.",
            'url' => url('/dashboard'),
            'assessment_id' => $this->assessment->id,
            'assessment_type' => $this->assessment->type,
        ];
    }
}
