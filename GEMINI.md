# Gemini CLI Project Directives: GCC System

## Project Overview
This project is the **Guidance and Counseling Center (GCC) System**, a web application designed to manage student counseling, psychological assessments, guidance seminars, and educational resources.

## Technology Stack
- **Backend Framework:** Laravel 12 (PHP ^8.2)
- **Frontend Tooling:** Vite, Tailwind CSS 4, Bootstrap 5, Vanilla JS / Blade Templates
- **Real-time & WebSockets:** Laravel Reverb & Echo (used for real-time messaging and notifications)
- **Database:** Relational (MySQL/SQLite) heavily utilizing Laravel Migrations and Eloquent ORM.

## System Flow & Roles
The application distinguishes between three primary user roles:

1. **Admin**
   - **Scope:** System configuration, user verification, and analytics.
   - **Flow:** Approves/rejects student registrations, manages site content (Announcements, Hero Images, Educational Resources), and performs bulk user management and reporting.

2. **Counselor**
   - **Scope:** Core counseling operations and student engagement.
   - **Flow:** Sets availability, manages student appointments (approve, reschedule, complete), conducts sessions and records Session Notes, analyzes Student Assessments, and organizes/tracks Seminar schedules and attendance.

3. **Student**
   - **Scope:** Self-service guidance and engagement.
   - **Flow:** Logs in via the homepage modal. Books and tracks appointments. Takes standardized psychological assessments (DASS42, Grit, NEO, WVI). Evaluates seminars. Uses real-time chat to communicate with counselors.

## Architectural Patterns & Conventions
- **Authentication:** Standard Laravel Auth augmented with email verification and Two-Factor Authentication (2FA). Login and Registration are dynamically handled via modals on the home route (`/`), redirecting from the legacy `/login` and `/register` endpoints.
- **Routing:** Highly organized using middleware aliases (`guest`, `auth`, `admin`, `role:student`, `role:counselor,admin`). Routes are logically grouped by user persona.
- **Controllers:** Separated by domains and roles (e.g., `App\Http\Controllers\Admin\`, `App\Http\Controllers\Counselor\`, `App\Http\Controllers\Student\`).
- **Data Models & Relationships:** The `User` model is central. Cascading deletes are strictly maintained for domain-specific models (e.g., deleting a User deletes their Appointments and Messages), while audit logs (e.g., `sms_logs`) may keep the record and nullify the user. JSON columns are used extensively for dynamic data like assessment scores and seminar evaluation answers.
- **Notifications:** Built heavily on Laravel Notifications, utilizing database channels for in-app bells and custom providers for SMS (e.g., Semaphore/Twilio) and emails.

## Development Guidelines
- **Styling:** Adhere to the existing hybrid approach of Tailwind CSS for custom utility styling alongside Bootstrap 5 components.
- **Database Modifying:** Always use Laravel migrations. Check `docs/data_dictionary.md` before altering database schema to understand existing constraints.
- **Authorization:** Never rely solely on UI hiding. Always enforce role-based access control (RBAC) at the route level (middleware) and controller level.
- **Code Quality:** Write clean, idiomatic PHP using modern features. Prefer dependency injection and eloquent relationships over raw queries. Avoid disabling warnings or types. Validate all requests via Form Requests.