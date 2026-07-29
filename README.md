# Ithrive Software Solutions — corporate website

A multi-page PHP website for Ithrive Software Solutions: dark-mode, glassmorphic,
with a WebGL hero and a dedicated page for every service, solution and case study.

No build step, no package manager at runtime — deploy the folder to any PHP 8.1+
host and it runs.

## Layout

```
index.php              Home
services.php           Services overview (tabbed matrix)
services/*.php         15 service detail pages
solutions.php          Proprietary AI products + industry patterns
solutions/*.php        Ithrive Insights, Ithrive AIChat
case-studies.php       Filterable grid of all 10 studies
case-studies/*.php     10 case study detail pages
company/               about.php, process.php, careers.php
blog.php               Article index
contact.php            Enquiry form + direct channels
404.php                Not-found page

handlers/
  contact-submit.php   Validates, logs and mails enquiries

includes/
  config.php           Site constants, navigation tree, BASE_URL resolution
  functions.php        e() url() asset() component() icon() + lookups + CSRF
  content.php          Every piece of copy on the site
  header.php           Glass navbar with mega-dropdowns
  footer.php
  components/          Reusable partials (see below)
  templates/           Shared page bodies behind the route files

assets/
  css/style.css        The whole design system
  js/main.js           Nav, dropdowns, tabs, filters, slider, modal, validation
  js/hero-scene.js     Three.js neural ring
  vendor/three/        three.module.js (vendored — no CDN)
  img/                 SVG logo mark and favicon

storage/               Submitted enquiries (git-ignored)
```

### Sub-pages are thin route files

Each of the 27 detail pages is five lines that set a slug and include a shared
template, so every page keeps a real URL while the layout lives in one place:

```php
<?php
declare(strict_types=1);

$serviceSlug = 'cloud-devops';

require dirname(__DIR__) . '/includes/templates/service-detail.php';
```

To add a service, add an entry to `SERVICES` in `includes/content.php` and drop
a matching route file into `services/`. The navigation, footer, sibling lists
and the contact form's service picker all read from that same constant.

### Components

`hero-3d`, `page-hero`, `section-head`, `feature-card`, `service-card`,
`case-study-card`, `mock-window`, `services-matrix`, `process-pipeline`,
`process-pipeline-compact`, `stats-band`, `client-logo-grid`,
`testimonial-slider`, `contact-form`, `contact-modal`, `cta`.

Render one with `component('name', ['key' => $value])`.

## Design system

| Token | Value |
| --- | --- |
| Base | `#0B0F17` |
| Cyan accent | `#00F2FE` |
| Purple accent | `#9D4EDD` |
| Type | Inter, JetBrains Mono for numerals |

Surfaces are `rgba(255,255,255,.035)` over a fixed grid field with two colour
blooms, blurred with `backdrop-filter`. Cards carry a gradient hairline that
lights up on hover. Every accent is driven by CSS custom properties, so a case
study sets `--accent` once and its mock window, metrics and rules follow.

## Running it locally

With a normal PHP install:

```bash
php -S localhost:8100
```

This machine has no native PHP, so there is a dev server that runs real PHP 8.3
compiled to WebAssembly:

```bash
node .tools/serve.mjs 8100
```

Run `npm install` inside `.tools/` first. Pin `@php-wasm/node` to 3.1.x — the
1.x line resolves the wasm binary to a malformed absolute path on Windows.

## Notes for deployment

- **Contact form.** Enquiries are appended to `storage/enquiries.ndjson` and
  mailed to `SITE_EMAIL` via `mail()`. Swap in SMTP where `deliver` is noted in
  `handlers/contact-submit.php`; the log is written either way, and the sender
  is told plainly if neither succeeded. `storage/` must be writable and must not
  be web-readable — the bundled `.htaccess` blocks it.
- **`LOCK_EX`.** The handler tries an exclusive lock first and falls back to an
  unlocked append, because some streams (including the wasm dev server) reject
  locking outright.
- **Pretty URLs.** `.htaccess` maps `/services/cloud-devops` to the `.php` file.
  On nginx, add the equivalent `try_files $uri $uri.php $uri/ =404;`.
- **Contact details.** `SITE_EMAIL`, `SITE_PHONE` and `SITE_HQ` in
  `includes/config.php` are placeholders. Replace before going live.
- **Case study imagery.** Every project card renders a CSS device mock — a
  browser or phone frame with the client's name, a metric row and a chart —
  rather than a screenshot of the client's live product. Swap in real captures
  once you have permission to publish them.
