<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\Appointment;

class AppointmentAcceptedNotification extends Notification
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
     *
     * @param  mixed  $notifiable
     * @return array
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
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $student = $notifiable;
        $counselor = $this->appointment->counselor;
        $appointment = $this->appointment;

        $message = (new MailMessage)
            ->subject('Your Appointment Has Been Accepted')
            ->view('emails.appointments.accepted', compact('student', 'counselor', 'appointment'));

        $logoPath = public_path('images/logo.jpg');
        if (file_exists($logoPath)) {
            $message->embed($logoPath, 'logo');
        }

        return $message;
    }

    /**
     * Get the array representation of the notification for database.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $counselor = $this->appointment->counselor;
        $start = $this->appointment->scheduled_at;
        $availability = \App\Models\Availability::where('user_id', $this->appointment->counselor_id)
            ->where('start', $start)
            ->first();
        $end = $availability ? $availability->end : $start->copy()->addMinutes(30);
        $date = $start->format('F j, Y');
        $time = $start->format('g:i A') . ' – ' . (new \Carbon\Carbon($end))->format('g:i A');
        return [
            'message' => 'Your appointment with ' . ($counselor ? $counselor->name : 'your counselor') . ' has been accepted. Please proceed to GCC on ' . $date . ' at ' . $time . '.',
            'url' => route('appointments.index'),
        ];
    }

    /**
     * Get the SMS representation of the notification.
     */
    public function toSms($notifiable)
    {
        $date = $this->appointment->scheduled_at->format('M d');
        $time = $this->appointment->scheduled_at->format('g:iA');
        $ref = $this->appointment->reference_number;

        return [
            'message' => "Your appointment on {$date} at {$time} has been accepted. Ref: {$ref}",
            'type' => 'appointment_accepted',
        ];
    }
}