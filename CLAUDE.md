# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Work Patterns

1. Save all accepted plans to docs/plans.
2. Every plan file must have a **Status: ** line indicating the current status of the plan. Either: "Not Started", "In Progress", "Completed", "Abandoned". In progress plans should have a short paragraph explaining what has been done and what is left to do. Abandoned plans must have a short paragraph explaining the reason for not completing the plan. Completed plans must have a link to a corresponding change log file.
3. After completing a piece of work (e.g., finishing a plan), save a summary of the changes into docs/change-logs. Change logs files linked to a plan should reference the plan file in the intro.
4. Code reviews conducted via the /code-review skill or via explicit "feature review" requests should be saved to docs/code-reviews, with the following metadata at the top of the document:
    **Date**: 2026-05-27
    **Branch**: `review-roles-and-permissions`
    **Reviewer**: Claude (automated multi-angle review)
    **Scope**: 56 files, 1,945 insertions — new Spatie role/permission model with 5 roles and policies across three Filament panels.
5. If a user asks you to capture, note or save an issue, store it into docs/issues as a new .md file. If this is a Git repository with a Github origin, create a new issue on Github.


## Stack

- **Laravel 11** + **PHP 8.1+**
- **Filament 3.2** — admin panel for content management (at `/admin`)
- **Livewire 3** — reactive frontend components
- **Vue 3** + **Vite** + **Tailwind CSS** + **DaisyUI** — frontend assets
- **Meilisearch** via Laravel Scout — full-text search
- **Spatie Media Library** — file/media management
- **Spatie Translatable** — multilingual content (EN, ES, FR stored as JSON columns)
- **MySQL** — primary database
- Local dev URL: `http://stats4sd-resources.test`

## Commands

```bash
# Frontend
npm run dev        # Vite dev server
npm run build      # Production build

# Backend
php artisan migrate
php artisan scout:sync-index-settings   # Sync Meilisearch configuration
php artisan scout:import "App\Models\Trove"  # Reindex model

# Tests
php artisan test                         # All tests
php artisan test --testsuite=Unit
php artisan test --testsuite=Feature
php artisan test --filter=TestClassName
```

Tests run against MySQL (not SQLite in-memory). Meilisearch must be running locally for search-related features.

## Architecture

### Core entities

| Model | Purpose |
|---|---|
| `Trove` | A single learning resource (document, video, link, etc.) |
| `Collection` | A curated group of Troves |
| `Tag` + `TagType` | Flexible tagging taxonomy (research methods, topics, themes, etc.) |
| `Organisation` | Ownership grouping for Troves and Collections |
| `Hub` | Thematic mini-sites (FRN, IFA) with their own tag associations |
| `TroveType` | Resource type classification |

### Key patterns

**Multilingual content**: `Trove` and `Collection` use `HasTranslations` (Spatie). Fields like `title`, `description`, `link` are JSON columns with locale keys. The active locale is set by the `set.locale` middleware on all web routes.

**Draft/versioning**: Troves use `HasDrafts` (from `/packages/laravel-drafts`). Preview routes load drafts; public routes load published only. The Filament admin UI uses `guava/filament-drafts`.

**Search**: `Trove` and `Collection` implement `Searchable`. Meilisearch indexes are configured in `config/scout.php`. After schema changes, re-run `php artisan scout:sync-index-settings` and reimport.

**Media**: Per-locale media collections (`cover_image_en`, `cover_image_es`, `content_en`, etc.) registered on `Trove`. Storage can be local or S3 (set via `FILESYSTEM_DISK`).

**Admin panel**: Filament resources in `app/Filament/Resources/` handle CRUD for all entities. Each resource has a `Resource.php` (form/table definition) and a `Pages/` subdirectory.

**Frontend browsing**: Livewire components in `app/Livewire/` handle the interactive public pages. `BrowseAll`, `Resources`, and `Collections` are the main browse/search pages. Hub-specific browse pages (`FrnHubBrowseResources`, `IfaHubBrowseResources`) extend the same pattern.

### Directory layout

```
app/
  Filament/Resources/   # Admin panel CRUD definitions
  Http/Controllers/     # Auth controllers only (other routes use closures or Livewire)
  Livewire/             # Interactive public-facing components
  Models/               # Eloquent models
  Providers/            # FilamentServiceProvider, AuthServiceProvider, etc.
packages/               # Local packages: laravel-drafts, filament-drafts, filament-scout
resources/
  views/                # Blade templates (home, trove, collection, frn, ifa, theme-pages)
  livewire/             # Livewire component views
  js/                   # Vue components + app.js
  css/                  # Tailwind entry point
routes/
  web.php               # Public routes (all under set.locale middleware)
  auth.php              # Auth routes
```

### Authentication

- Standard Laravel Auth + Azure AD via `connected_accounts` (Socialite)
- Filament admin access gated by `canAccessPanel()` on the `User` model
- API auth via Laravel Sanctum

## Environment setup

Meilisearch is required — configure `MEILISEARCH_HOST` and `MEILISEARCH_KEY` in `.env`. The `.env.example` uses `http://meilisearch:7700` (Docker default); adjust for local installs.

For file uploads, set `FILESYSTEM_DISK=local` for local dev or configure AWS S3 vars for production.
