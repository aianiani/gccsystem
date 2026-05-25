# GCC System — Data Dictionary

---

## 1. `users`

Central entity storing all system actors (students, counselors, admins).

| Column | Data Type | Constraints | Description |
|---|---|---|---|
| `id` | BIGINT | PK, Auto Increment | Unique user identifier |
| `name` | VARCHAR(255) | NOT NULL | Full name |
| `email` | VARCHAR(255) | NOT NULL, UNIQUE | Email address (used for login) |
| `email_verified_at` | TIMESTAMP | NULLABLE | When email was verified |
| `password` | VARCHAR(255) | NOT NULL | Hashed password |
| `role` | ENUM | NOT NULL, DEFAULT 'student' | `admin`, `student`, `counselor` |
| `is_active` | BOOLEAN | NOT NULL, DEFAULT TRUE | Account active status |
| `remember_token` | VARCHAR(100) | NULLABLE | Laravel "remember me" token |
| `two_factor_enabled` | BOOLEAN | NULLABLE | Whether 2FA is enabled |
| `avatar` | VARCHAR(255) | NULLABLE | Avatar filename |
| `registration_status` | VARCHAR(255) | NULLABLE | `pending`, `approved`, `rejected` |
| `registration_notes` | TEXT | NULLABLE | Admin notes on registration |
| `approved_by` | BIGINT | NULLABLE, FK → `users.id` | Admin who approved registration |
| `approved_at` | TIMESTAMP | NULLABLE | Approval timestamp |
| `rejection_reason` | TEXT | NULLABLE | Reason if registration rejected |
| `contact_number` | VARCHAR(255) | NULLABLE | Phone number |
| `address` | TEXT | NULLABLE | Home address |
| `student_id` | VARCHAR(255) | NULLABLE | University student ID |
| `college` | VARCHAR(255) | NULLABLE | College name (e.g. CAS, CVM, CFES) |
| `course` | VARCHAR(255) | NULLABLE | Degree program |
| `year_level` | VARCHAR(255) | NULLABLE | Year level (1st–6th Year) |
| `sex` | VARCHAR(255) | NULLABLE | Biological sex |
| `cor_file` | VARCHAR(255) | NULLABLE | Certificate of Registration filename |
| `consent_agreed` | BOOLEAN | NULLABLE | Whether student gave data consent |
| `consent_agreed_at` | TIMESTAMP | NULLABLE | When consent was given |
| `sms_notifications_enabled` | BOOLEAN | DEFAULT FALSE | SMS notification preference |
| `phone_verified_at` | TIMESTAMP | NULLABLE | Phone verification timestamp |
| `created_at` | TIMESTAMP | NULLABLE | Record creation |
| `updated_at` | TIMESTAMP | NULLABLE | Last update |

---

## 2. `appointments`

Counseling appointments between students and counselors.

