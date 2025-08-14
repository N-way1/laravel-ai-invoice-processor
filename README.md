# Laravel Developer Test - Document Processing Feature

## Goal

Add a "Document Processing" feature to this Laravel app.
Users upload PDF invoices → AI mock extracts data → Match with mock Purchase Orders → Display on dashboard.

## Setup

1. Clone this repository.
2. Run `composer install`.
3. Copy `.env.example` to `.env` and set up DB.
4. Run: `php artisan migrate --seed` and `php artisan serve`
5. Visit `/dashboard`.

## Mock APIs

-   AI Extraction: `POST /api/mock-ai-extract`
-   Purchase Orders: `GET /api/mock-purchase-orders`

## Requirements

-   PDF upload (validated)
-   Process file via AI mock
-   Match to mock PO
-   Store and display results
-   Use queues for processing
-   Include unit tests
-   Update this README with notes

## Submission

-   Push your code to a public GitHub repo.
-   Email the link before the 48-hour deadline.

## Notes

-   Fixed `Controller.php` which previously contained a copied AI mock controller.
-   Implemented `AiDocumentProcessor` with AI extraction logic, purchase-order matching, and error handling.
-   Filled `Document` model with migration to store extracted fields (`invoice_number`, `vendor`, `total_amount`, `po_number`, `status`) and support document lifecycle.
-   Added `apiResource` route inside `routes/api.php` and included only the store function
-   Matching logic: simple matching criteria, case-insensitive vendor name comparison. Documents are only updated when a matching PO is found.
-   Doucument `status` turn to fail if no matching PO is found
-   Added feature tests to validate upload, job dispatch, and processing behavior (see `tests/Feature/DocumentTest.php`).
-   Running locally: run migrations and seeders (`php artisan migrate --seed`), start the dev server (recommended: `php artisan serve --port=8000`) and run a queue worker (`php artisan queue:work`) to process uploaded documents.
-   Testing without a running queue: in tests you can mock the queue by uncommenting or adding `Queue::fake();` and assert dispatch with `Queue::assertPushed(ProcessDocument::class);` — this prevents the job from running and only verifies it was dispatched.
