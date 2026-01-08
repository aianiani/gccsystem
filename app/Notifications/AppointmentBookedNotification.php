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
        $channels = ['mail', 'database'];

        // Add SMS channel if user has SMS enabled
        if ($notifiable->sms_notifications_enabled && !empty($notifiable->contact_number)) {
            $channels[] = \App\Notifications\Channels\SmsChannel::class;
        }

        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        $student = $this->appointment->student;
        $counselor = $notifiable;
        $appointment = $this->appointment;

        $message = (new MailMessage)
            ->subject('New Appointment Booked')
            ->view('emails.appointments.booked', compact('student', 'counselor', 'appointment'));

        // Embed logo
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
        $student = $this->appointment->student;
        $start = $this->appointment->scheduled_at->format('M d, Y');
        $time = $this->appointment->scheduled_at->format('g:i A');
        return [
            'message' => "A new appointment has been booked by {$student->name} on {$start} at {$time}.",
            'url' => url('/counselor/appointments/' . $this->appointment->id),
        ];
    }

    /**
     * Get the SMS representation of the notification.
     */
    public function toSms($notifiable)
    {
        $student = $this->appointment->student;
        $date = $this->appointment->scheduled_at->format('M d');
        $time = $this->appointment->scheduled_at->format('g:iA');
        $ref = $this->appointment->reference_number;

        return [
            'message' => "New appointment: {$student->name} on {$date} at {$time}. Ref: {$ref}",
            'type' => 'appointment_booked',
        ];
    }
}