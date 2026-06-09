-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2026 at 11:09 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sag_akhani_connect`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `candidate_user_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'submitted',
  `cover_letter` text DEFAULT NULL,
  `reviewer_notes` text DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `applied_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `candidate_profiles`
--

CREATE TABLE `candidate_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `job_title` varchar(255) DEFAULT NULL,
  `experience_level` varchar(50) DEFAULT NULL,
  `employment_status` varchar(50) DEFAULT NULL,
  `notice_period` varchar(100) DEFAULT NULL,
  `willing_to_relocate` tinyint(1) DEFAULT NULL,
  `job_industry` varchar(255) DEFAULT NULL,
  `preferred_employment_type` varchar(100) DEFAULT NULL,
  `salary_expectation` varchar(100) DEFAULT NULL,
  `education_level` varchar(100) DEFAULT NULL,
  `education` text DEFAULT NULL,
  `certifications` text DEFAULT NULL,
  `experience` text DEFAULT NULL,
  `skills` text DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `cv_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `candidate_profiles`
--

INSERT INTO `candidate_profiles` (`id`, `user_id`, `job_title`, `experience_level`, `employment_status`, `notice_period`, `willing_to_relocate`, `job_industry`, `preferred_employment_type`, `salary_expectation`, `education_level`, `education`, `certifications`, `experience`, `skills`, `bio`, `cv_path`, `created_at`, `updated_at`) VALUES
(1, 2, 'Procurement Administrator', 'Mid-level', 'Available', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Seeded candidate account for Akhani Connect testing.', NULL, '2026-06-08 23:49:19', '2026-06-08 23:49:19');

-- --------------------------------------------------------

--
-- Table structure for table `client_profiles`
--

CREATE TABLE `client_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `contact_person_name` varchar(255) DEFAULT NULL,
  `company_phone` varchar(20) DEFAULT NULL,
  `access_scope` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `client_profiles`
--

INSERT INTO `client_profiles` (`id`, `user_id`, `company_name`, `contact_person_name`, `company_phone`, `access_scope`, `created_at`, `updated_at`) VALUES
(1, 5, 'Akhani Client Group', 'Nandi Dlamini', '0515550101', 'All procurement records', '2026-06-08 23:49:19', '2026-06-08 23:49:19');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `application_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `original_name` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `mime_type` varchar(100) NOT NULL,
  `size` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'uploaded',
  `uploaded_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `employment_type` varchar(50) DEFAULT NULL,
  `description` text NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'draft',
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `user_id`, `title`, `location`, `province`, `employment_type`, `description`, `status`, `published_at`, `created_at`, `updated_at`) VALUES
(1, 3, 'Procurement Administrator', 'Johannesburg', 'Gauteng', 'Permanent', '<p>A growing supply chain business is looking for a Procurement Administrator to support vendor onboarding, purchase order tracking, and reporting for internal stakeholders.</p><h4>Key Responsibilities</h4><ul><li>Capture purchase orders and maintain supplier records.</li><li>Follow up on quotations, delivery dates, and outstanding paperwork.</li><li>Prepare weekly procurement status reports for management.</li></ul><h4>Minimum Requirements</h4><ul><li>2+ years of procurement or administration experience.</li><li>Strong Excel and document management skills.</li><li>Comfortable working in a fast-paced operations environment.</li></ul>', 'published', '2026-06-08 23:52:33', '2026-06-08 23:52:33', '2026-06-08 23:52:33'),
(2, 3, 'Site Quantity Surveyor', 'Gqeberha', 'Eastern Cape', 'Contract', '<p>A construction contractor requires a Site Quantity Surveyor to manage project cost tracking, subcontractor measurements, and claims support on active building projects.</p><h4>Key Responsibilities</h4><ul><li>Measure work completed on site and prepare payment certificates.</li><li>Track variations, material usage, and subcontractor claims.</li><li>Assist with cost reports and final account preparation.</li></ul><h4>Minimum Requirements</h4><ul><li>National Diploma or Degree in Quantity Surveying.</li><li>Experience on building or civil projects.</li><li>Strong attention to detail and site coordination ability.</li></ul>', 'published', '2026-06-08 23:52:33', '2026-06-08 23:52:33', '2026-06-08 23:52:33'),
(3, 3, 'Warehouse Supervisor', 'Bloemfontein', 'Free State', 'Permanent', '<p>An established logistics operator is hiring a Warehouse Supervisor to lead daily warehouse activities, inventory control, and dispatch coordination.</p><h4>Key Responsibilities</h4><ul><li>Supervise receiving, picking, packing, and dispatch teams.</li><li>Monitor stock movement and investigate inventory variances.</li><li>Ensure warehouse safety and housekeeping standards are maintained.</li></ul><h4>Minimum Requirements</h4><ul><li>3+ years of warehousing or distribution supervision experience.</li><li>Experience with inventory systems and stock reconciliation.</li><li>Strong people management and reporting skills.</li></ul>', 'published', '2026-06-08 23:52:33', '2026-06-08 23:52:33', '2026-06-08 23:52:33'),
(4, 3, 'HR Officer', 'Durban', 'KwaZulu-Natal', 'Permanent', '<p>A regional services company is seeking an HR Officer to support recruitment administration, onboarding, leave management, and employee relations processes.</p><h4>Key Responsibilities</h4><ul><li>Coordinate interview scheduling, offers, and onboarding packs.</li><li>Maintain leave records and support payroll-related queries.</li><li>Assist with employee relations documentation and policy communication.</li></ul><h4>Minimum Requirements</h4><ul><li>Diploma or Degree in Human Resources or related field.</li><li>2+ years of generalist HR administration experience.</li><li>Good understanding of South African labour practices.</li></ul>', 'published', '2026-06-08 23:52:33', '2026-06-08 23:52:33', '2026-06-08 23:52:33'),
(5, 3, 'Junior IT Support Technician', 'Polokwane', 'Limpopo', 'Permanent', '<p>A technology support business is looking for a Junior IT Support Technician to assist users with hardware, software, and connectivity issues across branch offices.</p><h4>Key Responsibilities</h4><ul><li>Log and resolve first-line support tickets.</li><li>Set up workstations, printers, and user accounts.</li><li>Escalate unresolved issues and maintain support documentation.</li></ul><h4>Minimum Requirements</h4><ul><li>Relevant IT certificate or diploma.</li><li>Basic troubleshooting knowledge across Windows and networks.</li><li>Good communication and customer service skills.</li></ul>', 'published', '2026-06-08 23:52:33', '2026-06-08 23:52:33', '2026-06-08 23:52:33'),
(6, 3, 'Operations Coordinator', 'Nelspruit', 'Mpumalanga', 'Permanent', '<p>A field services company needs an Operations Coordinator to manage scheduling, customer communication, and performance tracking across multiple teams.</p><h4>Key Responsibilities</h4><ul><li>Coordinate technician schedules and route planning.</li><li>Maintain service logs and update customers on progress.</li><li>Compile daily and weekly operational performance reports.</li></ul><h4>Minimum Requirements</h4><ul><li>Experience in operations, logistics, or scheduling.</li><li>Excellent organisational and communication skills.</li><li>Strong administrative ability and attention to detail.</li></ul>', 'published', '2026-06-08 23:52:33', '2026-06-08 23:52:33', '2026-06-08 23:52:33'),
(7, 3, 'Safety Officer', 'Kimberley', 'Northern Cape', 'Contract', '<p>A mining support contractor is searching for a Safety Officer to drive site compliance, toolbox talks, inspections, and incident follow-up.</p><h4>Key Responsibilities</h4><ul><li>Conduct daily site inspections and risk observations.</li><li>Maintain safety files, permits, and compliance registers.</li><li>Support incident investigations and corrective action tracking.</li></ul><h4>Minimum Requirements</h4><ul><li>Relevant safety qualification and registration where required.</li><li>Experience in industrial, mining, or construction environments.</li><li>Strong reporting and stakeholder engagement skills.</li></ul>', 'published', '2026-06-08 23:52:33', '2026-06-08 23:52:33', '2026-06-08 23:52:33'),
(8, 3, 'Sales Representative', 'Mahikeng', 'North West', 'Permanent', '<p>A fast-moving consumer goods distributor is hiring a Sales Representative to grow customer relationships and achieve monthly sales targets in the region.</p><h4>Key Responsibilities</h4><ul><li>Visit customers, present promotions, and secure orders.</li><li>Maintain route plans and submit accurate sales reports.</li><li>Support merchandising and customer service activities.</li></ul><h4>Minimum Requirements</h4><ul><li>Proven field sales experience.</li><li>Valid driver’s licence and willingness to travel locally.</li><li>Good communication and target-driven mindset.</li></ul>', 'published', '2026-06-08 23:52:33', '2026-06-08 23:52:33', '2026-06-08 23:52:33'),
(9, 3, 'Financial Accountant', 'Cape Town', 'Western Cape', 'Permanent', '<p>A growing finance team requires a Financial Accountant to manage month-end reporting, reconciliations, compliance support, and audit preparation.</p><h4>Key Responsibilities</h4><ul><li>Prepare journals, reconciliations, and monthly financial reports.</li><li>Support statutory compliance and audit document preparation.</li><li>Analyse variances and provide finance insights to management.</li></ul><h4>Minimum Requirements</h4><ul><li>Completed accounting qualification.</li><li>Experience in month-end reporting and reconciliations.</li><li>Strong Excel skills and attention to accuracy.</li></ul>', 'published', '2026-06-08 23:52:33', '2026-06-08 23:52:33', '2026-06-08 23:52:33'),
(10, 3, 'Receptionist and Office Administrator', 'Johannesburg', 'Gauteng', 'Permanent', '<p>A professional services office is seeking a Receptionist and Office Administrator to manage front-desk operations and day-to-day office support.</p><h4>Key Responsibilities</h4><ul><li>Welcome visitors and handle incoming calls professionally.</li><li>Manage meeting room bookings, courier requests, and office supplies.</li><li>Support filing, correspondence, and general administration.</li></ul><h4>Minimum Requirements</h4><ul><li>Previous reception or office administration experience.</li><li>Professional communication and presentation skills.</li><li>Good organisational skills and confidence with office systems.</li></ul>', 'published', '2026-06-08 23:52:33', '2026-06-08 23:52:33', '2026-06-08 23:52:33'),
(11, 3, 'Mechanical Maintenance Fitter', 'Middelburg', 'Mpumalanga', 'Contract', '<p>An industrial plant is looking for a Mechanical Maintenance Fitter to assist with preventative maintenance, breakdown support, and shutdown work.</p><h4>Key Responsibilities</h4><ul><li>Carry out planned maintenance on production equipment.</li><li>Respond to breakdowns and assist with root-cause analysis.</li><li>Complete maintenance documentation and safety checks.</li></ul><h4>Minimum Requirements</h4><ul><li>Trade-tested fitter qualification.</li><li>Experience in plant or heavy industrial maintenance.</li><li>Ability to work shifts or shutdown periods when required.</li></ul>', 'published', '2026-06-08 23:52:33', '2026-06-08 23:52:33', '2026-06-08 23:52:33'),
(12, 3, 'Customer Service Consultant', 'Pietermaritzburg', 'KwaZulu-Natal', 'Permanent', '<p>A customer-focused business is recruiting a Customer Service Consultant to handle inbound queries, resolve issues, and maintain service excellence.</p><h4>Key Responsibilities</h4><ul><li>Respond to customer queries via phone and email.</li><li>Resolve service issues and escalate complex matters appropriately.</li><li>Maintain accurate customer records and interaction notes.</li></ul><h4>Minimum Requirements</h4><ul><li>Experience in customer service or call centre support.</li><li>Clear written and verbal communication skills.</li><li>Calm problem-solving approach and attention to detail.</li></ul>', 'published', '2026-06-08 23:52:33', '2026-06-08 23:52:33', '2026-06-08 23:52:33');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2026_06_08_070000_create_roles_table', 1),
(6, '2026_06_08_070050_add_role_foreign_key_to_users_table', 1),
(7, '2026_06_08_070100_create_permissions_table', 1),
(8, '2026_06_08_070200_create_permission_role_table', 1),
(9, '2026_06_08_070300_create_profiles_table', 1),
(10, '2026_06_08_070400_create_candidate_profiles_table', 1),
(11, '2026_06_08_070500_create_recruitment_profiles_table', 1),
(12, '2026_06_08_070600_create_procurement_profiles_table', 1),
(13, '2026_06_08_070700_create_client_profiles_table', 1),
(14, '2026_06_08_071000_create_procurement_directors_table', 1),
(15, '2026_06_08_071100_create_documents_table', 1),
(16, '2026_06_08_071200_create_verification_records_table', 1),
(17, '2026_06_08_071300_create_verification_attempts_table', 1),
(18, '2026_06_08_072000_create_jobs_table', 1),
(19, '2026_06_08_072100_create_applications_table', 1),
(20, '2026_06_08_072200_create_notifications_table', 1),
(21, '2026_06_08_072300_add_verifiable_to_verification_records_table', 1),
(22, '2026_06_08_072400_add_verification_fields_to_procurement_directors_table', 1),
(23, '2026_06_08_072500_create_platform_settings_table', 1),
(24, '2026_06_08_072600_add_review_fields_to_applications_table', 1),
(25, '2026_06_08_072700_add_application_id_to_documents_table', 1),
(26, '2026_06_08_072800_add_enterprise_api_fields_to_procurement_profiles_table', 1),
(27, '2026_06_08_072900_add_api_sync_fields_to_procurement_directors_table', 1),
(28, '2026_06_08_073000_add_workspace_fields_to_candidate_profiles_table', 1),
(29, '2026_06_08_073100_add_province_to_jobs_table', 1),
(30, '2026_06_09_083000_add_profile_fields_to_procurement_directors_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('connect@gabrielo.co.za', '$2y$12$S9fq8IOF8hdpSZosBG0QPOYJsreDI8Qv81AWALuHJjUsFgtPlRZbq', '2026-06-09 04:53:13');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 'View dashboard', 'dashboard.view', 'Access role dashboard pages.', '2026-06-08 23:49:19', '2026-06-08 23:49:19'),
(2, 'View profile', 'profile.view', 'View own account profile.', '2026-06-08 23:49:19', '2026-06-08 23:49:19'),
(3, 'Update profile', 'profile.update', 'Update own account profile.', '2026-06-08 23:49:19', '2026-06-08 23:49:19'),
(4, 'Manage users', 'users.manage', 'Create, update, and manage platform users.', '2026-06-08 23:49:19', '2026-06-08 23:49:19'),
(5, 'Manage roles', 'roles.manage', 'Manage system roles and access assignments.', '2026-06-08 23:49:19', '2026-06-08 23:49:19'),
(6, 'Manage settings', 'settings.manage', 'Update platform-level settings.', '2026-06-08 23:49:19', '2026-06-08 23:49:19'),
(7, 'View reports', 'reports.view', 'Access reporting pages.', '2026-06-08 23:49:19', '2026-06-08 23:49:19'),
(8, 'Manage clients', 'clients.manage', 'Create and manage client accounts.', '2026-06-08 23:49:19', '2026-06-08 23:49:19');

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`id`, `role_id`, `permission_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2026-06-08 23:49:19', '2026-06-08 23:49:19'),
(2, 1, 2, '2026-06-08 23:49:19', '2026-06-08 23:49:19'),
(3, 1, 3, '2026-06-08 23:49:19', '2026-06-08 23:49:19'),
(4, 1, 4, '2026-06-08 23:49:19', '2026-06-08 23:49:19'),
(5, 1, 5, '2026-06-08 23:49:19', '2026-06-08 23:49:19'),
(6, 1, 6, '2026-06-08 23:49:19', '2026-06-08 23:49:19'),
(7, 1, 7, '2026-06-08 23:49:19', '2026-06-08 23:49:19'),
(8, 1, 8, '2026-06-08 23:49:19', '2026-06-08 23:49:19'),
(9, 2, 1, '2026-06-08 23:49:19', '2026-06-08 23:49:19'),
(10, 2, 2, '2026-06-08 23:49:19', '2026-06-08 23:49:19'),
(11, 2, 3, '2026-06-08 23:49:19', '2026-06-08 23:49:19'),
(12, 3, 1, '2026-06-08 23:49:19', '2026-06-08 23:49:19'),
(13, 3, 2, '2026-06-08 23:49:19', '2026-06-08 23:49:19'),
(14, 3, 3, '2026-06-08 23:49:19', '2026-06-08 23:49:19'),
(15, 4, 1, '2026-06-08 23:49:19', '2026-06-08 23:49:19'),
(16, 4, 2, '2026-06-08 23:49:19', '2026-06-08 23:49:19'),
(17, 4, 3, '2026-06-08 23:49:19', '2026-06-08 23:49:19'),
(18, 5, 1, '2026-06-08 23:49:19', '2026-06-08 23:49:19'),
(19, 5, 2, '2026-06-08 23:49:19', '2026-06-08 23:49:19'),
(20, 5, 3, '2026-06-08 23:49:19', '2026-06-08 23:49:19');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `platform_settings`
--

CREATE TABLE `platform_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `procurement_directors`
--

CREATE TABLE `procurement_directors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `procurement_profile_id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `initials` varchar(20) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `marital_status` varchar(50) DEFAULT NULL,
  `privacy_status` varchar(100) DEFAULT NULL,
  `cellular_number` varchar(30) DEFAULT NULL,
  `home_telephone` varchar(30) DEFAULT NULL,
  `work_telephone` varchar(30) DEFAULT NULL,
  `email_address` varchar(255) DEFAULT NULL,
  `residential_address` text DEFAULT NULL,
  `postal_address` text DEFAULT NULL,
  `employer` varchar(255) DEFAULT NULL,
  `number_of_enquiries` int(10) UNSIGNED DEFAULT NULL,
  `id_number` varchar(20) NOT NULL,
  `position` varchar(255) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `provider_reference` varchar(255) DEFAULT NULL,
  `director_status` varchar(100) DEFAULT NULL,
  `verification_summary` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`verification_summary`)),
  `director_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`director_data`)),
  `verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `procurement_directors`
--

