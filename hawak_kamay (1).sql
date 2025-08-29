-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 29, 2025 at 03:11 AM
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
-- Database: `hawak_kamay`
--

-- --------------------------------------------------------

--
-- Stand-in structure for view `applicant_counts`
-- (See below for the actual view)
--
CREATE TABLE `applicant_counts` (
`job_id` int(11)
,`job_title` varchar(255)
,`total_applicants` bigint(21)
);

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `applied_date` date NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `cover_letter` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `job_id`, `student_id`, `applied_date`, `status`, `cover_letter`, `created_at`, `updated_at`) VALUES
(19, 23, 25, '2025-08-28', 'approved', '', '2025-08-28 04:59:18', '2025-08-28 05:12:10'),
(22, 21, 25, '2025-08-28', 'approved', '', '2025-08-28 05:08:44', '2025-08-28 05:12:08'),
(23, 24, 25, '2025-08-28', 'approved', '', '2025-08-28 05:09:06', '2025-08-28 05:12:11'),
(24, 22, 25, '2025-08-28', 'approved', '', '2025-08-28 05:09:15', '2025-08-28 05:12:10');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `code` varchar(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `code`, `name`, `description`, `created_at`) VALUES
(1, 'CITE', 'College of Information Technology Education', 'Computer Science and IT related programs', '2025-08-26 08:31:30'),
(2, 'CAHS', 'College of Allied Health Sciences', 'Healthcare and medical programs', '2025-08-26 08:31:30'),
(3, 'CBA', 'College of Business Administration', 'Business and management programs', '2025-08-26 08:31:30'),
(4, 'CAS', 'College of Arts and Sciences', 'Liberal arts and sciences programs', '2025-08-26 08:31:30'),
(5, 'COE', 'College of Engineering', 'Engineering programs', '2025-08-26 08:31:30'),
(6, 'CTED', 'College of Teacher Education', 'Education and teaching programs', '2025-08-26 08:31:30'),
(11, 'COME', 'College of Maritime Education', 'Dedicated to maritime education.', '2025-08-28 02:02:54'),
(12, 'CCJE', 'College of Criminal Justice Education', 'Offers courses in criminal justice.', '2025-08-28 02:04:16'),
(13, 'COM', 'College of Management and Accountancy', 'Includes programs in management and accountancy.', '2025-08-28 02:05:02');

-- --------------------------------------------------------

--
-- Table structure for table `job_postings`
--

CREATE TABLE `job_postings` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `requirements` text DEFAULT NULL,
  `schedule` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `posted_by_id` int(11) NOT NULL,
  `posted_date` date NOT NULL,
  `deadline` date NOT NULL,
  `status` enum('open','closed','filled') DEFAULT 'open',
  `max_applicants` int(11) DEFAULT 1,
  `current_applicants` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `department_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_postings`
--

INSERT INTO `job_postings` (`id`, `title`, `description`, `requirements`, `schedule`, `location`, `posted_by_id`, `posted_date`, `deadline`, `status`, `max_applicants`, `current_applicants`, `created_at`, `updated_at`, `department_id`) VALUES
(21, 'laboratory assistant', 'Lab assistant and closer', 'computer literate', 'monday 7:30-1:30pm', 'CL1', 18, '2025-08-27', '2025-09-03', 'open', 3, 0, '2025-08-27 07:47:14', '2025-08-27 07:47:14', 2),
(22, 'AAAAA', 'AAA', 'AAAA', 'monday 7:30-1:30pm', 'CL1', 18, '2025-08-27', '2025-09-03', 'open', 1, 0, '2025-08-27 14:57:38', '2025-08-27 14:57:38', 1),
(23, 'Student facilitator', 'need student faci', 'kabalo mag check kag stricto', 'monday 7:30-1:30pm', 'CITE', 18, '2025-08-28', '2025-09-04', 'open', 12, 0, '2025-08-27 23:23:37', '2025-08-27 23:23:37', 1),
(24, 'lab assistant ', 'aaaaa', 'aaa', 'monday 7:30-1:30pm', 'CL1', 18, '2025-08-28', '2025-09-04', 'open', 5, 1, '2025-08-28 02:28:27', '2025-08-28 02:28:27', 1);

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `submitted_by` int(11) NOT NULL,
  `role` enum('student','teacher') NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` enum('pending','reviewed','resolved') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `resolved_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `site_name` varchar(255) NOT NULL,
  `admin_email` varchar(255) NOT NULL,
  `reports_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `job_applications_enabled` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `site_name`, `admin_email`, `reports_enabled`, `job_applications_enabled`) VALUES
(1, 'HAWAK KAMAY SCHOLARSHIP PROGRAM SYSTEM', 'admin@example.com', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','teacher','admin') NOT NULL,
  `student_id` varchar(50) DEFAULT NULL,
  `teacher_id` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `department_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `student_id`, `teacher_id`, `created_at`, `updated_at`, `department_id`) VALUES
(12, 'Super Admin', 'admin@example.com', '123', 'admin', NULL, NULL, '2025-08-26 10:57:48', '2025-08-26 12:24:47', NULL),
(13, 'neil', 'neilasis1@gmail.com', '123', 'admin', NULL, NULL, '2025-08-26 11:14:32', '2025-08-26 11:14:32', NULL),
(16, 'neil', 'neilasis21@gmail.com', '123', 'admin', NULL, NULL, '2025-08-26 11:15:01', '2025-08-26 11:15:01', NULL),
(18, 'neil', 'neil22@gmail.com', '123', 'teacher', NULL, '123', '2025-08-26 12:21:34', '2025-08-26 12:29:39', 1),
(22, 'n', 'n1@gmail.com', '123', 'student', '12345', NULL, '2025-08-27 11:30:07', '2025-08-28 01:58:23', 2),
(23, '1234', '123@gmail.com', '123', 'student', '123456', NULL, '2025-08-27 11:30:52', '2025-08-27 11:30:52', 3),
(24, 'mar', 'm@gmail.com', '123', 'student', '123', NULL, '2025-08-28 03:54:19', '2025-08-28 03:54:19', 2),
(25, 'Josiah', 'josiah@gmail.com', '123123', 'student', '04-2324-038854', NULL, '2025-08-28 04:39:00', '2025-08-28 04:39:29', 1);

-- --------------------------------------------------------

--
-- Structure for view `applicant_counts`
--
DROP TABLE IF EXISTS `applicant_counts`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `applicant_counts`  AS SELECT `jp`.`id` AS `job_id`, `jp`.`title` AS `job_title`, count(`a`.`id`) AS `total_applicants` FROM (`job_postings` `jp` left join `applications` `a` on(`a`.`job_id` = `jp`.`id`)) GROUP BY `jp`.`id`, `jp`.`title` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_job` (`job_id`),
  ADD KEY `fk_student` (`student_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `job_postings`
--
ALTER TABLE `job_postings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posted_by_id` (`posted_by_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `submitted_by` (`submitted_by`),
  ADD KEY `fk_reports_resolved_by` (`resolved_by`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `department_id` (`department_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `job_postings`
--
ALTER TABLE `job_postings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `fk_job` FOREIGN KEY (`job_id`) REFERENCES `job_postings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_student` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `job_postings`
--
ALTER TABLE `job_postings`
  ADD CONSTRAINT `job_postings_ibfk_1` FOREIGN KEY (`posted_by_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `job_postings_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`);

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `fk_reports_resolved_by` FOREIGN KEY (`resolved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`submitted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
