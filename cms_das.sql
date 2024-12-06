-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2024 at 02:59 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms_das`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(11) NOT NULL,
  `cat_title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `comment_author` varchar(100) NOT NULL,
  `comment_email` varchar(100) NOT NULL,
  `comment_content` text NOT NULL,
  `comment_status` enum('approved','unapproved') DEFAULT 'unapproved',
  `comment_date` datetime DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `project_id`, `comment_author`, `comment_email`, `comment_content`, `comment_status`, `comment_date`, `user_id`) VALUES
(1, 4, 'insss1@gmail.com', '<br />\r\n<b>Notice</b>:  Undefined index: user_email in <b>C:\\xampp\\htdocs\\pro1\\pro2\\manage_projects.', 'jhkjh', 'unapproved', '2024-12-05 17:31:48', NULL),
(2, 4, 'insss1@gmail.com', '<br />\r\n<b>Notice</b>:  Undefined index: user_email in <b>C:\\xampp\\htdocs\\pro1\\pro2\\manage_projects.', 'add', 'unapproved', '2024-12-05 17:36:00', NULL),
(3, 4, 'insss1@gmail.com', '<br />\r\n<b>Notice</b>:  Undefined index: user_email in <b>C:\\xampp\\htdocs\\pro1\\pro2\\manage_projects.', 'welcam\r\n', 'unapproved', '2024-12-05 17:36:19', NULL),
(4, 5, 'in111@gmail.com', '<br />\r\n<b>Notice</b>:  Undefined index: user_email in <b>C:\\xampp\\htdocs\\pro1\\pro2\\manage_projects.', 'welcame of in111@gmail.com', 'unapproved', '2024-12-06 05:00:46', NULL),
(5, 7, 'user1@gmail.com', '<br />\r\n<b>Notice</b>:  Undefined index: user_email in <b>C:\\xampp\\htdocs\\pro1\\pro2\\manage_projects.', 'welcam', 'unapproved', '2024-12-06 05:53:36', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(4) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `user_id`, `message`, `is_read`, `created_at`) VALUES
(1, 2, 'Your project has been approved.', 0, '2024-12-05 15:17:03'),
(2, 8, 'Your project has been approved.', 1, '2024-12-05 16:58:56'),
(3, 8, 'Your project has been approved.', 0, '2024-12-05 17:27:48'),
(4, 9, 'Your project has been rejected.', 1, '2024-12-05 17:32:49'),
(5, 5, 'Your project has been approved.', 0, '2024-12-06 05:01:01'),
(6, 1, 'Your project has been approved.', 0, '2024-12-06 05:53:07');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `post_title` varchar(255) NOT NULL,
  `post_content` text NOT NULL,
  `post_author` int(11) NOT NULL,
  `post_date` datetime DEFAULT current_timestamp(),
  `post_category_id` int(11) DEFAULT NULL,
  `post_status` enum('draft','published','archived') NOT NULL DEFAULT 'draft'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `project_title` varchar(255) NOT NULL,
  `project_file` varchar(255) NOT NULL,
  `upload_date` datetime DEFAULT current_timestamp(),
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `project_description` text DEFAULT NULL,
  `submitted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`project_id`, `user_id`, `project_title`, `project_file`, `upload_date`, `status`, `project_description`, `submitted_by`) VALUES
(1, 2, 'java', 'discover saudi qxJ .pdf', '2024-12-05 14:37:19', 'approved', NULL, NULL),
(2, 8, 'java', 'discover saudi qxJ .pdf', '2024-12-05 15:14:40', 'approved', NULL, NULL),
(3, 9, 'hhhhh', 'discover saudi qxJ .pdf', '2024-12-05 16:19:46', 'rejected', NULL, NULL),
(4, 8, 'c', 'er.docx', '2024-12-05 16:55:24', 'approved', NULL, NULL),
(5, 5, 'python', 'discover saudi qxJ .pdf', '2024-12-06 04:59:02', 'approved', NULL, NULL),
(6, 5, 'java 1', 'discover saudi dRN .pdf', '2024-12-06 05:11:24', 'pending', 'java oop laern many coception ', 5),
(7, 1, 'c++', 'package javaapplication6.pdf', '2024-12-06 05:48:42', 'approved', 'c++ learning c', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `salesperson` text DEFAULT NULL,
  `region` text DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_firstname` varchar(50) NOT NULL,
  `user_lastname` varchar(50) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_role` enum('student','instructor') NOT NULL,
  `user_image` varchar(255) DEFAULT 'default.jpg',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `user_password`, `user_firstname`, `user_lastname`, `user_email`, `user_role`, `user_image`, `created_at`) VALUES
(1, 'user1@gmail.com', '$2y$10$V0VM//nUxN9rkGsZ8lU1L.jc.SiQWC/YoSJhCr1u4M1GSpeZxd4Ba', 'user1@gmail.com', 'user1@gmail.com', 'user1@gmail.com', 'student', 'default.jpg', '2024-12-05 17:17:22'),
(2, 'user2@gmail.com', '$2y$10$6KoNusvEeihItBeBliHO7OUB33Arf5fdJrRYalzOSRCYqKVcV.BAG', 'user2@gmail.com', 'user2@gmail.com', 'user2@gmail.com', 'instructor', 'default.jpg', '2024-12-05 17:17:22'),
(3, 'in22@gmail.com', '$2y$10$5XkduniCM4JJ8YXoTgsFl.FMqjH.wK3dm7M/8jCnQ0Mq0RaZjYjDu', 'in22@gmail.com', 'in22@gmail.com', 'in22@gmail.com', 'instructor', 'default.jpg', '2024-12-05 17:17:22'),
(4, 'in11@gmail.com', '$2y$10$ki0Y03uWja6Kp0aAK2scR.ynSGbuifbnUBBNatka5kFS7glFFIaW6', 'in11@gmail.com', 'in11@gmail.com', 'in11@gmail.com', 'student', 'default.jpg', '2024-12-05 17:17:22'),
(5, 'in111@gmail.com', '$2y$10$O0qcdps3gAeKg.kS.fCgNuaV2N92nlYuN3RZPDewC9RBpieRylHam', 'in111@gmail.com', 'in111@gmail.com', 'in111@gmail.com', 'student', 'default.jpg', '2024-12-05 17:17:22'),
(7, 'inst111@gmail.com', '$2y$10$U5uV8vIbiG2vNquDv0H4hu4/egM8yD7lNQvC.S6xkl4BYTLAbX1w.', 'inst111@gmail.com', 'inst111@gmail.com', 'inst111@gmail.com', 'instructor', 'default.jpg', '2024-12-05 17:17:22'),
(8, 'insss1@gmail.com', '$2y$10$nvMB1tCXYG8xdZGEvK428eGc/L6sDbz2WzhZXrlJKTP286u2YkWgG', 'insss1@gmail.com', 'insss1@gmail.com', 'insss1@gmail.com', 'instructor', 'default.jpg', '2024-12-05 17:17:22'),
(9, 'student11@gmail.com', '$2y$10$LWCYMjQkeCqtXey6sh5IZenDarv6o757e/WDB2jBbDXCWB.sOn9Q.', 'student11@gmail.com', 'student11@gmail.com', 'student11@gmail.com', 'student', 'default.jpg', '2024-12-05 17:17:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `post_author` (`post_author`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`project_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