INSERT INTO `procurement_directors` (`id`, `procurement_profile_id`, `full_name`, `initials`, `birth_date`, `gender`, `title`, `marital_status`, `privacy_status`, `cellular_number`, `home_telephone`, `work_telephone`, `email_address`, `residential_address`, `postal_address`, `employer`, `number_of_enquiries`, `id_number`, `position`, `status`, `provider_reference`, `director_status`, `verification_summary`, `director_data`, `verified_at`, `created_at`, `updated_at`) VALUES
(1, 2, 'GABRIEL OFENTSE RABOTLHALE', 'GO', '1988-12-20', 'Male', 'Mister', 'Married', 'ACCEPTS CONTACTS', '0725902289', '0145532042', '0110512800', 'GABRIEL.OFT@GMAIL.COM', '8907 BELARUS STREET SONNEDAL RANDBURG 7742', '26 BELARUS ST COSMO CITY 2188', 'FGX STUDIOS', 3, '8812205697089', NULL, 'verified', '791e0bfb-3d43-4548-82c9-764bb4a5e5d7', 'Success', '{\"request_id\":\"791e0bfb-3d43-4548-82c9-764bb4a5e5d7\",\"success\":true,\"mode\":\"production\",\"transaction_id\":null,\"status\":null,\"director_name\":\"GABRIEL OFENTSE RABOTLHALE\",\"id_number\":\"8812205697089\",\"position\":null,\"initials\":\"GO\",\"birth_date\":\"1988-12-20\",\"gender\":\"Male\",\"title\":\"Mister\",\"marital_status\":\"Married\",\"privacy_status\":\"ACCEPTS CONTACTS\",\"cellular_number\":\"0725902289\",\"home_telephone\":\"0145532042\",\"work_telephone\":\"0110512800\",\"email_address\":\"GABRIEL.OFT@GMAIL.COM\",\"residential_address\":\"8907 BELARUS STREET SONNEDAL RANDBURG 7742\",\"postal_address\":\"26 BELARUS ST COSMO CITY 2188\",\"employer\":\"FGX STUDIOS\",\"number_of_enquiries\":\"3\",\"companies_count\":null}', '{\"success\":true,\"response_timestamp\":\"2026-06-09T07:36:38.548Z\",\"requestId\":\"791e0bfb-3d43-4548-82c9-764bb4a5e5d7\",\"user_id\":\"8662\",\"remaining_credits\":206,\"mode\":\"production\",\"service\":\"cipc_director_search\",\"input\":{\"reportType\":\"cipc_director_search\",\"idNumber\":\"8812205697089\",\"mode\":\"production\"},\"results\":{\"success\":true,\"id_number\":\"8812205697089\",\"full_name\":\"GABRIEL OFENTSE RABOTLHALE\",\"initials\":\"GO\",\"birth_date\":\"1988-12-20\",\"gender\":\"Male\",\"title\":\"Mister\",\"marital_status\":\"Married\",\"privacy_status\":\"ACCEPTS CONTACTS\",\"cellular_number\":\"0725902289\",\"home_telephone\":\"0145532042\",\"work_telephone\":\"0110512800\",\"email_address\":\"GABRIEL.OFT@GMAIL.COM\",\"residential_address\":\"8907 BELARUS STREET SONNEDAL RANDBURG 7742\",\"postal_address\":\"26 BELARUS ST COSMO CITY 2188\",\"employer\":\"FGX STUDIOS\",\"number_of_enquiries\":\"3\",\"fraud_indicators\":{\"HomeAffairsVerificationYN\":\"Yes\",\"HomeAffairsDeceasedStatus\":\"No\",\"EmployerFraudVerificationYN\":\"\",\"ProtectiveVerificationYN\":\"No\",\"HomeAffairsDeceasedDate\":\"No\"},\"property_summary\":{\"TotalProperty\":\"1\",\"PurchasePrice\":\"700000.0000\"},\"director_summary\":{\"NumberOfCompanyDirector\":\"3\"},\"marital_enquiry\":{\"FirstName\":\"\",\"Surname\":\"\",\"IDNumber\":\"\",\"SpouseFirstName\":\"\",\"SpouseSurname\":\"\",\"SpouseIDNumber\":\"\"},\"enquiry_history\":[{\"EnquiryDate\":\"2025-10-14\",\"SubscriberName\":\"Hirodox (Pty) Ltd T\\/A i-Bureau Services\",\"SubscriberBusinessTypeDescription\":\"Other\",\"CreditGrantorEnquiryReasonDescription\":\"Affordability Assessment\",\"SubscriberContact\":\"010500 1060\"}],\"address_history\":[{\"FirstReportedDate\":\"2014-11-30\",\"LastUpdatedDate\":\"2026-05-04\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"8907 BELARUS STREET\",\"AddressLine2\":\"SONNEDAL\",\"AddressLine3\":\"RANDBURG\",\"AddressLine4\":\"\",\"PostalCode\":\"7742\",\"Address\":\"8907 BELARUS STREET SONNEDAL RANDBURG 7742\"},{\"FirstReportedDate\":\"2015-07-11\",\"LastUpdatedDate\":\"2023-09-10\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"26 BELARUS ST\",\"AddressLine2\":\"\",\"AddressLine3\":\"\",\"AddressLine4\":\"COSMO CITY\",\"PostalCode\":\"2188\",\"Address\":\"26 BELARUS ST COSMO CITY 2188\"},{\"FirstReportedDate\":\"2022-12-30\",\"LastUpdatedDate\":\"2023-03-10\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"\",\"AddressLine2\":\"8907  BELARUS STREET\",\"AddressLine3\":\"COSMO CITY\",\"AddressLine4\":\"ROODEPOORT\",\"PostalCode\":\"2087\",\"Address\":\"8907  BELARUS STREET COSMO CITY ROODEPOORT 2087\"},{\"FirstReportedDate\":\"2022-06-21\",\"LastUpdatedDate\":\"2022-08-04\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"8907 BELARUS STREET\",\"AddressLine2\":\"\",\"AddressLine3\":\"\",\"AddressLine4\":\"COSMO CITY\",\"PostalCode\":\"2188\",\"Address\":\"8907 BELARUS STREET COSMO CITY 2188\"},{\"FirstReportedDate\":\"2022-06-21\",\"LastUpdatedDate\":\"2022-08-04\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"8907 BELARUS STREET\",\"AddressLine2\":\"\",\"AddressLine3\":\"\",\"AddressLine4\":\"COSMO CITY\",\"PostalCode\":\"2188\",\"Address\":\"8907 BELARUS STREET COSMO CITY 2188\"},{\"FirstReportedDate\":\"2022-06-21\",\"LastUpdatedDate\":\"2022-06-22\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"8907 BELARUS STREET\",\"AddressLine2\":\"\",\"AddressLine3\":\"COSMO CITY\",\"AddressLine4\":\"COSMO CITY\",\"PostalCode\":\"2188\",\"Address\":\"8907 BELARUS STREET COSMO CITY COSMO CITY 2188\"},{\"FirstReportedDate\":\"2022-06-21\",\"LastUpdatedDate\":\"2022-06-22\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"8907 BELARUS STREET\",\"AddressLine2\":\"\",\"AddressLine3\":\"COSMO CITY\",\"AddressLine4\":\"COSMO CITY\",\"PostalCode\":\"2087\",\"Address\":\"8907 BELARUS STREET COSMO CITY COSMO CITY 2087\"},{\"FirstReportedDate\":\"2022-06-01\",\"LastUpdatedDate\":\"2022-06-01\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"8783 EMDENI AVENUE\",\"AddressLine2\":\"\",\"AddressLine3\":\"KAGISO\",\"AddressLine4\":\"KRUGERSDORP\",\"PostalCode\":\"1754\",\"Address\":\"8783 EMDENI AVENUE KAGISO KRUGERSDORP 1754\"},{\"FirstReportedDate\":\"2022-06-01\",\"LastUpdatedDate\":\"2022-06-01\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"COSMO CITY EXT 7 KAGISO\",\"AddressLine2\":\"8907 BELARUS STREET\",\"AddressLine3\":\"KAGISO 1 EXT 8\",\"AddressLine4\":\"KRUGERSDORP\",\"PostalCode\":\"1754\",\"Address\":\"COSMO CITY EXT 7 KAGISO 8907 BELARUS STREET KAGISO 1 EXT 8 KRUGERSDORP 1754\"},{\"FirstReportedDate\":\"2017-04-03\",\"LastUpdatedDate\":\"2021-06-05\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"COSMO CITY EXT 7 KAGISO\",\"AddressLine2\":\"8907 BELARUS STREET\",\"AddressLine3\":\"KAGISO 1 EXT 8\",\"AddressLine4\":\"KRUGERSDORP\",\"PostalCode\":\"\",\"Address\":\"COSMO CITY EXT 7 KAGISO 8907 BELARUS STREET KAGISO 1 EXT 8 KRUGERSDORP\"},{\"FirstReportedDate\":\"2017-04-03\",\"LastUpdatedDate\":\"2020-11-07\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"COSMO CITY EXT 7 KAGISO\",\"AddressLine2\":\"8907 BELARUS STREET\",\"AddressLine3\":\"KAGISO 1 EXT 8\",\"AddressLine4\":\"KRUGERSDORP\",\"PostalCode\":\"001754\",\"Address\":\"COSMO CITY EXT 7 KAGISO 8907 BELARUS STREET KAGISO 1 EXT 8 KRUGERSDORP 001754\"},{\"FirstReportedDate\":\"2017-04-03\",\"LastUpdatedDate\":\"2020-11-07\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"8783 EMDENI AVENUE\",\"AddressLine2\":\"KAGISO\",\"AddressLine3\":\"KAGISO\",\"AddressLine4\":\"KRUGERSDORP\",\"PostalCode\":\"001754\",\"Address\":\"8783 EMDENI AVENUE KAGISO KAGISO KRUGERSDORP 001754\"},{\"FirstReportedDate\":\"2020-10-08\",\"LastUpdatedDate\":\"2020-10-08\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"COSMO CITY EXT 7 KAGISO\",\"AddressLine2\":\"8907 BELARUS STREET\",\"AddressLine3\":\"KAGISO 1 EXT 8\",\"AddressLine4\":\"KRUGERSDORP\",\"PostalCode\":\"001754\",\"Address\":\"COSMO CITY EXT 7 KAGISO 8907 BELARUS STREET KAGISO 1 EXT 8 KRUGERSDORP 001754\"},{\"FirstReportedDate\":\"2020-10-08\",\"LastUpdatedDate\":\"2020-10-08\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"8783 EMDENI AVENUE\",\"AddressLine2\":\"KAGISO\",\"AddressLine3\":\"KRUGERSDORP\",\"AddressLine4\":\"KRUGERSDORP\",\"PostalCode\":\"001754\",\"Address\":\"8783 EMDENI AVENUE KAGISO KRUGERSDORP KRUGERSDORP 001754\"},{\"FirstReportedDate\":\"2015-07-11\",\"LastUpdatedDate\":\"2020-08-09\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"26 BELARUS STREET\",\"AddressLine2\":\"\",\"AddressLine3\":\"\",\"AddressLine4\":\"COSMO CITY\",\"PostalCode\":\"2188\",\"Address\":\"26 BELARUS STREET COSMO CITY 2188\"},{\"FirstReportedDate\":\"2017-04-03\",\"LastUpdatedDate\":\"2020-06-07\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"PO BOX 220\",\"AddressLine2\":\"MADIKWE\",\"AddressLine3\":\"NOT APPLICABLE\",\"AddressLine4\":\"NOT APPLICABLE\",\"PostalCode\":\"002840\",\"Address\":\"PO BOX 220 MADIKWE NOT APPLICABLE NOT APPLICABLE 002840\"},{\"FirstReportedDate\":\"2017-04-03\",\"LastUpdatedDate\":\"2020-05-14\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"8783 EMDENI AVENUE\",\"AddressLine2\":\"KAGISO\",\"AddressLine3\":\"KRUGERSDORP\",\"AddressLine4\":\"KRUGERSDORP\",\"PostalCode\":\"002840\",\"Address\":\"8783 EMDENI AVENUE KAGISO KRUGERSDORP KRUGERSDORP 002840\"},{\"FirstReportedDate\":\"2020-05-14\",\"LastUpdatedDate\":\"2020-05-14\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"PO BOX 220\",\"AddressLine2\":\"MADIKWE\",\"AddressLine3\":\"MADIKWE\",\"AddressLine4\":\"MADIKWE\",\"PostalCode\":\"002840\",\"Address\":\"PO BOX 220 MADIKWE MADIKWE MADIKWE 002840\"},{\"FirstReportedDate\":\"2019-05-27\",\"LastUpdatedDate\":\"2020-03-10\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"8907 BELARUS ST\",\"AddressLine2\":\"\",\"AddressLine3\":\"COSMO CITY EXT 7\",\"AddressLine4\":\"\",\"PostalCode\":\"2188\",\"Address\":\"8907 BELARUS ST COSMO CITY EXT 7 2188\"},{\"FirstReportedDate\":\"2019-05-27\",\"LastUpdatedDate\":\"2020-03-10\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"8907 BELARUS ST\",\"AddressLine2\":\"\",\"AddressLine3\":\"COSMO CITY EXT 7\",\"AddressLine4\":\"\",\"PostalCode\":\"2188\",\"Address\":\"8907 BELARUS ST COSMO CITY EXT 7 2188\"},{\"FirstReportedDate\":\"2019-05-27\",\"LastUpdatedDate\":\"2019-05-31\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"SEQOBILE\",\"AddressLine2\":\"226 PEOLWANE ST\",\"AddressLine3\":\"MADIKWE\",\"AddressLine4\":\"\",\"PostalCode\":\"2840\",\"Address\":\"SEQOBILE 226 PEOLWANE ST MADIKWE 2840\"},{\"FirstReportedDate\":\"2019-05-27\",\"LastUpdatedDate\":\"2019-05-31\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"SEQOBILE\",\"AddressLine2\":\"511 MOKGOFE STREET\",\"AddressLine3\":\"KAGISO 1\",\"AddressLine4\":\"\",\"PostalCode\":\"1754\",\"Address\":\"SEQOBILE 511 MOKGOFE STREET KAGISO 1 1754\"},{\"FirstReportedDate\":\"2015-07-11\",\"LastUpdatedDate\":\"2019-02-12\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"226 POELWANE ST\",\"AddressLine2\":\"\",\"AddressLine3\":\"\",\"AddressLine4\":\"MADIKWE\",\"PostalCode\":\"2840\",\"Address\":\"226 POELWANE ST MADIKWE 2840\"},{\"FirstReportedDate\":\"2015-07-11\",\"LastUpdatedDate\":\"2019-02-12\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"226 PEOLWANE STREET\",\"AddressLine2\":\"\",\"AddressLine3\":\"\",\"AddressLine4\":\"MADIKWE\",\"PostalCode\":\"2840\",\"Address\":\"226 PEOLWANE STREET MADIKWE 2840\"},{\"FirstReportedDate\":\"2014-11-30\",\"LastUpdatedDate\":\"2017-06-05\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"MADIKWE\",\"AddressLine2\":\"BAKWENA BOO MODIMOSANA\",\"AddressLine3\":\"\",\"AddressLine4\":\"\",\"PostalCode\":\"1754\",\"Address\":\"MADIKWE BAKWENA BOO MODIMOSANA 1754\"},{\"FirstReportedDate\":\"2014-11-30\",\"LastUpdatedDate\":\"2017-05-03\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"8783 EMDENI AVENUE\",\"AddressLine2\":\"MADIKWE\",\"AddressLine3\":\"BAKWENA BOO MODIMOSANA\",\"AddressLine4\":\"\",\"PostalCode\":\"2846\",\"Address\":\"8783 EMDENI AVENUE MADIKWE BAKWENA BOO MODIMOSANA 2846\"},{\"FirstReportedDate\":\"2017-05-03\",\"LastUpdatedDate\":\"2017-05-03\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"8783 EMDENI AVENUE\",\"AddressLine2\":\"KAGISO EXT 4\",\"AddressLine3\":\"KAGISO\",\"AddressLine4\":\"\",\"PostalCode\":\"1754\",\"Address\":\"8783 EMDENI AVENUE KAGISO EXT 4 KAGISO 1754\"},{\"FirstReportedDate\":\"2017-04-04\",\"LastUpdatedDate\":\"2017-04-04\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"8783 EMDENI AVENUE\",\"AddressLine2\":\"KAGISO\",\"AddressLine3\":\"KRUGERSDORP\",\"AddressLine4\":\"\",\"PostalCode\":\"1754\",\"Address\":\"8783 EMDENI AVENUE KAGISO KRUGERSDORP 1754\"},{\"FirstReportedDate\":\"2017-04-03\",\"LastUpdatedDate\":\"2017-04-04\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"8783 EMDENI AVENUE\",\"AddressLine2\":\"KAGISO\",\"AddressLine3\":\"KRUGERSDORP\",\"AddressLine4\":\"\",\"PostalCode\":\"1754\",\"Address\":\"8783 EMDENI AVENUE KAGISO KRUGERSDORP 1754\"},{\"FirstReportedDate\":\"2017-03-22\",\"LastUpdatedDate\":\"2017-03-24\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"8783 EMNDENI\",\"AddressLine2\":\"KAGISO\",\"AddressLine3\":\"\",\"AddressLine4\":\"\",\"PostalCode\":\"1754\",\"Address\":\"8783 EMNDENI KAGISO 1754\"},{\"FirstReportedDate\":\"2016-02-15\",\"LastUpdatedDate\":\"2016-04-17\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"8783 EMNDENI EAST STREET\",\"AddressLine2\":\"KAGISO 1\",\"AddressLine3\":\"KAGISO\",\"AddressLine4\":\"\",\"PostalCode\":\"1754\",\"Address\":\"8783 EMNDENI EAST STREET KAGISO 1 KAGISO 1754\"},{\"FirstReportedDate\":\"2015-07-11\",\"LastUpdatedDate\":\"2015-08-27\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"226 POELWANE ST\",\"AddressLine2\":\"MADIKWE\",\"AddressLine3\":\"\",\"AddressLine4\":\"\",\"PostalCode\":\"2840\",\"Address\":\"226 POELWANE ST MADIKWE 2840\"},{\"FirstReportedDate\":\"2015-07-11\",\"LastUpdatedDate\":\"2015-08-27\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"226 PEOLWANE STREET\",\"AddressLine2\":\"MADIKWE\",\"AddressLine3\":\"\",\"AddressLine4\":\"\",\"PostalCode\":\"2840\",\"Address\":\"226 PEOLWANE STREET MADIKWE 2840\"},{\"FirstReportedDate\":\"2013-11-13\",\"LastUpdatedDate\":\"2015-04-15\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"5 MAIN\",\"AddressLine2\":\"VREDENBURG\",\"AddressLine3\":\"\",\"AddressLine4\":\"\",\"PostalCode\":\"\",\"Address\":\"5 MAIN VREDENBURG\"},{\"FirstReportedDate\":\"2014-11-28\",\"LastUpdatedDate\":\"2015-01-25\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"226 PEOLWANE STREET\",\"AddressLine2\":\"MADIKWE\",\"AddressLine3\":\"BAKWENA BOO MODIMOSANA\",\"AddressLine4\":\"\",\"PostalCode\":\"2846\",\"Address\":\"226 PEOLWANE STREET MADIKWE BAKWENA BOO MODIMOSANA 2846\"},{\"FirstReportedDate\":\"2014-11-28\",\"LastUpdatedDate\":\"2015-01-25\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"226 PEOLWANE STREET\",\"AddressLine2\":\"MADIKWE\",\"AddressLine3\":\"MADIKWE\",\"AddressLine4\":\"\",\"PostalCode\":\"2840\",\"Address\":\"226 PEOLWANE STREET MADIKWE MADIKWE 2840\"},{\"FirstReportedDate\":\"2014-08-25\",\"LastUpdatedDate\":\"2014-08-25\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"PEOLWANE STREET\",\"AddressLine2\":\"MADIKWE\",\"AddressLine3\":\"\",\"AddressLine4\":\"\",\"PostalCode\":\"2840\",\"Address\":\"PEOLWANE STREET MADIKWE 2840\"},{\"FirstReportedDate\":\"2013-11-13\",\"LastUpdatedDate\":\"2014-05-24\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"5 MAIN\",\"AddressLine2\":\"VREDENBURG\",\"AddressLine3\":\"WESTERN CAPE\",\"AddressLine4\":\"\",\"PostalCode\":\"7380\",\"Address\":\"5 MAIN VREDENBURG WESTERN CAPE 7380\"},{\"FirstReportedDate\":\"2014-04-08\",\"LastUpdatedDate\":\"2014-04-08\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"5 MAIN\",\"AddressLine2\":\"VREDENBURG\",\"AddressLine3\":\"\",\"AddressLine4\":\"\",\"PostalCode\":\"\",\"Address\":\"5 MAIN VREDENBURG\"},{\"FirstReportedDate\":\"2014-04-08\",\"LastUpdatedDate\":\"2014-04-08\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"MAIN 5\",\"AddressLine2\":\"VREDENBURG\",\"AddressLine3\":\"WESTERN CAPE\",\"AddressLine4\":\"\",\"PostalCode\":\"7380\",\"Address\":\"MAIN 5 VREDENBURG WESTERN CAPE 7380\"},{\"FirstReportedDate\":\"2013-11-08\",\"LastUpdatedDate\":\"2013-12-04\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"226\",\"AddressLine2\":\"PELWANE STREET\",\"AddressLine3\":\"MADIKWE\",\"AddressLine4\":\"\",\"PostalCode\":\"2840\",\"Address\":\"226 PELWANE STREET MADIKWE 2840\"},{\"FirstReportedDate\":\"2013-11-08\",\"LastUpdatedDate\":\"2013-12-04\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"PO BOX 220\",\"AddressLine2\":\"PELWANE STREET\",\"AddressLine3\":\"MADIKWE\",\"AddressLine4\":\"\",\"PostalCode\":\"2840\",\"Address\":\"PO BOX 220 PELWANE STREET MADIKWE 2840\"},{\"FirstReportedDate\":\"2014-07-01\",\"LastUpdatedDate\":\"2013-06-29\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"PO BOX\",\"AddressLine2\":\"MADIKWE\",\"AddressLine3\":\"\",\"AddressLine4\":\"\",\"PostalCode\":\"2840\",\"Address\":\"PO BOX MADIKWE 2840\"},{\"FirstReportedDate\":\"2011-08-08\",\"LastUpdatedDate\":\"2012-11-17\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"516 SINQOBILE\",\"AddressLine2\":\"516 MOKGOFE STREET\",\"AddressLine3\":\"AZAADVILLE\",\"AddressLine4\":\"\",\"PostalCode\":\"1754\",\"Address\":\"516 SINQOBILE 516 MOKGOFE STREET AZAADVILLE 1754\"},{\"FirstReportedDate\":\"2009-11-29\",\"LastUpdatedDate\":\"2012-03-13\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"226 POELWANE STREET\",\"AddressLine2\":\"MADIKWE\",\"AddressLine3\":\"\",\"AddressLine4\":\"\",\"PostalCode\":\"2840\",\"Address\":\"226 POELWANE STREET MADIKWE 2840\"},{\"FirstReportedDate\":\"2011-07-18\",\"LastUpdatedDate\":\"2011-10-06\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"811 MOKGOFE STREET\",\"AddressLine2\":\"KAGISOI\",\"AddressLine3\":\"KAGISO\",\"AddressLine4\":\"\",\"PostalCode\":\"1754\",\"Address\":\"811 MOKGOFE STREET KAGISOI KAGISO 1754\"},{\"FirstReportedDate\":\"2011-10-06\",\"LastUpdatedDate\":\"2011-10-06\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"BOX 220\",\"AddressLine2\":\"MADIKOG\",\"AddressLine3\":\"RUSTENBERG\",\"AddressLine4\":\"\",\"PostalCode\":\"2840\",\"Address\":\"BOX 220 MADIKOG RUSTENBERG 2840\"},{\"FirstReportedDate\":\"2011-08-08\",\"LastUpdatedDate\":\"2011-08-29\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"516 SINQOBILE\",\"AddressLine2\":\"516 MOKGOFE STR\",\"AddressLine3\":\"AZAADVILLE\",\"AddressLine4\":\"AZAADVILLE\",\"PostalCode\":\"1754\",\"Address\":\"516 SINQOBILE 516 MOKGOFE STR AZAADVILLE AZAADVILLE 1754\"},{\"FirstReportedDate\":\"2009-11-28\",\"LastUpdatedDate\":\"2009-11-28\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P         \",\"AddressLine1\":\"P O BOX 220\",\"AddressLine2\":\"MADIKWE\",\"AddressLine3\":\"\",\"AddressLine4\":\"\",\"PostalCode\":\"2840\",\"Address\":\"P O BOX 220, MADIKWE, 2840\"},{\"FirstReportedDate\":\"2009-08-30\",\"LastUpdatedDate\":\"2009-08-30\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P         \",\"AddressLine1\":\"P O BOX 220\",\"AddressLine2\":\"MADIKWE\",\"AddressLine3\":\"\",\"AddressLine4\":\"\",\"PostalCode\":\"2840\",\"Address\":\"P O BOX 220, MADIKWE, 2840\"},{\"FirstReportedDate\":\"2009-08-30\",\"LastUpdatedDate\":\"2009-08-30\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R         \",\"AddressLine1\":\"226 PEOLWANE STREET\",\"AddressLine2\":\"MADIKWE\",\"AddressLine3\":\"\",\"AddressLine4\":\"\",\"PostalCode\":\"2840\",\"Address\":\"226 PEOLWANE STREET, MADIKWE, 2840\"},{\"FirstReportedDate\":\"2011-07-18\",\"LastUpdatedDate\":\"2006-09-24\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"PO BOX 220\",\"AddressLine2\":\"MADIKWE\",\"AddressLine3\":\"\",\"AddressLine4\":\"\",\"PostalCode\":\"2840\",\"Address\":\"PO BOX 220 MADIKWE 2840\"}],\"telephone_history\":[{\"ConsumerTelephoneID\":\"640554866\",\"TelephoneType\":\"Cellular\",\"TelephoneTypeInd\":\"C\",\"TelCode\":\"062\",\"TelNumber\":\"2673410\",\"TelephoneNumber\":\"0622673410\",\"EmailAddress\":\"\",\"LastUpdatedDate\":\"2026-05-04\",\"FirstReportedDate\":\"2014-11-30\"},{\"ConsumerTelephoneID\":\"578051729\",\"TelephoneType\":\"Work\",\"TelephoneTypeInd\":\"W\",\"TelCode\":\"011\",\"TelNumber\":\"0512800\",\"TelephoneNumber\":\"0110512800\",\"EmailAddress\":\"\",\"LastUpdatedDate\":\"2022-06-22\",\"FirstReportedDate\":\"2022-06-21\"},{\"ConsumerTelephoneID\":\"526896722\",\"TelephoneType\":\"Work\",\"TelephoneTypeInd\":\"W\",\"TelCode\":\"011\",\"TelNumber\":\"0386844\",\"TelephoneNumber\":\"0110386844\",\"EmailAddress\":\"\",\"LastUpdatedDate\":\"2019-07-14\",\"FirstReportedDate\":\"2015-07-11\"},{\"ConsumerTelephoneID\":\"524034089\",\"TelephoneType\":\"Work\",\"TelephoneTypeInd\":\"W\",\"TelCode\":\"011\",\"TelNumber\":\"0157280\",\"TelephoneNumber\":\"0110157280\",\"EmailAddress\":\"\",\"LastUpdatedDate\":\"2019-05-31\",\"FirstReportedDate\":\"2019-05-27\"},{\"ConsumerTelephoneID\":\"463671124\",\"TelephoneType\":\"Home\",\"TelephoneTypeInd\":\"H\",\"TelCode\":\"014\",\"TelNumber\":\"5532042\",\"TelephoneNumber\":\"0145532042\",\"EmailAddress\":\"\",\"LastUpdatedDate\":\"2016-02-23\",\"FirstReportedDate\":\"2011-07-18\"},{\"ConsumerTelephoneID\":\"463669126\",\"TelephoneType\":\"Work\",\"TelephoneTypeInd\":\"W\",\"TelCode\":\"083\",\"TelNumber\":\"3801266\",\"TelephoneNumber\":\"0833801266\",\"EmailAddress\":\"\",\"LastUpdatedDate\":\"2016-02-23\",\"FirstReportedDate\":\"2011-07-18\"},{\"ConsumerTelephoneID\":\"463668881\",\"TelephoneType\":\"Cellular\",\"TelephoneTypeInd\":\"C\",\"TelCode\":\"072\",\"TelNumber\":\"5902289\",\"TelephoneNumber\":\"0725902289\",\"EmailAddress\":\"\",\"LastUpdatedDate\":\"2016-02-23\",\"FirstReportedDate\":\"2011-07-18\"},{\"ConsumerTelephoneID\":\"437759798\",\"TelephoneType\":\"Work\",\"TelephoneTypeInd\":\"W\",\"TelCode\":\"083\",\"TelNumber\":\"3801266\",\"TelephoneNumber\":\"0833801266\",\"EmailAddress\":\"\",\"LastUpdatedDate\":\"2015-01-29\",\"FirstReportedDate\":\"2011-07-18\"},{\"ConsumerTelephoneID\":\"414244725\",\"TelephoneType\":\"Work\",\"TelephoneTypeInd\":\"W\",\"TelCode\":\"011\",\"TelNumber\":\"4674779\",\"TelephoneNumber\":\"0114674779\",\"EmailAddress\":\"\",\"LastUpdatedDate\":\"2013-06-29\",\"FirstReportedDate\":\"2012-06-30\"},{\"ConsumerTelephoneID\":\"398865041\",\"TelephoneType\":\"Cellular\",\"TelephoneTypeInd\":\"C\",\"TelCode\":\"083\",\"TelNumber\":\"3801266\",\"TelephoneNumber\":\"0833801266\",\"EmailAddress\":\"\",\"LastUpdatedDate\":\"2012-04-14\",\"FirstReportedDate\":\"2009-11-29\"},{\"ConsumerTelephoneID\":\"376988764\",\"TelephoneType\":\"Work\",\"TelephoneTypeInd\":\"W\",\"TelCode\":\"014\",\"TelNumber\":\"5532042\",\"TelephoneNumber\":\"0145532042\",\"EmailAddress\":\"\",\"LastUpdatedDate\":\"2011-09-21\",\"FirstReportedDate\":\"2011-09-21\"},{\"ConsumerTelephoneID\":\"373327871\",\"TelephoneType\":\"Home\",\"TelephoneTypeInd\":\"H\",\"TelCode\":\"014\",\"TelNumber\":\"5532042\",\"TelephoneNumber\":\"0145532042\",\"EmailAddress\":\"\",\"LastUpdatedDate\":\"2011-09-15\",\"FirstReportedDate\":\"2009-11-29\"},{\"ConsumerTelephoneID\":\"212384489\",\"TelephoneType\":\"Cellular\",\"TelephoneTypeInd\":\"C\",\"TelCode\":\"072\",\"TelNumber\":\"5902289\",\"TelephoneNumber\":\"0725902289\",\"EmailAddress\":\"\",\"LastUpdatedDate\":\"2009-11-25\",\"FirstReportedDate\":\"2009-10-22\"}],\"employment_history\":[{\"EmployerDetail\":\"FGX STUDIOS\",\"Designation\":\"\",\"LastUpdatedDate\":\"2019-08-07\",\"FirstReportedDate\":\"2019-05-27\"},{\"EmployerDetail\":\"WALLSTREET INTERACTIVE PTY LTD\",\"Designation\":\"\",\"LastUpdatedDate\":\"2012-11-20\",\"FirstReportedDate\":\"2012-06-30\"},{\"EmployerDetail\":\"MRABOTLHAEROOF\",\"Designation\":\"\",\"LastUpdatedDate\":\"2011-10-06\",\"FirstReportedDate\":\"2011-07-18\"},{\"EmployerDetail\":\"ZACHARIA RABOTLHARE\",\"Designation\":\"\",\"LastUpdatedDate\":\"2010-04-28\",\"FirstReportedDate\":\"2009-11-29\"}],\"director_enquiry_history\":[{\"EnquiryDate\":\"2026-05-27\",\"SubscriberName\":\"DataNamix - Web service\",\"SubscriberBusinessTypeDescription\":\"Other\",\"SubscriberContact\":\"\"},{\"EnquiryDate\":\"2026-06-06\",\"SubscriberName\":\"DataNamix - Web service\",\"SubscriberBusinessTypeDescription\":\"Other\",\"SubscriberContact\":\"\"}],\"property_information\":[{\"AuthorityName\":\"CITY OF JOHANNESBURG\",\"TownshipName\":\"\",\"StandNumber\":\"\",\"PortionNumber\":\"\",\"FarmName\":\"\",\"SchemeName\":\"\",\"TitleDeedNumber\":\"T16441\\/2019\",\"BuyerName\":\"RABOTLHALE GABRIEL OFENTSE\",\"BuyerTypeCode\":\"1\",\"BuyerIDNumber\":\"8812205697089\",\"BuyerMaritalStatusCode\":\"MARRIED IN\",\"SellerName\":\"MOKOTO KENEILWE\",\"SellerTypeCode\":\"1\",\"SellerIDNumber\":\"8206160932088\",\"SellerMaritalStatusCode\":\"UNMARRIED\",\"TransferDate\":\"2019-05-27\",\"RegistrarName\":\"JOHANNESBURG\",\"OldTitleDeedNumber\":\"T38946\\/2012\",\"AttorneyFirmNumber\":\"\",\"AttorneyFileNumber\":\"\",\"TitleDeedFeeAmount\":\"0.0000\",\"PropertyTypeCode\":\"E\",\"StreetNumber\":\"26\",\"StreetName\":\"BELARUS\",\"SuburbName\":\"\",\"CityName\":\"COSMO CITY EXT 7\",\"TransferID\":\"0\",\"ErfNumber\":\"8907\",\"DeedsOffice\":\"JOHANNESBURG\",\"PropertyTypeDescription\":\"Full Title - Erf - Land Parcel\",\"ErfSize\":\"280.0SQM\",\"PurchaseDate\":\"2019-03-13\",\"PurchasePriceAmount\":\"700000.0000\",\"BuyerSharePercentage\":\"0.0000\",\"BondAccountNumber\":\"B119712019\",\"BondAmount\":\"700000.0000\",\"BondHolderName\":\"S B GUARANTEE CO RF PTY LTD\",\"PhysicalAddress\":\"26 BELARUS  COSMO CITY EXT 7\"}],\"directorships\":[{\"CommercialName\":\"SA GLOBAL ZA\",\"RegistrationNumber\":\"K2014\\/161043\\/07\",\"AppointmentDate\":\"2014-08-05\",\"DirectorStatus\":\"Active\",\"DirectorDesignationDescription\":\"\",\"CommercialStatus\":\"AR Deregistration Process\",\"SICDescription\":\"Unknown Data\",\"PhysicalAddress\":\"8907 BELARUS STREET, COSMO CITY EXT7, COSMO CITY EXT7, GAUTENG, 2188\",\"PostalAddress\":\"8907 BELARUS STREET, COSMO CITY EXT7, COSMO CITY EXT7, GAUTENG, 2188\",\"TelephoneNumber\":\"\"},{\"CommercialName\":\"RAB COLLECTIVE\",\"RegistrationNumber\":\"K2016\\/353602\\/07\",\"AppointmentDate\":\"2016-08-17\",\"DirectorStatus\":\"Active\",\"DirectorDesignationDescription\":\"\",\"CommercialStatus\":\"AR Deregistration Process\",\"SICDescription\":\"Unknown Data\",\"PhysicalAddress\":\"8907 BELARUS STREET, COSMO CITY EXT7, COSMO CITY EXT7, GAUTENG, 2188\",\"PostalAddress\":\"8907 BELARUS STREET, COSMO CITY EXT7, COSMO CITY EXT7, GAUTENG, 2188\",\"TelephoneNumber\":\"\"},{\"CommercialName\":\"CENTREDOPS\",\"RegistrationNumber\":\"K2019\\/016019\\/07\",\"AppointmentDate\":\"2019-01-25\",\"DirectorStatus\":\"Active\",\"DirectorDesignationDescription\":\"\",\"CommercialStatus\":\"In Business\",\"SICDescription\":\"Unknown Data\",\"PhysicalAddress\":\"8907 BELARUS STREET, COSMO CITY EXT7, COSMO CITY EXT7, GAUTENG, 2188\",\"PostalAddress\":\"8907 BELARUS STREET, COSMO CITY EXT7, COSMO CITY EXT7, GAUTENG, 2188\",\"TelephoneNumber\":\"\"}],\"total_directorships\":3}}', '2026-06-09 06:08:48', '2026-06-09 05:36:16', '2026-06-09 06:08:48');

