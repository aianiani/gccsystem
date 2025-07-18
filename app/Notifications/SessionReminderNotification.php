<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\SessionNote;

class SessionReminderNotification extends Notification
{
    use Queueable;

    public $sessionNote;
    public $reminderType; // 'upcoming', 'missed', 'expired'

    public function __construct(SessionNote $sessionNote, $reminderType = 'upcoming')
    {
        $this->sessionNote = $sessionNote;
        $this->reminderType = $reminderType;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        $nextSessionDate = $this->sessionNote->next_session ? $this->sessionNote->next_session->format('F j, Y g:i A') : 'Not set';
        $isCounselor = $notifiable->role === 'counselor';

        switch ($this->reminderType) {
            case 'upcoming':
                return [
                    'title' => 'Session Reminder',
                    'message' => $isCounselor
                        ? "You have a counseling session scheduled with {$this->sessionNote->appointment->student->name} on {$nextSessionDate}."
                        : "Your next session is scheduled for {$nextSessionDate}. Your counselor may have added new session notes. Please be on time and check your notes.",
                    'type' => 'reminder',
                    'session_note_id' => $this->sessionNote->id,
                    'url' => route('appointments.index'),
                ];
            case 'missed':
                return [
                    'title' => 'Session Missed',
                    'message' => $isCounselor
                        ? "A session with {$this->sessionNote->appointment->student->name} scheduled for {$nextSessionDate} was missed."
                        : "Your scheduled session for {$nextSessionDate} was missed. Please contact your counselor to reschedule.",
                    'type' => 'missed',
                    'session_note_id' => $this->sessionNote->id,
                    'url' => route('appointments.index'),
                ];
            case 'expired':
                return [
                    'title' => 'Session Expired',
                    'message' => $isCounselor
                        ? "A session with {$this->sessionNote->appointment->student->name} scheduled for {$nextSessionDate} has expired."
                        : "Your scheduled session for {$nextSessionDate} has expired. Please contact your counselor.",
                    'type' => 'expired',
                    'session_note_id' => $this->sessionNote->id,
                    'url' => route('appointments.index'),
                ];
            default:
                return [
                    'title' => 'Session Update',
                    'message' => "Session update: {$nextSessionDate}",
                    'type' => 'update',
                    'session_note_id' => $this->sessionNote->id,
                    'url' => route('appointments.index'),
                ];
        }
    }
}
