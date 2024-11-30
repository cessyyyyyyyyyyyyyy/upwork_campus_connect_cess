-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2024 at 03:04 PM
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
-- Database: `upwork_campus_connect_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('admin') DEFAULT 'admin',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`user_id`, `username`, `email`, `password`, `user_type`, `created_at`) VALUES
(1, 'admin', 'admin@gmail.com', 'adminpass', 'admin', '2024-11-23 18:36:03');

-- --------------------------------------------------------

--
-- Table structure for table `freelancers`
--

CREATE TABLE `freelancers` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `freelancers`
--

INSERT INTO `freelancers` (`id`, `username`, `email`) VALUES
(1, 'FreelancerName', 'freelancer@example.com');

-- --------------------------------------------------------

--
-- Table structure for table `freelancer_reviews`
--

CREATE TABLE `freelancer_reviews` (
  `review_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `reviewer_id` int(11) DEFAULT NULL,
  `freelancer_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `freelancer_reviews`
--

INSERT INTO `freelancer_reviews` (`review_id`, `project_id`, `reviewer_id`, `freelancer_id`, `rating`, `comment`, `created_at`) VALUES
(1, 1, 8, 1, 5, 'amazing', '2024-11-24 13:53:39'),
(2, 10, 1, 1, 2, 'hays', '2024-11-24 17:42:50');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `freelancer_id` int(11) NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('in_progress','completed','pending','not_started') DEFAULT 'not_started',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `freelancer_id`, `job_title`, `description`, `status`, `created_at`, `updated_at`) VALUES
(2, 1, 'Test Job', 'This is a test job description', 'pending', '2024-11-24 16:19:58', '2024-11-24 16:19:58');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `read_status` enum('unread','read') DEFAULT 'unread'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `project_id`, `sender_id`, `receiver_id`, `message`, `is_read`, `timestamp`, `created_at`, `read_status`) VALUES
(114, 0, 1, 2, 'hi', 0, '2024-11-30 09:39:32', '2024-11-30 09:39:32', 'read'),
(115, 0, 1, 2, 'what wrong', 0, '2024-11-30 09:39:41', '2024-11-30 09:39:41', 'read'),
(116, 0, 1, 2, 'hi', 0, '2024-11-30 09:40:54', '2024-11-30 09:40:54', 'read'),
(117, 0, 10, 2, 'hi', 0, '2024-11-30 09:47:59', '2024-11-30 09:47:59', 'unread'),
(118, 0, 1, 2, 'hello', 0, '2024-11-30 09:59:46', '2024-11-30 09:59:46', 'read'),
(119, 0, 10, 2, 'hi', 0, '2024-11-30 10:06:46', '2024-11-30 10:06:46', 'unread'),
(120, 0, 1, 2, 'lokk', 0, '2024-11-30 10:06:58', '2024-11-30 10:06:58', 'read'),
(121, 0, 1, 1, 'hi', 0, '2024-11-30 10:13:05', '2024-11-30 10:13:05', 'read'),
(122, 0, 1, 2, 'hello', 0, '2024-11-30 10:13:20', '2024-11-30 10:13:20', 'read'),
(123, 0, 10, 1, 'hi', 0, '2024-11-30 10:14:13', '2024-11-30 10:14:13', 'read'),
(124, 0, 1, 2, 'say', 0, '2024-11-30 10:32:23', '2024-11-30 10:32:23', 'read'),
(125, 0, 1, 2, 'what', 0, '2024-11-30 12:33:28', '2024-11-30 12:33:28', 'unread');

-- --------------------------------------------------------

--
-- Table structure for table `overall_reviews`
--

CREATE TABLE `overall_reviews` (
  `review_id` int(11) NOT NULL,
  `reviewer_name` varchar(100) NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(100) NOT NULL,
  `project_id` int(100) NOT NULL,
  `client_id` int(100) NOT NULL,
  `freelancer_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `status` enum('pending','completed','failed') DEFAULT 'pending',
  `withdrawal_status` varchar(255) DEFAULT 'not_withdrawable'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `project_id`, `client_id`, `freelancer_id`, `amount`, `paid_at`, `status`, `withdrawal_status`) VALUES
