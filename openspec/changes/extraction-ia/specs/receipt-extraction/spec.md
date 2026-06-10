## MODIFIED Requirements

### Requirement: Extraction job is dispatched after receipt creation
The system SHALL dispatch `ExtractExpensesJob` to the queue immediately after a receipt is created (or updated while `en_attente`).

#### Scenario: Job dispatched on create
- **WHEN** a receipt is created with status `en_attente`
- **THEN** system pushes `ExtractExpensesJob` to the `default` queue with the receipt ID

### Requirement: Job calls ExtractionService instead of calling Groq directly
The job SHALL delegate the AI call to `ExtractionService` and record the result in `ExtractionHistory`.

#### Scenario: Successful extraction via service
- **WHEN** `ExtractionService::extract()` returns valid data
- **THEN** job creates `Article` records, updates receipt (total_estimé, devise, status `traité`), and records a success `ExtractionHistory`

#### Scenario: Failed extraction via service
- **WHEN** `ExtractionService` throws an exception
- **THEN** job sets receipt status to `erreur`, records a failed `ExtractionHistory` with the error message

#### Scenario: Groq API failure in service
- **WHEN** `ExtractionService` throws an `ExtractionApiException`
- **THEN** job is released back to the queue with a delay (retry up to 3 times), then marked as failed

### Requirement: Receipt status is updated after processing
The system SHALL update the receipt status after the job completes.

#### Scenario: Status reflects processing result
- **WHEN** extraction succeeds → status becomes `traité`
- **WHEN** extraction fails → status becomes `erreur`
- **WHEN** extraction is pending → status stays `en_attente`

### Requirement: Previous articles are replaced on re-extraction
If a receipt is re-processed (e.g., after edit or manual retry), the job SHALL delete existing articles before creating new ones.

#### Scenario: Re-extraction on edit or retry
- **WHEN** a receipt with existing articles is re-processed
- **THEN** job deletes all existing articles for that receipt before inserting new ones
