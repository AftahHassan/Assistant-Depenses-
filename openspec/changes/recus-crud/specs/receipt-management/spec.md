## ADDED Requirements

### Requirement: User can list their receipts
The system SHALL display a paginated list of all receipts belonging to the authenticated user.

#### Scenario: View receipt list
- **WHEN** an authenticated user visits `/receipts`
- **THEN** system displays a paginated table with receipt date, status, total estimé, and actions

#### Scenario: Guest visits receipt list
- **WHEN** an unauthenticated user visits `/receipts`
- **THEN** system redirects to the login page

#### Scenario: User sees only their own receipts
- **WHEN** authenticated user visits `/receipts`
- **THEN** system only shows receipts belonging to that user (not other users' receipts)

### Requirement: User can create a receipt with source text
The system SHALL allow an authenticated user to create a receipt by submitting free-form supplier receipt text.

#### Scenario: Successful receipt creation
- **WHEN** user submits valid source text on the create form
- **THEN** system creates the receipt with status `en_attente`, dispatches the extraction job, and redirects to the receipt list with a success message

#### Scenario: Guest tries to create a receipt
- **WHEN** an unauthenticated user visits `/receipts/create` or POSTs to `/receipts`
- **THEN** system redirects to the login page

#### Scenario: Validation fails on create
- **WHEN** user submits empty or too-long source text
- **THEN** system returns validation errors and does not dispatch any job

### Requirement: User can view receipt details
The system SHALL display the full details of a receipt, including its articles and extraction status.

#### Scenario: View receipt detail
- **WHEN** user visits `/receipts/{id}` for their own receipt
- **THEN** system displays source text, status, total estimé, devise, and list of extracted articles (if any)

#### Scenario: View another user's receipt
- **WHEN** user visits `/receipts/{id}` for a receipt belonging to another user
- **THEN** system returns a 404

### Requirement: User can edit a receipt
The system SHALL allow an authenticated user to edit a receipt's source text only if the receipt has not been processed.

#### Scenario: Successful edit
- **WHEN** user submits valid source text for an `en_attente` receipt
- **THEN** system updates the receipt and redispatches the extraction job

#### Scenario: Edit a processed receipt
- **WHEN** user tries to edit a receipt with status `traité` or `erreur`
- **THEN** system returns a validation error or redirects with an error message

### Requirement: User can delete a receipt
The system SHALL allow an authenticated user to delete their own receipt.

#### Scenario: Successful deletion
- **WHEN** user deletes their own receipt
- **THEN** system removes the receipt and its associated articles, then redirects with a success message

#### Scenario: Delete another user's receipt
- **WHEN** user tries to delete a receipt belonging to another user
- **THEN** system returns a 404
