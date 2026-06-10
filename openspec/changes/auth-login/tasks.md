## 1. Setup

- [ ] 1.1 Install Laravel Breeze (Blade + Tailwind) via Composer
- [ ] 1.2 Run Breeze installation and npm dependencies
- [ ] 1.3 Run database migrations (users, password_resets, personal_access_tokens)
- [ ] 1.4 Configure MAIL_MAILER=log for development

## 2. Registration

- [ ] 2.1 Create RegisterController with validation (name, email, password, confirmation)
- [ ] 2.2 Create RegisterRequest Form Request
- [ ] 2.3 Create register Blade view with Tailwind styling
- [ ] 2.4 Add registration routes (GET /register, POST /register)
- [ ] 2.5 Display validation errors on registration form

## 3. Login

- [ ] 3.1 Create LoginController with authentication logic
- [ ] 3.2 Create LoginRequest Form Request
- [ ] 3.3 Create login Blade view with Tailwind styling
- [ ] 3.4 Add login routes (GET /login, POST /login)
- [ ] 3.5 Implement "remember me" functionality
- [ ] 3.6 Display generic error message for invalid credentials

## 4. Logout

- [ ] 4.1 Create LogoutController with session destruction
- [ ] 4.2 Add POST /logout route
- [ ] 4.3 Ensure logout button uses POST method

## 5. Password Reset

- [ ] 5.1 Create ForgotPasswordController
- [ ] 5.2 Create forgot-password Blade view
- [ ] 5.3 Add forgot password routes (GET /forgot-password, POST /forgot-password)
- [ ] 5.4 Create ResetPasswordController
- [ ] 5.5 Create reset-password Blade view
- [ ] 5.6 Add reset password routes (GET /reset-password/{token}, POST /reset-password)
- [ ] 5.7 Send password reset link notification email
- [ ] 5.8 Validate new password strength (min 8 chars)

## 6. Email Verification

- [ ] 6.1 Create EmailVerificationPromptController (notice page)
- [ ] 6.2 Create verify-email Blade notice view
- [ ] 6.3 Add email verification notice route (GET /email/verify)
- [ ] 6.4 Create VerifyEmailController (handle verification link)
- [ ] 6.5 Create EmailVerificationNotificationController (resend link)
- [ ] 6.6 Add verify and resend routes
- [ ] 6.7 Apply email verification middleware to protected routes

## 7. Navigation & Layout

- [ ] 7.1 Create app layout with conditional navigation (guest vs authenticated)
- [ ] 7.2 Add login/register links for guests
- [ ] 7.3 Add user dropdown with logout for authenticated users
- [ ] 7.4 Create minimal dashboard page (GET /dashboard)

## 8. Tests

- [ ] 8.1 Test registration (success, duplicate email, weak password, mismatch, empty fields)
- [ ] 8.2 Test login (success, wrong password, non-existent email, remember me)
- [ ] 8.3 Test logout (success, POST-only, guest access)
- [ ] 8.4 Test password reset (request, reset success, expired token, weak password)
- [ ] 8.5 Test email verification (verify success, invalid signature, resend)
- [ ] 8.6 Test auth middleware (unauthenticated redirect, verified email check)
