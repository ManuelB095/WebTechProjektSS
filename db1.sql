-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 01, 2020 at 10:47 AM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webtech`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `pid` int(11) NOT NULL,
  `pr_owner` varchar(64) NOT NULL,
  `pr_filename` varchar(128) NOT NULL,
  `pr_exif` varchar(128) DEFAULT NULL,
  `pr_upload_date` timestamp(6) NOT NULL DEFAULT current_timestamp(6),
  `pr_quality` varchar(32) DEFAULT NULL,
  `pr_creation_date` timestamp(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`pid`, `pr_owner`, `pr_filename`, `pr_exif`, `pr_upload_date`, `pr_quality`, `pr_creation_date`) VALUES
(1234, 'asdf', 'dog-digging-sand-his-head-sand-beach-77290281.jpg', '', '2020-05-28 11:39:18.398117', '', '2020-05-12 06:28:09.671273'),
(4321, 'asdf', 'johanna-pferd.jpg', '', '2020-05-30 11:43:10.000000', '', '2020-05-30 11:43:10.000000');

-- --------------------------------------------------------

--
-- Table structure for table `producttags`
--

DROP TABLE IF EXISTS `product-tags`;
DROP TABLE IF EXISTS `producttags`;
CREATE TABLE `producttags` (
  `pid` int(11) NOT NULL,
  `tid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `producttags`
--

INSERT INTO `producttags` (`pid`, `tid`) VALUES
(1234, 1);

-- --------------------------------------------------------

--
-- Table structure for table `shoppingcart`
--

DROP TABLE IF EXISTS `shopping-cart`;
DROP TABLE IF EXISTS `shoppingcart`;
CREATE TABLE `shoppingcart` (
  `w_username` varchar(32) NOT NULL,
  `w_pid` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `userboughtproduct`
--

DROP TABLE IF EXISTS `userboughtproduct`;
CREATE TABLE `userboughtproduct` (
  `b_username` varchar(32) NOT NULL,
  `b_pid` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tag`;
DROP TABLE IF EXISTS `tags`;
CREATE TABLE `tags` (
  `tid` int(11) NOT NULL,
  `t_name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`tid`, `t_name`) VALUES
(2, 'Österreich'),
(3, 'Semmering'),
(1, 'Wien');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `username` varchar(32) NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `title` varchar(16) NOT NULL,
  `firstname` varchar(32) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `address` varchar(64) NOT NULL,
  `location` varchar(64) NOT NULL,
  `plz` int(4) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `email`, `title`, `firstname`, `lastname`, `address`, `location`, `plz`, `is_admin`, `is_active`) VALUES
('asdf', '$2y$10$hfAjn0zW2zof0HOY9.WElui3hexWGxm9j.ZfMXI664UUSOnVAhb1e', 'max@muster.at', 'Herr', 'Max', 'Mustermann', 'Mustergasse 12', 'Musterdorf', 1234, 1, 1);
-- password is '1234'

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `producttags`
--
ALTER TABLE `producttags`
  ADD PRIMARY KEY (`pid`,`tid`);

--
-- Indexes for table `shoppingcart`
--
ALTER TABLE `shoppingcart`
  ADD PRIMARY KEY (`w_username`,`w_pid`);

--
-- Indexes for table `userboughtproduct`
--
ALTER TABLE `userboughtproduct`
  ADD PRIMARY KEY (`b_username`,`b_pid`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`tid`),
  ADD UNIQUE KEY `t_name` (`t_name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4322;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `tid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
