# JOBZ IN CANADA — Complete Project Analysis

## Overview

**JOBZ IN CANADA** is a full-featured, multi-role Canadian job board platform built on **Laravel 13 + Vite + Tailwind CSS v4 + Alpine.js**. The application is actively running (`php artisan serve`) and uses an SQLite database for local development.

---

## Tech Stack

| Layer | Technology |
|---|---|
| Backend Framework | Laravel 13 (PHP ^8.3) |
| Frontend Bundler | Vite 8 + Laravel Vite Plugin |
| CSS Framework | Tailwind CSS v4 (via `@tailwindcss/vite`) |
| JS Interactivity | Alpine.js v3 |
| Database (dev) | SQLite |
| Auth | Laravel Breeze (email verification required) |
| Roles & Permissions | `spatie/laravel-permission` v8 |
| Storage | Cloudinary (via `CloudinaryService`) |
| Search | Laravel Scout v11 + Semantic Cache (Redis/Predis v3) |
| Payments | Mock / in-house `PaymentService` (no real gateway yet) |
| Fonts | Bunny Fonts — Poppins (300–800 weights) |
| Email | Laravel Mailable classes (SMTP) |
| Queue | Laravel Queue (used for notifications) |

---

## User Roles

Three distinct roles enforced via Spatie Permission:

| Role | Route Prefix | Description |
|---|---|---|
| `admin` | `/admin` | Platform super-administrator |
| `employer` | `/employer` | Company that posts jobs |
| `job_seeker` | `/seeker` | Candidate looking for jobs |

> All protected routes require `auth` + `verified` middleware.

---

## Application Architecture

### Directory Tree

```
app/
├── Console/
├── Helpers/          ← AuditLogHelper
├── Http/
│   ├── Controllers/  ← 19 controllers
│   ├── Middleware/   ← 3 custom middleware
│   └── Requests/     ← Form request classes
├── Jobs/             ← Queued jobs (background tasks)
├── Listeners/
├── Mail/             ← 5 Mailable classes
├── Models/           ← 40 Eloquent models
├── Notifications/    ← ApplicationNotifications
├── Providers/
├── Services/
│   ├── CloudinaryService.php
│   ├── PaymentService.php
│   ├── SemanticCacheService.php
│   └── Storage/
└── View/
```

---

## Database Layer

**42 migrations** covering a very comprehensive schema:

### Core Entities

| Model | Key Fields | Relationships |
|---|---|---|
| `User` | name, email, role, phone, country, city, status | HasMany: resumes, experiences, education, certifications, projects, applications, savedJobs, jobAlerts, notifications; BelongsToMany: skills, companies |
| `Company` | company_name, verification_status, slug | HasMany: jobs, locations, reviews; BelongsToMany: followers |
| `Job` | title, slug, status, featured, urgent, salary, location, employment_type | BelongsTo: company, employer, category; BelongsToMany: skills; HasMany: applications, screeningQuestions |
| `Application` | status, cover_letter, resume_id | BelongsTo: job, applicant; HasMany: notes, statusHistory |

### Profile / Portfolio

- `JobSeekerProfile` — headline, summary, open_to_work, availability
- `EmployerProfile` — linked to company
- `Resume` — file upload (Cloudinary), is_default, version
- `Experience` — job history
- `Education` — degree, institution, dates
- `Certification` — issuer, credential URL
- `Project` — title, URL, description
- `Skill` — global skill list; linked via pivot to both jobs and users

### Engagement

- `SavedJob` pivot
- `JobAlert` — keyword/location triggers for email notifications
- `RecentSearch` + `SearchQuery` — analytics
- `CompanyReview` — rating + body
- `CompanyFollower` pivot
- `JobReport` — abuse reporting
- `Interview` — interview scheduling

### Messaging

- `Conversation` + `Message` — direct messaging system

### Billing / Monetization

