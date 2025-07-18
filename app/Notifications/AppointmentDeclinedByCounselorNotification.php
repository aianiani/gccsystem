<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Appointment;

class AppointmentDeclinedByCounselorNotification extends Notification
{
    use Queueable;

    public $appointment;

    /**
     * Create a new notification instance.
     */
    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        $counselor = $this->appointment->counselor;
        $start = $this->appointment->scheduled_at->format('M d, Y');
        $time = $this->appointment->scheduled_at->format('g:i A');
        return (new MailMessage)
            ->subject('Appointment Declined or Cancelled')
            ->greeting('Hello!')
            ->line("Your appointment with {$counselor->name} has been declined or cancelled.")
            ->line("Date: {$start}")
            ->line("Time: {$time}")
            ->line('Please book another slot or contact the GCC for assistance.')
            ->action('View Appointments', url('/appointments'));
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable)
    {
        return [
            'message' => 'Your appointment has been declined by the counselor.',
            'url' => route('appointments.index'),
        ];
    }
} 