-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 03 يناير 2024 الساعة 05:46
-- إصدار الخادم: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fe9al`
--

-- --------------------------------------------------------

--
-- بنية الجدول `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `accounts`
--

INSERT INTO `accounts` (`id`, `username`, `email`, `password`) VALUES
(11, 'ms', 'm@gmail.com', '$2y$10$Igadg4e5Z6cwM0TCF8mLd.KUclJUCEPnGHm1/9717TYFH.INpjZWK'),
(12, 'm', 'F@gmail.com', '$2y$10$yW1lS6gm3pmS./HBeWY6feSyRbd0aAc9sWMII8bNb.9GRmnYeF3Ri'),
(13, 'y', 'hy@fff.cv', '$2y$10$HC00PstRuRxbdvLjPkeoh.v.E5YKafQKbxXPwgKLCXlj3BWHk5W2.'),
(14, 'mshal', 'mshlaldwas448@gmail.com', '$2y$10$OXC5RbQDkcJrf.AM3a8I8uv7IaWqC.CqPUYBXPnA5AukZH.PSZFH2');

-- --------------------------------------------------------

--
-- بنية الجدول `employees`
--

CREATE TABLE `employees` (
  `employee_id` int(11) NOT NULL,
  `employee_name` varchar(100) NOT NULL,
  `profession_service` varchar(100) NOT NULL,
  `employee_email` varchar(100) NOT NULL,
  `employee_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `employees`
--

INSERT INTO `employees` (`employee_id`, `employee_name`, `profession_service`, `employee_email`, `employee_password`) VALUES
(1, 'اسم الموظف', 'المهنة/الخدمة المقدمة', 'employee@example.com', 'hashed_password'),
(2, 'خالد ', 'مبرمج', 'kald@gmail.com', '$2y$10$JXCLzmUjcq.NJDCb5MYSSuWDVEScrUQ1WHorhCNC0EuuPHKkhNLYm');

-- --------------------------------------------------------

--
-- بنية الجدول `jobrequests`
--

CREATE TABLE `jobrequests` (
  `request_id` int(11) NOT NULL,
  `employee_name` varchar(255) NOT NULL,
  `job_details` text NOT NULL,
  `mobile_number` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `jobrequests`
--

INSERT INTO `jobrequests` (`request_id`, `employee_name`, `job_details`, `mobile_number`) VALUES
(12, 'خالد ', 'للللل', '1234567'),
(13, 'خالد ', 'للللل', '1234567'),
(14, 'خالد ', 'للللل', '1234567'),
(15, 'خالد ', 'ww', '0546992912'),
(16, 'خالد ', 'ww', '0546992912'),
(17, 'خالد ', 'ww', '0546992912'),
(18, 'خالد ', 'ww', '0546992912'),
(19, 'خالد ', 'ww', '0546992912'),
(20, 'خالد ', 'ww', '0546992912'),
(21, '', 'ww', '0546992912'),
(22, '', 'ww', '0546992912'),
(23, 'خالد ', 'ddddd', '0533989033'),
(24, 'خالد ', 'ddddd', '0533989033'),
(25, 'خالد ', 'ddddd', '0533989033'),
(26, 'خالد ', 'ييييييييييييييييييي', '2345678'),
(27, 'خالد ', 'ببببببببببببببببببببببببببببببببببببببببببببببببببببببببببببببببببببببب', '0987665'),
(28, '', 'kkkkkkkkkkkkkkkkkkkkkkkkkkkkk', '8967746574'),
(29, '', 'rrrrrrrrrrrrrrrrrrrrrrrrrr', '6767767666'),
(30, 'خالد ', 'oooooooooooooooooooooooooooooooo', '8967746579');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employee_id`),
  ADD UNIQUE KEY `employee_email` (`employee_email`);

--
-- Indexes for table `jobrequests`
--
ALTER TABLE `jobrequests`
  ADD PRIMARY KEY (`request_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `jobrequests`
--
ALTER TABLE `jobrequests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