- `SubscriptionPlan` + `Subscription` — employer plans (monthly/yearly)
- `Payment` + `Invoice` — full financial ledger
- `FeaturedJob` — time-limited job spotlight promotions
- `ResumeBoost` — time-limited seeker visibility boosts
- `Coupon` — discount codes with percentage/fixed support

### Platform Admin / Audit

- `AuditLog` — action tracking
- `ReportsLog` — moderation queue
- `EmailLog` — sent mail history
- `Notification` — in-app notifications
- `NotificationPreference` — per-user email alert settings
- `Document` — Cloudinary document storage metadata

---

## Controllers (19 total)

| Controller | Responsibility |
|---|---|
| `AdminController` | Users, companies, jobs, categories, skills, reports, reviews, announcements, audit logs |
| `ApplicationController` | Job applications (seeker side) |
| `BillingController` | Subscriptions, job promotions, resume boosts, invoices |
| `CouponController` | Admin coupon CRUD |
| `DashboardController` | Role-based dashboards (admin/employer/seeker), messages, alerts |
| `DesignSystemController` | Design system showcase page |
| `EmployerApplicantController` | Applicant pipeline, candidate search (premium) |
| `EmployerJobController` | Job CRUD, duplicate, status changes |
| `EmployerProfileController` | Employer profile + public company directory |
| `InAppNotificationController` | Notification center |
| `JobController` | Public job listing, show, save, history |
| `NotificationPreferenceController` | Per-user alert settings |
| `ProfileController` | Generic profile edit/delete |
| `RevenueAnalyticsController` | Admin revenue charts |
| `SearchAnalyticsController` | Admin search data |
| `SearchSuggestionController` | Autocomplete API endpoint |
| `SeekerProfileController` | Seeker profile, resume builder, experience/education/skills/projects/certifications |
| `SettingsController` | Account settings, sessions, GDPR data export, deactivation |

---

## Custom Middleware

| Middleware | Purpose |
|---|---|
| `CompanyVerifiedMiddleware` | Blocks unverified employers from posting jobs |
| `CandidateSearchAccess` | Restricts candidate DB search to premium subscribers |
| `ProfileCompletedMiddleware` | Ensures profile is filled before key actions |

---

## Services

| Service | Purpose |
|---|---|
| `PaymentService` | Processes subscriptions, featured job promotions, resume boosts; applies coupons, calculates 13% HST tax, creates payments/invoices/notifications atomically |
| `CloudinaryService` | File upload/management to Cloudinary CDN |
| `SemanticCacheService` | Redis-backed semantic query caching for search |

---

## Routes Summary (web.php — 256 lines)

| Group | Count | Key Routes |
|---|---|---|
| Public | ~8 | `/`, `/jobs`, `/jobs/{slug}`, `/companies`, `/companies/{slug}`, sitemap |
| Admin | ~25 | Dashboard, users, companies, jobs, categories, skills, reports, reviews, coupons, analytics |
| Employer | ~18 | Profile, job CRUD, applicant pipeline, candidate search, billing |
| Seeker | ~20 | Profile, resume builder, applications, alerts, notifications, boost |
| Shared Auth | ~5 | Settings, messages, profile |
| API | ~1 | `/api/jobs/suggestions` (autocomplete) |

---

## Frontend / Views

### Layout System

- `layouts/app.blade.php` — Authenticated shell with sidebar + header + footer, dark mode toggle (Alpine.js localStorage)
- `layouts/guest.blade.php` — Unauthenticated layout
- `layouts/sidebar.blade.php` — Role-aware side navigation (14.8 KB)
- `layouts/navigation.blade.php` — Top navigation
- `layouts/footer.blade.php`

### Blade Components (18)

`alert`, `application-logo`, `auth-session-status`, `card`, `danger-button`, `dropdown`, `dropdown-link`, `empty-state`, `input-error`, `input-label`, `modal`, `nav-link`, `primary-button`, `responsive-nav-link`, `secondary-button`, `skeleton`, `text-input`, `toast`

### View Groups

