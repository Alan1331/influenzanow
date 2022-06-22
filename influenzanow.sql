-- phpMyAdmin SQL Dump
-- version 4.6.6deb5ubuntu0.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 22, 2022 at 09:35 AM
-- Server version: 5.7.38-0ubuntu0.18.04.1
-- PHP Version: 7.3.33-1+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
(14, 'Done', 12, 7),
(16, 'Accepted/Joined', 12, 9),
(17, 'Accepted/Joined', 15, 7),
(18, 'Accepted/Joined', 16, 7),
(19, 'Accepted/Joined', 13, 7);

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
(7, 'Indomie', 'admin@indomie.com', '$2y$10$pJJ5G451OL5wejZx379iWOecfF5ERG9SuDa8YaW2gu5R226af4rf2', 'F&B', '087883345326', 'Indomie seleraku', 'default.png'),
(8, 'Abdulics', 'dexel7zip@gmail.com', '$2y$10$0Visi1uiGvv3iXdWUC0queFht4wCtY.FfBkY7bKDp8cXYNMe5SxGK', 'Electronics', '085156184925', 'We Love Electronics', 'default.png'),
(9, 'tuktukcha', 'alfnmrz@gmail.com', '$2y$10$HL.IRH2/wEXsqs9U69JdQ.y2ZHwQfvuE8lDwH3Mo7AtEugyb80uKO', 'Food', '081398770512', 'brand kami bergerak pada sektor makanan terutama minuman seperti varian milktea, smoothies, dan juice', 'default.png');

-- --------------------------------------------------------

--
-- Table structure for table `brand_notifications`
--

