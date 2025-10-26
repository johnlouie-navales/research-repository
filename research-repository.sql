-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 26, 2025 at 02:25 AM
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
-- Database: `research-repository`
--

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE `authors` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`id`, `first_name`, `last_name`, `email`, `created_at`, `updated_at`) VALUES
(1, 'Maria', 'dela Cruz', 'maria.delacruz@university.edu', '2025-10-25 09:41:51', '2025-10-25 09:41:51'),
(2, 'John', 'Santos', 'john.santos@university.edu', '2025-10-25 09:41:51', '2025-10-25 09:41:51'),
(3, 'Chris', 'Reyes', 'chris.reyes@university.edu', '2025-10-25 09:41:51', '2025-10-25 09:41:51'),
(4, 'Patricia', 'Gonzales', 'pat.gonzales@university.edu', '2025-10-25 09:41:51', '2025-10-25 09:41:51');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'College of Engineering and Technology', '2025-10-25 09:41:51', '2025-10-25 09:41:51'),
(2, 'College of Arts and Sciences', '2025-10-25 09:41:51', '2025-10-25 09:41:51'),
(3, 'College of Business and Accountancy', '2025-10-25 09:41:51', '2025-10-25 09:41:51');

-- --------------------------------------------------------

--
-- Table structure for table `research_works`
--

CREATE TABLE `research_works` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `abstract` text NOT NULL,
  `publication_year` year(4) NOT NULL,
  `keywords` text DEFAULT NULL,
  `file_path` varchar(512) NOT NULL,
  `department_id` int(10) UNSIGNED DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `research_works`
--

INSERT INTO `research_works` (`id`, `title`, `abstract`, `publication_year`, `keywords`, `file_path`, `department_id`, `uploaded_at`, `updated_at`) VALUES
(1, 'An Innovative System for Efficient Storage and Seamless Access to Research Works', 'This study focuses on the development of a digital repository using PHP and MySQL to manage and retrieve academic research efficiently. The system features advanced sorting and filtering by department...', '2024', 'digital repository, PHP, MySQL, information retrieval', '/uploads/repository_system_paper_2024.pdf', 1, '2025-10-25 09:41:51', '2025-10-25 09:41:51'),
(2, 'The Impact of Social Media on Political Discourse in Southeast Asia', 'Analyzing the trends of political communication on popular social media platforms, this paper explores the shift in public opinion and civic engagement over the past decade...', '2023', 'social media, politics, southeast asia, discourse analysis', '/uploads/social_media_politics_2023.pdf', 2, '2025-10-25 09:41:51', '2025-10-25 09:41:51'),
(3, 'Sustainable Business Models for Local E-Commerce Startups', 'This research investigates viable and sustainable business models for small to medium e-commerce enterprises in a post-pandemic economy. It provides a framework for financial and operational sustainability...', '2024', 'e-commerce, sustainability, business models, startups', '/uploads/ecommerce_sustainability_2024.pdf', 3, '2025-10-25 09:41:51', '2025-10-25 09:41:51');

-- --------------------------------------------------------

--
-- Table structure for table `work_authors`
--

CREATE TABLE `work_authors` (
  `work_id` int(10) UNSIGNED NOT NULL,
  `author_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `work_authors`
--

INSERT INTO `work_authors` (`work_id`, `author_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2025-10-25 09:41:51', '2025-10-25 09:41:51'),
(3, 1, '2025-10-25 09:41:51', '2025-10-25 09:41:51'),
(1, 2, '2025-10-25 09:41:51', '2025-10-25 09:41:51'),
(3, 3, '2025-10-25 09:41:51', '2025-10-25 09:41:51'),
(2, 4, '2025-10-25 09:41:51', '2025-10-25 09:41:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `full_name` (`first_name`,`last_name`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `research_works`
--
ALTER TABLE `research_works`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department_id` (`department_id`);
ALTER TABLE `research_works` ADD FULLTEXT KEY `search_index` (`title`,`abstract`,`keywords`);

--
-- Indexes for table `work_authors`
--
ALTER TABLE `work_authors`
  ADD PRIMARY KEY (`author_id`,`work_id`),
  ADD KEY `work_id` (`work_id`),
  ADD KEY `author_id` (`author_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `research_works`
--
ALTER TABLE `research_works`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `research_works`
--
ALTER TABLE `research_works`
  ADD CONSTRAINT `research_works_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `work_authors`
--
ALTER TABLE `work_authors`
  ADD CONSTRAINT `work_authors_ibfk_1` FOREIGN KEY (`work_id`) REFERENCES `research_works` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `work_authors_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
