-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 12, 2026 at 08:28 AM
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
(1, 2, 'Procurement Administrator', 'Mid-level', 'Available', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Seeded candidate account for Akhani Connect testing.', NULL, '2026-06-12 04:28:24', '2026-06-12 04:28:24');

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
(1, 5, 'Akhani Client Group', 'Nandi Dlamini', '0515550101', 'All procurement records', '2026-06-12 04:28:24', '2026-06-12 04:28:24');

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
  `display_name` varchar(255) DEFAULT NULL,
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
(1, 3, 'Procurement Administrator', 'Johannesburg', 'Gauteng', 'Permanent', '<p>A growing supply chain business is looking for a Procurement Administrator to support vendor onboarding, purchase order tracking, and reporting for internal stakeholders.</p><h4>Key Responsibilities</h4><ul><li>Capture purchase orders and maintain supplier records.</li><li>Follow up on quotations, delivery dates, and outstanding paperwork.</li><li>Prepare weekly procurement status reports for management.</li></ul><h4>Minimum Requirements</h4><ul><li>2+ years of procurement or administration experience.</li><li>Strong Excel and document management skills.</li><li>Comfortable working in a fast-paced operations environment.</li></ul>', 'published', '2026-06-12 04:28:26', '2026-06-12 04:28:26', '2026-06-12 04:28:26'),
(2, 3, 'Site Quantity Surveyor', 'Gqeberha', 'Eastern Cape', 'Contract', '<p>A construction contractor requires a Site Quantity Surveyor to manage project cost tracking, subcontractor measurements, and claims support on active building projects.</p><h4>Key Responsibilities</h4><ul><li>Measure work completed on site and prepare payment certificates.</li><li>Track variations, material usage, and subcontractor claims.</li><li>Assist with cost reports and final account preparation.</li></ul><h4>Minimum Requirements</h4><ul><li>National Diploma or Degree in Quantity Surveying.</li><li>Experience on building or civil projects.</li><li>Strong attention to detail and site coordination ability.</li></ul>', 'published', '2026-06-12 04:28:26', '2026-06-12 04:28:26', '2026-06-12 04:28:26'),
(3, 3, 'Warehouse Supervisor', 'Bloemfontein', 'Free State', 'Permanent', '<p>An established logistics operator is hiring a Warehouse Supervisor to lead daily warehouse activities, inventory control, and dispatch coordination.</p><h4>Key Responsibilities</h4><ul><li>Supervise receiving, picking, packing, and dispatch teams.</li><li>Monitor stock movement and investigate inventory variances.</li><li>Ensure warehouse safety and housekeeping standards are maintained.</li></ul><h4>Minimum Requirements</h4><ul><li>3+ years of warehousing or distribution supervision experience.</li><li>Experience with inventory systems and stock reconciliation.</li><li>Strong people management and reporting skills.</li></ul>', 'published', '2026-06-12 04:28:26', '2026-06-12 04:28:26', '2026-06-12 04:28:26'),
(4, 3, 'HR Officer', 'Durban', 'KwaZulu-Natal', 'Permanent', '<p>A regional services company is seeking an HR Officer to support recruitment administration, onboarding, leave management, and employee relations processes.</p><h4>Key Responsibilities</h4><ul><li>Coordinate interview scheduling, offers, and onboarding packs.</li><li>Maintain leave records and support payroll-related queries.</li><li>Assist with employee relations documentation and policy communication.</li></ul><h4>Minimum Requirements</h4><ul><li>Diploma or Degree in Human Resources or related field.</li><li>2+ years of generalist HR administration experience.</li><li>Good understanding of South African labour practices.</li></ul>', 'published', '2026-06-12 04:28:26', '2026-06-12 04:28:26', '2026-06-12 04:28:26'),
(5, 3, 'Junior IT Support Technician', 'Polokwane', 'Limpopo', 'Permanent', '<p>A technology support business is looking for a Junior IT Support Technician to assist users with hardware, software, and connectivity issues across branch offices.</p><h4>Key Responsibilities</h4><ul><li>Log and resolve first-line support tickets.</li><li>Set up workstations, printers, and user accounts.</li><li>Escalate unresolved issues and maintain support documentation.</li></ul><h4>Minimum Requirements</h4><ul><li>Relevant IT certificate or diploma.</li><li>Basic troubleshooting knowledge across Windows and networks.</li><li>Good communication and customer service skills.</li></ul>', 'published', '2026-06-12 04:28:26', '2026-06-12 04:28:26', '2026-06-12 04:28:26'),
(6, 3, 'Operations Coordinator', 'Nelspruit', 'Mpumalanga', 'Permanent', '<p>A field services company needs an Operations Coordinator to manage scheduling, customer communication, and performance tracking across multiple teams.</p><h4>Key Responsibilities</h4><ul><li>Coordinate technician schedules and route planning.</li><li>Maintain service logs and update customers on progress.</li><li>Compile daily and weekly operational performance reports.</li></ul><h4>Minimum Requirements</h4><ul><li>Experience in operations, logistics, or scheduling.</li><li>Excellent organisational and communication skills.</li><li>Strong administrative ability and attention to detail.</li></ul>', 'published', '2026-06-12 04:28:26', '2026-06-12 04:28:26', '2026-06-12 04:28:26'),
(7, 3, 'Safety Officer', 'Kimberley', 'Northern Cape', 'Contract', '<p>A mining support contractor is searching for a Safety Officer to drive site compliance, toolbox talks, inspections, and incident follow-up.</p><h4>Key Responsibilities</h4><ul><li>Conduct daily site inspections and risk observations.</li><li>Maintain safety files, permits, and compliance registers.</li><li>Support incident investigations and corrective action tracking.</li></ul><h4>Minimum Requirements</h4><ul><li>Relevant safety qualification and registration where required.</li><li>Experience in industrial, mining, or construction environments.</li><li>Strong reporting and stakeholder engagement skills.</li></ul>', 'published', '2026-06-12 04:28:26', '2026-06-12 04:28:26', '2026-06-12 04:28:26'),
(8, 3, 'Sales Representative', 'Mahikeng', 'North West', 'Permanent', '<p>A fast-moving consumer goods distributor is hiring a Sales Representative to grow customer relationships and achieve monthly sales targets in the region.</p><h4>Key Responsibilities</h4><ul><li>Visit customers, present promotions, and secure orders.</li><li>Maintain route plans and submit accurate sales reports.</li><li>Support merchandising and customer service activities.</li></ul><h4>Minimum Requirements</h4><ul><li>Proven field sales experience.</li><li>Valid driver’s licence and willingness to travel locally.</li><li>Good communication and target-driven mindset.</li></ul>', 'published', '2026-06-12 04:28:26', '2026-06-12 04:28:26', '2026-06-12 04:28:26'),
(9, 3, 'Financial Accountant', 'Cape Town', 'Western Cape', 'Permanent', '<p>A growing finance team requires a Financial Accountant to manage month-end reporting, reconciliations, compliance support, and audit preparation.</p><h4>Key Responsibilities</h4><ul><li>Prepare journals, reconciliations, and monthly financial reports.</li><li>Support statutory compliance and audit document preparation.</li><li>Analyse variances and provide finance insights to management.</li></ul><h4>Minimum Requirements</h4><ul><li>Completed accounting qualification.</li><li>Experience in month-end reporting and reconciliations.</li><li>Strong Excel skills and attention to accuracy.</li></ul>', 'published', '2026-06-12 04:28:26', '2026-06-12 04:28:26', '2026-06-12 04:28:26'),
(10, 3, 'Receptionist and Office Administrator', 'Johannesburg', 'Gauteng', 'Permanent', '<p>A professional services office is seeking a Receptionist and Office Administrator to manage front-desk operations and day-to-day office support.</p><h4>Key Responsibilities</h4><ul><li>Welcome visitors and handle incoming calls professionally.</li><li>Manage meeting room bookings, courier requests, and office supplies.</li><li>Support filing, correspondence, and general administration.</li></ul><h4>Minimum Requirements</h4><ul><li>Previous reception or office administration experience.</li><li>Professional communication and presentation skills.</li><li>Good organisational skills and confidence with office systems.</li></ul>', 'published', '2026-06-12 04:28:26', '2026-06-12 04:28:26', '2026-06-12 04:28:26'),
(11, 3, 'Mechanical Maintenance Fitter', 'Middelburg', 'Mpumalanga', 'Contract', '<p>An industrial plant is looking for a Mechanical Maintenance Fitter to assist with preventative maintenance, breakdown support, and shutdown work.</p><h4>Key Responsibilities</h4><ul><li>Carry out planned maintenance on production equipment.</li><li>Respond to breakdowns and assist with root-cause analysis.</li><li>Complete maintenance documentation and safety checks.</li></ul><h4>Minimum Requirements</h4><ul><li>Trade-tested fitter qualification.</li><li>Experience in plant or heavy industrial maintenance.</li><li>Ability to work shifts or shutdown periods when required.</li></ul>', 'published', '2026-06-12 04:28:26', '2026-06-12 04:28:26', '2026-06-12 04:28:26'),
(12, 3, 'Customer Service Consultant', 'Pietermaritzburg', 'KwaZulu-Natal', 'Permanent', '<p>A customer-focused business is recruiting a Customer Service Consultant to handle inbound queries, resolve issues, and maintain service excellence.</p><h4>Key Responsibilities</h4><ul><li>Respond to customer queries via phone and email.</li><li>Resolve service issues and escalate complex matters appropriately.</li><li>Maintain accurate customer records and interaction notes.</li></ul><h4>Minimum Requirements</h4><ul><li>Experience in customer service or call centre support.</li><li>Clear written and verbal communication skills.</li><li>Calm problem-solving approach and attention to detail.</li></ul>', 'published', '2026-06-12 04:28:26', '2026-06-12 04:28:26', '2026-06-12 04:28:26');

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
(30, '2026_06_09_083000_add_profile_fields_to_procurement_directors_table', 1),
(31, '2026_06_09_120000_add_display_name_to_documents_table', 1),
(32, '2026_06_09_130000_create_user_activities_table', 1);

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
(1, 'View dashboard', 'dashboard.view', 'Access role dashboard pages.', '2026-06-12 04:28:24', '2026-06-12 04:28:24'),
(2, 'View profile', 'profile.view', 'View own account profile.', '2026-06-12 04:28:24', '2026-06-12 04:28:24'),
(3, 'Update profile', 'profile.update', 'Update own account profile.', '2026-06-12 04:28:24', '2026-06-12 04:28:24'),
(4, 'Manage users', 'users.manage', 'Create, update, and manage platform users.', '2026-06-12 04:28:24', '2026-06-12 04:28:24'),
(5, 'Manage roles', 'roles.manage', 'Manage system roles and access assignments.', '2026-06-12 04:28:24', '2026-06-12 04:28:24'),
(6, 'Manage settings', 'settings.manage', 'Update platform-level settings.', '2026-06-12 04:28:24', '2026-06-12 04:28:24'),
(7, 'View reports', 'reports.view', 'Access reporting pages.', '2026-06-12 04:28:24', '2026-06-12 04:28:24'),
(8, 'Manage clients', 'clients.manage', 'Create and manage client accounts.', '2026-06-12 04:28:24', '2026-06-12 04:28:24');

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
(1, 1, 1, '2026-06-12 04:28:24', '2026-06-12 04:28:24'),
(2, 1, 2, '2026-06-12 04:28:24', '2026-06-12 04:28:24'),
(3, 1, 3, '2026-06-12 04:28:24', '2026-06-12 04:28:24'),
(4, 1, 4, '2026-06-12 04:28:24', '2026-06-12 04:28:24'),
(5, 1, 5, '2026-06-12 04:28:24', '2026-06-12 04:28:24'),
(6, 1, 6, '2026-06-12 04:28:24', '2026-06-12 04:28:24'),
(7, 1, 7, '2026-06-12 04:28:24', '2026-06-12 04:28:24'),
(8, 1, 8, '2026-06-12 04:28:24', '2026-06-12 04:28:24'),
(9, 2, 1, '2026-06-12 04:28:24', '2026-06-12 04:28:24'),
(10, 2, 2, '2026-06-12 04:28:24', '2026-06-12 04:28:24'),
(11, 2, 3, '2026-06-12 04:28:24', '2026-06-12 04:28:24'),
(12, 3, 1, '2026-06-12 04:28:24', '2026-06-12 04:28:24'),
(13, 3, 2, '2026-06-12 04:28:24', '2026-06-12 04:28:24'),
(14, 3, 3, '2026-06-12 04:28:24', '2026-06-12 04:28:24'),
(15, 4, 1, '2026-06-12 04:28:24', '2026-06-12 04:28:24'),
(16, 4, 2, '2026-06-12 04:28:24', '2026-06-12 04:28:24'),
(17, 4, 3, '2026-06-12 04:28:24', '2026-06-12 04:28:24'),
(18, 5, 1, '2026-06-12 04:28:24', '2026-06-12 04:28:24'),
(19, 5, 2, '2026-06-12 04:28:24', '2026-06-12 04:28:24'),
(20, 5, 3, '2026-06-12 04:28:24', '2026-06-12 04:28:24');

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
(1, 4, 'Akhani Procurement Services', '201408196207', '4123456789', '0315550101', NULL, NULL, NULL, NULL, NULL, 100, '2026-06-12 04:28:24', '2026-06-12 04:28:24');

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
(1, 1, NULL, 'Female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Johannesburg', 'Gauteng', NULL, 'ZA', 1, '2026-06-12 04:28:24', 1, '2026-06-12 04:28:24', '2026-06-12 04:28:24'),
(2, 2, NULL, 'Male', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pretoria', 'Gauteng', NULL, 'ZA', 1, '2026-06-12 04:28:24', 1, '2026-06-12 04:28:24', '2026-06-12 04:28:24'),
(3, 3, NULL, 'Female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Cape Town', 'Western Cape', NULL, 'ZA', 1, '2026-06-12 04:28:24', 1, '2026-06-12 04:28:24', '2026-06-12 04:28:24'),
(4, 4, NULL, 'Female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Durban', 'KwaZulu-Natal', NULL, 'ZA', 1, '2026-06-12 04:28:24', 1, '2026-06-12 04:28:24', '2026-06-12 04:28:24'),
(5, 5, NULL, 'Female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Bloemfontein', 'Free State', NULL, 'ZA', 1, '2026-06-12 04:28:24', 1, '2026-06-12 04:28:24', '2026-06-12 04:28:24');

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
(1, 3, 'Akhani Talent', '2026/000001/07', 'https://akhaniconnect.co.za', '0215550101', 'Refilwe Naidoo', '2026-06-12 04:28:24', '2026-06-12 04:28:24');

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
(1, 'Superadmin', 'superadmin', 'Platform owner with full administrative access.', '2026-06-12 04:28:24', '2026-06-12 04:28:24'),
(2, 'Candidate', 'candidate', 'Candidate account for job applications and profile management.', '2026-06-12 04:28:24', '2026-06-12 04:28:24'),
(3, 'Recruitment', 'recruitment', 'Recruitment account for managing candidates and recruitment workflows.', '2026-06-12 04:28:24', '2026-06-12 04:28:24'),
(4, 'Procurement', 'procurement', 'Procurement account for verification and enterprise workflows.', '2026-06-12 04:28:24', '2026-06-12 04:28:24'),
(5, 'Client', 'client', 'Client account with controlled access to procurement records.', '2026-06-12 04:28:24', '2026-06-12 04:28:24');

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
(1, 1, 'Aisha', 'Nkosi', 'admin@akhaniconnect.co.za', '0820000001', '2026-06-12 04:28:24', '2026-06-12 04:28:24', '$2y$12$DEjRrJbbfzyBvrDfFySBo..oJBf17Rsd2CfV5ly7W4f/BlZ50FFkq', 'active', NULL, NULL, '2026-06-12 04:28:24', '2026-06-12 04:28:24'),
(2, 2, 'Themba', 'Mokoena', 'candidate@akhaniconnect.co.za', '0820000002', '2026-06-12 04:28:24', '2026-06-12 04:28:24', '$2y$12$ojuzJPYrebKzEZmAZh.hT.bYEg.whTs1CdzqkyOgj7388iZC3JYYC', 'active', NULL, NULL, '2026-06-12 04:28:24', '2026-06-12 04:28:24'),
(3, 3, 'Refilwe', 'Naidoo', 'recruitment@akhaniconnect.co.za', '0820000003', '2026-06-12 04:28:24', '2026-06-12 04:28:24', '$2y$12$A4efsUnLnWt6kpQiv/usX.pJfumb0Rss1eg0YAvKQZrIMjiWQbZtm', 'active', NULL, NULL, '2026-06-12 04:28:24', '2026-06-12 04:28:24'),
(4, 4, 'Lerato', 'Mabena', 'procurement@akhaniconnect.co.za', '0820000004', '2026-06-12 04:28:24', '2026-06-12 04:28:24', '$2y$12$WIR0L8nTsd9SVed4hfa93uJRLUmdtP235u3eNFtH1S973S6Z6MC2q', 'active', NULL, NULL, '2026-06-12 04:28:24', '2026-06-12 04:28:24'),
(5, 5, 'Nandi', 'Dlamini', 'client@akhaniconnect.co.za', '0820000005', '2026-06-12 04:28:24', '2026-06-12 04:28:24', '$2y$12$tEzXGcEZ7bU/cszoGXsu4OPIws4XXtqzynCBjR1ILaTejfXjybMiy', 'active', NULL, NULL, '2026-06-12 04:28:24', '2026-06-12 04:28:24');

-- --------------------------------------------------------

--
-- Table structure for table `user_activities`
--

CREATE TABLE `user_activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `activity_type` varchar(255) NOT NULL DEFAULT 'page_view',
  `method` varchar(10) DEFAULT NULL,
  `route_name` varchar(255) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `country_code` varchar(2) DEFAULT NULL,
  `country_name` varchar(255) DEFAULT NULL,
  `browser` varchar(255) DEFAULT NULL,
  `platform` varchar(255) DEFAULT NULL,
  `device_type` varchar(255) DEFAULT NULL,
  `response_status` smallint(5) UNSIGNED DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `occurred_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, 2, 'sa_identity', 'verifynow', 'verified', 'seeded-candidate-sa-id', '{\"seeded\":true}', NULL, '2026-06-12 04:28:24', '2026-06-12 04:28:24', '2026-06-12 04:28:24', NULL, NULL),
(2, 4, 'sa_identity', 'verifynow', 'verified', 'seeded-procurement-sa-id', '{\"seeded\":true}', NULL, '2026-06-12 04:28:24', '2026-06-12 04:28:24', '2026-06-12 04:28:24', NULL, NULL);

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
-- Indexes for table `user_activities`
--
ALTER TABLE `user_activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_activities_user_id_occurred_at_index` (`user_id`,`occurred_at`),
  ADD KEY `user_activities_route_name_occurred_at_index` (`route_name`,`occurred_at`),
  ADD KEY `user_activities_activity_type_occurred_at_index` (`activity_type`,`occurred_at`);

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `procurement_profiles`
--
ALTER TABLE `procurement_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_activities`
--
ALTER TABLE `user_activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `verification_attempts`
--
ALTER TABLE `verification_attempts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `verification_records`
--
ALTER TABLE `verification_records`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
-- Constraints for table `user_activities`
--
ALTER TABLE `user_activities`
  ADD CONSTRAINT `user_activities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

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
