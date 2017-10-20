-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 20, 2017 at 04:29 PM
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
-- Table structure for table `kongsis`
--

CREATE TABLE `kongsis` (
  `kongsi_id` int(11) NOT NULL,
  `kongsi_name` varchar(50) NOT NULL,
  `kongsi_address` varchar(100) NOT NULL,
  `kongsi_store` varchar(50) NOT NULL,
  `kongsi_store_address` varchar(100) NOT NULL,
  `kongsi_telp` varchar(20) NOT NULL,
  `kongsi_hp` varchar(20) NOT NULL,
  `kongsi_no_npwp` varchar(30) NOT NULL,
  `kongsi_name_npwp` varchar(50) NOT NULL,
  `kongsi_mail` varchar(30) NOT NULL,
  `kongsi_type_id` int(11) NOT NULL,
  `kongsi_type_sub_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `kongsi_img` text NOT NULL,
  `kongsi_category_id` int(11) NOT NULL,
  `kongsi_warehouse` varchar(100) NOT NULL,
  `kongsi_purchase_pic` varchar(50) NOT NULL,
  `kongsi_purchase_tlp` varchar(25) NOT NULL,
  `kongsi_warehouse_pic` varchar(50) NOT NULL,
  `kongsi_warehouse_tlp` varchar(25) NOT NULL,
  `kongsi_store_pic` varchar(50) NOT NULL,
  `kongsi_store_tlp` varchar(25) NOT NULL,
  `location_id` int(11) NOT NULL,
  `promo1_name` varchar(50) NOT NULL,
  `promo1_date1` date NOT NULL,
  `promo1_date2` date NOT NULL,
  `promo2_name` varchar(50) NOT NULL,
  `promo2_date1` date NOT NULL,
  `promo2_date2` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kongsis`
--

INSERT INTO `kongsis` (`kongsi_id`, `kongsi_name`, `kongsi_address`, `kongsi_store`, `kongsi_store_address`, `kongsi_telp`, `kongsi_hp`, `kongsi_no_npwp`, `kongsi_name_npwp`, `kongsi_mail`, `kongsi_type_id`, `kongsi_type_sub_id`, `city_id`, `kongsi_img`, `kongsi_category_id`, `kongsi_warehouse`, `kongsi_purchase_pic`, `kongsi_purchase_tlp`, `kongsi_warehouse_pic`, `kongsi_warehouse_tlp`, `kongsi_store_pic`, `kongsi_store_tlp`, `location_id`, `promo1_name`, `promo1_date1`, `promo1_date2`, `promo2_name`, `promo2_date1`, `promo2_date2`) VALUES
(20, 'supri', 'jombang', 'supri shop', 'jombang', '12222222222222', '2222222222222222', '2121', 'supri', 'supri@gmail.com', 4, 3, 0, '6bf27c1b62227c3d5a89e318d27e9448.PNG', 1, 'jombang', '12212', '212', '2121', '212', '212', '212', 44443, 'promo lebaran', '2017-10-18', '2017-10-21', 'promo ketupat', '2017-10-21', '2017-10-28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kongsis`
--
ALTER TABLE `kongsis`
  ADD PRIMARY KEY (`kongsi_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kongsis`
--
ALTER TABLE `kongsis`
  MODIFY `kongsi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
