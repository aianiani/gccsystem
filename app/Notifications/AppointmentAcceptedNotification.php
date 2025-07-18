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
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $counselor = $this->appointment->counselor;
        $start = $this->appointment->scheduled_at;
        // Get real slot end time
        $availability = \App\Models\Availability::where('user_id', $this->appointment->counselor_id)
            ->where('start', $start)
            ->first();
        $end = $availability ? $availability->end : $start->copy()->addMinutes(30);
        $date = $start->format('F j, Y');
        $time = $start->format('g:i A') . ' – ' . (new \Carbon\Carbon($end))->format('g:i A');
        return (new MailMessage)
            ->subject('Your Appointment Has Been Accepted')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Your Appointment has been accepted, please proceed to GCC on ' . $date . ' at ' . $time . '.')
            ->action('View Appointment', url('/appointments'))
            ->line('Thank you for using our counseling services!');
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
} 