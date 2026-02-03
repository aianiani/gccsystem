<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Appointment;

class AppointmentReminderNotification extends Notification
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
        $user = $notifiable;
        $appointment = $this->appointment;
        $isStudent = $user->role === 'student';
        $otherParty = $isStudent ? $appointment->counselor : $appointment->student;

        $date = $appointment->scheduled_at->format('F d, Y');
        $time = $appointment->scheduled_at->format('g:i A');

        return (new MailMessage)
            ->subject('Upcoming Appointment Reminder')
            ->view('emails.appointments.reminder', compact('user', 'appointment', 'isStudent', 'otherParty', 'date', 'time'));
    }

    /**
     * Get the array representation of the notification for database.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $date = $this->appointment->scheduled_at->format('M d, g:i A');
        return [
            'title' => 'Appointment Reminder',
            'message' => "Reminder: You have an upcoming counseling session on {$date}.",
            'appointment_id' => $this->appointment->id,
            'type' => 'reminder',
            'url' => route('appointments.index'),
        ];
    }
}
