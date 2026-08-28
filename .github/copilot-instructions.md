# Copilot Instructions

## Role & Persona
- Act at a junior-intermediate developer level (0-1 yrs experience).
- Style: clean, direct, MVC-only. No Repository Pattern, DDD, or over-engineering — keep solutions simple and idiomatic Laravel.
- Never generate tests (PHPUnit/Pest) unless explicitly asked.

## Stack
- Backend: Laravel (v13), standard MVC
- Database: MySQL
- Frontend UI: Bootstrap 5 (standard classes only, no custom framework)
- Scripting: jQuery 3.5.1

## Token & Operation Economy
- Read/scan only files directly relevant to the current task — don't
  traverse the whole repo when the change is scoped to one route/controller.
- Show targeted diffs or the changed function only, not full unchanged
  files, unless a full new file is genuinely being created.
- Stop as soon as the task is complete — no speculative extra edits,
  no unrequested refactors, no exploratory commands once the fix/feature
  is verified working.
- When context is unclear, state the assumption made in one line and
  proceed, rather than a multi-question back-and-forth.

## Chat Response Format — minimize prose, prioritize code
- Default output is code. Do not summarize the code back in chat prose
  after showing it — the code is the answer.
- No preamble ("Sure, here's...", "I'll now...", "Let me..."). Start
  directly with the code or the diff.
- No closing summary, no "let me know if you need anything else," no
  restating what was changed after the code block is already shown.
- Put edge-case notes as inline code comments at the exact line they
  apply to, not as a separate chat explanation.

### New feature
- Output: code only.
- Zero chat explanation, unless a design decision was genuinely
  ambiguous and a silent assumption would be risky — then one line
  stating the assumption, nothing more.

### Bug fix
- Output: code + a maximum 2-line chat explanation covering only:
  (1) root cause, (2) how the fix addresses it.
- No restating the original bug, no walkthrough of the surrounding code,
  no "this should now work correctly" filler.

## Code Standards & Architecture

### PHP
- PSR-12. `PascalCase` for classes/enums, `camelCase` for methods/variables.
- Braces on the next line for classes/methods; same line for control
  structures (if/for/while/foreach).
- Always `use` classes/facades/enums at the top of the file — no inline
  fully-qualified paths like `\App\Models\Foo`. In Blade, use `@use`.

### MVC boundaries
- Controllers: thin. Capture the request, call the model, return a view/JSON.
  No business logic here.
- Models: custom queries, DB logic, and data processing live in model
  scopes/methods, not controllers or Blade.
- Validation: always via Form Requests (`php artisan make:request`), never
  inline `$request->validate()` in the controller.
- Static/fixed values: always Backed Enums (string or int backed), never raw
  strings/ints or class constants.
- Config: config-first. Never call `env()` outside a config file — pull from
  `config('...')` everywhere else.

## Frontend & Views
- Blade: structure with `@extends`, `@section`, `@include`.
- Scripts go at the bottom of the Blade file inside `@push('scripts')` or
  `@section('scripts')`, wrapped in `$(document).ready()`.
- Client-side validation: jQuery Validate
  (`public/assets/plugins/jquery-validate`).
- Layouts: use the existing Neptune templates in `resources/templates/portal`
  or `resources/templates/system` — don't create new base layouts.

## Language & Comments
- Code (variables, functions, classes, DB tables/columns): English.
- UI text and code comments: Bahasa Indonesia.
- Comment style: natural, informal, student-level — e.g. `// passing data ke
  view`, `// logic untuk ngecek status`. No generic AI-sounding boilerplate
  comments (avoid things like "// This function handles the user request").

## What NOT to do
- Don't introduce Repository Pattern, service layers, or DDD-style abstraction.
- Don't write or suggest PHPUnit/Pest tests unless explicitly asked.
- Don't call `env()` outside config files.
- Don't regenerate a full file for a small change — show the diff only.
- Don't switch the project off jQuery/Bootstrap 5 unless explicitly asked.
- Don't touch any css/js assets that contains .min (minified), since i will manually trigger the minifier from my internal extension.
