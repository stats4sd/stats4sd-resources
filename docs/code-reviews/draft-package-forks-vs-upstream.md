**Date**: 2026-06-25
**Branch**: `temp-merge-1`
**Reviewer**: Claude (automated multi-angle review)
**Scope**: Two forked Composer path-repo submodules (`packages/laravel-drafts`, `packages/filament-drafts`) diffed against their true upstreams (`oddvalue/laravel-drafts`, `GuavaCZ/filament-drafts`). Net real customization: 1 feature in laravel-drafts (`clone_relations`) + 1 dependency pin in filament-drafts.

# Draft package forks vs upstream

Both submodules are forks (`dave-mills/*`) wired into Composer as symlinked `path` repos (see root `composer.json` → `repositories`). Each was compared by adding the genuine upstream as a temporary git remote and diffing the checked-out branch against `upstream/main`. Working trees were clean at review time, so what is checked out equals what the app uses.

## `packages/laravel-drafts` — fork of `oddvalue/laravel-drafts`

- **Branch:** `clone-relations-to-drafts`, forked from upstream `main` at `2e0cc05` (mid-2024).
- **Divergence:** 1 commit ahead, **32 commits behind** current upstream `main`. The fork is missing later upstream work: Laravel 12/13 compatibility, phpstan/rector, PHP 8.4/8.5 support, and CI workflow hardening. Worth noting for any future upgrade.
- **Fork adds exactly 1 commit:** *"add option to clone relations to draft models"*.

### 1. New config flag — `config/drafts.php`

```php
/*
 * Should draftableRelations be cloned when creating a new draft? When false,
 * related entries will be cloned to published versions, but not to drafts.
 */
'clone_relations' => false,
```

### 2. Behaviour change — `src/Concerns/HasDrafts.php`

This is the entire purpose of the fork:

- **`saveAsDraft()`** — upstream replicates draftable relations *only onto the published record, at publish time*. The fork, when `clone_relations` is true, also calls `replicateAndAssociateDraftableRelations($draft)` immediately after the draft saves — so **drafts get their own copy of related records**, not just the published version.
- **`replicateAndAssociateDraftableRelations()`** — for `HasOne` and `HasMany`, when `clone_relations` is true it first **deletes existing related entries on the target** before re-creating them. This is a dedup guard: without it, repeatedly cloning relations onto a draft/published record would accumulate duplicate children.
- For `BelongsToMany` / `MorphToMany`, changed `$this->{$rel}()->pluck('id')` → `$this->{$rel}->pluck('id')` (plucks from the loaded relation collection instead of issuing a fresh query — minor).
- The remainder of the diff is **pure whitespace/style** reformatting bundled into the same commit: `! $x` → `!$x`, `Class.'::'` → `Class . '::'`, `int | Model` → `int|Model`, and a few stray blank lines.

**Net effect:** upstream drafts cannot carry their own related records; this fork lets a draft hold a cloned copy of its draftable relations (gated behind `clone_relations`), with delete-before-recreate to avoid duplicates. This is what allows previewing a draft Trove together with its related child entries.

## `packages/filament-drafts` — fork of `GuavaCZ/filament-drafts`

- **Branch:** `local-testing`, forked from the **current** upstream `main` tip `4300a33`.
- **Divergence:** 1 commit ahead, **0 behind** — fully up to date with GuavaCZ.
- **Fork adds exactly 1 commit:** *"require local laravel-drafts"*. The only change is one line in `composer.json`:

```diff
-        "oddvalue/laravel-drafts": "^1.3"
+        "oddvalue/laravel-drafts": "dev-main"
```

This loosens the dependency so it resolves to the **locally forked, customized laravel-drafts** (via the path repo) instead of the released `^1.3`. No code or behaviour changes.

> Note: the upstream commit `4300a33 "added FR translations and fix tab translations"` is on GuavaCZ's *official* main — FR translations are **not** a fork customization, they are upstream. Apart from the dependency pin, this fork is functionally identical to upstream GuavaCZ filament-drafts.

## Summary

| Package | Fork status | Real customization |
|---|---|---|
| laravel-drafts | 1 ahead / 32 behind upstream | `clone_relations` flag → clone draftable relations onto **drafts**, with dedup; plus style churn |
| filament-drafts | 1 ahead / 0 behind upstream | composer pin to `dev-main` so it uses the local forked laravel-drafts |

The only meaningful code change across both packages is the `clone_relations` feature in laravel-drafts. filament-drafts exists as a fork purely to repoint its dependency at that customized package.