(5, 5, 9, 9, 5000.00, '2024-11-24 17:52:04', 'pending', 'not_withdrawable'),
(6, 6, 9, 9, 7000.00, '2024-11-24 17:52:01', 'pending', 'not_withdrawable'),
(7, 7, 9, 9, 5000.00, '2024-11-24 17:51:58', 'pending', 'not_withdrawable'),
(8, 8, 1, 9, 7000.00, '2024-11-24 17:51:54', 'pending', 'not_withdrawable'),
(9, 9, 1, 9, 5000.00, '2024-11-24 17:24:05', 'pending', 'not_withdrawable'),
(10, 10, 1, 1, 6000.00, '2024-11-24 17:35:15', 'pending', 'not_withdrawable'),
(11, 11, 1, 1, 5500.00, NULL, 'pending', 'not_withdrawable'),
(12, 12, 1, 1, 6000.00, NULL, 'pending', 'not_withdrawable'),
(13, 13, 1, 9, 5000.00, NULL, 'pending', 'not_withdrawable');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `project_id` int(100) NOT NULL COMMENT 'Primary Key	',
  `client_id` int(100) NOT NULL COMMENT 'Foreign key (users.user_id)	',
  `freelancer_id` int(100) NOT NULL COMMENT 'Foreign key (users.user_id)	',
  `job_id` int(100) DEFAULT NULL COMMENT 'Reference to Jobs Table	',
  `status` enum('ongoing','completed','cancelled') NOT NULL DEFAULT 'ongoing',
  `started_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `completed_at` timestamp NULL DEFAULT NULL,
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `review_left` tinyint(1) DEFAULT 0,
  `amount_paid` decimal(10,2) DEFAULT 0.00,
  `payment_status` enum('paid','pending','unpaid') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`project_id`, `client_id`, `freelancer_id`, `job_id`, `status`, `started_at`, `completed_at`, `cancelled_at`, `review_left`, `amount_paid`, `payment_status`) VALUES
(1, 8, 1, 1, 'completed', '2024-11-24 06:51:45', '2024-11-24 13:53:08', NULL, 0, 5000.00, 'paid'),
(2, 9, 1, 1, 'ongoing', '2024-11-24 07:55:09', NULL, NULL, 0, 5000.00, 'unpaid'),
(3, 9, 3, 3, 'ongoing', '2024-11-24 07:55:11', NULL, NULL, 0, 3000.00, 'unpaid'),
(4, 9, 4, 4, 'ongoing', '2024-11-24 07:55:21', NULL, NULL, 0, 4000.00, 'unpaid'),
(5, 9, 9, 19, 'ongoing', '2024-11-24 08:21:11', NULL, NULL, 0, 5000.00, 'paid'),
(6, 9, 9, 18, 'ongoing', '2024-11-24 08:51:17', NULL, NULL, 0, 7000.00, 'paid'),
(7, 9, 9, 17, 'ongoing', '2024-11-24 08:55:59', NULL, NULL, 0, 5000.00, 'paid'),
(8, 1, 9, 18, 'completed', '2024-11-24 09:34:47', '2024-11-24 17:12:44', NULL, 0, 7000.00, 'paid'),
(9, 1, 9, 19, 'completed', '2024-11-24 10:20:34', '2024-11-24 17:42:07', NULL, 0, 5000.00, 'paid'),
(10, 1, 1, 20, 'completed', '2024-11-24 10:26:15', '2024-11-24 17:36:03', NULL, 0, 6000.00, 'paid'),
(11, 1, 1, 21, 'completed', '2024-11-29 09:26:11', '2024-11-29 16:26:56', NULL, 0, 5500.00, 'unpaid'),
(12, 1, 1, 20, 'completed', '2024-11-29 09:26:14', '2024-11-29 16:26:49', NULL, 0, 6000.00, 'unpaid'),
(13, 1, 9, 19, 'completed', '2024-11-29 09:26:16', '2024-11-29 16:26:31', NULL, 0, 5000.00, 'unpaid');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `service_id` int(100) NOT NULL,
  `freelancer_id` int(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`service_id`, `freelancer_id`, `title`, `description`, `price`, `created_at`) VALUES
(16, 9, 'Graphic Design for Branding', 'for logo', 5500.00, '2024-11-24 15:00:06'),
(17, 9, 'Photography', 'marlyn', 5000.00, '2024-11-24 15:05:15'),
(18, 9, 'Service Crew Member', 'marlyn', 7000.00, '2024-11-24 15:08:24'),
(19, 9, 'Photography', 'marlyn', 5000.00, '2024-11-24 15:16:13'),
(20, 1, 'Graphic Design for Branding', 'branding', 6000.00, '2024-11-24 17:26:07'),
(21, 1, 'E-Commerce Development', 'cessss', 5500.00, '2024-11-24 17:34:56');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(100) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('client','freelancer') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `username`, `email`, `password`, `user_type`, `created_at`) VALUES
(1, 'Princess Ann', 'Castillo', 'cess', 'princessanncastillo72@gmail.com', '$2y$10$r3.2vvxsIr1wp.3x3rfN..7Ac4JT137PPWXfuvp9FV3LSiVT7c2zW', 'freelancer', '2024-11-24 13:36:21'),
(3, 'Marlyn ', 'Dela Cruz', 'Marlyn', 'Marlyn@gmail.com', '$2y$10$bplSFL8XOT6aVvBJZDzmjeDJPtZ98lnG4qoeGfExb5jQn2ooghH0q', 'freelancer', '2024-11-24 13:40:46'),
(4, 'Jan Harold ', 'Dionela', 'Jan Harold', 'Janharold@gmail.com', '$2y$10$jutlvBniedKirAOKBzIqEu./akXClAD8F/GG3ejI1yFOe9WEJSbUO', 'freelancer', '2024-11-24 13:42:50'),
(5, 'Jan Harold ', 'Dionela', 'Jan Harold Dionela', 'Janharolddionela@gmail.com', '$2y$10$btUgztybBvSyPEsl2CAhVuflbw.1yzlwPra3Xu5.71dqKl1KWohuy', 'freelancer', '2024-11-24 13:45:16'),
(6, 'Kyla May', 'De Mariano', 'Kyla May De Mariano', 'Kyla@gmail.com', '$2y$10$rSZ0jt7LyvVQkIs6UPGBoe.iyokkscOad.ykZIrEocKrOQ/GK.Jg2', 'freelancer', '2024-11-24 13:46:46'),
(7, 'James Kendrick', 'Decena', 'James Kendrick Decena', 'James@gmail.com', '$2y$10$LypBdGrCZryWse1T0KcFtOurohvge7LWo1kmYTu/L.OBQ10H2HAvO', 'freelancer', '2024-11-24 13:48:29'),
(8, 'Marielle', 'Ragadio', 'Marielle Ragadio', 'Marielle@gmail.com', '$2y$10$uWZV5kQ9UWEUA9CQtOwl3.KakYdS6/eARSHo.4.ir1Ve4EhRhBSkS', 'freelancer', '2024-11-24 13:50:21'),
(9, 'Jim Brian', 'Aniñon', 'Jim', 'jim@gmail.com', '$2y$10$6FIjwPZXxBSkIkljMvIarezM3sK3hkHZQcpv4XBGaT8OMnkflpPJq', 'freelancer', '2024-11-24 15:19:52'),
(10, 'Dimple', 'Castillo', 'Dimple', 'dimple@gmail.com', '$2y$10$S9Y2BkoavP4zKSk4LQviTezdH0e23m9Bo/OntoRyElcDNyZskX.9S', 'client', '2024-11-29 15:24:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `freelancers`
--
ALTER TABLE `freelancers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `freelancer_reviews`
--
ALTER TABLE `freelancer_reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `reviewer_id` (`reviewer_id`),
  ADD KEY `freelancer_id` (`freelancer_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `freelancer_id` (`freelancer_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `overall_reviews`
--
ALTER TABLE `overall_reviews`
  ADD PRIMARY KEY (`review_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `freelancer_id` (`freelancer_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `freelancers`
--
ALTER TABLE `freelancers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `freelancer_reviews`
--
ALTER TABLE `freelancer_reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT for table `overall_reviews`
--
ALTER TABLE `overall_reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int(100) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key	', AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `service_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `freelancer_reviews`
--
ALTER TABLE `freelancer_reviews`
  ADD CONSTRAINT `freelancer_reviews_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`),
  ADD CONSTRAINT `freelancer_reviews_ibfk_2` FOREIGN KEY (`reviewer_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `freelancer_reviews_ibfk_3` FOREIGN KEY (`freelancer_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `jobs`
--
ALTER TABLE `jobs`
  ADD CONSTRAINT `jobs_ibfk_1` FOREIGN KEY (`freelancer_id`) REFERENCES `freelancers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`),
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `payments_ibfk_3` FOREIGN KEY (`freelancer_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
