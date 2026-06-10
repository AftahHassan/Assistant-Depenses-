## ADDED Requirements

### Requirement: Articles are displayed on receipt detail page
The system SHALL display all extracted articles for a receipt on its detail page.

#### Scenario: Show extracted articles
- **WHEN** user views a `traité` receipt detail
- **THEN** system displays a table with columns: libellé, quantité, prix unitaire, catégorie, and total par ligne

#### Scenario: No articles for pending receipt
- **WHEN** user views an `en_attente` receipt detail
- **THEN** system displays a "traitement en cours" message and no articles table

#### Scenario: Error state for failed extraction
- **WHEN** user views an `erreur` receipt detail
- **THEN** system displays an "erreur d'extraction" message with an option to retry

### Requirement: Article data is validated and cast
Each article SHALL have a libellé, quantité (positive integer), prix_unitaire (positive number), and catégorie (enum).

#### Scenario: Article values are cast correctly
- **WHEN** articles are stored from the extraction
- **THEN** `quantité` is cast to integer, `prix_unitaire` to float, `catégorie` to CategorieArticle enum

### Requirement: Articles belong to a receipt
Every article SHALL belong to exactly one receipt, and be cascade-deleted with it.

#### Scenario: Cascade delete on receipt removal
- **WHEN** a receipt is deleted
- **THEN** all its associated articles are also deleted
