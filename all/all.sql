-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2023 at 07:46 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `all`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog_postovi`
--

CREATE TABLE `blog_postovi` (
  `id` int(11) NOT NULL,
  `naslov` varchar(255) NOT NULL,
  `sadrzaj` text DEFAULT NULL,
  `autor_id` int(11) DEFAULT NULL,
  `datum_objave` timestamp NOT NULL DEFAULT current_timestamp(),
  `slika` varchar(255) DEFAULT NULL,
  `autor_username` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog_postovi`
--

INSERT INTO `blog_postovi` (`id`, `naslov`, `sadrzaj`, `autor_id`, `datum_objave`, `slika`, `autor_username`) VALUES
(24, 'test', 'fesfsdafs', 1, '2023-11-29 18:08:40', 'uploads/m.png', 'admin'),
(27, 'test1113333333333', 'ssssssssssss11111113333333333', 2, '2023-11-29 18:12:12', 'uploads/2megana.png', 'milutin'),
(28, 'ssssssssssss', 'ssssssssssss', 2, '2023-11-29 18:12:20', 'uploads/x.png', 'milutin'),
(29, 'sssssssssssssssssssssssssssssssssssssssss', 'ssssssssssssssdfeffffffffffffffffffssssssssssssssss', 2, '2023-11-29 18:12:32', 'uploads/y.PNG', 'milutin'),
(30, 'sssssssssss2222222222', 'ssssssssss222222222222', 2, '2023-11-29 18:12:48', 'uploads/111.jpg', 'milutin'),
(31, 'test', 'sssssssssssss', 2, '2023-11-29 18:15:44', 'uploads/Isus.PNG', 'milutin'),
(32, 'ssssssssss', 'ssssssssssss', 2, '2023-11-29 18:15:53', 'uploads/hightech.gif', 'milutin'),
(33, 'test', 'ssss', 2, '2023-11-29 18:24:46', 'uploads/lesce.jpg', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `korisnici`
--

CREATE TABLE `korisnici` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `korisnici`
--

INSERT INTO `korisnici` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin'),
(2, 'milutin', 'milutin'),
(3, 'hightech', 'hightech');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog_postovi`
--
ALTER TABLE `blog_postovi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `autor_id` (`autor_id`);

--
-- Indexes for table `korisnici`
--
ALTER TABLE `korisnici`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog_postovi`
--
ALTER TABLE `blog_postovi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `korisnici`
--
ALTER TABLE `korisnici`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blog_postovi`
--
ALTER TABLE `blog_postovi`
  ADD CONSTRAINT `blog_postovi_ibfk_1` FOREIGN KEY (`autor_id`) REFERENCES `korisnici` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
