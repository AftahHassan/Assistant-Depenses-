## Context

Le change `recus-crud` met en place l'extraction de base dans `ExtractExpensesJob`. L'extraction est noyée dans le Job, sans visibilité ni contrôle. Ce change introduit un service dédié, un historique traçable, et des outils de debug.

## Goals / Non-Goals

**Goals:**
- Service `ExtractionService` autonome, injectable et testable
- Historique complet de chaque appel IA (prompt, réponse brute, durée ms, tokens, statut)
- Refactor du Job pour déléguer au service
- Interface de debug accessible aux utilisateurs autorisés
- Retry manuel depuis l'interface
- Page de test d'extraction sans créer de reçu

**Non-Goals:**
- Pas de modification du modèle Receipt ou Article (géré par recus-crud)
- Pas de dashboard agrégé des performances IA (feature future)
- Pas d'authentification spécifique pour le debug (utilise le middleware auth existant)

## Decisions

| Décision | Choix | Raison |
|---|---|---|
| Architecture | `ExtractionService` en singleton injecté par constructeur dans le Job | Découplage, testabilité, SRP |
| Historique | Modèle `ExtractionHistory` avec payload JSON pour prompt et réponse brute | Traçabilité complète sans schéma rigide |
| Token tracking | Stocker `input_tokens`, `output_tokens`, `duration_ms` si fournis par Groq | Monitoring des coûts et performances |
| Stockage réponse brute | Cast JSON sur le champ `response_raw` du modèle | Flexible, permet inspection du JSON IA |
| Debug accessible à | Tous les utilisateurs authentifiés (pas de rôle admin) | Pas de système de rôles encore ; sera renforcé plus tard |
| Retry manuel | Dispatch d'un nouveau `ExtractExpensesJob` avec le receipt_id | Réutilisation du flux existant |
| Test extraction | Appelle `ExtractionService` sans persister, affiche le résultat | Permet d'itérer sur le prompt sans créer de données |
| Prompt IA | Versionné dans une méthode `buildPrompt()` du service | Centralisé, facile à modifier et tester |

## Risks / Trade-offs

- [Risque] `ExtractionHistory` peut grossir vite → mitigation : pagination dans l'interface, retention à définir
- [Risque] La réponse brute de Groq peut contenir des données sensibles → mitigation : `ExtractionHistory` lié à un receipt_id, visibilité restreinte au propriétaire
- [Trade-off] On duplique la logique de mapping dans le service (extraction) vs le Job (orchestration) → acceptable car le Job devient un simple orchestrateur
