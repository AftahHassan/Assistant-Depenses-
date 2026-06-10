## ADDED Requirements

### Requirement: User can manually retry extraction for a receipt
The system SHALL allow an authenticated user to re-dispatch the extraction job for a receipt from the debug interface.

#### Scenario: Retry extraction for a receipt
- **WHEN** user clicks "Retry" on a receipt with status `erreur` or `traité`
- **THEN** system resets receipt status to `en_attente`, deletes existing articles, dispatches a new `ExtractExpensesJob`, and shows a confirmation message

#### Scenario: Retry is available from receipt detail page
- **WHEN** viewing a receipt with status `erreur`
- **THEN** a "Ré-extraire" button is visible on the receipt detail page

#### Scenario: Retry respects rate limiting
- **WHEN** user retries the same receipt multiple times rapidly
- **THEN** system prevents abuse (throttle: max 5 retries per receipt per hour)
