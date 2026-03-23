-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 23, 2026 at 07:22 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `trisha`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_content`
--

CREATE TABLE `tbl_content` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL COMMENT 'Car model name e.g. Toyota Hilux',
  `description` text NOT NULL COMMENT 'Short vehicle description',
  `image_url` varchar(500) NOT NULL COMMENT 'Full URL or relative path to car image',
  `price` varchar(80) DEFAULT NULL COMMENT 'Price range e.g. UGX 55M - 120M',
  `year_range` varchar(30) DEFAULT NULL COMMENT 'Year range e.g. 2016-2023',
  `badge` varchar(40) DEFAULT NULL COMMENT 'Badge label: Hot, Best Seller, etc.',
  `is_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=visible, 0=hidden',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_content`
--

INSERT INTO `tbl_content` (`id`, `title`, `description`, `image_url`, `price`, `year_range`, `badge`, `is_active`, `created_at`) VALUES
(1, 'Toyota Noah', 'Spacious 7-8 seater family van. Very popular for taxi/business use in Kampala. Reliable, fuel-efficient.', 'https://images.unsplash.com/photo-1519641471654-76ce0107ad1b?w=700&q=80', 'UGX 45M - 75M', '2018-2022', 'Best Seller', 1, '2026-03-23 18:19:40'),
(2, 'Toyota Hilux', 'Tough double-cab pickup. King of Uganda roads - great for business, farming & rough terrain.', 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=700&q=80', 'UGX 55M - 120M', '2016-2023', 'Hot', 1, '2026-03-23 18:19:40'),
(3, 'Land Cruiser Prado', 'Premium SUV - durable, off-road capable, high resale value. Favourite for families & executives.', 'https://images.unsplash.com/photo-1606664515524-ed2f786a0bd6?w=700&q=80', 'UGX 90M - 180M', '2014-2021', 'Premium', 1, '2026-03-23 18:19:40'),
(4, 'Toyota Harrier', 'Luxury crossover SUV. Stylish, comfortable, smooth drive - very sought after in Uganda.', 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?w=700&q=80', 'UGX 50M - 95M', '2014-2020', NULL, 1, '2026-03-23 18:19:40'),
(5, 'Toyota Corolla', 'Reliable sedan - low maintenance, fuel saver. Perfect daily driver for city use.', 'https://images.unsplash.com/photo-1541899481282-d53bffe3c35d?w=700&q=80', 'UGX 35M - 65M', '2016-2023', NULL, 1, '2026-03-23 18:19:40'),
(6, 'Nissan Navara', 'Strong pickup alternative to Hilux. Good payload & off-road ability for work.', 'https://images.unsplash.com/photo-1486496146582-9ffcd0b2b2b7?w=700&q=80', 'UGX 50M - 90M', '2015-2022', NULL, 1, '2026-03-23 18:19:40'),
(7, 'Mitsubishi Delica', 'Rugged 7-8 seater MPV. Excellent for families & group transport on rough roads.', 'https://images.unsplash.com/photo-1546614042-7df3c24c9e5d?w=700&q=80', 'UGX 40M - 70M', '2013-2020', NULL, 1, '2026-03-23 18:19:40'),
(8, 'Subaru Forester', 'AWD safety & performance. Great handling in rain & on bad roads. Safety-rated.', 'https://images.unsplash.com/photo-1544636331-e26879cd4d9b?w=700&q=80', 'UGX 45M - 85M', '2016-2022', 'New Arrival', 1, '2026-03-23 18:19:40');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Indexes for table `tbl_content`
--
ALTER TABLE `tbl_content`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `tbl_content`
--
ALTER TABLE `tbl_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
