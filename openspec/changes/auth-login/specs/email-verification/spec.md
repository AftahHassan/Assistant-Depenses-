## ADDED Requirements

### Requirement: User must verify email after registration
The system SHALL require email verification before granting access to protected routes, unless the user just registered (verified automatically in session).

#### Scenario: Newly registered user accesses dashboard
- **WHEN** a user completes registration
- **THEN** system logs them in and allows access to the dashboard without immediate verification

#### Scenario: User with unverified email in subsequent session
- **WHEN** a logged-in user with an unverified email logs out and logs back in
- **THEN** system redirects them to the email verification notice page

### Requirement: User can request a new verification link
The system SHALL allow a user with an unverified email to request a new verification email.

#### Scenario: Resend verification email
- **WHEN** a logged-in user with an unverified email clicks "resend verification email"
- **THEN** system sends a new verification link (or logs it in dev) and shows a confirmation message

### Requirement: User can verify email by clicking a link
The system SHALL mark the user's email as verified when they click a valid verification link.

#### Scenario: Successful email verification
- **WHEN** user clicks a valid verification link
- **THEN** system marks the email as verified and redirects to the dashboard with a success message

#### Scenario: Verification with invalid signature
- **WHEN** user clicks a verification link with an invalid or expired signature
- **THEN** system shows an error message and prompts to resend the verification email

### Requirement: Verification notice page is publicly accessible
The system SHALL display a notice page at `/email/verify` for logged-in users with unverified emails.

#### Scenario: Authenticated user with verified email visits /email/verify
- **WHEN** a user with a verified email visits `/email/verify`
- **THEN** system redirects them to the dashboard