| Column | Data Type | Constraints | Description |
|---|---|---|---|
| `id` | BIGINT | PK, Auto Increment | Unique appointment ID |
| `student_id` | BIGINT | NOT NULL, FK → `users.id` ON DELETE CASCADE | Student who booked |
| `counselor_id` | BIGINT | NOT NULL, FK → `users.id` ON DELETE CASCADE | Assigned counselor |
| `scheduled_at` | DATETIME | NOT NULL | Appointment date and time |
| `previous_scheduled_at` | DATETIME | NULLABLE | Previous schedule (if rescheduled) |
| `notes` | TEXT | NULLABLE | Student's notes for the appointment |
| `status` | ENUM | NOT NULL | `pending`, `accepted`, `declined`, `completed`, `cancelled`, `rescheduled_pending` |
| `guardian1_name` | VARCHAR(255) | NULLABLE | Primary guardian name |
| `guardian1_relationship` | VARCHAR(255) | NULLABLE | Relationship to student |
| `guardian1_contact` | VARCHAR(255) | NULLABLE | Primary guardian contact |
| `guardian2_name` | VARCHAR(255) | NULLABLE | Secondary guardian name |
| `guardian2_relationship` | VARCHAR(255) | NULLABLE | Relationship to student |
| `guardian2_contact` | VARCHAR(255) | NULLABLE | Secondary guardian contact |
| `nature_of_problem` | ENUM | NULLABLE | `Academic`, `Family`, `Personal / Emotional`, `Social`, `Psychological`, `Other` |
| `nature_of_problem_other` | TEXT | NULLABLE | Description if "Other" selected |
| `reference_number` | VARCHAR(255) | NULLABLE, UNIQUE | Booking confirmation code |
| `appointment_type` | VARCHAR(255) | NULLABLE | `Walk-in`, `Called-in`, `Referral` |
| `referral_reason` | TEXT | NULLABLE | Reason for referral |
| `referrer_name` | VARCHAR(255) | NULLABLE | Name of the referrer |
| `created_at` | TIMESTAMP | NULLABLE | Record creation |
| `updated_at` | TIMESTAMP | NULLABLE | Last update |

---

## 3. `assessments`

Psychological assessment results (DASS42, Grit, Neo, WVI).

| Column | Data Type | Constraints | Description |
|---|---|---|---|
| `id` | BIGINT | PK, Auto Increment | Unique assessment ID |
| `user_id` | BIGINT | NOT NULL, FK → `users.id` ON DELETE CASCADE | Student who took the assessment |
| `risk_level` | VARCHAR(255) | NOT NULL | Computed risk level |
| `type` | VARCHAR(255) | NULLABLE | Assessment type (DASS42, Grit, Neo, WVI) |
| `score` | JSON | NULLABLE | Assessment scores (JSON object) |
| `responses` | JSON | NULLABLE | Raw student responses per question |
| `notes` | TEXT | NULLABLE | Counselor notes |
| `case_notes` | TEXT | NULLABLE | Detailed case notes |
| `status` | VARCHAR(255) | NULLABLE | Assessment status |
| `student_comment` | TEXT | NULLABLE | Student's own comment on result |
| `created_at` | TIMESTAMP | NULLABLE | Record creation |
| `updated_at` | TIMESTAMP | NULLABLE | Last update |

---

## 4. `messages`

Real-time chat messages between students and counselors.

| Column | Data Type | Constraints | Description |
|---|---|---|---|
| `id` | BIGINT | PK, Auto Increment | Unique message ID |
| `sender_id` | BIGINT | NOT NULL, FK → `users.id` ON DELETE CASCADE | User who sent the message |
| `recipient_id` | BIGINT | NOT NULL, FK → `users.id` ON DELETE CASCADE | User who receives the message |
| `content` | TEXT | NOT NULL | Message body |
| `image` | VARCHAR(255) | NULLABLE | Attached image filename |
| `is_read` | BOOLEAN | NOT NULL, DEFAULT FALSE | Read status |
| `created_at` | TIMESTAMP | NULLABLE | Record creation |
| `updated_at` | TIMESTAMP | NULLABLE | Last update |

---

## 5. `session_notes`

Counselor notes written per counseling session under an appointment.

| Column | Data Type | Constraints | Description |
|---|---|---|---|
| `id` | BIGINT | PK, Auto Increment | Unique note ID |
| `appointment_id` | BIGINT | NOT NULL, FK → `appointments.id` ON DELETE CASCADE | Parent appointment |
| `counselor_id` | BIGINT | NOT NULL, FK → `users.id` ON DELETE CASCADE | Counselor who wrote the note |
| `note` | TEXT | NOT NULL | Session note content |
| `session_number` | INTEGER | NULLABLE | Sequential session number |
| `next_session` | DATETIME | NULLABLE | Scheduled next session date |
| `session_status` | VARCHAR(255) | NULLABLE | `scheduled`, `completed`, `missed`, `expired` |
| `attendance` | VARCHAR(255) | NULLABLE | Attendance status |
| `absence_reason` | TEXT | NULLABLE | Reason for absence |
| `created_at` | TIMESTAMP | NULLABLE | Record creation |
| `updated_at` | TIMESTAMP | NULLABLE | Last update |

