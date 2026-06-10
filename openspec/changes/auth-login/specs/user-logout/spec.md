## ADDED Requirements

### Requirement: User can log out
The system SHALL allow an authenticated user to terminate their session.

#### Scenario: Successful logout
- **WHEN** an authenticated user clicks the logout button or sends a POST to `/logout`
- **THEN** system destroys the session and redirects to the homepage

#### Scenario: Logout is POST-only
- **WHEN** an unauthenticated or GET request is sent to `/logout`
- **THEN** system returns a 405 Method Not Allowed or redirects appropriately

#### Scenario: Authenticated session after logout
- **WHEN** a logged-out user tries to access a protected page
- **THEN** system redirects them to the login page
