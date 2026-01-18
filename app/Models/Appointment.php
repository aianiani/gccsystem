<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'student_id',
        'counselor_id',
        'scheduled_at',
        'previous_scheduled_at',
        'notes',
        'status',
        'guardian1_name',
        'guardian1_relationship',
        'guardian1_contact',
        'guardian2_name',
        'guardian2_relationship',
        'guardian2_contact',
        'nature_of_problem',
        'nature_of_problem_other',
        'appointment_type',
        'referral_reason',
        'reference_number',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'previous_scheduled_at' => 'datetime',
    ];

    // Valid statuses: pending, accepted, declined, completed, cancelled, rescheduled_pending
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function counselor()
    {
        return $this->belongsTo(User::class, 'counselor_id');
    }

    public function sessionNotes()
    {
        return $this->hasMany(SessionNote::class);
    }
}