---

## 6. `session_feedback`

Student feedback/rating for completed counseling sessions.

| Column | Data Type | Constraints | Description |
|---|---|---|---|
| `id` | BIGINT | PK, Auto Increment | Unique feedback ID |
| `appointment_id` | BIGINT | NOT NULL, FK → `appointments.id` ON DELETE CASCADE | Related appointment |
| `rating` | INTEGER | NOT NULL | Numeric rating |
| `comments` | TEXT | NULLABLE | Written feedback |
| `reviewed_by_counselor` | BOOLEAN | NOT NULL, DEFAULT FALSE | Whether counselor has reviewed |
| `created_at` | TIMESTAMP | NULLABLE | Record creation |
| `updated_at` | TIMESTAMP | NULLABLE | Last update |

---

## 7. `availabilities`

Counselor time slots available for booking.

| Column | Data Type | Constraints | Description |
|---|---|---|---|
| `id` | BIGINT | PK, Auto Increment | Unique availability ID |
| `user_id` | BIGINT | NOT NULL, FK → `users.id` ON DELETE CASCADE | Counselor who set the availability |
| `title` | VARCHAR(255) | NOT NULL, DEFAULT 'Available' | Slot label |
| `start` | DATETIME | NOT NULL | Start time |
| `end` | DATETIME | NOT NULL | End time |
| `created_at` | TIMESTAMP | NULLABLE | Record creation |
| `updated_at` | TIMESTAMP | NULLABLE | Last update |

---

## 8. `announcements`

System-wide announcements posted by admins/counselors.

| Column | Data Type | Constraints | Description |
|---|---|---|---|
| `id` | BIGINT | PK, Auto Increment | Unique announcement ID |
| `title` | VARCHAR(255) | NOT NULL | Announcement title |
| `content` | TEXT | NOT NULL | Full announcement body |
| `attachment` | VARCHAR(255) | NULLABLE | Attached file path |
| `images` | JSON | NULLABLE | Array of gallery image paths |
| `created_by` | BIGINT | NOT NULL, FK → `users.id` ON DELETE CASCADE | Author user |
| `created_at` | TIMESTAMP | NULLABLE | Record creation |
| `updated_at` | TIMESTAMP | NULLABLE | Last update |

---

## 9. `seminars`

Guidance seminar definitions (IDREAMS, 10C, LEADS, IMAGE).

| Column | Data Type | Constraints | Description |
|---|---|---|---|
| `id` | BIGINT | PK, Auto Increment | Unique seminar ID |
| `name` | VARCHAR(255) | NOT NULL | Seminar name (IDREAMS, 10C, LEADS, IMAGE) |
| `description` | TEXT | NULLABLE | Seminar description |
| `target_year_level` | INTEGER | NOT NULL | Year level target (1–6) |
| `created_at` | TIMESTAMP | NULLABLE | Record creation |
| `updated_at` | TIMESTAMP | NULLABLE | Last update |

---

## 10. `seminar_schedules`

Specific scheduled instances of a seminar.

| Column | Data Type | Constraints | Description |
|---|---|---|---|
| `id` | BIGINT | PK, Auto Increment | Unique schedule ID |
| `seminar_id` | BIGINT | NOT NULL, FK → `seminars.id` ON DELETE CASCADE | Parent seminar |
| `date` | DATE | NOT NULL | Schedule date |
| `location` | VARCHAR(255) | NULLABLE | Venue |
| `academic_year` | VARCHAR(255) | NULLABLE | Academic year (e.g. "2025-2026") |
| `session_type` | ENUM | NOT NULL, DEFAULT 'Morning' | `Morning`, `Afternoon` |
| `colleges` | JSON | NULLABLE | Array of targeted colleges |
| `created_at` | TIMESTAMP | NULLABLE | Record creation |
| `updated_at` | TIMESTAMP | NULLABLE | Last update |

