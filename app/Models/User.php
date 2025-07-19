<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Appointment;
use App\Models\SessionNote;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
        'avatar',
        'email_verified_at',
        'registration_status',
        'registration_notes',
        'approved_by',
        'approved_at',
        'rejection_reason',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'approved_at' => 'datetime',
        ];
    }

    /**
     * Check if user is an admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is active
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }

    /**
     * Check if user is a student
     */
    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    /**
     * Check if user is a counselor
     */
    public function isCounselor(): bool
    {
        return $this->role === 'counselor';
    }

    /**
     * Get user activities
     */
    public function activities()
    {
        return $this->hasMany(UserActivity::class);
    }

    /**
     * Get the user's appointments
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'student_id');
    }

    /**
     * Get the user's avatar URL or a default placeholder
     */
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return asset('storage/avatars/' . $this->avatar);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=2d5016&background=f4d03f&size=200';
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new \App\Notifications\EmailVerificationNotification);
    }

    public function assessments()
    {
        return $this->hasMany(\App\Models\Assessment::class);
    }

    /**
     * Get messages sent by this user
     */
    public function sentMessages()
    {
        return $this->hasMany(\App\Models\Message::class, 'sender_id');
    }

    /**
     * Get messages received by this user
     */
    public function receivedMessages()
    {
        return $this->hasMany(\App\Models\Message::class, 'recipient_id');
    }

    /**
     * Get all messages for this user (sent and received)
     */
    public function messages()
    {
        return \App\Models\Message::where('sender_id', $this->id)
            ->orWhere('recipient_id', $this->id);
    }

    /**
     * Get the admin who approved this user
     */
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Get session notes created by this counselor
     */
    public function sessionNotes()
    {
        return $this->hasMany(SessionNote::class, 'counselor_id');
    }

    /**
     * Check if user registration is pending approval
     */
    public function isPendingApproval(): bool
    {
        return $this->registration_status === 'pending';
    }

    /**
     * Check if user registration is approved
     */
    public function isApproved(): bool
    {
        return $this->registration_status === 'approved';
    }

    /**
     * Check if user registration is rejected
     */
    public function isRejected(): bool
    {
        return $this->registration_status === 'rejected';
    }

    /**
     * Check if user can access the system (active and approved)
     */
    public function canAccessSystem(): bool
    {
        return $this->is_active && $this->isApproved();
    }
}
