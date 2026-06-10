## ADDED Requirements

### Requirement: User can log in with email and password
The system SHALL authenticate a user using their email and password.

#### Scenario: Successful login
- **WHEN** user submits valid email and password
- **THEN** system authenticates the user and redirects to the dashboard

#### Scenario: Login with incorrect password
- **WHEN** user submits an existing email with an incorrect password
- **THEN** system returns a generic "invalid credentials" error

#### Scenario: Login with non-existent email
- **WHEN** user submits an email that does not exist
- **THEN** system returns a generic "invalid credentials" error

#### Scenario: Login with remember me
- **WHEN** user submits valid credentials with the "remember me" checkbox checked
- **THEN** system authenticates the user with a persistent session cookie

#### Scenario: Authenticated user visits /login
- **WHEN** an authenticated user visits `/login`
- **THEN** system redirects them to the dashboard

### Requirement: Login page is publicly accessible
The system SHALL display a login page at `/login` for unauthenticated users.

#### Scenario: Unauthenticated user visits /login
- **WHEN** an unauthenticated user visits `/login`
- **THEN** system displays the login form with email and password fields
