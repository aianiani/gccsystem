<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'risk_level',
        'score',
        'type',
        'notes',
    ];

    // Relationship to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 