CREATE TABLE `brand_notifications` (
  `brand_notif_id` bigint(20) NOT NULL,
  `brand_notif_desc` varchar(200) NOT NULL,
  `brand_notif_link` varchar(200) DEFAULT NULL,
  `hide` tinyint(1) DEFAULT '0',
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
  `post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `reason` varchar(300) DEFAULT NULL,
  `negotiation` tinyint(1) DEFAULT NULL,
  `brand_id` bigint(20) DEFAULT NULL,
  `reg_deadline` date DEFAULT NULL,
  `inf_required` bigint(20) DEFAULT NULL,
  `inf_applied` bigint(20) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `erf`
--

INSERT INTO `erf` (`erf_id`, `erf_name`, `product_name`, `product_price`, `gen_brief`, `erf_pict`, `erf_status`, `post_date`, `reason`, `negotiation`, `brand_id`, `reg_deadline`, `inf_required`, `inf_applied`) VALUES
(12, 'Promosikan Indomie Goreng', 'Indomie Goreng', '2500.00', 'Promosikan indomie dan dapatkan imbalannya', '62b279afc3416.png', 'posted', '2022-06-22 02:08:47', NULL, 1, 7, '2022-06-30', 1, 0),
(13, 'Review iPhone 13 Pro Max', 'iPhone 13 Pro Max', '24000000.00', 'Review iPhone 13 Pro Max', '62b27bcb854c1.jpg', 'posted', '2022-06-22 02:17:47', NULL, 0, 8, '2022-06-23', 1, 0),
(14, 'Visit Store Terbaru TUKTUKCHA', 'Milk Tea TUKTUKCHA', '30000.00', 'Membeli produk milk tea varian terbaru dan akan mendapatkan buy 1 get 1 free.', '62b272300984e.png', 'posted', '2022-06-22 01:49:02', NULL, 1, 9, '2022-07-13', 10, 0),
(15, 'Promosikan Indomie Kari Ayam', 'Indomie Kari Ayam', '2500.00', 'Promosikan indomie kari ayam dan dapatkan imbalannya', '62b27a31d3a8e.jpg', 'posted', '2022-06-22 02:16:25', NULL, 0, 7, '2022-06-30', 50, 0),
(16, 'Promosikan Indomie Pedas', 'Indomie Goreng Pedas', '2500.00', 'Promosikan indomie goreng pedas dan dapatkan imbalannya', '62b27bab23f95.png', 'posted', '2022-06-22 02:20:48', NULL, 0, 7, '2022-06-30', 50, 0);

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
  `inf_reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `inf_pict` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `influencer`
--

INSERT INTO `influencer` (`inf_id`, `inf_username`, `inf_name`, `inf_email`, `inf_password`, `inf_gender`, `inf_birthdate`, `inf_address`, `inf_phone_number`, `inf_reg_date`, `inf_pict`) VALUES
(7, 'alan1331', 'Syekh Maulana Wijaya', 'sahlan.royale@gmail.com', '$2y$10$drxDuqbaMr6AtRX1IcAyKePoJJ1amoDaAwyj8fl6UxP147Nrf.T1y', 'M', '2003-07-10', 'Sukabirus, Bojongsoang, Bandung', '085156684787', '2022-06-22 02:03:20', '62b2786828c18.jpg'),
(8, 'abdulist', 'Ahmad Abdul Fatah', 'dexel7zip@gmail.com', '$2y$10$1oLgWQJYX.OBItgOVlH9oOflIXz.PBTBkp63WmVbR2yGikIHaVfBG', 'M', '2003-05-30', 'GDC, Puri Insani 1, Blok F1/12', '085156184925', '2022-06-22 02:19:12', '62b27c20b689c.png'),
(9, 'alfnmrz', 'Alfian Mohammad Rizki', 'alfianmrizki123@gmail.com', '$2y$10$h22iZ63n1xU37bdLqhJCiO0DFWfW3nz1GTb802HjVizKvKWqXPJ8m', 'M', '2003-10-11', 'Perum Griya Curug Blok C.4/16, RT.010/RW.011, Rancagong, Legok', '081317004331', '2022-06-22 01:24:04', '62b26f348582f.jpg');

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
(12, 'Berpenampilan menarik'),
(13, 'Sultan'),
(13, 'Love to Flex'),
(14, 'Usia 17-30 tahun'),
(14, 'Berpenampilan Menarik'),
(14, 'Minimal ER 4.5%'),
(14, 'Domisili Tangerang'),
(15, 'Pintar'),
(16, 'Berpenampilan menarik');

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
(7, 'Rubick\'s Cube'),
(7, 'K-Drama'),
(8, 'Gaming'),
(8, 'Live Stream'),
(8, 'Watching Anime'),
(9, 'lifestle'),
(9, 'foodies');

-- --------------------------------------------------------

--
-- Table structure for table `inf_notifications`
--

CREATE TABLE `inf_notifications` (
  `inf_notif_id` bigint(20) NOT NULL,
  `inf_notif_desc` varchar(200) NOT NULL,
  `inf_notif_link` varchar(200) DEFAULT NULL,
  `hide` tinyint(1) DEFAULT '0',
  `inf_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inf_notifications`
--

INSERT INTO `inf_notifications` (`inf_notif_id`, `inf_notif_desc`, `inf_notif_link`, `hide`, `inf_id`) VALUES
(9, 'You have accepted to join campaign named Review iPhone 13 Pro Max', 'erfDetail.php?erf_id=13', 0, 8),
(10, 'Your work on task named Membeli iPhone 13 Pro max was approved by the brand', 'erfDetail.php?erf_id=13', 0, 8),
(11, 'Your work on task named Unboxing iPhone 13 Pro Max was approved by the brand', 'erfDetail.php?erf_id=13', 0, 8),
(12, 'Your work on task named Review iPhone 13 Pro Max was approved by the brand', 'erfDetail.php?erf_id=13', 0, 8),
(13, 'You have accepted to join campaign named Promosikan Indomie Goreng', 'erfDetail.php?erf_id=12', 0, 9),
(14, 'You have accepted to join campaign named Review iPhone 13 Pro Max', 'erfDetail.php?erf_id=13', 0, 7),
(15, 'You have accepted to join campaign named Promosikan Indomie Goreng', 'erfDetail.php?erf_id=12', 0, 7),
(16, 'You have accepted to join campaign named Promosikan Indomie Kari Ayam', 'erfDetail.php?erf_id=15', 0, 7),
(17, 'You have accepted to join campaign named Promosikan Indomie Pedas', 'erfDetail.php?erf_id=16', 0, 7),
(18, 'Your work on task named Make a purchase was approved by the brand', 'erfDetail.php?erf_id=12', 0, 7);

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
(12, 'https://www.indomie.com/homepage'),
(15, 'https://www.indomie.com/homepage'),
(16, 'https://www.indomie.com/homepage');

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
(38, 24, 'Beli di toko official', 'do'),
(39, 25, 'Membeli iPhone 13 Pro Max', 'do'),
(40, 25, 'jangan membeli yang lain', 'dont'),
(41, 26, 'Unboxing iPhone 13 Pro Max', 'do'),
(42, 26, 'Unboxing barang lain', 'dont'),
(43, 27, 'Review Jujur', 'do'),
(44, 27, 'Review Bohong', 'dont'),
(45, 28, 'membeli produk', 'do'),
(46, 28, 'datang pada pukul 12.00 - 17.00 WIB', 'do'),
(47, 28, 'Menggunakan dresscode Kuning', 'do'),
(48, 28, 'Telat menyelesaikan tugas', 'dont'),
(49, 28, 'menampilkan produk selain TUKTUKCHA', 'dont'),
(50, 29, 'Beli bebas dimanapun asal bukan produk palsu', 'do'),
(51, 30, 'Beli bebas dimanapun asal bukan produk palsu', 'do');

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
(13, 7, 12),
(14, 9, 12),
(15, 7, 13);

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
(7, 'instagram', 'sahlan_wijaya', '500', 'https://instagram.com/sahlan_wijaya', 14.25),
(8, 'instagram', 'ahd.abd._', '356', 'https://instagram.com/ahd.abd._', 4.25),
(8, 'tiktok', 'abdul.ist', '120', 'https://www.tiktok.com/@abdul.ist?is_from_webapp=1&sender_device=pc', 4.25),
(9, 'instagram', 'alfnmrz', '23000', 'https://instagram.com/alfnmrz', 4.5),
(9, 'tiktok', 'vianmrz', '1200', 'https://www.tiktok.com/@vianmrz', 5);

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
  `brief` text,
  `submission` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`task_id`, `task_name`, `task_deadline`, `task_status`, `erf_id`, `brief`, `submission`) VALUES
(24, 'Make a purchase', '2022-06-25', 'added', 12, 'Beli indomie', NULL),
(25, 'Membeli iPhone 13 Pro max', '2022-06-29', 'added', 13, 'Membeli iPhone 13 Pro Max di iBox', NULL),
(26, 'Unboxing iPhone 13 Pro Max', '2022-07-04', 'added', 13, 'Melakukan Unboxing dan Review', NULL),
(27, 'Review iPhone 13 Pro Max', '2022-07-10', 'added', 13, 'Review Fitur, Performa, dan lain lain', NULL),
(28, 'Purchase Product', '2022-07-20', 'added', 14, 'membeli produk terbaru TUKTUKCHA dan akan mendapatkan buy 1 get 1 free', NULL),
(29, 'Make a purchase', '2022-06-24', 'added', 15, 'Beli indomie kari ayam untuk dipromosikan', NULL),
(30, 'Make a purchase', '2022-06-25', 'added', 16, 'Beli indomie goreng pedas untuk dipromosikan', NULL);

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
(17, 24, 16, NULL, 'not submitted', 12),
(18, 25, 19, NULL, 'not submitted', 13),
(19, 26, 19, NULL, 'not submitted', 13),
(20, 27, 19, NULL, 'not submitted', 13),
(21, 24, 14, '62b27df54497a.png', 'Done', 12),
(22, 29, 17, NULL, 'not submitted', 15),
(23, 30, 18, NULL, 'not submitted', 16);

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
  MODIFY `apply_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `brand_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `brand_notifications`
--
ALTER TABLE `brand_notifications`
  MODIFY `brand_notif_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `erf`
--
ALTER TABLE `erf`
  MODIFY `erf_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `influencer`
--
ALTER TABLE `influencer`
  MODIFY `inf_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `inf_notifications`
--
ALTER TABLE `inf_notifications`
  MODIFY `inf_notif_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `rules_list`
--
ALTER TABLE `rules_list`
  MODIFY `rules_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
--
-- AUTO_INCREMENT for table `saved_erf`
--
ALTER TABLE `saved_erf`
  MODIFY `saved_erf_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `task_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `task_submissions`
--
ALTER TABLE `task_submissions`
  MODIFY `submission_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
