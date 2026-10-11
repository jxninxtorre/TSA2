-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 27, 2026 at 08:59 AM
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
-- Database: `tsa1`
--

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `task_date` date NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `title`, `status`, `task_date`, `created_at`) VALUES
(1, 'Message Hans Pomida about project deadline', 'pending', '2026-09-27', '2026-09-27 14:22:31'),
(2, 'Follow up with Janina Torre on requirements', 'pending', '2026-09-27', '2026-09-27 14:22:31'),
(3, 'Call John Lorenz DG for POS project update', 'completed', '2026-09-27', '2026-09-27 14:22:31'),
(4, 'Update Rugero King on task status', 'in_progress', '2026-09-27', '2026-09-27 14:22:31'),
(5, 'Ask Jsean Eduard Del Rosario for ERD draft', 'pending', '2026-09-26', '2026-09-27 14:22:31'),
(6, 'Meet with Julieta Muñoz for group discussion', 'completed', '2026-09-26', '2026-09-27 14:22:31'),
(7, 'Send Justin David Nepomuceno the schema file', 'pending', '2026-09-25', '2026-09-27 14:22:31'),
(8, 'Coordinate with Justine Jacob on the presentation', 'completed', '2026-09-25', '2026-09-27 14:22:31'),
(9, 'Review Maeko Joaquin Gonzalo code submission', 'pending', '2026-09-24', '2026-09-27 14:22:31'),
(10, 'Confirm schedule with Raleon James Lorenzo', 'in_progress', '2026-09-24', '2026-09-27 14:22:31'),
(11, 'Discuss testing plan with Thyrone Bryce Barroquillo', 'pending', '2026-09-24', '2026-09-27 14:22:31');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `full_name`, `email`, `created_at`) VALUES
(2, 'torrejanina', 'Janina Torre', 'jnaaaa@example.com', '2026-09-27 14:30:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