-- --------------------------------------------------------

--
-- Table structure for table `procurement_profiles`
--

CREATE TABLE `procurement_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `registration_number` varchar(50) DEFAULT NULL,
  `vat_number` varchar(30) DEFAULT NULL,
  `company_phone` varchar(20) DEFAULT NULL,
  `enterprise_status` varchar(100) DEFAULT NULL,
  `enterprise_type` varchar(100) DEFAULT NULL,
  `enterprise_address` text DEFAULT NULL,
  `enterprise_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`enterprise_data`)),
  `enterprise_synced_at` timestamp NULL DEFAULT NULL,
  `verification_progress` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `procurement_profiles`
--

INSERT INTO `procurement_profiles` (`id`, `user_id`, `company_name`, `registration_number`, `vat_number`, `company_phone`, `enterprise_status`, `enterprise_type`, `enterprise_address`, `enterprise_data`, `enterprise_synced_at`, `verification_progress`, `created_at`, `updated_at`) VALUES
(1, 4, 'Akhani Procurement Services', '201408196207', '4123456789', '0315550101', NULL, NULL, NULL, NULL, NULL, 29, '2026-06-08 23:49:19', '2026-06-09 01:29:40'),
(2, 6, 'BLACK APPLE INVESTMENTS (PTY)LTD', 'K2014/081962/07', '4200309682', '', 'In Business', 'Private Company', NULL, '{\"success\":true,\"company_name\":\"BLACK APPLE INVESTMENTS (PTY)LTD\",\"trade_name\":\"\",\"previous_name\":\"\",\"registration_number\":\"K2014\\/081962\\/07\",\"registration_date\":\"2014-04-24\",\"business_start_date\":\"2014-04-24\",\"status\":\"In Business\",\"company_type\":\"Private Company\",\"sic\":\"0 - Unknown Data\",\"tax_number\":\"9810918152\",\"vat_number\":\"4200309682\",\"business_description\":\"No Information Available\",\"telephone\":\"\",\"email\":\"\",\"website\":\"\",\"age_of_business\":\"12 Years 2 Months\",\"financial_year_end\":\"February\",\"director_count\":\"1\",\"number_of_enquiries\":\"3\",\"authorised_capital\":\"0.0000\",\"issued_capital\":\"0.0000\",\"physical_address\":\"62, KERK STREET, BELFAST, MPUMALANGA, 1100\",\"postal_address\":\"62, KERK STREET, BELFAST, MPUMALANGA, 1100\",\"directors\":[{\"FullName\":\"BONGANI NTOKOZO MBONANI\",\"FirstName\":\"BONGANI NTOKOZO\",\"Surname\":\"MBONANI\",\"IDNumber\":\"8905155324082\",\"AppointmentDate\":\"2014-04-24\",\"DirectorStatus\":\"Active\",\"DirectorStatusDate\":\"\",\"PhysicalAddress\":\"THE BLYDE CRYSTAL LAGOON WILLIOW MA, PRETORIA, PRETORIA, GAUTENG, 0054\"}],\"active_principals\":[{\"FullName\":\"BONGANI NTOKOZO MBONANI\",\"IDNumber\":\"8905155324082\",\"CellularNumber\":\"0827424014\",\"HomeTelephone\":\"\",\"WorkTelephone\":\"0573524076\",\"EmailAddress\":\"\",\"PhysicalAddress\":\"BRONKHOSTSPRUIT ROAD WILLOW MANOR THE BLYDE CRYSTAL LAGOON GAUTENG 0084\",\"PostalAddress\":\"UNIT 1422 THE BLYDE CRYSTAL LAGOON GAUTENG 0084\"}],\"address_history\":[{\"AddressType\":\"Physical\",\"Address\":\"62, KERK STREET, BELFAST, MPUMALANGA\",\"PostalCode\":\"1100\",\"LastUpdatedDate\":\"2014-12-05\"},{\"AddressType\":\"Postal\",\"Address\":\"62, KERK STREET, BELFAST, MPUMALANGA\",\"PostalCode\":\"1100\",\"LastUpdatedDate\":\"2014-12-05\"}],\"change_history\":[{\"EffectiveDate\":\"2024\\/10\\/23\",\"ChangeType\":\"CO\\/CC Annual Return\",\"Details\":\"Company \\/ Close Corporation AR Filing - Web Services : Ref No. : 5419195603\"},{\"EffectiveDate\":\"2023\\/05\\/19\",\"ChangeType\":\"AR Restore Into Business (25-24)\",\"Details\":\"Company \\/ Close Corporation AR Filing - Web Services : Ref No. : 5387177909\"},{\"EffectiveDate\":\"2023\\/04\\/26\",\"ChangeType\":\"AR IN Deregistration\",\"Details\":\"Annual Return Non Compliance - In Process of Deregistration Last Payment for AR Year\\/Month is 2020\\/4. \"},{\"EffectiveDate\":\"2020\\/06\\/11\",\"ChangeType\":\"AR Restore Into Business (25-24)\",\"Details\":\"Company \\/ Close Corporation AR Filing - Web Services : Ref No. : 5267176186\"},{\"EffectiveDate\":\"2019\\/07\\/29\",\"ChangeType\":\"AR IN Deregistration\",\"Details\":\"Annual Return Non Compliance - In Process of Deregistration Last Payment for AR Year\\/Month is 2017\\/4. \"},{\"EffectiveDate\":\"2017\\/05\\/11\",\"ChangeType\":\"AR Restore Into Business (25-24)\",\"Details\":\"Company \\/ Close Corporation AR Filing - Web Services : Ref No. : 571406975\"},{\"EffectiveDate\":\"2016\\/07\\/16\",\"ChangeType\":\"AR IN Deregistration\",\"Details\":\"Annual Return Non Compliance - In Process of Deregistration No Payment have been made.\"}],\"auditors\":[]}', '2026-06-09 06:29:04', 100, '2026-06-09 04:29:06', '2026-06-09 07:00:08');

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `id_number` varchar(20) DEFAULT NULL,
  `passport_number` varchar(30) DEFAULT NULL,
  `phone_secondary` varchar(20) DEFAULT NULL,
  `avatar_path` varchar(255) DEFAULT NULL,
  `address_line_1` varchar(255) DEFAULT NULL,
  `address_line_2` varchar(255) DEFAULT NULL,
  `suburb` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `postal_code` varchar(10) DEFAULT NULL,
  `country` varchar(2) NOT NULL DEFAULT 'ZA',
  `identity_verified` tinyint(1) NOT NULL DEFAULT 0,
  `identity_verified_at` timestamp NULL DEFAULT NULL,
  `profile_completed` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `user_id`, `date_of_birth`, `gender`, `id_number`, `passport_number`, `phone_secondary`, `avatar_path`, `address_line_1`, `address_line_2`, `suburb`, `city`, `province`, `postal_code`, `country`, `identity_verified`, `identity_verified_at`, `profile_completed`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 'Female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Johannesburg', 'Gauteng', NULL, 'ZA', 1, '2026-06-08 23:49:19', 1, '2026-06-08 23:49:19', '2026-06-08 23:49:19'),
