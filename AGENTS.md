# Akhani Connect

## Project Overview

Akhani Connect is a South African web application that combines:

* Recruitment Management
* Procurement Verification

The platform allows:

* Candidates to register and apply for jobs
* Recruiters to manage candidates
* Procurement users to verify business information
* Clients to view procurement verification records
* Superadmins to manage the platform

The application is designed specifically for South African users.

---

## Technology Stack

### Backend

* Laravel 10
* PHP 8+
* MySQL

### Frontend

* Bootstrap 5
* jQuery
* JavaScript

### Development Environment

* XAMPP
* phpMyAdmin

---

## Project Structure

```text
akhaniconnect/
│
├── AGENTS.md
├── assets/
├── project/
└── theme/
```

### assets

Contains:

* Legacy procurement screenshots
* Verification workflow examples
* Dashboard examples

### theme

Contains:

* HTML admin template
* Layouts
* Forms
* Cards
* Tables
* Widgets

### project

Contains:

* Laravel application source code

---

## AI Agent Instructions

Before generating code:

1. Read AGENTS.md completely.
2. Review assets folder.
3. Review theme folder.
4. Build implementation plan.
5. Generate migrations.
6. Generate models.
7. Generate services.
8. Generate controllers.
9. Generate views.

Do not start coding before completing the review process.

---

## Target Country

South Africa

Support:

* South African ID Numbers
* South African Companies
* South African Phone Numbers
* South African Driver Licences

---

## User Roles

### Superadmin

Responsibilities:

* Manage users
* Manage settings
* Manage reports
* Manage clients
* View verification logs

### Candidate

Responsibilities:

* Verify identity
* Manage profile
* Upload documents
* Search jobs
* Apply for jobs
* Track applications

Restriction:

* Cannot access dashboard until identity verification succeeds

### Recruitment

Responsibilities:

* Search candidates
* Manage candidate profiles
* Contact candidates
* Manage recruiter company profile

### Procurement

Responsibilities:

* Verify identity
* Verify enterprise details
* Verify enterprise directors
* Verify driver licence
* Upload documents
* Download reports

Restriction:

* Cannot access dashboard until identity verification succeeds

### Client

Responsibilities:

* View procurement records
* Search procurement users
* Filter procurement users
* Send notifications

Restrictions:

* Created by Superadmin only
* Cannot self-register

---

## Registration Types

Allowed:

* Candidate
* Recruitment
* Procurement

Required Fields:

* Name
* Surname
* Email
* Phone
* Password

Rules:

* Email must be unique
* Phone must be unique
* Send welcome email after registration

---

## Role IDs

| ID | Role        |
| -- | ----------- |
| 1  | Superadmin  |
| 2  | Candidate   |
| 3  | Recruitment |
| 4  | Procurement |
| 5  | Client      |

---

## VerifyNow Integration

Use VerifyNow as the verification provider.

Verification Modules:

* SA ID Verification
* Enterprise Verification
* Enterprise Directors Verification
* Driver Licence Verification
* Consumer Trace
* Bank Account Verification

Requirements:

* Save raw API responses
* Save processed API responses
* Save verification history
* Log requests and responses
* Allow re-verification

---

## Development Standards

Use:

* Form Requests
* Service Classes
* Eloquent Relationships
* Policies
* Notifications
* Queues

Avoid:

* Business logic in controllers
* Raw SQL when Eloquent can be used
* Inline JavaScript in Blade templates

---

## Coding Standards

### Controllers

* Thin controllers only
* Move business logic to services

### Services

Responsible for:

* Verification logic
* API integrations
* PDF generation

### Models

Responsible for:

* Relationships
* Accessors
* Mutators

### Views

Requirements:

* Bootstrap 5
* Responsive
* Reusable components

---

## Success Criteria

The project is complete when:

* Authentication works
* Registration works
* All roles function correctly
* VerifyNow integrations function correctly
* Candidates can apply for jobs
* Recruiters can manage candidates
* Procurement users can complete verification workflows
* Clients can view procurement information
* PDF reports can be generated
* Notifications are operational
* Application is production ready