---

## 11. `seminar_attendances`

Student attendance records per seminar schedule.

| Column | Data Type | Constraints | Description |
|---|---|---|---|
| `id` | BIGINT | PK, Auto Increment | Unique attendance ID |
| `user_id` | BIGINT | NOT NULL, FK → `users.id` ON DELETE CASCADE | Student |
| `seminar_name` | VARCHAR(255) | NOT NULL | Seminar name |
| `year_level` | INTEGER | NOT NULL | Year level (1–6) |
| `seminar_schedule_id` | BIGINT | NULLABLE, FK → `seminar_schedules.id` | Related schedule |
| `attended_at` | DATE | NULLABLE | Date attended |
| `status` | VARCHAR(255) | NULLABLE | Attendance status |
| `created_at` | TIMESTAMP | NULLABLE | Record creation |
| `updated_at` | TIMESTAMP | NULLABLE | Last update |

> **Unique Constraint**: (`user_id`, `seminar_name`, `year_level`)

---

## 12. `seminar_evaluations`

Student evaluations/feedback for attended seminars.

| Column | Data Type | Constraints | Description |
|---|---|---|---|
| `id` | BIGINT | PK, Auto Increment | Unique evaluation ID |
| `seminar_id` | BIGINT | NOT NULL, FK → `seminars.id` ON DELETE CASCADE | Evaluated seminar |
| `user_id` | BIGINT | NOT NULL, FK → `users.id` ON DELETE CASCADE | Student evaluator |
| `rating` | INTEGER | NOT NULL | Numeric rating |
| `comments` | TEXT | NULLABLE | Written comments |
| `answers` | JSON | NULLABLE | Evaluation form answers |
| `created_at` | TIMESTAMP | NULLABLE | Record creation |
| `updated_at` | TIMESTAMP | NULLABLE | Last update |

---

## 13. `sms_logs`

SMS notification delivery tracking.

| Column | Data Type | Constraints | Description |
|---|---|---|---|
| `id` | BIGINT | PK, Auto Increment | Unique log ID |
| `user_id` | BIGINT | NULLABLE, FK → `users.id` ON DELETE SET NULL | Recipient user |
| `phone_number` | VARCHAR(255) | NOT NULL | Destination phone number |
| `message` | TEXT | NOT NULL | SMS content |
| `provider` | VARCHAR(255) | NOT NULL, DEFAULT 'log' | `log`, `twilio`, `semaphore` |
| `status` | ENUM | NOT NULL, DEFAULT 'pending' | `pending`, `sent`, `failed` |
| `provider_response` | TEXT | NULLABLE | Raw API response |
| `notification_type` | VARCHAR(255) | NULLABLE | e.g. `appointment_booked`, `reminder` |
| `sent_at` | TIMESTAMP | NULLABLE | When SMS was sent |
| `created_at` | TIMESTAMP | NULLABLE | Record creation |
| `updated_at` | TIMESTAMP | NULLABLE | Last update |

---

## 14. `hero_images`

Homepage carousel/banner images (standalone — no FK relationships).

| Column | Data Type | Constraints | Description |
|---|---|---|---|
| `id` | BIGINT | PK, Auto Increment | Unique image ID |
| `title` | VARCHAR(255) | NULLABLE | Image caption |
| `image_path` | VARCHAR(255) | NOT NULL | File path to the image |
| `is_active` | BOOLEAN | NOT NULL, DEFAULT TRUE | Whether image is displayed |
| `order` | INTEGER | NOT NULL, DEFAULT 0 | Display sort order |
| `created_at` | TIMESTAMP | NULLABLE | Record creation |
| `updated_at` | TIMESTAMP | NULLABLE | Last update |

