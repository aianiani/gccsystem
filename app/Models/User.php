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
        'sms_notifications_enabled',
        'phone_verified_at',
        'registration_status',
        'registration_notes',
        'approved_by',
        'approved_at',
        'rejection_reason',
        'contact_number',
        'address',
        'student_id',
        'college',
        'course',
        'year_level',
        'sex',
        'cor_file',
        'consent_agreed',
        'consent_agreed_at',
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
            'phone_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'sms_notifications_enabled' => 'boolean',
            'approved_at' => 'datetime',
            'consent_agreed' => 'boolean',
            'consent_agreed_at' => 'datetime',
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
     * Get the COR file URL
     */
    public function getCorFileUrlAttribute()
    {
        if ($this->cor_file) {
            return asset('storage/cor_files/' . $this->cor_file);
        }
        return null;
    }

    /**
     * Get the college acronym
     */
    public function getCollegeAcronymAttribute()
    {
        $map = [
            'College of Arts and Sciences' => 'CAS',
            'College of Veterinary Medicine' => 'CVM',
            'College of Forestry and Environmental Sciences' => 'CFES',
            'College of Business and Management' => 'CBM',
            'College of Nursing' => 'CON',
            'College of Human Ecology' => 'CHE',
            'College of Agriculture' => 'CA',
            'College of Information Sciences and Computing' => 'CISC',
            'College of Education' => 'CE',
            'College of Engineering' => 'COE',
        ];

        return $map[$this->college] ?? $this->college;
    }

    /**
     * Get a clean year level label (e.g., 4th Year)
     */
    public function getYearLevelLabelAttribute()
    {
        if (!$this->year_level)
            return 'N/A';

        // If it's already formatted like "4th Year" or similar, return as is
        if (str_contains(strtolower($this->year_level), 'year')) {
            return $this->year_level;
        }

        // Otherwise format it
        $suffix = 'th';
        if ($this->year_level == 1)
            $suffix = 'st';
        elseif ($this->year_level == 2)
            $suffix = 'nd';
        elseif ($this->year_level == 3)
            $suffix = 'rd';

        return $this->year_level . $suffix . ' Year';
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

    /**
     * Determine if the user's email has been verified.
     */
    public function hasVerifiedEmail(): bool
    {
        return !is_null($this->email_verified_at);
    }

    /**
     * Mark the given user's email as verified.
     */
    public function markEmailAsVerified(): bool
    {
        $this->email_verified_at = now();
        return $this->save();
    }

    /**
     * Get the e-mail address that should be used for verification.
     */
    public function getEmailForVerification(): string
    {
        return $this->email;
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
    /**
     * Check if user can access the system (active and approved)
     */
    public function canAccessSystem(): bool
    {
        return $this->is_active && $this->isApproved();
    }

    /**
     * Scope a query to only include users with a given role.
     */
    public function scopeRole($query, $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Check if user has a specific role
     */
    public function hasRole($role)
    {
        return $this->role === $role;
    }
    /**
     * Get the seminar attendances for the user.
     */
    public function seminarAttendances()
    {
        return $this->hasMany(\App\Models\SeminarAttendance::class);
    }

    /**
     * Get the seminar evaluations for the user.
     */
    public function seminarEvaluations()
    {
        return $this->hasMany(\App\Models\SeminarEvaluation::class);
    }
}
