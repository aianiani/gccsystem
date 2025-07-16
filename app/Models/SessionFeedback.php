<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionFeedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'rating',
        'comments',
        'reviewed_by_counselor',
    ];

    // Relationship to Appointment
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
} 