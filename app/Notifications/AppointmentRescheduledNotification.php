<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Appointment;

class AppointmentRescheduledNotification extends Notification
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
        $recipient = $notifiable;
        $appointment = $this->appointment;
        $originalDate = $appointment->previous_scheduled_at;
        $rescheduleReason = $appointment->reschedule_reason ?? null;
        $requiresConfirmation = true;

        $message = (new MailMessage)
            ->subject('Your Appointment Has Been Rescheduled')
            ->view('emails.appointments.rescheduled', compact('recipient', 'appointment', 'originalDate', 'rescheduleReason', 'requiresConfirmation'));

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
        $old = $this->appointment->previous_scheduled_at;
        $new = $this->appointment->scheduled_at;
        $oldStr = $old ? $old->format('F j, Y \a\t g:i A') : 'N/A';
        $newStr = $new->format('F j, Y \a\t g:i A');
        return [
            'message' => 'Your appointment on ' . $oldStr . ' has been rescheduled to ' . $newStr . '. Please accept or decline the new schedule in your dashboard.',
            'appointment_id' => $this->appointment->id,
            'url' => route('appointments.index'),
        ];
    }
}