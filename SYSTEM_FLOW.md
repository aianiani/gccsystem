# GCC System — Guidance and Counseling Center
## Central Mindanao University (CMU) — System Flow & Process Documentation

---

## Table of Contents

1. [System Overview](#1-system-overview)
2. [Technology Stack](#2-technology-stack)
3. [User Roles](#3-user-roles)
4. [Authentication Flow](#4-authentication-flow)
5. [Registration & Approval Workflow](#5-registration--approval-workflow)
6. [Appointment Booking Workflow](#6-appointment-booking-workflow)
7. [Session & Counseling Workflow](#7-session--counseling-workflow)
8. [Psychological Assessments](#8-psychological-assessments)
9. [Seminar Management](#9-seminar-management)
10. [Real-Time Messaging](#10-real-time-messaging)
11. [Admin Controls & Reporting](#11-admin-controls--reporting)
12. [Notifications System](#12-notifications-system)
13. [Database Overview](#13-database-overview)
14. [Routes Architecture](#14-routes-architecture)
15. [Security & Access Control](#15-security--access-control)

---

## 1. System Overview

The **GCC System** is a web-based Guidance and Counseling Center management platform built for **Central Mindanao University (CMU)**. It bridges students with counselors by providing:

- Online counseling appointment scheduling
- Digital psychological assessments (DASS-42, GRIT, NEO, WVI)
- Secure student-counselor messaging
- Seminar attendance and evaluation tracking
- Administrative oversight, analytics, and reporting

**Primary Goal:** Streamline the guidance and counseling workflow — from student registration through session completion — while maintaining accurate records for institutional reporting.

---

## 2. Technology Stack

| Layer | Technology |
|-------|-----------|
| Backend | Laravel 12 (PHP 8.2+) |
| Frontend | Blade Templates, Tailwind CSS, Bootstrap 5, Vanilla JS |
| Database | MySQL with Eloquent ORM |
| Real-time | Laravel Reverb + Laravel Echo (WebSocket) |
| Email | SMTP / Brevo API (custom mailer) |
| SMS | Twilio / Semaphore (Philippines) |
| PDF Export | Barryvdh/DomPDF |
| Build Tool | Vite |

---

## 3. User Roles

The system has three roles, each with distinct access and responsibilities:

| Role | Description |
|------|-------------|
| **Student** | Books appointments, takes assessments, attends seminars, chats with counselors |
| **Counselor** | Manages appointments, records session notes, views assessments, runs seminars |
| **Admin** | Approves registrations, manages all users, generates reports, manages announcements |

Role is stored in the `users.role` column and enforced via `RoleMiddleware`.

---

## 4. Authentication Flow

### 4.1 Login

```
User enters email + password
        ↓
Credentials validated
        ↓
Is email verified?  ──No──→  Redirect to resend verification
        ↓ Yes
Is registration approved? (students only)
      ──No──→  Block login, show pending/rejected message
        ↓ Yes
Is account active?  ──No──→  Block login, show deactivated message
        ↓ Yes
Is 2FA enabled?
      ──Yes──→  Generate 6-digit code → Send via email
                     ↓
              User submits code at /2fa
                     ↓
              Is device trusted? (cookie check)
              ──Yes──→  Skip code entry
                     ↓
              Code valid? ──No──→  Error / Resend option
                     ↓ Yes
        ↓ No
Session regenerated → Redirect to dashboard (role-based)
```

### 4.2 Two-Factor Authentication (2FA)

- A 6-digit code is generated and stored in the `two_factor_codes` table with a timestamp.
- Code is delivered via email.
- Once validated, a `trusted_device_{userId}` cookie is set for that browser.
- Trusted devices skip 2FA on future logins.
- 2FA can be enabled/disabled per user from their profile.

### 4.3 Password Reset

1. User requests reset at `/password/reset`.
2. System sends a reset link with a signed token to the registered email.
3. User clicks link, sets a new password.
4. Session is cleared on next login attempt.

---

## 5. Registration & Approval Workflow

### 5.1 Student Registration

```
Student fills registration form
  (name, email, password, student ID, college, course, year level, sex, COR file)
        ↓
Account created:
  registration_status = 'pending'
  is_active = false
  email_verified_at = null
        ↓
Email verification link sent automatically
        ↓
Student verifies email
        ↓
Admin sees registration in approval queue
        ↓
Admin reviews COR and student info
        ↓
  Approve ──→  is_active = true, registration_status = 'approved'
               Email sent: RegistrationApprovedMail
  Reject  ──→  registration_status = 'rejected'
               Email sent: RegistrationRejectedMail (with reason)
        ↓
Approved student can now log in
```

### 5.2 Admin Approval Controls

- Bulk approve / bulk reject multiple registrations at once.
- Filter by college, course, year level, or status.
- View uploaded COR (Certificate of Registration) before approving.
- Enrollment verification step available during review.

---

## 6. Appointment Booking Workflow

### 6.1 Student Books an Appointment

```
Student goes to Appointments → Create
        ↓
System checks:
  1. Has student agreed to consent?   ──No──→  Redirect to /consent
  2. Has student completed DASS-42?   ──No──→  Prompt to take assessment first
        ↓ Yes (both)
Student selects a counselor
        ↓
System shows available time slots from counselor's availability calendar
        ↓
Student fills in:
  - Nature of problem
  - Appointment type
  - Referral reason / referrer name (if applicable)
  - Guardian information (if applicable)
        ↓
Appointment created with status = 'pending'
Notification sent to counselor
Student receives confirmation
```

### 6.2 Appointment Status Lifecycle

```
pending
   ↓
accepted  ──────────────────────────────────→  completed
   ↓                                              ↓
rescheduled_pending ←── Counselor reschedules    Student submits feedback/rating
   ↓
Student accepts  →  accepted (new time)
Student declines →  declined
   ↓
declined / cancelled
```

### 6.3 Counselor Manages Appointments

- View all student appointments with search and filters.
- **Accept** → Appointment confirmed; student notified.
- **Decline** → Appointment rejected; student notified with reason.
- **Reschedule** → New time proposed; student receives `rescheduled_pending` notification.
- **Complete** → Mark appointment done; prompt to create a Session Note.
- Bulk approve / bulk reject / bulk delete available.
- Send SMS reminders to students directly from the appointments view.

---

## 7. Session & Counseling Workflow

### 7.1 Session Notes

After an appointment is accepted and completed, the counselor records a **Session Note**:

| Field | Description |
|-------|-------------|
| Session Number | Which session this is in the series |
| Attendance | Present / Absent |
| Absence Reason | If absent, why |
| Note / Outcome | Counselor's observations and outcomes |
| Next Session | Scheduled date/time for follow-up |
| Session Status | scheduled / completed / missed / expired |

### 7.2 Session Timeline

- Each student has a full timeline of all sessions viewable by the counselor.
- Bulk session completion is available.
- Counselors can annotate and update notes after the fact.

### 7.3 Post-Session Feedback (Student)

After a session is completed, the student receives a prompt to submit feedback:
- **Rating** (1–5 stars)
- **Comments** (optional)
- Counselor can mark feedback as reviewed.

---

## 8. Psychological Assessments

### 8.1 Available Assessments

| Assessment | Target | Purpose |
|-----------|--------|---------|
| **DASS-42** | 2nd Year Students | Depression, Anxiety, and Stress Scale |
| **GRIT Scale** | All Students | Perseverance and passion for long-term goals |
| **NEO Personality** | All Students | Five-factor personality model |
| **WVI** | All Students | Work Values Inventory (career values) |

### 8.2 Assessment Flow (Student)

```
Student visits /assessments (requires consent agreement)
        ↓
Selects an assessment type (e.g., DASS-42)
        ↓
Answers standardized questions (typically 4-point Likert scale)
        ↓
System auto-scores and stores results in `assessments` table
  (responses stored as JSON, score stored as JSON)
        ↓
Risk level assigned (for DASS-42: Normal / Mild / Moderate / Severe / Extremely Severe)
        ↓
Student can add personal comments to their result
        ↓
AssessmentCompletedMail notification sent
```

### 8.3 Counselor View

- Counselors see all student assessment results with risk classification.
- Can add case notes to individual results.
- Can export assessment results as PDF using DomPDF.
- Results are filterable by type, risk level, date.

---

## 9. Seminar Management

### 9.1 Counselor Creates a Seminar

```
Counselor goes to /counselor/seminars → Create
        ↓
Fills in:
  - Seminar name & description
  - Target year level
  - Tag/category
        ↓
Creates Seminar Schedule(s):
  - Date and location
  - Academic year
  - Session type
  - Target colleges (array)
        ↓
Students matching the target year level / college
can see the seminar in their /seminars list
```

### 9.2 Seminar Attendance Status

| Status | Meaning |
|--------|---------|
| `pending` | Student is assigned but has not yet attended |
| `unlocked` | Attendance recorded; student may now evaluate |
| `completed` | Student has submitted their evaluation |

### 9.3 Seminar Evaluation (Student)

Once attendance is unlocked:
1. Student opens the seminar evaluation form.
2. Provides a **rating** and open-ended **comments**.
3. Answers structured evaluation questions (stored as JSON).
4. Status updated to `completed`.

Counselors can bulk-import attendance records via CSV/Excel.

---

## 10. Real-Time Messaging

### 10.1 Architecture

- Built on **Laravel Reverb** (WebSocket server) + **Laravel Echo** (client-side JS).
- Messages are stored in the `messages` table.
- Broadcasting channels:
  - `App.Models.User.{id}` — private user notifications
  - `chat.{id}` — private chat channel between two users

### 10.2 Chat Flow

```
Student opens /chat/{counselor_id}
        ↓
Page loads message history from DB (Messages model)
        ↓
User types message → POST to messages endpoint
        ↓
Message stored in DB
        ↓
Broadcast event fired on private chat channel
        ↓
Recipient's browser receives event via Echo subscription
        ↓
Message appears in real-time without page reload
```

- Image attachments are supported.
- Unread message tracking via `is_read` flag.
- In-app notification badge for new messages.

---

## 11. Admin Controls & Reporting

### 11.1 User Management

- View all users with filters (role, status, college).
- **Activate / Deactivate** individual accounts.
- **Promote** a student to counselor role.
- Bulk activate / deactivate / delete users.
- View full activity log per user.

### 11.2 Content Management

| Feature | Admin Capability |
|---------|-----------------|
| Announcements | Create, edit, delete — with images and file attachments |
| Hero Images | Upload and order homepage carousel images |
| Resources | Publish/unpublish educational resources (PDFs, docs, links) |

### 11.3 Analytics & Reports

- **Analytics Dashboard:** Appointments over time, assessment counts, seminar participation.
- **Reports:** Exportable in Excel and PDF formats.
- **Audit Log:** Full activity trail — every login, approval, and user action logged with IP address and user agent.

---

## 12. Notifications System

### 12.1 In-App Notifications

Stored in Laravel's `notifications` table and shown as a bell icon badge:

| Trigger | Recipient |
|---------|-----------|
| Appointment approved | Student |
| Appointment declined | Student |
| Appointment rescheduled | Student |
| Student books appointment | Counselor |
| Assessment completed | Counselor |
| Session reminder | Student |
| New message received | Recipient user |
| Seminar attendance unlocked | Student |

### 12.2 Email Notifications

| Mailable Class | Purpose |
|---------------|---------|
| `EmailVerificationMail` | Account email verification link |
| `TwoFactorCodeMail` | 2FA code delivery |
| `RegistrationApprovedMail` | Notify student of approval |
| `RegistrationRejectedMail` | Notify student of rejection with reason |
| `ResetPasswordMail` | Password reset link |
| `AssessmentCompletedMail` | Notify on assessment submission |

### 12.3 SMS Notifications

- Providers: **Twilio** (international), **Semaphore** (Philippines), **Log** (dev/testing).
- Rate-limited per user per day (configurable).
- All SMS logged in `sms_logs` table.
- Used for: appointment reminders, booking confirmations, reschedule alerts.
- Students can opt in/out of SMS via profile settings (`sms_notifications_enabled`).

---

## 13. Database Overview

### Core Tables

| Table | Purpose |
|-------|---------|
| `users` | All users (student, counselor, admin) with profile, role, and status |
| `appointments` | All appointment records and their lifecycle status |
| `session_notes` | Counselor session notes per appointment |
| `assessments` | Student assessment responses, scores, and risk levels |
| `messages` | Chat messages between students and counselors |
| `seminars` | Seminar definitions |
| `seminar_schedules` | Scheduled seminar instances |
| `seminar_attendances` | Student attendance records per schedule |
| `seminar_evaluations` | Student evaluations of seminars |
| `session_feedback` | Student feedback/ratings after appointments |
| `availabilities` | Counselor time slot availability (calendar events) |
| `announcements` | Admin-created announcements |
| `resources` | Educational resources library |
| `hero_images` | Homepage carousel images |
| `user_activities` | Audit log of all user actions |
| `sms_logs` | Log of all SMS sent |
| `two_factor_codes` | Temporary 2FA codes |
| `notifications` | Laravel in-app notifications |
| `password_reset_tokens` | Password reset requests |

### Key Relationships

```
User (student) ──< Appointments >── User (counselor)
Appointment ──< SessionNotes
Appointment ──── SessionFeedback
User ──< Assessments
User ──< Messages >── User
User ──< SeminarAttendances >── SeminarSchedule ──── Seminar
User ──< UserActivities
User ──< Availabilities
```

---

## 14. Routes Architecture

### Public Routes (No Auth)

| Route | Purpose |
|-------|---------|
| `GET /` | Homepage with login modal |
| `GET /announcements` | Public announcements listing |
| `GET /resources` | Public resources directory |
| `POST /login` | Authenticate user |
| `POST /register` | Submit registration |
| `GET /email/verify/{id}/{hash}` | Verify email address |
| `GET/POST /password/reset` | Password reset flow |

### Student Routes

| Route | Purpose |
|-------|---------|
| `GET /dashboard` | Student dashboard |
| `GET/POST /appointments` | View and book appointments |
| `GET /consent` | Consent form |
| `GET /assessments` | Assessments page |
| `POST /assessments/{type}` | Submit assessment answers |
| `GET /seminars` | View assigned seminars |
| `GET /feedback/{id}` | Post-appointment feedback form |
| `GET /chat/{user}` | Chat with counselor |

### Counselor Routes

| Route | Purpose |
|-------|---------|
| `GET /counselor/appointments` | Manage all appointments |
| `GET /counselor/session-notes` | View and manage session notes |
| `GET /counselor/assessments` | View student assessment results |
| `GET /counselor/students` | Student roster |
| `GET /counselor/guidance` | Guidance notes per student |
| `POST /counselor/availabilities` | Set availability calendar |
| `GET/POST /counselor/seminars` | Manage seminars |
| `GET /counselor/feedback` | Review student feedback |

### Admin Routes

| Route | Purpose |
|-------|---------|
| `GET /users` | All users management |
| `GET /admin/registration-approvals` | Pending registration queue |
| `POST /users/bulk-*` | Bulk user operations |
| `GET/POST /announcements` | Create and manage announcements |
| `GET /admin/reports` | Generate reports |
| `GET /admin/analytics` | Analytics dashboard |

---

## 15. Security & Access Control

### Middleware

| Middleware | Purpose |
|-----------|---------|
| `auth` | Requires authenticated session |
| `verified` | Requires verified email |
| `RoleMiddleware` | Enforces role-based route access |
| `AdminMiddleware` | Admin-only route guard |
| `SecureHeaders` | Injects security HTTP headers |
| `VerifyCsrfToken` | CSRF protection on all POST/PUT/DELETE |

### Access Rules

- Email must be verified before login is permitted.
- Student registration must be admin-approved before account is active.
- Admin can deactivate any account at any time.
- Session notes and assessments are filtered to the owning counselor or student.
- Bulk operations are restricted to admin and counselor roles.
- All sensitive routes are protected by CSRF tokens.

### Audit Logging

Every significant user action is recorded in `user_activities`:
- Login and logout events
- Registration attempts
- Approval and rejection actions
- Appointment status changes
- Assessment submissions

The admin can filter, search, and export the full activity audit log.

---

*Last updated: May 2026 — GCC System, Central Mindanao University*
