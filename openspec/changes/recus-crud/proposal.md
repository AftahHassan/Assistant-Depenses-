## Why

L'application doit permettre aux utilisateurs de gérer leurs reçus fournisseurs et d'extraire automatiquement les dépenses structurées via l'IA Groq. Sans cette fonctionnalité, le cœur métier du projet est inexistant.

## What Changes

- Modèle `Receipt` avec statut (en_attente, traité, erreur), texte source, total estimé, devise
- Modèle `Article` avec libellé, quantité, prix unitaire, catégorie (enum)
- Migration et relations Eloquent (User → Receipt → Articles)
- CRUD complet des reçus (création avec texte source, liste, détail, modification, suppression)
- Job `ExtractExpensesJob` qui appelle Groq via `laravel/ai` pour parser le texte
- Form Request de validation AVANT l'appel IA
- Dispatch du Job à la création du reçu, statut mis à jour après traitement
- Affichage des articles extraits sur la page détail du reçu
- Tests Pest pour le CRUD et l'extraction

## Capabilities

### New Capabilities
- `receipt-management`: CRUD complet des reçus fournisseurs (création, liste, détail, modification, suppression)
- `receipt-extraction`: Extraction IA des articles depuis le texte du reçu via Groq, avec gestion du statut
- `article-line-items`: Consultation des articles extraits (libellé, quantité, prix unitaire, catégorie) sur la page détail d'un reçu

### Modified Capabilities

<!-- Aucune capability existante modifiée -->

## Impact

- `composer.json` : ajout de `laravel/ai`
- `app/Models/Receipt.php`, `app/Models/Article.php`
- `app/Models/Enums/CategorieArticle.php` : enum pour les catégories
- `app/Jobs/ExtractExpensesJob.php` : appel Groq avec structured output
- `app/Http/Controllers/ReceiptController.php` : CRUD complet
- `app/Http/Requests/StoreReceiptRequest.php` : validation avant IA
- `app/Http/Requests/UpdateReceiptRequest.php` : validation pour update
- `database/migrations/xxxx_create_receipts_table.php`
- `database/migrations/xxxx_create_articles_table.php`
- `resources/views/receipts/` : index, show, create, edit, form partial
- `routes/web.php` : routes resource pour receipts
- `config/ai.php` : configuration du provider Groq
- `tests/Feature/ReceiptTest.php` : tests CRUD + extraction