(2, 2, NULL, 'Male', '8905155324082', NULL, NULL, NULL, NULL, NULL, NULL, 'Pretoria', 'Gauteng', NULL, 'ZA', 1, '2026-06-09 04:52:23', 1, '2026-06-08 23:49:19', '2026-06-09 04:52:23'),
(3, 3, NULL, 'Female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Cape Town', 'Western Cape', NULL, 'ZA', 1, '2026-06-08 23:49:19', 1, '2026-06-08 23:49:19', '2026-06-08 23:49:19'),
(4, 4, NULL, 'Female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Durban', 'KwaZulu-Natal', NULL, 'ZA', 1, '2026-06-08 23:49:19', 1, '2026-06-08 23:49:19', '2026-06-08 23:49:19'),
(5, 5, NULL, 'Female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Bloemfontein', 'Free State', NULL, 'ZA', 1, '2026-06-08 23:49:19', 1, '2026-06-08 23:49:19', '2026-06-08 23:49:19'),
(6, 6, '2026-06-10', 'Male', '8812205697089', NULL, NULL, NULL, '8907 Belarus Street', 'Cosmo  City', 'Cosmo  City', 'Randburg', 'Gauteng', '2108', 'ZA', 1, '2026-06-09 04:50:25', 1, '2026-06-09 04:29:06', '2026-06-09 04:57:22');

-- --------------------------------------------------------

--
-- Table structure for table `recruitment_profiles`
--

CREATE TABLE `recruitment_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `registration_number` varchar(50) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `company_phone` varchar(20) DEFAULT NULL,
  `contact_person_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `recruitment_profiles`
--

