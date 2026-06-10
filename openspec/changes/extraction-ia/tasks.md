## 1. Extraction Service

- [ ] 1.1 Create `app/Services/ExtractionService.php` with `extract(string $text): ExtractionResult` method
- [ ] 1.2 Build structured prompt in `buildPrompt()` method with instructions for receipt extraction
- [ ] 1.3 Implement Groq API call via `AI::chat()->model('llama-3.1-8b-instant')->structured($schema)`
- [ ] 1.4 Create `ExtractionResult` DTO (articles array, total_estimé, devise)
- [ ] 1.5 Create custom exceptions : `ExtractionValidationException`, `ExtractionApiException`
- [ ] 1.6 Implement schema validation after AI response
- [ ] 1.7 Add `mapResponseToArticles()` method returning array of Article attributes
- [ ] 1.8 Register `ExtractionService` as singleton in `AppServiceProvider`

## 2. Extraction History Model & Migration

- [ ] 2.1 Create migration for `extraction_history` table (receipt_id FK nullable, status enum, prompt_sent JSON, response_raw JSON nullable, duration_ms nullable, input_tokens nullable, output_tokens nullable, error_message nullable, timestamps)
- [ ] 2.2 Create `ExtractionHistory` model with fillable, casts (JSON for prompt_sent, response_raw), relation to receipt
- [ ] 2.3 Run migration

## 3. Refactor ExtractExpensesJob

- [ ] 3.1 Inject `ExtractionService` into `ExtractExpensesJob`
- [ ] 3.2 Replace direct Groq call with `ExtractionService::extract()`
- [ ] 3.3 Create `ExtractionHistory` record after each extraction (success or failure)
- [ ] 3.4 Keep retry logic for `ExtractionApiException` (release with delay, max 3 retries)
- [ ] 3.5 Keep article deletion & recreation logic for re-extraction
- [ ] 3.6 Update receipt status based on result

## 4. Debug Controller & Routes

- [ ] 4.1 Create `ExtractionDebugController` with `index()` (history list), `show()` (detail), `retry()`, `test()` (test form), `runTest()` (execute test)
- [ ] 4.2 `index()` : paginate extraction history with eager loading
- [ ] 4.3 `show()` : display full prompt and raw response
- [ ] 4.4 `retry()` : reset receipt status, delete articles, dispatch job
- [ ] 4.5 Create `TestExtractionRequest` (validate texte_source: required, string, min:10, max:5000)
- [ ] 4.6 `runTest()` : call `ExtractionService` without persisting, show result
- [ ] 4.7 Add routes under `/extractions` prefix with auth middleware

## 5. Views

- [ ] 5.1 Create `resources/views/extractions/index.blade.php` : history table with status, duration, tokens, actions
- [ ] 5.2 Create `resources/views/extractions/show.blade.php` : prompt, raw response, metadata
- [ ] 5.3 Create `resources/views/extractions/test.blade.php` : textarea + submit, show result or error
- [ ] 5.4 Add "Ré-extraire" button on receipt detail view (from recus-crud) for `erreur` status
- [ ] 5.5 Add navigation link to extraction debug in layout

## 6. Retry & Throttle

- [ ] 6.1 Implement throttle on retry (max 5 per receipt per hour) via Laravel RateLimiter
- [ ] 6.2 Show remaining retry attempts on error receipt detail

## 7. Tests

- [ ] 7.1 Test `ExtractionService` (successful extraction, invalid response, API failure)
- [ ] 7.2 Test `ExtractionHistory` creation on success and failure
- [ ] 7.3 Test refactored `ExtractExpensesJob` (delegates to service, creates history)
- [ ] 7.4 Test debug controller (history list, detail, test extraction, guest redirect)
- [ ] 7.5 Test retry flow (successful retry, throttle limit)
