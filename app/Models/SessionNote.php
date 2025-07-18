<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SessionNote extends Model
{
    protected $fillable = [
        'appointment_id',
        'counselor_id',
        'note',
        'session_number',
        'next_session',
        'session_status',
        'attendance',
        'absence_reason',
    ];

    protected $casts = [
        'next_session' => 'datetime',
    ];

    // Session status constants
    const STATUS_SCHEDULED = 'scheduled';
    const STATUS_COMPLETED = 'completed';
    const STATUS_MISSED = 'missed';
    const STATUS_EXPIRED = 'expired';

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function counselor()
    {
        return $this->belongsTo(User::class, 'counselor_id');
    }
}
