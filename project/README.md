# Akhani Connect

Akhani Connect is a Laravel 10 platform built for South African recruitment and procurement workflows.

It combines:

- candidate registration, profile management, document upload, and job applications
- recruitment job publishing and candidate/application review
- procurement identity and company verification workflows
- client-side review of procurement verification records
- superadmin user, reporting, analytics, and platform management

## Stack

- PHP 8.1+
- Laravel 10
- MySQL
- Bootstrap 5
- jQuery / JavaScript
- XAMPP for local development
- DOMPDF for PDF export
- Guzzle for API integrations

## Core Roles

- `Superadmin`
- `Candidate`
- `Recruitment`
- `Procurement`
- `Client`

## Key Features Delivered

### Authentication and onboarding

- role-based registration for candidate, recruitment, and procurement
- superadmin-created client accounts
- login, logout, forgot password, and reset password flows
- welcome email on registration
- role-based dashboard redirects
- identity-verification gate for protected role areas

### Shared account features

- profile/account update
- profile picture upload
- verification-aware role badges
- notification center
- themed auth screens and shared dashboard layout

### Candidate

- SA ID verification
- driver licence verification via API
- candidate profile completion
- candidate document uploads
- job browsing and applications
- application tracking dashboard

### Recruitment

- SA ID verification
- recruiter/company profile update
- create, edit, publish-date manage, and delete jobs
- WYSIWYG job description editor
- candidate and application review
- access to candidate and application documents

### Procurement

- SA ID verification
- locked ID number sourced from verified identity record
- procurement profile completion
- CIPC enterprise verification by registration number
- enterprise directors verification by director ID number
- driver licence verification via API
- supporting document uploads
- verification history and re-verification
- PDF downloads for enterprise and director records
- progress dashboard based on the core procurement verification modules

### Client

- SA ID verification
- client dashboard with analytics charts
- procurement record search and filtering
- procurement user detail review
- enterprise, director, and document PDF/download access
- follow-up notifications to procurement users

### Superadmin

- user management
- client management
- verification log review
- procurement and candidate detail review
- analytics/activity tracking
- dashboard analytics charts
- reports and settings areas

## Verification Integrations

The platform is integrated around VerifyNow workflows.

Current verification modules in the application include:

- `SA ID Verification`
- `Enterprise Verification`
- `Enterprise Directors Verification`
- `Driver Licence Verification`
- `Bank Account Verification` scaffolded in procurement

The application stores:

- verification status per module
- processed verification summaries
- verification history / retry attempts
- raw and structured supporting data used for display and reporting

## South African-specific support

- South African ID number verification
- South African provinces dropdowns where required
- South African company verification workflows
- South African phone-oriented onboarding flows
- South African driver licence verification support

## UI and Theme Notes

The app uses the supplied HTML theme and customizes it for Akhani Connect branding:

- primary color: `#e76505`
- primary text color: `#202124`
- body font: `Manrope`
- heading font: `Plus Jakarta Sans`

Custom frontend assets live mainly under:

- `public/assets/css/akhani-theme.css`
- `public/assets/js/custom`

## Project Structure

Project folder:

```text
project/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
├── resources/
├── routes/
├── storage/
└── tests/
```

## Important Application Areas

- routes: `routes/web.php`
- shared layout: `resources/views/layouts/app.blade.php`
- theme overrides: `public/assets/css/akhani-theme.css`
- verification config: `config/verifynow.php`
- SA helper config: `config/south_africa.php`

## Seeders

Available seeders include:

- `RoleSeeder`
- `PermissionSeeder`
- `RolePermissionSeeder`
- `SuperadminSeeder`
- `DefaultUserSeeder`
- `RecruitmentJobSeeder`
- `DatabaseSeeder`

The project has been set up to support seeded default role accounts and seeded recruitment jobs for testing/demo use.

## Local Setup

1. Install PHP/MySQL dependencies.

```bash
composer install
```

2. Create the application key.

```bash
php artisan key:generate
```

3. Configure your environment in `.env`.

Minimum areas to review:

- database connection
- mail configuration
- filesystem/public storage
- VerifyNow credentials

4. Run migrations and seeders.

```bash
php artisan migrate --seed
```

If you want a full clean reset for testing:

```bash
php artisan migrate:fresh --seed
```

5. Create the storage symlink if needed.

```bash
php artisan storage:link
```

6. Start the local server.

```bash
php artisan serve
```

## Environment Variables

VerifyNow configuration uses:

```env
VERIFYNOW_API_KEY=
VERIFYNOW_MODE=sandbox
VERIFYNOW_BASE_URL=https://www.verifynow.co.za/api/external
VERIFYNOW_TIMEOUT=30
```

You will also need normal Laravel `.env` values for:

- `APP_URL`
- `DB_*`
- `MAIL_*`
- `FILESYSTEM_DISK`

## Testing Notes

This project has been tested heavily through UI and workflow iteration. Where API-backed verification is used, the application expects valid provider credentials and reachable provider endpoints.

Useful commands:

```bash
php artisan test
php artisan route:list
php artisan config:clear
php artisan cache:clear
```

## PDF Exports

PDF exports are supported for:

- procurement enterprise details
- procurement director details
- procurement review reports
- client/admin procurement report views

These are powered by `barryvdh/laravel-dompdf`.

## WordPress Jobs Plugin

A companion WordPress plugin was also created for public job listing display:

- plugin folder: `assets/akhaniconnectjobs`
- shortcode: `['akhani-connect-jobs']`

It supports:

- keyword search
- province filter
- job type filter
- accordion job listing UI
- pagination with previous/next controls
- external apply link to the Akhani Connect admin application

## Current Focus Areas / Remaining Considerations

Before production rollout, review:

- final VerifyNow production credentials and error handling
- queue/mail configuration for production
- scheduled maintenance/log rotation
- test coverage for high-risk flows
- authorization/policy review across all roles
- production storage/CDN strategy for uploaded documents

## Credits

Platform: `Akhani Connect`

WordPress jobs plugin developer details used in the plugin:

- `LMK Digital`
- [https://lmkdigital.africa/](https://lmkdigital.africa/)
- `info@lmkdigital.africa`
