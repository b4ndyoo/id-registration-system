-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 07, 2024 at 04:28 AM
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
-- Database: `lormastudentidregistration`
--

-- --------------------------------------------------------

--
-- Table structure for table `archives_college`
--

CREATE TABLE `archives_college` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `firstname` varchar(25) NOT NULL,
  `middleinitial` varchar(25) NOT NULL,
  `lastname` varchar(25) NOT NULL,
  `birthday` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `idnumber` int(11) NOT NULL,
  `courseyear` varchar(25) NOT NULL,
  `address` varchar(25) NOT NULL,
  `contactperson` varchar(25) NOT NULL,
  `contactnumber` varchar(25) NOT NULL,
  `idpicture` varchar(100) DEFAULT NULL,
  `signature` varchar(100) DEFAULT NULL,
  `payment` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
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
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(7, '0001_01_01_000000_create_users_table', 1),
(8, '0001_01_01_000001_create_cache_table', 1),
(9, '0001_01_01_000002_create_jobs_table', 1),
(10, '2024_09_13_074802_add_new_fields_to_users_table', 1),
(11, '2024_09_18_011703_registered_students', 1),
(12, '2024_09_19_074401_archives', 1);

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
-- Table structure for table `registered_college_students`
--

CREATE TABLE `registered_college_students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `firstname` varchar(25) NOT NULL,
  `middleinitial` varchar(25) NOT NULL,
  `lastname` varchar(25) NOT NULL,
  `birthday` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `idnumber` int(11) NOT NULL,
  `courseyear` varchar(25) NOT NULL,
  `address` varchar(25) NOT NULL,
  `contactperson` varchar(25) NOT NULL,
  `contactnumber` varchar(255) NOT NULL,
  `idpicture` varchar(100) DEFAULT NULL,
  `signature` varchar(100) DEFAULT NULL,
  `payment` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `registered_college_students`
--

INSERT INTO `registered_college_students` (`id`, `firstname`, `middleinitial`, `lastname`, `birthday`, `email`, `idnumber`, `courseyear`, `address`, `contactperson`, `contactnumber`, `idpicture`, `signature`, `payment`, `created_at`, `updated_at`) VALUES
(20, 'sample2', 'sample2', 'sample2', 'sample2', 'sample2@lorma.edu', 5100523, 'sample2', 'sample2', 'sample2', '092394329', 'public/images/idPictures/5100523-2024-id.png', 'public/images/signatures/5100523-2024-sign.png', NULL, '2024-10-01 19:43:16', '2024-10-01 19:43:16'),
(21, 'Jovan', 'M.', 'Dela Cerna', 'March 16, 2003', 'jovan.delacerna@lorma.edu', 5100538, 'BSCS - IV', 'La Union', 'F Dela Cerna', '09291050400', 'public/images/idPictures/5100538-2024-id.jpg', 'public/images/signatures/5100538-2024-sign.jpg', 'public/images/payments/5100538-2024-payment.png', '2024-10-01 19:43:19', '2024-10-01 19:43:19'),
(22, 'Sample 1', 'Sample 1', 'Sample 1', 'Sample 1', 'dfasd@lorma.edu', 9657457, 'Sample 1', 'Sample 1', 'Sample 1', 'Sample 1', 'public/images/idPictures/9657457-2024-id.png', 'public/images/signatures/9657457-2024-sign.png', NULL, '2024-10-01 19:46:59', '2024-10-01 19:46:59'),
(26, 'sample3', 'sample3', 'sample3', 'sample3', 'sample3@lorma.edu', 423322, 'sample3', 'sample3', 'sample3', '909123122', 'public/images/idPictures/423322-2024-id.png', 'public/images/signatures/423322-2024-sign.png', NULL, '2024-10-01 21:24:23', '2024-10-01 21:24:23'),
(27, 'sample4', 'sample4', 'sample4', 'sample4', 'sample4@lorma.edu', 53454543, 'sample4', 'sample4', 'sample4', 'sample4', 'public/images/idPictures/53454543-2024-id.png', 'public/images/signatures/53454543-2024-sign.png', NULL, '2024-10-01 21:24:25', '2024-10-01 21:24:25'),
(28, 'sample5', 'sample5', 'sample5', 'sample5', 'sample5@lorma.edu', 785642, 'sample5', 'sample5', 'sample5', 'sample5', 'public/images/idPictures/785642-2024-id.jpeg', 'public/images/signatures/785642-2024-sign.jpg', NULL, '2024-10-01 21:24:28', '2024-10-01 21:24:28');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('mhLn1U9juuiliUNTHTuotsQL6nH8Iu0MCmXZiETA', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36 Edg/129.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoianhEdVF6UENqOGM0QXpSQ3dqN1hFNXdjWnFGaEtZQlY5SEVoSVA3UyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zdHVkZW50cy10YWJsZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1727847588);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'jovan', 'chs@lorma.edu', 'chs', NULL, '$2y$12$8GO4Cynn/p4F9c7xm3U2WOvKVcYsgO11pWqnWxCdotq51H6uIQuKu', NULL, '2024-09-26 21:28:04', '2024-09-26 21:28:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `archives_college`
--
ALTER TABLE `archives_college`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

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
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `registered_college_students`
--
ALTER TABLE `registered_college_students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `archives_college`
--
ALTER TABLE `archives_college`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `registered_college_students`
--
ALTER TABLE `registered_college_students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
