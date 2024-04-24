-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 24, 2024 at 06:28 PM
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
-- Database: `mugsmugglescafe`
--

-- --------------------------------------------------------

--
-- Table structure for table `brews`
--

CREATE TABLE `brews` (
  `brew_id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `size` varchar(10) NOT NULL,
  `price` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brews`
--

INSERT INTO `brews` (`brew_id`, `name`, `size`, `price`) VALUES
(0, 'Caffeine Chaos	', 'small', 4),
(1, 'Caffeine Chaos	', 'medium', 5),
(2, 'Caffeine Chaos	', 'large', 5),
(3, 'Java Jive', 'small', 4),
(4, 'Java Jive', 'medium', 5),
(5, 'Java Jive', 'large', 5),
(6, 'Velvet Vortex', 'small', 5),
(7, 'Velvet Vortex', 'medium', 5),
(8, 'Velvet Vortex', 'large', 6),
(9, 'Espresso Exilir', 'small', 5),
(10, 'Espresso Exilir', 'medium', 5),
(11, 'Espresso Exilir', 'large', 6),
(12, 'Latte Loco', 'small', 5),
(13, 'Latte Loco', 'medium', 6),
(14, 'Latte Loco', 'large', 6),
(15, 'Frothy Fantasy', 'small', 6),
(16, 'Frothy Fantasy', 'medium', 6),
(17, 'Frothy Fantasy', 'large', 7);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `brew_id` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `size` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `brew_id`, `quantity`, `order_date`, `size`) VALUES
(7, 4, 0, 1, '2024-04-24 02:44:42', 'medium'),
(9, 4, 1, 5, '2024-04-24 02:59:47', 'large'),
(11, 4, 4, 6, '2024-04-24 03:01:58', 'large'),
(12, 4, 3, 9, '2024-04-24 03:17:57', 'medium'),
(13, 4, 4, 7, '2024-04-24 03:18:50', 'medium'),
(14, 4, 2, 3, '2024-04-24 03:22:17', 'small'),
(15, 4, 2, 100, '2024-04-24 03:22:28', 'medium'),
(17, 4, 4, 3, '2024-04-24 19:30:32', 'small'),
(18, 5, 3, 3, '2024-04-24 21:57:32', 'small'),
(19, 5, 0, 4, '2024-04-24 21:57:54', 'medium'),
(23, 4, 0, 4, '2024-04-24 22:23:38', 'small'),
(24, 4, 5, 1, '2024-04-24 22:24:23', 'large');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(4, 'user1', '$2y$10$y9RAoAHpkgccjn7xDUfnquBFDCVrYInZEgATMNgC5hnj5AM9lAr2a', '2024-04-23 20:00:08'),
(5, 'user2', '$2y$10$QOSplGrgz6oFE0t.AmpSkOF8qwWPSqoCsF8bDXyRByTTmzJF.VslW', '2024-04-24 13:17:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brews`
--
ALTER TABLE `brews`
  ADD PRIMARY KEY (`brew_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `brew_id` (`brew_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brews`
--
ALTER TABLE `brews`
  MODIFY `brew_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`brew_id`) REFERENCES `brews` (`brew_id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
