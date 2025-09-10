<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Appointment;

class AppointmentRescheduleAcceptedNotification extends Notification
{
    use Queueable;

    public $appointment;
    public $oldDateTime;

    /**
     * Create a new notification instance.
     * @param Appointment $appointment
     * @param string $oldDateTime
     */
    public function __construct(Appointment $appointment, $oldDateTime)
    {
        $this->appointment = $appointment;
        $this->oldDateTime = $oldDateTime;
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
        $student = $this->appointment->student;
        $newDate = $this->appointment->scheduled_at->format('F j, Y');
        $newTime = $this->appointment->scheduled_at->format('g:i A');
        return (new MailMessage)
            ->subject('Rescheduled Appointment Accepted by Student')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('The rescheduled date of ' . $this->oldDateTime . ' has been accepted by ' . ($student ? $student->name : 'the student') . '.')
            ->line('New scheduled appointment date and time is: ' . $newDate . ' at ' . $newTime)
            ->action('View Appointment', url('/counselor/appointments/' . $this->appointment->id))
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
        $student = $this->appointment->student;
        $newDate = $this->appointment->scheduled_at->format('F j, Y');
        $newTime = $this->appointment->scheduled_at->format('g:i A');
        return [
            'message' => 'The rescheduled date of ' . $this->oldDateTime . ' has been accepted by ' . ($student ? $student->name : 'the student') . '. New scheduled appointment: ' . $newDate . ' at ' . $newTime . '.',
            'url' => url('/counselor/appointments/' . $this->appointment->id),
        ];
    }
} 