<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Appointment;

class AppointmentDeclinedNotification extends Notification implements ShouldQueue
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
            ->subject('Appointment Declined by Student')
            ->greeting('Hello!')
            ->line("The student {$student->name} has declined the rescheduled appointment slot.")
            ->line("Date: {$start}")
            ->line("Time: {$time}")
            ->line('You may offer a new slot or contact the student for further arrangements.')
            ->action('View Appointment', url('/counselor/appointments/' . $this->appointment->id));
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable)
    {
        $start = $this->appointment->scheduled_at->format('F j, Y');
        $time = $this->appointment->scheduled_at->format('g:i A');
        return [
            'message' => 'Your appointment scheduled for ' . $start . ' at ' . $time . ' has been declined. Please select another available slot or contact the GCC for assistance.',
            'url' => route('appointments.index'),
        ];
    }
} 