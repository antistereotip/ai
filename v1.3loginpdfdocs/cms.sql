-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 03, 2024 at 10:40 AM
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
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `pdf_id` int(11) NOT NULL,
  `comment_text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `pdf_id`, `comment_text`, `created_at`) VALUES
(3, 32, 'test 3', '2023-11-12 15:43:33'),
(4, 28, 'dwdwdwwd', '2023-11-17 19:46:07'),
(8, 33, 'bios', '2023-11-17 20:23:34');

-- --------------------------------------------------------

--
-- Table structure for table `comments2`
--

CREATE TABLE `comments2` (
  `id` int(11) NOT NULL,
  `document_id` int(11) NOT NULL,
  `comment_text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments2`
--

INSERT INTO `comments2` (`id`, `document_id`, `comment_text`, `created_at`) VALUES
(2, 18, 'test', '2023-11-13 08:28:46'),
(9, 30, 'lorem ipsum lorem ipsumlorem ipsum vlorem ipsum lorem ipsum lorem ipsum lorem ipsumlorem ipsum lorem ipsumlorem ipsumlorem ipsum lorem ipsumlorem ipsumlorem ipsum lorem ipsumlorem ipsumlorem ipsum lorem ipsumlorem ipsumlorem ipsum lorem ipsumlorem ipsumlorem ipsumlorem ipsum lorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsum lorem ipsumlorem ipsumlorem ipsumlorem ipsum lorem ipsumvlorem ipsumlorem ipsum', '2023-11-17 20:25:10'),
(10, 28, 'tcp', '2023-11-17 20:25:34'),
(13, 32, 'deddddddddddd', '2023-11-28 19:33:39');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `file_name`, `file_path`, `uploaded_at`) VALUES
(3, 'sitemap.xml', 'uploads/sitemap.xml', '2023-11-10 20:40:38'),
(4, 'novicvitalic.pdf', 'uploads/novicvitalic.pdf', '2023-11-10 20:42:04'),
(5, 'antistereotip_konfekcija.pdf', 'uploads/antistereotip_konfekcija.pdf', '2023-11-10 20:43:58'),
(6, 'Antistereotip-Plan-B.pdf', 'uploads/Antistereotip-Plan-B.pdf', '2023-11-10 20:44:02'),
(7, 'CV NOVI.pdf', 'uploads/CV NOVI.pdf', '2023-11-10 20:44:06'),
(8, 'cv.pdf', 'uploads/cv.pdf', '2023-11-10 20:44:12'),
(9, 'cvnovicrno.pdf', 'uploads/cvnovicrno.pdf', '2023-11-10 20:44:17'),
(10, 'cvnovzeleniitalic.pdf', 'uploads/cvnovzeleniitalic.pdf', '2023-11-10 20:44:22'),
(11, 'DinovZabavnik.pdf', 'uploads/DinovZabavnik.pdf', '2023-11-10 20:44:40'),
(12, 'dinovzabavnik32bita.pdf', 'uploads/dinovzabavnik32bita.pdf', '2023-11-10 20:44:50'),
(13, 'dzsk_krec_trag.pdf', 'uploads/dzsk_krec_trag.pdf', '2023-11-10 20:44:59'),
(14, 'kozacka-kuca.pdf', 'uploads/kozacka-kuca.pdf', '2023-11-10 20:45:06'),
(15, 'kratkapropoved-cuda.pdf', 'uploads/kratkapropoved-cuda.pdf', '2023-11-10 20:45:10'),
(16, 'kratka-propoved-domacin-slabost-u-snagu.pdf', 'uploads/kratka-propoved-domacin-slabost-u-snagu.pdf', '2023-11-10 20:45:17'),
(17, 'kratkapropoved-nemilosrdni-sluga.pdf', 'uploads/kratkapropoved-nemilosrdni-sluga.pdf', '2023-11-10 20:45:24'),
(18, 'kratka-propoved-pastir.pdf', 'uploads/kratka-propoved-pastir.pdf', '2023-11-10 20:45:37'),
(19, 'lili-kroz-oblake.pdf', 'uploads/lili-kroz-oblake.pdf', '2023-11-10 20:45:42'),
(20, 'neocekivana-zbrka.pdf', 'uploads/neocekivana-zbrka.pdf', '2023-11-10 20:45:50'),
(21, 'novembar.pdf', 'uploads/novembar.pdf', '2023-11-10 20:46:07'),
(22, 'novicvitalic.pdf', 'uploads/novicvitalic.pdf', '2023-11-10 20:46:12'),
(23, 'test.docx', 'uploads/test.docx', '2023-11-10 21:11:17'),
(24, 'propratnopismo.pdf', 'uploads/propratnopismo.pdf', '2023-11-10 22:00:01'),
(25, 'propratnopismo1.pdf', 'uploads/propratnopismo1.pdf', '2023-11-10 22:00:05'),
(26, 'TCP-UDPMrezniProtokoliZDroid.pdf', 'uploads/TCP-UDPMrezniProtokoliZDroid.pdf', '2023-11-11 05:34:48'),
(27, 'ZlatniBroj.pdf', 'uploads/ZlatniBroj.pdf', '2023-11-11 05:34:53'),
(28, 'TCP-UDPMrezniProtokoliZDroid.pdf', 'uploads/TCP-UDPMrezniProtokoliZDroid.pdf', '2023-11-11 05:35:18'),
(29, 'massages.xml', 'uploads/massages.xml', '2023-11-16 21:52:35'),
(30, 'vsms.xml', 'uploads/vsms.xml', '2023-11-16 21:52:39'),
(32, 'cvnovzeleniitalic.pdf', 'uploads/cvnovzeleniitalic.pdf', '2023-11-27 07:41:45'),
(33, 'novicvitalic.pdf', 'uploads/novicvitalic.pdf', '2023-12-02 14:48:24');

-- --------------------------------------------------------

--
-- Table structure for table `pdf_documents`
--

CREATE TABLE `pdf_documents` (
  `id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pdf_documents`
--

INSERT INTO `pdf_documents` (`id`, `file_name`, `file_path`, `uploaded_at`) VALUES
(1, 'novicvitalic.pdf', 'uploads/novicvitalic.pdf', '2023-11-10 19:41:54'),
(2, 'kratkapropoved-cuda.pdf', 'uploads/kratkapropoved-cuda.pdf', '2023-11-10 19:42:26'),
(3, 'kratka-propoved-domacin-slabost-u-snagu.pdf', 'uploads/kratka-propoved-domacin-slabost-u-snagu.pdf', '2023-11-10 19:42:31'),
(4, 'kratkapropoved-nemilosrdni-sluga.pdf', 'uploads/kratkapropoved-nemilosrdni-sluga.pdf', '2023-11-10 19:42:36'),
(5, 'kratka-propoved-pastir.pdf', 'uploads/kratka-propoved-pastir.pdf', '2023-11-10 19:42:43'),
(7, 'kratka-propoved-zakon-greha-domacin.pdf', 'uploads/kratka-propoved-zakon-greha-domacin.pdf', '2023-11-10 19:49:42'),
(8, 'DinovZabavnik.pdf', 'uploads/DinovZabavnik.pdf', '2023-11-10 19:52:27'),
(11, 'cvnovzeleniitalic.pdf', 'uploads/cvnovzeleniitalic.pdf', '2023-11-10 19:55:57'),
(12, 'CV NOVI.pdf', 'uploads/CV NOVI.pdf', '2023-11-10 19:56:10'),
(13, 'cv.pdf', 'uploads/cv.pdf', '2023-11-10 19:56:15'),
(15, 'cvnovicrno.pdf', 'uploads/cvnovicrno.pdf', '2023-11-10 20:08:18'),
(16, 'dzsk_krec_trag.pdf', 'uploads/dzsk_krec_trag.pdf', '2023-11-10 20:21:49'),
(17, 'antistereotip_konfekcija.pdf', 'uploads/antistereotip_konfekcija.pdf', '2023-11-10 20:22:11'),
(18, 'novembar.pdf', 'uploads/novembar.pdf', '2023-11-10 20:22:32'),
(19, 'Antistereotip-Plan-B.pdf', 'uploads/Antistereotip-Plan-B.pdf', '2023-11-10 20:24:35'),
(20, 'dinovzabavnik32bita.pdf', 'uploads/dinovzabavnik32bita.pdf', '2023-11-10 20:24:58'),
(21, 'kozacka-kuca.pdf', 'uploads/kozacka-kuca.pdf', '2023-11-10 20:26:37'),
(22, 'lili-kroz-oblake.pdf', 'uploads/lili-kroz-oblake.pdf', '2023-11-10 20:26:40'),
(23, 'neocekivana-zbrka.pdf', 'uploads/neocekivana-zbrka.pdf', '2023-11-10 20:26:44'),
(24, 'TCP-UDPMrezniProtokoliZDroid.pdf', 'uploads/TCP-UDPMrezniProtokoliZDroid.pdf', '2023-11-11 05:35:34'),
(25, 'ZlatniBroj.pdf', 'uploads/ZlatniBroj.pdf', '2023-11-11 05:36:10'),
(26, 'Kako se zastiti.pdf', 'uploads/Kako se zastiti.pdf', '2023-11-11 05:39:39'),
(27, 'Instalacija Gentoo-a.pdf', 'uploads/Instalacija Gentoo-a.pdf', '2023-11-11 05:40:02'),
(28, 'Instalacija GNU Linux-a.pdf', 'uploads/Instalacija GNU Linux-a.pdf', '2023-11-11 05:40:09'),
(29, 'Internet.pdf', 'uploads/Internet.pdf', '2023-11-11 05:40:18'),
(30, 'Hardware.pdf', 'uploads/Hardware.pdf', '2023-11-11 05:40:26'),
(31, 'GPS.pdf', 'uploads/GPS.pdf', '2023-11-11 05:40:31'),
(32, 'Cron pravila.pdf', 'uploads/Cron pravila.pdf', '2023-11-11 05:40:35'),
(33, 'BIOS, Kernel i GRUB, veoma bitno za startanje kompjutera.pdf', 'uploads/BIOS, Kernel i GRUB, veoma bitno za startanje kompjutera.pdf', '2023-11-11 05:40:40');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'admin', 'loginordie124'),
(2, 'milutin', 'loginordie124');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pdf_id` (`pdf_id`);

--
-- Indexes for table `comments2`
--
ALTER TABLE `comments2`
  ADD PRIMARY KEY (`id`),
  ADD KEY `document_id` (`document_id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pdf_documents`
--
ALTER TABLE `pdf_documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `comments2`
--
ALTER TABLE `comments2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `pdf_documents`
--
ALTER TABLE `pdf_documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`pdf_id`) REFERENCES `pdf_documents` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comments2`
--
ALTER TABLE `comments2`
  ADD CONSTRAINT `comments2_ibfk_1` FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
