## Why

L'extraction IA actuelle (dans `recus-crud`) est noyée dans le Job sans service dédié, sans historique des appels, et sans outil de debug. En production, impossible de savoir pourquoi une extraction a échoué, de la rejouer manuellement, ou de tester le prompt sans modifier le code.

## What Changes

- Service `ExtractionService` dédié, découplé du Job
- Modèle `ExtractionHistory` pour tracer chaque appel IA (prompt, réponse brute, durée, tokens, statut)
- Refactor du `ExtractExpensesJob` pour utiliser `ExtractionService`
- Interface de debug : historique des extractions, inspection des réponses brutes, retry manuel
- Page de test d'extraction avec texte libre (sans créer de reçu)
- Amélioration du prompt avec instructions plus précises

## Capabilities

### New Capabilities
- `extraction-service`: Service métier `ExtractionService` encapsulant l'appel Groq, la validation du schéma, et la création des articles
- `extraction-history`: Historique complet des appels IA (prompt, réponse, durée, tokens, statut) avec modèle et migration dédiés
- `extraction-debug`: Interface de debug (historique, inspection réponses brutes, test d'extraction en texte libre)
- `extraction-retry`: Re-déclenchement manuel d'une extraction depuis l'interface

### Modified Capabilities
- `receipt-extraction` (de `recus-crud`): Le Job `ExtractExpensesJob` délègue à `ExtractionService` au lieu d'appeler Groq directement ; enregistre l'historique automatiquement

## Impact

- `app/Services/ExtractionService.php` : nouveau service
- `app/Models/ExtractionHistory.php` : modèle pour la traçabilité
- `database/migrations/xxxx_create_extraction_history_table.php`
- `app/Jobs/ExtractExpensesJob.php` : refactor pour utiliser ExtractionService
- `app/Http/Controllers/ExtractionDebugController.php` : debug et retry
- `app/Http/Requests/TestExtractionRequest.php` : validation pour le test
- `resources/views/extractions/` : historique, détail, test
- `routes/web.php` : routes de debug extraction
- `tests/Feature/ExtractionServiceTest.php` : tests unitaires du service
- `tests/Feature/ExtractionHistoryTest.php` : tests de l'historique
