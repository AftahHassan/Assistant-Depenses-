## ADDED Requirements

### Requirement: Every extraction call is recorded in history
The system SHALL record a new `ExtractionHistory` record for every AI extraction call, whether successful or failed.

#### Scenario: Successful extraction creates history
- **WHEN** an extraction succeeds
- **THEN** a history record is created with status `success`, prompt sent, response raw, duration_ms, input_tokens, output_tokens, and linked receipt_id

#### Scenario: Failed extraction creates history
- **WHEN** an extraction fails (validation error or API error)
- **THEN** a history record is created with status `error`, prompt sent, error message, and linked receipt_id

### Requirement: ExtractionHistory stores full prompt and raw response
The system SHALL store the complete prompt sent to Groq and the complete raw response (or error) in JSON format.

#### Scenario: Prompt and response are stored as JSON
- **WHEN** a history record is created
- **THEN** `prompt_sent` and `response_raw` are stored as JSON text columns

### Requirement: History records are paginated and filterable
The system SHALL display extraction history in reverse chronological order with pagination.

#### Scenario: View history list
- **WHEN** an authenticated user visits the extraction history page
- **THEN** system displays a paginated list with date, receipt_id, status, duration, and tokens

#### Scenario: Filter by receipt
- **WHEN** a user views history filtered by a specific receipt
- **THEN** system shows only history records for that receipt
