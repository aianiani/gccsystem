<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Appointment;

class AppointmentBookedNotification extends Notification
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
        $student = $this->appointment->student;
        $start = $this->appointment->scheduled_at->format('M d, Y');
        $time = $this->appointment->scheduled_at->format('g:i A');
        return (new MailMessage)
            ->subject('New Appointment Booked')
            ->greeting('Hello!')
            ->line("A new appointment has been booked by {$student->name}.")
            ->line("Date: {$start}")
            ->line("Time: {$time}")
            ->action('View Appointment', url('/counselor/appointments/' . $this->appointment->id));
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable)
    {
        return [
            'message' => 'Your appointment has been booked.',
            'url' => route('appointments.index'),
        ];
    }
} 