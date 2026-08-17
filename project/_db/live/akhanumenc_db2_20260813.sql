/*
 Navicat Premium Data Transfer

 Source Server         : akhaniconnect.co.za
 Source Server Type    : MySQL
 Source Server Version : 101118 (10.11.18-MariaDB-deb12+trixie+xneelo)
 Source Host           : sql58.jnb1.host-h.net:3306
 Source Schema         : akhanumenc_db2

 Target Server Type    : MySQL
 Target Server Version : 101118 (10.11.18-MariaDB-deb12+trixie+xneelo)
 File Encoding         : 65001

 Date: 13/08/2026 11:44:35
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for applications
-- ----------------------------
DROP TABLE IF EXISTS `applications`;
CREATE TABLE `applications`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `job_id` bigint UNSIGNED NOT NULL,
  `candidate_user_id` bigint UNSIGNED NOT NULL,
  `status` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'submitted',
  `cover_letter` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `reviewer_notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `applied_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `applications_job_id_candidate_user_id_unique`(`job_id` ASC, `candidate_user_id` ASC) USING BTREE,
  INDEX `applications_candidate_user_id_foreign`(`candidate_user_id` ASC) USING BTREE,
  CONSTRAINT `applications_candidate_user_id_foreign` FOREIGN KEY (`candidate_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `applications_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of applications
-- ----------------------------

-- ----------------------------
-- Table structure for candidate_profiles
-- ----------------------------
DROP TABLE IF EXISTS `candidate_profiles`;
CREATE TABLE `candidate_profiles`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `job_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `experience_level` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `employment_status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `notice_period` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `willing_to_relocate` tinyint(1) NULL DEFAULT NULL,
  `job_industry` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `preferred_employment_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `salary_expectation` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `education_level` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `education` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `certifications` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `experience` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `skills` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `bio` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `cv_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `candidate_profiles_user_id_unique`(`user_id` ASC) USING BTREE,
  CONSTRAINT `candidate_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of candidate_profiles
-- ----------------------------
INSERT INTO `candidate_profiles` VALUES (1, 2, 'Procurement Administrator', 'Mid-level', 'Available', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Seeded candidate account for Akhani Connect testing.', NULL, '2026-06-15 04:33:03', '2026-06-15 04:33:03');

-- ----------------------------
-- Table structure for client_profiles
-- ----------------------------
DROP TABLE IF EXISTS `client_profiles`;
CREATE TABLE `client_profiles`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `company_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `contact_person_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `company_phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `access_scope` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `client_profiles_user_id_unique`(`user_id` ASC) USING BTREE,
  CONSTRAINT `client_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of client_profiles
-- ----------------------------
INSERT INTO `client_profiles` VALUES (1, 5, 'Akhani Client Group', 'Nandi Dlamini', '0515550101', 'All procurement records', '2026-06-15 04:33:03', '2026-06-15 04:33:03');

-- ----------------------------
-- Table structure for documents
-- ----------------------------
DROP TABLE IF EXISTS `documents`;
CREATE TABLE `documents`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `application_id` bigint UNSIGNED NULL DEFAULT NULL,
  `category` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `original_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` bigint UNSIGNED NOT NULL,
  `status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'uploaded',
  `uploaded_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `documents_user_id_foreign`(`user_id` ASC) USING BTREE,
  INDEX `documents_application_id_foreign`(`application_id` ASC) USING BTREE,
  CONSTRAINT `documents_application_id_foreign` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `documents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of documents
-- ----------------------------

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for jobs
-- ----------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `province` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `employment_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `jobs_user_id_foreign`(`user_id` ASC) USING BTREE,
  CONSTRAINT `jobs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of jobs
-- ----------------------------
INSERT INTO `jobs` VALUES (1, 3, 'Procurement Administrator', 'Johannesburg', 'Gauteng', 'Permanent', '<p>A growing supply chain business is looking for a Procurement Administrator to support vendor onboarding, purchase order tracking, and reporting for internal stakeholders.</p><h4>Key Responsibilities</h4><ul><li>Capture purchase orders and maintain supplier records.</li><li>Follow up on quotations, delivery dates, and outstanding paperwork.</li><li>Prepare weekly procurement status reports for management.</li></ul><h4>Minimum Requirements</h4><ul><li>2+ years of procurement or administration experience.</li><li>Strong Excel and document management skills.</li><li>Comfortable working in a fast-paced operations environment.</li></ul>', 'published', '2026-06-15 04:33:04', '2026-06-15 04:33:04', '2026-06-15 04:33:04');
INSERT INTO `jobs` VALUES (2, 3, 'Site Quantity Surveyor', 'Gqeberha', 'Eastern Cape', 'Contract', '<p>A construction contractor requires a Site Quantity Surveyor to manage project cost tracking, subcontractor measurements, and claims support on active building projects.</p><h4>Key Responsibilities</h4><ul><li>Measure work completed on site and prepare payment certificates.</li><li>Track variations, material usage, and subcontractor claims.</li><li>Assist with cost reports and final account preparation.</li></ul><h4>Minimum Requirements</h4><ul><li>National Diploma or Degree in Quantity Surveying.</li><li>Experience on building or civil projects.</li><li>Strong attention to detail and site coordination ability.</li></ul>', 'published', '2026-06-15 04:33:04', '2026-06-15 04:33:04', '2026-06-15 04:33:04');
INSERT INTO `jobs` VALUES (3, 3, 'Warehouse Supervisor', 'Bloemfontein', 'Free State', 'Permanent', '<p>An established logistics operator is hiring a Warehouse Supervisor to lead daily warehouse activities, inventory control, and dispatch coordination.</p><h4>Key Responsibilities</h4><ul><li>Supervise receiving, picking, packing, and dispatch teams.</li><li>Monitor stock movement and investigate inventory variances.</li><li>Ensure warehouse safety and housekeeping standards are maintained.</li></ul><h4>Minimum Requirements</h4><ul><li>3+ years of warehousing or distribution supervision experience.</li><li>Experience with inventory systems and stock reconciliation.</li><li>Strong people management and reporting skills.</li></ul>', 'published', '2026-06-15 04:33:04', '2026-06-15 04:33:04', '2026-06-15 04:33:04');
INSERT INTO `jobs` VALUES (4, 3, 'HR Officer', 'Durban', 'KwaZulu-Natal', 'Permanent', '<p>A regional services company is seeking an HR Officer to support recruitment administration, onboarding, leave management, and employee relations processes.</p><h4>Key Responsibilities</h4><ul><li>Coordinate interview scheduling, offers, and onboarding packs.</li><li>Maintain leave records and support payroll-related queries.</li><li>Assist with employee relations documentation and policy communication.</li></ul><h4>Minimum Requirements</h4><ul><li>Diploma or Degree in Human Resources or related field.</li><li>2+ years of generalist HR administration experience.</li><li>Good understanding of South African labour practices.</li></ul>', 'published', '2026-06-15 04:33:04', '2026-06-15 04:33:04', '2026-06-15 04:33:04');
INSERT INTO `jobs` VALUES (5, 3, 'Junior IT Support Technician', 'Polokwane', 'Limpopo', 'Permanent', '<p>A technology support business is looking for a Junior IT Support Technician to assist users with hardware, software, and connectivity issues across branch offices.</p><h4>Key Responsibilities</h4><ul><li>Log and resolve first-line support tickets.</li><li>Set up workstations, printers, and user accounts.</li><li>Escalate unresolved issues and maintain support documentation.</li></ul><h4>Minimum Requirements</h4><ul><li>Relevant IT certificate or diploma.</li><li>Basic troubleshooting knowledge across Windows and networks.</li><li>Good communication and customer service skills.</li></ul>', 'published', '2026-06-15 04:33:04', '2026-06-15 04:33:04', '2026-06-15 04:33:04');
INSERT INTO `jobs` VALUES (6, 3, 'Operations Coordinator', 'Nelspruit', 'Mpumalanga', 'Permanent', '<p>A field services company needs an Operations Coordinator to manage scheduling, customer communication, and performance tracking across multiple teams.</p><h4>Key Responsibilities</h4><ul><li>Coordinate technician schedules and route planning.</li><li>Maintain service logs and update customers on progress.</li><li>Compile daily and weekly operational performance reports.</li></ul><h4>Minimum Requirements</h4><ul><li>Experience in operations, logistics, or scheduling.</li><li>Excellent organisational and communication skills.</li><li>Strong administrative ability and attention to detail.</li></ul>', 'published', '2026-06-15 04:33:04', '2026-06-15 04:33:04', '2026-06-15 04:33:04');
INSERT INTO `jobs` VALUES (7, 3, 'Safety Officer', 'Kimberley', 'Northern Cape', 'Contract', '<p>A mining support contractor is searching for a Safety Officer to drive site compliance, toolbox talks, inspections, and incident follow-up.</p><h4>Key Responsibilities</h4><ul><li>Conduct daily site inspections and risk observations.</li><li>Maintain safety files, permits, and compliance registers.</li><li>Support incident investigations and corrective action tracking.</li></ul><h4>Minimum Requirements</h4><ul><li>Relevant safety qualification and registration where required.</li><li>Experience in industrial, mining, or construction environments.</li><li>Strong reporting and stakeholder engagement skills.</li></ul>', 'published', '2026-06-15 04:33:04', '2026-06-15 04:33:04', '2026-06-15 04:33:04');
INSERT INTO `jobs` VALUES (8, 3, 'Sales Representative', 'Mahikeng', 'North West', 'Permanent', '<p>A fast-moving consumer goods distributor is hiring a Sales Representative to grow customer relationships and achieve monthly sales targets in the region.</p><h4>Key Responsibilities</h4><ul><li>Visit customers, present promotions, and secure orders.</li><li>Maintain route plans and submit accurate sales reports.</li><li>Support merchandising and customer service activities.</li></ul><h4>Minimum Requirements</h4><ul><li>Proven field sales experience.</li><li>Valid driver’s licence and willingness to travel locally.</li><li>Good communication and target-driven mindset.</li></ul>', 'published', '2026-06-15 04:33:04', '2026-06-15 04:33:04', '2026-06-15 04:33:04');
INSERT INTO `jobs` VALUES (9, 3, 'Financial Accountant', 'Cape Town', 'Western Cape', 'Permanent', '<p>A growing finance team requires a Financial Accountant to manage month-end reporting, reconciliations, compliance support, and audit preparation.</p><h4>Key Responsibilities</h4><ul><li>Prepare journals, reconciliations, and monthly financial reports.</li><li>Support statutory compliance and audit document preparation.</li><li>Analyse variances and provide finance insights to management.</li></ul><h4>Minimum Requirements</h4><ul><li>Completed accounting qualification.</li><li>Experience in month-end reporting and reconciliations.</li><li>Strong Excel skills and attention to accuracy.</li></ul>', 'published', '2026-06-15 04:33:04', '2026-06-15 04:33:04', '2026-06-15 04:33:04');
INSERT INTO `jobs` VALUES (10, 3, 'Receptionist and Office Administrator', 'Johannesburg', 'Gauteng', 'Permanent', '<p>A professional services office is seeking a Receptionist and Office Administrator to manage front-desk operations and day-to-day office support.</p><h4>Key Responsibilities</h4><ul><li>Welcome visitors and handle incoming calls professionally.</li><li>Manage meeting room bookings, courier requests, and office supplies.</li><li>Support filing, correspondence, and general administration.</li></ul><h4>Minimum Requirements</h4><ul><li>Previous reception or office administration experience.</li><li>Professional communication and presentation skills.</li><li>Good organisational skills and confidence with office systems.</li></ul>', 'published', '2026-06-15 04:33:04', '2026-06-15 04:33:04', '2026-06-15 04:33:04');
INSERT INTO `jobs` VALUES (11, 3, 'Mechanical Maintenance Fitter', 'Middelburg', 'Mpumalanga', 'Contract', '<p>An industrial plant is looking for a Mechanical Maintenance Fitter to assist with preventative maintenance, breakdown support, and shutdown work.</p><h4>Key Responsibilities</h4><ul><li>Carry out planned maintenance on production equipment.</li><li>Respond to breakdowns and assist with root-cause analysis.</li><li>Complete maintenance documentation and safety checks.</li></ul><h4>Minimum Requirements</h4><ul><li>Trade-tested fitter qualification.</li><li>Experience in plant or heavy industrial maintenance.</li><li>Ability to work shifts or shutdown periods when required.</li></ul>', 'published', '2026-06-15 04:33:04', '2026-06-15 04:33:04', '2026-06-15 04:33:04');
INSERT INTO `jobs` VALUES (12, 3, 'Customer Service Consultant', 'Pietermaritzburg', 'KwaZulu-Natal', 'Permanent', '<p>A customer-focused business is recruiting a Customer Service Consultant to handle inbound queries, resolve issues, and maintain service excellence.</p><h4>Key Responsibilities</h4><ul><li>Respond to customer queries via phone and email.</li><li>Resolve service issues and escalate complex matters appropriately.</li><li>Maintain accurate customer records and interaction notes.</li></ul><h4>Minimum Requirements</h4><ul><li>Experience in customer service or call centre support.</li><li>Clear written and verbal communication skills.</li><li>Calm problem-solving approach and attention to detail.</li></ul>', 'published', '2026-06-15 04:33:04', '2026-06-15 04:33:04', '2026-06-15 04:33:04');
INSERT INTO `jobs` VALUES (13, 3, 'Investment Manager', 'Pretoria', 'Gauteng', 'Contract', '<p>We are looking for an Investment Manager with the following qualifications and experience.&nbsp;</p>', 'draft', NULL, '2026-07-15 16:42:02', '2026-07-15 16:42:02');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 33 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2014_10_12_100000_create_password_reset_tokens_table', 1);
INSERT INTO `migrations` VALUES (3, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO `migrations` VALUES (4, '2019_12_14_000001_create_personal_access_tokens_table', 1);
INSERT INTO `migrations` VALUES (5, '2026_06_08_070000_create_roles_table', 1);
INSERT INTO `migrations` VALUES (6, '2026_06_08_070050_add_role_foreign_key_to_users_table', 1);
INSERT INTO `migrations` VALUES (7, '2026_06_08_070100_create_permissions_table', 1);
INSERT INTO `migrations` VALUES (8, '2026_06_08_070200_create_permission_role_table', 1);
INSERT INTO `migrations` VALUES (9, '2026_06_08_070300_create_profiles_table', 1);
INSERT INTO `migrations` VALUES (10, '2026_06_08_070400_create_candidate_profiles_table', 1);
INSERT INTO `migrations` VALUES (11, '2026_06_08_070500_create_recruitment_profiles_table', 1);
INSERT INTO `migrations` VALUES (12, '2026_06_08_070600_create_procurement_profiles_table', 1);
INSERT INTO `migrations` VALUES (13, '2026_06_08_070700_create_client_profiles_table', 1);
INSERT INTO `migrations` VALUES (14, '2026_06_08_071000_create_procurement_directors_table', 1);
INSERT INTO `migrations` VALUES (15, '2026_06_08_071100_create_documents_table', 1);
INSERT INTO `migrations` VALUES (16, '2026_06_08_071200_create_verification_records_table', 1);
INSERT INTO `migrations` VALUES (17, '2026_06_08_071300_create_verification_attempts_table', 1);
INSERT INTO `migrations` VALUES (18, '2026_06_08_072000_create_jobs_table', 1);
INSERT INTO `migrations` VALUES (19, '2026_06_08_072100_create_applications_table', 1);
INSERT INTO `migrations` VALUES (20, '2026_06_08_072200_create_notifications_table', 1);
INSERT INTO `migrations` VALUES (21, '2026_06_08_072300_add_verifiable_to_verification_records_table', 1);
INSERT INTO `migrations` VALUES (22, '2026_06_08_072400_add_verification_fields_to_procurement_directors_table', 1);
INSERT INTO `migrations` VALUES (23, '2026_06_08_072500_create_platform_settings_table', 1);
INSERT INTO `migrations` VALUES (24, '2026_06_08_072600_add_review_fields_to_applications_table', 1);
INSERT INTO `migrations` VALUES (25, '2026_06_08_072700_add_application_id_to_documents_table', 1);
INSERT INTO `migrations` VALUES (26, '2026_06_08_072800_add_enterprise_api_fields_to_procurement_profiles_table', 1);
INSERT INTO `migrations` VALUES (27, '2026_06_08_072900_add_api_sync_fields_to_procurement_directors_table', 1);
INSERT INTO `migrations` VALUES (28, '2026_06_08_073000_add_workspace_fields_to_candidate_profiles_table', 1);
INSERT INTO `migrations` VALUES (29, '2026_06_08_073100_add_province_to_jobs_table', 1);
INSERT INTO `migrations` VALUES (30, '2026_06_09_083000_add_profile_fields_to_procurement_directors_table', 1);
INSERT INTO `migrations` VALUES (31, '2026_06_09_120000_add_display_name_to_documents_table', 1);
INSERT INTO `migrations` VALUES (32, '2026_06_09_130000_create_user_activities_table', 1);

-- ----------------------------
-- Table structure for notifications
-- ----------------------------
DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `notifications_notifiable_type_notifiable_id_index`(`notifiable_type` ASC, `notifiable_id` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of notifications
-- ----------------------------

-- ----------------------------
-- Table structure for password_reset_tokens
-- ----------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of password_reset_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for permission_role
-- ----------------------------
DROP TABLE IF EXISTS `permission_role`;
CREATE TABLE `permission_role`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_id` bigint UNSIGNED NOT NULL,
  `permission_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `permission_role_role_id_permission_id_unique`(`role_id` ASC, `permission_id` ASC) USING BTREE,
  INDEX `permission_role_permission_id_foreign`(`permission_id` ASC) USING BTREE,
  CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permission_role
-- ----------------------------
INSERT INTO `permission_role` VALUES (1, 1, 1, '2026-06-15 04:33:03', '2026-06-15 04:33:03');
INSERT INTO `permission_role` VALUES (2, 1, 2, '2026-06-15 04:33:03', '2026-06-15 04:33:03');
INSERT INTO `permission_role` VALUES (3, 1, 3, '2026-06-15 04:33:03', '2026-06-15 04:33:03');
INSERT INTO `permission_role` VALUES (4, 1, 4, '2026-06-15 04:33:03', '2026-06-15 04:33:03');
INSERT INTO `permission_role` VALUES (5, 1, 5, '2026-06-15 04:33:03', '2026-06-15 04:33:03');
INSERT INTO `permission_role` VALUES (6, 1, 6, '2026-06-15 04:33:03', '2026-06-15 04:33:03');
INSERT INTO `permission_role` VALUES (7, 1, 7, '2026-06-15 04:33:03', '2026-06-15 04:33:03');
INSERT INTO `permission_role` VALUES (8, 1, 8, '2026-06-15 04:33:03', '2026-06-15 04:33:03');
INSERT INTO `permission_role` VALUES (9, 2, 1, '2026-06-15 04:33:03', '2026-06-15 04:33:03');
INSERT INTO `permission_role` VALUES (10, 2, 2, '2026-06-15 04:33:03', '2026-06-15 04:33:03');
INSERT INTO `permission_role` VALUES (11, 2, 3, '2026-06-15 04:33:03', '2026-06-15 04:33:03');
INSERT INTO `permission_role` VALUES (12, 3, 1, '2026-06-15 04:33:03', '2026-06-15 04:33:03');
INSERT INTO `permission_role` VALUES (13, 3, 2, '2026-06-15 04:33:03', '2026-06-15 04:33:03');
INSERT INTO `permission_role` VALUES (14, 3, 3, '2026-06-15 04:33:03', '2026-06-15 04:33:03');
INSERT INTO `permission_role` VALUES (15, 4, 1, '2026-06-15 04:33:03', '2026-06-15 04:33:03');
INSERT INTO `permission_role` VALUES (16, 4, 2, '2026-06-15 04:33:03', '2026-06-15 04:33:03');
INSERT INTO `permission_role` VALUES (17, 4, 3, '2026-06-15 04:33:03', '2026-06-15 04:33:03');
INSERT INTO `permission_role` VALUES (18, 5, 1, '2026-06-15 04:33:03', '2026-06-15 04:33:03');
INSERT INTO `permission_role` VALUES (19, 5, 2, '2026-06-15 04:33:03', '2026-06-15 04:33:03');
INSERT INTO `permission_role` VALUES (20, 5, 3, '2026-06-15 04:33:03', '2026-06-15 04:33:03');

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `permissions_slug_unique`(`slug` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES (1, 'View dashboard', 'dashboard.view', 'Access role dashboard pages.', '2026-06-15 04:33:03', '2026-06-15 04:33:03');
INSERT INTO `permissions` VALUES (2, 'View profile', 'profile.view', 'View own account profile.', '2026-06-15 04:33:03', '2026-06-15 04:33:03');
INSERT INTO `permissions` VALUES (3, 'Update profile', 'profile.update', 'Update own account profile.', '2026-06-15 04:33:03', '2026-06-15 04:33:03');
INSERT INTO `permissions` VALUES (4, 'Manage users', 'users.manage', 'Create, update, and manage platform users.', '2026-06-15 04:33:03', '2026-06-15 04:33:03');
INSERT INTO `permissions` VALUES (5, 'Manage roles', 'roles.manage', 'Manage system roles and access assignments.', '2026-06-15 04:33:03', '2026-06-15 04:33:03');
INSERT INTO `permissions` VALUES (6, 'Manage settings', 'settings.manage', 'Update platform-level settings.', '2026-06-15 04:33:03', '2026-06-15 04:33:03');
INSERT INTO `permissions` VALUES (7, 'View reports', 'reports.view', 'Access reporting pages.', '2026-06-15 04:33:03', '2026-06-15 04:33:03');
INSERT INTO `permissions` VALUES (8, 'Manage clients', 'clients.manage', 'Create and manage client accounts.', '2026-06-15 04:33:03', '2026-06-15 04:33:03');

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `personal_access_tokens_token_unique`(`token` ASC) USING BTREE,
  INDEX `personal_access_tokens_tokenable_type_tokenable_id_index`(`tokenable_type` ASC, `tokenable_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for platform_settings
-- ----------------------------
DROP TABLE IF EXISTS `platform_settings`;
CREATE TABLE `platform_settings`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `platform_settings_key_unique`(`key` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of platform_settings
-- ----------------------------

-- ----------------------------
-- Table structure for procurement_directors
-- ----------------------------
DROP TABLE IF EXISTS `procurement_directors`;
CREATE TABLE `procurement_directors`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `procurement_profile_id` bigint UNSIGNED NOT NULL,
  `full_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `initials` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `birth_date` date NULL DEFAULT NULL,
  `gender` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `marital_status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `privacy_status` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `cellular_number` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `home_telephone` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `work_telephone` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `email_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `residential_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `postal_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `employer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `number_of_enquiries` int UNSIGNED NULL DEFAULT NULL,
  `id_number` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `provider_reference` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `director_status` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `verification_summary` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL,
  `director_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `procurement_directors_procurement_profile_id_foreign`(`procurement_profile_id` ASC) USING BTREE,
  CONSTRAINT `procurement_directors_procurement_profile_id_foreign` FOREIGN KEY (`procurement_profile_id`) REFERENCES `procurement_profiles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of procurement_directors
-- ----------------------------

-- ----------------------------
-- Table structure for procurement_profiles
-- ----------------------------
DROP TABLE IF EXISTS `procurement_profiles`;
CREATE TABLE `procurement_profiles`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `company_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `registration_number` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `vat_number` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `company_phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `enterprise_status` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `enterprise_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `enterprise_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `enterprise_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL,
  `enterprise_synced_at` timestamp NULL DEFAULT NULL,
  `verification_progress` tinyint UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `procurement_profiles_user_id_unique`(`user_id` ASC) USING BTREE,
  CONSTRAINT `procurement_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of procurement_profiles
-- ----------------------------
INSERT INTO `procurement_profiles` VALUES (1, 4, 'Akhani Procurement Services', '201408196207', '4123456789', '0315550101', NULL, NULL, NULL, NULL, NULL, 50, '2026-06-15 04:33:03', '2026-07-15 16:51:36');

-- ----------------------------
-- Table structure for profiles
-- ----------------------------
DROP TABLE IF EXISTS `profiles`;
CREATE TABLE `profiles`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `date_of_birth` date NULL DEFAULT NULL,
  `gender` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `id_number` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `passport_number` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `phone_secondary` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `avatar_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `address_line_1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `address_line_2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `suburb` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `province` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `postal_code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `country` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ZA',
  `identity_verified` tinyint(1) NOT NULL DEFAULT 0,
  `identity_verified_at` timestamp NULL DEFAULT NULL,
  `profile_completed` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `profiles_user_id_unique`(`user_id` ASC) USING BTREE,
  UNIQUE INDEX `profiles_id_number_unique`(`id_number` ASC) USING BTREE,
  UNIQUE INDEX `profiles_passport_number_unique`(`passport_number` ASC) USING BTREE,
  CONSTRAINT `profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of profiles
-- ----------------------------
INSERT INTO `profiles` VALUES (1, 1, NULL, 'Female', NULL, NULL, NULL, 'avatars/P15E31ODizE7f5p6NtxYkqh3OzS5bSJNmOf7aSjb.png', NULL, NULL, NULL, 'Johannesburg', 'Gauteng', NULL, 'ZA', 1, '2026-06-15 04:33:03', 1, '2026-06-15 04:33:03', '2026-08-02 11:19:19');
INSERT INTO `profiles` VALUES (2, 2, NULL, 'Male', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pretoria', 'Gauteng', NULL, 'ZA', 1, '2026-06-15 04:33:03', 1, '2026-06-15 04:33:03', '2026-06-15 04:33:03');
INSERT INTO `profiles` VALUES (3, 3, '1989-05-15', 'Male', '8905155324082', NULL, '0609625471', NULL, '2009 Bronkhorstspruit Rd Willow Manor', 'Promonade', 'Pretoria East', 'Tshwane', 'Gauteng', '0054', 'ZA', 1, '2026-07-05 11:19:06', 1, '2026-06-15 04:33:03', '2026-07-15 16:36:09');
INSERT INTO `profiles` VALUES (4, 4, NULL, 'Female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Durban', 'KwaZulu-Natal', NULL, 'ZA', 1, '2026-06-15 04:33:03', 1, '2026-06-15 04:33:03', '2026-06-15 04:33:03');
INSERT INTO `profiles` VALUES (5, 5, NULL, 'Female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Bloemfontein', 'Free State', NULL, 'ZA', 1, '2026-06-15 04:33:03', 1, '2026-06-15 04:33:03', '2026-06-15 04:33:03');

-- ----------------------------
-- Table structure for recruitment_profiles
-- ----------------------------
DROP TABLE IF EXISTS `recruitment_profiles`;
CREATE TABLE `recruitment_profiles`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `company_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `registration_number` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `website` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `company_phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `contact_person_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `recruitment_profiles_user_id_unique`(`user_id` ASC) USING BTREE,
  CONSTRAINT `recruitment_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of recruitment_profiles
-- ----------------------------
INSERT INTO `recruitment_profiles` VALUES (1, 3, 'Black Apple Investments', '2014/081962/07', 'https://blackappleinvestments.co.za/', '0215550101', 'Nthandokazi Mbonani', '2026-06-15 04:33:03', '2026-07-15 16:39:05');

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `roles_name_unique`(`name` ASC) USING BTREE,
  UNIQUE INDEX `roles_slug_unique`(`slug` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (1, 'Superadmin', 'superadmin', 'Platform owner with full administrative access.', '2026-06-15 04:33:03', '2026-06-15 04:33:03');
INSERT INTO `roles` VALUES (2, 'Candidate', 'candidate', 'Candidate account for job applications and profile management.', '2026-06-15 04:33:03', '2026-06-15 04:33:03');
INSERT INTO `roles` VALUES (3, 'Recruitment', 'recruitment', 'Recruitment account for managing candidates and recruitment workflows.', '2026-06-15 04:33:03', '2026-06-15 04:33:03');
INSERT INTO `roles` VALUES (4, 'Procurement', 'procurement', 'Procurement account for verification and enterprise workflows.', '2026-06-15 04:33:03', '2026-06-15 04:33:03');
INSERT INTO `roles` VALUES (5, 'Client', 'client', 'Client account with controlled access to procurement records.', '2026-06-15 04:33:03', '2026-06-15 04:33:03');

-- ----------------------------
-- Table structure for user_activities
-- ----------------------------
DROP TABLE IF EXISTS `user_activities`;
CREATE TABLE `user_activities`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `activity_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'page_view',
  `method` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `route_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `country_code` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `country_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `browser` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `platform` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `device_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `response_status` smallint UNSIGNED NULL DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL,
  `occurred_at` timestamp NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_activities_user_id_occurred_at_index`(`user_id` ASC, `occurred_at` ASC) USING BTREE,
  INDEX `user_activities_route_name_occurred_at_index`(`route_name` ASC, `occurred_at` ASC) USING BTREE,
  INDEX `user_activities_activity_type_occurred_at_index`(`activity_type` ASC, `occurred_at` ASC) USING BTREE,
  CONSTRAINT `user_activities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 55 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_activities
-- ----------------------------
INSERT INTO `user_activities` VALUES (1, 1, 'login', 'POST', 'login.store', '/login', '41.193.177.50', NULL, 'Unknown', 'Safari', 'macOS', 'Desktop', 302, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5 Safari/605.1.15', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-07-05 11:14:21', '2026-07-05 11:14:21', '2026-07-05 11:14:21');
INSERT INTO `user_activities` VALUES (2, 1, 'visit', 'POST', 'login.store', '/login', '41.193.177.50', NULL, 'Unknown', 'Safari', 'macOS', 'Desktop', 302, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5 Safari/605.1.15', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-07-05 11:14:21', '2026-07-05 11:14:21', '2026-07-05 11:14:21');
INSERT INTO `user_activities` VALUES (3, 3, 'login', 'POST', 'login.store', '/login', '41.193.177.50', NULL, 'Unknown', 'Safari', 'macOS', 'Desktop', 302, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5 Safari/605.1.15', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-07-05 11:18:41', '2026-07-05 11:18:41', '2026-07-05 11:18:41');
INSERT INTO `user_activities` VALUES (4, 3, 'visit', 'POST', 'login.store', '/login', '41.193.177.50', NULL, 'Unknown', 'Safari', 'macOS', 'Desktop', 302, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5 Safari/605.1.15', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-07-05 11:18:41', '2026-07-05 11:18:41', '2026-07-05 11:18:41');
INSERT INTO `user_activities` VALUES (5, 1, 'login', 'POST', 'login.store', '/login', '102.182.238.161', NULL, 'Unknown', 'Safari', 'macOS', 'Desktop', 302, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5 Safari/605.1.15', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-07-15 16:07:52', '2026-07-15 16:07:52', '2026-07-15 16:07:52');
INSERT INTO `user_activities` VALUES (6, 1, 'visit', 'POST', 'login.store', '/login', '102.182.238.161', NULL, 'Unknown', 'Safari', 'macOS', 'Desktop', 302, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5 Safari/605.1.15', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-07-15 16:07:52', '2026-07-15 16:07:52', '2026-07-15 16:07:52');
INSERT INTO `user_activities` VALUES (7, 5, 'login', 'POST', 'login.store', '/login', '102.182.238.161', NULL, 'Unknown', 'Safari', 'macOS', 'Desktop', 302, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5 Safari/605.1.15', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-07-15 16:13:52', '2026-07-15 16:13:52', '2026-07-15 16:13:52');
INSERT INTO `user_activities` VALUES (8, 5, 'visit', 'POST', 'login.store', '/login', '102.182.238.161', NULL, 'Unknown', 'Safari', 'macOS', 'Desktop', 302, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5 Safari/605.1.15', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-07-15 16:13:52', '2026-07-15 16:13:52', '2026-07-15 16:13:52');
INSERT INTO `user_activities` VALUES (9, 1, 'login', 'POST', 'login.store', '/login', '102.182.238.161', NULL, 'Unknown', 'Safari', 'macOS', 'Desktop', 302, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5 Safari/605.1.15', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-07-15 16:15:52', '2026-07-15 16:15:52', '2026-07-15 16:15:52');
INSERT INTO `user_activities` VALUES (10, 1, 'visit', 'POST', 'login.store', '/login', '102.182.238.161', NULL, 'Unknown', 'Safari', 'macOS', 'Desktop', 302, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5 Safari/605.1.15', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-07-15 16:15:52', '2026-07-15 16:15:52', '2026-07-15 16:15:52');
INSERT INTO `user_activities` VALUES (11, 2, 'login', 'POST', 'login.store', '/login', '102.182.238.161', NULL, 'Unknown', 'Safari', 'macOS', 'Desktop', 302, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5 Safari/605.1.15', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-07-15 16:17:24', '2026-07-15 16:17:24', '2026-07-15 16:17:24');
INSERT INTO `user_activities` VALUES (12, 2, 'visit', 'POST', 'login.store', '/login', '102.182.238.161', NULL, 'Unknown', 'Safari', 'macOS', 'Desktop', 302, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5 Safari/605.1.15', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-07-15 16:17:24', '2026-07-15 16:17:24', '2026-07-15 16:17:24');
INSERT INTO `user_activities` VALUES (13, 2, 'login', 'POST', 'login.store', '/login', '102.182.238.161', NULL, 'Unknown', 'Safari', 'macOS', 'Desktop', 302, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5 Safari/605.1.15', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-07-15 16:19:35', '2026-07-15 16:19:35', '2026-07-15 16:19:35');
INSERT INTO `user_activities` VALUES (14, 2, 'visit', 'POST', 'login.store', '/login', '102.182.238.161', NULL, 'Unknown', 'Safari', 'macOS', 'Desktop', 302, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5 Safari/605.1.15', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-07-15 16:19:35', '2026-07-15 16:19:35', '2026-07-15 16:19:35');
INSERT INTO `user_activities` VALUES (15, 1, 'login', 'POST', 'login.store', '/login', '102.182.238.161', NULL, 'Unknown', 'Safari', 'macOS', 'Desktop', 302, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5 Safari/605.1.15', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-07-15 16:32:26', '2026-07-15 16:32:26', '2026-07-15 16:32:26');
INSERT INTO `user_activities` VALUES (16, 1, 'visit', 'POST', 'login.store', '/login', '102.182.238.161', NULL, 'Unknown', 'Safari', 'macOS', 'Desktop', 302, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5 Safari/605.1.15', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-07-15 16:32:26', '2026-07-15 16:32:26', '2026-07-15 16:32:26');
INSERT INTO `user_activities` VALUES (17, 3, 'login', 'POST', 'login.store', '/login', '102.182.238.161', NULL, 'Unknown', 'Safari', 'macOS', 'Desktop', 302, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5 Safari/605.1.15', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-07-15 16:35:43', '2026-07-15 16:35:43', '2026-07-15 16:35:43');
INSERT INTO `user_activities` VALUES (18, 3, 'visit', 'POST', 'login.store', '/login', '102.182.238.161', NULL, 'Unknown', 'Safari', 'macOS', 'Desktop', 302, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5 Safari/605.1.15', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-07-15 16:35:43', '2026-07-15 16:35:43', '2026-07-15 16:35:43');
INSERT INTO `user_activities` VALUES (19, 4, 'login', 'POST', 'login.store', '/login', '102.182.238.161', NULL, 'Unknown', 'Safari', 'macOS', 'Desktop', 302, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5 Safari/605.1.15', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-07-15 16:51:36', '2026-07-15 16:51:36', '2026-07-15 16:51:36');
INSERT INTO `user_activities` VALUES (20, 4, 'visit', 'POST', 'login.store', '/login', '102.182.238.161', NULL, 'Unknown', 'Safari', 'macOS', 'Desktop', 302, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5 Safari/605.1.15', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-07-15 16:51:36', '2026-07-15 16:51:36', '2026-07-15 16:51:36');
INSERT INTO `user_activities` VALUES (21, 1, 'login', 'POST', 'login.store', '/login', '102.182.238.161', NULL, 'Unknown', 'Safari', 'macOS', 'Desktop', 302, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5 Safari/605.1.15', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-07-15 16:54:19', '2026-07-15 16:54:19', '2026-07-15 16:54:19');
INSERT INTO `user_activities` VALUES (22, 1, 'visit', 'POST', 'login.store', '/login', '102.182.238.161', NULL, 'Unknown', 'Safari', 'macOS', 'Desktop', 302, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5 Safari/605.1.15', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-07-15 16:54:20', '2026-07-15 16:54:20', '2026-07-15 16:54:20');
INSERT INTO `user_activities` VALUES (23, 3, 'login', 'POST', 'login.store', '/login', '102.182.238.161', NULL, 'Unknown', 'Safari', 'macOS', 'Desktop', 302, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5 Safari/605.1.15', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-07-15 16:56:11', '2026-07-15 16:56:11', '2026-07-15 16:56:11');
INSERT INTO `user_activities` VALUES (24, 3, 'visit', 'POST', 'login.store', '/login', '102.182.238.161', NULL, 'Unknown', 'Safari', 'macOS', 'Desktop', 302, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5 Safari/605.1.15', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-07-15 16:56:11', '2026-07-15 16:56:11', '2026-07-15 16:56:11');
INSERT INTO `user_activities` VALUES (25, 4, 'login', 'POST', 'login.store', '/login', '102.182.238.161', NULL, 'Unknown', 'Safari', 'macOS', 'Desktop', 302, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5 Safari/605.1.15', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-07-15 16:58:08', '2026-07-15 16:58:08', '2026-07-15 16:58:08');
INSERT INTO `user_activities` VALUES (26, 4, 'visit', 'POST', 'login.store', '/login', '102.182.238.161', NULL, 'Unknown', 'Safari', 'macOS', 'Desktop', 302, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5 Safari/605.1.15', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-07-15 16:58:08', '2026-07-15 16:58:08', '2026-07-15 16:58:08');
INSERT INTO `user_activities` VALUES (27, 1, 'login', 'POST', 'login.store', '/login', '102.182.238.161', NULL, 'Unknown', 'Safari', 'macOS', 'Desktop', 302, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5 Safari/605.1.15', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-07-16 07:55:59', '2026-07-16 07:55:59', '2026-07-16 07:55:59');
INSERT INTO `user_activities` VALUES (28, 1, 'visit', 'POST', 'login.store', '/login', '102.182.238.161', NULL, 'Unknown', 'Safari', 'macOS', 'Desktop', 302, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5 Safari/605.1.15', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-07-16 07:55:59', '2026-07-16 07:55:59', '2026-07-16 07:55:59');
INSERT INTO `user_activities` VALUES (29, 1, 'login', 'POST', 'login.store', '/login', '41.13.92.226', NULL, 'Unknown', 'Safari', 'macOS', 'Mobile', 302, 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5 Mobile/15E148 Safari/604.1', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-07-16 19:23:09', '2026-07-16 19:23:09', '2026-07-16 19:23:09');
INSERT INTO `user_activities` VALUES (30, 1, 'visit', 'POST', 'login.store', '/login', '41.13.92.226', NULL, 'Unknown', 'Safari', 'macOS', 'Mobile', 302, 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5 Mobile/15E148 Safari/604.1', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-07-16 19:23:09', '2026-07-16 19:23:09', '2026-07-16 19:23:09');
INSERT INTO `user_activities` VALUES (31, 1, 'login', 'POST', 'login.store', '/login', '102.135.145.223', NULL, 'Unknown', 'Safari', 'macOS', 'Desktop', 302, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5 Safari/605.1.15', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-07-31 09:39:52', '2026-07-31 09:39:52', '2026-07-31 09:39:52');
INSERT INTO `user_activities` VALUES (32, 1, 'visit', 'POST', 'login.store', '/login', '102.135.145.223', NULL, 'Unknown', 'Safari', 'macOS', 'Desktop', 302, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5 Safari/605.1.15', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-07-31 09:39:52', '2026-07-31 09:39:52', '2026-07-31 09:39:52');
INSERT INTO `user_activities` VALUES (33, 3, 'login', 'POST', 'login.store', '/login', '105.245.112.147', NULL, 'Unknown', 'Safari', 'macOS', 'Desktop', 302, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5 Safari/605.1.15', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-07-31 09:46:21', '2026-07-31 09:46:21', '2026-07-31 09:46:21');
INSERT INTO `user_activities` VALUES (34, 3, 'visit', 'POST', 'login.store', '/login', '105.245.112.147', NULL, 'Unknown', 'Safari', 'macOS', 'Desktop', 302, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5 Safari/605.1.15', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-07-31 09:46:21', '2026-07-31 09:46:21', '2026-07-31 09:46:21');
INSERT INTO `user_activities` VALUES (35, 1, 'login', 'POST', 'login.store', '/login', '105.245.112.147', NULL, 'Unknown', 'Safari', 'macOS', 'Desktop', 302, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5 Safari/605.1.15', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-07-31 12:36:33', '2026-07-31 12:36:33', '2026-07-31 12:36:33');
INSERT INTO `user_activities` VALUES (36, 1, 'visit', 'POST', 'login.store', '/login', '105.245.112.147', NULL, 'Unknown', 'Safari', 'macOS', 'Desktop', 302, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5 Safari/605.1.15', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-07-31 12:36:33', '2026-07-31 12:36:33', '2026-07-31 12:36:33');
INSERT INTO `user_activities` VALUES (37, 1, 'login', 'POST', 'login.store', '/login', '102.182.238.161', NULL, 'Unknown', 'Safari', 'macOS', 'Desktop', 302, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5 Safari/605.1.15', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-08-02 11:17:18', '2026-08-02 11:17:18', '2026-08-02 11:17:18');
INSERT INTO `user_activities` VALUES (38, 1, 'visit', 'POST', 'login.store', '/login', '102.182.238.161', NULL, 'Unknown', 'Safari', 'macOS', 'Desktop', 302, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5 Safari/605.1.15', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-08-02 11:17:18', '2026-08-02 11:17:18', '2026-08-02 11:17:18');
INSERT INTO `user_activities` VALUES (39, 2, 'login', 'POST', 'login.store', '/login', '102.182.238.161', NULL, 'Unknown', 'Safari', 'macOS', 'Desktop', 302, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5 Safari/605.1.15', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-08-02 11:25:13', '2026-08-02 11:25:13', '2026-08-02 11:25:13');
INSERT INTO `user_activities` VALUES (40, 2, 'visit', 'POST', 'login.store', '/login', '102.182.238.161', NULL, 'Unknown', 'Safari', 'macOS', 'Desktop', 302, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5 Safari/605.1.15', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-08-02 11:25:13', '2026-08-02 11:25:13', '2026-08-02 11:25:13');
INSERT INTO `user_activities` VALUES (41, 1, 'login', 'POST', 'login.store', '/login', '102.182.238.161', NULL, 'Unknown', 'Safari', 'macOS', 'Desktop', 302, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5 Safari/605.1.15', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-08-02 11:27:22', '2026-08-02 11:27:22', '2026-08-02 11:27:22');
INSERT INTO `user_activities` VALUES (42, 1, 'visit', 'POST', 'login.store', '/login', '102.182.238.161', NULL, 'Unknown', 'Safari', 'macOS', 'Desktop', 302, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5 Safari/605.1.15', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-08-02 11:27:22', '2026-08-02 11:27:22', '2026-08-02 11:27:22');
INSERT INTO `user_activities` VALUES (43, 1, 'login', 'POST', 'login.store', '/login', '105.245.113.25', NULL, 'Unknown', 'Safari', 'macOS', 'Desktop', 302, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5 Safari/605.1.15', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-08-05 12:29:48', '2026-08-05 12:29:48', '2026-08-05 12:29:48');
INSERT INTO `user_activities` VALUES (44, 1, 'visit', 'POST', 'login.store', '/login', '105.245.113.25', NULL, 'Unknown', 'Safari', 'macOS', 'Desktop', 302, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5 Safari/605.1.15', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-08-05 12:29:48', '2026-08-05 12:29:48', '2026-08-05 12:29:48');
INSERT INTO `user_activities` VALUES (45, 2, 'login', 'POST', 'login.store', '/login', '105.245.113.25', NULL, 'Unknown', 'Safari', 'macOS', 'Desktop', 302, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5 Safari/605.1.15', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-08-05 12:32:06', '2026-08-05 12:32:06', '2026-08-05 12:32:06');
INSERT INTO `user_activities` VALUES (46, 2, 'visit', 'POST', 'login.store', '/login', '105.245.113.25', NULL, 'Unknown', 'Safari', 'macOS', 'Desktop', 302, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5 Safari/605.1.15', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-08-05 12:32:06', '2026-08-05 12:32:06', '2026-08-05 12:32:06');
INSERT INTO `user_activities` VALUES (47, 1, 'login', 'POST', 'login.store', '/login', '105.245.113.25', NULL, 'Unknown', 'Safari', 'macOS', 'Desktop', 302, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5 Safari/605.1.15', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-08-05 12:33:43', '2026-08-05 12:33:43', '2026-08-05 12:33:43');
INSERT INTO `user_activities` VALUES (48, 1, 'visit', 'POST', 'login.store', '/login', '105.245.113.25', NULL, 'Unknown', 'Safari', 'macOS', 'Desktop', 302, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5 Safari/605.1.15', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-08-05 12:33:43', '2026-08-05 12:33:43', '2026-08-05 12:33:43');
INSERT INTO `user_activities` VALUES (49, 1, 'login', 'POST', 'login.store', '/login', '41.13.64.119', NULL, 'Unknown', 'Safari', 'macOS', 'Desktop', 302, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5 Safari/605.1.15', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-08-05 15:52:48', '2026-08-05 15:52:48', '2026-08-05 15:52:48');
INSERT INTO `user_activities` VALUES (50, 1, 'visit', 'POST', 'login.store', '/login', '41.13.64.119', NULL, 'Unknown', 'Safari', 'macOS', 'Desktop', 302, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5 Safari/605.1.15', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-08-05 15:52:48', '2026-08-05 15:52:48', '2026-08-05 15:52:48');
INSERT INTO `user_activities` VALUES (51, 1, 'login', 'POST', 'login.store', '/login', '41.13.64.119', NULL, 'Unknown', 'Safari', 'macOS', 'Desktop', 302, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5 Safari/605.1.15', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-08-05 15:53:19', '2026-08-05 15:53:19', '2026-08-05 15:53:19');
INSERT INTO `user_activities` VALUES (52, 1, 'visit', 'POST', 'login.store', '/login', '41.13.64.119', NULL, 'Unknown', 'Safari', 'macOS', 'Desktop', 302, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5 Safari/605.1.15', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-08-05 15:53:19', '2026-08-05 15:53:19', '2026-08-05 15:53:19');
INSERT INTO `user_activities` VALUES (53, 1, 'login', 'POST', 'login.store', '/login', '102.182.238.161', NULL, 'Unknown', 'Safari', 'macOS', 'Mobile', 302, 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5.2 Mobile/15E148 Safari/604.1', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-08-10 10:01:05', '2026-08-10 10:01:05', '2026-08-10 10:01:05');
INSERT INTO `user_activities` VALUES (54, 1, 'visit', 'POST', 'login.store', '/login', '102.182.238.161', NULL, 'Unknown', 'Safari', 'macOS', 'Mobile', 302, 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5.2 Mobile/15E148 Safari/604.1', '{\"full_url\":\"https:\\/\\/admin.akhaniconnect.co.za\\/login\",\"query\":[]}', '2026-08-10 10:01:05', '2026-08-10 10:01:05', '2026-08-10 10:01:05');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_id` bigint UNSIGNED NOT NULL,
  `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `phone_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `last_login_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email` ASC) USING BTREE,
  UNIQUE INDEX `users_phone_unique`(`phone` ASC) USING BTREE,
  INDEX `users_role_id_foreign`(`role_id` ASC) USING BTREE,
  CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 1, 'Aisha', 'Nkosi', 'admin@akhaniconnect.co.za', '0820000001', '2026-06-15 04:33:03', '2026-06-15 04:33:03', '$2y$12$mcVB/SgN87y9ntPZihJFbOC7sITe5eeTD/uKL452DUlqFFWei93U2', 'active', '2026-08-10 10:01:05', NULL, '2026-06-15 04:33:03', '2026-08-10 10:01:05');
INSERT INTO `users` VALUES (2, 2, 'Themba', 'Mokoena', 'candidate@akhaniconnect.co.za', '0820000002', '2026-06-15 04:33:03', '2026-06-15 04:33:03', '$2y$12$Mpdy5ErI6OjDOkNwVjqbOeT.OHdwfo9zWqN63T/57RUI5/2S2M10m', 'active', '2026-08-05 12:32:06', NULL, '2026-06-15 04:33:03', '2026-08-05 12:32:06');
INSERT INTO `users` VALUES (3, 3, 'Bongani', 'Mbonani', 'recruitment@akhaniconnect.co.za', '0827424014', '2026-06-15 04:33:03', '2026-06-15 04:33:03', '$2y$12$VPDSv4IbfhW8iR0raMjMDemYyDPAs0NwAmBggUxbXJdot3OglMTJi', 'active', '2026-07-31 09:46:21', 'Tuoo1bORQuuuM6vzG5lUi11SebhLk1G6CiKbxVKUpkSPfBm8Xx8CyAkPFtwx', '2026-06-15 04:33:03', '2026-07-31 09:46:21');
INSERT INTO `users` VALUES (4, 4, 'Lerato', 'Mabena', 'procurement@akhaniconnect.co.za', '0820000004', '2026-06-15 04:33:03', '2026-06-15 04:33:03', '$2y$12$JcOflXLeK3kQiVqHs5thbOkc/ysvjZsC0rnnyRBsDhB0iefRuHUbC', 'active', '2026-07-15 16:58:08', NULL, '2026-06-15 04:33:03', '2026-07-15 16:58:08');
INSERT INTO `users` VALUES (5, 5, 'Nandi', 'Dlamini', 'client@akhaniconnect.co.za', '0820000005', '2026-06-15 04:33:03', '2026-06-15 04:33:03', '$2y$12$N4hJeg8IJXxqr52F1CYgseqSzQHXdYEdMqg3hmCcc7597MO92ovF.', 'active', '2026-07-15 16:13:52', NULL, '2026-06-15 04:33:03', '2026-07-15 16:13:52');

-- ----------------------------
-- Table structure for verification_attempts
-- ----------------------------
DROP TABLE IF EXISTS `verification_attempts`;
CREATE TABLE `verification_attempts`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `verification_record_id` bigint UNSIGNED NOT NULL,
  `status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `provider_reference` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `request_payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL,
  `raw_response` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `processed_response` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL,
  `error_message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `attempted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `verification_attempts_verification_record_id_foreign`(`verification_record_id` ASC) USING BTREE,
  CONSTRAINT `verification_attempts_verification_record_id_foreign` FOREIGN KEY (`verification_record_id`) REFERENCES `verification_records` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of verification_attempts
-- ----------------------------
INSERT INTO `verification_attempts` VALUES (1, 3, 'verified', '97c195be-4ca4-4020-b7c6-039692e9c5e4', '{\"id_number\":\"8905155324082\",\"reportType\":\"said_verification\",\"mode\":\"production\"}', '{\"success\":true,\"requestId\":\"97c195be-4ca4-4020-b7c6-039692e9c5e4\",\"user_id\":\"8662\",\"remainingCredits\":82,\"mode\":\"production\",\"reportType\":\"said_verification\",\"input\":{\"idNumber\":\"8905155324082\"},\"results\":{\"said_verification\":{\"Status\":\"Success\",\"realTimeResults\":{\"Status\":\"ID Number Valid\",\"Verification\":{\"Firstnames\":\"BONGANI NTOKOZO\",\"Lastname\":\"MBONANI\",\"Dob\":\"1989-05-15\",\"Age\":37,\"Gender\":\"Male\",\"Citizenship\":\"South African\",\"DateIssued\":\"\"},\"transaction_id\":\"19412222\"},\"transaction_id\":\"19412222\",\"meta\":{\"environment\":\"production\",\"timestamp\":\"2026-07-05T11:19:06.154Z\"}}}}', '{\"success\":true,\"requestId\":\"97c195be-4ca4-4020-b7c6-039692e9c5e4\",\"user_id\":\"8662\",\"remainingCredits\":82,\"mode\":\"production\",\"reportType\":\"said_verification\",\"input\":{\"idNumber\":\"8905155324082\"},\"results\":{\"said_verification\":{\"Status\":\"Success\",\"realTimeResults\":{\"Status\":\"ID Number Valid\",\"Verification\":{\"Firstnames\":\"BONGANI NTOKOZO\",\"Lastname\":\"MBONANI\",\"Dob\":\"1989-05-15\",\"Age\":37,\"Gender\":\"Male\",\"Citizenship\":\"South African\",\"DateIssued\":\"\"},\"transaction_id\":\"19412222\"},\"transaction_id\":\"19412222\",\"meta\":{\"environment\":\"production\",\"timestamp\":\"2026-07-05T11:19:06.154Z\"}}}}', NULL, '2026-07-05 11:19:06', '2026-07-05 11:19:06', '2026-07-05 11:19:06');
INSERT INTO `verification_attempts` VALUES (3, 4, 'failed', NULL, '{\"id_number\":\"8905155324082\",\"reportType\":\"said_verification\",\"mode\":\"production\"}', NULL, NULL, 'SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry \'8905155324082\' for key \'profiles_id_number_unique\' (Connection: mysql, SQL: update `profiles` set `id_number` = 8905155324082, `identity_verified_at` = 2026-07-15 16:14:25, `profiles`.`updated_at` = 2026-07-15 16:14:25 where `id` = 5)', '2026-07-15 16:14:25', '2026-07-15 16:14:25', '2026-07-15 16:14:25');
INSERT INTO `verification_attempts` VALUES (5, 1, 'failed', NULL, '{\"id_number\":\"8905155324082\",\"reportType\":\"said_verification\",\"mode\":\"production\"}', NULL, NULL, 'SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry \'8905155324082\' for key \'profiles_id_number_unique\' (Connection: mysql, SQL: update `profiles` set `id_number` = 8905155324082, `identity_verified_at` = 2026-07-15 16:18:32, `profiles`.`updated_at` = 2026-07-15 16:18:32 where `id` = 2)', '2026-07-15 16:18:32', '2026-07-15 16:18:32', '2026-07-15 16:18:32');
INSERT INTO `verification_attempts` VALUES (7, 1, 'failed', NULL, '{\"id_number\":\"8905155324082\",\"reportType\":\"said_verification\",\"mode\":\"production\"}', NULL, NULL, 'SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry \'8905155324082\' for key \'profiles_id_number_unique\' (Connection: mysql, SQL: update `profiles` set `id_number` = 8905155324082, `identity_verified_at` = 2026-08-02 11:25:43, `profiles`.`updated_at` = 2026-08-02 11:25:43 where `id` = 2)', '2026-08-02 11:25:43', '2026-08-02 11:25:43', '2026-08-02 11:25:43');

-- ----------------------------
-- Table structure for verification_records
-- ----------------------------
DROP TABLE IF EXISTS `verification_records`;
CREATE TABLE `verification_records`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `module` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'verifynow',
  `status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `provider_reference` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `summary` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL,
  `last_error` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `last_verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `verifiable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `verifiable_id` bigint UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `verification_records_user_id_module_unique`(`user_id` ASC, `module` ASC) USING BTREE,
  INDEX `verification_records_verifiable_type_verifiable_id_index`(`verifiable_type` ASC, `verifiable_id` ASC) USING BTREE,
  CONSTRAINT `verification_records_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of verification_records
-- ----------------------------
INSERT INTO `verification_records` VALUES (1, 2, 'sa_identity', 'verifynow', 'failed', 'seeded-candidate-sa-id', '{\"seeded\":true}', 'SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry \'8905155324082\' for key \'profiles_id_number_unique\' (Connection: mysql, SQL: update `profiles` set `id_number` = 8905155324082, `identity_verified_at` = 2026-08-02 11:25:43, `profiles`.`updated_at` = 2026-08-02 11:25:43 where `id` = 2)', '2026-06-15 04:33:03', '2026-06-15 04:33:03', '2026-08-02 11:25:43', NULL, NULL);
INSERT INTO `verification_records` VALUES (2, 4, 'sa_identity', 'verifynow', 'verified', 'seeded-procurement-sa-id', '{\"seeded\":true}', NULL, '2026-06-15 04:33:03', '2026-06-15 04:33:03', '2026-06-15 04:33:03', NULL, NULL);
INSERT INTO `verification_records` VALUES (3, 3, 'sa_identity', 'verifynow', 'verified', '97c195be-4ca4-4020-b7c6-039692e9c5e4', '{\"request_id\":\"97c195be-4ca4-4020-b7c6-039692e9c5e4\",\"success\":true,\"mode\":\"production\",\"report_type\":\"said_verification\",\"transaction_id\":\"19412222\",\"status\":\"ID Number Valid\",\"id_number\":\"8905155324082\"}', NULL, '2026-07-05 11:19:06', '2026-07-05 11:19:02', '2026-07-05 11:19:06', NULL, NULL);
INSERT INTO `verification_records` VALUES (4, 5, 'sa_identity', 'verifynow', 'failed', NULL, NULL, 'SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry \'8905155324082\' for key \'profiles_id_number_unique\' (Connection: mysql, SQL: update `profiles` set `id_number` = 8905155324082, `identity_verified_at` = 2026-07-15 16:14:25, `profiles`.`updated_at` = 2026-07-15 16:14:25 where `id` = 5)', NULL, '2026-07-15 16:14:21', '2026-07-15 16:14:25', NULL, NULL);

SET FOREIGN_KEY_CHECKS = 1;
