## ADDED Requirements

### Requirement: User can request a password reset link
The system SHALL allow an unauthenticated user to request a password reset email by providing their registered email address.

#### Scenario: Successful password reset request
- **WHEN** user submits a registered email on the forgot password page
- **THEN** system sends a password reset link to that email (or logs it in dev) and shows a confirmation message

#### Scenario: Password reset request with unregistered email
- **WHEN** user submits an email that does not exist
- **THEN** system does NOT reveal whether the email exists, but shows the same confirmation message

### Requirement: User can reset password with a valid token
The system SHALL allow a user to set a new password using a valid reset token received by email.

#### Scenario: Successful password reset
- **WHEN** user clicks a valid reset link and submits a new password with confirmation
- **THEN** system updates the password and redirects to the login page with a success message

#### Scenario: Password reset with expired token
- **WHEN** user clicks an expired or invalid reset link
- **THEN** system shows an error message and prompts the user to request a new reset link

#### Scenario: Password reset with weak password
- **WHEN** user submits a new password shorter than 8 characters during reset
- **THEN** system returns a validation error for the password field
