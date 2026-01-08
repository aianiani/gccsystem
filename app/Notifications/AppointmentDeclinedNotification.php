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
        $student = $notifiable;
        $appointment = $this->appointment;
        $reason = $appointment->decline_reason ?? null;

        $message = (new MailMessage)
            ->subject('Appointment Update')
            ->view('emails.appointments.declined', compact('student', 'appointment', 'reason'));

        $logoPath = public_path('images/logo.jpg');
        if (file_exists($logoPath)) {
            $message->embed($logoPath, 'logo');
        }

        return $message;
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