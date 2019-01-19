-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 19, 2019 at 11:27 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `goginphprojekt`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_firstname` varchar(255) NOT NULL,
  `user_lastname` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_psw` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_country` char(2) NOT NULL,
  `user_role` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_firstname`, `user_lastname`, `user_name`, `user_psw`, `user_email`, `user_country`, `user_role`) VALUES
(2, 'Silver', 'WaveRider', 'silverrider', '$2y$12$a975nLOpde320gHT9ErZ.eQPNE/9bMdEl2JsNjYJRXKq17UT3qqQ.', 'silverrider@surfboard.au', 'AU', 'PendingRole'),
(3, 'Gordana', 'DeliÅ¡imunoviÄ‡', 'aprillmood', '$2y$12$RCP/Xwk6JHJJjS27ukVuhe22gxkioqql4VrZL2tM2.qqRVUmH.djm', 'april.mood@yahoo.com', 'HR', 'Administrator'),
(4, 'Heidi', 'Slider', 'slider', '$2y$12$DRbNBbZWimPaS90lKrDTj.VQ76nrlidrs8pDZSQsccMlpqjLp6bZa', 'hawaiislider@waikiki.com', 'US', 'Editor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
