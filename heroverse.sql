-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2024 at 09:09 AM
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
-- Database: `dvwa`
--
CREATE DATABASE IF NOT EXISTS `dvwa` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `dvwa`;

-- --------------------------------------------------------

--
-- Table structure for table `guestbook`
--

CREATE TABLE `guestbook` (
  `comment_id` smallint(5) UNSIGNED NOT NULL,
  `comment` varchar(300) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guestbook`
--

INSERT INTO `guestbook` (`comment_id`, `comment`, `name`) VALUES
(1, 'This is a test comment.', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(6) NOT NULL,
  `first_name` varchar(15) DEFAULT NULL,
  `last_name` varchar(15) DEFAULT NULL,
  `user` varchar(15) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `avatar` varchar(70) DEFAULT NULL,
  `last_login` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `failed_login` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `user`, `password`, `avatar`, `last_login`, `failed_login`) VALUES
(1, 'admin', 'admin', 'admin', '5f4dcc3b5aa765d61d8327deb882cf99', '/hackable/users/admin.jpg', '2024-12-02 08:00:42', 0),
(2, 'Gordon', 'Brown', 'gordonb', 'e99a18c428cb38d5f260853678922e03', '/hackable/users/gordonb.jpg', '2024-11-24 08:15:07', 0),
(3, 'Hack', 'Me', '1337', '8d3533d75ae2c3966d7e0d4fcc69216b', '/hackable/users/1337.jpg', '2024-11-24 08:15:07', 0),
(4, 'Pablo', 'Picasso', 'pablo', '0d107d09f5bbe40cade3de5c71e9e9b7', '/hackable/users/pablo.jpg', '2024-11-24 08:15:07', 0),
(5, 'Bob', 'Smith', 'smithy', '5f4dcc3b5aa765d61d8327deb882cf99', '/hackable/users/smithy.jpg', '2024-11-24 08:15:07', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `guestbook`
--
ALTER TABLE `guestbook`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `guestbook`
--
ALTER TABLE `guestbook`
  MODIFY `comment_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Database: `g563`
--
CREATE DATABASE IF NOT EXISTS `g563` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `g563`;

-- --------------------------------------------------------

--
-- Table structure for table `iris`
--

CREATE TABLE `iris` (
  `Id` int(3) DEFAULT NULL,
  `SepalLengthCm` decimal(2,1) DEFAULT NULL,
  `SepalWidthCm` decimal(2,1) DEFAULT NULL,
  `PetalLengthCm` decimal(2,1) DEFAULT NULL,
  `PetalWidthCm` decimal(2,1) DEFAULT NULL,
  `Species` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `iris`
--

INSERT INTO `iris` (`Id`, `SepalLengthCm`, `SepalWidthCm`, `PetalLengthCm`, `PetalWidthCm`, `Species`) VALUES
(1, 5.1, 3.5, 1.4, 0.2, 'Iris-setosa'),
(2, 4.9, 3.0, 1.4, 0.2, 'Iris-setosa'),
(3, 4.7, 3.2, 1.3, 0.2, 'Iris-setosa'),
(4, 4.6, 3.1, 1.5, 0.2, 'Iris-setosa'),
(5, 5.0, 3.6, 1.4, 0.2, 'Iris-setosa'),
(6, 5.4, 3.9, 1.7, 0.4, 'Iris-setosa'),
(7, 4.6, 3.4, 1.4, 0.3, 'Iris-setosa'),
(8, 5.0, 3.4, 1.5, 0.2, 'Iris-setosa'),
(9, 4.4, 2.9, 1.4, 0.2, 'Iris-setosa'),
(10, 4.9, 3.1, 1.5, 0.1, 'Iris-setosa'),
(11, 5.4, 3.7, 1.5, 0.2, 'Iris-setosa'),
(12, 4.8, 3.4, 1.6, 0.2, 'Iris-setosa'),
(13, 4.8, 3.0, 1.4, 0.1, 'Iris-setosa'),
(14, 4.3, 3.0, 1.1, 0.1, 'Iris-setosa'),
(15, 5.8, 4.0, 1.2, 0.2, 'Iris-setosa'),
(16, 5.7, 4.4, 1.5, 0.4, 'Iris-setosa'),
(17, 5.4, 3.9, 1.3, 0.4, 'Iris-setosa'),
(18, 5.1, 3.5, 1.4, 0.3, 'Iris-setosa'),
(19, 5.7, 3.8, 1.7, 0.3, 'Iris-setosa'),
(20, 5.1, 3.8, 1.5, 0.3, 'Iris-setosa'),
(21, 5.4, 3.4, 1.7, 0.2, 'Iris-setosa'),
(22, 5.1, 3.7, 1.5, 0.4, 'Iris-setosa'),
(23, 4.6, 3.6, 1.0, 0.2, 'Iris-setosa'),
(24, 5.1, 3.3, 1.7, 0.5, 'Iris-setosa'),
(25, 4.8, 3.4, 1.9, 0.2, 'Iris-setosa'),
(26, 5.0, 3.0, 1.6, 0.2, 'Iris-setosa'),
(27, 5.0, 3.4, 1.6, 0.4, 'Iris-setosa'),
(28, 5.2, 3.5, 1.5, 0.2, 'Iris-setosa'),
(29, 5.2, 3.4, 1.4, 0.2, 'Iris-setosa'),
(30, 4.7, 3.2, 1.6, 0.2, 'Iris-setosa'),
(31, 4.8, 3.1, 1.6, 0.2, 'Iris-setosa'),
(32, 5.4, 3.4, 1.5, 0.4, 'Iris-setosa'),
(33, 5.2, 4.1, 1.5, 0.1, 'Iris-setosa'),
(34, 5.5, 4.2, 1.4, 0.2, 'Iris-setosa'),
(35, 4.9, 3.1, 1.5, 0.1, 'Iris-setosa'),
(36, 5.0, 3.2, 1.2, 0.2, 'Iris-setosa'),
(37, 5.5, 3.5, 1.3, 0.2, 'Iris-setosa'),
(38, 4.9, 3.1, 1.5, 0.1, 'Iris-setosa'),
(39, 4.4, 3.0, 1.3, 0.2, 'Iris-setosa'),
(40, 5.1, 3.4, 1.5, 0.2, 'Iris-setosa'),
(41, 5.0, 3.5, 1.3, 0.3, 'Iris-setosa'),
(42, 4.5, 2.3, 1.3, 0.3, 'Iris-setosa'),
(43, 4.4, 3.2, 1.3, 0.2, 'Iris-setosa'),
(44, 5.0, 3.5, 1.6, 0.6, 'Iris-setosa'),
(45, 5.1, 3.8, 1.9, 0.4, 'Iris-setosa'),
(46, 4.8, 3.0, 1.4, 0.3, 'Iris-setosa'),
(47, 5.1, 3.8, 1.6, 0.2, 'Iris-setosa'),
(48, 4.6, 3.2, 1.4, 0.2, 'Iris-setosa'),
(49, 5.3, 3.7, 1.5, 0.2, 'Iris-setosa'),
(50, 5.0, 3.3, 1.4, 0.2, 'Iris-setosa'),
(51, 7.0, 3.2, 4.7, 1.4, 'Iris-versicolor'),
(52, 6.4, 3.2, 4.5, 1.5, 'Iris-versicolor'),
(53, 6.9, 3.1, 4.9, 1.5, 'Iris-versicolor'),
(54, 5.5, 2.3, 4.0, 1.3, 'Iris-versicolor'),
(55, 6.5, 2.8, 4.6, 1.5, 'Iris-versicolor'),
(56, 5.7, 2.8, 4.5, 1.3, 'Iris-versicolor'),
(57, 6.3, 3.3, 4.7, 1.6, 'Iris-versicolor'),
(58, 4.9, 2.4, 3.3, 1.0, 'Iris-versicolor'),
(59, 6.6, 2.9, 4.6, 1.3, 'Iris-versicolor'),
(60, 5.2, 2.7, 3.9, 1.4, 'Iris-versicolor'),
(61, 5.0, 2.0, 3.5, 1.0, 'Iris-versicolor'),
(62, 5.9, 3.0, 4.2, 1.5, 'Iris-versicolor'),
(63, 6.0, 2.2, 4.0, 1.0, 'Iris-versicolor'),
(64, 6.1, 2.9, 4.7, 1.4, 'Iris-versicolor'),
(65, 5.6, 2.9, 3.6, 1.3, 'Iris-versicolor'),
(66, 6.7, 3.1, 4.4, 1.4, 'Iris-versicolor'),
(67, 5.6, 3.0, 4.5, 1.5, 'Iris-versicolor'),
(68, 5.8, 2.7, 4.1, 1.0, 'Iris-versicolor'),
(69, 6.2, 2.2, 4.5, 1.5, 'Iris-versicolor'),
(70, 5.6, 2.5, 3.9, 1.1, 'Iris-versicolor'),
(71, 5.9, 3.2, 4.8, 1.8, 'Iris-versicolor'),
(72, 6.1, 2.8, 4.0, 1.3, 'Iris-versicolor'),
(73, 6.3, 2.5, 4.9, 1.5, 'Iris-versicolor'),
(74, 6.1, 2.8, 4.7, 1.2, 'Iris-versicolor'),
(75, 6.4, 2.9, 4.3, 1.3, 'Iris-versicolor'),
(76, 6.6, 3.0, 4.4, 1.4, 'Iris-versicolor'),
(77, 6.8, 2.8, 4.8, 1.4, 'Iris-versicolor'),
(78, 6.7, 3.0, 5.0, 1.7, 'Iris-versicolor'),
(79, 6.0, 2.9, 4.5, 1.5, 'Iris-versicolor'),
(80, 5.7, 2.6, 3.5, 1.0, 'Iris-versicolor'),
(81, 5.5, 2.4, 3.8, 1.1, 'Iris-versicolor'),
(82, 5.5, 2.4, 3.7, 1.0, 'Iris-versicolor'),
(83, 5.8, 2.7, 3.9, 1.2, 'Iris-versicolor'),
(84, 6.0, 2.7, 5.1, 1.6, 'Iris-versicolor'),
(85, 5.4, 3.0, 4.5, 1.5, 'Iris-versicolor'),
(86, 6.0, 3.4, 4.5, 1.6, 'Iris-versicolor'),
(87, 6.7, 3.1, 4.7, 1.5, 'Iris-versicolor'),
(88, 6.3, 2.3, 4.4, 1.3, 'Iris-versicolor'),
(89, 5.6, 3.0, 4.1, 1.3, 'Iris-versicolor'),
(90, 5.5, 2.5, 4.0, 1.3, 'Iris-versicolor'),
(91, 5.5, 2.6, 4.4, 1.2, 'Iris-versicolor'),
(92, 6.1, 3.0, 4.6, 1.4, 'Iris-versicolor'),
(93, 5.8, 2.6, 4.0, 1.2, 'Iris-versicolor'),
(94, 5.0, 2.3, 3.3, 1.0, 'Iris-versicolor'),
(95, 5.6, 2.7, 4.2, 1.3, 'Iris-versicolor'),
(96, 5.7, 3.0, 4.2, 1.2, 'Iris-versicolor'),
(97, 5.7, 2.9, 4.2, 1.3, 'Iris-versicolor'),
(98, 6.2, 2.9, 4.3, 1.3, 'Iris-versicolor'),
(99, 5.1, 2.5, 3.0, 1.1, 'Iris-versicolor'),
(100, 5.7, 2.8, 4.1, 1.3, 'Iris-versicolor'),
(101, 6.3, 3.3, 6.0, 2.5, 'Iris-virginica'),
(102, 5.8, 2.7, 5.1, 1.9, 'Iris-virginica'),
(103, 7.1, 3.0, 5.9, 2.1, 'Iris-virginica'),
(104, 6.3, 2.9, 5.6, 1.8, 'Iris-virginica'),
(105, 6.5, 3.0, 5.8, 2.2, 'Iris-virginica'),
(106, 7.6, 3.0, 6.6, 2.1, 'Iris-virginica'),
(107, 4.9, 2.5, 4.5, 1.7, 'Iris-virginica'),
(108, 7.3, 2.9, 6.3, 1.8, 'Iris-virginica'),
(109, 6.7, 2.5, 5.8, 1.8, 'Iris-virginica'),
(110, 7.2, 3.6, 6.1, 2.5, 'Iris-virginica'),
(111, 6.5, 3.2, 5.1, 2.0, 'Iris-virginica'),
(112, 6.4, 2.7, 5.3, 1.9, 'Iris-virginica'),
(113, 6.8, 3.0, 5.5, 2.1, 'Iris-virginica'),
(114, 5.7, 2.5, 5.0, 2.0, 'Iris-virginica'),
(115, 5.8, 2.8, 5.1, 2.4, 'Iris-virginica'),
(116, 6.4, 3.2, 5.3, 2.3, 'Iris-virginica'),
(117, 6.5, 3.0, 5.5, 1.8, 'Iris-virginica'),
(118, 7.7, 3.8, 6.7, 2.2, 'Iris-virginica'),
(119, 7.7, 2.6, 6.9, 2.3, 'Iris-virginica'),
(120, 6.0, 2.2, 5.0, 1.5, 'Iris-virginica'),
(121, 6.9, 3.2, 5.7, 2.3, 'Iris-virginica'),
(122, 5.6, 2.8, 4.9, 2.0, 'Iris-virginica'),
(123, 7.7, 2.8, 6.7, 2.0, 'Iris-virginica'),
(124, 6.3, 2.7, 4.9, 1.8, 'Iris-virginica'),
(125, 6.7, 3.3, 5.7, 2.1, 'Iris-virginica'),
(126, 7.2, 3.2, 6.0, 1.8, 'Iris-virginica'),
(127, 6.2, 2.8, 4.8, 1.8, 'Iris-virginica'),
(128, 6.1, 3.0, 4.9, 1.8, 'Iris-virginica'),
(129, 6.4, 2.8, 5.6, 2.1, 'Iris-virginica'),
(130, 7.2, 3.0, 5.8, 1.6, 'Iris-virginica'),
(131, 7.4, 2.8, 6.1, 1.9, 'Iris-virginica'),
(132, 7.9, 3.8, 6.4, 2.0, 'Iris-virginica'),
(133, 6.4, 2.8, 5.6, 2.2, 'Iris-virginica'),
(134, 6.3, 2.8, 5.1, 1.5, 'Iris-virginica'),
(135, 6.1, 2.6, 5.6, 1.4, 'Iris-virginica'),
(136, 7.7, 3.0, 6.1, 2.3, 'Iris-virginica'),
(137, 6.3, 3.4, 5.6, 2.4, 'Iris-virginica'),
(138, 6.4, 3.1, 5.5, 1.8, 'Iris-virginica'),
(139, 6.0, 3.0, 4.8, 1.8, 'Iris-virginica'),
(140, 6.9, 3.1, 5.4, 2.1, 'Iris-virginica'),
(141, 6.7, 3.1, 5.6, 2.4, 'Iris-virginica'),
(142, 6.9, 3.1, 5.1, 2.3, 'Iris-virginica'),
(143, 5.8, 2.7, 5.1, 1.9, 'Iris-virginica'),
(144, 6.8, 3.2, 5.9, 2.3, 'Iris-virginica'),
(145, 6.7, 3.3, 5.7, 2.5, 'Iris-virginica'),
(146, 6.7, 3.0, 5.2, 2.3, 'Iris-virginica'),
(147, 6.3, 2.5, 5.0, 1.9, 'Iris-virginica'),
(148, 6.5, 3.0, 5.2, 2.0, 'Iris-virginica'),
(149, 6.2, 3.4, 5.4, 2.3, 'Iris-virginica'),
(150, 5.9, 3.0, 5.1, 1.8, 'Iris-virginica');
--
-- Database: `heroverse`
--
CREATE DATABASE IF NOT EXISTS `heroverse` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `heroverse`;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `content` text NOT NULL,
  `status` enum('visible','hidden') DEFAULT 'visible',
  `moderated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `event_id`, `content`, `status`, `moderated_by`, `created_at`) VALUES
(1, 1, 15, 'Hii guys', 'visible', NULL, '2024-12-01 02:30:58'),
(2, 2, 15, 'HEY GEYS', 'visible', NULL, '2024-12-01 02:30:58'),
(3, 1, 15, 'dada', 'visible', NULL, '2024-12-01 04:47:03'),
(4, 1, 15, 'kakak', 'visible', NULL, '2024-12-01 04:47:24'),
(5, 1, 15, 'dadad', 'visible', NULL, '2024-12-01 04:47:29'),
(6, 1, 15, 'ffffa', 'visible', NULL, '2024-12-01 04:47:32'),
(7, 1, 15, 'dada', 'visible', NULL, '2024-12-01 04:47:55'),
(8, 1, 15, 'dadaka\n\nadada', 'visible', NULL, '2024-12-01 04:48:34'),
(9, 1, 15, 'ddddaaa', 'visible', NULL, '2024-12-01 04:54:02'),
(10, 1, 15, 'ddddaaa', 'visible', 1, '2024-12-01 04:54:25'),
(11, 1, 15, 'dada', 'visible', NULL, '2024-12-01 04:55:01'),
(12, 1, 15, 'dada', 'visible', NULL, '2024-12-01 04:55:18'),
(13, 1, 15, 'dada', 'visible', NULL, '2024-12-01 04:55:58'),
(14, 1, 15, 'dada', 'visible', NULL, '2024-12-01 04:56:31'),
(15, 1, 15, 'vavava lala', 'visible', 1, '2024-12-01 04:56:47'),
(16, 1, 15, 'adad', 'visible', NULL, '2024-12-01 04:58:51'),
(17, 1, 15, 'adad', 'visible', 1, '2024-12-01 04:59:20'),
(18, 1, 15, 'wdadawd1', 'visible', NULL, '2024-12-01 04:59:24'),
(19, 1, 15, 'adasda\nadwadwad', 'visible', NULL, '2024-12-01 04:59:29'),
(20, 1, 15, 'vavava', 'visible', NULL, '2024-12-01 06:09:56'),
(21, 1, 15, '💎♟  Ⓒ𝓸ᵒ𝓁 𝔱є𝕩𝐓  💞🐍', 'visible', 1, '2024-12-01 06:12:19'),
(22, 1, 15, '▀▄▀▄▀▄🄲🄾🄾🄻 🅃🄴🅇🅃▀▄▀▄▀▄', 'visible', 1, '2024-12-01 06:12:53'),
(23, 1, 15, 'gaga', 'visible', NULL, '2024-12-01 07:34:56'),
(24, 1, 15, 'gagagag', 'visible', NULL, '2024-12-01 07:47:03'),
(25, 1, 15, 'ddda', 'visible', NULL, '2024-12-01 07:47:05'),
(26, 1, 15, 'fafafa3333', 'hidden', 1, '2024-12-01 07:47:11'),
(27, 1, 15, 'fafafafafa', 'visible', 1, '2024-12-01 07:47:14'),
(28, 1, 15, 'dadadadada333adada', 'visible', 1, '2024-12-01 07:48:29'),
(29, 2, 17, 'dada', 'visible', NULL, '2024-12-01 07:50:02'),
(30, 2, 17, 'adwada', 'visible', NULL, '2024-12-01 07:50:18'),
(31, 2, 17, 'vava', 'visible', NULL, '2024-12-01 07:50:20'),
(32, 2, 17, 'vava\nava', 'visible', NULL, '2024-12-01 07:50:23'),
(33, 2, 17, 'vavav', 'visible', NULL, '2024-12-01 07:50:26'),
(34, 2, 17, 'avav', 'visible', NULL, '2024-12-01 07:50:28'),
(35, 1, 15, 'cuteee', 'visible', 1, '2024-12-01 09:23:14'),
(36, 2, 15, 'vavava vo mat may ban', 'visible', 1, '2024-12-01 11:07:35'),
(37, 1, 17, 'kaka', 'hidden', 1, '2024-12-01 14:09:21'),
(38, 1, 18, 'hello garl\n\n\n\n\n\n\n\n\n\nkekeke', 'hidden', 1, '2024-12-01 14:23:05'),
(39, 1, 22, 'binh luan lai\n', 'visible', 1, '2024-12-04 15:27:30'),
(40, 1, 22, 'haha', 'hidden', 1, '2024-12-04 15:27:33'),
(41, 1, 22, 'aaaaaaaaa', 'visible', NULL, '2024-12-04 15:27:35'),
(42, 1, 22, 'test', 'visible', NULL, '2024-12-04 15:27:38'),
(43, 1, 22, 'like', 'visible', NULL, '2024-12-04 15:27:40'),
(44, 1, 22, 'up', 'visible', NULL, '2024-12-04 15:27:43'),
(45, 1, 22, 'up + 2\n', 'visible', NULL, '2024-12-04 15:27:47'),
(46, 5, 23, 'binh luan moi', 'visible', NULL, '2024-12-05 07:40:12'),
(47, 5, 23, '1', 'visible', NULL, '2024-12-05 07:40:16'),
(48, 5, 23, '2', 'visible', NULL, '2024-12-05 07:40:19'),
(49, 5, 23, '33', 'hidden', 1, '2024-12-05 07:40:23'),
(50, 5, 23, '4', 'visible', NULL, '2024-12-05 07:40:26'),
(51, 5, 23, '5', 'visible', NULL, '2024-12-05 07:40:28'),
(52, 6, 24, '12345', 'hidden', 1, '2024-12-05 07:58:59'),
(53, 6, 24, '2', 'visible', NULL, '2024-12-05 07:59:02'),
(54, 6, 24, '3', 'visible', NULL, '2024-12-05 07:59:04'),
(55, 6, 24, '4', 'visible', NULL, '2024-12-05 07:59:07'),
(56, 6, 24, '5', 'visible', NULL, '2024-12-05 07:59:09'),
(57, 6, 24, '6', 'visible', NULL, '2024-12-05 07:59:12');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `start_time`, `end_time`, `location`, `image`, `created_by`, `created_at`, `updated_at`) VALUES
(14, '12312', 'aaa', '2024-11-30 10:15:00', '2024-12-01 10:15:00', 'Vietnam', 'profile_674c6ef1de1129.88137986.png', 'zarockmana', '2024-11-30 10:19:46', '2024-12-01 14:13:05'),
(15, 'Event', 'Welcome', '2024-11-30 10:19:00', '2024-12-01 10:19:00', 'USA', 'profile_674b2c0595b5b2.90790467.PNG', 'zarockmana', '2024-11-30 10:20:09', '2024-12-05 01:26:46'),
(17, 'Brand new map', 'Expanse your adventure on this brand new map!', '2024-11-30 10:19:00', '2024-12-01 10:19:00', 'USA', 'profile_674c6efbb6a3a0.39963805.jpg', 'zarockmana', '2024-11-30 10:34:57', '2024-12-05 01:27:17'),
(18, 'the New Hero: Undying Fury', 'The Nightmare War begins, bringing forth chaos and challenges like never before. Brace yourself as heroes rise to battle the darkness and restore peace to the realm.', '2024-12-01 13:31:00', '2024-12-02 13:31:00', 'Vietnam', 'profile_674c65d1a914d0.36558207.png', 'zarockmana', '2024-12-01 13:34:09', '2024-12-01 13:34:09'),
(19, 'New Private Campaigns Unveiled', 'The Nightmare War begins, bringing forth chaos and challenges like never before. Brace yourself as heroes rise to battle the darkness and restore peace to the realm.', '2024-12-01 13:34:00', '2024-12-02 13:34:00', 'USA', 'profile_674c65f0c232c8.73473598.png', 'zarockmana', '2024-12-01 13:34:40', '2024-12-01 13:34:40'),
(20, 'Join the Squad! - Become a part of us', 'Submit your CV and take the first step toward joining our dynamic and passionate team. We are always looking for talented individuals who are ready to collaborate, innovate, and grow with us!', '2024-12-01 13:34:00', '2024-12-02 13:34:00', 'USA', 'profile_674c697f6776f5.15585112.jpg', 'zarockmana', '2024-12-01 13:49:51', '2024-12-01 13:49:51'),
(21, 'Nightmare Wars Begin', 'The Nightmare War begins, bringing forth chaos and challenges like never before. Brace yourself as heroes rise to battle the darkness and restore peace to the realm.', '2024-12-01 13:49:00', '2024-12-02 13:49:00', 'Vietnam', 'profile_674c699c945644.14850169.jpg', 'zarockmana', '2024-12-01 13:50:20', '2024-12-01 13:50:20'),
(22, 'Su kien moi', 'Join', '2024-12-04 15:26:00', '2024-12-19 15:26:00', 'USA', 'profile_675074cabc8733.90046419.png', 'zarockmana', '2024-12-04 15:27:06', '2024-12-04 15:27:06'),
(23, 'Brand new event', 'Su kien moi', '2024-12-05 07:38:00', '2025-01-01 07:38:00', 'Vietnam', 'profile_675158c9704c50.87926533.png', 'zarockmana', '2024-12-05 07:39:53', '2024-12-05 07:39:53'),
(24, 'New event', 'Brand new eevent', '2024-12-05 07:58:00', '2024-12-19 07:58:00', 'Vietnam', 'profile_67515d2cd53aa3.02426723.jpg', 'zarockmana', '2024-12-05 07:58:36', '2024-12-05 07:58:36');

-- --------------------------------------------------------

--
-- Table structure for table `heroes`
--

CREATE TABLE `heroes` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `type` enum('dark','light') NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `heroes`
--

INSERT INTO `heroes` (`id`, `name`, `price`, `type`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Dragneel', 3.00, 'light', 'public/uploads/heroes/hero_6750fa7402a0f.png', '2024-12-05 00:57:24', '2024-12-05 07:47:02'),
(3, 'Fine', 5.00, 'dark', 'public/uploads/heroes/hero_67510107b0824.png', '2024-12-05 01:25:27', '2024-12-05 01:25:27'),
(4, 'Hero', 10.00, 'dark', 'public/uploads/heroes/hero_67515db0bc7cd.png', '2024-12-05 08:00:48', '2024-12-05 08:00:48');

-- --------------------------------------------------------

--
-- Table structure for table `map`
--

CREATE TABLE `map` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `map`
--

INSERT INTO `map` (`id`, `name`, `image`, `created_at`, `updated_at`) VALUES
(1, 'AI_NongNghiep', 'public/uploads/maps/map_6750fa63d17c6.png', '2024-12-05 00:57:07', '2024-12-05 00:57:07'),
(2, 'AI_NhanDien', 'public/uploads/maps/map_6751022c0391a.jpg', '2024-12-05 01:25:00', '2024-12-05 01:30:20'),
(3, 'AI_NhanDien', 'public/uploads/maps/map_675100f0d9f41.png', '2024-12-05 01:25:04', '2024-12-05 01:25:04');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `recharge_history`
--

CREATE TABLE `recharge_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `orderId` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `amount` decimal(10,2) NOT NULL,
  `coins` int(11) NOT NULL,
  `payment_method` enum('momo','zalopay','code') NOT NULL,
  `status` enum('pending','completed','failed') DEFAULT 'pending',
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recharge_history`
--

INSERT INTO `recharge_history` (`id`, `user_id`, `orderId`, `date`, `amount`, `coins`, `payment_method`, `status`, `description`) VALUES
(1, 2, 'username_2000301', '2024-11-27 05:19:28', 20000.00, 20, 'momo', 'completed', 'Cong 1 ten lua'),
(2, 2, 'username_2000302', '2024-11-27 05:19:28', 50000.00, 50, 'zalopay', 'pending', 'Cong 1 nui ten lua'),
(3, 2, 'username_2000303', '2024-11-27 05:19:28', 100000.00, 100, 'code', 'failed', 'Rat nhieu ten lua'),
(7, 2, 'zarockman_1732700695', '2024-11-27 09:47:33', 20000.00, 20, 'momo', 'completed', 'Cong mot ten lua'),
(10, 2, 'zarockman_1732701748', '2024-11-27 10:06:22', 254140.00, 0, 'momo', 'completed', 'Subscription Plan: Pro'),
(11, 2, 'zarockman_1732702023', '2024-11-27 10:07:46', 100000.00, 100, 'momo', 'completed', 'Cong mot ten lua'),
(12, 2, 'zarockman_1732702160', '2024-11-27 10:09:57', 50000.00, 50, 'momo', 'completed', 'Cong mot ten lua'),
(13, 2, 'zarockman_1732702228', '2024-11-27 10:11:07', 508280.00, 0, 'momo', 'completed', 'Subscription Plan: Premium'),
(15, 2, 'zarockman_1732703079', '2024-11-27 10:25:29', 20000.00, 20, 'momo', 'completed', 'Cong mot ten lua'),
(16, 2, 'zarockman_1732703256', '2024-11-27 10:28:16', 254140.00, 0, 'momo', 'completed', 'Subscription Plan: Pro'),
(17, 2, 'zarockman_1732703606', '2024-11-27 10:34:06', 254140.00, 0, 'momo', 'completed', 'Subscription Plan: Pro'),
(24, 2, 'zarockman_1732703676', '2024-11-27 10:35:13', 508280.00, 0, 'momo', 'completed', 'Subscription Plan: Premium'),
(35, 2, '241128_zarockman_1732787761', '2024-11-28 09:56:01', 20000.00, 0, 'zalopay', 'pending', 'Cong mot ten lua'),
(36, 2, '241128_zarockman_1732790984', '2024-11-28 10:49:44', 20000.00, 0, 'zalopay', 'completed', 'Cong mot ten lua'),
(37, 2, '241128_zarockman_1732791155', '2024-11-28 10:52:35', 254140.00, 0, 'zalopay', 'completed', 'Subscription Plan: Pro'),
(41, 2, 'zarockman_1732792048', '2024-11-28 11:08:20', 508280.00, 0, 'momo', 'completed', 'Subscription Plan: Premium'),
(45, 2, '241128_zarockman_1732792419', '2024-11-28 11:13:39', 254140.00, 0, 'zalopay', 'completed', 'Subscription Plan: Pro'),
(49, 2, '241128_zarockman_1732792862', '2024-11-28 11:21:02', 508280.00, 0, 'zalopay', 'completed', 'Subscription Plan: Premium'),
(51, 2, '241128_zarockman_1732794550', '2024-11-28 11:49:10', 508280.00, 0, 'zalopay', 'completed', 'Subscription Plan: Premium'),
(52, 2, '241128_zarockman_1732797767', '2024-11-28 12:42:47', 254140.00, 0, 'zalopay', 'completed', 'Subscription Plan: Pro'),
(53, 2, 'zarockman_1732797884', '2024-11-28 12:45:33', 100000.00, 100, 'momo', 'completed', 'Cong mot ten lua'),
(55, 2, 'zarockman_1732797991', '2024-11-28 12:47:17', 508280.00, 0, 'momo', 'completed', 'Subscription Plan: Premium'),
(62, 2, 'zarockman_1732798503', '2024-11-28 12:58:06', 254140.00, 0, 'momo', 'completed', 'Subscription Plan: Pro'),
(75, 2, 'zarockman_1732799824', '2024-11-28 13:37:22', 50000.00, 50, 'momo', 'completed', 'Cong mot ten lua'),
(77, 2, '241128_zarockman_1732801506', '2024-11-28 13:45:06', 10000.00, 0, 'zalopay', 'completed', 'Cong mot ten lua'),
(78, 2, '241128_zarockman_1732801749', '2024-11-28 13:49:09', 100000.00, 100, 'zalopay', 'completed', 'Cong mot ten lua'),
(79, 2, '241128_zarockman_1732801846', '2024-11-28 13:50:46', 254140.00, 0, 'zalopay', 'completed', 'Subscription Plan: Pro'),
(89, 2, 'zarockman_1732809299', '2024-11-28 15:56:02', 20000.00, 20, 'momo', 'completed', 'Cong mot ten lua'),
(91, 2, '241128_zarockman_1732809376', '2024-11-28 15:56:16', 10000.00, 10, 'zalopay', 'completed', 'Cong mot ten lua'),
(137, 2, '241201_zarockman_1733064075', '2024-12-01 14:41:15', 254140.00, 0, 'zalopay', 'failed', 'Subscription Plan: Pro'),
(138, 2, '241201_zarockman_1733064626', '2024-12-01 14:50:26', 254140.00, 0, 'zalopay', 'failed', 'Subscription Plan: Pro'),
(139, 2, '241201_zarockman_1733064651', '2024-12-01 14:50:51', 254140.00, 0, 'zalopay', 'completed', 'Subscription Plan: Pro'),
(170, 2, '241202_zarockman_1733150690', '2024-12-02 14:44:50', 508280.00, 0, 'zalopay', 'failed', 'Subscription Plan: Premium'),
(189, 3, '241203_zarockman1_1733214042', '2024-12-03 08:20:42', 508280.00, 0, 'zalopay', 'failed', 'Subscription Plan: Premium'),
(193, 3, '241203_zarockman1_1733214383', '2024-12-03 08:26:23', 50000.00, 50, 'zalopay', 'failed', 'Cong mot ten lua'),
(194, 3, '241203_zarockman1_1733214662', '2024-12-03 08:31:02', 50000.00, 50, 'zalopay', 'failed', 'Cong mot ten lua'),
(195, 3, '241203_zarockman1_1733214690', '2024-12-03 08:31:30', 254140.00, 0, 'zalopay', 'completed', 'Subscription Plan: Pro'),
(221, 4, 'zarockman2_1733325743', '2024-12-04 15:24:18', 100000.00, 100, 'momo', 'completed', 'Cong mot ten lua'),
(222, 4, '241204_zarockman2_1733325872', '2024-12-04 15:24:32', 508280.00, 0, 'zalopay', 'completed', 'Subscription Plan: Premium'),
(238, 5, '241205_rockman_1733384048', '2024-12-05 07:34:08', 50000.00, 50, 'zalopay', 'completed', 'Cong mot ten lua'),
(242, 6, '241205_rockman1_1733385278', '2024-12-05 07:54:38', 20000.00, 20, 'zalopay', 'completed', 'Cong mot ten lua'),
(243, 6, '241205_rockman1_1733385402', '2024-12-05 07:56:42', 508280.00, 0, 'zalopay', 'completed', 'Subscription Plan: Premium');

-- --------------------------------------------------------

--
-- Table structure for table `support`
--

CREATE TABLE `support` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(200) NOT NULL,
  `question` text NOT NULL,
  `is_processed` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `support`
--

INSERT INTO `support` (`id`, `user_id`, `title`, `question`, `is_processed`, `created_at`, `updated_at`) VALUES
(1, 2, 'Hỗ trợ tài khoản', 'Tôi không thể đăng nhập vào tài khoản của mình. Xin hãy giúp đỡ!', 1, '2024-12-05 00:56:45', '2024-12-05 00:56:45'),
(2, NULL, 'Hỗ trợ nạp tiền', 'Tôi đã nạp tiền nhưng không nhận được Coin. Xin hãy giúp đỡ!', 0, '2024-12-05 00:56:45', '2024-12-05 07:42:49'),
(3, 1, 'Hỗ trợ dịch vụ', 'Tôi muốn nâng cấp tài khoản VIP. Xin hãy giúp đỡ!', 1, '2024-12-05 00:56:45', '2024-12-05 00:56:45'),
(4, 1, 'Hello admin', 'HELLO', 1, '2024-12-05 07:43:34', '2024-12-05 07:44:29');

-- --------------------------------------------------------

--
-- Table structure for table `usage_history`
--

CREATE TABLE `usage_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `coins_used` int(11) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usage_history`
--

INSERT INTO `usage_history` (`id`, `user_id`, `date`, `coins_used`, `description`) VALUES
(1, 2, '0000-00-00 00:00:00', 10, 'Mua tướng Dragneel'),
(2, 2, '0000-00-00 00:00:00', 30, 'Nâng cấp tài khoản VIP'),
(3, 2, '0000-00-00 00:00:00', 5, 'Sử dụng dịch vụ hỗ trợ');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','member') DEFAULT 'member',
  `subscription_type` enum('basic','pro','premium') DEFAULT 'basic',
  `balance` decimal(10,2) DEFAULT 0.00,
  `two_fa_enabled` tinyint(1) DEFAULT 0,
  `profile_pic` varchar(255) DEFAULT NULL,
  `failed_login` int(11) DEFAULT 0,
  `last_login` timestamp NULL DEFAULT NULL,
  `lockout_time` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `subscription_type`, `balance`, `two_fa_enabled`, `profile_pic`, `failed_login`, `last_login`, `lockout_time`, `created_at`, `updated_at`) VALUES
(1, 'zarockmana', 'minhhiul4112@gmail.com', '$2y$10$6fzIMnFtKUdjBqVCcDi9EOwjb4EC1oOr1bhFwVGDjaFKveyz/4Kf2', 'admin', 'basic', 0.00, 0, 'profile_674dafddd795f1.37242634.pdf', 0, '2024-12-05 07:58:01', NULL, '2024-11-20 11:07:30', '2024-12-05 08:03:09'),
(2, 'zarockman', 'minhhiul42@gmail.com', '$2y$10$wqNd8kOeDMBjRA7m1qQPYOzmk09pB5VD4f05S7y4K3FcxZDJIK5o6', 'member', 'premium', 169.00, 0, 'a0ad035e1e163e2a0fce422522325bf3.png', 0, '2024-12-05 07:26:24', NULL, '2024-11-20 11:07:44', '2024-12-05 07:26:24'),
(3, 'zarockman1', 'minhhiul333@gmail.com', '$2y$10$bIsRKs1.E0XS9HyFPvtf4OaFKJ48YGhdMqUC3u9gzxhLSzHK/uktq', 'member', 'pro', 50.00, 0, NULL, 0, '2024-12-05 07:41:30', NULL, '2024-12-03 08:20:17', '2024-12-05 07:41:30'),
(4, 'zarockman2', 'minhhiul33334@gmail.com', '$2y$10$R2WsNZ3lSarF91wtdXgd0OOsqHjj5EVcf59u/y1/xWcJ8bTbIbX56', 'admin', 'basic', 100.00, 0, 'd836b918c495fba1e338a5f56f73eff0.png', 999, '2024-12-05 00:43:17', NULL, '2024-12-04 15:20:02', '2024-12-05 00:43:17'),
(5, 'rockman', 'minhhiul311@gmail.comm', '$2y$10$IqHbGawfL8kBz4qJPNliUebo10.ZnYynbpoRqABBNvxnz5Xmlzi/S', 'member', 'basic', 50.00, 0, 'cd916d60572556ca71b6f316880a32d0.png', 0, '2024-12-05 07:27:06', NULL, '2024-12-05 07:26:58', '2024-12-05 07:41:48'),
(6, 'rockman1', 'minhhiul0330@gmail.com', '$2y$10$LJA/q4djpOT1eIuN.CgQful8pTzYFYBMFDK1f75MpNq2TPImbxvmG', 'member', 'premium', 17.00, 0, 'd4ad608eca15962c3bd75da31357fb84.png', 0, '2024-12-05 07:52:59', NULL, '2024-12-05 07:52:29', '2024-12-05 08:01:46');

-- --------------------------------------------------------

--
-- Table structure for table `user_heroes`
--

CREATE TABLE `user_heroes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `hero_id` int(11) NOT NULL,
  `date_purchased` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_heroes`
--

INSERT INTO `user_heroes` (`id`, `user_id`, `hero_id`, `date_purchased`) VALUES
(2, 2, 1, '2024-12-05 01:12:45'),
(3, 2, 3, '2024-12-05 01:27:52'),
(4, 6, 1, '2024-12-05 08:01:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `moderated_by` (`moderated_by`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `heroes`
--
ALTER TABLE `heroes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `map`
--
ALTER TABLE `map`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recharge_history`
--
ALTER TABLE `recharge_history`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orderId` (`orderId`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `support`
--
ALTER TABLE `support`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `usage_history`
--
ALTER TABLE `usage_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_heroes`
--
ALTER TABLE `user_heroes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_hero` (`user_id`,`hero_id`),
  ADD KEY `hero_id` (`hero_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `heroes`
--
ALTER TABLE `heroes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `map`
--
ALTER TABLE `map`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `recharge_history`
--
ALTER TABLE `recharge_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=244;

--
-- AUTO_INCREMENT for table `support`
--
ALTER TABLE `support`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `usage_history`
--
ALTER TABLE `usage_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_heroes`
--
ALTER TABLE `user_heroes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_3` FOREIGN KEY (`moderated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`username`) ON DELETE CASCADE;

--
-- Constraints for table `recharge_history`
--
ALTER TABLE `recharge_history`
  ADD CONSTRAINT `recharge_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `support`
--
ALTER TABLE `support`
  ADD CONSTRAINT `support_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `usage_history`
--
ALTER TABLE `usage_history`
  ADD CONSTRAINT `usage_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_heroes`
--
ALTER TABLE `user_heroes`
  ADD CONSTRAINT `user_heroes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_heroes_ibfk_2` FOREIGN KEY (`hero_id`) REFERENCES `heroes` (`id`) ON DELETE CASCADE;
--
-- Database: `mydb`
--
CREATE DATABASE IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `mydb`;

-- --------------------------------------------------------

--
-- Table structure for table `myguests`
--

CREATE TABLE `myguests` (
  `id` int(6) UNSIGNED NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `myguests`
--
ALTER TABLE `myguests`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `myguests`
--
ALTER TABLE `myguests`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Database: `phpmyadmin`
--
CREATE DATABASE IF NOT EXISTS `phpmyadmin` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `phpmyadmin`;

-- --------------------------------------------------------

--
-- Table structure for table `pma__bookmark`
--

CREATE TABLE `pma__bookmark` (
  `id` int(10) UNSIGNED NOT NULL,
  `dbase` varchar(255) NOT NULL DEFAULT '',
  `user` varchar(255) NOT NULL DEFAULT '',
  `label` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `query` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Bookmarks';

-- --------------------------------------------------------

--
-- Table structure for table `pma__central_columns`
--

CREATE TABLE `pma__central_columns` (
  `db_name` varchar(64) NOT NULL,
  `col_name` varchar(64) NOT NULL,
  `col_type` varchar(64) NOT NULL,
  `col_length` text DEFAULT NULL,
  `col_collation` varchar(64) NOT NULL,
  `col_isNull` tinyint(1) NOT NULL,
  `col_extra` varchar(255) DEFAULT '',
  `col_default` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Central list of columns';

-- --------------------------------------------------------

--
-- Table structure for table `pma__column_info`
--

CREATE TABLE `pma__column_info` (
  `id` int(5) UNSIGNED NOT NULL,
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `column_name` varchar(64) NOT NULL DEFAULT '',
  `comment` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `mimetype` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `transformation` varchar(255) NOT NULL DEFAULT '',
  `transformation_options` varchar(255) NOT NULL DEFAULT '',
  `input_transformation` varchar(255) NOT NULL DEFAULT '',
  `input_transformation_options` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Column information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__designer_settings`
--

CREATE TABLE `pma__designer_settings` (
  `username` varchar(64) NOT NULL,
  `settings_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Settings related to Designer';

-- --------------------------------------------------------

--
-- Table structure for table `pma__export_templates`
--

CREATE TABLE `pma__export_templates` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL,
  `export_type` varchar(10) NOT NULL,
  `template_name` varchar(64) NOT NULL,
  `template_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved export templates';

-- --------------------------------------------------------

--
-- Table structure for table `pma__favorite`
--

CREATE TABLE `pma__favorite` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Favorite tables';

-- --------------------------------------------------------

--
-- Table structure for table `pma__history`
--

CREATE TABLE `pma__history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db` varchar(64) NOT NULL DEFAULT '',
  `table` varchar(64) NOT NULL DEFAULT '',
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp(),
  `sqlquery` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='SQL history for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__navigationhiding`
--

CREATE TABLE `pma__navigationhiding` (
  `username` varchar(64) NOT NULL,
  `item_name` varchar(64) NOT NULL,
  `item_type` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Hidden items of navigation tree';

-- --------------------------------------------------------

--
-- Table structure for table `pma__pdf_pages`
--

CREATE TABLE `pma__pdf_pages` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `page_nr` int(10) UNSIGNED NOT NULL,
  `page_descr` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='PDF relation pages for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__recent`
--

CREATE TABLE `pma__recent` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Recently accessed tables';

--
-- Dumping data for table `pma__recent`
--

INSERT INTO `pma__recent` (`username`, `tables`) VALUES
('root', '[{\"db\":\"heroverse\",\"table\":\"users\"},{\"db\":\"heroverse\",\"table\":\"comments\"},{\"db\":\"heroverse\",\"table\":\"events\"},{\"db\":\"heroverse\",\"table\":\"support\"},{\"db\":\"heroverse\",\"table\":\"recharge_history\"},{\"db\":\"heroverse\",\"table\":\"pages\"},{\"db\":\"heroverse\",\"table\":\"map\"},{\"db\":\"heroverse\",\"table\":\"user_heroes\"},{\"db\":\"heroverse\",\"table\":\"heroes\"},{\"db\":\"heroverse\",\"table\":\"news\"}]');

-- --------------------------------------------------------

--
-- Table structure for table `pma__relation`
--

CREATE TABLE `pma__relation` (
  `master_db` varchar(64) NOT NULL DEFAULT '',
  `master_table` varchar(64) NOT NULL DEFAULT '',
  `master_field` varchar(64) NOT NULL DEFAULT '',
  `foreign_db` varchar(64) NOT NULL DEFAULT '',
  `foreign_table` varchar(64) NOT NULL DEFAULT '',
  `foreign_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Relation table';

-- --------------------------------------------------------

--
-- Table structure for table `pma__savedsearches`
--

CREATE TABLE `pma__savedsearches` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `search_name` varchar(64) NOT NULL DEFAULT '',
  `search_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved searches';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_coords`
--

CREATE TABLE `pma__table_coords` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `pdf_page_number` int(11) NOT NULL DEFAULT 0,
  `x` float UNSIGNED NOT NULL DEFAULT 0,
  `y` float UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table coordinates for phpMyAdmin PDF output';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_info`
--

CREATE TABLE `pma__table_info` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `display_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_uiprefs`
--

CREATE TABLE `pma__table_uiprefs` (
  `username` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `prefs` text NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tables'' UI preferences';

-- --------------------------------------------------------

--
-- Table structure for table `pma__tracking`
--

CREATE TABLE `pma__tracking` (
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `version` int(10) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `schema_snapshot` text NOT NULL,
  `schema_sql` text DEFAULT NULL,
  `data_sql` longtext DEFAULT NULL,
  `tracking` set('UPDATE','REPLACE','INSERT','DELETE','TRUNCATE','CREATE DATABASE','ALTER DATABASE','DROP DATABASE','CREATE TABLE','ALTER TABLE','RENAME TABLE','DROP TABLE','CREATE INDEX','DROP INDEX','CREATE VIEW','ALTER VIEW','DROP VIEW') DEFAULT NULL,
  `tracking_active` int(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Database changes tracking for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__userconfig`
--

CREATE TABLE `pma__userconfig` (
  `username` varchar(64) NOT NULL,
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `config_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User preferences storage for phpMyAdmin';

--
-- Dumping data for table `pma__userconfig`
--

INSERT INTO `pma__userconfig` (`username`, `timevalue`, `config_data`) VALUES
('root', '2024-12-05 07:43:05', '{\"Console\\/Mode\":\"collapse\",\"NavigationWidth\":0}');

-- --------------------------------------------------------

--
-- Table structure for table `pma__usergroups`
--

CREATE TABLE `pma__usergroups` (
  `usergroup` varchar(64) NOT NULL,
  `tab` varchar(64) NOT NULL,
  `allowed` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User groups with configured menu items';

-- --------------------------------------------------------

--
-- Table structure for table `pma__users`
--

CREATE TABLE `pma__users` (
  `username` varchar(64) NOT NULL,
  `usergroup` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Users and their assignments to user groups';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pma__central_columns`
--
ALTER TABLE `pma__central_columns`
  ADD PRIMARY KEY (`db_name`,`col_name`);

--
-- Indexes for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `db_name` (`db_name`,`table_name`,`column_name`);

--
-- Indexes for table `pma__designer_settings`
--
ALTER TABLE `pma__designer_settings`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_user_type_template` (`username`,`export_type`,`template_name`);

--
-- Indexes for table `pma__favorite`
--
ALTER TABLE `pma__favorite`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__history`
--
ALTER TABLE `pma__history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`,`db`,`table`,`timevalue`);

--
-- Indexes for table `pma__navigationhiding`
--
ALTER TABLE `pma__navigationhiding`
  ADD PRIMARY KEY (`username`,`item_name`,`item_type`,`db_name`,`table_name`);

--
-- Indexes for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  ADD PRIMARY KEY (`page_nr`),
  ADD KEY `db_name` (`db_name`);

--
-- Indexes for table `pma__recent`
--
ALTER TABLE `pma__recent`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__relation`
--
ALTER TABLE `pma__relation`
  ADD PRIMARY KEY (`master_db`,`master_table`,`master_field`),
  ADD KEY `foreign_field` (`foreign_db`,`foreign_table`);

--
-- Indexes for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_savedsearches_username_dbname` (`username`,`db_name`,`search_name`);

--
-- Indexes for table `pma__table_coords`
--
ALTER TABLE `pma__table_coords`
  ADD PRIMARY KEY (`db_name`,`table_name`,`pdf_page_number`);

--
-- Indexes for table `pma__table_info`
--
ALTER TABLE `pma__table_info`
  ADD PRIMARY KEY (`db_name`,`table_name`);

--
-- Indexes for table `pma__table_uiprefs`
--
ALTER TABLE `pma__table_uiprefs`
  ADD PRIMARY KEY (`username`,`db_name`,`table_name`);

--
-- Indexes for table `pma__tracking`
--
ALTER TABLE `pma__tracking`
  ADD PRIMARY KEY (`db_name`,`table_name`,`version`);

--
-- Indexes for table `pma__userconfig`
--
ALTER TABLE `pma__userconfig`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__usergroups`
--
ALTER TABLE `pma__usergroups`
  ADD PRIMARY KEY (`usergroup`,`tab`,`allowed`);

--
-- Indexes for table `pma__users`
--
ALTER TABLE `pma__users`
  ADD PRIMARY KEY (`username`,`usergroup`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__history`
--
ALTER TABLE `pma__history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  MODIFY `page_nr` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Database: `shop`
--
CREATE DATABASE IF NOT EXISTS `shop` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `shop`;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` double NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`) VALUES
(1, 'Usb Kingston 3.0', 'USB Kingston siêu mỏng  có hình thức nhỏ gọn và không nắp phù hợp với mọi phong cách năng động.', 42000, 'https://m.media-amazon.com/images/I/31UpGSJdmqL._AC_.jpg'),
(2, 'Ổ cứng di động External SSD', 'Dung lượng: 500GB, 1TB, 2TB Chống sốc, chống nước IP55 Thiết kế nhỏ gọn', 3000000, 'https://m.media-amazon.com/images/I/911ujeCkGfL._AC_UY436_FMwebp_QL65_.jpg'),
(3, 'RAM Laptop Samsung 8GB', '', 750000, 'https://m.media-amazon.com/images/I/71cWL5j3FqL._AC_UY436_FMwebp_QL65_.jpg'),
(5, 'hellloo friend', 'aaaaaaaaaaaaa', 100.2, 'https://www.cavaha.com/wp-content/uploads/2024/09/usb-8g.png'),
(6, 'Màn hình Samsung Gaming Odyssey G5', 'Cảm nhận rõ sự kịch tính đến nghẹt thở trong mỗi trận đấu với màn hình cong 1000R lý tưởng\r\nMàn hình Ultra-WQHD (3440x1440) mang đến góc nhìn bao quát toàn cảnh về trận đấu, sắc nét sống động\r\nCông nghệ AMD FreeSync Premium, tần số quét 165Hz sẵn sàng hạ gục mọi đối thủ\r\nPhản xạ nhanh chóng trước mọi tình huống nhờ tốc độ phản hồi 1ms', 7490000, 'https://cdn2.cellphones.com.vn/insecure/rs:fill:358:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/m/a/man-hinh-samsung-gaming-odyssey-g5-lc34g55twwexxv-34-inch.png'),
(7, 'Laptop ASUS ROG Strix G16', 'Máy được trang bị bộ vi xử lý Intel Core i5-13450HX, cung cấp hiệu năng ấn tượng cho cả gaming và các tác vụ đa phương tiện.\r\nMàn hình 16 inch Full HD với tần số quét 165Hz mang lại trải nghiệm hình ảnh mượt mà và sắc nét, đặc biệt phù hợp cho game thủ.\r\nCard đồ họa NVIDIA GeForce RTX 4050 với 6GB VRAM đảm bảo khả năng xử lý đồ họa mạnh mẽ, cho phép chơi các tựa game đòi hỏi cao ở mức cài đặt tốt.\r\nBộ nhớ RAM 8GB kết hợp với ổ cứng SSD 512GB PCIe cho phép đa nhiệm mượt mà và khởi động nhanh chóng các ứng dụng và trò chơi.', 29490000, 'https://cdn2.cellphones.com.vn/insecure/rs:fill:358:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/g/r/group_509_14__1.png'),
(11, 'Laptop MSI Gaming Thin 15 B12UCX-1419VN', 'Vi xử lý Intel Core i5-12450H, RAM 8GB và ổ cứng SSD 512GB PCIe mang đến hiệu suất mượt mà cho các tác vụ hàng ngày, chơi game và chỉnh sửa video cơ bản.\r\nCard đồ họa NVIDIA GeForce RTX 2050 giúp bạn chơi game ở độ phân giải Full HD với mức thiết lập đồ họa trung bình đến cao.\r\nMàn hình 15.6 inch độ phân giải Full HD (1920 x 1080) cho hình ảnh rõ nét, sống động, mang đến trải nghiệm thị giác tuyệt vời.\r\nHệ thống tản nhiệt tiên tiến giúp duy trì nhiệt độ ổn định, đảm bảo hiệu suất hoạt động tối ưu trong thời gian dài.', 15490000, 'https://cdn2.cellphones.com.vn/insecure/rs:fill:358:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/t/e/text_d_i_3__3_3.png'),
(343, 'eewewe', '', 3.3, 'https://dictionary.cambridge.org/vi/images/thumb/ewe_noun_002_12898.jpg?version=6.0.37'),
(1233, 'Newww', 'aa', 123, 'https://m.media-amazon.com/images/I/61tq7VpNRVL._AC_SL1500_.jpg'),
(1235, 'untitled', 'aaa', 1222, 'https://i.pinimg.com/550x/04/5b/98/045b982aa17ca3f7e5abe44e3dbd4e33.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=213214;
--
-- Database: `test`
--
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `test`;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`) VALUES
(1, 'Product 1', 'Description for product 1', 19.99),
(2, 'Product 2', 'Description for product 2', 29.99),
(3, 'Product 3', 'Description for product 3', 39.99),
(4, 'Product 1', 'Description for product 1', 19.99),
(5, 'Product 2', 'Description for product 2', 29.99),
(6, 'Product 3', 'Description for product 3', 39.99),
(7, 'Product 1', 'Description for product 1', 19.99),
(8, 'Product 2', 'Description for product 2', 29.99),
(9, 'Product 3', 'Description for product 3', 39.99),
(10, 'Product 1', 'Description for product 1', 19.99),
(11, 'Product 2', 'Description for product 2', 29.99),
(12, 'Product 3', 'Description for product 3', 39.99),
(13, 'Product 1', 'Description for product 1', 19.99),
(14, 'Product 2', 'Description for product 2', 29.99),
(15, 'Product 3', 'Description for product 3', 39.99);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
