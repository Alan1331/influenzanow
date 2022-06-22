-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 22, 2022 at 02:22 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `influenzanow`
--

-- --------------------------------------------------------

--
-- Table structure for table `apply_erf`
--

CREATE TABLE `apply_erf` (
  `apply_id` bigint(20) NOT NULL,
  `apply_status` varchar(20) DEFAULT NULL,
  `erf_id` bigint(20) DEFAULT NULL,
  `inf_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `apply_erf`
--

INSERT INTO `apply_erf` (`apply_id`, `apply_status`, `erf_id`, `inf_id`) VALUES
(5, 'Done', 7, 1),
(6, 'Waiting for Approval', 7, 6),
(7, 'Accepted/Joined', 5, 6),
(8, 'Waiting for Approval', 8, 6),
(9, 'Accepted/Joined', 8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `brand_id` bigint(20) NOT NULL,
  `brand_name` varchar(30) NOT NULL,
  `brand_email` varchar(50) NOT NULL,
  `brand_password` varchar(150) NOT NULL,
  `brand_sector` varchar(30) NOT NULL,
  `brand_phone_number` varchar(15) NOT NULL,
  `brand_description` varchar(300) DEFAULT NULL,
  `brand_logo` varchar(500) DEFAULT 'default.png'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`brand_id`, `brand_name`, `brand_email`, `brand_password`, `brand_sector`, `brand_phone_number`, `brand_description`, `brand_logo`) VALUES
(2, 'Indomie', 'indomie@indomie.com', '$2y$10$ycZClBpSQVMGlTKzsz6BfOb6OdGZ/vhVGzVzM4VHUrGsWtInFqVO2', 'Instant Noodle', '087883345326', 'Indomie selerakuuuuuuuu', '62b21976a8aa1.png'),
(3, 'Apple', 'apple@gmail.com', '$2y$10$D2HOcoOSSVqTxfu5SfUE8OwBkNdXSpOkgw8.rpwrY68epFTPIrWzG', 'Electronics', '08737747128', 'Apple brand mevvah', 'default.png'),
(4, 'Abdulics Inc.', 'abdulist2003@gmail.com', '$2y$10$FHhS7pmI.BZ4PY0oFpyNJeVkVsNTwWMClFIRsBfWhbHGs3UDgb4We', 'Electronics', '085156184925', 'asdasdsa', 'default.png'),
(5, 'Aqua', 'aqua@aqua.com', '$2y$10$qqMhJG819aIaO685JE8BxuPU3NdXUZs.HkZhH0EPp6VJ15n06ER0S', 'Mineral Water', '087883345326', 'Aqua air putih keluarga', 'default.png');

-- --------------------------------------------------------

--
-- Table structure for table `brand_notifications`
--

CREATE TABLE `brand_notifications` (
  `brand_notif_id` bigint(20) NOT NULL,
  `brand_notif_desc` varchar(200) NOT NULL,
  `brand_notif_link` varchar(200) DEFAULT NULL,
  `hide` tinyint(1) DEFAULT 0,
  `brand_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `erf`
--

CREATE TABLE `erf` (
  `erf_id` bigint(20) NOT NULL,
  `erf_name` varchar(30) NOT NULL,
  `product_name` varchar(30) NOT NULL,
  `product_price` decimal(19,2) NOT NULL,
  `gen_brief` text NOT NULL,
  `erf_pict` varchar(500) DEFAULT 'default.png',
  `erf_status` varchar(10) DEFAULT NULL,
  `post_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `reason` varchar(300) DEFAULT NULL,
  `negotiation` tinyint(1) DEFAULT NULL,
  `brand_id` bigint(20) DEFAULT NULL,
  `reg_deadline` date DEFAULT NULL,
  `inf_required` bigint(20) DEFAULT NULL,
  `inf_applied` bigint(20) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `erf`
--

INSERT INTO `erf` (`erf_id`, `erf_name`, `product_name`, `product_price`, `gen_brief`, `erf_pict`, `erf_status`, `post_date`, `reason`, `negotiation`, `brand_id`, `reg_deadline`, `inf_required`, `inf_applied`) VALUES
(5, 'Promosikan Indomie Goreng', 'Indomie Goreng', '3150.00', 'Beli dan promosikan Indomie, dapatkan imbalannya.', '62a6f1893afa6.png', 'posted', '2022-06-14 06:00:40', NULL, 1, 2, '2022-06-30', 150, 0),
(7, 'Promosikan Indomie Kari Ayam', 'Indomie Kari Ayam', '2500.00', 'kari ayam', '62a6f5c76ea47.png', 'posted', '2022-06-13 14:26:55', NULL, 1, 2, '2022-06-17', 35, 0),
(8, 'Promosikan Indomie Pedas', 'Indomie Pedas', '2500.00', 'Promosikan indomie soto', '62b205fca9957.jpg', 'posted', '2022-06-21 17:55:08', NULL, 0, 2, '2022-06-18', 50, 0),
(9, 'Review iPhone 13 Pro Max', 'iPhone 13 Pro Max', '25000000.00', 'review iphone 13 pro max', 'default.png', 'posted', '2022-06-16 05:57:47', NULL, 0, 4, '2022-06-17', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `influencer`
--

CREATE TABLE `influencer` (
  `inf_id` bigint(20) NOT NULL,
  `inf_username` varchar(20) NOT NULL,
  `inf_name` varchar(30) NOT NULL,
  `inf_email` varchar(50) NOT NULL,
  `inf_password` varchar(150) NOT NULL,
  `inf_gender` char(1) NOT NULL,
  `inf_birthdate` date NOT NULL,
  `inf_address` varchar(150) NOT NULL,
  `inf_phone_number` varchar(15) NOT NULL,
  `inf_reg_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `inf_pict` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `influencer`
--

INSERT INTO `influencer` (`inf_id`, `inf_username`, `inf_name`, `inf_email`, `inf_password`, `inf_gender`, `inf_birthdate`, `inf_address`, `inf_phone_number`, `inf_reg_date`, `inf_pict`) VALUES
(1, 'alan1331', 'Syekh Maulana Wijaya', 'sahlan.royale@gmail.com', '$2y$10$zZ6fveS1g/Hk7OBT.Je5NOp6GMm7jjCE8ftvvVA9sVIQs9vvCQhki', 'M', '2003-07-10', 'Jl. Jatimayung 3, RT.001/RW.09, Jatimulya', '085156684787', '2022-06-14 17:44:55', '62a8c917a8268.jpg'),
(2, 'budi_tabuti', 'Budi Tabuti', 'budi@tabuti.corp', '$2y$10$JrEtu94ZWsu9EHkKJWSUb.DSLzzJnmSmRDF6gfdsXJLBh8I038e/.', 'M', '2022-03-31', 'test', '085157784777', '2022-06-16 03:23:08', 'default.png'),
(3, 'abdulist', 'Ahmad Abdul Fatah', 'dexel7zip@gmail.com', '$2y$10$1R4TFKxAOjgFL6X36qP64u5b3g1GJ0WolobbAIR7TWYSpjpTFxxCq', 'M', '2022-06-15', 'hgi8uh7u', '085156184925', '2022-06-16 03:36:20', 'default.png'),
(4, 'testing', 'testing', 'testing@gmail.com', '$2y$10$cTvdU7fiUEQQ9FLLNbhzC.e1jxDl7AebyJtba0G7cQo/Kyo8p8n1m', 'M', '2022-06-09', 'Testing', '087883345326', '2022-06-16 05:50:37', 'default.png'),
(5, 'alfnmrz', 'Alfian Mohammad Rizki', 'alfnmrz@gmail.com', '$2y$10$t96t4HI1/k7uv47nIm2AoOcw2jW67.i3yrU6Ol144JS2HpKIQtnNq', 'M', '2022-01-05', 'Tanggerang', '08515668787', '2022-06-20 07:33:03', '62b022afdbfcb.jpg'),
(6, 'testing2', 'testing2', 'testing2@gmail.com', '$2y$10$ZCoW8RkhYdt5yxNAGt0CueeXCBn8nr6hlr.nZhicQfMLPb.sVZf5K', 'M', '2022-06-19', 'testing2', '08515668787', '2022-06-20 11:55:16', '62b06024876d0.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `inf_criteria`
--

CREATE TABLE `inf_criteria` (
  `erf_id` bigint(20) DEFAULT NULL,
  `criteria` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inf_criteria`
--

INSERT INTO `inf_criteria` (`erf_id`, `criteria`) VALUES
(5, 'berpenampilan menarik'),
(7, 'berpenampilan menarik'),
(7, 'cocok dengan personal branding Indomie'),
(7, 'anak kos'),
(5, 'cocok dengan personal branding Indomie'),
(9, 'suka flexing harta'),
(9, 'tampan'),
(9, 'tinggi minimal 175cm'),
(8, 'Berpenampilan menarik');

-- --------------------------------------------------------

--
-- Table structure for table `inf_interest`
--

CREATE TABLE `inf_interest` (
  `inf_id` bigint(20) DEFAULT NULL,
  `interest` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inf_interest`
--

INSERT INTO `inf_interest` (`inf_id`, `interest`) VALUES
(NULL, 'K-Drama'),
(2, 'Rubick\'s Cube'),
(3, 'Gaming'),
(1, 'Rubick\'s Cube'),
(1, 'K-Drama'),
(1, 'Basketball'),
(4, 'Rubick\'s Cube'),
(5, 'Lifestyle'),
(6, 'testing2');

-- --------------------------------------------------------

--
-- Table structure for table `inf_notifications`
--

CREATE TABLE `inf_notifications` (
  `inf_notif_id` bigint(20) NOT NULL,
  `inf_notif_desc` varchar(200) NOT NULL,
  `inf_notif_link` varchar(200) DEFAULT NULL,
  `hide` tinyint(1) DEFAULT 0,
  `inf_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inf_notifications`
--

INSERT INTO `inf_notifications` (`inf_notif_id`, `inf_notif_desc`, `inf_notif_link`, `hide`, `inf_id`) VALUES
(1, 'You have accepted to join campaign named Promosikan Indomie Goreng', 'erfDetail.php?erf_id=5', 1, 1),
(2, 'You have accepted to join campaign named Promosikan Lemineral Kemasan N', 'erfDetail.php?erf_id=10', 0, 5),
(3, 'You have accepted to join campaign named Promosikan Indomie Kari Ayam', 'erfDetail.php?erf_id=7', 0, 1),
(4, 'Your work on task named Make a purchase was approved by the brand', 'erfDetail.php?erf_id=7', 0, 1),
(5, 'Your work on task named Promote our brand was approved by the brand', 'erfDetail.php?erf_id=7', 0, 1),
(6, 'You have accepted to join campaign named Promosikan Indomie Pedas', 'erfDetail.php?erf_id=8', 0, 1),
(7, 'You have accepted to join campaign named Promosikan Indomie Goreng', 'erfDetail.php?erf_id=5', 0, 6),
(8, 'Your application on \'Promosikan Indomie Goreng\' was declined', 'erfDetail.php?erf_id=5', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ref_link`
--

CREATE TABLE `ref_link` (
  `erf_id` bigint(20) DEFAULT NULL,
  `link` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ref_link`
--

INSERT INTO `ref_link` (`erf_id`, `link`) VALUES
(5, 'https://www.indomie.com/homepage'),
(5, 'https://youtube.com/indomie');

-- --------------------------------------------------------

--
-- Table structure for table `rules_list`
--

CREATE TABLE `rules_list` (
  `rules_id` bigint(20) NOT NULL,
  `task_id` bigint(20) DEFAULT NULL,
  `rules` varchar(300) DEFAULT NULL,
  `rules_type` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rules_list`
--

INSERT INTO `rules_list` (`rules_id`, `task_id`, `rules`, `rules_type`) VALUES
(1, 4, 'test', 'do'),
(2, 4, 'test', 'dont'),
(3, 7, 'promosikan produk kami', 'do'),
(4, 7, 'jangan perlihatkan produk lain', 'dont'),
(11, 9, 'like instagram kita', 'do'),
(12, 9, 'follow instagram kita', 'do'),
(13, 9, 'dilarang follow instagram kompetitor', 'dont'),
(14, 10, 'Beli di official store', 'do'),
(15, 10, 'Jangan beli di toko sembarang', 'dont'),
(16, 11, 'promosikan produk kami', 'do'),
(17, 11, 'jangan perlihatkan produk lain', 'dont'),
(18, 13, 'Beli di minimarket', 'do'),
(19, 13, 'jangan beli di warung', 'dont'),
(20, 14, 'promosikan produk kami', 'do'),
(21, 14, 'jangan perlihatkan produk lain', 'dont'),
(22, 15, 'Beli di official store', 'do'),
(23, 15, 'Jangan beli di toko sembarang', 'dont'),
(24, 16, 'promosikan produk kami', 'do'),
(25, 16, 'jangan perlihatkan produk lain', 'dont'),
(26, 17, 'promosikan produk kami', 'do'),
(27, 17, 'jangan perlihatkan produk lain', 'dont'),
(28, 18, 'Beli di official store', 'do'),
(31, 18, 'Jangan beli di toko sembarang', 'dont'),
(32, 19, 'promosikan produk kami', 'do'),
(33, 19, 'jangan perlihatkan produk lain', 'dont'),
(34, 21, 'promosikan produk kami', 'do'),
(35, 21, 'testing', 'do'),
(36, 22, 'testing', 'do'),
(37, 23, 'Promosikan Lemineral kemasan tanggung', 'do');

-- --------------------------------------------------------

--
-- Table structure for table `saved_erf`
--

CREATE TABLE `saved_erf` (
  `saved_erf_id` bigint(20) NOT NULL,
  `inf_id` bigint(20) DEFAULT NULL,
  `erf_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `saved_erf`
--

INSERT INTO `saved_erf` (`saved_erf_id`, `inf_id`, `erf_id`) VALUES
(8, 6, 7),
(9, 6, 5),
(10, 6, 8);

-- --------------------------------------------------------

--
-- Table structure for table `sns`
--

CREATE TABLE `sns` (
  `inf_id` bigint(20) DEFAULT NULL,
  `sns_type` varchar(10) NOT NULL,
  `sns_username` varchar(20) NOT NULL,
  `sns_followers` varchar(20) NOT NULL,
  `sns_link` varchar(100) NOT NULL,
  `sns_er` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sns`
--

INSERT INTO `sns` (`inf_id`, `sns_type`, `sns_username`, `sns_followers`, `sns_link`, `sns_er`) VALUES
(NULL, 'instagram', 'sahlan_wijaya', '600', 'https://instagram.com/sahlan_wijaya', 5.12),
(2, 'instagram', 'budi_tabuti', '20', 'https://instagram.com/budi_tabuti', 40.23),
(3, 'instagram', 'ahd.abd._', '300', 'https://instagram.com/ahd.abd._', 4.76),
(1, 'instagram', 'sahlan_wijaya', '500', 'https://instagram.com/sahlan_wijaya', 5.25),
(4, 'instagram', 'testing', '10', 'https://instagram.com/testing', 1.2),
(5, 'instagram', 'alfnmrz', '23.3K', 'https://instagram.com/alfnmrz', 3.15),
(6, 'instagram', 'testing2', '20', 'https://instagram.com/testing2', 1.51),
(6, 'youtube', 'testing2', '273', 'https://youtube.com/testing2', 0),
(6, 'tiktok', 'testing2', '19', 'https://tiktok.com/testing2', 0);

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `task_id` bigint(20) NOT NULL,
  `task_name` varchar(30) NOT NULL,
  `task_deadline` date NOT NULL,
  `task_status` varchar(10) NOT NULL,
  `erf_id` bigint(20) NOT NULL,
  `brief` text DEFAULT NULL,
  `submission` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`task_id`, `task_name`, `task_deadline`, `task_status`, `erf_id`, `brief`, `submission`) VALUES
(13, 'Make a purchase', '2022-06-27', 'added', 7, 'Beli indomie kari ayam di minimarket terdekat.', NULL),
(14, 'Promote our brand', '2022-06-30', 'added', 7, 'promosikan indomie kari ayam', NULL),
(15, 'Make a purchase', '2022-06-20', 'added', 8, 'Make a purchase', NULL),
(17, 'Promote our brand', '2022-07-08', 'added', 8, 'Promosikan indomie soto', NULL),
(18, 'Make a purchase', '2022-06-30', 'added', 5, 'Beli indomie goreng minimal 2pcs', NULL),
(19, 'Promote Indomie Goreng', '2022-07-02', 'added', 5, 'Promosikan indomie goreng', NULL),
(20, 'Pergi ke iBox', '2022-06-19', 'drafted', 9, 'Pergi ke iBox mana saja', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `task_submissions`
--

CREATE TABLE `task_submissions` (
  `submission_id` bigint(20) NOT NULL,
  `task_id` bigint(20) DEFAULT NULL,
  `apply_id` bigint(20) DEFAULT NULL,
  `submission` varchar(200) DEFAULT NULL,
  `submission_status` varchar(20) DEFAULT NULL,
  `erf_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `task_submissions`
--

INSERT INTO `task_submissions` (`submission_id`, `task_id`, `apply_id`, `submission`, `submission_status`, `erf_id`) VALUES
(8, 13, 5, '62b01bdb1b615.png', 'Done', 7),
(9, 14, 5, '62b01be8b16c0.png', 'Done', 7),
(10, 15, 9, NULL, 'not submitted', 8),
(11, 17, 9, NULL, 'not submitted', 8),
(12, 18, 7, NULL, 'not submitted', 5),
(13, 19, 7, NULL, 'not submitted', 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `apply_erf`
--
ALTER TABLE `apply_erf`
  ADD PRIMARY KEY (`apply_id`),
  ADD KEY `fk_erf_apply` (`erf_id`),
  ADD KEY `fk_inf_apply` (`inf_id`);

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `brand_notifications`
--
ALTER TABLE `brand_notifications`
  ADD PRIMARY KEY (`brand_notif_id`),
  ADD KEY `fk_brand_notif` (`brand_id`);

--
-- Indexes for table `erf`
--
ALTER TABLE `erf`
  ADD PRIMARY KEY (`erf_id`),
  ADD KEY `brand_id` (`brand_id`);

--
-- Indexes for table `influencer`
--
ALTER TABLE `influencer`
  ADD PRIMARY KEY (`inf_id`);

--
-- Indexes for table `inf_criteria`
--
ALTER TABLE `inf_criteria`
  ADD KEY `fkcriteria` (`erf_id`);

--
-- Indexes for table `inf_interest`
--
ALTER TABLE `inf_interest`
  ADD KEY `fk_inf_interest` (`inf_id`);

--
-- Indexes for table `inf_notifications`
--
ALTER TABLE `inf_notifications`
  ADD PRIMARY KEY (`inf_notif_id`),
  ADD KEY `fk_inf_notif` (`inf_id`);

--
-- Indexes for table `ref_link`
--
ALTER TABLE `ref_link`
  ADD KEY `fklink` (`erf_id`);

--
-- Indexes for table `rules_list`
--
ALTER TABLE `rules_list`
  ADD PRIMARY KEY (`rules_id`);

--
-- Indexes for table `saved_erf`
--
ALTER TABLE `saved_erf`
  ADD PRIMARY KEY (`saved_erf_id`),
  ADD KEY `fk_saved_erf_inf_id` (`inf_id`),
  ADD KEY `fk_saved_erf_erf_id` (`erf_id`);

--
-- Indexes for table `sns`
--
ALTER TABLE `sns`
  ADD KEY `fk_inf_sns` (`inf_id`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`task_id`),
  ADD KEY `erf_id` (`erf_id`);

--
-- Indexes for table `task_submissions`
--
ALTER TABLE `task_submissions`
  ADD PRIMARY KEY (`submission_id`),
  ADD KEY `fk_submission_task` (`task_id`),
  ADD KEY `fk_submission_apply` (`apply_id`),
  ADD KEY `fk_submission_erf` (`erf_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `apply_erf`
--
ALTER TABLE `apply_erf`
  MODIFY `apply_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `brand_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `brand_notifications`
--
ALTER TABLE `brand_notifications`
  MODIFY `brand_notif_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `erf`
--
ALTER TABLE `erf`
  MODIFY `erf_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `influencer`
--
ALTER TABLE `influencer`
  MODIFY `inf_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `inf_notifications`
--
ALTER TABLE `inf_notifications`
  MODIFY `inf_notif_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `rules_list`
--
ALTER TABLE `rules_list`
  MODIFY `rules_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `saved_erf`
--
ALTER TABLE `saved_erf`
  MODIFY `saved_erf_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `task_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `task_submissions`
--
ALTER TABLE `task_submissions`
  MODIFY `submission_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `apply_erf`
--
ALTER TABLE `apply_erf`
  ADD CONSTRAINT `fk_erf_apply` FOREIGN KEY (`erf_id`) REFERENCES `erf` (`erf_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_inf_apply` FOREIGN KEY (`inf_id`) REFERENCES `influencer` (`inf_id`) ON DELETE CASCADE;

--
-- Constraints for table `brand_notifications`
--
ALTER TABLE `brand_notifications`
  ADD CONSTRAINT `fk_brand_notif` FOREIGN KEY (`brand_id`) REFERENCES `brand` (`brand_id`) ON DELETE CASCADE;

--
-- Constraints for table `erf`
--
ALTER TABLE `erf`
  ADD CONSTRAINT `erf_ibfk_1` FOREIGN KEY (`brand_id`) REFERENCES `brand` (`brand_id`);

--
-- Constraints for table `inf_criteria`
--
ALTER TABLE `inf_criteria`
  ADD CONSTRAINT `fkcriteria` FOREIGN KEY (`erf_id`) REFERENCES `erf` (`erf_id`) ON DELETE CASCADE;

--
-- Constraints for table `inf_interest`
--
ALTER TABLE `inf_interest`
  ADD CONSTRAINT `fk_inf_interest` FOREIGN KEY (`inf_id`) REFERENCES `influencer` (`inf_id`);

--
-- Constraints for table `inf_notifications`
--
ALTER TABLE `inf_notifications`
  ADD CONSTRAINT `fk_inf_notif` FOREIGN KEY (`inf_id`) REFERENCES `influencer` (`inf_id`) ON DELETE CASCADE;

--
-- Constraints for table `ref_link`
--
ALTER TABLE `ref_link`
  ADD CONSTRAINT `fklink` FOREIGN KEY (`erf_id`) REFERENCES `erf` (`erf_id`) ON DELETE CASCADE;

--
-- Constraints for table `saved_erf`
--
ALTER TABLE `saved_erf`
  ADD CONSTRAINT `fk_saved_erf_erf_id` FOREIGN KEY (`erf_id`) REFERENCES `erf` (`erf_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_saved_erf_inf_id` FOREIGN KEY (`inf_id`) REFERENCES `influencer` (`inf_id`) ON DELETE CASCADE;

--
-- Constraints for table `sns`
--
ALTER TABLE `sns`
  ADD CONSTRAINT `fk_inf_sns` FOREIGN KEY (`inf_id`) REFERENCES `influencer` (`inf_id`) ON DELETE CASCADE;

--
-- Constraints for table `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `task_ibfk_1` FOREIGN KEY (`erf_id`) REFERENCES `erf` (`erf_id`);

--
-- Constraints for table `task_submissions`
--
ALTER TABLE `task_submissions`
  ADD CONSTRAINT `fk_submission_apply` FOREIGN KEY (`apply_id`) REFERENCES `apply_erf` (`apply_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_submission_erf` FOREIGN KEY (`erf_id`) REFERENCES `erf` (`erf_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_submission_task` FOREIGN KEY (`task_id`) REFERENCES `task` (`task_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
