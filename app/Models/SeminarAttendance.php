<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeminarAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'seminar_name',
        'year_level',
        'seminar_schedule_id',
        'attended_at',
        'status',
    ];

    protected $casts = [
        'attended_at' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schedule()
    {
        return $this->belongsTo(SeminarSchedule::class, 'seminar_schedule_id');
    }
}
