-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 27, 2025 at 06:02 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fishmonitoring`
--

-- --------------------------------------------------------

--
-- Table structure for table `catches`
--

CREATE TABLE `catches` (
  `id` bigint UNSIGNED NOT NULL,
  `species` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `length_cm` double(8,2) NOT NULL,
  `weight_g` double(8,2) NOT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `catch_datetime` datetime DEFAULT NULL,
  `gear_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `catch_volume` int DEFAULT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `region` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fisherman_registration_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fisherman_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `landing_center` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_sampling` date NOT NULL,
  `time_landing` time NOT NULL,
  `enumerators` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fishing_ground` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `weather_conditions` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `boat_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_motorized` tinyint(1) NOT NULL DEFAULT '1',
  `boat_length` decimal(8,2) NOT NULL,
  `boat_width` decimal(8,2) NOT NULL,
  `boat_depth` decimal(8,2) NOT NULL,
  `gross_tonnage` decimal(10,2) DEFAULT NULL,
  `horsepower` int DEFAULT NULL,
  `engine_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fishermen_count` int NOT NULL,
  `fishing_gear_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gear_specifications` text COLLATE utf8mb4_unicode_ci,
  `hooks_hauls` int DEFAULT NULL,
  `net_line_length` decimal(10,2) DEFAULT NULL,
  `soaking_time` decimal(5,2) DEFAULT NULL,
  `mesh_size` decimal(5,2) DEFAULT NULL,
  `days_fished` int NOT NULL,
  `fishing_location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payao_used` tinyint(1) NOT NULL DEFAULT '0',
  `fishing_effort_notes` text COLLATE utf8mb4_unicode_ci,
  `catch_type` enum('Complete','Incomplete','Partly Sold') COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_catch_kg` decimal(10,2) NOT NULL,
  `subsample_taken` tinyint(1) NOT NULL DEFAULT '0',
  `subsample_weight` decimal(10,2) DEFAULT NULL,
  `below_legal_size` tinyint(1) NOT NULL DEFAULT '0',
  `below_legal_species` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scientific_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `confidence_score` decimal(5,2) DEFAULT NULL,
  `detection_confidence` decimal(5,2) DEFAULT NULL,
  `bbox_width` int DEFAULT NULL,
  `bbox_height` int DEFAULT NULL,
  `pixels_per_cm` decimal(10,4) DEFAULT NULL,
  `fish_length_cm` decimal(8,2) DEFAULT NULL,
  `fish_weight_g` decimal(10,2) DEFAULT NULL,
  `processing_mode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'automatic'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `catches`
--
ALTER TABLE `catches`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `catches`
--
ALTER TABLE `catches`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
