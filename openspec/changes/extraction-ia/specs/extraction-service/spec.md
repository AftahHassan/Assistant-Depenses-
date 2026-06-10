## ADDED Requirements

### Requirement: ExtractionService encapsulates Groq AI calls
The system SHALL provide an `ExtractionService` class that encapsulates the Groq API call, schema validation, and result mapping.

#### Scenario: Service accepts receipt text and returns structured data
- **WHEN** `ExtractionService::extract(texte_source)` is called with valid text
- **THEN** it returns an object containing articles array, total_estimé, and devise

#### Scenario: Service validates AI response against schema
- **WHEN** Groq returns data that does not match the expected schema
- **THEN** the service throws a typed `ExtractionValidationException`

#### Scenario: Service handles API errors gracefully
- **WHEN** the Groq API call fails (timeout, network, rate limit)
- **THEN** the service throws an `ExtractionApiException` with the original exception details

### Requirement: Service builds a structured prompt
The service SHALL build an optimized prompt for receipt extraction that instructs the model to return data matching the JSON contract.

#### Scenario: Prompt includes receipt context
- **WHEN** preparing the AI call
- **THEN** the prompt instructs the model to extract articles with libellé, quantité, prix_unitaire, and catégorie

### Requirement: Service can map AI response to Article models
The service SHALL provide a method to map the AI response into an array of Article model attributes.

#### Scenario: Map response to attributes
- **WHEN** given a valid AI response
- **THEN** the service returns an array of article attributes with correct types (quantité as int, prix_unitaire as float, catégorie as enum value)
