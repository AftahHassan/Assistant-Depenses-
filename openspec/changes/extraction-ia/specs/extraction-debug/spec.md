## ADDED Requirements

### Requirement: Debug interface shows extraction history
The system SHALL provide a debug page at `/extractions` that displays the full extraction history.

#### Scenario: History page is accessible to authenticated users
- **WHEN** an authenticated user visits `/extractions`
- **THEN** system displays the paginated extraction history

#### Scenario: Guest access is blocked
- **WHEN** an unauthenticated user visits `/extractions`
- **THEN** system redirects to the login page

### Requirement: User can inspect a single extraction in detail
The system SHALL show the full details of an extraction history record, including the complete prompt sent and raw response received.

#### Scenario: View extraction detail
- **WHEN** user clicks on a history record
- **THEN** system displays the prompt, raw response, duration, tokens, and status in a readable format

### Requirement: User can test extraction with custom text
The system SHALL provide a page where a user can enter free text and see the AI extraction result without creating a receipt.

#### Scenario: Test extraction
- **WHEN** an authenticated user submits custom text on the test page
- **THEN** system calls `ExtractionService` and displays the structured result (or error) without persisting

#### Scenario: Test extraction validates input
- **WHEN** an authenticated user submits empty or too-short text
- **THEN** system returns a validation error without calling the AI