---

## 15. `resources`

Educational resources (videos, articles, files) for students.

| Column | Data Type | Constraints | Description |
|---|---|---|---|
| `id` | BIGINT | PK, Auto Increment | Unique resource ID |
| `title` | VARCHAR(255) | NOT NULL | Resource title |
| `description` | TEXT | NULLABLE | Resource description |
| `type` | VARCHAR(255) | NOT NULL | `video`, `article`, `file` |
| `content` | TEXT | NOT NULL | URL or embedded content |
| `file_path` | VARCHAR(255) | NULLABLE | Uploaded file path |
| `file_name` | VARCHAR(255) | NULLABLE | Original filename |
| `file_type` | VARCHAR(255) | NULLABLE | MIME type |
| `file_size` | BIGINT | NULLABLE | File size in bytes |
| `category` | VARCHAR(255) | NOT NULL, DEFAULT 'Mental Health' | e.g. `Mental Health`, `Orientation` |
| `is_published` | BOOLEAN | NOT NULL, DEFAULT TRUE | Visibility flag |
| `created_by` | BIGINT | NOT NULL, FK → `users.id` ON DELETE CASCADE | Author user |
| `created_at` | TIMESTAMP | NULLABLE | Record creation |
| `updated_at` | TIMESTAMP | NULLABLE | Last update |

---

## 16. `user_activities`

Audit trail logging user actions within the system.

| Column | Data Type | Constraints | Description |
|---|---|---|---|
| `id` | BIGINT | PK, Auto Increment | Unique activity log ID |
| `user_id` | BIGINT | NOT NULL, FK → `users.id` ON DELETE CASCADE | User who performed the action |
| `action` | VARCHAR(255) | NOT NULL | Action identifier (e.g. `login`, `logout`) |
| `description` | TEXT | NULLABLE | Human-readable description |
| `ip_address` | VARCHAR(255) | NULLABLE | Client IP address |
| `user_agent` | TEXT | NULLABLE | Browser/client user agent string |
| `data` | JSON | NULLABLE | Additional context data |
| `created_at` | TIMESTAMP | NULLABLE | Record creation |
| `updated_at` | TIMESTAMP | NULLABLE | Last update |

---

## 17. `notifications`

In-app and email notifications delivered to users via Laravel's notification system.

| Column | Data Type | Constraints | Description |
|---|---|---|---|
| `id` | UUID | PK | Unique notification ID |
| `type` | VARCHAR(255) | NOT NULL | Notification class name (e.g. `AppointmentConfirmed`, `AssessmentResult`, `SessionScheduled`) |
| `notifiable_type` | VARCHAR(255) | NOT NULL | Polymorphic type (e.g. `App\Models\User`) |
| `notifiable_id` | BIGINT | NOT NULL | ID of the notified user |
| `data` | TEXT (JSON) | NOT NULL | Notification payload (title, message, action URL, etc.) |
| `read_at` | TIMESTAMP | NULLABLE | When the notification was read (`NULL` = unread) |
| `created_at` | TIMESTAMP | NULLABLE | Record creation |
| `updated_at` | TIMESTAMP | NULLABLE | Last update |

> **Index**: (`notifiable_type`, `notifiable_id`) — polymorphic morph index for efficient lookups.

---

## Laravel Framework Tables

These tables are auto-generated by Laravel and are not part of the application domain model:

| Table | Purpose |
|---|---|
| `password_reset_tokens` | Stores password reset tokens (PK: `email`) |
| `sessions` | Stores HTTP session data for authenticated users |
| `cache` | Application cache storage |
| `cache_locks` | Cache lock management |
| `jobs` | Queue job storage |
| `job_batches` | Batched job tracking |
| `failed_jobs` | Failed queue job records |
| `two_factor_codes` | 2FA verification codes |
| `password_resets` | Legacy password resets table |
