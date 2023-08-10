-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 23, 2023 at 08:10 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `workplacedash`
--

-- --------------------------------------------------------

--
-- Table structure for table `actions_attachement_rel`
--

CREATE TABLE `actions_attachement_rel` (
  `aa_id` int(10) UNSIGNED NOT NULL,
  `am_id` int(11) DEFAULT NULL,
  `attachament` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `attachement_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `actions_master`
--

CREATE TABLE `actions_master` (
  `am_id` int(10) UNSIGNED NOT NULL,
  `am_parent_id` int(11) DEFAULT NULL,
  `am_module_type` int(11) DEFAULT NULL,
  `am_site_id` int(11) DEFAULT NULL,
  `am_description` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `am_control` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `am_due_date` datetime DEFAULT NULL,
  `am_remark` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `am_atpq_id` int(11) DEFAULT NULL,
  `am_atp_id` int(11) DEFAULT NULL,
  `am_adm_id` int(11) DEFAULT NULL,
  `am_status` tinyint(1) DEFAULT NULL,
  `am_created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `actions_responsible`
--

CREATE TABLE `actions_responsible` (
  `ar_id` int(10) UNSIGNED NOT NULL,
  `am_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `audit_answer_master`
--

CREATE TABLE `audit_answer_master` (
  `aam_id` int(11) NOT NULL,
  `aam_atpq_id` int(11) DEFAULT NULL,
  `aam_atp_id` int(11) DEFAULT NULL,
  `aam_atm_id` int(11) DEFAULT NULL,
  `aam_adm_id` int(11) DEFAULT NULL,
  `aam_opt_id` int(11) DEFAULT NULL,
  `aam_answer` longtext DEFAULT NULL,
  `aam_question` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `audit_checkbox_optoin`
--

CREATE TABLE `audit_checkbox_optoin` (
  `aco_id` int(10) UNSIGNED NOT NULL,
  `aco_grpid_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `aco_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `optcolor` int(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `audit_checkbox_optoin`
--

INSERT INTO `audit_checkbox_optoin` (`aco_id`, `aco_grpid_id`, `aco_name`, `optcolor`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '1', 'Yes', 2, '2020-11-09 04:02:06', NULL, NULL),
(2, '1', 'No', 3, '2020-11-09 04:05:05', NULL, NULL),
(3, '1', 'N/A', 5, '2020-11-09 04:05:05', NULL, NULL),
(4, '2', 'Good', 1, '2020-11-09 04:05:05', NULL, NULL),
(5, '2', 'Fair', 4, '2020-11-09 04:05:05', NULL, NULL),
(6, '2', 'Poor', 3, '2020-11-09 04:05:05', NULL, NULL),
(7, '2', 'N/A', 5, '2020-11-09 04:05:05', NULL, NULL),
(8, '3', 'Compliant', 2, '2020-11-09 04:05:05', NULL, NULL),
(9, '3', 'Non-Compliant', 3, '2020-11-09 04:05:06', NULL, NULL),
(10, '3', 'N/A', 5, '2020-11-09 04:05:06', NULL, NULL),
(11, '4', 'Compliant', 2, '2020-11-09 04:05:06', NULL, NULL),
(12, '4', 'Improvement', 3, '2020-11-09 04:05:06', NULL, NULL),
(13, '4', 'Minor N/C', 5, '2020-11-09 04:05:06', NULL, NULL),
(14, '4', 'Major N/C', 4, '2020-11-09 04:05:06', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `audit_checkbox_question_option`
--

CREATE TABLE `audit_checkbox_question_option` (
  `acqo_id` int(11) NOT NULL,
  `acqo_atp_id` int(11) DEFAULT NULL,
  `acqo_atm_id` int(11) DEFAULT NULL,
  `acqo_atpq_id` int(11) DEFAULT NULL,
  `acqo_option` varchar(255) DEFAULT NULL,
  `acqo_optcolor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `audit_checkbox_question_option`
--

INSERT INTO `audit_checkbox_question_option` (`acqo_id`, `acqo_atp_id`, `acqo_atm_id`, `acqo_atpq_id`, `acqo_option`, `acqo_optcolor`) VALUES
(1, 1, 1, 5, 'Compliant', 2),
(2, 1, 1, 5, 'Improvement', 3),
(3, 1, 1, 5, 'Minor N/C', 5),
(4, 1, 1, 5, 'Major N/C', 4),
(5, 1, 1, 17, 'Compliant', 2),
(6, 1, 1, 17, 'Non-Compliant', 3),
(7, 1, 1, 17, 'N/A', 5),
(8, 5, 1, 24, 'Yes', 2),
(9, 5, 1, 24, 'No', 3),
(10, 5, 1, 24, 'N/A', 5);

-- --------------------------------------------------------

--
-- Table structure for table `audit_frequency`
--

CREATE TABLE `audit_frequency` (
  `af_id` int(10) UNSIGNED NOT NULL,
  `af_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `audit_frequency`
--

INSERT INTO `audit_frequency` (`af_id`, `af_name`) VALUES
(1, 'Daily'),
(2, 'Weekly'),
(3, 'Monthly'),
(4, 'Quarterly'),
(5, 'Half-yearly'),
(6, 'Yearly'),
(7, 'One time');

-- --------------------------------------------------------

--
-- Table structure for table `audit_gridview_option`
--

CREATE TABLE `audit_gridview_option` (
  `ago_id` int(10) UNSIGNED NOT NULL,
  `ago_atp_id` int(11) DEFAULT NULL,
  `ago_atm_id` int(11) DEFAULT NULL,
  `ago_atpq_id` int(11) DEFAULT NULL,
  `ago_keyword` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ago_value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `audit_keyfinding`
--

CREATE TABLE `audit_keyfinding` (
  `ak_id` int(10) UNSIGNED NOT NULL,
  `ak_atpq_id` int(11) DEFAULT NULL,
  `ak_atp_id` int(11) DEFAULT NULL,
  `ak_atm_id` int(11) DEFAULT NULL,
  `ak_adm_id` int(11) DEFAULT NULL,
  `ak_keyfinding` longtext COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `audit_master`
--

CREATE TABLE `audit_master` (
  `adm_id` int(11) NOT NULL,
  `adm_srno` varchar(100) DEFAULT NULL,
  `adm_ac_id` int(11) DEFAULT NULL,
  `adm_atm_id` int(11) DEFAULT NULL,
  `adm_site_id` int(11) DEFAULT NULL,
  `adm_main_site_id` int(11) DEFAULT NULL,
  `adm_af_id` int(11) DEFAULT NULL,
  `adm_start_from` date DEFAULT NULL,
  `adm_end_on` date DEFAULT NULL,
  `adm_auditor` int(11) DEFAULT NULL,
  `adm_created_by` int(11) DEFAULT NULL,
  `adm_status` int(11) DEFAULT NULL,
  `adm_status_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `audit_section_completed`
--

CREATE TABLE `audit_section_completed` (
  `asc_id` int(11) NOT NULL,
  `asc_adm_id` int(11) DEFAULT NULL,
  `asc_atp_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `audit_templates_master`
--

CREATE TABLE `audit_templates_master` (
  `atm_id` int(10) UNSIGNED NOT NULL,
  `atm_audit_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `atm_description` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `atm_audit_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `atm_icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `atm_scoring_required` int(11) DEFAULT NULL,
  `atm_status` int(11) DEFAULT NULL,
  `atm_created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `audit_templates_master`
--

INSERT INTO `audit_templates_master` (`atm_id`, `atm_audit_name`, `atm_description`, `atm_audit_id`, `atm_icon`, `atm_scoring_required`, `atm_status`, `atm_created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'OHSAS 18001 Internal Audit', 'System and Process Compliance Audit Checklist as per OHSAS 180001 standard.', 'O1IA', NULL, 0, 1, 1, '2020-11-06 01:04:33', '2020-11-25 22:58:09', NULL),
(2, 'Covid-19 Return to Work Hygiene', 'A return to work health generic checklist for offices and factories to ensure people safety and health protection.', 'COV-19', NULL, 0, 1, 1, '2020-11-06 01:04:57', '2020-11-25 22:58:14', NULL),
(3, 'Construction Site Inspection', 'A generic checklist for building and construction site inspections.', 'O3IA', NULL, 0, 1, 1, '2020-11-06 01:05:39', '2020-11-25 22:58:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `audit_templates_parts`
--

CREATE TABLE `audit_templates_parts` (
  `atp_id` int(10) UNSIGNED NOT NULL,
  `atp_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `atp_atm_id` int(11) DEFAULT NULL,
  `atp_status` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `audit_templates_parts`
--

INSERT INTO `audit_templates_parts` (`atp_id`, `atp_name`, `atp_atm_id`, `atp_status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Section A', 1, 1, '2020-11-11 12:11:57', NULL, NULL),
(2, 'Section B', 1, 1, '2020-11-12 04:32:40', NULL, NULL),
(3, 'Section A', 2, 1, '2020-11-11 12:11:57', NULL, NULL),
(4, 'Section 1', 3, 1, '2020-11-12 04:32:40', NULL, NULL),
(5, 'Section C', 1, 1, '2020-11-26 12:13:28', NULL, NULL),
(6, 'Section 2', 3, 1, '2020-12-11 07:37:25', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `audit_template_parts_questions`
--

CREATE TABLE `audit_template_parts_questions` (
  `atpq_id` int(10) UNSIGNED NOT NULL,
  `atpq_atp_id` int(10) DEFAULT NULL,
  `atpq_atm_id` int(11) DEFAULT NULL,
  `atpq_parent_id` int(11) DEFAULT NULL,
  `atpq_option_id` int(11) DEFAULT NULL,
  `atpq_type` int(11) DEFAULT NULL,
  `atpq_divid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `atpq_question` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `atpq_is_mandatory` int(11) DEFAULT NULL,
  `atpq_is_description` int(11) DEFAULT NULL,
  `atpq_description_text` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `atpq_file_type` int(11) DEFAULT NULL,
  `atpq_no_of_files` int(11) DEFAULT NULL,
  `atpq_file_size` int(11) DEFAULT NULL,
  `atpq_is_multiple_choice` int(11) DEFAULT NULL,
  `atpq_is_rules` int(11) DEFAULT NULL,
  `atpq_is_date` int(11) DEFAULT NULL,
  `atpq_is_time` int(11) DEFAULT NULL,
  `atpq_start_date` date DEFAULT NULL,
  `atpq_end_date` date DEFAULT NULL,
  `atpq_declaration_text` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `atpq_is_row_headers` int(11) DEFAULT NULL,
  `atpq_no_of_rows` int(11) DEFAULT NULL,
  `atpq_no_of_columns` int(11) DEFAULT NULL,
  `atpq_table_heading` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `atpq_is_text_type` int(11) DEFAULT NULL,
  `atpq_created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `audit_template_parts_questions`
--

INSERT INTO `audit_template_parts_questions` (`atpq_id`, `atpq_atp_id`, `atpq_atm_id`, `atpq_parent_id`, `atpq_option_id`, `atpq_type`, `atpq_divid`, `atpq_question`, `atpq_is_mandatory`, `atpq_is_description`, `atpq_description_text`, `atpq_file_type`, `atpq_no_of_files`, `atpq_file_size`, `atpq_is_multiple_choice`, `atpq_is_rules`, `atpq_is_date`, `atpq_is_time`, `atpq_start_date`, `atpq_end_date`, `atpq_declaration_text`, `atpq_is_row_headers`, `atpq_no_of_rows`, `atpq_no_of_columns`, `atpq_table_heading`, `atpq_is_text_type`, `atpq_created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, 1, 1, NULL, NULL, 1, '114', '1. Attachment Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has beensd', NULL, 1, NULL, 2, 5, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-11-19 06:40:29', '2021-03-01 23:04:12', NULL),
(5, 1, 1, NULL, NULL, 2, '115', '2. Check Box It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.', 1, 1, 'Description Check Box It is a long established fact that a Check Box It is a long established fact that a', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-11-19 06:44:12', '2021-03-01 23:04:27', NULL),
(9, 1, 1, NULL, NULL, 4, '119', '3. Lorem Ipsum is not simply random text', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'The standarad chunk of Lorem Ipsum used since the 150 dasdasdasd', NULL, NULL, NULL, NULL, NULL, NULL, '2020-11-19 06:58:51', '2020-11-26 00:21:58', NULL),
(10, 1, 1, NULL, NULL, 5, '1110', '4. Grid View Contrary to popular belief, Lorem Ipsum is not simply random text', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 2, 'sadasd', NULL, NULL, '2020-11-19 07:00:35', '2020-12-10 00:09:47', NULL),
(11, 1, 1, NULL, NULL, 6, '1111', '5. Site List From Master Contrary to popular belief, Lorem Ipsum is not simply random text', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-11-19 07:05:28', '2020-11-26 00:22:04', NULL),
(12, 1, 1, NULL, NULL, 7, '1112', '6. Text Area Lorem Ipsum is simply dummy text of the printing and typesetting', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-11-19 07:07:55', '2020-11-26 00:22:07', NULL),
(13, 1, 1, NULL, NULL, 8, '1113', '7. Text Field It is a long established fact that a reader will be distracted by the readable content of a page', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2020-11-19 07:09:08', '2020-11-26 00:22:16', NULL),
(14, 1, 1, NULL, NULL, 9, '1114', '8. User List From Master It is a long established fact that a reader will be distracted by the readable content of a page', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-11-19 07:10:27', '2020-11-26 00:22:13', NULL),
(15, 2, 1, NULL, NULL, 8, '2115', 'It is a long established fact that a reader will be distracted by the readable content of a page', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2020-11-19 07:11:48', '2020-12-10 04:05:37', NULL),
(16, 1, 1, NULL, NULL, 3, '1116', '9. Date and time It is a long established fact that a reader will be distracted by the readable content of a page', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2020-11-24', '2020-11-30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-11-25 00:39:44', '2020-11-26 00:22:19', NULL),
(17, 1, 1, NULL, NULL, 2, '1117', '10. Checkbox multiple c', 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-11-25 06:57:22', '2021-03-01 23:02:42', NULL),
(19, 1, 1, 5, 1, 7, '1119', 'TEst 1', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-11-26 02:18:00', '2020-12-09 23:43:40', NULL),
(20, 1, 1, 5, 1, 8, '1120', 'test 2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-11-26 02:18:07', '2020-11-26 02:18:16', NULL),
(21, 1, 1, 5, 1, 1, '1121', 'test 3', 1, NULL, NULL, 1, 5, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-11-26 02:20:33', '2020-12-09 23:43:42', NULL),
(22, 1, 1, 5, 1, 2, '1122', 'ttst 4', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-11-26 02:21:27', '2020-11-26 02:21:46', NULL),
(23, 1, 1, 5, 1, 2, '1123', 'test 5', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-11-26 02:21:41', '2020-11-26 02:21:57', NULL),
(24, 5, 1, NULL, NULL, 2, '5124', '1. 4.6.1 Has top management reviewed the organization’s health and safety management system at planned intervals, to ensure its continuing suitability, adequacy, and effectiveness', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-11-26 06:43:31', '2020-12-10 02:02:25', NULL),
(25, 5, 1, NULL, NULL, 3, '5125', '2. 4.6.2 Have top management reviews included assessing opportunities for improvement and the need for changes to the management system, including the policy, objectives and targets?', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-11-26 06:44:04', '2021-03-12 05:57:03', NULL),
(26, 3, 2, NULL, NULL, 8, '3226', 'Hand Sanitizers are available at Entry and Exit Points.', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-11-27 23:59:49', '2020-12-11 02:01:31', NULL),
(27, 1, 1, 5, 1, 3, '1127', 'test 6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2020-11-14', '2020-11-30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-11-28 00:44:42', '2020-11-28 00:44:59', NULL),
(28, 1, 1, 5, 1, 4, '1128', 'Test 7', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'desclaration text', NULL, NULL, NULL, NULL, NULL, NULL, '2020-11-28 00:45:00', '2020-12-09 23:43:46', NULL),
(29, 1, 1, 5, 1, 5, '1129', 'test 8', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 2, 'Test heading', NULL, NULL, '2020-11-28 00:45:16', '2020-12-09 23:43:49', NULL),
(30, 1, 1, 5, 1, 6, '1130', 'test 9', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-11-28 00:45:43', '2020-11-28 00:46:09', NULL),
(31, 1, 1, 5, 1, 9, '1131', 'test 10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-11-28 00:46:09', '2020-11-28 00:46:15', NULL),
(32, 3, 2, NULL, NULL, 7, '3232', 'Posters are kept at Entry and Exit points for maintaining hygiene.', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-12-11 02:01:22', '2020-12-11 02:01:35', NULL),
(33, 3, 2, NULL, NULL, 2, '3233', 'Tool Box Talks (TBT) on Health and Sanitisation is given to all contract workers.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-12-11 02:01:36', '2020-12-11 02:04:48', NULL),
(34, 4, 3, NULL, NULL, 2, '4334', 'All key stakeholders should be involved and consulted in fair Sourcing and Selection decisions related to PPE.', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-12-11 02:06:05', '2020-12-11 02:07:03', NULL),
(35, 4, 3, NULL, NULL, 2, '4335', 'For all activities that involve injury and/or impairment risks (by way of exposure to chemical, mechanical or physical hazards), the required PPE are provided to all involved.', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-12-11 02:06:32', '2020-12-11 02:06:47', NULL),
(36, 4, 3, NULL, NULL, 7, '4336', 'All required PPE have been procured in different sizes and fitments to meet diverse worker needs.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-12-11 02:06:50', '2020-12-11 02:06:58', NULL),
(37, 4, 3, NULL, NULL, 8, '4337', 'Proper on-boarding and training in PPE are given to all employees and contract workers.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-12-11 02:07:05', '2020-12-11 02:07:14', NULL),
(38, 6, 3, NULL, NULL, 8, '6338', 'PPE related training should cover all the topics of what, where, how to use PPE, the limitations and risks involved in not using PPE, the maintenance and shelf-life of PPE?', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2020-12-11 02:07:28', '2020-12-11 02:07:37', NULL),
(39, 6, 3, NULL, NULL, 2, '6339', 'Protective Helmets are to be used wherever there is the possible danger of head injury from impact, or from falling or flying objects, or from electrical shock and burns.', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-12-11 02:07:35', '2020-12-11 02:07:51', NULL),
(40, 5, 1, NULL, NULL, 9, '5140', 'test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 10, NULL, NULL, NULL, '2021-03-01 23:00:16', '2021-03-01 23:01:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `audit_timeline`
--

CREATE TABLE `audit_timeline` (
  `atl_id` int(11) NOT NULL,
  `atl_adm_id` int(11) DEFAULT NULL,
  `atl_userid` int(11) DEFAULT NULL,
  `atl_type` int(11) DEFAULT NULL,
  `timeline` timestamp NOT NULL DEFAULT current_timestamp(),
  `atl_reason` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `audit_usernotify`
--

CREATE TABLE `audit_usernotify` (
  `aun_id` int(10) UNSIGNED NOT NULL,
  `aun_atpq_id` int(11) DEFAULT NULL,
  `aun_atp_id` int(11) DEFAULT NULL,
  `aun_atm_id` int(11) DEFAULT NULL,
  `aun_adm_id` int(11) DEFAULT NULL,
  `aun_user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bodypart_master`
--

CREATE TABLE `bodypart_master` (
  `bpm_id` int(10) UNSIGNED NOT NULL,
  `bpm_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bpm_status` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `bodypart_master`
--

INSERT INTO `bodypart_master` (`bpm_id`, `bpm_name`, `bpm_status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Spine - Thoracic', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(2, 'Spine - Cervical', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(3, 'Head - Rear', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(4, 'Chest', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(5, 'Right Thigh', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(6, 'Right Knee', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(7, 'Left Shoulder', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(8, 'Left Arm', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(9, 'Head - Frontal', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(10, 'Left Eye', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(11, 'Left Ear', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(12, 'Face', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(13, 'Neck', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(14, 'Right Eye', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(15, 'Right Ear', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(16, 'Right Shoulder', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(17, 'Right Arm', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(18, 'Right Hand', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(19, 'Abdomen', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(20, 'Private Parts', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(21, 'Left Hand', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(22, 'Left Thigh', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(23, 'Left Knee', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(24, 'Left Leg', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(25, 'Left Feet', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(26, 'Right Feet', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(27, 'Right Leg', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(28, 'Left Hamstring', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(29, 'Right Hamstring', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(30, 'Right Calve', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(31, 'Left Calve', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(32, 'Right Heel', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(33, 'Left Heel', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(34, 'Right Lower Back', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(35, 'Spine - Sacral', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(36, 'Left Lower Back', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(37, 'Spine - Lumbar', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(38, 'Right Upper Back', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(39, 'Left Upper Back', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_id` bigint(20) DEFAULT NULL,
  `type_id` bigint(20) DEFAULT NULL,
  `cat_icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category_name`, `parent_id`, `type_id`, `cat_icon`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Unsafe Act', 1, 1, NULL, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(2, 'Not wearing PPE', 1, 1, NULL, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(3, 'Not following SOP', 1, 1, NULL, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(4, 'Complacency', 1, 1, NULL, '2020-10-29 01:41:08', '2021-03-23 17:31:47', NULL),
(5, 'Violation / Abuse', 1, 1, NULL, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(6, 'Horseplay', 1, 1, NULL, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(7, 'Behavioral', 1, 1, NULL, '2020-10-29 01:41:08', '2021-03-23 17:32:12', NULL),
(8, 'Incorrect Position', 1, 1, NULL, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(9, 'Others ( Unsafe Act )', 1, 1, NULL, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(10, 'Unsafe Condition', 10, 1, NULL, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(11, 'House keeping', 10, 1, NULL, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(12, 'No warning / Safety signs', 10, 1, NULL, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(13, 'No ventilation / Illumination', 10, 1, NULL, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(14, 'Hazardous chemicals', 10, 1, NULL, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(15, 'Radiation', 10, 1, NULL, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(16, 'Extreme high / Low temperature', 10, 1, NULL, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(17, 'Extreme noise / Dust', 10, 1, NULL, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(18, 'Defective equipment / Materials', 10, 1, NULL, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(19, 'Others ( Unsafe Condition )', 10, 1, NULL, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(20, 'Best Practice', 20, 1, NULL, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(21, 'Safety initiative', 20, 1, NULL, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(22, 'Quality improvement', 20, 1, NULL, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(23, 'Cost-Cutting', 20, 1, NULL, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(24, 'Fatigue reduction', 20, 1, NULL, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(25, 'Productivity', 20, 1, NULL, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(26, 'Sustainability', 20, 1, NULL, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(27, 'Others ( Best Practice )', 20, 1, NULL, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(28, 'Near Miss', 28, 2, NULL, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(29, 'Lost Time Injury', 29, 2, NULL, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(30, 'Fatality', 29, 2, NULL, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(31, 'Reportable Accident', 29, 2, NULL, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(32, 'Medical Treatment Case', 29, 2, NULL, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(33, 'Restricted Work Case', 29, 2, NULL, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(34, 'First Aid Case', 34, 2, NULL, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(35, 'Non-Reportable Accident', 35, 2, NULL, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(36, 'Fire Hazard', 36, 2, NULL, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(37, 'Environmental', 37, 2, NULL, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(38, 'Harmful discharge to Air', 37, 2, NULL, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(39, 'Harmful discharge to Land', 37, 2, NULL, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(40, 'Harmful discharge to Water', 37, 2, NULL, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(41, 'Harmful to Flora and Fauna', 37, 2, NULL, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(42, 'Natural Calamity', 37, 2, NULL, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(43, 'Environmental', 43, 3, NULL, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(44, 'Operational', 44, 3, NULL, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(45, 'Chemical', 45, 3, NULL, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(46, 'Health', 46, 3, NULL, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(47, 'Safety', 47, 3, NULL, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(48, 'Inherent', 48, 3, NULL, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(49, 'Internal Audit', 49, 4, NULL, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(50, 'External Audit', 50, 4, NULL, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(51, 'Surprise Audit', 51, 4, NULL, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(52, 'Inspection', 52, 4, NULL, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(53, 'Checklist', 53, 4, NULL, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(54, 'test', 54, 1, '', '2020-12-28 12:21:07', '2020-12-28 12:21:21', '2020-12-28 12:21:21'),
(55, 'Harj Test 1', 55, 1, '', '2021-01-11 10:22:19', '2021-03-12 06:12:43', '2021-03-12 06:12:43'),
(56, 'Cat 1', 55, 1, '', '2021-01-11 10:22:33', '2021-01-11 10:23:06', '2021-01-11 10:23:06'),
(57, 'Cat 2', 55, 1, '', '2021-01-11 10:22:48', '2021-01-11 10:22:59', '2021-01-11 10:22:59'),
(58, 'Head', 55, 1, '', '2021-01-11 10:23:14', '2021-03-12 06:12:43', '2021-03-12 06:12:43'),
(59, 'Shoulders', 55, 1, '', '2021-01-11 10:23:22', '2021-03-12 06:12:43', '2021-03-12 06:12:43'),
(60, 'Knees', 55, 1, '', '2021-01-11 10:23:30', '2021-03-12 06:12:43', '2021-03-12 06:12:43'),
(61, 'Toes', 55, 1, '', '2021-01-11 10:23:38', '2021-03-12 06:12:43', '2021-03-12 06:12:43'),
(62, 'Car', 62, 1, '', '2021-01-12 19:00:43', '2021-03-12 06:12:39', '2021-03-12 06:12:39'),
(63, 'Driver Door', 62, 1, '', '2021-01-12 19:00:54', '2021-03-12 06:12:39', '2021-03-12 06:12:39'),
(64, 'Passenger Door', 62, 1, '', '2021-01-12 19:01:07', '2021-03-12 06:12:39', '2021-03-12 06:12:39'),
(65, 'Boot', 62, 1, '', '2021-01-12 19:01:17', '2021-03-12 06:12:39', '2021-03-12 06:12:39');

-- --------------------------------------------------------

--
-- Table structure for table `category_type`
--

CREATE TABLE `category_type` (
  `ct_id` int(10) UNSIGNED NOT NULL,
  `ct_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category_type`
--

INSERT INTO `category_type` (`ct_id`, `ct_name`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Near Miss', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(2, 'Incidents', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(3, 'Classification', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(4, 'Audits', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `control_master`
--

CREATE TABLE `control_master` (
  `cm_id` int(10) UNSIGNED NOT NULL,
  `cm_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cm_status` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `control_master`
--

INSERT INTO `control_master` (`cm_id`, `cm_name`, `cm_status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Elimination', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(2, 'Substitution', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(3, 'Engineering', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(4, 'Administrative', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `flights`
--

CREATE TABLE `flights` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `incidents_attachement_rel`
--

CREATE TABLE `incidents_attachement_rel` (
  `ia_id` int(10) UNSIGNED NOT NULL,
  `im_id` int(11) DEFAULT NULL,
  `attachament` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `attachement_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `incidents_investigation_team`
--

CREATE TABLE `incidents_investigation_team` (
  `iit_id` int(10) UNSIGNED NOT NULL,
  `iit_im_id` int(11) DEFAULT NULL,
  `iit_user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `incidents_master`
--

CREATE TABLE `incidents_master` (
  `im_id` int(10) UNSIGNED NOT NULL,
  `im_srno` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `im_description` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `im_ic_id` int(11) DEFAULT NULL,
  `im_site_id` int(11) DEFAULT NULL,
  `im_shift` int(11) DEFAULT NULL,
  `im_datetime` datetime DEFAULT NULL,
  `im_ratinganincident` int(11) DEFAULT NULL,
  `im_investigationisrequired` int(11) DEFAULT NULL,
  `im_machineno_extralocation` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `im_extendofdamange` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `im_immediateactiontaken` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `im_anyvictim` int(11) DEFAULT NULL,
  `im_investigateteamlead` int(11) DEFAULT NULL,
  `im_dateofcomplete` datetime DEFAULT NULL,
  `im_actionapproved` int(11) DEFAULT NULL,
  `im_lastsubmitedstep` int(11) DEFAULT NULL,
  `im_approved_by` int(11) DEFAULT NULL,
  `im_approved_at` datetime DEFAULT NULL,
  `im_created_by` int(11) DEFAULT NULL,
  `im_status` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `incidents_rating`
--

CREATE TABLE `incidents_rating` (
  `ir_id` int(10) UNSIGNED NOT NULL,
  `rating` int(11) DEFAULT NULL,
  `severity` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `likelihood` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rating_type` int(11) DEFAULT NULL,
  `rating_text` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `incidents_rating`
--

INSERT INTO `incidents_rating` (`ir_id`, `rating`, `severity`, `likelihood`, `rating_type`, `rating_text`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Very Low', 'Unlikely / Rare', 1, 'Minor', '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(2, 2, 'Very Low', 'Likely / Intermittent', 1, 'Minor', '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(3, 3, 'Very Low', 'Frequent / Repetitive', 1, 'Minor', '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(4, 4, 'Very Low', 'Almost Certain / Cyclic', 1, 'Minor', '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(5, 2, 'Minor', 'Unlikely / Rare', 1, 'Minor', '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(6, 4, 'Minor', 'Likely / Intermittent', 1, 'Minor', '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(7, 6, 'Minor', 'Frequent / Repetitive', 1, 'Minor', '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(8, 8, 'Minor', 'Almost Certain / Cyclic', 2, 'Serious', '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(9, 3, 'Serious', 'Unlikely / Rare', 1, 'Minor', '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(10, 6, 'Serious', 'Likely / Intermittent', 1, 'Minor', '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(11, 9, 'Serious', 'Frequent / Repetitive', 2, 'Serious', '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(12, 12, 'Serious', 'Almost Certain / Cyclic', 2, 'Serious', '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(13, 4, 'Fatal', 'Unlikely / Rare', 1, 'Minor', '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(14, 8, 'Fatal', 'Likely / Intermittent', 2, 'Serious', '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(15, 12, 'Fatal', 'Frequent / Repetitive', 2, 'Serious', '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(16, 16, 'Fatal', 'Almost Certain / Cyclic', 3, 'Fatal', '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(17, 5, 'Major Hazard / Calamity', 'Unlikely / Rare', 1, 'Minor', '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(18, 10, 'Major Hazard / Calamity', 'Likely / Intermittent', 2, 'Serious', '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(19, 15, 'Major Hazard / Calamity', 'Frequent / Repetitive', 3, 'Fatal', '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(20, 20, 'Major Hazard / Calamity', 'Almost Certain / Cyclic', 3, 'Fatal', '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `incidents_root_cause`
--

CREATE TABLE `incidents_root_cause` (
  `irc_id` int(10) UNSIGNED NOT NULL,
  `irc_im_id` int(11) DEFAULT NULL,
  `irc_rcid` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `incidents_root_cause`
--

INSERT INTO `incidents_root_cause` (`irc_id`, `irc_im_id`, `irc_rcid`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, '2020-12-02 05:40:31', NULL, NULL),
(2, 1, 17, '2020-12-02 05:40:31', NULL, NULL),
(3, 1, 18, '2020-12-02 05:40:31', NULL, NULL),
(4, 1, 19, '2020-12-02 05:40:31', NULL, NULL),
(5, 1, 20, '2020-12-02 05:40:31', NULL, NULL),
(6, 10, 1, '2021-01-11 13:56:13', NULL, NULL),
(7, 10, 20, '2021-01-11 13:56:13', NULL, NULL),
(8, 10, 14, '2021-01-11 13:56:13', NULL, NULL),
(9, 10, 127, '2021-01-11 13:56:13', NULL, NULL),
(57, 11, 17, '2021-01-19 10:41:09', NULL, NULL),
(58, 11, 18, '2021-01-19 10:41:09', NULL, NULL),
(59, 11, 19, '2021-01-19 10:41:09', NULL, NULL),
(60, 11, 20, '2021-01-19 10:41:09', NULL, NULL),
(61, 11, 123, '2021-01-19 10:41:09', NULL, NULL),
(62, 11, 124, '2021-01-19 10:41:09', NULL, NULL),
(63, 11, 125, '2021-01-19 10:41:09', NULL, NULL),
(64, 11, 126, '2021-01-19 10:41:09', NULL, NULL),
(65, 11, 127, '2021-01-19 10:41:09', NULL, NULL),
(66, 11, 23, '2021-01-19 10:41:09', NULL, NULL),
(67, 11, 24, '2021-01-19 10:41:09', NULL, NULL),
(68, 11, 1, '2021-01-19 10:41:09', NULL, NULL),
(69, 11, 14, '2021-01-19 10:41:09', NULL, NULL),
(70, 11, 2, '2021-01-19 10:41:09', NULL, NULL),
(138, 7, 17, '2021-01-19 11:23:46', NULL, NULL),
(139, 7, 18, '2021-01-19 11:23:46', NULL, NULL),
(140, 7, 19, '2021-01-19 11:23:46', NULL, NULL),
(141, 7, 20, '2021-01-19 11:23:46', NULL, NULL),
(142, 7, 28, '2021-01-19 11:23:46', NULL, NULL),
(143, 7, 29, '2021-01-19 11:23:46', NULL, NULL),
(144, 7, 123, '2021-01-19 11:23:46', NULL, NULL),
(145, 7, 124, '2021-01-19 11:23:46', NULL, NULL),
(146, 7, 125, '2021-01-19 11:23:46', NULL, NULL),
(147, 7, 126, '2021-01-19 11:23:46', NULL, NULL),
(148, 7, 127, '2021-01-19 11:23:46', NULL, NULL),
(149, 7, 1, '2021-01-19 11:23:46', NULL, NULL),
(150, 7, 3, '2021-01-19 11:23:46', NULL, NULL),
(151, 7, 14, '2021-01-19 11:23:46', NULL, NULL),
(169, 12, 17, '2021-01-19 12:13:40', NULL, NULL),
(170, 12, 18, '2021-01-19 12:13:40', NULL, NULL),
(171, 12, 19, '2021-01-19 12:13:40', NULL, NULL),
(172, 12, 20, '2021-01-19 12:13:40', NULL, NULL),
(173, 12, 21, '2021-01-19 12:13:40', NULL, NULL),
(174, 12, 22, '2021-01-19 12:13:40', NULL, NULL),
(175, 12, 21, '2021-01-19 12:13:40', NULL, NULL),
(176, 12, 22, '2021-01-19 12:13:40', NULL, NULL),
(177, 12, 123, '2021-01-19 12:13:40', NULL, NULL),
(178, 12, 124, '2021-01-19 12:13:40', NULL, NULL),
(179, 12, 125, '2021-01-19 12:13:40', NULL, NULL),
(180, 12, 126, '2021-01-19 12:13:40', NULL, NULL),
(181, 12, 127, '2021-01-19 12:13:40', NULL, NULL),
(182, 12, 129, '2021-01-19 12:13:40', NULL, NULL),
(183, 12, 130, '2021-01-19 12:13:40', NULL, NULL),
(184, 12, 1, '2021-01-19 12:13:40', NULL, NULL),
(185, 12, 2, '2021-01-19 12:13:40', NULL, NULL),
(186, 12, 2, '2021-01-19 12:13:40', NULL, NULL),
(187, 12, 14, '2021-01-19 12:13:40', NULL, NULL),
(188, 12, 15, '2021-01-19 12:13:40', NULL, NULL),
(189, 15, 17, '2021-01-19 12:21:35', NULL, NULL),
(190, 15, 21, '2021-01-19 12:21:35', NULL, NULL),
(191, 15, 22, '2021-01-19 12:21:35', NULL, NULL),
(192, 15, 23, '2021-01-19 12:21:35', NULL, NULL),
(193, 15, 24, '2021-01-19 12:21:35', NULL, NULL),
(194, 15, 25, '2021-01-19 12:21:35', NULL, NULL),
(195, 15, 26, '2021-01-19 12:21:35', NULL, NULL),
(196, 15, 27, '2021-01-19 12:21:35', NULL, NULL),
(197, 15, 87, '2021-01-19 12:21:35', NULL, NULL),
(198, 15, 88, '2021-01-19 12:21:35', NULL, NULL),
(199, 15, 89, '2021-01-19 12:21:35', NULL, NULL),
(200, 15, 90, '2021-01-19 12:21:35', NULL, NULL),
(201, 15, 91, '2021-01-19 12:21:35', NULL, NULL),
(202, 15, 92, '2021-01-19 12:21:35', NULL, NULL),
(203, 15, 93, '2021-01-19 12:21:35', NULL, NULL),
(204, 15, 94, '2021-01-19 12:21:35', NULL, NULL),
(205, 15, 95, '2021-01-19 12:21:35', NULL, NULL),
(206, 15, 96, '2021-01-19 12:21:35', NULL, NULL),
(207, 15, 97, '2021-01-19 12:21:35', NULL, NULL),
(208, 15, 98, '2021-01-19 12:21:35', NULL, NULL),
(209, 15, 99, '2021-01-19 12:21:35', NULL, NULL),
(210, 15, 100, '2021-01-19 12:21:35', NULL, NULL),
(211, 15, 123, '2021-01-19 12:21:35', NULL, NULL),
(212, 15, 124, '2021-01-19 12:21:35', NULL, NULL),
(213, 15, 1, '2021-01-19 12:21:35', NULL, NULL),
(214, 15, 2, '2021-01-19 12:21:35', NULL, NULL),
(215, 15, 10, '2021-01-19 12:21:35', NULL, NULL),
(216, 15, 14, '2021-01-19 12:21:35', NULL, NULL),
(217, 17, 17, '2021-01-20 07:22:54', NULL, NULL),
(218, 17, 18, '2021-01-20 07:22:54', NULL, NULL),
(219, 17, 123, '2021-01-20 07:22:54', NULL, NULL),
(220, 17, 124, '2021-01-20 07:22:54', NULL, NULL),
(221, 17, 125, '2021-01-20 07:22:54', NULL, NULL),
(222, 17, 126, '2021-01-20 07:22:54', NULL, NULL),
(223, 17, 127, '2021-01-20 07:22:54', NULL, NULL),
(224, 17, 1, '2021-01-20 07:22:54', NULL, NULL),
(225, 17, 14, '2021-01-20 07:22:54', NULL, NULL),
(226, 19, 18, '2021-01-20 10:57:57', NULL, NULL),
(227, 19, 19, '2021-01-20 10:57:57', NULL, NULL),
(228, 19, 49, '2021-01-20 10:57:57', NULL, NULL),
(229, 19, 50, '2021-01-20 10:57:57', NULL, NULL),
(230, 19, 51, '2021-01-20 10:57:57', NULL, NULL),
(231, 19, 52, '2021-01-20 10:57:57', NULL, NULL),
(232, 19, 53, '2021-01-20 10:57:57', NULL, NULL),
(233, 19, 54, '2021-01-20 10:57:57', NULL, NULL),
(234, 19, 55, '2021-01-20 10:57:57', NULL, NULL),
(235, 19, 56, '2021-01-20 10:57:57', NULL, NULL),
(236, 19, 123, '2021-01-20 10:57:57', NULL, NULL),
(237, 19, 124, '2021-01-20 10:57:57', NULL, NULL),
(238, 19, 125, '2021-01-20 10:57:57', NULL, NULL),
(239, 19, 126, '2021-01-20 10:57:57', NULL, NULL),
(240, 19, 127, '2021-01-20 10:57:57', NULL, NULL),
(241, 19, 128, '2021-01-20 10:57:57', NULL, NULL),
(242, 19, 129, '2021-01-20 10:57:57', NULL, NULL),
(243, 19, 1, '2021-01-20 10:57:57', NULL, NULL),
(244, 19, 5, '2021-01-20 10:57:57', NULL, NULL),
(245, 19, 14, '2021-01-20 10:57:57', NULL, NULL),
(246, 19, 15, '2021-01-20 10:57:57', NULL, NULL),
(247, 22, 18, '2021-01-20 11:49:21', NULL, NULL),
(248, 22, 17, '2021-01-20 11:49:21', NULL, NULL),
(249, 22, 21, '2021-01-20 11:49:21', NULL, NULL),
(250, 22, 22, '2021-01-20 11:49:21', NULL, NULL),
(251, 22, 23, '2021-01-20 11:49:21', NULL, NULL),
(252, 22, 24, '2021-01-20 11:49:21', NULL, NULL),
(253, 22, 25, '2021-01-20 11:49:21', NULL, NULL),
(254, 22, 26, '2021-01-20 11:49:21', NULL, NULL),
(255, 22, 27, '2021-01-20 11:49:21', NULL, NULL),
(256, 22, 123, '2021-01-20 11:49:21', NULL, NULL),
(257, 22, 124, '2021-01-20 11:49:21', NULL, NULL),
(258, 22, 125, '2021-01-20 11:49:21', NULL, NULL),
(259, 22, 126, '2021-01-20 11:49:21', NULL, NULL),
(260, 22, 127, '2021-01-20 11:49:21', NULL, NULL),
(261, 22, 112, '2021-01-20 11:49:21', NULL, NULL),
(262, 22, 113, '2021-01-20 11:49:21', NULL, NULL),
(263, 22, 1, '2021-01-20 11:49:21', NULL, NULL),
(264, 22, 2, '2021-01-20 11:49:21', NULL, NULL),
(265, 22, 14, '2021-01-20 11:49:21', NULL, NULL),
(266, 22, 12, '2021-01-20 11:49:21', NULL, NULL),
(285, 3, 1, '2021-02-22 12:25:52', NULL, NULL),
(286, 3, 17, '2021-02-22 12:25:52', NULL, NULL),
(287, 3, 18, '2021-02-22 12:25:52', NULL, NULL),
(288, 3, 19, '2021-02-22 12:25:52', NULL, NULL),
(289, 3, 20, '2021-02-22 12:25:52', NULL, NULL),
(290, 3, 2, '2021-02-22 12:25:52', NULL, NULL),
(291, 3, 21, '2021-02-22 12:25:52', NULL, NULL),
(292, 3, 22, '2021-02-22 12:25:52', NULL, NULL),
(293, 3, 23, '2021-02-22 12:25:52', NULL, NULL),
(294, 3, 24, '2021-02-22 12:25:52', NULL, NULL),
(295, 3, 25, '2021-02-22 12:25:52', NULL, NULL),
(296, 3, 26, '2021-02-22 12:25:52', NULL, NULL),
(297, 3, 27, '2021-02-22 12:25:52', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `incidents_root_cause_description`
--

CREATE TABLE `incidents_root_cause_description` (
  `ircd_id` int(10) UNSIGNED NOT NULL,
  `ircd_im_id` int(11) DEFAULT NULL,
  `ircd_rcid` int(11) DEFAULT NULL,
  `ircd_text` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `incidents_victim`
--

CREATE TABLE `incidents_victim` (
  `iv_id` int(10) UNSIGNED NOT NULL,
  `iv_im_id` int(11) DEFAULT NULL,
  `iv_vtm_id` int(11) DEFAULT NULL,
  `iv_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `iv_gender` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `iv_age_range` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `iv_age_range_min` int(11) DEFAULT NULL,
  `iv_age_range_max` int(11) DEFAULT NULL,
  `iv_details_injury` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `iv_taken_hospital` int(11) DEFAULT NULL,
  `iv_when_returntowork` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `iv_details_treatment` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `incidents_victim_bodypart`
--

CREATE TABLE `incidents_victim_bodypart` (
  `ivbp_id` int(10) UNSIGNED NOT NULL,
  `ivbp_im_id` int(11) DEFAULT NULL,
  `ivbp_iv_id` int(11) DEFAULT NULL,
  `ivbp_bpm_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_sites_table', 1),
(4, '2020_08_01_063804_create_category_table', 1),
(5, '2020_09_16_044753_create_roles', 1),
(6, '2020_09_19_055301_create_user_site_relation', 1),
(7, '2020_09_24_042614_create_category_type', 1),
(8, '2020_09_25_043649_create_observations_master', 1),
(9, '2020_09_25_043808_create_observations_attachement_rel', 1),
(10, '2020_09_29_062730_create_actions_master', 1),
(11, '2020_09_29_062815_create_actions_responsible', 1),
(12, '2020_09_29_062830_create_actions_attachement_rel', 1),
(13, '2020_10_01_055659_create_incidents_master', 1),
(14, '2020_10_01_055716_create_incidents_attachement_rel', 1),
(15, '2020_10_01_113617_create_shift_master', 1),
(16, '2020_10_03_052535_create_control_master', 1),
(17, '2020_10_03_052543_create_victimtype_master', 1),
(18, '2020_10_03_052551_create_bodypart_master', 1),
(19, '2020_10_03_091614_create_incidents_root_cause', 1),
(20, '2020_10_03_091623_create_incidents_investigation_team', 1),
(21, '2020_10_03_091629_create_incidents_victim', 1),
(22, '2020_10_03_091636_create_incidents_victim_bodypart', 1),
(23, '2020_10_03_091956_create_rootcause_master', 1),
(24, '2020_10_03_092015_create_rootcause_items', 1),
(25, '2020_10_06_104714_create_incidents_root_cause_description', 1),
(26, '2020_10_09_053829_create_incidents_rating', 1),
(27, '2020_10_10_055150_create_permissions_master', 1),
(28, '2020_10_10_055902_create_role_permissions_master', 1),
(29, '2020_10_10_055910_create_users_permissions', 1),
(30, '2020_10_12_044059_create_role_log', 1),
(31, '2020_10_14_063413_create_users_roles', 1),
(32, '2021_09_10_100754_create_flights_table', 2),
(39, '2023_06_20_133356_create_vaccinations_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `observations_attachement_rel`
--

CREATE TABLE `observations_attachement_rel` (
  `oar_id` int(10) UNSIGNED NOT NULL,
  `ob_id` int(11) DEFAULT NULL,
  `attachament` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `attachement_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `observations_master`
--

CREATE TABLE `observations_master` (
  `ob_id` int(10) UNSIGNED NOT NULL,
  `ob_srno` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `site_id` int(11) DEFAULT NULL,
  `ob_describethelocation` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `oc_id` int(11) DEFAULT NULL,
  `description` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `obdatetime` datetime DEFAULT NULL,
  `riskpotentiallevel` int(11) DEFAULT NULL,
  `action_required` tinyint(1) DEFAULT NULL,
  `Comments` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `listing_type` int(10) DEFAULT NULL,
  `ob_more_information_required` int(2) DEFAULT NULL,
  `ob_information_required` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `ob_reply_information_requested` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `ob_closing_comments` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `ob_fullname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ob_empid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ob_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `observations_master`
--

INSERT INTO `observations_master` (`ob_id`, `ob_srno`, `site_id`, `ob_describethelocation`, `oc_id`, `description`, `obdatetime`, `riskpotentiallevel`, `action_required`, `Comments`, `listing_type`, `ob_more_information_required`, `ob_information_required`, `ob_reply_information_requested`, `status`, `ob_closing_comments`, `created_by`, `ob_fullname`, `ob_empid`, `ob_email`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'NM020001', 1, '212310', 1, '1112121', '2021-05-20 16:22:00', 1, 0, '321231', 1, NULL, NULL, NULL, 2, '', 1, NULL, NULL, NULL, '2021-05-19 05:22:56', '2023-06-22 06:10:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `observations_reply_attachement`
--

CREATE TABLE `observations_reply_attachement` (
  `ora_id` int(10) UNSIGNED NOT NULL,
  `ora_ob_id` int(11) DEFAULT NULL,
  `ora_attachament` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ora_attachement_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions_master`
--

CREATE TABLE `permissions_master` (
  `pm_id` int(10) UNSIGNED NOT NULL,
  `pm_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `permissions_master`
--

INSERT INTO `permissions_master` (`pm_id`, `pm_name`, `created_at`, `updated_at`) VALUES
(1, 'Audit', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(2, 'Audit Add', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(3, 'Audit Edit', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(4, 'Audit Delete', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(5, 'Incident', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(6, 'Incident Add', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(7, 'Incident Edit', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(8, 'Incident Delete', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(9, 'Permit', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(10, 'Permit Add', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(11, 'Permit Edit ', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(12, 'Permit Delete', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(13, 'Permit Revoke', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(14, 'Permit Extend', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(15, 'Permit Close', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(16, 'Permit Reject', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(17, 'Audit Template', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(18, 'Audit Template Add', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(19, 'Audit Template Edit', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(20, 'Audit Template Delete', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(21, 'Categories', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(22, 'Categories Add', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(23, 'Categories Edit', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(24, 'Categories Delete', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(25, 'HIRA', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(26, 'HIRA Add', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(27, 'HIRA Edit', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(28, 'HIRA Delete', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(29, 'Permit Templates', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(30, 'Permit Templates Add', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(31, 'Permit Templates Edit', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(32, 'Permit Templates Delete', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(33, 'Root Cause', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(34, 'Root Cause Add', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(35, 'Root Cause Edit', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(36, 'Root Cause Delete', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(37, 'Roles', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(38, 'Roles Add', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(39, 'Roles Edit', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(40, 'Roles Delete', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(41, 'Sites', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(42, 'Sites Add', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(43, 'Sites Edit', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(44, 'Sites Delete', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(45, 'User', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(46, 'User Add', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(47, 'User Edit', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(48, 'User Delete', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(49, 'Workflows', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(50, 'Workflows Add', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(51, 'Workflows Edit', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(52, 'Workflows Delete', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(53, 'Actions', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(54, 'Actions Add', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(55, 'Actions Edit', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(56, 'Actions Delete', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(57, 'Observations', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(58, 'Observations Add', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(59, 'Observations Edit', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(60, 'Observations Delete', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(61, 'Observations Close', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(62, 'Incidents Close', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(63, 'Incidents Approve/Reject', '2020-10-29 01:41:08', '2020-10-29 01:41:08'),
(64, 'Observations Risk potential', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `r_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `r_status` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `r_name`, `r_status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Super Admin', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(2, 'Head of Safety', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(3, 'User', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(4, 'Head of Division', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(5, 'Guest', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_log`
--

CREATE TABLE `role_log` (
  `rl_id` int(10) UNSIGNED NOT NULL,
  `rl_r_id` int(11) DEFAULT NULL,
  `rl_user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `role_log`
--

INSERT INTO `role_log` (`rl_id`, `rl_r_id`, `rl_user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 5, 2, '2021-05-19 09:49:49', NULL, NULL),
(2, 2, 2, '2021-05-25 09:56:59', NULL, NULL),
(3, 3, 3, '2021-09-10 10:11:53', NULL, NULL),
(4, 5, 3, '2021-09-10 10:12:22', NULL, NULL),
(5, 4, 3, '2021-09-10 10:13:00', NULL, NULL),
(6, 5, 3, '2021-09-10 10:13:06', NULL, NULL),
(7, 3, 3, '2021-09-10 10:14:57', NULL, NULL),
(8, 5, 3, '2021-09-10 10:15:07', NULL, NULL),
(9, 3, 3, '2021-09-10 10:15:25', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions_master`
--

CREATE TABLE `role_permissions_master` (
  `rpm_id` int(10) UNSIGNED NOT NULL,
  `roles_id` int(11) DEFAULT NULL,
  `permission_pm_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `role_permissions_master`
--

INSERT INTO `role_permissions_master` (`rpm_id`, `roles_id`, `permission_pm_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, '2020-10-29 01:41:07', '2020-10-29 01:41:07', NULL),
(2, 1, 2, '2020-10-29 01:41:07', '2020-10-29 01:41:07', NULL),
(3, 1, 3, '2020-10-29 01:41:07', '2020-10-29 01:41:07', NULL),
(4, 1, 4, '2020-10-29 01:41:07', '2020-10-29 01:41:07', NULL),
(5, 1, 5, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(6, 1, 6, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(7, 1, 7, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(8, 1, 8, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(9, 1, 9, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(10, 1, 10, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(11, 1, 11, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(12, 1, 12, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(13, 1, 13, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(14, 1, 14, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(15, 1, 15, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(16, 1, 16, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(17, 1, 17, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(18, 1, 18, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(19, 1, 19, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(20, 1, 20, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(21, 1, 21, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(22, 1, 22, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(23, 1, 23, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(24, 1, 24, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(25, 1, 25, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(26, 1, 26, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(27, 1, 27, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(28, 1, 28, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(29, 1, 29, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(30, 1, 30, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(31, 1, 31, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(32, 1, 32, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(33, 1, 33, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(34, 1, 34, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(35, 1, 35, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(36, 1, 36, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(37, 1, 37, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(38, 1, 38, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(39, 1, 39, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(40, 1, 40, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(41, 1, 41, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(42, 1, 42, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(43, 1, 43, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(44, 1, 44, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(45, 1, 45, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(46, 1, 46, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(47, 1, 47, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(48, 1, 48, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(49, 1, 49, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(50, 1, 50, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(51, 1, 51, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(52, 1, 52, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(53, 2, 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(54, 2, 2, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(55, 2, 3, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(56, 2, 4, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(57, 2, 5, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(58, 2, 6, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(59, 2, 7, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(60, 2, 8, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(61, 2, 9, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(62, 2, 10, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(63, 2, 11, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(64, 2, 12, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(65, 2, 13, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(66, 2, 14, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(67, 2, 15, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(68, 2, 16, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(75, 4, 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(76, 4, 2, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(77, 4, 3, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(78, 4, 4, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(79, 4, 5, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(80, 4, 6, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(81, 4, 7, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(82, 4, 8, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(83, 4, 9, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(84, 4, 10, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(85, 4, 11, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(86, 4, 12, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(142, 7, 5, '2020-12-18 13:50:42', NULL, NULL),
(143, 7, 6, '2020-12-18 13:50:42', NULL, NULL),
(144, 7, 7, '2020-12-18 13:50:42', NULL, NULL),
(145, 7, 8, '2020-12-18 13:50:42', NULL, NULL),
(146, 8, 1, '2021-01-11 11:15:48', NULL, NULL),
(147, 8, 2, '2021-01-11 11:15:48', NULL, NULL),
(148, 8, 3, '2021-01-11 11:15:48', NULL, NULL),
(149, 8, 4, '2021-01-11 11:15:48', NULL, NULL),
(150, 8, 5, '2021-01-11 11:15:48', NULL, NULL),
(151, 8, 6, '2021-01-11 11:15:48', NULL, NULL),
(152, 8, 7, '2021-01-11 11:15:48', NULL, NULL),
(153, 8, 8, '2021-01-11 11:15:48', NULL, NULL),
(154, 8, 17, '2021-01-11 11:15:48', NULL, NULL),
(155, 8, 18, '2021-01-11 11:15:48', NULL, NULL),
(156, 8, 19, '2021-01-11 11:15:48', NULL, NULL),
(157, 8, 20, '2021-01-11 11:15:48', NULL, NULL),
(158, 8, 21, '2021-01-11 11:15:48', NULL, NULL),
(159, 8, 22, '2021-01-11 11:15:48', NULL, NULL),
(160, 8, 23, '2021-01-11 11:15:48', NULL, NULL),
(161, 8, 24, '2021-01-11 11:15:48', NULL, NULL),
(162, 8, 25, '2021-01-11 11:15:48', NULL, NULL),
(163, 8, 26, '2021-01-11 11:15:48', NULL, NULL),
(164, 8, 27, '2021-01-11 11:15:48', NULL, NULL),
(165, 8, 28, '2021-01-11 11:15:48', NULL, NULL),
(166, 8, 29, '2021-01-11 11:15:48', NULL, NULL),
(167, 8, 30, '2021-01-11 11:15:48', NULL, NULL),
(168, 8, 31, '2021-01-11 11:15:48', NULL, NULL),
(169, 8, 32, '2021-01-11 11:15:48', NULL, NULL),
(170, 8, 33, '2021-01-11 11:15:48', NULL, NULL),
(171, 8, 34, '2021-01-11 11:15:48', NULL, NULL),
(172, 8, 35, '2021-01-11 11:15:48', NULL, NULL),
(173, 8, 36, '2021-01-11 11:15:48', NULL, NULL),
(174, 8, 37, '2021-01-11 11:15:48', NULL, NULL),
(175, 8, 38, '2021-01-11 11:15:48', NULL, NULL),
(176, 8, 39, '2021-01-11 11:15:48', NULL, NULL),
(177, 8, 40, '2021-01-11 11:15:48', NULL, NULL),
(178, 8, 41, '2021-01-11 11:15:48', NULL, NULL),
(179, 8, 42, '2021-01-11 11:15:48', NULL, NULL),
(180, 8, 43, '2021-01-11 11:15:48', NULL, NULL),
(181, 8, 44, '2021-01-11 11:15:48', NULL, NULL),
(182, 8, 45, '2021-01-11 11:15:48', NULL, NULL),
(183, 8, 45, '2021-01-11 11:15:48', NULL, NULL),
(184, 8, 47, '2021-01-11 11:15:48', NULL, NULL),
(185, 8, 48, '2021-01-11 11:15:48', NULL, NULL),
(186, 8, 49, '2021-01-11 11:15:48', NULL, NULL),
(187, 8, 50, '2021-01-11 11:15:48', NULL, NULL),
(188, 8, 51, '2021-01-11 11:15:48', NULL, NULL),
(189, 8, 52, '2021-01-11 11:15:48', NULL, NULL),
(254, 11, 1, '2021-01-19 16:15:15', NULL, NULL),
(255, 11, 2, '2021-01-19 16:15:15', NULL, NULL),
(256, 11, 3, '2021-01-19 16:15:15', NULL, NULL),
(257, 11, 4, '2021-01-19 16:15:15', NULL, NULL),
(258, 11, 5, '2021-01-19 16:15:15', NULL, NULL),
(259, 11, 6, '2021-01-19 16:15:15', NULL, NULL),
(260, 11, 7, '2021-01-19 16:15:15', NULL, NULL),
(261, 11, 8, '2021-01-19 16:15:15', NULL, NULL),
(262, 11, 17, '2021-01-19 16:15:15', NULL, NULL),
(263, 11, 18, '2021-01-19 16:15:15', NULL, NULL),
(264, 11, 19, '2021-01-19 16:15:15', NULL, NULL),
(265, 11, 20, '2021-01-19 16:15:15', NULL, NULL),
(266, 11, 21, '2021-01-19 16:15:15', NULL, NULL),
(267, 11, 22, '2021-01-19 16:15:15', NULL, NULL),
(268, 11, 23, '2021-01-19 16:15:15', NULL, NULL),
(269, 11, 24, '2021-01-19 16:15:15', NULL, NULL),
(270, 11, 25, '2021-01-19 16:15:15', NULL, NULL),
(271, 11, 26, '2021-01-19 16:15:15', NULL, NULL),
(272, 11, 27, '2021-01-19 16:15:15', NULL, NULL),
(273, 11, 28, '2021-01-19 16:15:15', NULL, NULL),
(274, 11, 29, '2021-01-19 16:15:15', NULL, NULL),
(275, 11, 30, '2021-01-19 16:15:15', NULL, NULL),
(276, 11, 31, '2021-01-19 16:15:15', NULL, NULL),
(277, 11, 32, '2021-01-19 16:15:15', NULL, NULL),
(278, 11, 33, '2021-01-19 16:15:15', NULL, NULL),
(279, 11, 34, '2021-01-19 16:15:15', NULL, NULL),
(280, 11, 35, '2021-01-19 16:15:15', NULL, NULL),
(281, 11, 36, '2021-01-19 16:15:15', NULL, NULL),
(282, 11, 37, '2021-01-19 16:15:15', NULL, NULL),
(283, 11, 38, '2021-01-19 16:15:15', NULL, NULL),
(284, 11, 39, '2021-01-19 16:15:15', NULL, NULL),
(285, 11, 40, '2021-01-19 16:15:15', NULL, NULL),
(286, 11, 41, '2021-01-19 16:15:15', NULL, NULL),
(287, 11, 42, '2021-01-19 16:15:15', NULL, NULL),
(288, 11, 43, '2021-01-19 16:15:15', NULL, NULL),
(289, 11, 44, '2021-01-19 16:15:15', NULL, NULL),
(290, 11, 45, '2021-01-19 16:15:15', NULL, NULL),
(291, 11, 45, '2021-01-19 16:15:15', NULL, NULL),
(292, 11, 47, '2021-01-19 16:15:15', NULL, NULL),
(293, 11, 48, '2021-01-19 16:15:15', NULL, NULL),
(294, 11, 49, '2021-01-19 16:15:15', NULL, NULL),
(295, 11, 50, '2021-01-19 16:15:15', NULL, NULL),
(296, 11, 51, '2021-01-19 16:15:15', NULL, NULL),
(297, 11, 52, '2021-01-19 16:15:15', NULL, NULL),
(298, 12, 1, '2021-01-19 16:15:55', NULL, NULL),
(299, 12, 2, '2021-01-19 16:15:55', NULL, NULL),
(300, 12, 3, '2021-01-19 16:15:55', NULL, NULL),
(301, 12, 4, '2021-01-19 16:15:55', NULL, NULL),
(302, 12, 5, '2021-01-19 16:15:55', NULL, NULL),
(303, 12, 6, '2021-01-19 16:15:55', NULL, NULL),
(304, 12, 7, '2021-01-19 16:15:55', NULL, NULL),
(305, 12, 8, '2021-01-19 16:15:55', NULL, NULL),
(306, 12, 17, '2021-01-19 16:15:55', NULL, NULL),
(307, 12, 18, '2021-01-19 16:15:55', NULL, NULL),
(308, 12, 19, '2021-01-19 16:15:55', NULL, NULL),
(309, 12, 20, '2021-01-19 16:15:55', NULL, NULL),
(310, 12, 21, '2021-01-19 16:15:55', NULL, NULL),
(311, 12, 22, '2021-01-19 16:15:55', NULL, NULL),
(312, 12, 23, '2021-01-19 16:15:55', NULL, NULL),
(313, 12, 24, '2021-01-19 16:15:55', NULL, NULL),
(314, 12, 25, '2021-01-19 16:15:55', NULL, NULL),
(315, 12, 26, '2021-01-19 16:15:55', NULL, NULL),
(316, 12, 27, '2021-01-19 16:15:55', NULL, NULL),
(317, 12, 28, '2021-01-19 16:15:55', NULL, NULL),
(452, 10, 53, '2021-01-26 04:33:25', NULL, NULL),
(453, 10, 54, '2021-01-26 04:33:25', NULL, NULL),
(454, 10, 55, '2021-01-26 04:33:25', NULL, NULL),
(455, 10, 56, '2021-01-26 04:33:25', NULL, NULL),
(456, 10, 1, '2021-01-26 04:33:25', NULL, NULL),
(457, 10, 2, '2021-01-26 04:33:25', NULL, NULL),
(458, 10, 3, '2021-01-26 04:33:25', NULL, NULL),
(459, 10, 4, '2021-01-26 04:33:25', NULL, NULL),
(460, 10, 5, '2021-01-26 04:33:25', NULL, NULL),
(461, 10, 6, '2021-01-26 04:33:25', NULL, NULL),
(462, 10, 7, '2021-01-26 04:33:25', NULL, NULL),
(463, 10, 8, '2021-01-26 04:33:25', NULL, NULL),
(464, 10, 9, '2021-01-26 04:33:25', NULL, NULL),
(465, 10, 10, '2021-01-26 04:33:25', NULL, NULL),
(466, 10, 11, '2021-01-26 04:33:25', NULL, NULL),
(467, 10, 12, '2021-01-26 04:33:25', NULL, NULL),
(468, 10, 13, '2021-01-26 04:33:25', NULL, NULL),
(469, 10, 14, '2021-01-26 04:33:25', NULL, NULL),
(470, 10, 15, '2021-01-26 04:33:25', NULL, NULL),
(471, 10, 16, '2021-01-26 04:33:25', NULL, NULL),
(472, 10, 17, '2021-01-26 04:33:25', NULL, NULL),
(473, 10, 18, '2021-01-26 04:33:25', NULL, NULL),
(474, 10, 19, '2021-01-26 04:33:25', NULL, NULL),
(475, 10, 20, '2021-01-26 04:33:25', NULL, NULL),
(476, 10, 21, '2021-01-26 04:33:25', NULL, NULL),
(477, 10, 22, '2021-01-26 04:33:25', NULL, NULL),
(478, 10, 23, '2021-01-26 04:33:25', NULL, NULL),
(479, 10, 24, '2021-01-26 04:33:25', NULL, NULL),
(480, 10, 25, '2021-01-26 04:33:25', NULL, NULL),
(481, 10, 26, '2021-01-26 04:33:25', NULL, NULL),
(482, 10, 27, '2021-01-26 04:33:25', NULL, NULL),
(483, 10, 28, '2021-01-26 04:33:25', NULL, NULL),
(484, 10, 29, '2021-01-26 04:33:25', NULL, NULL),
(485, 10, 30, '2021-01-26 04:33:25', NULL, NULL),
(486, 10, 31, '2021-01-26 04:33:25', NULL, NULL),
(487, 10, 32, '2021-01-26 04:33:25', NULL, NULL),
(488, 10, 33, '2021-01-26 04:33:25', NULL, NULL),
(489, 10, 34, '2021-01-26 04:33:25', NULL, NULL),
(490, 10, 35, '2021-01-26 04:33:25', NULL, NULL),
(491, 10, 36, '2021-01-26 04:33:25', NULL, NULL),
(492, 10, 37, '2021-01-26 04:33:25', NULL, NULL),
(493, 10, 38, '2021-01-26 04:33:25', NULL, NULL),
(494, 10, 39, '2021-01-26 04:33:25', NULL, NULL),
(495, 10, 40, '2021-01-26 04:33:25', NULL, NULL),
(496, 10, 41, '2021-01-26 04:33:25', NULL, NULL),
(497, 10, 42, '2021-01-26 04:33:25', NULL, NULL),
(498, 10, 43, '2021-01-26 04:33:25', NULL, NULL),
(499, 10, 44, '2021-01-26 04:33:25', NULL, NULL),
(500, 10, 45, '2021-01-26 04:33:25', NULL, NULL),
(501, 10, 47, '2021-01-26 04:33:25', NULL, NULL),
(502, 10, 48, '2021-01-26 04:33:25', NULL, NULL),
(503, 10, 49, '2021-01-26 04:33:25', NULL, NULL),
(504, 10, 50, '2021-01-26 04:33:25', NULL, NULL),
(505, 10, 51, '2021-01-26 04:33:25', NULL, NULL),
(506, 10, 52, '2021-01-26 04:33:25', NULL, NULL),
(611, 13, 57, '2021-01-26 06:20:39', NULL, NULL),
(612, 13, 58, '2021-01-26 06:20:39', NULL, NULL),
(613, 13, 59, '2021-01-26 06:20:39', NULL, NULL),
(614, 13, 60, '2021-01-26 06:20:39', NULL, NULL),
(615, 13, 1, '2021-01-26 06:20:39', NULL, NULL),
(616, 13, 2, '2021-01-26 06:20:39', NULL, NULL),
(617, 13, 3, '2021-01-26 06:20:39', NULL, NULL),
(618, 13, 4, '2021-01-26 06:20:39', NULL, NULL),
(619, 13, 9, '2021-01-26 06:20:39', NULL, NULL),
(620, 13, 10, '2021-01-26 06:20:39', NULL, NULL),
(621, 13, 11, '2021-01-26 06:20:39', NULL, NULL),
(622, 13, 12, '2021-01-26 06:20:39', NULL, NULL),
(623, 13, 13, '2021-01-26 06:20:39', NULL, NULL),
(624, 13, 16, '2021-01-26 06:20:39', NULL, NULL),
(625, 13, 21, '2021-01-26 06:20:39', NULL, NULL),
(626, 13, 22, '2021-01-26 06:20:39', NULL, NULL),
(627, 13, 23, '2021-01-26 06:20:39', NULL, NULL),
(628, 13, 24, '2021-01-26 06:20:39', NULL, NULL),
(629, 13, 37, '2021-01-26 06:20:39', NULL, NULL),
(630, 13, 38, '2021-01-26 06:20:39', NULL, NULL),
(631, 13, 39, '2021-01-26 06:20:39', NULL, NULL),
(632, 13, 41, '2021-01-26 06:20:39', NULL, NULL),
(633, 13, 42, '2021-01-26 06:20:39', NULL, NULL),
(634, 13, 43, '2021-01-26 06:20:39', NULL, NULL),
(635, 13, 45, '2021-01-26 06:20:39', NULL, NULL),
(636, 13, 46, '2021-01-26 06:20:39', NULL, NULL),
(637, 13, 47, '2021-01-26 06:20:39', NULL, NULL),
(638, 9, 57, '2021-02-04 07:31:22', NULL, NULL),
(639, 9, 64, '2021-02-04 07:31:22', NULL, NULL),
(640, 9, 5, '2021-02-04 07:31:22', NULL, NULL),
(641, 9, 6, '2021-02-04 07:31:22', NULL, NULL),
(642, 9, 7, '2021-02-04 07:31:22', NULL, NULL),
(643, 9, 8, '2021-02-04 07:31:22', NULL, NULL),
(644, 9, 17, '2021-02-04 07:31:22', NULL, NULL),
(645, 9, 18, '2021-02-04 07:31:22', NULL, NULL),
(646, 9, 19, '2021-02-04 07:31:22', NULL, NULL),
(647, 9, 20, '2021-02-04 07:31:22', NULL, NULL),
(648, 9, 33, '2021-02-04 07:31:22', NULL, NULL),
(649, 9, 34, '2021-02-04 07:31:22', NULL, NULL),
(650, 9, 35, '2021-02-04 07:31:22', NULL, NULL),
(651, 9, 36, '2021-02-04 07:31:22', NULL, NULL),
(652, 14, 57, '2021-03-24 12:03:55', NULL, NULL),
(653, 14, 58, '2021-03-24 12:03:55', NULL, NULL),
(654, 14, 59, '2021-03-24 12:03:55', NULL, NULL),
(655, 15, 57, '2021-03-24 12:14:45', NULL, NULL),
(656, 15, 58, '2021-03-24 12:14:45', NULL, NULL),
(657, 15, 59, '2021-03-24 12:14:45', NULL, NULL),
(658, 15, 60, '2021-03-24 12:14:45', NULL, NULL),
(659, 15, 61, '2021-03-24 12:14:45', NULL, NULL),
(660, 15, 64, '2021-03-24 12:14:45', NULL, NULL),
(661, 15, 5, '2021-03-24 12:14:45', NULL, NULL),
(662, 15, 6, '2021-03-24 12:14:45', NULL, NULL),
(663, 15, 7, '2021-03-24 12:14:45', NULL, NULL),
(664, 15, 8, '2021-03-24 12:14:45', NULL, NULL),
(665, 15, 62, '2021-03-24 12:14:45', NULL, NULL),
(666, 16, 57, '2021-03-24 12:15:01', NULL, NULL),
(667, 16, 58, '2021-03-24 12:15:01', NULL, NULL),
(668, 16, 59, '2021-03-24 12:15:01', NULL, NULL),
(669, 16, 60, '2021-03-24 12:15:01', NULL, NULL),
(670, 16, 61, '2021-03-24 12:15:01', NULL, NULL),
(671, 16, 64, '2021-03-24 12:15:01', NULL, NULL),
(672, 16, 5, '2021-03-24 12:15:01', NULL, NULL),
(673, 16, 6, '2021-03-24 12:15:01', NULL, NULL),
(674, 16, 7, '2021-03-24 12:15:01', NULL, NULL),
(675, 16, 8, '2021-03-24 12:15:01', NULL, NULL),
(676, 16, 62, '2021-03-24 12:15:01', NULL, NULL),
(677, 16, 63, '2021-03-24 12:15:01', NULL, NULL),
(678, 6, 57, '2021-05-06 05:11:34', NULL, NULL),
(679, 6, 58, '2021-05-06 05:11:34', NULL, NULL),
(682, 3, 57, '2021-09-10 10:12:49', NULL, NULL),
(683, 3, 58, '2021-09-10 10:12:49', NULL, NULL),
(684, 3, 59, '2021-09-10 10:12:49', NULL, NULL),
(685, 3, 60, '2021-09-10 10:12:49', NULL, NULL),
(686, 3, 61, '2021-09-10 10:12:49', NULL, NULL),
(687, 3, 64, '2021-09-10 10:12:49', NULL, NULL),
(688, 5, 57, '2021-09-10 10:14:44', NULL, NULL),
(689, 5, 58, '2021-09-10 10:14:44', NULL, NULL),
(690, 5, 59, '2021-09-10 10:14:44', NULL, NULL),
(691, 5, 60, '2021-09-10 10:14:44', NULL, NULL),
(692, 5, 61, '2021-09-10 10:14:44', NULL, NULL),
(693, 5, 64, '2021-09-10 10:14:44', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rootcause_items`
--

CREATE TABLE `rootcause_items` (
  `rci_id` int(10) UNSIGNED NOT NULL,
  `rci_rc_id` int(11) DEFAULT NULL,
  `rci_parent_id` int(11) DEFAULT NULL,
  `rci_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rci_desctiption` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `rci_status` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `rootcause_items`
--

INSERT INTO `rootcause_items` (`rci_id`, `rci_rc_id`, `rci_parent_id`, `rci_name`, `rci_desctiption`, `rci_status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 'Abuse or Misuse', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(2, 1, 2, 'Excessive Wear and Tear', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(3, 1, 3, 'Inadequate Engineering', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(4, 1, 4, 'Inadequate Leadership and/or Supervision', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(5, 1, 5, 'Inadequate Maintenance', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(6, 1, 6, 'Inadequate Purchasing', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(7, 1, 7, 'Inadequate Tools and Equipment', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(8, 1, 8, 'Inadequate Work Standards', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(10, 2, 10, 'Improper Motivation', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(11, 2, 11, 'Inadequate Mental/Psychological Capability', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(12, 2, 12, 'Inadequate Physical/Physiological Capability', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(14, 2, 14, 'Lack of Skill', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(15, 2, 15, 'Mental or Physiological', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(16, 2, 16, 'Physical or Physiological Stress', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(17, 1, 1, 'Improper intentional conduct that is condoned', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(18, 1, 1, 'Improper intentional conduct that is not condoned', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(19, 1, 1, 'Improper unintentional conduct that is condoned', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(20, 1, 1, 'Improper unintentional conduct that is not condoned', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(21, 1, 2, 'Improper extension of service life', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(22, 1, 2, 'Improper loading or rate of use', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(23, 1, 2, 'Inadequate inspection and/or monitoring', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(24, 1, 2, 'Inadequate maintenance', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(25, 1, 2, 'Inadequate planning of use', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(26, 1, 2, 'Use by unqualified or untrained people', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(27, 1, 2, 'Use for wrong purposes', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(28, 1, 3, 'Inadequate assessment of loss exposures', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(29, 1, 3, 'Inadequate assessment of operation readiness', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(30, 1, 3, 'Inadequate consideration of human factors/ergonomics', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(31, 1, 3, 'Inadequate evaluation of changes', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(32, 1, 3, 'Inadequate monitoring or construction', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(33, 1, 3, 'Inadequate monitoring or initial operation readiness', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(34, 1, 3, 'Inadequate or improper controls', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(35, 1, 3, 'Inadequate standards, specifications and/or design criteria', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(36, 1, 4, 'Giving inadequate policy, Procedure, Practices or guidelines', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(37, 1, 4, 'Giving objectives, goals or standards that conflict', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(38, 1, 4, 'Improper or insufficient delegation', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(39, 1, 4, 'Inadequate identification and evaluation of loss exposures', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(40, 1, 4, 'Inadequate instructions, orientation and/or training', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(41, 1, 4, 'Inadequate or incorrect performance feedback', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(42, 1, 4, 'Inadequate or incorrect performance measurement and evaluation', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(43, 1, 4, 'Inadequate performance measurement and evaluation', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(44, 1, 4, 'Inadequate work planning or programming', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(45, 1, 4, 'Lack of supervisory/management job knowledge', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(46, 1, 4, 'Providing inadequate reference documents, directives and guidance publications', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(47, 1, 4, 'Unclear or conflicting assignment of responsibility', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(48, 1, 4, 'Unclear or conflicting reporting relationships', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(49, 1, 5, 'Inadequate adjustment/assembly', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(50, 1, 5, 'Inadequate assessment of needs', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(51, 1, 5, 'Inadequate cleaning or resurfacing', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(52, 1, 5, 'Inadequate communication of repair needs', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(53, 1, 5, 'Inadequate examination of repair units', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(54, 1, 5, 'Inadequate lubrication and servicing', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(55, 1, 5, 'Inadequate schedule of repair work', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(56, 1, 5, 'Inadequate substitution of parts during repair', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(57, 1, 6, 'Improper handling of materials', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(58, 1, 6, 'Improper salvages and/or waste disposal', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(59, 1, 6, 'Improper storage of materials', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(60, 1, 6, 'Improper transporting of materials', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(61, 1, 6, 'Inadequate communication of safety and health data', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(62, 1, 6, 'Inadequate contractor selection', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(63, 1, 6, 'Inadequate identification of hazardous materials', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(64, 1, 6, 'Inadequate mode or route of shipment', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(65, 1, 6, 'Inadequate receiving inspection and acceptance', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(66, 1, 6, 'Inadequate research on materials/equipment', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(67, 1, 6, 'Inadequate specifications on requisitions', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(68, 1, 6, 'Inadequate specifications to vendors', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(69, 1, 7, 'Inadequate adjustment/repair/maintenance', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(70, 1, 7, 'Inadequate assessment of needs and risks', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(71, 1, 7, 'Inadequate availability', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(72, 1, 7, 'Inadequate human factors/ergonomics considerations', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(73, 1, 7, 'Inadequate removal and replacement of unsuitable items', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(74, 1, 7, 'Inadequate salvage and reclamation', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(75, 1, 7, 'Inadequate standards or specifications', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(76, 1, 8, 'Inadequate communication of standards', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(77, 1, 8, 'Inadequate employee involvement in development of standards', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(78, 1, 8, 'Inadequate monitoring of compliance', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(79, 1, 8, 'Inadequate monitoring of standards', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(80, 1, 8, 'Inadequate procedures / practices / rules in development of standards', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(81, 1, 8, 'Inadequate reinforcement of standards through signs, color codes and job-aids', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(82, 1, 8, 'Inadequate standards for inventory and evaluation of exposure', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(83, 1, 8, 'Inadequate standards for process design', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(84, 1, 8, 'Inadequate tracking of workflow', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(85, 1, 8, 'Inadequate training of standards', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(86, 1, 8, 'Inadequate updation of standards', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(87, 2, 10, 'Excessive frustration', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(88, 2, 10, 'Improper attempt to avoid discomfort', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(89, 2, 10, 'Improper attempt to gain attention', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(90, 2, 10, 'Improper attempt to save time or effort', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(91, 2, 10, 'Improper performance is rewarded', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(92, 2, 10, 'Improper production incentives', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(93, 2, 10, 'Improper supervisory example', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(94, 2, 10, 'Inadequate discipline', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(95, 2, 10, 'Inadequate performance feedback', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(96, 2, 10, 'Inadequate reinforcement of proper behaviour', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(97, 2, 10, 'Inappropriate aggression', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(98, 2, 10, 'Inappropriate peer pressure', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(99, 2, 10, 'Lack of incentives', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(100, 2, 10, 'Proper performance is punished', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(101, 2, 11, 'Emotional disturbance', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(102, 2, 11, 'Fears and phobias', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(103, 2, 11, 'Inability to comprehend', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(104, 2, 11, 'Intelligence level', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(105, 2, 11, 'Low learning aptitude', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(106, 2, 11, 'Low mechanical aptitude', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(107, 2, 11, 'Memory failure', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(108, 2, 11, 'Mental Illness', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(109, 2, 11, 'Poor coordination', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(110, 2, 11, 'Poor judgment', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(111, 2, 11, 'Slow reaction time', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(112, 2, 12, 'Hearing deficiency', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(113, 2, 12, 'Inappropriate height, weight, size, strength, reach', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(114, 2, 12, 'Limited ability to sustain body positions', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(115, 2, 12, 'Other permanent physical capabilities', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(116, 2, 12, 'Other sensor deficiency (touch, taste, smell, balance)', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(117, 2, 12, 'Respiratory incapacity', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(118, 2, 12, 'Restricted range of body movement', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(119, 2, 12, 'Sensitives to sensor extremes (temperature, sound)', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(120, 2, 12, 'Substance sensitives or allergies', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(121, 2, 12, 'Temporary disabilities', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(122, 2, 12, 'Vision deficiency', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(123, 2, 14, 'Inadequate practices', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(124, 2, 14, 'Inadequate review instruction', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(125, 2, 14, 'Infrequent performance', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(126, 2, 14, 'Lack of coaching/training', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(127, 2, 14, 'Lack of Knowledge/Experience', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(128, 2, 15, 'Conflicting demands/directions', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(129, 2, 15, 'Confusing directions/demands', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(130, 2, 15, 'Emotional over load', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(131, 2, 15, 'Extreme concentration/perception demands', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(132, 2, 15, 'Extreme judgment/decision demands', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(133, 2, 15, 'Fatigue due to mental task load or speed', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(134, 2, 15, 'Meaningless or degrading activities', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(135, 2, 15, 'Mental illness', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(136, 2, 15, 'Preoccupation with problems frustration', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(137, 2, 15, 'Routine, monotony, demand for uneventful vigilance', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(138, 2, 16, 'Atmospheric pressure variation', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(139, 2, 16, 'Blood sugar insufficiency', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(140, 2, 16, 'Constrained movement', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(141, 2, 16, 'Drugs', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(142, 2, 16, 'Exposure to health hazards', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(143, 2, 16, 'Exposure to temperature extremes', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(144, 2, 16, 'Fatigue due to lack of rest', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(145, 2, 16, 'Fatigue due to sensory overload', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(146, 2, 16, 'Fatigue due to task load or duration', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(147, 2, 16, 'Injury or illness', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(148, 2, 16, 'Oxygen deficiency', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rootcause_master`
--

CREATE TABLE `rootcause_master` (
  `rc_id` int(10) UNSIGNED NOT NULL,
  `rc_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rc_desctiption` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `rc_status` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `rootcause_master`
--

INSERT INTO `rootcause_master` (`rc_id`, `rc_name`, `rc_desctiption`, `rc_status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Job Factors', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(2, 'Personal Factors', '', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `shift_master`
--

CREATE TABLE `shift_master` (
  `sm_id` int(10) UNSIGNED NOT NULL,
  `sm_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sm_status` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `shift_master`
--

INSERT INTO `shift_master` (`sm_id`, `sm_name`, `sm_status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'First', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(2, 'Second', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(3, 'Third', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL),
(4, 'General', 1, '2020-10-29 01:41:08', '2020-10-29 01:41:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sites`
--

CREATE TABLE `sites` (
  `id` int(10) UNSIGNED NOT NULL,
  `site_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `site_id` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `site_timezone` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `site_headofsafety` int(11) DEFAULT NULL,
  `site_supervisor` int(11) DEFAULT NULL,
  `sos_mobile` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `sos_email` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `site_type` int(11) DEFAULT NULL,
  `site_parent` int(11) DEFAULT NULL,
  `sub_parent` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sites`
--

INSERT INTO `sites` (`id`, `site_name`, `site_id`, `site_timezone`, `site_headofsafety`, `site_supervisor`, `sos_mobile`, `sos_email`, `status`, `site_type`, `site_parent`, `sub_parent`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Site One', 'ST123', 'UTC−5', 0, NULL, '1234657980', 'siteone@workplacedash.com', 1, 1, 1, NULL, '2021-05-19 00:30:24', '2021-05-25 05:44:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `site_headofsafety`
--

CREATE TABLE `site_headofsafety` (
  `sh_id` int(10) UNSIGNED NOT NULL,
  `sh_site_id` int(11) DEFAULT NULL,
  `sh_user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `site_headofsafety`
--

INSERT INTO `site_headofsafety` (`sh_id`, `sh_site_id`, `sh_user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 1, 1, '2021-05-25 11:14:28', NULL, NULL),
(3, 1, 2, '2021-05-25 11:14:28', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `empid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_admin` tinyint(1) DEFAULT NULL,
  `database_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `companyname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `companyid` int(11) DEFAULT NULL,
  `planguage` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `fcmtoken` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `empid`, `name`, `email`, `email_verified_at`, `password`, `is_admin`, `database_name`, `companyname`, `companyid`, `planguage`, `status`, `remember_token`, `created_at`, `updated_at`, `deleted_at`, `fcmtoken`) VALUES
(1, 'Exir1', 'paresh', 'pareshs.gc@gmail.com', '2021-04-08 18:32:56', '$2y$10$/FzthEGGiZK5uzM8Ums1WOSy7/Tp1DtOrBbsB4etV6zRTrbyR2B22', 1, 'workplacedash', 'Site One', 2, 'en', 1, NULL, '2020-10-14 18:58:24', '2021-04-08 18:32:56', NULL, NULL),
(2, 'xOmLSz', 'Kishan ujiya', 'kishanu.gc@gmail.com', '2021-05-19 11:15:15', '$2y$10$Pc42B1ZneAsxOhTQHM/XWORn8nmsb/1T9uTcOCyxpyr2/3yb26n6a', 2, 'workplacedash', 'Site One', 2, 'en', 1, NULL, '2021-05-19 04:19:39', '2021-09-09 22:56:20', NULL, NULL),
(3, 'O1c624', 'test user', 'testuser@test.com', NULL, '$2y$10$goLEeOFPqIEvQpQdf79WCu.78Zb8FCIyVMWrqksgIvm.zCTCY0hXa', 3, 'workplacedash', 'Site One', 2, 'en', 1, NULL, '2021-09-10 04:41:46', '2021-09-10 04:45:25', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_permissions`
--

CREATE TABLE `users_permissions` (
  `upd_id` int(10) UNSIGNED NOT NULL,
  `permission_pm_id` int(11) DEFAULT NULL,
  `user_by_tennat_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users_permissions`
--

INSERT INTO `users_permissions` (`upd_id`, `permission_pm_id`, `user_by_tennat_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1246, 1, 19, '2021-03-12 10:58:04', NULL, NULL),
(1247, 2, 19, '2021-03-12 10:58:04', NULL, NULL),
(1248, 3, 19, '2021-03-12 10:58:04', NULL, NULL),
(1249, 4, 19, '2021-03-12 10:58:04', NULL, NULL),
(1250, 5, 19, '2021-03-12 10:58:04', NULL, NULL),
(1251, 6, 19, '2021-03-12 10:58:04', NULL, NULL),
(1252, 7, 19, '2021-03-12 10:58:04', NULL, NULL),
(1253, 8, 19, '2021-03-12 10:58:04', NULL, NULL),
(1254, 9, 19, '2021-03-12 10:58:04', NULL, NULL),
(1255, 10, 19, '2021-03-12 10:58:04', NULL, NULL),
(1256, 11, 19, '2021-03-12 10:58:04', NULL, NULL),
(1257, 12, 19, '2021-03-12 10:58:04', NULL, NULL),
(1284, 1, 20, '2021-03-16 11:19:43', NULL, NULL),
(1285, 2, 20, '2021-03-16 11:19:43', NULL, NULL),
(1286, 3, 20, '2021-03-16 11:19:43', NULL, NULL),
(1287, 4, 20, '2021-03-16 11:19:43', NULL, NULL),
(1288, 5, 20, '2021-03-16 11:19:43', NULL, NULL),
(1289, 6, 20, '2021-03-16 11:19:43', NULL, NULL),
(1290, 7, 20, '2021-03-16 11:19:43', NULL, NULL),
(1291, 8, 20, '2021-03-16 11:19:43', NULL, NULL),
(1292, 9, 20, '2021-03-16 11:19:43', NULL, NULL),
(1293, 10, 20, '2021-03-16 11:19:43', NULL, NULL),
(1294, 11, 20, '2021-03-16 11:19:43', NULL, NULL),
(1295, 12, 20, '2021-03-16 11:19:43', NULL, NULL),
(1296, 1, 21, '2021-03-16 11:34:29', NULL, NULL),
(1297, 2, 21, '2021-03-16 11:34:29', NULL, NULL),
(1298, 3, 21, '2021-03-16 11:34:29', NULL, NULL),
(1299, 4, 21, '2021-03-16 11:34:29', NULL, NULL),
(1300, 5, 21, '2021-03-16 11:34:29', NULL, NULL),
(1301, 6, 21, '2021-03-16 11:34:29', NULL, NULL),
(1302, 7, 21, '2021-03-16 11:34:29', NULL, NULL),
(1303, 8, 21, '2021-03-16 11:34:29', NULL, NULL),
(1304, 9, 21, '2021-03-16 11:34:29', NULL, NULL),
(1305, 10, 21, '2021-03-16 11:34:29', NULL, NULL),
(1306, 11, 21, '2021-03-16 11:34:29', NULL, NULL),
(1307, 12, 21, '2021-03-16 11:34:29', NULL, NULL),
(1308, 57, 22, '2021-03-24 12:15:57', NULL, NULL),
(1309, 58, 22, '2021-03-24 12:15:57', NULL, NULL),
(1310, 59, 22, '2021-03-24 12:15:57', NULL, NULL),
(1311, 57, 23, '2021-03-24 12:16:22', NULL, NULL),
(1312, 58, 23, '2021-03-24 12:16:22', NULL, NULL),
(1313, 59, 23, '2021-03-24 12:16:22', NULL, NULL),
(1314, 60, 23, '2021-03-24 12:16:22', NULL, NULL),
(1315, 61, 23, '2021-03-24 12:16:22', NULL, NULL),
(1316, 64, 23, '2021-03-24 12:16:22', NULL, NULL),
(1317, 5, 23, '2021-03-24 12:16:22', NULL, NULL),
(1318, 6, 23, '2021-03-24 12:16:22', NULL, NULL),
(1319, 7, 23, '2021-03-24 12:16:22', NULL, NULL),
(1320, 8, 23, '2021-03-24 12:16:22', NULL, NULL),
(1321, 62, 23, '2021-03-24 12:16:22', NULL, NULL),
(1322, 63, 23, '2021-03-24 12:16:22', NULL, NULL),
(1419, 57, 18, '2021-04-09 05:38:56', NULL, NULL),
(1420, 58, 18, '2021-04-09 05:38:56', NULL, NULL),
(1421, 59, 18, '2021-04-09 05:38:56', NULL, NULL),
(1422, 57, 25, '2021-04-14 10:41:05', NULL, NULL),
(1423, 58, 25, '2021-04-14 10:41:05', NULL, NULL),
(1424, 59, 25, '2021-04-14 10:41:05', NULL, NULL),
(1425, 60, 25, '2021-04-14 10:41:05', NULL, NULL),
(1426, 61, 25, '2021-04-14 10:41:05', NULL, NULL),
(1427, 64, 25, '2021-04-14 10:41:05', NULL, NULL),
(1428, 5, 25, '2021-04-14 10:41:05', NULL, NULL),
(1429, 6, 25, '2021-04-14 10:41:05', NULL, NULL),
(1430, 7, 25, '2021-04-14 10:41:05', NULL, NULL),
(1431, 8, 25, '2021-04-14 10:41:05', NULL, NULL),
(1432, 62, 25, '2021-04-14 10:41:05', NULL, NULL),
(1433, 57, 26, '2021-04-14 11:07:27', NULL, NULL),
(1434, 58, 26, '2021-04-14 11:07:27', NULL, NULL),
(1435, 59, 26, '2021-04-14 11:07:27', NULL, NULL),
(1436, 60, 26, '2021-04-14 11:07:27', NULL, NULL),
(1437, 61, 26, '2021-04-14 11:07:27', NULL, NULL),
(1438, 64, 26, '2021-04-14 11:07:27', NULL, NULL),
(1439, 5, 26, '2021-04-14 11:07:27', NULL, NULL),
(1440, 6, 26, '2021-04-14 11:07:27', NULL, NULL),
(1441, 7, 26, '2021-04-14 11:07:27', NULL, NULL),
(1442, 8, 26, '2021-04-14 11:07:27', NULL, NULL),
(1443, 62, 26, '2021-04-14 11:07:27', NULL, NULL),
(1444, 63, 26, '2021-04-14 11:07:27', NULL, NULL),
(1445, 57, 27, '2021-04-14 11:18:25', NULL, NULL),
(1446, 58, 27, '2021-04-14 11:18:25', NULL, NULL),
(1447, 59, 27, '2021-04-14 11:18:25', NULL, NULL),
(1448, 60, 27, '2021-04-14 11:18:25', NULL, NULL),
(1449, 61, 27, '2021-04-14 11:18:25', NULL, NULL),
(1450, 64, 27, '2021-04-14 11:18:25', NULL, NULL),
(1451, 5, 27, '2021-04-14 11:18:25', NULL, NULL),
(1452, 6, 27, '2021-04-14 11:18:25', NULL, NULL),
(1453, 7, 27, '2021-04-14 11:18:25', NULL, NULL),
(1454, 8, 27, '2021-04-14 11:18:25', NULL, NULL),
(1455, 62, 27, '2021-04-14 11:18:25', NULL, NULL),
(1456, 57, 28, '2021-04-14 11:21:53', NULL, NULL),
(1457, 58, 28, '2021-04-14 11:21:53', NULL, NULL),
(1458, 59, 28, '2021-04-14 11:21:53', NULL, NULL),
(1459, 60, 28, '2021-04-14 11:21:53', NULL, NULL),
(1460, 61, 28, '2021-04-14 11:21:53', NULL, NULL),
(1461, 64, 28, '2021-04-14 11:21:53', NULL, NULL),
(1462, 5, 28, '2021-04-14 11:21:53', NULL, NULL),
(1463, 6, 28, '2021-04-14 11:21:53', NULL, NULL),
(1464, 7, 28, '2021-04-14 11:21:53', NULL, NULL),
(1465, 8, 28, '2021-04-14 11:21:53', NULL, NULL),
(1466, 62, 28, '2021-04-14 11:21:53', NULL, NULL),
(1467, 57, 29, '2021-04-14 11:32:28', NULL, NULL),
(1468, 58, 29, '2021-04-14 11:32:28', NULL, NULL),
(1469, 59, 29, '2021-04-14 11:32:28', NULL, NULL),
(1470, 1, 30, '2021-05-05 13:06:58', NULL, NULL),
(1471, 2, 30, '2021-05-05 13:06:58', NULL, NULL),
(1472, 3, 30, '2021-05-05 13:06:58', NULL, NULL),
(1473, 4, 30, '2021-05-05 13:06:58', NULL, NULL),
(1474, 5, 30, '2021-05-05 13:06:58', NULL, NULL),
(1475, 6, 30, '2021-05-05 13:06:58', NULL, NULL),
(1476, 7, 30, '2021-05-05 13:06:58', NULL, NULL),
(1477, 8, 30, '2021-05-05 13:06:58', NULL, NULL),
(1478, 9, 30, '2021-05-05 13:06:58', NULL, NULL),
(1479, 10, 30, '2021-05-05 13:06:58', NULL, NULL),
(1480, 11, 30, '2021-05-05 13:06:58', NULL, NULL),
(1481, 12, 30, '2021-05-05 13:06:58', NULL, NULL),
(1482, 13, 30, '2021-05-05 13:06:58', NULL, NULL),
(1483, 14, 30, '2021-05-05 13:06:58', NULL, NULL),
(1484, 15, 30, '2021-05-05 13:06:58', NULL, NULL),
(1485, 16, 30, '2021-05-05 13:06:58', NULL, NULL),
(1486, 17, 30, '2021-05-05 13:06:58', NULL, NULL),
(1487, 18, 30, '2021-05-05 13:06:58', NULL, NULL),
(1488, 19, 30, '2021-05-05 13:06:58', NULL, NULL),
(1489, 20, 30, '2021-05-05 13:06:58', NULL, NULL),
(1490, 21, 30, '2021-05-05 13:06:58', NULL, NULL),
(1491, 22, 30, '2021-05-05 13:06:58', NULL, NULL),
(1492, 23, 30, '2021-05-05 13:06:58', NULL, NULL),
(1493, 24, 30, '2021-05-05 13:06:58', NULL, NULL),
(1494, 25, 30, '2021-05-05 13:06:58', NULL, NULL),
(1495, 26, 30, '2021-05-05 13:06:58', NULL, NULL),
(1496, 27, 30, '2021-05-05 13:06:58', NULL, NULL),
(1497, 28, 30, '2021-05-05 13:06:58', NULL, NULL),
(1498, 29, 30, '2021-05-05 13:06:58', NULL, NULL),
(1499, 30, 30, '2021-05-05 13:06:58', NULL, NULL),
(1500, 31, 30, '2021-05-05 13:06:58', NULL, NULL),
(1501, 32, 30, '2021-05-05 13:06:58', NULL, NULL),
(1502, 33, 30, '2021-05-05 13:06:58', NULL, NULL),
(1503, 34, 30, '2021-05-05 13:06:58', NULL, NULL),
(1504, 35, 30, '2021-05-05 13:06:58', NULL, NULL),
(1505, 36, 30, '2021-05-05 13:06:58', NULL, NULL),
(1506, 37, 30, '2021-05-05 13:06:58', NULL, NULL),
(1507, 38, 30, '2021-05-05 13:06:58', NULL, NULL),
(1508, 39, 30, '2021-05-05 13:06:58', NULL, NULL),
(1509, 40, 30, '2021-05-05 13:06:58', NULL, NULL),
(1510, 41, 30, '2021-05-05 13:06:58', NULL, NULL),
(1511, 42, 30, '2021-05-05 13:06:58', NULL, NULL),
(1512, 43, 30, '2021-05-05 13:06:58', NULL, NULL),
(1513, 44, 30, '2021-05-05 13:06:58', NULL, NULL),
(1514, 45, 30, '2021-05-05 13:06:58', NULL, NULL),
(1515, 45, 30, '2021-05-05 13:06:58', NULL, NULL),
(1516, 47, 30, '2021-05-05 13:06:58', NULL, NULL),
(1517, 48, 30, '2021-05-05 13:06:58', NULL, NULL),
(1518, 49, 30, '2021-05-05 13:06:58', NULL, NULL),
(1519, 50, 30, '2021-05-05 13:06:58', NULL, NULL),
(1520, 51, 30, '2021-05-05 13:06:58', NULL, NULL),
(1521, 52, 30, '2021-05-05 13:06:58', NULL, NULL),
(1522, 57, 31, '2021-05-06 05:25:48', NULL, NULL),
(1523, 58, 31, '2021-05-06 05:25:48', NULL, NULL),
(1524, 59, 31, '2021-05-06 05:25:48', NULL, NULL),
(1525, 60, 31, '2021-05-06 05:25:48', NULL, NULL),
(1526, 57, 32, '2021-05-08 05:23:28', NULL, NULL),
(1527, 58, 32, '2021-05-08 05:23:28', NULL, NULL),
(1528, 59, 32, '2021-05-08 05:23:28', NULL, NULL),
(1529, 60, 32, '2021-05-08 05:23:28', NULL, NULL),
(1530, 57, 33, '2021-05-08 10:01:12', NULL, NULL),
(1531, 58, 33, '2021-05-08 10:01:12', NULL, NULL),
(1532, 57, 34, '2021-05-08 10:02:03', NULL, NULL),
(1533, 58, 34, '2021-05-08 10:02:03', NULL, NULL),
(1590, 1, 2, '2021-05-25 10:14:08', NULL, NULL),
(1591, 2, 2, '2021-05-25 10:14:08', NULL, NULL),
(1592, 3, 2, '2021-05-25 10:14:08', NULL, NULL),
(1593, 4, 2, '2021-05-25 10:14:08', NULL, NULL),
(1594, 5, 2, '2021-05-25 10:14:08', NULL, NULL),
(1595, 6, 2, '2021-05-25 10:14:08', NULL, NULL),
(1596, 7, 2, '2021-05-25 10:14:08', NULL, NULL),
(1597, 8, 2, '2021-05-25 10:14:08', NULL, NULL),
(1598, 9, 2, '2021-05-25 10:14:08', NULL, NULL),
(1599, 10, 2, '2021-05-25 10:14:08', NULL, NULL),
(1600, 11, 2, '2021-05-25 10:14:08', NULL, NULL),
(1601, 12, 2, '2021-05-25 10:14:08', NULL, NULL),
(1602, 13, 2, '2021-05-25 10:14:08', NULL, NULL),
(1603, 14, 2, '2021-05-25 10:14:08', NULL, NULL),
(1604, 15, 2, '2021-05-25 10:14:08', NULL, NULL),
(1605, 16, 2, '2021-05-25 10:14:08', NULL, NULL),
(1606, 65, 2, '2021-05-25 10:14:08', NULL, NULL),
(1607, 57, 1, '2021-09-10 04:18:05', NULL, NULL),
(1608, 58, 1, '2021-09-10 04:18:05', NULL, NULL),
(1609, 59, 1, '2021-09-10 04:18:05', NULL, NULL),
(1610, 60, 1, '2021-09-10 04:18:05', NULL, NULL),
(1611, 61, 1, '2021-09-10 04:18:05', NULL, NULL),
(1612, 64, 1, '2021-09-10 04:18:05', NULL, NULL),
(1613, 53, 1, '2021-09-10 04:18:05', NULL, NULL),
(1614, 54, 1, '2021-09-10 04:18:05', NULL, NULL),
(1615, 55, 1, '2021-09-10 04:18:05', NULL, NULL),
(1616, 56, 1, '2021-09-10 04:18:05', NULL, NULL),
(1617, 1, 1, '2021-09-10 04:18:05', NULL, NULL),
(1618, 2, 1, '2021-09-10 04:18:05', NULL, NULL),
(1619, 3, 1, '2021-09-10 04:18:05', NULL, NULL),
(1620, 4, 1, '2021-09-10 04:18:05', NULL, NULL),
(1621, 5, 1, '2021-09-10 04:18:05', NULL, NULL),
(1622, 6, 1, '2021-09-10 04:18:05', NULL, NULL),
(1623, 7, 1, '2021-09-10 04:18:05', NULL, NULL),
(1624, 8, 1, '2021-09-10 04:18:05', NULL, NULL),
(1625, 62, 1, '2021-09-10 04:18:05', NULL, NULL),
(1626, 9, 1, '2021-09-10 04:18:05', NULL, NULL),
(1627, 10, 1, '2021-09-10 04:18:05', NULL, NULL),
(1628, 11, 1, '2021-09-10 04:18:05', NULL, NULL),
(1629, 12, 1, '2021-09-10 04:18:05', NULL, NULL),
(1630, 13, 1, '2021-09-10 04:18:05', NULL, NULL),
(1631, 14, 1, '2021-09-10 04:18:05', NULL, NULL),
(1632, 15, 1, '2021-09-10 04:18:05', NULL, NULL),
(1633, 16, 1, '2021-09-10 04:18:05', NULL, NULL),
(1634, 65, 1, '2021-09-10 04:18:05', NULL, NULL),
(1635, 17, 1, '2021-09-10 04:18:05', NULL, NULL),
(1636, 18, 1, '2021-09-10 04:18:05', NULL, NULL),
(1637, 19, 1, '2021-09-10 04:18:05', NULL, NULL),
(1638, 20, 1, '2021-09-10 04:18:05', NULL, NULL),
(1639, 21, 1, '2021-09-10 04:18:05', NULL, NULL),
(1640, 22, 1, '2021-09-10 04:18:05', NULL, NULL),
(1641, 23, 1, '2021-09-10 04:18:05', NULL, NULL),
(1642, 24, 1, '2021-09-10 04:18:05', NULL, NULL),
(1643, 25, 1, '2021-09-10 04:18:05', NULL, NULL),
(1644, 26, 1, '2021-09-10 04:18:05', NULL, NULL),
(1645, 27, 1, '2021-09-10 04:18:05', NULL, NULL),
(1646, 28, 1, '2021-09-10 04:18:05', NULL, NULL),
(1647, 29, 1, '2021-09-10 04:18:05', NULL, NULL),
(1648, 30, 1, '2021-09-10 04:18:05', NULL, NULL),
(1649, 31, 1, '2021-09-10 04:18:05', NULL, NULL),
(1650, 32, 1, '2021-09-10 04:18:05', NULL, NULL),
(1651, 33, 1, '2021-09-10 04:18:05', NULL, NULL),
(1652, 34, 1, '2021-09-10 04:18:05', NULL, NULL),
(1653, 35, 1, '2021-09-10 04:18:05', NULL, NULL),
(1654, 36, 1, '2021-09-10 04:18:05', NULL, NULL),
(1655, 37, 1, '2021-09-10 04:18:05', NULL, NULL),
(1656, 38, 1, '2021-09-10 04:18:05', NULL, NULL),
(1657, 39, 1, '2021-09-10 04:18:05', NULL, NULL),
(1658, 40, 1, '2021-09-10 04:18:05', NULL, NULL),
(1659, 41, 1, '2021-09-10 04:18:05', NULL, NULL),
(1660, 42, 1, '2021-09-10 04:18:05', NULL, NULL),
(1661, 43, 1, '2021-09-10 04:18:05', NULL, NULL),
(1662, 44, 1, '2021-09-10 04:18:05', NULL, NULL),
(1663, 45, 1, '2021-09-10 04:18:05', NULL, NULL),
(1664, 46, 1, '2021-09-10 04:18:05', NULL, NULL),
(1665, 47, 1, '2021-09-10 04:18:05', NULL, NULL),
(1666, 48, 1, '2021-09-10 04:18:05', NULL, NULL),
(1667, 49, 1, '2021-09-10 04:18:05', NULL, NULL),
(1668, 50, 1, '2021-09-10 04:18:05', NULL, NULL),
(1669, 51, 1, '2021-09-10 04:18:05', NULL, NULL),
(1670, 52, 1, '2021-09-10 04:18:05', NULL, NULL),
(1707, 57, 3, '2021-09-10 10:15:25', NULL, NULL),
(1708, 58, 3, '2021-09-10 10:15:25', NULL, NULL),
(1709, 59, 3, '2021-09-10 10:15:25', NULL, NULL),
(1710, 60, 3, '2021-09-10 10:15:25', NULL, NULL),
(1711, 61, 3, '2021-09-10 10:15:25', NULL, NULL),
(1712, 64, 3, '2021-09-10 10:15:25', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_roles`
--

CREATE TABLE `users_roles` (
  `urid` int(10) UNSIGNED NOT NULL,
  `user_by_tennat_id` int(11) DEFAULT NULL,
  `roles_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users_roles`
--

INSERT INTO `users_roles` (`urid`, `user_by_tennat_id`, `roles_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, '2020-10-29 07:11:08', NULL, NULL),
(14, 18, 14, '2021-03-12 10:57:21', NULL, NULL),
(15, 19, 4, '2021-03-12 10:58:04', NULL, NULL),
(16, 20, 4, '2021-03-16 11:19:43', NULL, NULL),
(17, 21, 4, '2021-03-16 11:34:29', NULL, NULL),
(18, 22, 14, '2021-03-24 12:15:57', NULL, NULL),
(19, 23, 16, '2021-03-24 12:16:22', NULL, NULL),
(20, 25, 15, '2021-04-14 10:41:05', NULL, NULL),
(21, 26, 16, '2021-04-14 11:07:27', NULL, NULL),
(22, 27, 15, '2021-04-14 11:18:25', NULL, NULL),
(23, 28, 15, '2021-04-14 11:21:53', NULL, NULL),
(24, 29, 14, '2021-04-14 11:32:28', NULL, NULL),
(25, 30, 6, '2021-05-05 13:06:58', NULL, NULL),
(26, 31, 6, '2021-05-06 05:25:48', NULL, NULL),
(27, 32, 6, '2021-05-08 05:23:28', NULL, NULL),
(28, 33, 6, '2021-05-08 10:01:12', NULL, NULL),
(29, 34, 6, '2021-05-08 10:02:03', NULL, NULL),
(30, 2, 2, '2021-05-19 09:49:49', NULL, NULL),
(31, 3, 3, '2021-09-10 10:11:53', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_site_relation`
--

CREATE TABLE `user_site_relation` (
  `us_id` int(10) UNSIGNED NOT NULL,
  `site_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_site_relation`
--

INSERT INTO `user_site_relation` (`us_id`, `site_id`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, '2021-05-19 06:00:53', NULL, NULL),
(4, 1, 2, '2021-09-10 04:26:20', NULL, NULL),
(12, 1, 3, '2021-09-10 10:15:25', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vaccinations`
--

CREATE TABLE `vaccinations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vaccinated` tinyint(1) NOT NULL DEFAULT 0,
  `date_administered` datetime DEFAULT NULL,
  `vaccine_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `other_vaccine_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `picture` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `second_vaccinated` tinyint(1) NOT NULL DEFAULT 0,
  `second_date_administered` datetime DEFAULT NULL,
  `second_other_vaccine_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `second_vaccine_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `second_picture` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `vaccinations`
--

INSERT INTO `vaccinations` (`id`, `vaccinated`, `date_administered`, `vaccine_type`, `other_vaccine_type`, `picture`, `second_vaccinated`, `second_date_administered`, `second_other_vaccine_type`, `second_vaccine_type`, `second_picture`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '2023-06-22 17:49:00', 'Pfizer', NULL, 'Site One/AIusAvTgxiCcPbC08toTy4J2XVLfptgw9QgAPgHz.png', 1, '2023-06-16 17:49:00', NULL, 'AstraZeneca', NULL, 1, '2023-06-22 06:50:58', '2023-06-22 06:50:58', NULL),
(2, 1, '2023-06-13 22:11:00', 'AstraZeneca', NULL, 'Site One/l6SHp4ZscZelSidH4Mr2Iu94Jl4GwUELsF1pJzLF.png', 1, '2023-06-17 22:11:00', NULL, 'AstraZeneca', 'Site One/ZhVbkrQ0uj4hI75GtIIHlj4iX5rFQR5C2NFXK65h.png', 1, '2023-06-22 11:13:15', '2023-06-22 11:13:15', NULL),
(4, 1, '2023-06-12 22:27:00', 'Moderna', NULL, 'Site One/jk72GaGs7f1MTGVUEdG8Z60uxMay39SxpSbrBAse.png', 1, '2023-06-21 22:33:00', 'QQQQQQQQQQQQ', 'Other', NULL, 1, '2023-06-22 11:28:03', '2023-06-22 11:34:05', NULL),
(5, 1, '2023-06-01 22:36:00', 'Pfizer', NULL, 'Site One/idfiJImJnXDQiip016owdMfgVoaLwaMLjyENE8Ye.png', 1, '2023-06-02 22:37:00', '1111111111', 'Other', 'Site One/huPenO9DCGDvvZ4rUehl8izudC14uJIdjhK29dXW.png', 1, '2023-06-22 11:37:16', '2023-06-22 11:37:16', NULL),
(6, 1, '2023-06-23 11:30:00', 'Moderna', NULL, 'Site One/N2HherMHeYiDJrmcz7VqQn5NIZXZvakP5rH3PNFZ.png', 1, '2023-06-24 11:31:00', 'Test Other', 'Other', NULL, 1, '2023-06-23 00:31:26', '2023-06-23 00:31:26', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `actions_attachement_rel`
--
ALTER TABLE `actions_attachement_rel`
  ADD PRIMARY KEY (`aa_id`);

--
-- Indexes for table `actions_master`
--
ALTER TABLE `actions_master`
  ADD PRIMARY KEY (`am_id`);

--
-- Indexes for table `actions_responsible`
--
ALTER TABLE `actions_responsible`
  ADD PRIMARY KEY (`ar_id`);

--
-- Indexes for table `audit_answer_master`
--
ALTER TABLE `audit_answer_master`
  ADD PRIMARY KEY (`aam_id`);

--
-- Indexes for table `audit_checkbox_optoin`
--
ALTER TABLE `audit_checkbox_optoin`
  ADD PRIMARY KEY (`aco_id`);

--
-- Indexes for table `audit_checkbox_question_option`
--
ALTER TABLE `audit_checkbox_question_option`
  ADD PRIMARY KEY (`acqo_id`);

--
-- Indexes for table `audit_frequency`
--
ALTER TABLE `audit_frequency`
  ADD PRIMARY KEY (`af_id`);

--
-- Indexes for table `audit_gridview_option`
--
ALTER TABLE `audit_gridview_option`
  ADD PRIMARY KEY (`ago_id`);

--
-- Indexes for table `audit_keyfinding`
--
ALTER TABLE `audit_keyfinding`
  ADD PRIMARY KEY (`ak_id`);

--
-- Indexes for table `audit_master`
--
ALTER TABLE `audit_master`
  ADD PRIMARY KEY (`adm_id`);

--
-- Indexes for table `audit_section_completed`
--
ALTER TABLE `audit_section_completed`
  ADD PRIMARY KEY (`asc_id`);

--
-- Indexes for table `audit_templates_master`
--
ALTER TABLE `audit_templates_master`
  ADD PRIMARY KEY (`atm_id`);

--
-- Indexes for table `audit_templates_parts`
--
ALTER TABLE `audit_templates_parts`
  ADD PRIMARY KEY (`atp_id`);

--
-- Indexes for table `audit_template_parts_questions`
--
ALTER TABLE `audit_template_parts_questions`
  ADD PRIMARY KEY (`atpq_id`);

--
-- Indexes for table `audit_timeline`
--
ALTER TABLE `audit_timeline`
  ADD PRIMARY KEY (`atl_id`);

--
-- Indexes for table `audit_usernotify`
--
ALTER TABLE `audit_usernotify`
  ADD PRIMARY KEY (`aun_id`);

--
-- Indexes for table `bodypart_master`
--
ALTER TABLE `bodypart_master`
  ADD PRIMARY KEY (`bpm_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category_type`
--
ALTER TABLE `category_type`
  ADD PRIMARY KEY (`ct_id`);

--
-- Indexes for table `control_master`
--
ALTER TABLE `control_master`
  ADD PRIMARY KEY (`cm_id`);

--
-- Indexes for table `flights`
--
ALTER TABLE `flights`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `incidents_attachement_rel`
--
ALTER TABLE `incidents_attachement_rel`
  ADD PRIMARY KEY (`ia_id`);

--
-- Indexes for table `incidents_investigation_team`
--
ALTER TABLE `incidents_investigation_team`
  ADD PRIMARY KEY (`iit_id`);

--
-- Indexes for table `incidents_master`
--
ALTER TABLE `incidents_master`
  ADD PRIMARY KEY (`im_id`);

--
-- Indexes for table `incidents_rating`
--
ALTER TABLE `incidents_rating`
  ADD PRIMARY KEY (`ir_id`);

--
-- Indexes for table `incidents_root_cause`
--
ALTER TABLE `incidents_root_cause`
  ADD PRIMARY KEY (`irc_id`);

--
-- Indexes for table `incidents_root_cause_description`
--
ALTER TABLE `incidents_root_cause_description`
  ADD PRIMARY KEY (`ircd_id`);

--
-- Indexes for table `incidents_victim`
--
ALTER TABLE `incidents_victim`
  ADD PRIMARY KEY (`iv_id`);

--
-- Indexes for table `incidents_victim_bodypart`
--
ALTER TABLE `incidents_victim_bodypart`
  ADD PRIMARY KEY (`ivbp_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `observations_attachement_rel`
--
ALTER TABLE `observations_attachement_rel`
  ADD PRIMARY KEY (`oar_id`);

--
-- Indexes for table `observations_master`
--
ALTER TABLE `observations_master`
  ADD PRIMARY KEY (`ob_id`);

--
-- Indexes for table `observations_reply_attachement`
--
ALTER TABLE `observations_reply_attachement`
  ADD PRIMARY KEY (`ora_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions_master`
--
ALTER TABLE `permissions_master`
  ADD PRIMARY KEY (`pm_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_log`
--
ALTER TABLE `role_log`
  ADD PRIMARY KEY (`rl_id`);

--
-- Indexes for table `role_permissions_master`
--
ALTER TABLE `role_permissions_master`
  ADD PRIMARY KEY (`rpm_id`);

--
-- Indexes for table `rootcause_items`
--
ALTER TABLE `rootcause_items`
  ADD PRIMARY KEY (`rci_id`);

--
-- Indexes for table `rootcause_master`
--
ALTER TABLE `rootcause_master`
  ADD PRIMARY KEY (`rc_id`);

--
-- Indexes for table `shift_master`
--
ALTER TABLE `shift_master`
  ADD PRIMARY KEY (`sm_id`);

--
-- Indexes for table `sites`
--
ALTER TABLE `sites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_headofsafety`
--
ALTER TABLE `site_headofsafety`
  ADD PRIMARY KEY (`sh_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `users_permissions`
--
ALTER TABLE `users_permissions`
  ADD PRIMARY KEY (`upd_id`);

--
-- Indexes for table `users_roles`
--
ALTER TABLE `users_roles`
  ADD PRIMARY KEY (`urid`);

--
-- Indexes for table `user_site_relation`
--
ALTER TABLE `user_site_relation`
  ADD PRIMARY KEY (`us_id`);

--
-- Indexes for table `vaccinations`
--
ALTER TABLE `vaccinations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `actions_attachement_rel`
--
ALTER TABLE `actions_attachement_rel`
  MODIFY `aa_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `actions_master`
--
ALTER TABLE `actions_master`
  MODIFY `am_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `actions_responsible`
--
ALTER TABLE `actions_responsible`
  MODIFY `ar_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audit_answer_master`
--
ALTER TABLE `audit_answer_master`
  MODIFY `aam_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audit_checkbox_optoin`
--
ALTER TABLE `audit_checkbox_optoin`
  MODIFY `aco_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `audit_checkbox_question_option`
--
ALTER TABLE `audit_checkbox_question_option`
  MODIFY `acqo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `audit_frequency`
--
ALTER TABLE `audit_frequency`
  MODIFY `af_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `audit_gridview_option`
--
ALTER TABLE `audit_gridview_option`
  MODIFY `ago_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audit_keyfinding`
--
ALTER TABLE `audit_keyfinding`
  MODIFY `ak_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audit_master`
--
ALTER TABLE `audit_master`
  MODIFY `adm_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audit_section_completed`
--
ALTER TABLE `audit_section_completed`
  MODIFY `asc_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audit_templates_master`
--
ALTER TABLE `audit_templates_master`
  MODIFY `atm_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `audit_templates_parts`
--
ALTER TABLE `audit_templates_parts`
  MODIFY `atp_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `audit_template_parts_questions`
--
ALTER TABLE `audit_template_parts_questions`
  MODIFY `atpq_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `audit_timeline`
--
ALTER TABLE `audit_timeline`
  MODIFY `atl_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audit_usernotify`
--
ALTER TABLE `audit_usernotify`
  MODIFY `aun_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bodypart_master`
--
ALTER TABLE `bodypart_master`
  MODIFY `bpm_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `category_type`
--
ALTER TABLE `category_type`
  MODIFY `ct_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `control_master`
--
ALTER TABLE `control_master`
  MODIFY `cm_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `flights`
--
ALTER TABLE `flights`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `incidents_attachement_rel`
--
ALTER TABLE `incidents_attachement_rel`
  MODIFY `ia_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `incidents_investigation_team`
--
ALTER TABLE `incidents_investigation_team`
  MODIFY `iit_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `incidents_master`
--
ALTER TABLE `incidents_master`
  MODIFY `im_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `incidents_rating`
--
ALTER TABLE `incidents_rating`
  MODIFY `ir_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `incidents_root_cause`
--
ALTER TABLE `incidents_root_cause`
  MODIFY `irc_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=298;

--
-- AUTO_INCREMENT for table `incidents_root_cause_description`
--
ALTER TABLE `incidents_root_cause_description`
  MODIFY `ircd_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `incidents_victim`
--
ALTER TABLE `incidents_victim`
  MODIFY `iv_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `incidents_victim_bodypart`
--
ALTER TABLE `incidents_victim_bodypart`
  MODIFY `ivbp_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `observations_attachement_rel`
--
ALTER TABLE `observations_attachement_rel`
  MODIFY `oar_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `observations_master`
--
ALTER TABLE `observations_master`
  MODIFY `ob_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `observations_reply_attachement`
--
ALTER TABLE `observations_reply_attachement`
  MODIFY `ora_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions_master`
--
ALTER TABLE `permissions_master`
  MODIFY `pm_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=616;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `role_log`
--
ALTER TABLE `role_log`
  MODIFY `rl_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `role_permissions_master`
--
ALTER TABLE `role_permissions_master`
  MODIFY `rpm_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=694;

--
-- AUTO_INCREMENT for table `rootcause_items`
--
ALTER TABLE `rootcause_items`
  MODIFY `rci_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- AUTO_INCREMENT for table `rootcause_master`
--
ALTER TABLE `rootcause_master`
  MODIFY `rc_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `shift_master`
--
ALTER TABLE `shift_master`
  MODIFY `sm_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sites`
--
ALTER TABLE `sites`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `site_headofsafety`
--
ALTER TABLE `site_headofsafety`
  MODIFY `sh_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users_permissions`
--
ALTER TABLE `users_permissions`
  MODIFY `upd_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1713;

--
-- AUTO_INCREMENT for table `users_roles`
--
ALTER TABLE `users_roles`
  MODIFY `urid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `user_site_relation`
--
ALTER TABLE `user_site_relation`
  MODIFY `us_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `vaccinations`
--
ALTER TABLE `vaccinations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
