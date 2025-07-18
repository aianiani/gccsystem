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
