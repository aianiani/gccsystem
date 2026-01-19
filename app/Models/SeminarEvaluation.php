<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeminarEvaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'seminar_id',
        'user_id',
        'rating',
        'comments',
        'answers',
    ];

    protected $casts = [
        'answers' => 'array',
    ];

    public function seminar()
    {
        return $this->belongsTo(Seminar::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
