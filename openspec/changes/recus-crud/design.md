## Context

Application Laravel 13 fraîche, sans code métier. AGENTS.md définit déjà l'architecture cible : CRUD reçus → Form Request → Job → Groq → mise à jour du statut.

## Goals / Non-Goals

**Goals:**
- CRUD complet des reçus (Create, Read, Update, Delete) avec validation
- Extraction IA des articles via Groq (llama-3.1-8b-instant) au moment de la création
- Statut du reçu : `en_attente` → `traité` ou `erreur`
- Affichage des articles extraits dans la vue détail
- Tests Pest pour le CRUD et l'extraction (avec fake SDK)

**Non-Goals:**
- Pas de modification des reçus après extraction (le texte source est immutable une fois traité)
- Pas d'upload de fichier image/PDF (texte libre uniquement)
- Pas de dashboard d'agrégation des dépenses (feature future)

## Decisions

| Décision | Choix | Raison |
|---|---|---|
| Provider IA | `laravel/ai` + Groq | Stack défini dans AGENTS.md |
| Modèle | `llama-3.1-8b-instant` | Rapide, suffisant pour l'extraction structurée |
| Structured output | `AI::chat()->structured($schema)` | Garantit le respect du contrat JSON |
| Status enum | `ReceiptStatus` (`en_attente`, `traité`, `erreur`) avec Eloquent Cast | Suivi clair du cycle de vie |
| Catégorie enum | `CategorieArticle` avec Eloquent Cast | Normalisation des catégories |
| Validation | `StoreReceiptRequest` avant dispatch du Job | Économie d'appels IA (cf. AGENTS.md) |
| Queue | `ExtractExpensesJob` dispatché sur queue `default` | Appel IA bloquant (~3-8s), pas en HTTP |
| Tables | `receipts` + `articles` avec FK et cascade | Relation 1:N claire |
| Routes | `Route::resource('receipts', ReceiptController::class)` | Convention Laravel RESTful |
| Affichage extraction | `Eager load` articles sur Receipt::with('articles') | Zéro N+1 (AGENTS.md) |

## Risks / Trade-offs

- [Risque] `laravel/ai` pas encore installé → mitigation : ajout dans composer.json, config AI dans `config/ai.php`
- [Risque] Groq peut retourner un parsing incomplet → mitigation : validation dans le Job, statut `erreur` si schéma invalide
- [Risque] Le texte source peut être très long → mitigation : validation taille max dans le Form Request
- [Trade-off] On ne stocke pas le JSON brut de l'IA ; on mappe directement dans les colonnes `articles` pour la traçabilité et la ré-extraction
