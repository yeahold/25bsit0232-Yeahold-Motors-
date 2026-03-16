-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 16, 2026 at 03:00 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `trisha`
CREATE DATABASE IF NOT EXISTS `trisha` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `trisha`;
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT 'bmw-x5.jpg',
  `bio` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `phone`, `profile_picture`, `bio`, `created_at`, `updated_at`) VALUES
(1, 'Test User', 'test@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+256701234567', '', 'Hello, my name is Ndagire Trisha Yeahold, a balor degree student with a growing passion for technology and web development. I\'m still learning the ins and outs of coding, but I enjoy exploring how websites work and building projects step by step as I improve my skills.\r\n\r\nOutside of my studies, I love watching skating. The sport inspires me with its energy and strategy, and I bring that same curiosity and focus into my learning journey.\r\n\r\nMy aim is to keep developing my technical abilities while staying open to new ideas and challenges in life, building a foundation for a future career in IT.\r\n\r\nI am friendly , respectful,and hardworking.\r\ni believe in treating people with kindness and honesty.\r\nI bring value to the people around me.\r\nI am worthy of respect, kindness, and love.', '2026-03-09 15:30:45', '2026-03-12 13:30:55'),
(2, 'NDAGIRE TRISHA YEAHOLD', 'ty.ndagire@unik.ac.ug', '$2y$10$S8iQhXqZXAoFfVyrrEGgcezD6uH3HWbX.y3fN7uq/PUi/DCWdHamS', '', 'avatar_2_1773312406.jpeg', 'Hello, my name is Ndagire Trisha Yeahold, a bachalor degree student with a growing passion for technology and web development. I\'m still learning the ins and outs of coding, but I enjoy exploring how websites work and building projects step by step as I improve my skills.\r\n Outside of my studies, I love watching skating. The sport inspires me with its energy and strategy, and I bring that same curiosity and focus into my learning journey.\r\nMy aim is to keep developing my technical abilities while staying open to new ideas and challenges in life, building a foundation for a future career in IT.\r\nI am friendly , respectful,and hardworking.\r\ni believe in treating people with kindness and honesty.\r\nI bring value to the people around me.\r\nI am worthy of respect, kindness, and love.', '2026-03-09 15:34:46', '2026-03-12 13:46:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
