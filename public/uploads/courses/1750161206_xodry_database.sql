-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 13, 2025 at 04:21 AM
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
-- Database: `xodry_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `bullet_point_1` varchar(255) DEFAULT NULL,
  `bullet_point_2` varchar(255) DEFAULT NULL,
  `bullet_point_3` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `image`, `category_name`, `description`, `bullet_point_1`, `bullet_point_2`, `bullet_point_3`) VALUES
(10, 'uploads/developer-8764527.jpg', 'Dry Cleaning', 'This is  the example card of service for  testing purpose', 'Free Pickup', 'Free Delivery', 'Same Day Delivery'),
(11, 'uploads/nature-tranquil-beauty-reflected-calm-water-generative-ai.jpg', 'Wash And Iron', 'This is  the second example card for testing purpose', 'Free Pickup', 'Free Delivery', 'Same Day Delivery'),
(12, 'uploads/pexels-omaralnahi-18495.jpg', 'Premium Laundry', 'This is also a example  car of service for testing purpose', 'Free Pickup', 'Free Delivery', 'Same Day Delivery');

-- --------------------------------------------------------

--
-- Table structure for table `pickups`
--

CREATE TABLE `pickups` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `schedule` varchar(100) NOT NULL,
  `number` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `status` varchar(50) DEFAULT 'Order Placed',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `rider_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `pickups`
--

INSERT INTO `pickups` (`id`, `user_id`, `name`, `schedule`, `number`, `address`, `status`, `created_at`, `rider_id`) VALUES
(1, 2, 'Monis Raza Khan', '12/01/2012', '9198599490', 'sandila', 'Dropped at Store', '2025-05-29 14:02:55', 17),
(2, 2, 'Monis Raza Khan', '12/01/2012', '9198599490', 'sandila', 'Delivered', '2025-05-29 14:03:11', 17),
(3, 2, 'Monis Raza Khan', '12/01/2012', '9198599490', 'sandila', 'Delivered', '2025-05-29 14:07:42', 17),
(4, 2, 'Monis Raza Khan', '12/01/2012', '9198599490', 'sandila', 'Dropped at Store', '2025-05-29 14:14:16', 17),
(5, 2, 'Monis Raza Khan', '12/01/2012', '9198599490', 'sandila', 'Order Placed', '2025-05-29 14:15:05', NULL),
(6, 2, 'Monis Raza Khan', '12/01/2012', '9198599490', 'sandila', 'Order Placed', '2025-05-29 14:19:37', NULL),
(7, 17, 'Monis Raza Khan', '12/01/2012', '8090492602', 'sandila', 'Order Placed', '2025-05-29 14:34:55', NULL),
(8, 2, 'Monis Raza Khan', '12/12/1212', '9198599490', 'sandila lucknow', 'Order Placed', '2025-06-04 06:38:46', NULL),
(9, 2, 'Monis Raza Khan', '12/01/2045', '9198599490', 'sandila lucknow', 'Order Placed', '2025-06-04 06:51:16', NULL),
(10, 2, 'Monis Raza Khan', '12/01/2045', '9198599490', 'sandila lucknow', 'Order Placed', '2025-06-04 06:51:44', NULL),
(12, 2, 'Monis Raza Khan', '12/12/1212', '9198599490', 'sandila lucknow', 'Order Placed', '2025-06-05 03:08:38', NULL),
(13, 2, 'Monis Raza Khan', '12/01/2045', '9198599490', 'lucknow', 'Order Placed', '2025-06-05 03:52:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `category_id`, `service_name`, `price`) VALUES
(3, 11, 't-shirt', 99.00),
(4, 10, 'coat pant', 100.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `number` varchar(10) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','rider','user') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `number`, `email`, `address`, `password`, `role`, `created_at`) VALUES
(2, 'Monis Raza Khan', '9198599490', 'mkmonisraza0786@gmail.com', 'sandila', '$2y$10$wypsyXtfK8mplEYcB20a5.TzvPST2iES9x0IC6ktbr88Xfyq7HhjG', 'admin', '2025-05-29 02:38:21'),
(17, 'Monis Raza Khan', '8090492602', NULL, 'sandila', '$2y$10$0F5i.j/iy9BYhNrghyRefeOYgV1QIru6M8XrS3Ug5cI0Qbep2hLb.', 'rider', '2025-05-29 12:24:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pickups`
--
ALTER TABLE `pickups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `rider_id` (`rider_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `number` (`number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `pickups`
--
ALTER TABLE `pickups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pickups`
--
ALTER TABLE `pickups`
  ADD CONSTRAINT `fk_pickup_rider` FOREIGN KEY (`rider_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pickups_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
