## ADDED Requirements

### Requirement: Extraction job is dispatched after receipt creation
The system SHALL dispatch `ExtractExpensesJob` to the queue immediately after a receipt is created (or updated while `en_attente`).

#### Scenario: Job dispatched on create
- **WHEN** a receipt is created with status `en_attente`
- **THEN** system pushes `ExtractExpensesJob` to the `default` queue with the receipt ID

### Requirement: Job calls Groq with structured output schema
The job SHALL call the Groq API via `laravel/ai` using the `llama-3.1-8b-instant` model with a structured output schema matching the expected JSON contract.

#### Scenario: Successful extraction
- **WHEN** Groq returns valid structured data matching the schema
- **THEN** job creates `Article` records for each article in the response, updates `total_estimé` and `devise` on the receipt, and sets status to `traité`

#### Scenario: Partial or invalid response from Groq
- **WHEN** Groq returns data that does not match the expected schema
- **THEN** job sets receipt status to `erreur` and logs the error details

#### Scenario: Groq API failure (timeout / network error)
- **WHEN** the Groq API call fails with an exception
- **THEN** job is released back to the queue with a delay (retry up to 3 times), then marked as failed

### Requirement: Receipt status is updated after processing
The system SHALL update the receipt status after the job completes.

#### Scenario: Status reflects processing result
- **WHEN** extraction succeeds → status becomes `traité`
- **WHEN** extraction fails → status becomes `erreur`
- **WHEN** extraction is pending → status stays `en_attente`

### Requirement: Previous articles are replaced on re-extraction
If a receipt is re-processed (e.g., after edit), the job SHALL delete existing articles before creating new ones.

#### Scenario: Re-extraction on edit
- **WHEN** a receipt with existing articles is re-processed
- **THEN** job deletes all existing articles for that receipt before inserting new ones
