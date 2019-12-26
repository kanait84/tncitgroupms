-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 26, 2019 at 03:45 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tncitgroupms`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `u_id` bigint(20) UNSIGNED NOT NULL,
  `r_id` bigint(20) UNSIGNED NOT NULL,
  `comment` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `u_id`, `r_id`, `comment`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 87, 32, 'sds', NULL, '2019-12-24 06:38:38', '2019-12-24 06:38:38');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `d_id` bigint(20) UNSIGNED NOT NULL,
  `d_title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `d_description` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`d_id`, `d_title`, `d_description`, `created_at`, `updated_at`) VALUES
(1, 'Marketing Department', 'Digital Marketing', '2019-08-07 23:30:21', '2019-08-07 23:30:21'),
(2, 'IT Department', 'Assigned for Application, Blockchain, Cyber Security', '2019-08-07 23:40:13', '2019-08-07 23:40:13'),
(3, 'Top Management', 'Oversee all business development.', '2019-08-07 23:40:35', '2019-08-07 23:40:35'),
(4, 'Human Resource Department', 'Assigned for internal company regulations and process', '2019-08-07 23:41:02', '2019-08-07 23:41:02'),
(5, 'Accounting Department', 'Assigned for transaction process internally for company.', '2019-08-07 23:41:17', '2019-08-07 23:41:17');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_07_23_062252_create_reports_table', 1),
(4, '2019_07_23_082272_create_comments_table', 1),
(5, '2019_08_07_105131_create_department_table', 1),
(6, '2019_08_07_105143_create_sub_department_table', 1),
(7, '2019_08_21_072253_create_notifications_table', 1),
(8, '2019_11_11_110309_create_overtimerequests_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('03850edf-7f6f-40d8-83d9-7ffbff0bbacf', 'App\\Notifications\\OtHRApprove', 'App\\User', 87, '{\"data\":\"Maricel Bea Approved the OverTime of the date - 2019-12-16\",\"u_id\":\"87\",\"report_uid\":\"3\",\"otdate\":\"2019-12-16\"}', '2019-12-23 10:32:48', '2019-12-23 10:25:27', '2019-12-23 10:25:27'),
('05b98740-ec26-450f-8f9a-885f69abeaa0', 'App\\Notifications\\OtHRApprove', 'App\\User', 87, '{\"data\":\"Maricel Bea Approved the OverTime of the date - 2019-12-23\",\"u_id\":\"87\",\"report_uid\":\"3\",\"otdate\":\"2019-12-23\"}', '2019-12-23 10:32:50', '2019-12-23 10:25:23', '2019-12-23 10:25:23'),
('0e09f064-8eb5-4b34-92a0-c561cf4db1c5', 'App\\Notifications\\OverTimeRequest', 'App\\User', 4, '{\"data\":\"kanagaraj requested OverTime of the date - 2019-12-10\",\"u_id\":87,\"mgr_id\":\"4\",\"report_uid\":\"3\",\"reportdate\":\"2019-12-10\"}', '2019-12-23 10:00:18', '2019-12-23 09:59:29', '2019-12-23 09:59:29'),
('137b731a-a7a4-4e7e-bd05-fa920edbc150', 'App\\Notifications\\OtHRRequest', 'App\\User', 82, '{\"data\":\"kanagaraj requested OverTime of the date - 2019-12-23\",\"u_id\":\"87\",\"report_uid\":\"3\",\"otdate\":\"2019-12-23\"}', '2019-12-23 10:25:23', '2019-12-23 06:57:35', '2019-12-23 06:57:35'),
('19d889c1-f44f-4855-99f8-e0805547d891', 'App\\Notifications\\OtAfterMgrApprove', 'App\\User', 3, '{\"data\":\"kanagaraj requested OverTime of the date - 2019-12-23\",\"u_id\":\"87\",\"report_uid\":\"3\",\"otdate\":\"2019-12-23\"}', '2019-12-23 09:21:52', '2019-12-23 04:46:21', '2019-12-23 04:46:21'),
('1aa9b856-6422-47d6-8401-34f0f2c0e3bc', 'App\\Notifications\\OtHRApprove', 'App\\User', 87, '{\"data\":\"Maricel Bea Approved the OverTime of the date - 2019-12-23\",\"u_id\":\"87\",\"report_uid\":\"3\",\"otdate\":\"2019-12-23\"}', '2019-12-23 09:37:27', '2019-12-23 09:22:10', '2019-12-23 09:22:10'),
('2211894d-c2f2-4241-b518-391b69707a35', 'App\\Notifications\\OverTimeRequest', 'App\\User', 4, '{\"data\":\"kanagaraj requested OverTime of the date - 2019-12-12\",\"u_id\":87,\"mgr_id\":\"4\",\"report_uid\":\"3\",\"reportdate\":\"2019-12-12\"}', '2019-12-23 09:58:00', '2019-12-23 09:57:42', '2019-12-23 09:57:42'),
('2fea2b79-56b0-4d78-be7f-8e6688b8b5c2', 'App\\Notifications\\OtHRRequest', 'App\\User', 82, '{\"data\":\"kanagaraj requested OverTime of the date - 2019-12-16\",\"u_id\":\"87\",\"report_uid\":\"3\",\"otdate\":\"2019-12-16\"}', '2019-12-23 09:56:50', '2019-12-23 09:54:54', '2019-12-23 09:54:54'),
('3f464f49-517e-4c33-99e1-0de076c3d693', 'App\\Notifications\\OverTimeRequest', 'App\\User', 4, '{\"data\":\"kanagaraj requested OverTime of the date - 2019-12-23\",\"u_id\":87,\"mgr_id\":\"4\",\"report_uid\":\"3\",\"reportdate\":\"2019-12-23\"}', '2019-12-23 04:46:21', '2019-12-23 04:45:40', '2019-12-23 04:45:40'),
('45efc85c-8b08-49cb-93ab-9e5f5363ec78', 'App\\Notifications\\OtAfterMgrApprove', 'App\\User', 3, '{\"data\":\"kanagaraj requested OverTime of the date - 2019-12-14\",\"u_id\":\"87\",\"report_uid\":\"3\",\"otdate\":\"2019-12-14\"}', '2019-12-23 10:57:11', '2019-12-23 10:54:16', '2019-12-23 10:54:16'),
('4a8be45b-8d78-4106-9298-2524ce2498d6', 'App\\Notifications\\ReportComment', 'App\\User', 4, '{\"data\":\"Kanagaraj Chinnadurai commented the report of the date - 2019-12-21\",\"u_id\":87,\"r_id\":32,\"reportdate\":\"2019-12-21\"}', NULL, '2019-12-24 06:38:39', '2019-12-24 06:38:39'),
('4cce0592-6db3-449d-8bf3-11651b95ce6c', 'App\\Notifications\\OtHRRequest', 'App\\User', 82, '{\"data\":\"kanagaraj requested OverTime of the date - 2019-12-23\",\"u_id\":\"87\",\"report_uid\":\"3\",\"otdate\":\"2019-12-23\"}', '2019-12-23 09:22:10', '2019-12-23 09:21:52', '2019-12-23 09:21:52'),
('5ab43e83-74de-483a-8054-48b24c044fc5', 'App\\Notifications\\OverTimeRequest', 'App\\User', 4, '{\"data\":\"kanagaraj requested OverTime of the date - 2019-12-14\",\"u_id\":87,\"mgr_id\":\"4\",\"report_uid\":\"3\",\"reportdate\":\"2019-12-14\"}', '2019-12-23 10:54:16', '2019-12-23 10:36:54', '2019-12-23 10:36:54'),
('63c4c9b6-a91a-42e1-ab6a-1be1528574d2', 'App\\Notifications\\OtHRReject', 'App\\User', 87, '{\"data\":\"Maricel Bea rejected your report of the date - 2019-12-23\",\"u_id\":\"87\",\"r_id\":\"3\",\"reportdate\":\"2019-12-23\"}', '2019-12-23 09:37:22', '2019-12-23 09:24:52', '2019-12-23 09:24:52'),
('6b72f9f6-51f5-4309-8aec-792375a52605', 'App\\Notifications\\OtAfterMgrDisApprove', 'App\\User', 87, '{\"data\":\"Jene Claude Dizon rejected the OverTime of the date - 2019-12-12\",\"u_id\":\"87\",\"report_uid\":\"4\",\"otdate\":\"2019-12-12\"}', '2019-12-23 09:58:25', '2019-12-23 09:58:01', '2019-12-23 09:58:01'),
('7066de20-58ef-4e0b-98b6-cb69875d3e1d', 'App\\Notifications\\OtAfterMgrApprove', 'App\\User', 3, '{\"data\":\"kanagaraj requested OverTime of the date - 2019-12-16\",\"u_id\":\"87\",\"report_uid\":\"3\",\"otdate\":\"2019-12-16\"}', '2019-12-23 09:54:54', '2019-12-23 09:53:33', '2019-12-23 09:53:33'),
('7767d8a0-b097-4573-8ba6-9622628d2f84', 'App\\Notifications\\OtHRRequest', 'App\\User', 82, '{\"data\":\"kanagaraj requested OverTime of the date - 2019-12-16\",\"u_id\":\"87\",\"report_uid\":\"3\",\"otdate\":\"2019-12-16\"}', '2019-12-23 10:25:27', '2019-12-23 09:54:11', '2019-12-23 09:54:11'),
('82b25ae7-8b8b-4bfb-b0bf-c49bed0f1f5b', 'App\\Notifications\\OtHRApprove', 'App\\User', 87, '{\"data\":\"Maricel Bea Approved the OverTime of the date - 2019-12-14\",\"u_id\":\"87\",\"report_uid\":\"3\",\"otdate\":\"2019-12-14\"}', '2019-12-24 01:09:40', '2019-12-23 10:59:55', '2019-12-23 10:59:55'),
('86782171-8185-4fc2-817a-bfe69495a897', 'App\\Notifications\\OtAfterMgrApprove', 'App\\User', 3, '{\"data\":\"kanagaraj requested OverTime of the date - 2019-12-20\",\"u_id\":\"87\",\"report_uid\":\"3\",\"otdate\":\"2019-12-20\"}', '2019-12-22 10:24:43', '2019-12-22 10:13:20', '2019-12-22 10:13:20'),
('8e970a4c-0102-44d3-a687-5442b831de7d', 'App\\Notifications\\OverTimeRequest', 'App\\User', 4, '{\"data\":\"kanagaraj requested OverTime of the date - 2019-12-22\",\"u_id\":87,\"mgr_id\":\"4\",\"report_uid\":\"3\",\"reportdate\":\"2019-12-22\"}', '2019-12-22 10:03:55', '2019-12-22 09:55:22', '2019-12-22 09:55:22'),
('98fb51f7-45b4-4ed6-a4bf-a6beb2945e72', 'App\\Notifications\\OtHRRequest', 'App\\User', 82, '{\"data\":\"kanagaraj requested OverTime of the date - 2019-12-10\",\"u_id\":\"87\",\"report_uid\":\"3\",\"otdate\":\"2019-12-10\"}', '2019-12-23 10:03:08', '2019-12-23 10:01:01', '2019-12-23 10:01:01'),
('b85adff0-6856-44f0-9bae-4edf01183902', 'App\\Notifications\\OtAfterTopMgtApprove', 'App\\User', 87, '{\"data\":\"Harry Jung Approved the OverTime of the date - 2019-12-22\",\"u_id\":\"87\",\"report_uid\":\"3\",\"otdate\":\"2019-12-22\"}', '2019-12-23 04:45:02', '2019-12-22 10:20:43', '2019-12-22 10:20:43'),
('b9818d45-1367-47da-a415-aaa65d3baba3', 'App\\Notifications\\OverTimeRequest', 'App\\User', 4, '{\"data\":\"kanagaraj requested OverTime of the date - 2019-12-16\",\"u_id\":87,\"mgr_id\":\"4\",\"report_uid\":\"3\",\"reportdate\":\"2019-12-16\"}', '2019-12-23 09:53:33', '2019-12-23 09:52:59', '2019-12-23 09:52:59'),
('becd4d67-54f7-4f91-855d-a5bf7af1b911', 'App\\Notifications\\OtAfterTopMgtApprove', 'App\\User', 87, '{\"data\":\"Harry Jung Approved the OverTime of the date - 2019-12-20\",\"u_id\":\"87\",\"report_uid\":\"3\",\"otdate\":\"2019-12-20\"}', '2019-12-23 04:44:59', '2019-12-22 10:24:44', '2019-12-22 10:24:44'),
('c133aada-7773-47d6-998f-fe80da5a6b05', 'App\\Notifications\\OtHRRequest', 'App\\User', 82, '{\"data\":\"kanagaraj requested OverTime of the date - 2019-12-14\",\"u_id\":\"87\",\"report_uid\":\"3\",\"otdate\":\"2019-12-14\"}', '2019-12-23 10:59:55', '2019-12-23 10:57:11', '2019-12-23 10:57:11'),
('d71067e4-44de-40fa-93fb-7dbd82b4bd72', 'App\\Notifications\\OtAfterMgrApprove', 'App\\User', 3, '{\"data\":\"kanagaraj requested OverTime of the date - 2019-12-22\",\"u_id\":\"87\",\"report_uid\":\"3\",\"otdate\":\"2019-12-22\"}', '2019-12-22 10:20:43', '2019-12-22 10:03:55', '2019-12-22 10:03:55'),
('d8b03c39-dc2b-4a37-aca6-5916cc0eaedf', 'App\\Notifications\\OtAfterMgrApprove', 'App\\User', 3, '{\"data\":\"kanagaraj requested OverTime of the date - 2019-12-10\",\"u_id\":\"87\",\"report_uid\":\"3\",\"otdate\":\"2019-12-10\"}', '2019-12-23 10:01:01', '2019-12-23 10:00:19', '2019-12-23 10:00:19'),
('e72d2df3-a8d5-45b3-9f90-c98e29612bef', 'App\\Notifications\\OverTimeRequest', 'App\\User', 4, '{\"data\":\"kanagaraj requested OverTime of the date - 2019-12-20\",\"u_id\":87,\"mgr_id\":\"4\",\"report_uid\":\"3\",\"reportdate\":\"2019-12-20\"}', '2019-12-22 10:13:19', '2019-12-22 10:12:09', '2019-12-22 10:12:09'),
('f9e4444e-5f06-4532-a18b-9d39b37dd55f', 'App\\Notifications\\OtHRApprove', 'App\\User', 87, '{\"data\":\"Maricel Bea Approved the OverTime of the date - 2019-12-10\",\"u_id\":\"87\",\"report_uid\":\"3\",\"otdate\":\"2019-12-10\"}', '2019-12-23 10:32:51', '2019-12-23 10:03:08', '2019-12-23 10:03:08'),
('fa7dd950-c956-4687-baad-bdb1a92de2de', 'App\\Notifications\\OtHRReject', 'App\\User', 87, '{\"data\":\"Maricel Bea rejected your report of the date - 2019-12-16\",\"u_id\":\"87\",\"r_id\":\"3\",\"reportdate\":\"2019-12-16\"}', '2019-12-23 09:57:01', '2019-12-23 09:56:50', '2019-12-23 09:56:50');

-- --------------------------------------------------------

--
-- Table structure for table `overtimerequests`
--

CREATE TABLE `overtimerequests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `u_id` bigint(20) UNSIGNED NOT NULL,
  `date` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_time` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `end_time` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `mgr_id` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `report_uid` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ot_file` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `overtimerequests`
--

INSERT INTO `overtimerequests` (`id`, `u_id`, `date`, `start_time`, `end_time`, `reason`, `mgr_id`, `report_uid`, `ot_file`, `file_type`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 87, '2019-12-12', '18:00', '22:54', 'Test new Project', '4', '3', '2019-12-22-87.doc', 'doc', 'Approved', NULL, '2019-12-22 09:55:21', '2019-12-22 09:55:21'),
(2, 87, '2019-12-20', '18:00', '23:11', 'This is Test Project', '4', '3', '2019-12-20-87.doc', 'doc', 'Approved', NULL, '2019-12-22 10:12:09', '2019-12-22 10:12:09'),
(3, 87, '2019-12-23', '18:00', '22:45', 'this is testing', '4', '3', '2019-12-23-87.JPG', 'JPG', 'Approved', NULL, '2019-12-23 04:45:40', '2019-12-23 04:45:40'),
(4, 87, '2019-09-16', '18:00', '22:52', 'new testttt', '4', '3', '', '', 'Approved', NULL, '2019-12-23 09:52:59', '2019-12-23 09:52:59'),
(6, 87, '2019-12-10', '18:00', '22:59', 'drtyu89iuytresaertyuiop', '4', '3', '', '', 'Approved', NULL, '2019-12-23 09:59:29', '2019-12-23 09:59:29'),
(7, 87, '2019-12-14', '18:00', '22:35', 'This is new testing', '4', '3', '', '', 'Approved', NULL, '2019-12-23 10:36:54', '2019-12-23 10:36:54');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `r_id` bigint(20) UNSIGNED NOT NULL,
  `u_id` bigint(20) UNSIGNED NOT NULL,
  `date` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `attachment` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`r_id`, `u_id`, `date`, `description`, `attachment`, `file_type`, `remember_token`, `created_at`, `updated_at`) VALUES
(14, 7, '2019-08-11', '11th Report', NULL, NULL, NULL, '2019-08-14 03:54:41', '2019-08-14 03:54:41'),
(15, 7, '2019-08-12', '12th report', NULL, NULL, NULL, '2019-08-14 03:54:52', '2019-08-14 03:54:52'),
(26, 7, '2019-08-14', '14th report', NULL, NULL, NULL, '2019-08-15 03:28:34', '2019-08-15 03:28:34'),
(27, 7, '2019-08-13', '13th report', NULL, NULL, NULL, '2019-08-15 04:07:27', '2019-08-15 04:07:27'),
(28, 7, '2019-08-18', 'test resporttt1', NULL, NULL, NULL, '2019-08-18 21:36:50', '2019-08-18 21:36:50'),
(29, 87, '2019-08-18', 'test from kana', NULL, NULL, NULL, '2019-08-18 22:01:24', '2019-08-18 22:01:24'),
(30, 87, '2019-12-20', 'rtfyuytrewrty', NULL, NULL, NULL, '2019-08-18 22:57:23', '2019-08-18 22:57:23'),
(31, 7, '2019-12-19', '19th report', NULL, NULL, NULL, '2019-08-18 23:13:42', '2019-08-18 23:13:42'),
(32, 87, '2019-12-21', 'test report of 21st Dec 2019', NULL, NULL, NULL, '2019-12-24 06:38:26', '2019-12-24 06:38:26'),
(33, 87, '2019-12-25', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. \r\nLorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, \r\nwhen an unknown printer took a galley of type and scrambled it to make a type specimen book. \r\n', NULL, NULL, NULL, '2019-12-26 03:20:19', '2019-12-26 03:20:19'),
(34, 87, '2019-12-26', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. \r\norem Ipsum has been the industry\'s standard dummy text ever since the 1500s, \r\nhen an unknown printer took a galley of type and scrambled it to make a type specim\r\nen book', NULL, NULL, NULL, '2019-12-26 03:21:43', '2019-12-26 03:21:43');

-- --------------------------------------------------------

--
-- Table structure for table `sub_departments`
--

CREATE TABLE `sub_departments` (
  `sd_id` bigint(20) UNSIGNED NOT NULL,
  `d_id` bigint(20) UNSIGNED NOT NULL,
  `sd_title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sd_description` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_departments`
--

INSERT INTO `sub_departments` (`sd_id`, `d_id`, `sd_title`, `sd_description`, `created_at`, `updated_at`) VALUES
(2, 1, 'Content Marketing Team', 'a type of marketing that involves the creation and sharing of online material (such as videos, blogs', '2019-08-07 23:56:24', '2019-08-07 23:56:24'),
(3, 1, 'Manager', 'SEO is an acronym that stands for search engine optimization, which is the process of optimizing you', '2019-08-07 23:57:04', '2019-08-07 23:57:04'),
(5, 2, 'Blockchain Team', 'Assigned for blockchain development.', '2019-08-07 23:58:28', '2019-08-07 23:58:28'),
(6, 2, 'Application Team', 'Assigned for backend, frontend development with blockchain integration', '2019-08-07 23:58:57', '2019-08-07 23:58:57'),
(7, 2, 'Cyber Security Team', 'Assigned for maintaining security of all web and app applications.', '2019-08-07 23:59:47', '2019-08-07 23:59:47'),
(8, 3, 'Korean Team', 'Korean management that handles over all company process', '2019-08-08 02:12:14', '2019-08-08 02:12:14'),
(9, 2, 'Monitoring Team', 'Monitoring Team', '2019-08-18 00:22:45', '2019-08-18 00:22:45'),
(11, 1, 'Design Team', 'Design Team', '2019-08-18 00:24:16', '2019-08-18 00:24:16'),
(12, 1, 'Digital Marketing Team', 'Digital Marketing Team', '2019-08-18 00:24:47', '2019-08-18 00:24:47'),
(13, 1, 'Research Team', 'Research Team', '2019-08-18 00:25:17', '2019-08-18 00:25:17'),
(14, 5, 'Accounting', 'Accounting', '2019-08-18 00:25:58', '2019-08-18 00:25:58'),
(15, 4, 'Human Resource', 'Human Resource', '2019-08-18 00:26:22', '2019-08-18 00:26:22'),
(17, 1, 'Email Support Team', 'Email Support Team', '2019-08-17 16:00:00', '2019-08-17 16:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `d_id` bigint(20) UNSIGNED NOT NULL,
  `sd_id` bigint(20) UNSIGNED NOT NULL,
  `position` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emp_photo` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emp_sign` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `mobile`, `type`, `d_id`, `sd_id`, `position`, `emp_photo`, `emp_sign`, `file_type`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin@abbcfoundation.com', '0545320716', 'admin', 3, 8, 'Administrator', 'admin@abbcfoundation.com.png', '', '', NULL, '$2y$10$92jpogGjNfr2HWK9.QN5ROcKAeP9fYwQh0TFWc8bilFU2.VmkZuhe', NULL, NULL, NULL),
(3, 'Harry Jung', 'harry@abbcfoundation.com', '05458909890', 'topmanagement', 3, 8, 'Operation Director', 'harry@abbcfoundation.com.jpg', 'harry@abbcfoundation.com.png', 'jpg', NULL, '$2y$10$92jpogGjNfr2HWK9.QN5ROcKAeP9fYwQh0TFWc8bilFU2.VmkZuhe', 'VXfnTj6P9iV6AvMGcJXDBx1VHKtD8LBzmT9jhZFfrA0DZUPogAUBhl5XGyMj', '2019-08-08 02:28:30', '2019-12-24 02:01:19'),
(4, 'Jene Claude Dizon', 'jclaude@abbcfoundation.com', '0545320716', 'management', 2, 3, 'Application Development Manager', 'jclaude@abbcfoundation.com.png', 'jclaude@abbcfoundation.com.png', '', NULL, '$2y$10$Nuan0FQPL1r6./Dao60Zguam2ZafglJI3Ds7H5bySKee9BZw0plmC', '4NB8DOFkgPVuDD33FY9DqtDp6G4qUkVrMDBJGL0BbGHMBNyrShuDWA6BGZrv', '2019-08-08 02:52:57', '2019-12-24 01:59:53'),
(5, 'Suresh Kannan', 'suresh@abbcfoundation.com', '0543412323891', 'management', 1, 3, 'Marketing Manager', 'suresh@abbcfoundation.com.jpeg', '', '', NULL, '$2y$10$Ez1wrqm.ATe7/9UgEl33uOTpSRpRdEr.SKwpVvmXY79oYnvnEF0j2', '8YHCXsbpF737VnuddMom5RumyGz2VXpnKODigUHLJy6pcWOOPThw1WhFJT50', '2019-08-08 02:55:20', '2019-08-18 06:55:01'),
(6, 'Tim Comising', 'tim@abbcfoundation.com', '05456789098', 'management', 1, 2, 'Content Marketing Manager', 'tim@abbcfoundation.com.png', '', '', NULL, '$2y$10$b5euR1s6Dc7x8rEs.jbEOuGtb8PBnBypdSkebc./tHHPIueiGInXS', NULL, '2019-08-08 02:57:11', '2019-08-08 02:57:11'),
(7, 'Elvi Dano Correos', 'elvi@abbcfoundation.com', '04548909890', 'employee', 1, 2, 'Content Specialist', 'elvi@abbcfoundation.com.png', '', '', NULL, '$2y$10$cedSjHuuY/j4IjZ1UY27IeXVpoZ8o2kAkAcUGb2SfAjnktlcLdmiO', NULL, '2019-08-08 02:58:24', '2019-08-08 02:58:24'),
(8, 'Shahbaz Muhammad', 'mshahbaz@abbcfoundation.com', '05457262789', 'management', 2, 7, 'Cyber Security Manager', 'mshahbaz@abbcfoundation.com.png', '', '', NULL, '$2y$10$iwQa5kE3qzm02iFHK55T/uDfWn4q4ltwNdaBPN/DCS34lePANdjUu', NULL, '2019-08-08 02:58:58', '2019-08-08 02:58:58'),
(11, 'Prashant Kachawka', 'prashant@abbcfoundation.com', '04789287890', 'employee', 2, 7, 'Cyber Security Officer', 'prashant@abbcfoundation.com.png', '', '', NULL, '$2y$10$3l5F948s2pQTZ4nOEZP86.8WtYn24n0sysLxvwoAMPfRNiRKwmnH2', NULL, '2019-08-08 03:02:50', '2019-08-08 03:02:50'),
(13, 'Farhan Riasat', 'farhan@abbcfoundation.com', '0000000', 'employee', 2, 6, 'Back End Developer', 'farhan@abbcfoundation.com.png', '', '', NULL, '$2y$10$QMjbjWftXHPa803PgSqdo.W6xE1lGEDuApT0iG6OCsWz0d1eSzpgW', NULL, '2019-08-17 23:54:44', '2019-08-17 23:54:44'),
(14, 'Rimshad Ahamed', 'rimshad@abbcfoundation.com', '00000000', 'employee', 2, 6, 'Front End Developer', 'rimshad@abbcfoundation.com.png', '', '', NULL, '$2y$10$y4MmZEup8cz3o66jcntHmuT3cirMyz9X2PY2sMlevBAMn6eq2OTSS', NULL, '2019-08-17 23:58:03', '2019-08-17 23:58:03'),
(15, 'Siddharth Chordia', 'siddharth@abbcfoundation.com', '0000000', 'employee', 2, 6, 'Android Developer', 'siddharth@abbcfoundation.com.png', '', '', NULL, '$2y$10$5RHHBTjS0E11751cgMC2Ge34SyxRswIdab83VVulkxzPoggpnhPIW', NULL, '2019-08-17 23:58:54', '2019-08-17 23:58:54'),
(16, 'Zeeshan javed', 'zeeshan@abbcfoundation.com', '0000000', 'employee', 2, 6, 'Sr. Android/Web Developer', 'zeeshan@abbcfoundation.com.png', '', '', NULL, '$2y$10$Jlv3NfZiwg8AhXSYWhkcyuN/6SSuvz4LY0wzBPZ.q8hOaiMHX1xnq', NULL, '2019-08-17 23:59:55', '2019-08-17 23:59:55'),
(17, 'Ashish Babar', 'ashish@abbcfoundation.com', '00000000', 'employee', 2, 5, 'Blockchain Developer', 'ashish@abbcfoundation.com.png', '', '', NULL, '$2y$10$QgyNWCLD2.RLyGI0k0Xo8OYRK8CpVimANAuRstiwjl9HpBjas2322', NULL, '2019-08-18 00:01:05', '2019-08-18 00:01:05'),
(18, 'Awais Sakhi', 'awais@abbcfoundation.com', '00000000', 'employee', 2, 5, 'Blockchain Developer', 'awais@abbcfoundation.com.png', '', '', NULL, '$2y$10$5V76ZF53hpF6/MDPJyuv4ejIphmPHCQGrN5/IrewmPGQD9gutpAVS', NULL, '2019-08-18 00:02:27', '2019-08-18 00:02:27'),
(19, 'Surya pratap', 'surya.pratap@abbcfoundation.com', '00000000', 'employee', 2, 5, 'Blockchain Team Manager', 'surya.pratap@abbcfoundation.com.png', '', '', NULL, '$2y$10$hC18qsSohgQu.7tf0X7m1e1GmadY/MbX7idWkex/yBNv7H7X85TxC', NULL, '2019-08-18 00:03:34', '2019-08-18 00:03:34'),
(20, 'Hamaad Abdul Waris', 'hamaad@abbcfoundation.com', '00000000', 'employee', 2, 5, 'Blockchain Developer', 'hamaad@abbcfoundation.com.png', '', '', NULL, '$2y$10$ZtZC/PpIU8LOxQx/OE0/vuxEdgJtmZl65//DKtJSN71zoQ/P4jRuO', NULL, '2019-08-18 00:16:50', '2019-08-18 00:16:50'),
(22, 'Ashik Khan', 'ashik@abbcfoundation.com', '00000000', 'employee', 2, 9, 'Monitoring Specialist', 'ashik@abbcfoundation.com.png', '', '', NULL, '$2y$10$ZYcoOkAik0hwqROlvLFsPOgNN1Ux4z.Vf.FA5Cs4Um5GCAY5NQ6By', NULL, '2019-08-18 00:28:03', '2019-08-18 00:28:03'),
(23, 'Eldho Jacob', 'eldho@abbcfoundation.com', '00000000', 'employee', 2, 9, 'Monitoring Specialist', 'eldho@abbcfoundation.com.png', '', '', NULL, '$2y$10$1Pi6KDPOORBAd79XRCeW/OmHnH0fbtpfZtHueRTYCEEUVp3b5Voui', NULL, '2019-08-18 00:28:33', '2019-08-18 00:28:33'),
(24, 'Roland Guirdonan', 'roland@abbcfoundation.com', '00000000', 'employee', 2, 9, 'Monitoring Specialist', 'roland@abbcfoundation.com.png', '', '', NULL, '$2y$10$hBg3blriyQ.I2vPKkF8IceFgEutlVX5D5z/WGkVjgHd6kGMihNwQC', NULL, '2019-08-18 00:29:08', '2019-08-18 00:29:08'),
(25, 'Rudy Mandap', 'rudy@abbcfoundation.com', '00000000', 'employee', 2, 9, 'Monitoring Specialist', 'rudy@abbcfoundation.com.png', '', '', NULL, '$2y$10$Hx3YLKI.etJsf6VqRfP8DO62Vt5A6290NEdAajwMe1xn7ZTjfEHUO', NULL, '2019-08-18 00:29:45', '2019-08-18 00:29:45'),
(26, 'Siddesh Kanolkar', 'siddesh@abbcfoundation.com', '00000000', 'employee', 2, 9, 'Monitoring Specialist', 'siddesh@abbcfoundation.com.png', '', '', NULL, '$2y$10$XspxzajW.lA.Rq9hg3oUXOZ1ofq9PdhbHZ7.LfIqq0/aIxtDu2GDm', NULL, '2019-08-18 00:30:46', '2019-08-18 00:30:46'),
(27, 'Tariq Farah', 'tariq@abbcfoundation.com', '00000000', 'employee', 2, 9, 'Monitoring Specialist', 'tariq@abbcfoundation.com.png', '', '', NULL, '$2y$10$0.u2KfFaAiTd6gvIefE5Le6OB4g/r5kg6cxJweQSHbrfRtH.fiL56', NULL, '2019-08-18 00:31:25', '2019-08-18 00:31:25'),
(28, 'Ulpathali Barathala', 'ulpathali@abbcfoundation.com', '00000000', 'employee', 2, 9, 'Monitoring Specialist', 'ulpathali@abbcfoundation.com.png', '', '', NULL, '$2y$10$18NPSgtA4OtqTf/3kLkmCuU9X5IJsDrVghD9jZ4xQBJ9q4G7BxBOi', NULL, '2019-08-18 00:32:01', '2019-08-18 00:32:01'),
(29, 'Vivek Vasudevan', 'vivek@abbcfoundation.com', '00000000', 'employee', 2, 9, 'Monitoring Specialist', 'vivek@abbcfoundation.com.png', '', '', NULL, '$2y$10$y81lX28GbgNTQhxRnssR/.aiky4A6QcuoqLSMKpu0K/NgdayyfBYu', NULL, '2019-08-18 00:32:38', '2019-08-18 00:32:38'),
(30, 'Ana Maria Martins Da Silva', 'maria@abbcfoundation.com', '00000000', 'employee', 1, 2, 'Content Specialist', 'maria@abbcfoundation.com.png', '', '', NULL, '$2y$10$0aAI2.73VtgtlUa0DaGM9eCPqwYFU.vnI3oKaOmgF/G1JaxDvOyGi', NULL, '2019-08-18 00:33:58', '2019-08-18 00:33:58'),
(32, 'Gabriel De Souza', 'gabriel@abbcfoundation.com', '00000000', 'employee', 1, 2, 'Content Specialist', 'gabriel@abbcfoundation.com.png', '', '', NULL, '$2y$10$0ivUk5Dqbyc5OU2IYDnwKOVmTSgt6cXjNiS64Pt4mn5g8gvDYG9Lm', NULL, '2019-08-18 00:49:33', '2019-08-18 00:49:33'),
(33, 'Ismael Mohammed', 'ismael@abbcfoundation.com', '00000000', 'employee', 1, 2, 'Content Specialist', 'ismael@abbcfoundation.com.png', '', '', NULL, '$2y$10$CEzXHgZL52lFgZoboQZ0NORtEQE9ibxHkMfnIF9xDb1NbxR69/.b.', NULL, '2019-08-18 00:50:07', '2019-08-18 00:50:07'),
(34, 'JC Francis', 'francis@abbcfoundation.com', '00000000', 'employee', 1, 2, 'Content Specialist', 'francis@abbcfoundation.com.png', '', '', NULL, '$2y$10$MgMHVJvB7CZEdyUKjDC4x.au5sE8MvFgj/iTirRlazsVhaTI7CqvW', NULL, '2019-08-18 00:50:54', '2019-08-18 00:50:54'),
(35, 'Jesus L. Dawal Jr', 'jesus@abbcfoundation.com', '00000000', 'employee', 1, 2, 'Content Specialist', 'jesus@abbcfoundation.com.png', '', '', NULL, '$2y$10$sSMHFEl8H4lI1qEhP5eGleQJhjmkzrbiyMB4DguuxksQOLbXbNNKK', NULL, '2019-08-18 00:52:25', '2019-08-18 00:52:25'),
(36, 'Joanna Alhambra', 'joanna@abbcfoundation.com', '00000000', 'employee', 1, 2, 'Content Specialist', 'joanna@abbcfoundation.com.png', '', '', NULL, '$2y$10$4QObnf4SMPbq97J/usF25.Qjs.nQ9wF8qc3YuIFIFN.1zBpQj6MwS', NULL, '2019-08-18 00:53:01', '2019-08-18 00:53:01'),
(37, 'Lemuel Capisinio', 'lemuel@abbcfoundation.com', '00000000', 'employee', 1, 11, 'Digital Graphics Designer', 'lemuel@abbcfoundation.com.png', '', '', NULL, '$2y$10$sMVPcYqQ30uWz59Y0EM8aOfwEKi2AJFBSSqd0fYXw1Owb9K9JFG/i', NULL, '2019-08-18 00:54:15', '2019-08-18 00:54:15'),
(38, 'Muhammad Junaid', 'junaid@abbcfoundation.com', '00000000', 'employee', 1, 11, 'Digital Graphics Designer', 'junaid@abbcfoundation.com.png', '', '', NULL, '$2y$10$8e8uB2PbhqRJ8giiau4gn.yVu1urYZ47/cSR727f9SnI7AYOyW8.O', NULL, '2019-08-18 00:55:21', '2019-08-18 00:55:21'),
(39, 'Ramees Raja', 'ramees@abbcfoundation.com', '00000000', 'employee', 1, 11, 'Digital Graphics Designer / Web Developer', 'ramees@abbcfoundation.com.png', '', '', NULL, '$2y$10$vYQ5.3dA8bWsiKQCd2zL1.GD6HXk3itCunBiNOAJ70uQv/7uxOfaq', NULL, '2019-08-18 00:56:15', '2019-08-18 00:56:15'),
(40, 'Shameer Alshab', 'shameer@abbcfoundation.com', '00000000', 'employee', 1, 11, '3D Digital Designer', 'shameer@abbcfoundation.com.png', '', '', NULL, '$2y$10$AP8Yj4XSOA/8ZQIf9/HDa..8vQtUuftsNalaH4T2.7RPRODZ0fBOe', NULL, '2019-08-18 00:56:59', '2019-08-18 00:56:59'),
(41, 'Vineeth Soman', 'vineeth@abbcfoundation.com', '00000000', 'employee', 1, 11, 'Digital Graphics Designer', 'vineeth@abbcfoundation.com.png', '', '', NULL, '$2y$10$nFs8RLBjNTP8rRcPYbTcE.eD29D8ovsHBXfyZeHOuzqHOO/GbWjjq', NULL, '2019-08-18 00:57:42', '2019-08-18 00:57:42'),
(42, 'Shahul Hameed', 'shahul@abbcfoundation.com', '00000000', 'employee', 1, 12, 'Digital Marketing Manager', 'shahul@abbcfoundation.com.png', '', '', NULL, '$2y$10$m6kTXOOff4d0z5aytilD0uCz79J6/FYj/Jjuq9nH9U3kkXmIvJP0e', NULL, '2019-08-18 00:59:15', '2019-08-18 00:59:15'),
(43, 'Afshan Firdose', 'afshan@abbcfoundation.com', '00000000', 'employee', 1, 12, 'Digital Marketing Specialist', 'afshan@abbcfoundation.com.png', '', '', NULL, '$2y$10$F0BGCglDXdmTH/FBi4yF8.2Kp2C0FxXUs5oiJK2HpBlI.e5Jug3CS', NULL, '2019-08-18 01:33:01', '2019-08-18 01:33:01'),
(44, 'Aidana Asanalieva', 'aidana@abbcfoundation.com', '00000000', 'employee', 1, 12, 'Digital Marketing Specialist', 'aidana@abbcfoundation.com.png', '', '', NULL, '$2y$10$A1MrPFN4tHD7R3AaGwAjO.8Y8qgoyMrUpIc8YNAx09R.WRPzhRDCC', NULL, '2019-08-18 01:33:46', '2019-08-18 01:33:46'),
(45, 'Ananthi Reeta', 'ananthi@abbcfoundation.com', '00000000', 'employee', 1, 12, 'Digital Marketing Specialist', 'ananthi@abbcfoundation.com.png', '', '', NULL, '$2y$10$EhGTBz6CdHiuZ91pbdvItuZuvEnpjnu66pblo7nN/GZr2XvmhuPHe', NULL, '2019-08-18 01:34:21', '2019-08-18 01:34:21'),
(46, 'Diana Suyerbayeva', 'diana@abbcfoundation.com', '00000000', 'employee', 1, 12, 'Digital Marketing Specialist', 'diana@abbcfoundation.com.png', '', '', NULL, '$2y$10$0vmBW3tVWPD3Cet4DNg3ueMeG34RckcM6jyOsPt2pPj76/s3ExZ3y', NULL, '2019-08-18 01:35:06', '2019-08-18 01:35:06'),
(47, 'Ikram Yunus', 'ikram@abbcfoundation.com', '00000000', 'employee', 1, 12, 'Digital Marketing Specialist', 'ikram@abbcfoundation.com.png', '', '', NULL, '$2y$10$siGg4/oJVqxe/jgj5Ep7i.F1DnqIvWdQJsR0smF/VET5v2H2WnM4y', NULL, '2019-08-18 01:36:02', '2019-08-18 01:36:02'),
(48, 'Lance Villanueva Ebreo', 'lance@abbcfoundation.com', '00000000', 'employee', 1, 12, 'Digital Marketing Specialist', 'lance@abbcfoundation.com.png', '', '', NULL, '$2y$10$9DGthAIEBCGaUKQeI8LASu1yqkhuu/4TfBvcdDIv468toSH6Fa2YW', NULL, '2019-08-18 01:36:35', '2019-08-18 01:36:35'),
(49, 'Mariam Sarhali', 'mariam@abbcfoundation.com', '00000000', 'employee', 1, 12, 'Digital Marketing Specialist', 'mariam@abbcfoundation.com.png', '', '', NULL, '$2y$10$giIrQOlmysTPKabhahE0WeTzKfmIfJwjwChwBoTfia.WpRfSqWELe', NULL, '2019-08-18 01:37:25', '2019-08-18 01:37:25'),
(50, 'Naveed Mian', 'naveed@abbcfoundation.com', '00000000', 'employee', 1, 12, 'Digital Marketing Specialist', 'naveed@abbcfoundation.com.png', '', '', NULL, '$2y$10$qZfInyw2/moG0chrFmGaquhNXxBjVFGx2KeghU9qEi8KDX1kVkdvm', NULL, '2019-08-18 01:38:06', '2019-08-18 01:38:06'),
(51, 'Ragu Bharath', 'ragu@abbcfoundation.com', '00000000', 'employee', 1, 12, 'Digital Marketing Specialist', 'ragu@abbcfoundation.com.png', '', '', NULL, '$2y$10$IwilNeiZAlcL15pDS32GbefLvWSo1HRkdtF.do2eyHGaNb1L3ns/C', NULL, '2019-08-18 01:38:52', '2019-08-18 01:38:52'),
(52, 'Ram Raj', 'ram@abbcfoundation.com', '00000000', 'employee', 1, 12, 'Digital Marketing Specialist', 'ram@abbcfoundation.com.png', '', '', NULL, '$2y$10$NguGugwHfluZAyWDygzUAeqQExw1Zx3N/xeBw4NMdrx4r5jEZakke', NULL, '2019-08-18 01:39:31', '2019-08-18 01:39:31'),
(53, 'Rohit Mohan', 'rohit@abbcfoundation.com', '00000000', 'employee', 1, 12, 'Digital Marketing Specialist', 'rohit@abbcfoundation.com.png', '', '', NULL, '$2y$10$3iKUv7a11.Pj9ukQZCMLjue76xYYjg8gAMj6aG4.wAxov8zHi/s/m', NULL, '2019-08-18 01:40:04', '2019-08-18 01:40:04'),
(54, 'Vaishaali Thanabalan', 'vaishaali@abbcfoundation.com', '00000000', 'employee', 1, 12, 'Digital Marketing Specialist', 'vaishaali@abbcfoundation.com.png', '', '', NULL, '$2y$10$JM6QYogqeNAGRykiaXuYPe/HJ14vWV2UaOcqnS8rnzWGV.FdeKhiS', NULL, '2019-08-18 01:44:11', '2019-08-18 01:44:11'),
(55, 'Vijayachandar Dharmaraj', 'vijay@abbcfoundation.com', '00000000', 'employee', 1, 12, 'Digital Marketing Specialist', 'vijay@abbcfoundation.com.png', '', '', NULL, '$2y$10$HVfjFSlBFPv0PuH7Xg8jie5XT9RFRmQrjChcsr91A1lbPDPddqhDu', NULL, '2019-08-18 01:44:58', '2019-08-18 01:44:58'),
(56, 'Yahya Khan', 'yahya@abbcfoundation.com', '00000000', 'employee', 1, 12, 'Digital Marketing Specialist', 'yahya@abbcfoundation.com.png', '', '', NULL, '$2y$10$6sgibCpiFT5pWBYEqAru6eyxpgncjHjCI1JN2w4eDrVIXqtkTn3f.', NULL, '2019-08-18 01:45:58', '2019-08-18 01:45:58'),
(57, 'Priyanka', 'priyanka@abbcfoundation.com', '00000000', 'employee', 1, 17, 'Email Support Lead', 'priyanka@abbcfoundation.com.png', '', '', NULL, '$2y$10$O.4QyUzFdv9T5YkzNSVreO81Fy/KAnJ6qPX1Q1GkFP7FwGU9NI/5u', NULL, '2019-08-18 01:52:16', '2019-08-18 01:52:16'),
(58, 'Priyanka Amal Choudhury', 'amal@abbcfoundation.com', '00000000', 'employee', 1, 17, 'Email Support Manager', 'amal@abbcfoundation.com.png', '', '', NULL, '$2y$10$XpvZB6inMlKXryALbfZ2QOBFTec4hET2Wl/8HCD2i0UZjN3RwEOSm', NULL, '2019-08-18 01:53:35', '2019-08-18 01:53:35'),
(59, 'Abygail Franco', 'abygail@abbcfoundation.com', '00000000', 'employee', 1, 17, 'Customer Support', 'abygail@abbcfoundation.com.png', '', '', NULL, '$2y$10$8rFRpC0PWbWoHP5zw0ssQu.9tJUBMOjYmcL/bMnrR9oibA0ENwbFe', NULL, '2019-08-18 01:54:45', '2019-08-18 01:54:45'),
(60, 'Alliana Barcheta', 'alliana@abbcfoundation.com', '00000000', 'employee', 1, 17, 'Customer Support', 'alliana@abbcfoundation.com.png', '', '', NULL, '$2y$10$QgjS.tAJjD49yFMf23kXS.hAQppocwGcExpUvLUAbEWx.FnJchCoK', NULL, '2019-08-18 01:55:21', '2019-08-18 01:55:21'),
(61, 'Cedie Reyes', 'cedie@abbcfoundation.com', '00000000', 'employee', 1, 17, 'Customer Support', 'cedie@abbcfoundation.com.png', '', '', NULL, '$2y$10$6Fg0ZyLGb1iqxJn2sNOep.WVkFXjKtvhlJOvU/Wok37Ey4B8CPHs.', NULL, '2019-08-18 01:56:52', '2019-08-18 01:56:52'),
(62, 'Ingrid Escatron', 'ingrid@abbcfoundation.com', '00000000', 'employee', 1, 17, 'Customer Support', 'ingrid@abbcfoundation.com.png', '', '', NULL, '$2y$10$7MGqwMAWZM9dNM9l.xRxBepGsJH40yqqQHMahNG/u8YdokCwV7qE2', NULL, '2019-08-18 01:57:40', '2019-08-18 01:57:40'),
(63, 'Jenny Estrella', 'jenny@abbcfoundation.com', '00000000', 'employee', 1, 17, 'Customer Support', 'jenny@abbcfoundation.com.png', '', '', NULL, '$2y$10$XVt6tDijRZdKAJb9PcOwdenxrRLAJ556yp3pRKh09oNU9/nNCyq8S', NULL, '2019-08-18 01:58:22', '2019-08-18 01:58:22'),
(64, 'Leo Angelo Roxas', 'leo@abbcfoundation.com', '00000000', 'employee', 1, 17, 'Customer Support', 'leo@abbcfoundation.com.png', '', '', NULL, '$2y$10$vKl6wgyPtpbZVzk4wB.NHuhk/iopWR9csrizojOL9rXtYbHxXc/.2', NULL, '2019-08-18 02:00:06', '2019-08-18 02:00:06'),
(65, 'Meenu S .L', 'meenu@abbcfoundation.com', '00000000', 'employee', 1, 17, 'Customer Support', 'meenu@abbcfoundation.com.png', '', '', NULL, '$2y$10$GKKPx2oJxQXFg8wOHtAxyuXeDMd9FVj892LOw.2MbIe55s5xbU83u', NULL, '2019-08-18 02:00:50', '2019-08-18 02:00:50'),
(66, 'Megalyn Licudine', 'megalyn@abbcfoundation.com', '00000000', 'employee', 1, 17, 'Customer Support', 'megalyn@abbcfoundation.com.png', '', '', NULL, '$2y$10$t76zUZrJgNxq/X6XbZJYA.z/a/I4E/qFfa/OJWokJLMW3qmM4DkT2', NULL, '2019-08-18 02:01:49', '2019-08-18 02:01:49'),
(67, 'Sora Tsevegmid Chinbat', 'sora@abbcfoundation.com', '00000000', 'employee', 1, 17, 'Customer Support', 'sora@abbcfoundation.com.png', '', '', NULL, '$2y$10$kRYMZ/OCQV2qCIhSiASxKeVzP.pm6Ab0OhY3y3Kd2whYSltdy/4Xa', NULL, '2019-08-18 02:03:29', '2019-08-18 02:03:29'),
(68, 'Kitt Rho D. Manarin', 'kittrho@abbcfoundation.com', '00000000', 'employee', 1, 13, 'Researcher', 'kittrho@abbcfoundation.com.png', '', '', NULL, '$2y$10$lZPb.03AcDyWbtB9fw9hvevPSJALpYhqPIWcrm1WRO7rTtci4sr/G', NULL, '2019-08-18 02:04:49', '2019-08-18 02:04:49'),
(69, 'Rajasekar kumar', 'rajasekar@abbcfoundation.com', '00000000', 'employee', 1, 13, 'Researcher', 'rajasekar@abbcfoundation.com.png', '', '', NULL, '$2y$10$LCiSX50aNcEV2zKxh5G0IuNoxbb1fUL0oc64qAoyhZWAunMyMtTXW', NULL, '2019-08-18 02:06:02', '2019-08-18 02:06:02'),
(70, 'Sarath Kumar', 'sarath@abbcfoundation.com', '00000000', 'employee', 1, 13, 'Researcher', 'sarath@abbcfoundation.com.png', '', '', NULL, '$2y$10$eH8UWK8IncyO6Ck6jV1azepxr.669q6QYsPqdciQ8OigaqlN5sK1a', NULL, '2019-08-18 02:06:39', '2019-08-18 02:06:39'),
(71, 'Stanley park', 'stanley@abbcfoundation.com', '00000000', 'employee', 3, 8, 'ABBC CTO', 'stanley@abbcfoundation.com.png', '', '', NULL, '$2y$10$nN5oKsJEXxu1ZwMVD3/iOuDltUVqdv7wV2pRqjEgyS0RQXHkbjmWS', NULL, '2019-08-18 02:20:38', '2019-08-18 02:20:38'),
(72, 'Lim whay Liang', 'whayliang@abbcfoundation.com', '00000000', 'employee', 3, 8, 'CEO ADN', 'whayliang@abbcfoundation.com.png', '', '', NULL, '$2y$10$ocLnQJB6azQ1fxqk4y/i0eG/U/jmP30QrCq5qXBdQtHGK.lNol4RC', NULL, '2019-08-18 02:21:25', '2019-08-18 02:21:25'),
(73, 'Jon Ban', 'jon@abbcfoundation.com', '00000000', 'topmanagement', 1, 8, 'CEO MC IT', 'jon@abbcfoundation.com.png', '', '', NULL, '$2y$10$2xHQRHH4ic/jDBWnNgOaaenpfeHrVBHtekm.PLg0ItgCzCQ37qZbK', NULL, '2019-08-18 02:23:50', '2019-08-18 02:23:50'),
(74, 'Jason Daniel', 'jason@abbcfoundation.com', '00000000', 'topmanagement', 3, 8, 'CEO ABBC', 'jason@abbcfoundation.com.png', '', '', NULL, '$2y$10$fH8ajhI7i1/JJHjBaijcSeUfe2pr9C96U8bIzt5A4jSOdMbvG.4au', NULL, '2019-08-18 02:24:27', '2019-08-18 02:24:27'),
(75, 'Jisung kim', 'jk@abbcfoundation.com', '00000000', 'topmanagement', 3, 8, 'Korean Staff', 'jk@abbcfoundation.com.png', '', '', NULL, '$2y$10$PEhoLFPLCZ5XmPQ8Mxiwl.VL74APDUrKxorjijN448rf5erce6wJy', NULL, '2019-08-18 02:26:18', '2019-08-18 02:26:18'),
(76, 'Yeongho	Kim', 'kai@abbcfoundation.com', '00000000', 'topmanagement', 3, 8, 'Korean Staff', 'kai@abbcfoundation.com.png', '', '', NULL, '$2y$10$PF2k9GVyCq1I8kSenNZkw.lZF9dEi/mmlQpfEge1nJz3YCcc.efPe', NULL, '2019-08-18 02:27:02', '2019-08-18 02:27:02'),
(77, 'Yeongil Kim', 'teokim@abbcfoundation.com', '00000000', 'topmanagement', 3, 8, 'Korean Staff', 'teokim@abbcfoundation.com.png', '', '', NULL, '$2y$10$MQQTRDezeqSIb1O2Vjyt9.tZqdk0nE0z6XA.CvNlYlECvhCcJucaK', NULL, '2019-08-18 02:27:48', '2019-08-18 02:27:48'),
(78, 'Yeri	Hong', 'yeri@abbcfoundation.com', '00000000', 'topmanagement', 3, 8, 'Korean Staff', 'yeri@abbcfoundation.com.png', '', '', NULL, '$2y$10$PUfeUexc/CFYZ7D0glGy3OSOlvT/cAATmjAP2dAPEraW7yk73ZfDi', NULL, '2019-08-18 02:28:31', '2019-08-18 02:28:31'),
(79, 'Jee	Youn Chun', 'jee.chun@abbcfoundation.com', '00000000', 'topmanagement', 3, 8, 'Translator', 'jee.chun@abbcfoundation.com.png', '', '', NULL, '$2y$10$iwwJm/thzALG7LE.YrRQoeF2pRwsZhkwPJzDLxVdm8knMLkMdrvc.', NULL, '2019-08-18 02:29:15', '2019-08-18 02:29:15'),
(80, 'Kristine Maret', 'kristine@abbcfoundation.com', '00000000', 'employee', 5, 14, 'Accountant', 'kristine@abbcfoundation.com.png', '', '', NULL, '$2y$10$6QONsdK4gHl2VT5PzTFKwuUrheDKddgF50qFeO8cO3aInNpk7MC8y', NULL, '2019-08-18 02:33:25', '2019-08-18 02:33:25'),
(81, 'Jae Park', 'jae@abbcfoundation.com', '00000000', 'employee', 5, 14, 'Accounting Department Translator', 'jae@abbcfoundation.com.png', '', '', NULL, '$2y$10$p3h31mOScXgAyJd3R4Gktuz5PTT0eWE44WGHLArRCo5/TjNz5ATWi', NULL, '2019-08-18 02:34:09', '2019-08-18 02:34:09'),
(82, 'Maricel Bea', 'maricel@abbcfoundation.com', '00000000', 'employee', 4, 15, 'HR Manager', 'maricel@abbcfoundation.com.png', '', '', NULL, '$2y$10$92jpogGjNfr2HWK9.QN5ROcKAeP9fYwQh0TFWc8bilFU2.VmkZuhe', '7q5nI4mYw4K71bNUEeidxR8Vqrlz5lq9bU2llSrLM2xFo48GeR69DPC5iM8q', '2019-08-18 02:34:53', '2019-08-18 02:34:53'),
(83, 'Manuel Zantua Jr', 'manuel@abbcfoundation.com', '00000000', 'employee', 4, 15, 'Jr. HR', 'manuel@abbcfoundation.com.png', '', '', NULL, '$2y$10$vmOWh197VIrd1/zygtLmbe6vgMFW58StkCbm3/M566IPg2D5LrjZS', NULL, '2019-08-18 02:35:34', '2019-08-18 02:35:34'),
(84, 'Zia Rehman', 'zia@abbcfoundation.com', '00000000', 'employee', 4, 15, 'PR', 'zia@abbcfoundation.com.png', '', '', NULL, '$2y$10$ACQ6WxTPzgO4I5kqK23H.u9gMsfPpPbjZ/ijiMZVyPMGNfbn2m1te', NULL, '2019-08-18 02:36:11', '2019-08-18 02:36:11'),
(85, 'Hemza', 'hemza@abbcfoundation.com', '00000000', 'employee', 4, 15, 'PR', 'hemza@abbcfoundation.com.png', '', '', NULL, '$2y$10$Pxk9fLErWdM708o.1LgTJuKqBufMwm2odEku/6rIm.yoYlio0m.xq', NULL, '2019-08-18 02:36:50', '2019-08-18 02:36:50'),
(86, 'Mariz Leira San Juan', 'mariz@abbcfoundation.com', '00000000', 'employee', 4, 15, 'Receptionist', 'mariz@abbcfoundation.com.png', '', '', NULL, '$2y$10$HKONoHzyMOuYM9AW50p9mujcbJuT7fiPqBFR/.m5yB75dptd95bhK', NULL, '2019-08-18 02:37:41', '2019-08-18 02:37:41'),
(87, 'Kanagaraj Chinnadurai', 'kanagaraj@abbcfoundation.com', '00000000', 'topmanagement', 2, 6, 'Web developer', 'kanagaraj@abbcfoundation.com.jpg', 'kanagaraj@abbcfoundation.com.png', '', NULL, '$2y$10$eQ/qvdqLm1cOj3d5GtermumSDEUFlgDhIi9/rwIcMSyWDTfufDnA6', 'NuzpveVuhu9u01H9uGARLY68NeQ61FUc7EdzunNVTAN5MZW9NqtbeW6qob5i', '2019-08-18 05:04:10', '2019-12-24 01:58:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_u_id_foreign` (`u_id`),
  ADD KEY `comments_r_id_foreign` (`r_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`d_id`);

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
-- Indexes for table `overtimerequests`
--
ALTER TABLE `overtimerequests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`r_id`),
  ADD KEY `reports_u_id_foreign` (`u_id`);

--
-- Indexes for table `sub_departments`
--
ALTER TABLE `sub_departments`
  ADD PRIMARY KEY (`sd_id`),
  ADD KEY `sub_departments_d_id_foreign` (`d_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `d_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `overtimerequests`
--
ALTER TABLE `overtimerequests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `r_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `sub_departments`
--
ALTER TABLE `sub_departments`
  MODIFY `sd_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_r_id_foreign` FOREIGN KEY (`r_id`) REFERENCES `reports` (`r_id`),
  ADD CONSTRAINT `comments_u_id_foreign` FOREIGN KEY (`u_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_u_id_foreign` FOREIGN KEY (`u_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `sub_departments`
--
ALTER TABLE `sub_departments`
  ADD CONSTRAINT `sub_departments_d_id_foreign` FOREIGN KEY (`d_id`) REFERENCES `departments` (`d_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
