<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Appointment;
use App\Models\User;

class AppointmentTransferredNotification extends Notification
{
    use Queueable;

    public function __construct(public Appointment $appointment, public User $fromCounselor) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        $newCounselor = $this->appointment->counselor;
        return [
            'message' => "Appointment on {$this->appointment->scheduled_at->format('M d, Y g:i A')} has been transferred from {$this->fromCounselor->name} to {$newCounselor->name}.",
            'url' => route('appointments.index'),
        ];
    }
}
