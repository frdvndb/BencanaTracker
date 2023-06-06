-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 06, 2023 at 05:00 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bencanatracker`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_locations`
--

CREATE TABLE `user_locations` (
  `id` int(11) NOT NULL,
  `latitude` varchar(20) NOT NULL,
  `longitude` varchar(20) NOT NULL,
  `location_name` varchar(100) NOT NULL,
  `info` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_locations`
--

INSERT INTO `user_locations` (`id`, `latitude`, `longitude`, `location_name`, `info`) VALUES
(1, '36.778259', '-119.417931', 'California', 'Sacramento, USA'),
(2, '31.968599', '-99.901810', 'Texas', 'Austin, USA'),
(3, '27.664827', '-81.515755', 'Florida', 'Tallahassee, USA'),
(4, '41.6809707', '44.0287382', 'Georgia', 'Atlanta, USA'),
(5, '38.8950368', '-77.0365427', 'Washington', 'Olympia, USA'),
(6, '17.58940638724942', '-2.2025069507958994', 'Mali', ''),
(7, '22.408874092158356', '1.7179779302709797', 'Hujan', ''),
(8, '25.58414250072312', '2.612069955813028', 'Hujan', ''),
(9, '26.210006517204697', '4.802212229691385', 'Hujan', ''),
(10, '15.51826152890787', '19.03074946125235', 'Hujan', ''),
(11, '16.51085069889158', '20.81530962112265', 'ssd', ''),
(12, '28.977905048429026', '38.5927278716457', 'Hujan', ''),
(13, '-3.29848800923147', '114.5878281983168', 'Banjir', ''),
(14, '17.395621776048063', '-9.465223044337156', 'gi', ''),
(15, '17.479473304040464', '-13.508191794337156', 'x', ''),
(16, '24.649618305369113', '18.091023382181763', 'sss', ''),
(17, '47.31694714117874', '22.878411834428917', 'Banjiir Gempabumo', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user_locations`
--
ALTER TABLE `user_locations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user_locations`
--
ALTER TABLE `user_locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
