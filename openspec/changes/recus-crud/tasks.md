## 1. Setup & Dependencies

- [ ] 1.1 Install `laravel/ai` via Composer
- [ ] 1.2 Configure Groq provider in `config/ai.php` avec clé API et modèle `llama-3.1-8b-instant`
- [ ] 1.3 Add `GROQ_API_KEY` to `.env`

## 2. Enums

- [ ] 2.1 Create `App\Models\Enums\ReceiptStatus` enum (`en_attente`, `traité`, `erreur`)
- [ ] 2.2 Create `App\Models\Enums\CategorieArticle` enum (`alimentaire`, `boissons`, `hygiène`, `entretien`, `autre`)

## 3. Migrations & Models

- [ ] 3.1 Create migration for `receipts` table (user_id FK, texte_source, status enum, total_estimé nullable, devise nullable, timestamps)
- [ ] 3.2 Create migration for `articles` table (receipt_id FK cascade, libellé, quantité integer, prix_unitaire float, catégorie enum)
- [ ] 3.3 Create `Receipt` model with fillable, casts (status enum), relations (user, articles)
- [ ] 3.4 Create `Article` model with fillable, casts (quantité integer, prix_unitaire float, catégorie enum), relation (receipt)
- [ ] 3.5 Add `receipts` relation on User model
- [ ] 3.6 Run migrations

## 4. Form Requests

- [ ] 4.1 Create `StoreReceiptRequest` (validate texte_source: required, string, min:10, max:5000)
- [ ] 4.2 Create `UpdateReceiptRequest` (same rules, but only allow if status is `en_attente`)

## 5. Job & AI Extraction

- [ ] 5.1 Create `ExtractExpensesJob` with structured output schema matching contrat JSON
- [ ] 5.2 Implement Groq API call via `AI::chat()->structured()` using model `llama-3.1-8b-instant`
- [ ] 5.3 Map AI response to Article records and update receipt (total_estimé, devise, status)
- [ ] 5.4 Handle AI failures (invalid response → status `erreur`, exceptions → release with retry)
- [ ] 5.5 Delete existing articles before re-extraction (for edit flow)

## 6. Controller & Routes

- [ ] 6.1 Create `ReceiptController` with CRUD methods (index, create, store, show, edit, update, destroy)
- [ ] 6.2 `index()` : paginate user's receipts with eager loading
- [ ] 6.3 `store()` : validate via StoreReceiptRequest, create receipt, dispatch job, redirect
- [ ] 6.4 `show()` : load receipt + articles, return view
- [ ] 6.5 `update()` : validate via UpdateReceiptRequest, update texte_source, reset status to `en_attente`, re-dispatch job
- [ ] 6.6 `destroy()` : authorize ownership, delete receipt (cascade articles)
- [ ] 6.7 Add `Route::resource('receipts', ReceiptController::class)` with auth middleware

## 7. Views

- [ ] 7.1 Create `resources/views/receipts/index.blade.php` : table with status badge, total, actions
- [ ] 7.2 Create `resources/views/receipts/create.blade.php` : form with textarea for texte_source
- [ ] 7.3 Create `resources/views/receipts/show.blade.php` : source text + articles table + status
- [ ] 7.4 Create `resources/views/receipts/edit.blade.php` : same form as create, pre-filled
- [ ] 7.5 Create `resources/views/receipts/_form.blade.php` : partial for create/edit
- [ ] 7.6 Add navigation link to receipts index in layout

## 8. Tests

- [ ] 8.1 Test receipt creation (success, validation errors, guest redirect)
- [ ] 8.2 Test receipt listing (pagination, own receipts only)
- [ ] 8.3 Test receipt detail (own receipt, other user's 404, pending/error states)
- [ ] 8.4 Test receipt edit (success, processed receipt blocked)
- [ ] 8.5 Test receipt deletion (success, other user's 404)
- [ ] 8.6 Test extraction job (successful extraction, invalid response, API failure, re-extraction)
- [ ] 8.7 Test job dispatch on create and edit
