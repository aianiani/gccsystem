<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeminarSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'seminar_id',
        'date',
        'location',
        'academic_year',
        'session_type',
        'colleges',
    ];

    protected $casts = [
        'date' => 'date',
        'colleges' => 'array',
    ];

    public function seminar()
    {
        return $this->belongsTo(Seminar::class);
    }
}
