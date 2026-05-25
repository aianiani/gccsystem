# GCC System — Entity Relationship Diagram

> **Note:** All tables include `created_at` and `updated_at` timestamp columns (omitted from diagrams for brevity).

---

## High-Level Overview

This diagram shows **all entities and their relationships** at a glance — no column details.

```mermaid
erDiagram
    users ||--o| users : "approved_by"

    users ||--o{ appointments : "books / handles"
    users ||--o{ availabilities : "sets"
    users ||--o{ assessments : "takes"
    users ||--o{ messages : "sends / receives"
    users ||--o{ session_notes : "writes"
    users ||--o{ announcements : "creates"
    users ||--o{ resources : "creates"
    users ||--o{ seminar_attendances : "attends"
    users ||--o{ seminar_evaluations : "submits"
    users ||--o{ sms_logs : "receives SMS"
    users ||--o{ user_activities : "logs"

    appointments ||--o{ session_notes : "has"
    appointments ||--o{ session_feedback : "has"

    seminars ||--o{ seminar_schedules : "has"
    seminars ||--o{ seminar_evaluations : "has"
    seminar_schedules ||--o{ seminar_attendances : "tracks"
```

---

## 1. User Management & Authentication

> **Note:** The system uses a single `users` table with a `role` column. The entities below are shown **separated by role** to visualize the distinct connections each role has.

```mermaid
erDiagram
    users ||--|| admins : "role = admin"
    users ||--|| students : "role = student"
    users ||--|| counselors : "role = counselor"

    admins ||--o{ users : "approves registration"
    admins ||--o{ announcements : "creates"
    admins ||--o{ resources : "creates"
    admins ||--o{ user_activities : "logs"

    students ||--o{ appointments : "books"
    students ||--o{ assessments : "takes"
    students ||--o{ messages : "sends / receives"
    students ||--o{ seminar_attendances : "attends"
    students ||--o{ seminar_evaluations : "submits"

    counselors ||--o{ appointments : "handles"
    counselors ||--o{ session_notes : "writes"
    counselors ||--o{ availabilities : "sets schedule"
    counselors ||--o{ messages : "sends / receives"
    counselors ||--o{ resources : "creates"
    
    users {
        bigint id PK
        string name
        string email UK
        timestamp email_verified_at
        string password
        enum role "admin, student, counselor"
        boolean is_active
        string remember_token
        boolean two_factor_enabled
        string avatar
        string registration_status "pending, approved, rejected"
        text registration_notes
        bigint approved_by FK
        timestamp approved_at
        text rejection_reason
        boolean consent_agreed
        timestamp consent_agreed_at
        string passkey
    }

    admins {
        bigint user_id FK
        string name
        enum role "admin"
    }

    students {
        bigint user_id FK
        string name
        string student_id
        string college
        string course
        string year_level
        string sex
        string cor_file
        string contact_number
        text address
    }

    counselors {
        bigint user_id FK
        string name
        string contact_number
        text address
        boolean sms_notifications_enabled
        timestamp phone_verified_at
    }
```

---

## 2. Appointment & Scheduling

```mermaid
erDiagram
    students ||--o{ appointments : "books"
    counselors ||--o{ appointments : "handles"
    counselors ||--o{ availabilities : "sets schedule"
    appointments ||--o{ guardian_info : "has"

    students {
        bigint id PK
        string name
        string student_id
        string college
        string course
        string year_level
    }

    counselors {
        bigint id PK
        string name
        string contact_number
    }

    appointments {
        bigint id PK
        bigint student_id FK
        bigint counselor_id FK
        datetime scheduled_at
        datetime previous_scheduled_at
        text notes
        enum status "pending, accepted, declined, completed, cancelled, rescheduled_pending"
        enum nature_of_problem "Academic, Family, Personal, Social, Psychological, Other"
        text nature_of_problem_other
        string reference_number UK
        string appointment_type "Walk-in, Called-in, Referral"
        text referral_reason
        string referrer_name
    }

    guardian_info {
        string guardian1_name
        string guardian1_relationship
        string guardian1_contact
        string guardian2_name
        string guardian2_relationship
        string guardian2_contact
    }

    availabilities {
        bigint id PK
        bigint user_id FK
        string title
        datetime start
        datetime end
    }
```

---

## 3. Counseling Sessions

```mermaid
erDiagram
    students ||--o{ appointments : "attends"
    counselors ||--o{ appointments : "conducts"
    appointments ||--o{ session_notes : "has"
    appointments ||--o{ session_feedback : "receives"
    counselors ||--o{ session_notes : "writes"
    students ||--o{ session_feedback : "writes"
    counselors ||--o{ session_feedback : "reviews"

    students {
        bigint id PK
        string name
        string student_id
    }

    counselors {
        bigint id PK
        string name
    }

    appointments {
        bigint id PK
        bigint student_id FK
        bigint counselor_id FK
        enum status "pending, accepted, declined, completed, cancelled, rescheduled_pending"
    }

    session_notes {
        bigint id PK
        bigint appointment_id FK
        bigint counselor_id FK
        text note
        integer session_number
        datetime next_session
        string session_status "scheduled, completed, missed, expired"
        string attendance
        text absence_reason
    }

    session_feedback {
        bigint id PK
        bigint appointment_id FK
        integer rating
        text comments
        boolean reviewed_by_counselor
    }
```

---

## 4. Assessments

```mermaid
erDiagram
    students ||--o{ assessments : "takes"
    counselors ||--o{ assessments : "reviews and adds case notes"

    students {
        bigint id PK
        string name
        string student_id
        string college
        string year_level
    }

    counselors {
        bigint id PK
        string name
    }

    assessments {
        bigint id PK
        bigint user_id FK
        string type "DASS42, Grit, Neo, WVI"
        string risk_level
        json score
        json responses
        text notes
        text case_notes
        string status
        text student_comment
    }
```

