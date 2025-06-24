# Email Verification Setup Guide

This guide explains how to set up email verification using Mailtrap for testing.

## Features Implemented

✅ Email verification on user registration  
✅ Custom email verification template  
✅ Resend verification email functionality  
✅ Email verification check on login  
✅ Activity logging for verification events  

## Setup Instructions

### 1. Environment Configuration

Create a `.env` file in your project root with the following Mailtrap configuration:

```env
APP_NAME="User Management App"
APP_ENV=local
APP_KEY=base64:your_generated_key
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=sqlite
DB_DATABASE=/path/to/your/project/database/database.sqlite

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=aianmark1715@gmail.com
MAIL_PASSWORD=uxbw syub lpcr ojyi
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=aianmark1715@gmail.com
MAIL_FROM_NAME="User Management App"

### 2. Mailtrap Setup

1. Go to [Mailtrap.io](https://mailtrap.io) and create a free account
2. Create a new inbox
3. Go to the inbox settings and copy the SMTP credentials
4. Update your `.env` file with the Mailtrap credentials

### 3. Database Setup

Run the following commands:

```bash
# Create the database file (if using SQLite)
touch database/database.sqlite

# Run migrations
php artisan migrate

# Generate application key (if not already done)
php artisan key:generate
```

### 4. Testing Email Verification

1. Start your Laravel development server:
   ```bash
   php artisan serve
   ```

2. Navigate to the registration page and create a new account

3. Check your Mailtrap inbox for the verification email

4. Click the verification link in the email

5. Try logging in with the verified account

## How It Works

### Registration Flow
1. User fills out registration form
2. Account is created with `email_verified_at` as `null`
3. Verification email is sent via Mailtrap
4. User is redirected to login with success message

### Email Verification Flow
1. User clicks verification link in email
2. System verifies the hash and user ID
3. `email_verified_at` is set to current timestamp
4. User is redirected to login with success message

### Login Flow
1. User attempts to log in
2. System checks if email is verified
3. If not verified, login is blocked with resend link
4. If verified, normal login process continues

### Resend Verification
1. User can request new verification email
2. New verification link is sent
3. Previous links become invalid

## Files Modified/Created

### Models
- `app/Models/User.php` - Added MustVerifyEmail contract and verification method

### Controllers
- `app/Http/Controllers/AuthController.php` - Added verification methods

### Notifications
- `app/Notifications/EmailVerificationNotification.php` - Custom verification notification

### Views
- `resources/views/emails/verification/email.blade.php` - Email template
- `resources/views/auth/verification/resend.blade.php` - Resend form
- `resources/views/auth/login.blade.php` - Updated for verification messages

### Routes
- `routes/web.php` - Added verification routes

## Security Features

- Email verification links expire after 60 minutes
- Verification links use SHA1 hash of email for security
- Unverified users cannot log in
- Activity logging for all verification events
- CSRF protection on all forms

## Troubleshooting

### Emails not sending
- Check Mailtrap credentials in `.env`
- Verify `MAIL_MAILER=smtp` is set
- Check Mailtrap inbox for emails

### Verification links not working
- Ensure `APP_URL` is set correctly in `.env`
- Check that the verification route is accessible
- Verify the hash generation is working correctly

### Database issues
- Run `php artisan migrate:status` to check migration status
- Ensure `email_verified_at` column exists in users table

## Production Deployment

For production, replace Mailtrap with a real email service:

1. Update `MAIL_HOST`, `MAIL_USERNAME`, and `MAIL_PASSWORD` with your email provider credentials
2. Set `MAIL_FROM_ADDRESS` to your verified domain
3. Consider using queue jobs for email sending in production
4. Set up proper email delivery monitoring 