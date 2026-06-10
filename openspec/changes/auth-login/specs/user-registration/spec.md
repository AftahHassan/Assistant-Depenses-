## ADDED Requirements

### Requirement: User can register with email and password
The system SHALL allow a new user to create an account by providing their name, email address, password, and password confirmation.

#### Scenario: Successful registration
- **WHEN** user submits valid registration data (name, email, password, password confirmation)
- **THEN** system creates the user account, logs the user in, and redirects to the dashboard

#### Scenario: Registration with existing email
- **WHEN** user submits registration with an email that already exists
- **THEN** system returns a validation error for the email field

#### Scenario: Registration with weak password
- **WHEN** user submits a password shorter than 8 characters
- **THEN** system returns a validation error for the password field

#### Scenario: Registration with mismatched passwords
- **WHEN** user submits password and password confirmation that do not match
- **THEN** system returns a validation error for the password confirmation field

#### Scenario: Registration with empty fields
- **WHEN** user submits the registration form with empty name, email, or password
- **THEN** system returns validation errors for each empty required field

### Requirement: Registration page is publicly accessible
The system SHALL display a registration page at `/register` for unauthenticated users.

#### Scenario: Authenticated user visits /register
- **WHEN** an authenticated user visits `/register`
- **THEN** system redirects them to the dashboard

#### Scenario: Unauthenticated user visits /register
- **WHEN** an unauthenticated user visits `/register`
- **THEN** system displays the registration form