---

## 5. Messaging

```mermaid
erDiagram
    students ||--o{ messages : "sends"
    students ||--o{ messages : "receives"
    counselors ||--o{ messages : "sends"
    counselors ||--o{ messages : "receives"

    students {
        bigint id PK
        string name
        string student_id
    }

    counselors {
        bigint id PK
        string name
    }

    messages {
        bigint id PK
        bigint sender_id FK
        bigint recipient_id FK
        text content
        string image
        boolean is_read
    }
```

---

## 6. Guidance Program (Seminars)

```mermaid
erDiagram
    counselors ||--o{ seminars : "manages"
    seminars ||--o{ seminar_schedules : "has"
    seminars ||--o{ seminar_evaluations : "has"
    seminar_schedules ||--o{ seminar_attendances : "tracks"
    counselors ||--o{ seminar_attendances : "marks attendance"
    students ||--o{ seminar_attendances : "attends"
    students ||--o{ seminar_evaluations : "submits"

    students {
        bigint id PK
        string name
        string student_id
        string college
        string year_level
    }

    counselors {
        bigint id PK
        string name
    }

    seminars {
        bigint id PK
        string name "IDREAMS, 10C, LEADS, IMAGE"
        text description
        integer target_year_level
    }

    seminar_schedules {
        bigint id PK
        bigint seminar_id FK
        date date
        string location
        string academic_year
        enum session_type "Morning, Afternoon"
        json colleges
    }

    seminar_attendances {
        bigint id PK
        bigint user_id FK
        string seminar_name
        integer year_level
        bigint seminar_schedule_id FK
        date attended_at
        string status
    }

    seminar_evaluations {
        bigint id PK
        bigint seminar_id FK
        bigint user_id FK
        integer rating
        text comments
        json answers
    }
```

---

## 7. Content Management

```mermaid
erDiagram
    admins ||--o{ announcements : "creates"
    admins ||--o{ resources : "creates"
    admins ||--o{ hero_images : "manages"
    counselors ||--o{ announcements : "creates"
    counselors ||--o{ resources : "creates"
    students ||--o{ announcements : "views"
    students ||--o{ resources : "views"

    admins {
        bigint id PK
        string name
        enum role "admin"
    }

    counselors {
        bigint id PK
        string name
        enum role "counselor"
    }

    students {
        bigint id PK
        string name
        enum role "student"
    }

    announcements {
        bigint id PK
        string title
        text content
        string attachment
        json images
        bigint created_by FK
    }

    resources {
        bigint id PK
        string title
        text description
        string type "video, article, file"
        text content
        string file_path
        string file_name
        string file_type
        bigint file_size
        string category
        boolean is_published
        bigint created_by FK
    }

    hero_images {
        bigint id PK
        string title
        string image_path
        boolean is_active
        integer order
    }
```

---

## 8. Notifications & Activity Logging

```mermaid
erDiagram
    system ||--o{ email_notifications : "sends"
    system ||--o{ in_app_notifications : "triggers"
    email_notifications ||--o{ students : "notifies"
    email_notifications ||--o{ counselors : "notifies"
    in_app_notifications ||--o{ students : "alerts"
    in_app_notifications ||--o{ counselors : "alerts"
    students ||--o{ user_activities : "logs"
    counselors ||--o{ user_activities : "logs"
    admins ||--o{ user_activities : "logs"

    system {
        string name "GCC System"
    }

    students {
        bigint id PK
        string name
        string email
    }

    counselors {
        bigint id PK
        string name
        string email
    }

    admins {
        bigint id PK
        string name
        string email
    }

    email_notifications {
        string type "appointment_confirmation, appointment_reminder, assessment_result, session_scheduled"
        string recipient_email
        string subject
        text body
        enum status "sent, failed"
        timestamp sent_at
    }

    in_app_notifications {
        bigint id PK
        string type "NotificationType"
        bigint notifiable_id FK
        string notifiable_type
        json data
        timestamp read_at
    }

    user_activities {
        bigint id PK
        bigint user_id FK
        string action
        text description
        string ip_address
        text user_agent
        json data
    }
```

---

## Relationship Summary

| Parent | Child | Type | Foreign Key | On Delete |
|---|---|---|---|---|
| users | users | 1:1 (self) | `approved_by` | — |
| users | appointments | 1:N | `student_id` | CASCADE |
| users | appointments | 1:N | `counselor_id` | CASCADE |
| users | availabilities | 1:N | `user_id` | CASCADE |
| users | assessments | 1:N | `user_id` | CASCADE |
| users | messages | 1:N | `sender_id` | CASCADE |
| users | messages | 1:N | `recipient_id` | CASCADE |
| users | session_notes | 1:N | `counselor_id` | CASCADE |
| users | announcements | 1:N | `created_by` | CASCADE |
| users | resources | 1:N | `created_by` | CASCADE |
| users | seminar_attendances | 1:N | `user_id` | CASCADE |
| users | seminar_evaluations | 1:N | `user_id` | CASCADE |
| users | sms_logs | 1:N | `user_id` | SET NULL |
| users | user_activities | 1:N | `user_id` | CASCADE |
| appointments | session_notes | 1:N | `appointment_id` | CASCADE |
| appointments | session_feedback | 1:N | `appointment_id` | CASCADE |
| seminars | seminar_schedules | 1:N | `seminar_id` | CASCADE |
| seminars | seminar_evaluations | 1:N | `seminar_id` | CASCADE |
| seminar_schedules | seminar_attendances | 1:N | `seminar_schedule_id` | — |