| Group | Views |
|---|---|
| `home.blade.php` | Public landing page (721 lines, data-fetching in @php block) |
| `jobs/` | index, show (29KB!), apply |
| `admin/` | 12 management views (users, jobs, companies, categories, skills, coupons, reports, reviews, analytics, audit logs, announcements) |
| `employer/` | billing, invoice, promote_job, applicants/, candidates/, jobs/ |
| `seeker/` | resume-builder (34KB), boost, applications/ |
| `company/` | company profiles |
| `messages/` | messaging UI |
| `notifications/` | in-app notification center |
| `profile/` | profile edit |
| `emails/` | email templates |
| `design_system/` | design showcase |
| `components/` | reusable blade components |
| `auth/` | login, register, etc. |

---

## Email / Notification System

| Mailable | Trigger |
|---|---|
| `WelcomeMail` | User registration |
| `VerificationMail` | Email verification |
| `ApplicationMail` | New job application submitted |
| `ApplicationStatusUpdateMail` | Status change (shortlisted, rejected, etc.) |
| `AlertMatchNotificationMail` | Job alert match found |

In-app notifications are stored in the `notifications` table and served via `InAppNotificationController`.

---

## Current State / Observations

### ✅ Strengths
- **Very comprehensive schema** — 40 models covering nearly every feature of a production job board
- **Role-based access control** — Clean Spatie permission integration
- **Full billing system** — Subscriptions, promotions, boosts, coupons, invoicing, HST tax
- **Audit trail** — `AuditLog` on all sensitive actions
- **GDPR compliance** — Data export + account deactivation in settings
- **SEO** — Dynamic XML sitemap generator built into routes
- **Analytics** — Search analytics, revenue analytics dashboards for admin
- **Dark mode** — Alpine.js + localStorage persisted

### ⚠️ Gaps / Issues to Address

1. **`app.css` is completely empty (0 bytes)** — The active CSS file the user has open has no content. All styling likely lives in Tailwind utility classes inline in Blade templates, but any custom CSS/design tokens are missing.

2. **`layouts/app.blade.php` has no CSS classes** — The main authenticated layout has raw semantic HTML tags with no Tailwind classes applied. This means the authenticated dashboard shell has no visual styling.

3. **`PaymentService` uses a mock gateway** — `payment_gateway => 'mock'` with no real payment processor integration (Stripe, PayPal, etc.).

4. **`home.blade.php` does DB queries directly in `@php` block** — Should move to a controller or dedicated View Composer for cleaner MVC separation.

5. **No API routes file** — The autocomplete API endpoint lives in `web.php`; should be in `api.php` with proper rate limiting.

6. **No tests written** — `tests/` directory exists but likely has only the Laravel defaults.

7. **`SemanticCacheService` depends on Redis** — Predis is configured but in local SQLite dev environment, caching may not be active.

8. **`google/apiclient` in composer** — Google API client is a dependency but its usage isn't visible in the reviewed files; unclear what feature uses it.

9. **Impersonation security** — Admin can impersonate any user; the revert route only checks `auth` (not `admin`), which could be a security surface.

---

## Monetization Model

| Feature | Pricing (CAD) |
|---|---|
| Featured Job — 7 days | $10 + 13% HST |
| Featured Job — 15 days | $18 + 13% HST |
| Featured Job — 30 days | $30 + 13% HST |
| Featured Job — 60 days | $50 + 13% HST |
| Resume Boost — 7 days | $5 + 13% HST |
| Resume Boost — 15 days | $9 + 13% HST |
| Resume Boost — 30 days | $15 + 13% HST |
| Employer Subscription | Plans stored in `subscription_plans` table (monthly/yearly) |

Discount coupons supported (percentage or fixed amount).

---

## Running the Project

```bash
# Dev server (currently running)
php artisan serve

# Full dev environment (queue + vite + logs)
composer dev

# Build frontend
npm run build
```

> **Database**: SQLite at `database/database.sqlite` (98 KB, contains data)
