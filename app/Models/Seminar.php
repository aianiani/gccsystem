<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seminar extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'target_year_level',
    ];

    public function schedules()
    {
        return $this->hasMany(SeminarSchedule::class);
    }

    public function evaluations()
    {
        return $this->hasMany(SeminarEvaluation::class);
    }
}
