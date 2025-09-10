# Web-Based Appointment Scheduling and Counseling Information System for Central Mindanao University (CMU)

## Project Overview
This project aims to develop a comprehensive web-based system to enhance service accessibility, communication, and efficiency between students and counselors at Central Mindanao University (CMU). The system streamlines appointment scheduling, provides secure communication, integrates AI-assisted mental health assessment, and offers robust management tools for counselors and administrators.

## Objectives
1. **Online Appointment Scheduling**
   - Design and implement a user-friendly online system that allows students to book, reschedule, or cancel counseling sessions with ease.

2. **Secure Messaging/Contact Feature**
   - Develop a secure and confidential communication channel between students and counselors to facilitate private discussions and support.

3. **AI-Assisted Mental Health Assessment**
   - Integrate a module that utilizes machine learning and sentiment analysis to interpret mental health questionnaires (e.g., DASS or stress scale). This enables counselors to gain deeper insights into student well-being and prioritize high-risk cases more effectively.

4. **Counselor Dashboard**
   - Implement a dedicated dashboard for counselors to view and manage their appointments, access student profiles, record session notes, and monitor feedback related to their sessions.

5. **Admin Management Tools**
   - Enable administrators to manage the system by posting announcements and memos, overseeing all appointments, resolving scheduling conflicts, monitoring usage, and accessing system-wide activity reports.

6. **Student Feedback Collection**
   - Collect feedback from students through online surveys after counseling sessions or activities to support continuous service improvement.

## Key Features
- Student registration and authentication
- Appointment booking, rescheduling, and cancellation
- Secure, confidential messaging between students and counselors
- AI-powered mental health assessment and risk prioritization
- Counselor dashboard for session management and note-taking
- Admin panel for announcements, memos, and system oversight
- Feedback and survey collection for quality improvement

## Technologies Used
- **Backend:** Laravel (PHP)
- **Frontend:** Blade Templates, CSS, JavaScript
- **Database:** MySQL or compatible relational database
- **AI/ML:** Integration for sentiment analysis and assessment (future scope)

## Getting Started
1. **Clone the repository:**
   ```bash
   git clone <repository-url>
   cd gccsystem
   ```
2. **Install dependencies:**
   ```bash
   composer install
   npm install
   ```
3. **Set up environment:**
   - Copy `.env.example` to `.env` and configure your database and mail settings.
   - Generate application key:
     ```bash
     php artisan key:generate
     ```
4. **Run migrations:**
   ```bash
   php artisan migrate
   ```
5. **Start the development server:**
   ```bash
   php artisan serve
   ```

## Contribution
Contributions are welcome! Please fork the repository and submit a pull request for review.

## License
This project is for academic and research purposes at Central Mindanao University.