INSERT INTO `recruitment_profiles` (`id`, `user_id`, `company_name`, `registration_number`, `website`, `company_phone`, `contact_person_name`, `created_at`, `updated_at`) VALUES
(1, 3, 'Akhani Talent', '2026/000001/07', 'https://akhaniconnect.co.za', '0215550101', 'Refilwe Naidoo', '2026-06-08 23:49:19', '2026-06-08 23:49:19');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Superadmin', 'superadmin', 'Platform owner with full administrative access.', '2026-06-08 23:49:19', '2026-06-08 23:49:19'),
(2, 'Candidate', 'candidate', 'Candidate account for job applications and profile management.', '2026-06-08 23:49:19', '2026-06-08 23:49:19'),
(3, 'Recruitment', 'recruitment', 'Recruitment account for managing candidates and recruitment workflows.', '2026-06-08 23:49:19', '2026-06-08 23:49:19'),
(4, 'Procurement', 'procurement', 'Procurement account for verification and enterprise workflows.', '2026-06-08 23:49:19', '2026-06-08 23:49:19'),
(5, 'Client', 'client', 'Client account with controlled access to procurement records.', '2026-06-08 23:49:19', '2026-06-08 23:49:19');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `phone_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'active',
  `last_login_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `first_name`, `surname`, `email`, `phone`, `email_verified_at`, `phone_verified_at`, `password`, `status`, `last_login_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, 'Aisha', 'Nkosi', 'admin@akhaniconnect.co.za', '0820000001', '2026-06-08 23:49:19', '2026-06-08 23:49:19', '$2y$12$nB125O4WbGnS7ADl/LEmGO5NtcMF7Y/6NBla6Ieiw19x5Ua584sPC', 'active', '2026-06-09 01:13:35', NULL, '2026-06-08 23:49:19', '2026-06-09 01:13:35'),
(2, 2, 'Themba', 'Mokoena', 'candidate@akhaniconnect.co.za', '0820000002', '2026-06-08 23:49:19', '2026-06-08 23:49:19', '$2y$12$LDvzIa6Jdl4GLxFiSKb9kO/YkuFbLgUI9EPd6z3SvKSakR2t9ZAmy', 'active', '2026-06-09 04:51:26', NULL, '2026-06-08 23:49:19', '2026-06-09 04:51:26'),
(3, 3, 'Refilwe', 'Naidoo', 'recruitment@akhaniconnect.co.za', '0820000003', '2026-06-08 23:49:19', '2026-06-08 23:49:19', '$2y$12$OBXGRVD32EPUZwpXLSf6yOTIs7OIcwxE8fM7pZnQQqhQ17tAEN3eG', 'active', '2026-06-09 02:42:23', NULL, '2026-06-08 23:49:19', '2026-06-09 02:42:23'),
(4, 4, 'Lerato', 'Mabena', 'procurement@akhaniconnect.co.za', '0820000004', '2026-06-08 23:49:19', '2026-06-08 23:49:19', '$2y$12$CF/G7L2bYp5wBsrb44.EXuiCRyaJUaAPlkpiaOIxmdE1H.xcDGGIG', 'active', '2026-06-09 02:45:41', NULL, '2026-06-08 23:49:19', '2026-06-09 02:45:41'),
(5, 5, 'Nandi', 'Dlamini', 'client@akhaniconnect.co.za', '0820000005', '2026-06-08 23:49:19', '2026-06-08 23:49:19', '$2y$12$LEkd/kB5Kenivi1SEdaS8OZJItdmJVx3UhxAk7qFmKWPf4ESkj882', 'active', NULL, NULL, '2026-06-08 23:49:19', '2026-06-08 23:49:19'),
(6, 4, 'Gabriel', 'Rabotlhale', 'connect@gabrielo.co.za', '0725902289', NULL, NULL, '$2y$12$STAb5FVTo/EY3NdPGidnZ.mghpxVePE8PkgWUPZnPP2vvDxAvL9Ne', 'active', '2026-06-09 04:56:12', NULL, '2026-06-09 04:29:06', '2026-06-09 04:56:12');

-- --------------------------------------------------------

--
-- Table structure for table `verification_attempts`
--

CREATE TABLE `verification_attempts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `verification_record_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `provider_reference` varchar(255) DEFAULT NULL,
  `request_payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`request_payload`)),
  `raw_response` longtext DEFAULT NULL,
  `processed_response` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`processed_response`)),
  `error_message` text DEFAULT NULL,
  `attempted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `verification_attempts`
--

INSERT INTO `verification_attempts` (`id`, `verification_record_id`, `status`, `provider_reference`, `request_payload`, `raw_response`, `processed_response`, `error_message`, `attempted_at`, `created_at`, `updated_at`) VALUES
(1, 3, 'failed', NULL, '{\"registration_number\":\"201408196207\",\"reportType\":\"cipc_company_match\",\"mode\":\"production\"}', '{\"success\":false,\"error\":\"Processing failed\",\"message\":\"Failed to query CIPC endpoint. Please try again later.\"}', '{\"success\":false,\"error\":\"Processing failed\",\"message\":\"Failed to query CIPC endpoint. Please try again later.\"}', 'Processing failed', '2026-06-09 01:29:40', '2026-06-09 01:29:40', '2026-06-09 01:29:40'),
(2, 4, 'verified', '17180e4f-977b-41b3-8ee9-717ae47a0b76', '{\"id_number\":\"8812205697089\",\"reportType\":\"said_verification\",\"mode\":\"production\"}', '{\"success\":true,\"requestId\":\"17180e4f-977b-41b3-8ee9-717ae47a0b76\",\"user_id\":\"8662\",\"remainingCredits\":238,\"mode\":\"production\",\"reportType\":\"said_verification\",\"input\":{\"idNumber\":\"8812205697089\"},\"results\":{\"said_verification\":{\"Status\":\"Success\",\"realTimeResults\":{\"Status\":\"ID Number Valid\",\"Verification\":{\"Firstnames\":\"GABRIEL OFENTSE\",\"Lastname\":\"RABOTLHALE\",\"Dob\":\"1988-12-20\",\"Age\":37,\"Gender\":\"Male\",\"Citizenship\":\"South African\",\"DateIssued\":\"\"},\"transaction_id\":\"19162901\"},\"transaction_id\":\"19162901\",\"meta\":{\"environment\":\"production\",\"timestamp\":\"2026-06-09T06:29:23.089Z\"}}}}', '{\"success\":true,\"requestId\":\"17180e4f-977b-41b3-8ee9-717ae47a0b76\",\"user_id\":\"8662\",\"remainingCredits\":238,\"mode\":\"production\",\"reportType\":\"said_verification\",\"input\":{\"idNumber\":\"8812205697089\"},\"results\":{\"said_verification\":{\"Status\":\"Success\",\"realTimeResults\":{\"Status\":\"ID Number Valid\",\"Verification\":{\"Firstnames\":\"GABRIEL OFENTSE\",\"Lastname\":\"RABOTLHALE\",\"Dob\":\"1988-12-20\",\"Age\":37,\"Gender\":\"Male\",\"Citizenship\":\"South African\",\"DateIssued\":\"\"},\"transaction_id\":\"19162901\"},\"transaction_id\":\"19162901\",\"meta\":{\"environment\":\"production\",\"timestamp\":\"2026-06-09T06:29:23.089Z\"}}}}', NULL, '2026-06-09 04:29:23', '2026-06-09 04:29:23', '2026-06-09 04:29:23'),
(3, 4, 'verified', 'c789704f-a0d7-40e8-b03a-3beaf7c91e59', '{\"id_number\":\"8812205697089\",\"reportType\":\"said_verification\",\"mode\":\"production\"}', '{\"success\":true,\"requestId\":\"c789704f-a0d7-40e8-b03a-3beaf7c91e59\",\"user_id\":\"8662\",\"remainingCredits\":237,\"mode\":\"production\",\"reportType\":\"said_verification\",\"input\":{\"idNumber\":\"8812205697089\"},\"results\":{\"said_verification\":{\"Status\":\"Success\",\"realTimeResults\":{\"Status\":\"ID Number Valid\",\"Verification\":{\"Firstnames\":\"GABRIEL OFENTSE\",\"Lastname\":\"RABOTLHALE\",\"Dob\":\"1988-12-20\",\"Age\":37,\"Gender\":\"Male\",\"Citizenship\":\"South African\",\"DateIssued\":\"\"},\"transaction_id\":\"19163002\"},\"transaction_id\":\"19163002\",\"meta\":{\"environment\":\"production\",\"timestamp\":\"2026-06-09T06:50:25.070Z\"}}}}', '{\"success\":true,\"requestId\":\"c789704f-a0d7-40e8-b03a-3beaf7c91e59\",\"user_id\":\"8662\",\"remainingCredits\":237,\"mode\":\"production\",\"reportType\":\"said_verification\",\"input\":{\"idNumber\":\"8812205697089\"},\"results\":{\"said_verification\":{\"Status\":\"Success\",\"realTimeResults\":{\"Status\":\"ID Number Valid\",\"Verification\":{\"Firstnames\":\"GABRIEL OFENTSE\",\"Lastname\":\"RABOTLHALE\",\"Dob\":\"1988-12-20\",\"Age\":37,\"Gender\":\"Male\",\"Citizenship\":\"South African\",\"DateIssued\":\"\"},\"transaction_id\":\"19163002\"},\"transaction_id\":\"19163002\",\"meta\":{\"environment\":\"production\",\"timestamp\":\"2026-06-09T06:50:25.070Z\"}}}}', NULL, '2026-06-09 04:50:25', '2026-06-09 04:50:25', '2026-06-09 04:50:25'),
(4, 1, 'verified', '7fedb92c-f863-4b40-a6a7-f1c5cb2ab8e2', '{\"id_number\":\"8905155324082\",\"reportType\":\"said_verification\",\"mode\":\"production\"}', '{\"success\":true,\"requestId\":\"7fedb92c-f863-4b40-a6a7-f1c5cb2ab8e2\",\"user_id\":\"8662\",\"remainingCredits\":236,\"mode\":\"production\",\"reportType\":\"said_verification\",\"input\":{\"idNumber\":\"8905155324082\"},\"results\":{\"said_verification\":{\"Status\":\"Success\",\"realTimeResults\":{\"Status\":\"ID Number Valid\",\"Verification\":{\"Firstnames\":\"BONGANI NTOKOZO\",\"Lastname\":\"MBONANI\",\"Dob\":\"1989-05-15\",\"Age\":37,\"Gender\":\"Male\",\"Citizenship\":\"South African\",\"DateIssued\":\"\"},\"transaction_id\":\"19163008\"},\"transaction_id\":\"19163008\",\"meta\":{\"environment\":\"production\",\"timestamp\":\"2026-06-09T06:52:23.185Z\"}}}}', '{\"success\":true,\"requestId\":\"7fedb92c-f863-4b40-a6a7-f1c5cb2ab8e2\",\"user_id\":\"8662\",\"remainingCredits\":236,\"mode\":\"production\",\"reportType\":\"said_verification\",\"input\":{\"idNumber\":\"8905155324082\"},\"results\":{\"said_verification\":{\"Status\":\"Success\",\"realTimeResults\":{\"Status\":\"ID Number Valid\",\"Verification\":{\"Firstnames\":\"BONGANI NTOKOZO\",\"Lastname\":\"MBONANI\",\"Dob\":\"1989-05-15\",\"Age\":37,\"Gender\":\"Male\",\"Citizenship\":\"South African\",\"DateIssued\":\"\"},\"transaction_id\":\"19163008\"},\"transaction_id\":\"19163008\",\"meta\":{\"environment\":\"production\",\"timestamp\":\"2026-06-09T06:52:23.185Z\"}}}}', NULL, '2026-06-09 04:52:23', '2026-06-09 04:52:23', '2026-06-09 04:52:23'),
(5, 5, 'failed', NULL, '{\"registration_number\":null,\"reportType\":\"cipc_company_match\",\"mode\":\"production\"}', '{\"error\":\"Missing identifier for company match. Must provide at least one of registration_number, vat_number, or sole_prop_id_number.\"}', '{\"error\":\"Missing identifier for company match. Must provide at least one of registration_number, vat_number, or sole_prop_id_number.\"}', 'Missing identifier for company match. Must provide at least one of registration_number, vat_number, or sole_prop_id_number.', '2026-06-09 04:57:48', '2026-06-09 04:57:48', '2026-06-09 04:57:48'),
(6, 5, 'failed', NULL, '{\"registration_number\":\"201408196207\",\"reportType\":\"cipc_company_match\",\"mode\":\"production\"}', '{\"success\":false,\"error\":\"Processing failed\",\"message\":\"Failed to query CIPC endpoint. Please try again later.\"}', '{\"success\":false,\"error\":\"Processing failed\",\"message\":\"Failed to query CIPC endpoint. Please try again later.\"}', 'Processing failed', '2026-06-09 05:20:26', '2026-06-09 05:20:26', '2026-06-09 05:20:26'),
(7, 5, 'failed', NULL, '{\"registration_number\":\"201408196207\",\"reportType\":\"cipc_company_match\",\"mode\":\"production\"}', '{\"success\":false,\"error\":\"Processing failed\",\"message\":\"Failed to query CIPC endpoint. Please try again later.\"}', '{\"success\":false,\"error\":\"Processing failed\",\"message\":\"Failed to query CIPC endpoint. Please try again later.\"}', 'Failed to query CIPC endpoint. Please try again later.', '2026-06-09 05:27:21', '2026-06-09 05:27:21', '2026-06-09 05:27:21');
INSERT INTO `verification_attempts` (`id`, `verification_record_id`, `status`, `provider_reference`, `request_payload`, `raw_response`, `processed_response`, `error_message`, `attempted_at`, `created_at`, `updated_at`) VALUES
(8, 6, 'verified', '791e0bfb-3d43-4548-82c9-764bb4a5e5d7', '{\"director_id\":1,\"id_number\":\"8812205697089\",\"reportType\":\"cipc_director_search\",\"mode\":\"production\"}', '{\"success\":true,\"response_timestamp\":\"2026-06-09T07:36:38.548Z\",\"requestId\":\"791e0bfb-3d43-4548-82c9-764bb4a5e5d7\",\"user_id\":\"8662\",\"remaining_credits\":206,\"mode\":\"production\",\"service\":\"cipc_director_search\",\"input\":{\"reportType\":\"cipc_director_search\",\"idNumber\":\"8812205697089\",\"mode\":\"production\"},\"results\":{\"success\":true,\"id_number\":\"8812205697089\",\"full_name\":\"GABRIEL OFENTSE RABOTLHALE\",\"initials\":\"GO\",\"birth_date\":\"1988-12-20\",\"gender\":\"Male\",\"title\":\"Mister\",\"marital_status\":\"Married\",\"privacy_status\":\"ACCEPTS CONTACTS\",\"cellular_number\":\"0725902289\",\"home_telephone\":\"0145532042\",\"work_telephone\":\"0110512800\",\"email_address\":\"GABRIEL.OFT@GMAIL.COM\",\"residential_address\":\"8907 BELARUS STREET SONNEDAL RANDBURG 7742\",\"postal_address\":\"26 BELARUS ST COSMO CITY 2188\",\"employer\":\"FGX STUDIOS\",\"number_of_enquiries\":\"3\",\"fraud_indicators\":{\"HomeAffairsVerificationYN\":\"Yes\",\"HomeAffairsDeceasedStatus\":\"No\",\"EmployerFraudVerificationYN\":\"\",\"ProtectiveVerificationYN\":\"No\",\"HomeAffairsDeceasedDate\":\"No\"},\"property_summary\":{\"TotalProperty\":\"1\",\"PurchasePrice\":\"700000.0000\"},\"director_summary\":{\"NumberOfCompanyDirector\":\"3\"},\"marital_enquiry\":{\"FirstName\":\"\",\"Surname\":\"\",\"IDNumber\":\"\",\"SpouseFirstName\":\"\",\"SpouseSurname\":\"\",\"SpouseIDNumber\":\"\"},\"enquiry_history\":[{\"EnquiryDate\":\"2025-10-14\",\"SubscriberName\":\"Hirodox (Pty) Ltd T/A i-Bureau Services\",\"SubscriberBusinessTypeDescription\":\"Other\",\"CreditGrantorEnquiryReasonDescription\":\"Affordability Assessment\",\"SubscriberContact\":\"010500 1060\"}],\"address_history\":[{\"FirstReportedDate\":\"2014-11-30\",\"LastUpdatedDate\":\"2026-05-04\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"8907 BELARUS STREET\",\"AddressLine2\":\"SONNEDAL\",\"AddressLine3\":\"RANDBURG\",\"AddressLine4\":\"\",\"PostalCode\":\"7742\",\"Address\":\"8907 BELARUS STREET SONNEDAL RANDBURG 7742\"},{\"FirstReportedDate\":\"2015-07-11\",\"LastUpdatedDate\":\"2023-09-10\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"26 BELARUS ST\",\"AddressLine2\":\"\",\"AddressLine3\":\"\",\"AddressLine4\":\"COSMO CITY\",\"PostalCode\":\"2188\",\"Address\":\"26 BELARUS ST COSMO CITY 2188\"},{\"FirstReportedDate\":\"2022-12-30\",\"LastUpdatedDate\":\"2023-03-10\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"\",\"AddressLine2\":\"8907  BELARUS STREET\",\"AddressLine3\":\"COSMO CITY\",\"AddressLine4\":\"ROODEPOORT\",\"PostalCode\":\"2087\",\"Address\":\"8907  BELARUS STREET COSMO CITY ROODEPOORT 2087\"},{\"FirstReportedDate\":\"2022-06-21\",\"LastUpdatedDate\":\"2022-08-04\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"8907 BELARUS STREET\",\"AddressLine2\":\"\",\"AddressLine3\":\"\",\"AddressLine4\":\"COSMO CITY\",\"PostalCode\":\"2188\",\"Address\":\"8907 BELARUS STREET COSMO CITY 2188\"},{\"FirstReportedDate\":\"2022-06-21\",\"LastUpdatedDate\":\"2022-08-04\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"8907 BELARUS STREET\",\"AddressLine2\":\"\",\"AddressLine3\":\"\",\"AddressLine4\":\"COSMO CITY\",\"PostalCode\":\"2188\",\"Address\":\"8907 BELARUS STREET COSMO CITY 2188\"},{\"FirstReportedDate\":\"2022-06-21\",\"LastUpdatedDate\":\"2022-06-22\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"8907 BELARUS STREET\",\"AddressLine2\":\"\",\"AddressLine3\":\"COSMO CITY\",\"AddressLine4\":\"COSMO CITY\",\"PostalCode\":\"2188\",\"Address\":\"8907 BELARUS STREET COSMO CITY COSMO CITY 2188\"},{\"FirstReportedDate\":\"2022-06-21\",\"LastUpdatedDate\":\"2022-06-22\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"8907 BELARUS STREET\",\"AddressLine2\":\"\",\"AddressLine3\":\"COSMO CITY\",\"AddressLine4\":\"COSMO CITY\",\"PostalCode\":\"2087\",\"Address\":\"8907 BELARUS STREET COSMO CITY COSMO CITY 2087\"},{\"FirstReportedDate\":\"2022-06-01\",\"LastUpdatedDate\":\"2022-06-01\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"8783 EMDENI AVENUE\",\"AddressLine2\":\"\",\"AddressLine3\":\"KAGISO\",\"AddressLine4\":\"KRUGERSDORP\",\"PostalCode\":\"1754\",\"Address\":\"8783 EMDENI AVENUE KAGISO KRUGERSDORP 1754\"},{\"FirstReportedDate\":\"2022-06-01\",\"LastUpdatedDate\":\"2022-06-01\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"COSMO CITY EXT 7 KAGISO\",\"AddressLine2\":\"8907 BELARUS STREET\",\"AddressLine3\":\"KAGISO 1 EXT 8\",\"AddressLine4\":\"KRUGERSDORP\",\"PostalCode\":\"1754\",\"Address\":\"COSMO CITY EXT 7 KAGISO 8907 BELARUS STREET KAGISO 1 EXT 8 KRUGERSDORP 1754\"},{\"FirstReportedDate\":\"2017-04-03\",\"LastUpdatedDate\":\"2021-06-05\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"COSMO CITY EXT 7 KAGISO\",\"AddressLine2\":\"8907 BELARUS STREET\",\"AddressLine3\":\"KAGISO 1 EXT 8\",\"AddressLine4\":\"KRUGERSDORP\",\"PostalCode\":\"\",\"Address\":\"COSMO CITY EXT 7 KAGISO 8907 BELARUS STREET KAGISO 1 EXT 8 KRUGERSDORP\"},{\"FirstReportedDate\":\"2017-04-03\",\"LastUpdatedDate\":\"2020-11-07\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"COSMO CITY EXT 7 KAGISO\",\"AddressLine2\":\"8907 BELARUS STREET\",\"AddressLine3\":\"KAGISO 1 EXT 8\",\"AddressLine4\":\"KRUGERSDORP\",\"PostalCode\":\"001754\",\"Address\":\"COSMO CITY EXT 7 KAGISO 8907 BELARUS STREET KAGISO 1 EXT 8 KRUGERSDORP 001754\"},{\"FirstReportedDate\":\"2017-04-03\",\"LastUpdatedDate\":\"2020-11-07\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"8783 EMDENI AVENUE\",\"AddressLine2\":\"KAGISO\",\"AddressLine3\":\"KAGISO\",\"AddressLine4\":\"KRUGERSDORP\",\"PostalCode\":\"001754\",\"Address\":\"8783 EMDENI AVENUE KAGISO KAGISO KRUGERSDORP 001754\"},{\"FirstReportedDate\":\"2020-10-08\",\"LastUpdatedDate\":\"2020-10-08\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"COSMO CITY EXT 7 KAGISO\",\"AddressLine2\":\"8907 BELARUS STREET\",\"AddressLine3\":\"KAGISO 1 EXT 8\",\"AddressLine4\":\"KRUGERSDORP\",\"PostalCode\":\"001754\",\"Address\":\"COSMO CITY EXT 7 KAGISO 8907 BELARUS STREET KAGISO 1 EXT 8 KRUGERSDORP 001754\"},{\"FirstReportedDate\":\"2020-10-08\",\"LastUpdatedDate\":\"2020-10-08\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"8783 EMDENI AVENUE\",\"AddressLine2\":\"KAGISO\",\"AddressLine3\":\"KRUGERSDORP\",\"AddressLine4\":\"KRUGERSDORP\",\"PostalCode\":\"001754\",\"Address\":\"8783 EMDENI AVENUE KAGISO KRUGERSDORP KRUGERSDORP 001754\"},{\"FirstReportedDate\":\"2015-07-11\",\"LastUpdatedDate\":\"2020-08-09\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"26 BELARUS STREET\",\"AddressLine2\":\"\",\"AddressLine3\":\"\",\"AddressLine4\":\"COSMO CITY\",\"PostalCode\":\"2188\",\"Address\":\"26 BELARUS STREET COSMO CITY 2188\"},{\"FirstReportedDate\":\"2017-04-03\",\"LastUpdatedDate\":\"2020-06-07\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"PO BOX 220\",\"AddressLine2\":\"MADIKWE\",\"AddressLine3\":\"NOT APPLICABLE\",\"AddressLine4\":\"NOT APPLICABLE\",\"PostalCode\":\"002840\",\"Address\":\"PO BOX 220 MADIKWE NOT APPLICABLE NOT APPLICABLE 002840\"},{\"FirstReportedDate\":\"2017-04-03\",\"LastUpdatedDate\":\"2020-05-14\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"8783 EMDENI AVENUE\",\"AddressLine2\":\"KAGISO\",\"AddressLine3\":\"KRUGERSDORP\",\"AddressLine4\":\"KRUGERSDORP\",\"PostalCode\":\"002840\",\"Address\":\"8783 EMDENI AVENUE KAGISO KRUGERSDORP KRUGERSDORP 002840\"},{\"FirstReportedDate\":\"2020-05-14\",\"LastUpdatedDate\":\"2020-05-14\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"PO BOX 220\",\"AddressLine2\":\"MADIKWE\",\"AddressLine3\":\"MADIKWE\",\"AddressLine4\":\"MADIKWE\",\"PostalCode\":\"002840\",\"Address\":\"PO BOX 220 MADIKWE MADIKWE MADIKWE 002840\"},{\"FirstReportedDate\":\"2019-05-27\",\"LastUpdatedDate\":\"2020-03-10\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"8907 BELARUS ST\",\"AddressLine2\":\"\",\"AddressLine3\":\"COSMO CITY EXT 7\",\"AddressLine4\":\"\",\"PostalCode\":\"2188\",\"Address\":\"8907 BELARUS ST COSMO CITY EXT 7 2188\"},{\"FirstReportedDate\":\"2019-05-27\",\"LastUpdatedDate\":\"2020-03-10\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"8907 BELARUS ST\",\"AddressLine2\":\"\",\"AddressLine3\":\"COSMO CITY EXT 7\",\"AddressLine4\":\"\",\"PostalCode\":\"2188\",\"Address\":\"8907 BELARUS ST COSMO CITY EXT 7 2188\"},{\"FirstReportedDate\":\"2019-05-27\",\"LastUpdatedDate\":\"2019-05-31\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"SEQOBILE\",\"AddressLine2\":\"226 PEOLWANE ST\",\"AddressLine3\":\"MADIKWE\",\"AddressLine4\":\"\",\"PostalCode\":\"2840\",\"Address\":\"SEQOBILE 226 PEOLWANE ST MADIKWE 2840\"},{\"FirstReportedDate\":\"2019-05-27\",\"LastUpdatedDate\":\"2019-05-31\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"SEQOBILE\",\"AddressLine2\":\"511 MOKGOFE STREET\",\"AddressLine3\":\"KAGISO 1\",\"AddressLine4\":\"\",\"PostalCode\":\"1754\",\"Address\":\"SEQOBILE 511 MOKGOFE STREET KAGISO 1 1754\"},{\"FirstReportedDate\":\"2015-07-11\",\"LastUpdatedDate\":\"2019-02-12\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"226 POELWANE ST\",\"AddressLine2\":\"\",\"AddressLine3\":\"\",\"AddressLine4\":\"MADIKWE\",\"PostalCode\":\"2840\",\"Address\":\"226 POELWANE ST MADIKWE 2840\"},{\"FirstReportedDate\":\"2015-07-11\",\"LastUpdatedDate\":\"2019-02-12\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"226 PEOLWANE STREET\",\"AddressLine2\":\"\",\"AddressLine3\":\"\",\"AddressLine4\":\"MADIKWE\",\"PostalCode\":\"2840\",\"Address\":\"226 PEOLWANE STREET MADIKWE 2840\"},{\"FirstReportedDate\":\"2014-11-30\",\"LastUpdatedDate\":\"2017-06-05\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"MADIKWE\",\"AddressLine2\":\"BAKWENA BOO MODIMOSANA\",\"AddressLine3\":\"\",\"AddressLine4\":\"\",\"PostalCode\":\"1754\",\"Address\":\"MADIKWE BAKWENA BOO MODIMOSANA 1754\"},{\"FirstReportedDate\":\"2014-11-30\",\"LastUpdatedDate\":\"2017-05-03\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"8783 EMDENI AVENUE\",\"AddressLine2\":\"MADIKWE\",\"AddressLine3\":\"BAKWENA BOO MODIMOSANA\",\"AddressLine4\":\"\",\"PostalCode\":\"2846\",\"Address\":\"8783 EMDENI AVENUE MADIKWE BAKWENA BOO MODIMOSANA 2846\"},{\"FirstReportedDate\":\"2017-05-03\",\"LastUpdatedDate\":\"2017-05-03\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"8783 EMDENI AVENUE\",\"AddressLine2\":\"KAGISO EXT 4\",\"AddressLine3\":\"KAGISO\",\"AddressLine4\":\"\",\"PostalCode\":\"1754\",\"Address\":\"8783 EMDENI AVENUE KAGISO EXT 4 KAGISO 1754\"},{\"FirstReportedDate\":\"2017-04-04\",\"LastUpdatedDate\":\"2017-04-04\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"8783 EMDENI AVENUE\",\"AddressLine2\":\"KAGISO\",\"AddressLine3\":\"KRUGERSDORP\",\"AddressLine4\":\"\",\"PostalCode\":\"1754\",\"Address\":\"8783 EMDENI AVENUE KAGISO KRUGERSDORP 1754\"},{\"FirstReportedDate\":\"2017-04-03\",\"LastUpdatedDate\":\"2017-04-04\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"8783 EMDENI AVENUE\",\"AddressLine2\":\"KAGISO\",\"AddressLine3\":\"KRUGERSDORP\",\"AddressLine4\":\"\",\"PostalCode\":\"1754\",\"Address\":\"8783 EMDENI AVENUE KAGISO KRUGERSDORP 1754\"},{\"FirstReportedDate\":\"2017-03-22\",\"LastUpdatedDate\":\"2017-03-24\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"8783 EMNDENI\",\"AddressLine2\":\"KAGISO\",\"AddressLine3\":\"\",\"AddressLine4\":\"\",\"PostalCode\":\"1754\",\"Address\":\"8783 EMNDENI KAGISO 1754\"},{\"FirstReportedDate\":\"2016-02-15\",\"LastUpdatedDate\":\"2016-04-17\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"8783 EMNDENI EAST STREET\",\"AddressLine2\":\"KAGISO 1\",\"AddressLine3\":\"KAGISO\",\"AddressLine4\":\"\",\"PostalCode\":\"1754\",\"Address\":\"8783 EMNDENI EAST STREET KAGISO 1 KAGISO 1754\"},{\"FirstReportedDate\":\"2015-07-11\",\"LastUpdatedDate\":\"2015-08-27\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"226 POELWANE ST\",\"AddressLine2\":\"MADIKWE\",\"AddressLine3\":\"\",\"AddressLine4\":\"\",\"PostalCode\":\"2840\",\"Address\":\"226 POELWANE ST MADIKWE 2840\"},{\"FirstReportedDate\":\"2015-07-11\",\"LastUpdatedDate\":\"2015-08-27\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"226 PEOLWANE STREET\",\"AddressLine2\":\"MADIKWE\",\"AddressLine3\":\"\",\"AddressLine4\":\"\",\"PostalCode\":\"2840\",\"Address\":\"226 PEOLWANE STREET MADIKWE 2840\"},{\"FirstReportedDate\":\"2013-11-13\",\"LastUpdatedDate\":\"2015-04-15\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"5 MAIN\",\"AddressLine2\":\"VREDENBURG\",\"AddressLine3\":\"\",\"AddressLine4\":\"\",\"PostalCode\":\"\",\"Address\":\"5 MAIN VREDENBURG\"},{\"FirstReportedDate\":\"2014-11-28\",\"LastUpdatedDate\":\"2015-01-25\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"226 PEOLWANE STREET\",\"AddressLine2\":\"MADIKWE\",\"AddressLine3\":\"BAKWENA BOO MODIMOSANA\",\"AddressLine4\":\"\",\"PostalCode\":\"2846\",\"Address\":\"226 PEOLWANE STREET MADIKWE BAKWENA BOO MODIMOSANA 2846\"},{\"FirstReportedDate\":\"2014-11-28\",\"LastUpdatedDate\":\"2015-01-25\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"226 PEOLWANE STREET\",\"AddressLine2\":\"MADIKWE\",\"AddressLine3\":\"MADIKWE\",\"AddressLine4\":\"\",\"PostalCode\":\"2840\",\"Address\":\"226 PEOLWANE STREET MADIKWE MADIKWE 2840\"},{\"FirstReportedDate\":\"2014-08-25\",\"LastUpdatedDate\":\"2014-08-25\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"PEOLWANE STREET\",\"AddressLine2\":\"MADIKWE\",\"AddressLine3\":\"\",\"AddressLine4\":\"\",\"PostalCode\":\"2840\",\"Address\":\"PEOLWANE STREET MADIKWE 2840\"},{\"FirstReportedDate\":\"2013-11-13\",\"LastUpdatedDate\":\"2014-05-24\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"5 MAIN\",\"AddressLine2\":\"VREDENBURG\",\"AddressLine3\":\"WESTERN CAPE\",\"AddressLine4\":\"\",\"PostalCode\":\"7380\",\"Address\":\"5 MAIN VREDENBURG WESTERN CAPE 7380\"},{\"FirstReportedDate\":\"2014-04-08\",\"LastUpdatedDate\":\"2014-04-08\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"5 MAIN\",\"AddressLine2\":\"VREDENBURG\",\"AddressLine3\":\"\",\"AddressLine4\":\"\",\"PostalCode\":\"\",\"Address\":\"5 MAIN VREDENBURG\"},{\"FirstReportedDate\":\"2014-04-08\",\"LastUpdatedDate\":\"2014-04-08\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"MAIN 5\",\"AddressLine2\":\"VREDENBURG\",\"AddressLine3\":\"WESTERN CAPE\",\"AddressLine4\":\"\",\"PostalCode\":\"7380\",\"Address\":\"MAIN 5 VREDENBURG WESTERN CAPE 7380\"},{\"FirstReportedDate\":\"2013-11-08\",\"LastUpdatedDate\":\"2013-12-04\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"226\",\"AddressLine2\":\"PELWANE STREET\",\"AddressLine3\":\"MADIKWE\",\"AddressLine4\":\"\",\"PostalCode\":\"2840\",\"Address\":\"226 PELWANE STREET MADIKWE 2840\"},{\"FirstReportedDate\":\"2013-11-08\",\"LastUpdatedDate\":\"2013-12-04\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"PO BOX 220\",\"AddressLine2\":\"PELWANE STREET\",\"AddressLine3\":\"MADIKWE\",\"AddressLine4\":\"\",\"PostalCode\":\"2840\",\"Address\":\"PO BOX 220 PELWANE STREET MADIKWE 2840\"},{\"FirstReportedDate\":\"2014-07-01\",\"LastUpdatedDate\":\"2013-06-29\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"PO BOX\",\"AddressLine2\":\"MADIKWE\",\"AddressLine3\":\"\",\"AddressLine4\":\"\",\"PostalCode\":\"2840\",\"Address\":\"PO BOX MADIKWE 2840\"},{\"FirstReportedDate\":\"2011-08-08\",\"LastUpdatedDate\":\"2012-11-17\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"516 SINQOBILE\",\"AddressLine2\":\"516 MOKGOFE STREET\",\"AddressLine3\":\"AZAADVILLE\",\"AddressLine4\":\"\",\"PostalCode\":\"1754\",\"Address\":\"516 SINQOBILE 516 MOKGOFE STREET AZAADVILLE 1754\"},{\"FirstReportedDate\":\"2009-11-29\",\"LastUpdatedDate\":\"2012-03-13\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"226 POELWANE STREET\",\"AddressLine2\":\"MADIKWE\",\"AddressLine3\":\"\",\"AddressLine4\":\"\",\"PostalCode\":\"2840\",\"Address\":\"226 POELWANE STREET MADIKWE 2840\"},{\"FirstReportedDate\":\"2011-07-18\",\"LastUpdatedDate\":\"2011-10-06\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"811 MOKGOFE STREET\",\"AddressLine2\":\"KAGISOI\",\"AddressLine3\":\"KAGISO\",\"AddressLine4\":\"\",\"PostalCode\":\"1754\",\"Address\":\"811 MOKGOFE STREET KAGISOI KAGISO 1754\"},{\"FirstReportedDate\":\"2011-10-06\",\"LastUpdatedDate\":\"2011-10-06\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"BOX 220\",\"AddressLine2\":\"MADIKOG\",\"AddressLine3\":\"RUSTENBERG\",\"AddressLine4\":\"\",\"PostalCode\":\"2840\",\"Address\":\"BOX 220 MADIKOG RUSTENBERG 2840\"},{\"FirstReportedDate\":\"2011-08-08\",\"LastUpdatedDate\":\"2011-08-29\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"516 SINQOBILE\",\"AddressLine2\":\"516 MOKGOFE STR\",\"AddressLine3\":\"AZAADVILLE\",\"AddressLine4\":\"AZAADVILLE\",\"PostalCode\":\"1754\",\"Address\":\"516 SINQOBILE 516 MOKGOFE STR AZAADVILLE AZAADVILLE 1754\"},{\"FirstReportedDate\":\"2009-11-28\",\"LastUpdatedDate\":\"2009-11-28\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P         \",\"AddressLine1\":\"P O BOX 220\",\"AddressLine2\":\"MADIKWE\",\"AddressLine3\":\"\",\"AddressLine4\":\"\",\"PostalCode\":\"2840\",\"Address\":\"P O BOX 220, MADIKWE, 2840\"},{\"FirstReportedDate\":\"2009-08-30\",\"LastUpdatedDate\":\"2009-08-30\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P         \",\"AddressLine1\":\"P O BOX 220\",\"AddressLine2\":\"MADIKWE\",\"AddressLine3\":\"\",\"AddressLine4\":\"\",\"PostalCode\":\"2840\",\"Address\":\"P O BOX 220, MADIKWE, 2840\"},{\"FirstReportedDate\":\"2009-08-30\",\"LastUpdatedDate\":\"2009-08-30\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R         \",\"AddressLine1\":\"226 PEOLWANE STREET\",\"AddressLine2\":\"MADIKWE\",\"AddressLine3\":\"\",\"AddressLine4\":\"\",\"PostalCode\":\"2840\",\"Address\":\"226 PEOLWANE STREET, MADIKWE, 2840\"},{\"FirstReportedDate\":\"2011-07-18\",\"LastUpdatedDate\":\"2006-09-24\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"PO BOX 220\",\"AddressLine2\":\"MADIKWE\",\"AddressLine3\":\"\",\"AddressLine4\":\"\",\"PostalCode\":\"2840\",\"Address\":\"PO BOX 220 MADIKWE 2840\"}],\"telephone_history\":[{\"ConsumerTelephoneID\":\"640554866\",\"TelephoneType\":\"Cellular\",\"TelephoneTypeInd\":\"C\",\"TelCode\":\"062\",\"TelNumber\":\"2673410\",\"TelephoneNumber\":\"0622673410\",\"EmailAddress\":\"\",\"LastUpdatedDate\":\"2026-05-04\",\"FirstReportedDate\":\"2014-11-30\"},{\"ConsumerTelephoneID\":\"578051729\",\"TelephoneType\":\"Work\",\"TelephoneTypeInd\":\"W\",\"TelCode\":\"011\",\"TelNumber\":\"0512800\",\"TelephoneNumber\":\"0110512800\",\"EmailAddress\":\"\",\"LastUpdatedDate\":\"2022-06-22\",\"FirstReportedDate\":\"2022-06-21\"},{\"ConsumerTelephoneID\":\"526896722\",\"TelephoneType\":\"Work\",\"TelephoneTypeInd\":\"W\",\"TelCode\":\"011\",\"TelNumber\":\"0386844\",\"TelephoneNumber\":\"0110386844\",\"EmailAddress\":\"\",\"LastUpdatedDate\":\"2019-07-14\",\"FirstReportedDate\":\"2015-07-11\"},{\"ConsumerTelephoneID\":\"524034089\",\"TelephoneType\":\"Work\",\"TelephoneTypeInd\":\"W\",\"TelCode\":\"011\",\"TelNumber\":\"0157280\",\"TelephoneNumber\":\"0110157280\",\"EmailAddress\":\"\",\"LastUpdatedDate\":\"2019-05-31\",\"FirstReportedDate\":\"2019-05-27\"},{\"ConsumerTelephoneID\":\"463671124\",\"TelephoneType\":\"Home\",\"TelephoneTypeInd\":\"H\",\"TelCode\":\"014\",\"TelNumber\":\"5532042\",\"TelephoneNumber\":\"0145532042\",\"EmailAddress\":\"\",\"LastUpdatedDate\":\"2016-02-23\",\"FirstReportedDate\":\"2011-07-18\"},{\"ConsumerTelephoneID\":\"463669126\",\"TelephoneType\":\"Work\",\"TelephoneTypeInd\":\"W\",\"TelCode\":\"083\",\"TelNumber\":\"3801266\",\"TelephoneNumber\":\"0833801266\",\"EmailAddress\":\"\",\"LastUpdatedDate\":\"2016-02-23\",\"FirstReportedDate\":\"2011-07-18\"},{\"ConsumerTelephoneID\":\"463668881\",\"TelephoneType\":\"Cellular\",\"TelephoneTypeInd\":\"C\",\"TelCode\":\"072\",\"TelNumber\":\"5902289\",\"TelephoneNumber\":\"0725902289\",\"EmailAddress\":\"\",\"LastUpdatedDate\":\"2016-02-23\",\"FirstReportedDate\":\"2011-07-18\"},{\"ConsumerTelephoneID\":\"437759798\",\"TelephoneType\":\"Work\",\"TelephoneTypeInd\":\"W\",\"TelCode\":\"083\",\"TelNumber\":\"3801266\",\"TelephoneNumber\":\"0833801266\",\"EmailAddress\":\"\",\"LastUpdatedDate\":\"2015-01-29\",\"FirstReportedDate\":\"2011-07-18\"},{\"ConsumerTelephoneID\":\"414244725\",\"TelephoneType\":\"Work\",\"TelephoneTypeInd\":\"W\",\"TelCode\":\"011\",\"TelNumber\":\"4674779\",\"TelephoneNumber\":\"0114674779\",\"EmailAddress\":\"\",\"LastUpdatedDate\":\"2013-06-29\",\"FirstReportedDate\":\"2012-06-30\"},{\"ConsumerTelephoneID\":\"398865041\",\"TelephoneType\":\"Cellular\",\"TelephoneTypeInd\":\"C\",\"TelCode\":\"083\",\"TelNumber\":\"3801266\",\"TelephoneNumber\":\"0833801266\",\"EmailAddress\":\"\",\"LastUpdatedDate\":\"2012-04-14\",\"FirstReportedDate\":\"2009-11-29\"},{\"ConsumerTelephoneID\":\"376988764\",\"TelephoneType\":\"Work\",\"TelephoneTypeInd\":\"W\",\"TelCode\":\"014\",\"TelNumber\":\"5532042\",\"TelephoneNumber\":\"0145532042\",\"EmailAddress\":\"\",\"LastUpdatedDate\":\"2011-09-21\",\"FirstReportedDate\":\"2011-09-21\"},{\"ConsumerTelephoneID\":\"373327871\",\"TelephoneType\":\"Home\",\"TelephoneTypeInd\":\"H\",\"TelCode\":\"014\",\"TelNumber\":\"5532042\",\"TelephoneNumber\":\"0145532042\",\"EmailAddress\":\"\",\"LastUpdatedDate\":\"2011-09-15\",\"FirstReportedDate\":\"2009-11-29\"},{\"ConsumerTelephoneID\":\"212384489\",\"TelephoneType\":\"Cellular\",\"TelephoneTypeInd\":\"C\",\"TelCode\":\"072\",\"TelNumber\":\"5902289\",\"TelephoneNumber\":\"0725902289\",\"EmailAddress\":\"\",\"LastUpdatedDate\":\"2009-11-25\",\"FirstReportedDate\":\"2009-10-22\"}],\"employment_history\":[{\"EmployerDetail\":\"FGX STUDIOS\",\"Designation\":\"\",\"LastUpdatedDate\":\"2019-08-07\",\"FirstReportedDate\":\"2019-05-27\"},{\"EmployerDetail\":\"WALLSTREET INTERACTIVE PTY LTD\",\"Designation\":\"\",\"LastUpdatedDate\":\"2012-11-20\",\"FirstReportedDate\":\"2012-06-30\"},{\"EmployerDetail\":\"MRABOTLHAEROOF\",\"Designation\":\"\",\"LastUpdatedDate\":\"2011-10-06\",\"FirstReportedDate\":\"2011-07-18\"},{\"EmployerDetail\":\"ZACHARIA RABOTLHARE\",\"Designation\":\"\",\"LastUpdatedDate\":\"2010-04-28\",\"FirstReportedDate\":\"2009-11-29\"}],\"director_enquiry_history\":[{\"EnquiryDate\":\"2026-05-27\",\"SubscriberName\":\"DataNamix - Web service\",\"SubscriberBusinessTypeDescription\":\"Other\",\"SubscriberContact\":\"\"},{\"EnquiryDate\":\"2026-06-06\",\"SubscriberName\":\"DataNamix - Web service\",\"SubscriberBusinessTypeDescription\":\"Other\",\"SubscriberContact\":\"\"}],\"property_information\":[{\"AuthorityName\":\"CITY OF JOHANNESBURG\",\"TownshipName\":\"\",\"StandNumber\":\"\",\"PortionNumber\":\"\",\"FarmName\":\"\",\"SchemeName\":\"\",\"TitleDeedNumber\":\"T16441/2019\",\"BuyerName\":\"RABOTLHALE GABRIEL OFENTSE\",\"BuyerTypeCode\":\"1\",\"BuyerIDNumber\":\"8812205697089\",\"BuyerMaritalStatusCode\":\"MARRIED IN\",\"SellerName\":\"MOKOTO KENEILWE\",\"SellerTypeCode\":\"1\",\"SellerIDNumber\":\"8206160932088\",\"SellerMaritalStatusCode\":\"UNMARRIED\",\"TransferDate\":\"2019-05-27\",\"RegistrarName\":\"JOHANNESBURG\",\"OldTitleDeedNumber\":\"T38946/2012\",\"AttorneyFirmNumber\":\"\",\"AttorneyFileNumber\":\"\",\"TitleDeedFeeAmount\":\"0.0000\",\"PropertyTypeCode\":\"E\",\"StreetNumber\":\"26\",\"StreetName\":\"BELARUS\",\"SuburbName\":\"\",\"CityName\":\"COSMO CITY EXT 7\",\"TransferID\":\"0\",\"ErfNumber\":\"8907\",\"DeedsOffice\":\"JOHANNESBURG\",\"PropertyTypeDescription\":\"Full Title - Erf - Land Parcel\",\"ErfSize\":\"280.0SQM\",\"PurchaseDate\":\"2019-03-13\",\"PurchasePriceAmount\":\"700000.0000\",\"BuyerSharePercentage\":\"0.0000\",\"BondAccountNumber\":\"B119712019\",\"BondAmount\":\"700000.0000\",\"BondHolderName\":\"S B GUARANTEE CO RF PTY LTD\",\"PhysicalAddress\":\"26 BELARUS  COSMO CITY EXT 7\"}],\"directorships\":[{\"CommercialName\":\"SA GLOBAL ZA\",\"RegistrationNumber\":\"K2014/161043/07\",\"AppointmentDate\":\"2014-08-05\",\"DirectorStatus\":\"Active\",\"DirectorDesignationDescription\":\"\",\"CommercialStatus\":\"AR Deregistration Process\",\"SICDescription\":\"Unknown Data\",\"PhysicalAddress\":\"8907 BELARUS STREET, COSMO CITY EXT7, COSMO CITY EXT7, GAUTENG, 2188\",\"PostalAddress\":\"8907 BELARUS STREET, COSMO CITY EXT7, COSMO CITY EXT7, GAUTENG, 2188\",\"TelephoneNumber\":\"\"},{\"CommercialName\":\"RAB COLLECTIVE\",\"RegistrationNumber\":\"K2016/353602/07\",\"AppointmentDate\":\"2016-08-17\",\"DirectorStatus\":\"Active\",\"DirectorDesignationDescription\":\"\",\"CommercialStatus\":\"AR Deregistration Process\",\"SICDescription\":\"Unknown Data\",\"PhysicalAddress\":\"8907 BELARUS STREET, COSMO CITY EXT7, COSMO CITY EXT7, GAUTENG, 2188\",\"PostalAddress\":\"8907 BELARUS STREET, COSMO CITY EXT7, COSMO CITY EXT7, GAUTENG, 2188\",\"TelephoneNumber\":\"\"},{\"CommercialName\":\"CENTREDOPS\",\"RegistrationNumber\":\"K2019/016019/07\",\"AppointmentDate\":\"2019-01-25\",\"DirectorStatus\":\"Active\",\"DirectorDesignationDescription\":\"\",\"CommercialStatus\":\"In Business\",\"SICDescription\":\"Unknown Data\",\"PhysicalAddress\":\"8907 BELARUS STREET, COSMO CITY EXT7, COSMO CITY EXT7, GAUTENG, 2188\",\"PostalAddress\":\"8907 BELARUS STREET, COSMO CITY EXT7, COSMO CITY EXT7, GAUTENG, 2188\",\"TelephoneNumber\":\"\"}],\"total_directorships\":3}}', '{\"success\":true,\"response_timestamp\":\"2026-06-09T07:36:38.548Z\",\"requestId\":\"791e0bfb-3d43-4548-82c9-764bb4a5e5d7\",\"user_id\":\"8662\",\"remaining_credits\":206,\"mode\":\"production\",\"service\":\"cipc_director_search\",\"input\":{\"reportType\":\"cipc_director_search\",\"idNumber\":\"8812205697089\",\"mode\":\"production\"},\"results\":{\"success\":true,\"id_number\":\"8812205697089\",\"full_name\":\"GABRIEL OFENTSE RABOTLHALE\",\"initials\":\"GO\",\"birth_date\":\"1988-12-20\",\"gender\":\"Male\",\"title\":\"Mister\",\"marital_status\":\"Married\",\"privacy_status\":\"ACCEPTS CONTACTS\",\"cellular_number\":\"0725902289\",\"home_telephone\":\"0145532042\",\"work_telephone\":\"0110512800\",\"email_address\":\"GABRIEL.OFT@GMAIL.COM\",\"residential_address\":\"8907 BELARUS STREET SONNEDAL RANDBURG 7742\",\"postal_address\":\"26 BELARUS ST COSMO CITY 2188\",\"employer\":\"FGX STUDIOS\",\"number_of_enquiries\":\"3\",\"fraud_indicators\":{\"HomeAffairsVerificationYN\":\"Yes\",\"HomeAffairsDeceasedStatus\":\"No\",\"EmployerFraudVerificationYN\":\"\",\"ProtectiveVerificationYN\":\"No\",\"HomeAffairsDeceasedDate\":\"No\"},\"property_summary\":{\"TotalProperty\":\"1\",\"PurchasePrice\":\"700000.0000\"},\"director_summary\":{\"NumberOfCompanyDirector\":\"3\"},\"marital_enquiry\":{\"FirstName\":\"\",\"Surname\":\"\",\"IDNumber\":\"\",\"SpouseFirstName\":\"\",\"SpouseSurname\":\"\",\"SpouseIDNumber\":\"\"},\"enquiry_history\":[{\"EnquiryDate\":\"2025-10-14\",\"SubscriberName\":\"Hirodox (Pty) Ltd T\\/A i-Bureau Services\",\"SubscriberBusinessTypeDescription\":\"Other\",\"CreditGrantorEnquiryReasonDescription\":\"Affordability Assessment\",\"SubscriberContact\":\"010500 1060\"}],\"address_history\":[{\"FirstReportedDate\":\"2014-11-30\",\"LastUpdatedDate\":\"2026-05-04\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"8907 BELARUS STREET\",\"AddressLine2\":\"SONNEDAL\",\"AddressLine3\":\"RANDBURG\",\"AddressLine4\":\"\",\"PostalCode\":\"7742\",\"Address\":\"8907 BELARUS STREET SONNEDAL RANDBURG 7742\"},{\"FirstReportedDate\":\"2015-07-11\",\"LastUpdatedDate\":\"2023-09-10\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"26 BELARUS ST\",\"AddressLine2\":\"\",\"AddressLine3\":\"\",\"AddressLine4\":\"COSMO CITY\",\"PostalCode\":\"2188\",\"Address\":\"26 BELARUS ST COSMO CITY 2188\"},{\"FirstReportedDate\":\"2022-12-30\",\"LastUpdatedDate\":\"2023-03-10\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"\",\"AddressLine2\":\"8907  BELARUS STREET\",\"AddressLine3\":\"COSMO CITY\",\"AddressLine4\":\"ROODEPOORT\",\"PostalCode\":\"2087\",\"Address\":\"8907  BELARUS STREET COSMO CITY ROODEPOORT 2087\"},{\"FirstReportedDate\":\"2022-06-21\",\"LastUpdatedDate\":\"2022-08-04\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"8907 BELARUS STREET\",\"AddressLine2\":\"\",\"AddressLine3\":\"\",\"AddressLine4\":\"COSMO CITY\",\"PostalCode\":\"2188\",\"Address\":\"8907 BELARUS STREET COSMO CITY 2188\"},{\"FirstReportedDate\":\"2022-06-21\",\"LastUpdatedDate\":\"2022-08-04\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"8907 BELARUS STREET\",\"AddressLine2\":\"\",\"AddressLine3\":\"\",\"AddressLine4\":\"COSMO CITY\",\"PostalCode\":\"2188\",\"Address\":\"8907 BELARUS STREET COSMO CITY 2188\"},{\"FirstReportedDate\":\"2022-06-21\",\"LastUpdatedDate\":\"2022-06-22\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"8907 BELARUS STREET\",\"AddressLine2\":\"\",\"AddressLine3\":\"COSMO CITY\",\"AddressLine4\":\"COSMO CITY\",\"PostalCode\":\"2188\",\"Address\":\"8907 BELARUS STREET COSMO CITY COSMO CITY 2188\"},{\"FirstReportedDate\":\"2022-06-21\",\"LastUpdatedDate\":\"2022-06-22\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"8907 BELARUS STREET\",\"AddressLine2\":\"\",\"AddressLine3\":\"COSMO CITY\",\"AddressLine4\":\"COSMO CITY\",\"PostalCode\":\"2087\",\"Address\":\"8907 BELARUS STREET COSMO CITY COSMO CITY 2087\"},{\"FirstReportedDate\":\"2022-06-01\",\"LastUpdatedDate\":\"2022-06-01\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"8783 EMDENI AVENUE\",\"AddressLine2\":\"\",\"AddressLine3\":\"KAGISO\",\"AddressLine4\":\"KRUGERSDORP\",\"PostalCode\":\"1754\",\"Address\":\"8783 EMDENI AVENUE KAGISO KRUGERSDORP 1754\"},{\"FirstReportedDate\":\"2022-06-01\",\"LastUpdatedDate\":\"2022-06-01\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"COSMO CITY EXT 7 KAGISO\",\"AddressLine2\":\"8907 BELARUS STREET\",\"AddressLine3\":\"KAGISO 1 EXT 8\",\"AddressLine4\":\"KRUGERSDORP\",\"PostalCode\":\"1754\",\"Address\":\"COSMO CITY EXT 7 KAGISO 8907 BELARUS STREET KAGISO 1 EXT 8 KRUGERSDORP 1754\"},{\"FirstReportedDate\":\"2017-04-03\",\"LastUpdatedDate\":\"2021-06-05\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"COSMO CITY EXT 7 KAGISO\",\"AddressLine2\":\"8907 BELARUS STREET\",\"AddressLine3\":\"KAGISO 1 EXT 8\",\"AddressLine4\":\"KRUGERSDORP\",\"PostalCode\":\"\",\"Address\":\"COSMO CITY EXT 7 KAGISO 8907 BELARUS STREET KAGISO 1 EXT 8 KRUGERSDORP\"},{\"FirstReportedDate\":\"2017-04-03\",\"LastUpdatedDate\":\"2020-11-07\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"COSMO CITY EXT 7 KAGISO\",\"AddressLine2\":\"8907 BELARUS STREET\",\"AddressLine3\":\"KAGISO 1 EXT 8\",\"AddressLine4\":\"KRUGERSDORP\",\"PostalCode\":\"001754\",\"Address\":\"COSMO CITY EXT 7 KAGISO 8907 BELARUS STREET KAGISO 1 EXT 8 KRUGERSDORP 001754\"},{\"FirstReportedDate\":\"2017-04-03\",\"LastUpdatedDate\":\"2020-11-07\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"8783 EMDENI AVENUE\",\"AddressLine2\":\"KAGISO\",\"AddressLine3\":\"KAGISO\",\"AddressLine4\":\"KRUGERSDORP\",\"PostalCode\":\"001754\",\"Address\":\"8783 EMDENI AVENUE KAGISO KAGISO KRUGERSDORP 001754\"},{\"FirstReportedDate\":\"2020-10-08\",\"LastUpdatedDate\":\"2020-10-08\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"COSMO CITY EXT 7 KAGISO\",\"AddressLine2\":\"8907 BELARUS STREET\",\"AddressLine3\":\"KAGISO 1 EXT 8\",\"AddressLine4\":\"KRUGERSDORP\",\"PostalCode\":\"001754\",\"Address\":\"COSMO CITY EXT 7 KAGISO 8907 BELARUS STREET KAGISO 1 EXT 8 KRUGERSDORP 001754\"},{\"FirstReportedDate\":\"2020-10-08\",\"LastUpdatedDate\":\"2020-10-08\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"8783 EMDENI AVENUE\",\"AddressLine2\":\"KAGISO\",\"AddressLine3\":\"KRUGERSDORP\",\"AddressLine4\":\"KRUGERSDORP\",\"PostalCode\":\"001754\",\"Address\":\"8783 EMDENI AVENUE KAGISO KRUGERSDORP KRUGERSDORP 001754\"},{\"FirstReportedDate\":\"2015-07-11\",\"LastUpdatedDate\":\"2020-08-09\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"26 BELARUS STREET\",\"AddressLine2\":\"\",\"AddressLine3\":\"\",\"AddressLine4\":\"COSMO CITY\",\"PostalCode\":\"2188\",\"Address\":\"26 BELARUS STREET COSMO CITY 2188\"},{\"FirstReportedDate\":\"2017-04-03\",\"LastUpdatedDate\":\"2020-06-07\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"PO BOX 220\",\"AddressLine2\":\"MADIKWE\",\"AddressLine3\":\"NOT APPLICABLE\",\"AddressLine4\":\"NOT APPLICABLE\",\"PostalCode\":\"002840\",\"Address\":\"PO BOX 220 MADIKWE NOT APPLICABLE NOT APPLICABLE 002840\"},{\"FirstReportedDate\":\"2017-04-03\",\"LastUpdatedDate\":\"2020-05-14\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"8783 EMDENI AVENUE\",\"AddressLine2\":\"KAGISO\",\"AddressLine3\":\"KRUGERSDORP\",\"AddressLine4\":\"KRUGERSDORP\",\"PostalCode\":\"002840\",\"Address\":\"8783 EMDENI AVENUE KAGISO KRUGERSDORP KRUGERSDORP 002840\"},{\"FirstReportedDate\":\"2020-05-14\",\"LastUpdatedDate\":\"2020-05-14\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"PO BOX 220\",\"AddressLine2\":\"MADIKWE\",\"AddressLine3\":\"MADIKWE\",\"AddressLine4\":\"MADIKWE\",\"PostalCode\":\"002840\",\"Address\":\"PO BOX 220 MADIKWE MADIKWE MADIKWE 002840\"},{\"FirstReportedDate\":\"2019-05-27\",\"LastUpdatedDate\":\"2020-03-10\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"8907 BELARUS ST\",\"AddressLine2\":\"\",\"AddressLine3\":\"COSMO CITY EXT 7\",\"AddressLine4\":\"\",\"PostalCode\":\"2188\",\"Address\":\"8907 BELARUS ST COSMO CITY EXT 7 2188\"},{\"FirstReportedDate\":\"2019-05-27\",\"LastUpdatedDate\":\"2020-03-10\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"8907 BELARUS ST\",\"AddressLine2\":\"\",\"AddressLine3\":\"COSMO CITY EXT 7\",\"AddressLine4\":\"\",\"PostalCode\":\"2188\",\"Address\":\"8907 BELARUS ST COSMO CITY EXT 7 2188\"},{\"FirstReportedDate\":\"2019-05-27\",\"LastUpdatedDate\":\"2019-05-31\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"SEQOBILE\",\"AddressLine2\":\"226 PEOLWANE ST\",\"AddressLine3\":\"MADIKWE\",\"AddressLine4\":\"\",\"PostalCode\":\"2840\",\"Address\":\"SEQOBILE 226 PEOLWANE ST MADIKWE 2840\"},{\"FirstReportedDate\":\"2019-05-27\",\"LastUpdatedDate\":\"2019-05-31\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"SEQOBILE\",\"AddressLine2\":\"511 MOKGOFE STREET\",\"AddressLine3\":\"KAGISO 1\",\"AddressLine4\":\"\",\"PostalCode\":\"1754\",\"Address\":\"SEQOBILE 511 MOKGOFE STREET KAGISO 1 1754\"},{\"FirstReportedDate\":\"2015-07-11\",\"LastUpdatedDate\":\"2019-02-12\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"226 POELWANE ST\",\"AddressLine2\":\"\",\"AddressLine3\":\"\",\"AddressLine4\":\"MADIKWE\",\"PostalCode\":\"2840\",\"Address\":\"226 POELWANE ST MADIKWE 2840\"},{\"FirstReportedDate\":\"2015-07-11\",\"LastUpdatedDate\":\"2019-02-12\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"226 PEOLWANE STREET\",\"AddressLine2\":\"\",\"AddressLine3\":\"\",\"AddressLine4\":\"MADIKWE\",\"PostalCode\":\"2840\",\"Address\":\"226 PEOLWANE STREET MADIKWE 2840\"},{\"FirstReportedDate\":\"2014-11-30\",\"LastUpdatedDate\":\"2017-06-05\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"MADIKWE\",\"AddressLine2\":\"BAKWENA BOO MODIMOSANA\",\"AddressLine3\":\"\",\"AddressLine4\":\"\",\"PostalCode\":\"1754\",\"Address\":\"MADIKWE BAKWENA BOO MODIMOSANA 1754\"},{\"FirstReportedDate\":\"2014-11-30\",\"LastUpdatedDate\":\"2017-05-03\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"8783 EMDENI AVENUE\",\"AddressLine2\":\"MADIKWE\",\"AddressLine3\":\"BAKWENA BOO MODIMOSANA\",\"AddressLine4\":\"\",\"PostalCode\":\"2846\",\"Address\":\"8783 EMDENI AVENUE MADIKWE BAKWENA BOO MODIMOSANA 2846\"},{\"FirstReportedDate\":\"2017-05-03\",\"LastUpdatedDate\":\"2017-05-03\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"8783 EMDENI AVENUE\",\"AddressLine2\":\"KAGISO EXT 4\",\"AddressLine3\":\"KAGISO\",\"AddressLine4\":\"\",\"PostalCode\":\"1754\",\"Address\":\"8783 EMDENI AVENUE KAGISO EXT 4 KAGISO 1754\"},{\"FirstReportedDate\":\"2017-04-04\",\"LastUpdatedDate\":\"2017-04-04\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"8783 EMDENI AVENUE\",\"AddressLine2\":\"KAGISO\",\"AddressLine3\":\"KRUGERSDORP\",\"AddressLine4\":\"\",\"PostalCode\":\"1754\",\"Address\":\"8783 EMDENI AVENUE KAGISO KRUGERSDORP 1754\"},{\"FirstReportedDate\":\"2017-04-03\",\"LastUpdatedDate\":\"2017-04-04\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"8783 EMDENI AVENUE\",\"AddressLine2\":\"KAGISO\",\"AddressLine3\":\"KRUGERSDORP\",\"AddressLine4\":\"\",\"PostalCode\":\"1754\",\"Address\":\"8783 EMDENI AVENUE KAGISO KRUGERSDORP 1754\"},{\"FirstReportedDate\":\"2017-03-22\",\"LastUpdatedDate\":\"2017-03-24\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"8783 EMNDENI\",\"AddressLine2\":\"KAGISO\",\"AddressLine3\":\"\",\"AddressLine4\":\"\",\"PostalCode\":\"1754\",\"Address\":\"8783 EMNDENI KAGISO 1754\"},{\"FirstReportedDate\":\"2016-02-15\",\"LastUpdatedDate\":\"2016-04-17\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"8783 EMNDENI EAST STREET\",\"AddressLine2\":\"KAGISO 1\",\"AddressLine3\":\"KAGISO\",\"AddressLine4\":\"\",\"PostalCode\":\"1754\",\"Address\":\"8783 EMNDENI EAST STREET KAGISO 1 KAGISO 1754\"},{\"FirstReportedDate\":\"2015-07-11\",\"LastUpdatedDate\":\"2015-08-27\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"226 POELWANE ST\",\"AddressLine2\":\"MADIKWE\",\"AddressLine3\":\"\",\"AddressLine4\":\"\",\"PostalCode\":\"2840\",\"Address\":\"226 POELWANE ST MADIKWE 2840\"},{\"FirstReportedDate\":\"2015-07-11\",\"LastUpdatedDate\":\"2015-08-27\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"226 PEOLWANE STREET\",\"AddressLine2\":\"MADIKWE\",\"AddressLine3\":\"\",\"AddressLine4\":\"\",\"PostalCode\":\"2840\",\"Address\":\"226 PEOLWANE STREET MADIKWE 2840\"},{\"FirstReportedDate\":\"2013-11-13\",\"LastUpdatedDate\":\"2015-04-15\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"5 MAIN\",\"AddressLine2\":\"VREDENBURG\",\"AddressLine3\":\"\",\"AddressLine4\":\"\",\"PostalCode\":\"\",\"Address\":\"5 MAIN VREDENBURG\"},{\"FirstReportedDate\":\"2014-11-28\",\"LastUpdatedDate\":\"2015-01-25\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"226 PEOLWANE STREET\",\"AddressLine2\":\"MADIKWE\",\"AddressLine3\":\"BAKWENA BOO MODIMOSANA\",\"AddressLine4\":\"\",\"PostalCode\":\"2846\",\"Address\":\"226 PEOLWANE STREET MADIKWE BAKWENA BOO MODIMOSANA 2846\"},{\"FirstReportedDate\":\"2014-11-28\",\"LastUpdatedDate\":\"2015-01-25\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"226 PEOLWANE STREET\",\"AddressLine2\":\"MADIKWE\",\"AddressLine3\":\"MADIKWE\",\"AddressLine4\":\"\",\"PostalCode\":\"2840\",\"Address\":\"226 PEOLWANE STREET MADIKWE MADIKWE 2840\"},{\"FirstReportedDate\":\"2014-08-25\",\"LastUpdatedDate\":\"2014-08-25\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"PEOLWANE STREET\",\"AddressLine2\":\"MADIKWE\",\"AddressLine3\":\"\",\"AddressLine4\":\"\",\"PostalCode\":\"2840\",\"Address\":\"PEOLWANE STREET MADIKWE 2840\"},{\"FirstReportedDate\":\"2013-11-13\",\"LastUpdatedDate\":\"2014-05-24\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"5 MAIN\",\"AddressLine2\":\"VREDENBURG\",\"AddressLine3\":\"WESTERN CAPE\",\"AddressLine4\":\"\",\"PostalCode\":\"7380\",\"Address\":\"5 MAIN VREDENBURG WESTERN CAPE 7380\"},{\"FirstReportedDate\":\"2014-04-08\",\"LastUpdatedDate\":\"2014-04-08\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"5 MAIN\",\"AddressLine2\":\"VREDENBURG\",\"AddressLine3\":\"\",\"AddressLine4\":\"\",\"PostalCode\":\"\",\"Address\":\"5 MAIN VREDENBURG\"},{\"FirstReportedDate\":\"2014-04-08\",\"LastUpdatedDate\":\"2014-04-08\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"MAIN 5\",\"AddressLine2\":\"VREDENBURG\",\"AddressLine3\":\"WESTERN CAPE\",\"AddressLine4\":\"\",\"PostalCode\":\"7380\",\"Address\":\"MAIN 5 VREDENBURG WESTERN CAPE 7380\"},{\"FirstReportedDate\":\"2013-11-08\",\"LastUpdatedDate\":\"2013-12-04\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"226\",\"AddressLine2\":\"PELWANE STREET\",\"AddressLine3\":\"MADIKWE\",\"AddressLine4\":\"\",\"PostalCode\":\"2840\",\"Address\":\"226 PELWANE STREET MADIKWE 2840\"},{\"FirstReportedDate\":\"2013-11-08\",\"LastUpdatedDate\":\"2013-12-04\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"PO BOX 220\",\"AddressLine2\":\"PELWANE STREET\",\"AddressLine3\":\"MADIKWE\",\"AddressLine4\":\"\",\"PostalCode\":\"2840\",\"Address\":\"PO BOX 220 PELWANE STREET MADIKWE 2840\"},{\"FirstReportedDate\":\"2014-07-01\",\"LastUpdatedDate\":\"2013-06-29\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"PO BOX\",\"AddressLine2\":\"MADIKWE\",\"AddressLine3\":\"\",\"AddressLine4\":\"\",\"PostalCode\":\"2840\",\"Address\":\"PO BOX MADIKWE 2840\"},{\"FirstReportedDate\":\"2011-08-08\",\"LastUpdatedDate\":\"2012-11-17\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"516 SINQOBILE\",\"AddressLine2\":\"516 MOKGOFE STREET\",\"AddressLine3\":\"AZAADVILLE\",\"AddressLine4\":\"\",\"PostalCode\":\"1754\",\"Address\":\"516 SINQOBILE 516 MOKGOFE STREET AZAADVILLE 1754\"},{\"FirstReportedDate\":\"2009-11-29\",\"LastUpdatedDate\":\"2012-03-13\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"226 POELWANE STREET\",\"AddressLine2\":\"MADIKWE\",\"AddressLine3\":\"\",\"AddressLine4\":\"\",\"PostalCode\":\"2840\",\"Address\":\"226 POELWANE STREET MADIKWE 2840\"},{\"FirstReportedDate\":\"2011-07-18\",\"LastUpdatedDate\":\"2011-10-06\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"811 MOKGOFE STREET\",\"AddressLine2\":\"KAGISOI\",\"AddressLine3\":\"KAGISO\",\"AddressLine4\":\"\",\"PostalCode\":\"1754\",\"Address\":\"811 MOKGOFE STREET KAGISOI KAGISO 1754\"},{\"FirstReportedDate\":\"2011-10-06\",\"LastUpdatedDate\":\"2011-10-06\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"BOX 220\",\"AddressLine2\":\"MADIKOG\",\"AddressLine3\":\"RUSTENBERG\",\"AddressLine4\":\"\",\"PostalCode\":\"2840\",\"Address\":\"BOX 220 MADIKOG RUSTENBERG 2840\"},{\"FirstReportedDate\":\"2011-08-08\",\"LastUpdatedDate\":\"2011-08-29\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R\",\"AddressLine1\":\"516 SINQOBILE\",\"AddressLine2\":\"516 MOKGOFE STR\",\"AddressLine3\":\"AZAADVILLE\",\"AddressLine4\":\"AZAADVILLE\",\"PostalCode\":\"1754\",\"Address\":\"516 SINQOBILE 516 MOKGOFE STR AZAADVILLE AZAADVILLE 1754\"},{\"FirstReportedDate\":\"2009-11-28\",\"LastUpdatedDate\":\"2009-11-28\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P         \",\"AddressLine1\":\"P O BOX 220\",\"AddressLine2\":\"MADIKWE\",\"AddressLine3\":\"\",\"AddressLine4\":\"\",\"PostalCode\":\"2840\",\"Address\":\"P O BOX 220, MADIKWE, 2840\"},{\"FirstReportedDate\":\"2009-08-30\",\"LastUpdatedDate\":\"2009-08-30\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P         \",\"AddressLine1\":\"P O BOX 220\",\"AddressLine2\":\"MADIKWE\",\"AddressLine3\":\"\",\"AddressLine4\":\"\",\"PostalCode\":\"2840\",\"Address\":\"P O BOX 220, MADIKWE, 2840\"},{\"FirstReportedDate\":\"2009-08-30\",\"LastUpdatedDate\":\"2009-08-30\",\"AddressType\":\"Residential\",\"AddressTypeInd\":\"R         \",\"AddressLine1\":\"226 PEOLWANE STREET\",\"AddressLine2\":\"MADIKWE\",\"AddressLine3\":\"\",\"AddressLine4\":\"\",\"PostalCode\":\"2840\",\"Address\":\"226 PEOLWANE STREET, MADIKWE, 2840\"},{\"FirstReportedDate\":\"2011-07-18\",\"LastUpdatedDate\":\"2006-09-24\",\"AddressType\":\"Postal\",\"AddressTypeInd\":\"P\",\"AddressLine1\":\"PO BOX 220\",\"AddressLine2\":\"MADIKWE\",\"AddressLine3\":\"\",\"AddressLine4\":\"\",\"PostalCode\":\"2840\",\"Address\":\"PO BOX 220 MADIKWE 2840\"}],\"telephone_history\":[{\"ConsumerTelephoneID\":\"640554866\",\"TelephoneType\":\"Cellular\",\"TelephoneTypeInd\":\"C\",\"TelCode\":\"062\",\"TelNumber\":\"2673410\",\"TelephoneNumber\":\"0622673410\",\"EmailAddress\":\"\",\"LastUpdatedDate\":\"2026-05-04\",\"FirstReportedDate\":\"2014-11-30\"},{\"ConsumerTelephoneID\":\"578051729\",\"TelephoneType\":\"Work\",\"TelephoneTypeInd\":\"W\",\"TelCode\":\"011\",\"TelNumber\":\"0512800\",\"TelephoneNumber\":\"0110512800\",\"EmailAddress\":\"\",\"LastUpdatedDate\":\"2022-06-22\",\"FirstReportedDate\":\"2022-06-21\"},{\"ConsumerTelephoneID\":\"526896722\",\"TelephoneType\":\"Work\",\"TelephoneTypeInd\":\"W\",\"TelCode\":\"011\",\"TelNumber\":\"0386844\",\"TelephoneNumber\":\"0110386844\",\"EmailAddress\":\"\",\"LastUpdatedDate\":\"2019-07-14\",\"FirstReportedDate\":\"2015-07-11\"},{\"ConsumerTelephoneID\":\"524034089\",\"TelephoneType\":\"Work\",\"TelephoneTypeInd\":\"W\",\"TelCode\":\"011\",\"TelNumber\":\"0157280\",\"TelephoneNumber\":\"0110157280\",\"EmailAddress\":\"\",\"LastUpdatedDate\":\"2019-05-31\",\"FirstReportedDate\":\"2019-05-27\"},{\"ConsumerTelephoneID\":\"463671124\",\"TelephoneType\":\"Home\",\"TelephoneTypeInd\":\"H\",\"TelCode\":\"014\",\"TelNumber\":\"5532042\",\"TelephoneNumber\":\"0145532042\",\"EmailAddress\":\"\",\"LastUpdatedDate\":\"2016-02-23\",\"FirstReportedDate\":\"2011-07-18\"},{\"ConsumerTelephoneID\":\"463669126\",\"TelephoneType\":\"Work\",\"TelephoneTypeInd\":\"W\",\"TelCode\":\"083\",\"TelNumber\":\"3801266\",\"TelephoneNumber\":\"0833801266\",\"EmailAddress\":\"\",\"LastUpdatedDate\":\"2016-02-23\",\"FirstReportedDate\":\"2011-07-18\"},{\"ConsumerTelephoneID\":\"463668881\",\"TelephoneType\":\"Cellular\",\"TelephoneTypeInd\":\"C\",\"TelCode\":\"072\",\"TelNumber\":\"5902289\",\"TelephoneNumber\":\"0725902289\",\"EmailAddress\":\"\",\"LastUpdatedDate\":\"2016-02-23\",\"FirstReportedDate\":\"2011-07-18\"},{\"ConsumerTelephoneID\":\"437759798\",\"TelephoneType\":\"Work\",\"TelephoneTypeInd\":\"W\",\"TelCode\":\"083\",\"TelNumber\":\"3801266\",\"TelephoneNumber\":\"0833801266\",\"EmailAddress\":\"\",\"LastUpdatedDate\":\"2015-01-29\",\"FirstReportedDate\":\"2011-07-18\"},{\"ConsumerTelephoneID\":\"414244725\",\"TelephoneType\":\"Work\",\"TelephoneTypeInd\":\"W\",\"TelCode\":\"011\",\"TelNumber\":\"4674779\",\"TelephoneNumber\":\"0114674779\",\"EmailAddress\":\"\",\"LastUpdatedDate\":\"2013-06-29\",\"FirstReportedDate\":\"2012-06-30\"},{\"ConsumerTelephoneID\":\"398865041\",\"TelephoneType\":\"Cellular\",\"TelephoneTypeInd\":\"C\",\"TelCode\":\"083\",\"TelNumber\":\"3801266\",\"TelephoneNumber\":\"0833801266\",\"EmailAddress\":\"\",\"LastUpdatedDate\":\"2012-04-14\",\"FirstReportedDate\":\"2009-11-29\"},{\"ConsumerTelephoneID\":\"376988764\",\"TelephoneType\":\"Work\",\"TelephoneTypeInd\":\"W\",\"TelCode\":\"014\",\"TelNumber\":\"5532042\",\"TelephoneNumber\":\"0145532042\",\"EmailAddress\":\"\",\"LastUpdatedDate\":\"2011-09-21\",\"FirstReportedDate\":\"2011-09-21\"},{\"ConsumerTelephoneID\":\"373327871\",\"TelephoneType\":\"Home\",\"TelephoneTypeInd\":\"H\",\"TelCode\":\"014\",\"TelNumber\":\"5532042\",\"TelephoneNumber\":\"0145532042\",\"EmailAddress\":\"\",\"LastUpdatedDate\":\"2011-09-15\",\"FirstReportedDate\":\"2009-11-29\"},{\"ConsumerTelephoneID\":\"212384489\",\"TelephoneType\":\"Cellular\",\"TelephoneTypeInd\":\"C\",\"TelCode\":\"072\",\"TelNumber\":\"5902289\",\"TelephoneNumber\":\"0725902289\",\"EmailAddress\":\"\",\"LastUpdatedDate\":\"2009-11-25\",\"FirstReportedDate\":\"2009-10-22\"}],\"employment_history\":[{\"EmployerDetail\":\"FGX STUDIOS\",\"Designation\":\"\",\"LastUpdatedDate\":\"2019-08-07\",\"FirstReportedDate\":\"2019-05-27\"},{\"EmployerDetail\":\"WALLSTREET INTERACTIVE PTY LTD\",\"Designation\":\"\",\"LastUpdatedDate\":\"2012-11-20\",\"FirstReportedDate\":\"2012-06-30\"},{\"EmployerDetail\":\"MRABOTLHAEROOF\",\"Designation\":\"\",\"LastUpdatedDate\":\"2011-10-06\",\"FirstReportedDate\":\"2011-07-18\"},{\"EmployerDetail\":\"ZACHARIA RABOTLHARE\",\"Designation\":\"\",\"LastUpdatedDate\":\"2010-04-28\",\"FirstReportedDate\":\"2009-11-29\"}],\"director_enquiry_history\":[{\"EnquiryDate\":\"2026-05-27\",\"SubscriberName\":\"DataNamix - Web service\",\"SubscriberBusinessTypeDescription\":\"Other\",\"SubscriberContact\":\"\"},{\"EnquiryDate\":\"2026-06-06\",\"SubscriberName\":\"DataNamix - Web service\",\"SubscriberBusinessTypeDescription\":\"Other\",\"SubscriberContact\":\"\"}],\"property_information\":[{\"AuthorityName\":\"CITY OF JOHANNESBURG\",\"TownshipName\":\"\",\"StandNumber\":\"\",\"PortionNumber\":\"\",\"FarmName\":\"\",\"SchemeName\":\"\",\"TitleDeedNumber\":\"T16441\\/2019\",\"BuyerName\":\"RABOTLHALE GABRIEL OFENTSE\",\"BuyerTypeCode\":\"1\",\"BuyerIDNumber\":\"8812205697089\",\"BuyerMaritalStatusCode\":\"MARRIED IN\",\"SellerName\":\"MOKOTO KENEILWE\",\"SellerTypeCode\":\"1\",\"SellerIDNumber\":\"8206160932088\",\"SellerMaritalStatusCode\":\"UNMARRIED\",\"TransferDate\":\"2019-05-27\",\"RegistrarName\":\"JOHANNESBURG\",\"OldTitleDeedNumber\":\"T38946\\/2012\",\"AttorneyFirmNumber\":\"\",\"AttorneyFileNumber\":\"\",\"TitleDeedFeeAmount\":\"0.0000\",\"PropertyTypeCode\":\"E\",\"StreetNumber\":\"26\",\"StreetName\":\"BELARUS\",\"SuburbName\":\"\",\"CityName\":\"COSMO CITY EXT 7\",\"TransferID\":\"0\",\"ErfNumber\":\"8907\",\"DeedsOffice\":\"JOHANNESBURG\",\"PropertyTypeDescription\":\"Full Title - Erf - Land Parcel\",\"ErfSize\":\"280.0SQM\",\"PurchaseDate\":\"2019-03-13\",\"PurchasePriceAmount\":\"700000.0000\",\"BuyerSharePercentage\":\"0.0000\",\"BondAccountNumber\":\"B119712019\",\"BondAmount\":\"700000.0000\",\"BondHolderName\":\"S B GUARANTEE CO RF PTY LTD\",\"PhysicalAddress\":\"26 BELARUS  COSMO CITY EXT 7\"}],\"directorships\":[{\"CommercialName\":\"SA GLOBAL ZA\",\"RegistrationNumber\":\"K2014\\/161043\\/07\",\"AppointmentDate\":\"2014-08-05\",\"DirectorStatus\":\"Active\",\"DirectorDesignationDescription\":\"\",\"CommercialStatus\":\"AR Deregistration Process\",\"SICDescription\":\"Unknown Data\",\"PhysicalAddress\":\"8907 BELARUS STREET, COSMO CITY EXT7, COSMO CITY EXT7, GAUTENG, 2188\",\"PostalAddress\":\"8907 BELARUS STREET, COSMO CITY EXT7, COSMO CITY EXT7, GAUTENG, 2188\",\"TelephoneNumber\":\"\"},{\"CommercialName\":\"RAB COLLECTIVE\",\"RegistrationNumber\":\"K2016\\/353602\\/07\",\"AppointmentDate\":\"2016-08-17\",\"DirectorStatus\":\"Active\",\"DirectorDesignationDescription\":\"\",\"CommercialStatus\":\"AR Deregistration Process\",\"SICDescription\":\"Unknown Data\",\"PhysicalAddress\":\"8907 BELARUS STREET, COSMO CITY EXT7, COSMO CITY EXT7, GAUTENG, 2188\",\"PostalAddress\":\"8907 BELARUS STREET, COSMO CITY EXT7, COSMO CITY EXT7, GAUTENG, 2188\",\"TelephoneNumber\":\"\"},{\"CommercialName\":\"CENTREDOPS\",\"RegistrationNumber\":\"K2019\\/016019\\/07\",\"AppointmentDate\":\"2019-01-25\",\"DirectorStatus\":\"Active\",\"DirectorDesignationDescription\":\"\",\"CommercialStatus\":\"In Business\",\"SICDescription\":\"Unknown Data\",\"PhysicalAddress\":\"8907 BELARUS STREET, COSMO CITY EXT7, COSMO CITY EXT7, GAUTENG, 2188\",\"PostalAddress\":\"8907 BELARUS STREET, COSMO CITY EXT7, COSMO CITY EXT7, GAUTENG, 2188\",\"TelephoneNumber\":\"\"}],\"total_directorships\":3}}', NULL, '2026-06-09 05:36:38', '2026-06-09 05:36:38', '2026-06-09 05:36:38');
INSERT INTO `verification_attempts` (`id`, `verification_record_id`, `status`, `provider_reference`, `request_payload`, `raw_response`, `processed_response`, `error_message`, `attempted_at`, `created_at`, `updated_at`) VALUES
(9, 5, 'failed', NULL, '{\"registration_number\":\"201408196207\",\"reportType\":\"cipc_company_match\",\"mode\":\"production\"}', '{\"success\":false,\"error\":\"Processing failed\",\"message\":\"Failed to query CIPC endpoint. Please try again later.\"}', '{\"success\":false,\"error\":\"Processing failed\",\"message\":\"Failed to query CIPC endpoint. Please try again later.\"}', 'Failed to query CIPC endpoint. Please try again later.', '2026-06-09 06:24:32', '2026-06-09 06:24:32', '2026-06-09 06:24:32'),
(10, 5, 'verified', '93ccf37f-c31a-4e2b-a542-b07a0fe9ed90', '{\"registration_number\":\"2014\\/081962\\/07\",\"reportType\":\"cipc_company_match\",\"mode\":\"production\"}', '{\"success\":true,\"response_timestamp\":\"2026-06-09T08:29:04.007Z\",\"requestId\":\"93ccf37f-c31a-4e2b-a542-b07a0fe9ed90\",\"user_id\":\"8662\",\"remaining_credits\":186,\"mode\":\"production\",\"service\":\"cipc_company_match\",\"input\":{\"registration_number\":\"2014/081962/07\",\"reportType\":\"cipc_company_match\",\"mode\":\"production\"},\"results\":{\"success\":true,\"company_name\":\"BLACK APPLE INVESTMENTS (PTY)LTD\",\"trade_name\":\"\",\"previous_name\":\"\",\"registration_number\":\"K2014/081962/07\",\"registration_date\":\"2014-04-24\",\"business_start_date\":\"2014-04-24\",\"status\":\"In Business\",\"company_type\":\"Private Company\",\"sic\":\"0 - Unknown Data\",\"tax_number\":\"9810918152\",\"vat_number\":\"4200309682\",\"business_description\":\"No Information Available\",\"telephone\":\"\",\"email\":\"\",\"website\":\"\",\"age_of_business\":\"12 Years 2 Months\",\"financial_year_end\":\"February\",\"director_count\":\"1\",\"number_of_enquiries\":\"3\",\"authorised_capital\":\"0.0000\",\"issued_capital\":\"0.0000\",\"physical_address\":\"62, KERK STREET, BELFAST, MPUMALANGA, 1100\",\"postal_address\":\"62, KERK STREET, BELFAST, MPUMALANGA, 1100\",\"directors\":[{\"FullName\":\"BONGANI NTOKOZO MBONANI\",\"FirstName\":\"BONGANI NTOKOZO\",\"Surname\":\"MBONANI\",\"IDNumber\":\"8905155324082\",\"AppointmentDate\":\"2014-04-24\",\"DirectorStatus\":\"Active\",\"DirectorStatusDate\":\"\",\"PhysicalAddress\":\"THE BLYDE CRYSTAL LAGOON WILLIOW MA, PRETORIA, PRETORIA, GAUTENG, 0054\"}],\"active_principals\":[{\"FullName\":\"BONGANI NTOKOZO MBONANI\",\"IDNumber\":\"8905155324082\",\"CellularNumber\":\"0827424014\",\"HomeTelephone\":\"\",\"WorkTelephone\":\"0573524076\",\"EmailAddress\":\"\",\"PhysicalAddress\":\"BRONKHOSTSPRUIT ROAD WILLOW MANOR THE BLYDE CRYSTAL LAGOON GAUTENG 0084\",\"PostalAddress\":\"UNIT 1422 THE BLYDE CRYSTAL LAGOON GAUTENG 0084\"}],\"address_history\":[{\"AddressType\":\"Physical\",\"Address\":\"62, KERK STREET, BELFAST, MPUMALANGA\",\"PostalCode\":\"1100\",\"LastUpdatedDate\":\"2014-12-05\"},{\"AddressType\":\"Postal\",\"Address\":\"62, KERK STREET, BELFAST, MPUMALANGA\",\"PostalCode\":\"1100\",\"LastUpdatedDate\":\"2014-12-05\"}],\"change_history\":[{\"EffectiveDate\":\"2024/10/23\",\"ChangeType\":\"CO/CC Annual Return\",\"Details\":\"Company / Close Corporation AR Filing - Web Services : Ref No. : 5419195603\"},{\"EffectiveDate\":\"2023/05/19\",\"ChangeType\":\"AR Restore Into Business (25-24)\",\"Details\":\"Company / Close Corporation AR Filing - Web Services : Ref No. : 5387177909\"},{\"EffectiveDate\":\"2023/04/26\",\"ChangeType\":\"AR IN Deregistration\",\"Details\":\"Annual Return Non Compliance - In Process of Deregistration Last Payment for AR Year/Month is 2020/4. \"},{\"EffectiveDate\":\"2020/06/11\",\"ChangeType\":\"AR Restore Into Business (25-24)\",\"Details\":\"Company / Close Corporation AR Filing - Web Services : Ref No. : 5267176186\"},{\"EffectiveDate\":\"2019/07/29\",\"ChangeType\":\"AR IN Deregistration\",\"Details\":\"Annual Return Non Compliance - In Process of Deregistration Last Payment for AR Year/Month is 2017/4. \"},{\"EffectiveDate\":\"2017/05/11\",\"ChangeType\":\"AR Restore Into Business (25-24)\",\"Details\":\"Company / Close Corporation AR Filing - Web Services : Ref No. : 571406975\"},{\"EffectiveDate\":\"2016/07/16\",\"ChangeType\":\"AR IN Deregistration\",\"Details\":\"Annual Return Non Compliance - In Process of Deregistration No Payment have been made.\"}],\"auditors\":[]}}', '{\"success\":true,\"response_timestamp\":\"2026-06-09T08:29:04.007Z\",\"requestId\":\"93ccf37f-c31a-4e2b-a542-b07a0fe9ed90\",\"user_id\":\"8662\",\"remaining_credits\":186,\"mode\":\"production\",\"service\":\"cipc_company_match\",\"input\":{\"registration_number\":\"2014\\/081962\\/07\",\"reportType\":\"cipc_company_match\",\"mode\":\"production\"},\"results\":{\"success\":true,\"company_name\":\"BLACK APPLE INVESTMENTS (PTY)LTD\",\"trade_name\":\"\",\"previous_name\":\"\",\"registration_number\":\"K2014\\/081962\\/07\",\"registration_date\":\"2014-04-24\",\"business_start_date\":\"2014-04-24\",\"status\":\"In Business\",\"company_type\":\"Private Company\",\"sic\":\"0 - Unknown Data\",\"tax_number\":\"9810918152\",\"vat_number\":\"4200309682\",\"business_description\":\"No Information Available\",\"telephone\":\"\",\"email\":\"\",\"website\":\"\",\"age_of_business\":\"12 Years 2 Months\",\"financial_year_end\":\"February\",\"director_count\":\"1\",\"number_of_enquiries\":\"3\",\"authorised_capital\":\"0.0000\",\"issued_capital\":\"0.0000\",\"physical_address\":\"62, KERK STREET, BELFAST, MPUMALANGA, 1100\",\"postal_address\":\"62, KERK STREET, BELFAST, MPUMALANGA, 1100\",\"directors\":[{\"FullName\":\"BONGANI NTOKOZO MBONANI\",\"FirstName\":\"BONGANI NTOKOZO\",\"Surname\":\"MBONANI\",\"IDNumber\":\"8905155324082\",\"AppointmentDate\":\"2014-04-24\",\"DirectorStatus\":\"Active\",\"DirectorStatusDate\":\"\",\"PhysicalAddress\":\"THE BLYDE CRYSTAL LAGOON WILLIOW MA, PRETORIA, PRETORIA, GAUTENG, 0054\"}],\"active_principals\":[{\"FullName\":\"BONGANI NTOKOZO MBONANI\",\"IDNumber\":\"8905155324082\",\"CellularNumber\":\"0827424014\",\"HomeTelephone\":\"\",\"WorkTelephone\":\"0573524076\",\"EmailAddress\":\"\",\"PhysicalAddress\":\"BRONKHOSTSPRUIT ROAD WILLOW MANOR THE BLYDE CRYSTAL LAGOON GAUTENG 0084\",\"PostalAddress\":\"UNIT 1422 THE BLYDE CRYSTAL LAGOON GAUTENG 0084\"}],\"address_history\":[{\"AddressType\":\"Physical\",\"Address\":\"62, KERK STREET, BELFAST, MPUMALANGA\",\"PostalCode\":\"1100\",\"LastUpdatedDate\":\"2014-12-05\"},{\"AddressType\":\"Postal\",\"Address\":\"62, KERK STREET, BELFAST, MPUMALANGA\",\"PostalCode\":\"1100\",\"LastUpdatedDate\":\"2014-12-05\"}],\"change_history\":[{\"EffectiveDate\":\"2024\\/10\\/23\",\"ChangeType\":\"CO\\/CC Annual Return\",\"Details\":\"Company \\/ Close Corporation AR Filing - Web Services : Ref No. : 5419195603\"},{\"EffectiveDate\":\"2023\\/05\\/19\",\"ChangeType\":\"AR Restore Into Business (25-24)\",\"Details\":\"Company \\/ Close Corporation AR Filing - Web Services : Ref No. : 5387177909\"},{\"EffectiveDate\":\"2023\\/04\\/26\",\"ChangeType\":\"AR IN Deregistration\",\"Details\":\"Annual Return Non Compliance - In Process of Deregistration Last Payment for AR Year\\/Month is 2020\\/4. \"},{\"EffectiveDate\":\"2020\\/06\\/11\",\"ChangeType\":\"AR Restore Into Business (25-24)\",\"Details\":\"Company \\/ Close Corporation AR Filing - Web Services : Ref No. : 5267176186\"},{\"EffectiveDate\":\"2019\\/07\\/29\",\"ChangeType\":\"AR IN Deregistration\",\"Details\":\"Annual Return Non Compliance - In Process of Deregistration Last Payment for AR Year\\/Month is 2017\\/4. \"},{\"EffectiveDate\":\"2017\\/05\\/11\",\"ChangeType\":\"AR Restore Into Business (25-24)\",\"Details\":\"Company \\/ Close Corporation AR Filing - Web Services : Ref No. : 571406975\"},{\"EffectiveDate\":\"2016\\/07\\/16\",\"ChangeType\":\"AR IN Deregistration\",\"Details\":\"Annual Return Non Compliance - In Process of Deregistration No Payment have been made.\"}],\"auditors\":[]}}', NULL, '2026-06-09 06:29:04', '2026-06-09 06:29:04', '2026-06-09 06:29:04');

-- --------------------------------------------------------

--
-- Table structure for table `verification_records`
--

CREATE TABLE `verification_records` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `module` varchar(50) NOT NULL,
  `provider` varchar(50) NOT NULL DEFAULT 'verifynow',
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `provider_reference` varchar(255) DEFAULT NULL,
  `summary` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`summary`)),
  `last_error` text DEFAULT NULL,
  `last_verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `verifiable_type` varchar(255) DEFAULT NULL,
  `verifiable_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `verification_records`
--

INSERT INTO `verification_records` (`id`, `user_id`, `module`, `provider`, `status`, `provider_reference`, `summary`, `last_error`, `last_verified_at`, `created_at`, `updated_at`, `verifiable_type`, `verifiable_id`) VALUES
(1, 2, 'sa_identity', 'verifynow', 'verified', '7fedb92c-f863-4b40-a6a7-f1c5cb2ab8e2', '{\"request_id\":\"7fedb92c-f863-4b40-a6a7-f1c5cb2ab8e2\",\"success\":true,\"mode\":\"production\",\"report_type\":\"said_verification\",\"transaction_id\":\"19163008\",\"status\":\"ID Number Valid\",\"id_number\":\"8905155324082\"}', NULL, '2026-06-09 04:52:23', '2026-06-08 23:49:19', '2026-06-09 04:52:23', NULL, NULL),
(2, 4, 'sa_identity', 'verifynow', 'verified', 'seeded-procurement-sa-id', '{\"seeded\":true}', NULL, '2026-06-08 23:49:19', '2026-06-08 23:49:19', '2026-06-08 23:49:19', NULL, NULL),
(3, 4, 'enterprise', 'verifynow', 'failed', NULL, '{\"request_id\":null,\"success\":false,\"mode\":\"production\",\"transaction_id\":null,\"status\":null,\"company_name\":null,\"registration_number\":null,\"vat_number\":null,\"company_phone\":null,\"enterprise_type\":null,\"enterprise_address\":null}', 'Processing failed', '2026-06-09 01:29:40', '2026-06-09 01:29:34', '2026-06-09 01:29:40', 'App\\Models\\ProcurementProfile', 1),
(4, 6, 'sa_identity', 'verifynow', 'verified', 'c789704f-a0d7-40e8-b03a-3beaf7c91e59', '{\"request_id\":\"c789704f-a0d7-40e8-b03a-3beaf7c91e59\",\"success\":true,\"mode\":\"production\",\"report_type\":\"said_verification\",\"transaction_id\":\"19163002\",\"status\":\"ID Number Valid\",\"id_number\":\"8812205697089\"}', NULL, '2026-06-09 04:50:25', '2026-06-09 04:29:19', '2026-06-09 04:50:25', NULL, NULL),
(5, 6, 'enterprise', 'verifynow', 'verified', '93ccf37f-c31a-4e2b-a542-b07a0fe9ed90', '{\"request_id\":\"93ccf37f-c31a-4e2b-a542-b07a0fe9ed90\",\"success\":true,\"mode\":\"production\",\"transaction_id\":null,\"status\":\"In Business\",\"company_name\":\"BLACK APPLE INVESTMENTS (PTY)LTD\",\"registration_number\":\"K2014\\/081962\\/07\",\"vat_number\":\"4200309682\",\"company_phone\":\"\",\"enterprise_type\":\"Private Company\",\"enterprise_address\":null}', NULL, '2026-06-09 06:29:04', '2026-06-09 04:57:47', '2026-06-09 06:29:04', 'App\\Models\\ProcurementProfile', 2),
(6, 6, 'enterprise_director', 'verifynow', 'verified', '791e0bfb-3d43-4548-82c9-764bb4a5e5d7', '{\"request_id\":\"791e0bfb-3d43-4548-82c9-764bb4a5e5d7\",\"success\":true,\"mode\":\"production\",\"transaction_id\":null,\"status\":null,\"director_name\":\"GABRIEL OFENTSE RABOTLHALE\",\"id_number\":\"8812205697089\",\"position\":null,\"initials\":\"GO\",\"birth_date\":\"1988-12-20\",\"gender\":\"Male\",\"title\":\"Mister\",\"marital_status\":\"Married\",\"privacy_status\":\"ACCEPTS CONTACTS\",\"cellular_number\":\"0725902289\",\"home_telephone\":\"0145532042\",\"work_telephone\":\"0110512800\",\"email_address\":\"GABRIEL.OFT@GMAIL.COM\",\"residential_address\":\"8907 BELARUS STREET SONNEDAL RANDBURG 7742\",\"postal_address\":\"26 BELARUS ST COSMO CITY 2188\",\"employer\":\"FGX STUDIOS\",\"number_of_enquiries\":\"3\",\"companies_count\":null}', NULL, '2026-06-09 05:36:38', '2026-06-09 05:36:26', '2026-06-09 06:07:38', 'App\\Models\\ProcurementDirector', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `applications_job_id_candidate_user_id_unique` (`job_id`,`candidate_user_id`),
  ADD KEY `applications_candidate_user_id_foreign` (`candidate_user_id`);

--
-- Indexes for table `candidate_profiles`
--
ALTER TABLE `candidate_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `candidate_profiles_user_id_unique` (`user_id`);

