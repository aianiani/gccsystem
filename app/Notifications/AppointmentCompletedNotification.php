<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Appointment;

class AppointmentCompletedNotification extends Notification
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
            ->subject('Appointment Completed')
            ->greeting('Hello!')
            ->line("Your appointment with {$counselor->name} has been marked as completed.")
            ->line("Date: {$start}")
            ->line("Time: {$time}")
            ->line('You may now view your session notes if available.')
            ->action('View Appointments', url('/appointments'));
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable)
    {
        $counselor = $this->appointment->counselor;
        $start = $this->appointment->scheduled_at->format('F j, Y');
        $time = $this->appointment->scheduled_at->format('g:i A');
        return [
            'message' => 'Your appointment with ' . ($counselor ? $counselor->name : 'your counselor') . ' on ' . $start . ' at ' . $time . ' has been marked as completed. You may now view your session notes if available.',
            'url' => route('appointments.index'),
        ];
    }
} 