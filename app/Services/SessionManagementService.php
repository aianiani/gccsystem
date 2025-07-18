<?php

namespace App\Services;

use App\Models\SessionNote;
use App\Models\Appointment;
use App\Notifications\SessionReminderNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SessionManagementService
{
    /**
     * Update session statuses based on current time
     */
    public function updateSessionStatuses()
    {
        $now = Carbon::now();
        
        // Update expired sessions (past 24 hours)
        SessionNote::where('session_status', 'scheduled')
            ->where('next_session', '<', $now->copy()->subHours(24))
            ->update(['session_status' => SessionNote::STATUS_EXPIRED]);
        
        // Update missed sessions (past session time but within 24 hours)
        SessionNote::where('session_status', 'scheduled')
            ->where('next_session', '<', $now)
            ->where('next_session', '>=', $now->copy()->subHours(24))
            ->update(['session_status' => SessionNote::STATUS_MISSED]);
    }

    /**
     * Send reminder notifications for upcoming sessions
     */
    public function sendReminderNotifications()
    {
        $now = Carbon::now();
        $reminderTime = $now->copy()->addHours(24); // 24 hours before
        
        $upcomingSessions = SessionNote::where('session_status', 'scheduled')
            ->where('next_session', '>=', $now)
            ->where('next_session', '<=', $reminderTime)
            ->with(['appointment.student', 'appointment.counselor'])
            ->get();
        
        foreach ($upcomingSessions as $sessionNote) {
            // Send reminder to student
            if ($sessionNote->appointment->student) {
                $sessionNote->appointment->student->notify(
                    new SessionReminderNotification($sessionNote, 'upcoming')
                );
            }
            
            // Send reminder to counselor
            if ($sessionNote->appointment->counselor) {
                $sessionNote->appointment->counselor->notify(
                    new SessionReminderNotification($sessionNote, 'upcoming')
                );
            }
        }
    }

    /**
     * Send missed session notifications
     */
    public function sendMissedSessionNotifications()
    {
        $now = Carbon::now();
        
        $missedSessions = SessionNote::where('session_status', 'missed')
            ->where('next_session', '>=', $now->copy()->subHours(1)) // Within last hour
            ->with(['appointment.student', 'appointment.counselor'])
            ->get();
        
        foreach ($missedSessions as $sessionNote) {
            // Send missed notification to student
            if ($sessionNote->appointment->student) {
                $sessionNote->appointment->student->notify(
                    new SessionReminderNotification($sessionNote, 'missed')
                );
            }
            
            // Send missed notification to counselor
            if ($sessionNote->appointment->counselor) {
                $sessionNote->appointment->counselor->notify(
                    new SessionReminderNotification($sessionNote, 'missed')
                );
            }
        }
    }

    /**
     * Send expired session notifications
     */
    public function sendExpiredSessionNotifications()
    {
        $now = Carbon::now();
        
        $expiredSessions = SessionNote::where('session_status', 'expired')
            ->where('next_session', '>=', $now->copy()->subHours(25)) // Within last 25 hours
            ->where('next_session', '<', $now->copy()->subHours(24)) // But after 24 hours
            ->with(['appointment.student', 'appointment.counselor'])
            ->get();
        
        foreach ($expiredSessions as $sessionNote) {
            // Send expired notification to student
            if ($sessionNote->appointment->student) {
                $sessionNote->appointment->student->notify(
                    new SessionReminderNotification($sessionNote, 'expired')
                );
            }
            
            // Send expired notification to counselor
            if ($sessionNote->appointment->counselor) {
                $sessionNote->appointment->counselor->notify(
                    new SessionReminderNotification($sessionNote, 'expired')
                );
            }
        }
    }

    /**
     * Automatically create new appointment when session is completed
     */
    public function createNextAppointment(SessionNote $sessionNote)
    {
        if (!$sessionNote->next_session) {
            return null;
        }

        // Check if appointment already exists for this time
        $existingAppointment = Appointment::where('counselor_id', $sessionNote->counselor_id)
            ->where('student_id', $sessionNote->appointment->student_id)
            ->where('scheduled_at', $sessionNote->next_session)
            ->first();

        if ($existingAppointment) {
            return $existingAppointment;
        }

        // Create new appointment
        $sessionNumber = $sessionNote->session_number + 1;
        $ordinal = $sessionNumber . ($sessionNumber == 1 ? 'st' : ($sessionNumber == 2 ? 'nd' : ($sessionNumber == 3 ? 'rd' : 'th')));
        $newAppointment = Appointment::create([
            'student_id' => $sessionNote->appointment->student_id,
            'counselor_id' => $sessionNote->counselor_id,
            'scheduled_at' => $sessionNote->next_session,
            'status' => 'pending',
            'notes' => "{$ordinal} Session - Auto created from session note #{$sessionNote->session_number}",
        ]);

        Log::info("Auto-created appointment {$newAppointment->id} from session note {$sessionNote->id}");
        
        return $newAppointment;
    }

    /**
     * Mark session as completed
     */
    public function markSessionAsCompleted(SessionNote $sessionNote)
    {
        $sessionNote->update(['session_status' => SessionNote::STATUS_COMPLETED]);
        
        // If there's a next session scheduled, create appointment
        if ($sessionNote->next_session) {
            $this->createNextAppointment($sessionNote);
        }
    }

    /**
     * Run all session management tasks
     */
    public function runSessionManagementTasks()
    {
        $this->updateSessionStatuses();
        $this->sendReminderNotifications();
        $this->sendMissedSessionNotifications();
        $this->sendExpiredSessionNotifications();
    }
} 