--
-- Indexes for table `client_profiles`
--
ALTER TABLE `client_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `client_profiles_user_id_unique` (`user_id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `documents_user_id_foreign` (`user_id`),
  ADD KEY `documents_application_id_foreign` (`application_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_user_id_foreign` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_slug_unique` (`slug`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permission_role_role_id_permission_id_unique` (`role_id`,`permission_id`),
  ADD KEY `permission_role_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `platform_settings`
--
ALTER TABLE `platform_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `platform_settings_key_unique` (`key`);

--
-- Indexes for table `procurement_directors`
--
ALTER TABLE `procurement_directors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `procurement_directors_procurement_profile_id_foreign` (`procurement_profile_id`);

--
-- Indexes for table `procurement_profiles`
--
ALTER TABLE `procurement_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `procurement_profiles_user_id_unique` (`user_id`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `profiles_user_id_unique` (`user_id`),
  ADD UNIQUE KEY `profiles_id_number_unique` (`id_number`),
  ADD UNIQUE KEY `profiles_passport_number_unique` (`passport_number`);

--
-- Indexes for table `recruitment_profiles`
--
ALTER TABLE `recruitment_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `recruitment_profiles_user_id_unique` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`),
  ADD UNIQUE KEY `roles_slug_unique` (`slug`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- Indexes for table `verification_attempts`
--
ALTER TABLE `verification_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `verification_attempts_verification_record_id_foreign` (`verification_record_id`);

--
-- Indexes for table `verification_records`
--
ALTER TABLE `verification_records`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `verification_records_user_id_module_unique` (`user_id`,`module`),
  ADD KEY `verification_records_verifiable_type_verifiable_id_index` (`verifiable_type`,`verifiable_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `candidate_profiles`
--
ALTER TABLE `candidate_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `client_profiles`
--
ALTER TABLE `client_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `permission_role`
--
ALTER TABLE `permission_role`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `platform_settings`
--
ALTER TABLE `platform_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `procurement_directors`
--
ALTER TABLE `procurement_directors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `procurement_profiles`
--
ALTER TABLE `procurement_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `recruitment_profiles`
--
ALTER TABLE `recruitment_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `verification_attempts`
--
ALTER TABLE `verification_attempts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `verification_records`
--
ALTER TABLE `verification_records`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_candidate_user_id_foreign` FOREIGN KEY (`candidate_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `applications_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `candidate_profiles`
--
ALTER TABLE `candidate_profiles`
  ADD CONSTRAINT `candidate_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `client_profiles`
--
ALTER TABLE `client_profiles`
  ADD CONSTRAINT `client_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_application_id_foreign` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `documents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `jobs`
--
ALTER TABLE `jobs`
  ADD CONSTRAINT `jobs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `procurement_directors`
--
ALTER TABLE `procurement_directors`
  ADD CONSTRAINT `procurement_directors_procurement_profile_id_foreign` FOREIGN KEY (`procurement_profile_id`) REFERENCES `procurement_profiles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `procurement_profiles`
--
ALTER TABLE `procurement_profiles`
  ADD CONSTRAINT `procurement_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `recruitment_profiles`
--
ALTER TABLE `recruitment_profiles`
  ADD CONSTRAINT `recruitment_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `verification_attempts`
--
ALTER TABLE `verification_attempts`
  ADD CONSTRAINT `verification_attempts_verification_record_id_foreign` FOREIGN KEY (`verification_record_id`) REFERENCES `verification_records` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `verification_records`
--
ALTER TABLE `verification_records`
  ADD CONSTRAINT `verification_records_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
