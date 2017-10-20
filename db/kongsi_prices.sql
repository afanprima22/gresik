-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 20, 2017 at 04:31 PM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gresik_live`
--

-- --------------------------------------------------------

--
-- Table structure for table `kongsi_prices`
--

CREATE TABLE `kongsi_prices` (
  `kongsi_price_id` int(11) NOT NULL,
  `kongsi_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `kongsi_price_value` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `kongsi_price_promo1` int(11) NOT NULL,
  `kongsi_price_promo2` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kongsi_prices`
--

INSERT INTO `kongsi_prices` (`kongsi_price_id`, `kongsi_id`, `item_id`, `kongsi_price_value`, `user_id`, `kongsi_price_promo1`, `kongsi_price_promo2`) VALUES
(2, 18, 6416, 200000, 11, 2000, 1000),
(3, 20, 6416, 10000, 11, 1000, 1000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kongsi_prices`
--
ALTER TABLE `kongsi_prices`
  ADD PRIMARY KEY (`kongsi_price_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kongsi_prices`
--
ALTER TABLE `kongsi_prices`
  MODIFY `kongsi_price_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
