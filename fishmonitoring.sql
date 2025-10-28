-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 24, 2025 at 04:38 PM
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
-- Table structure for table `boats`
--

CREATE TABLE `boats` (
  `id` bigint UNSIGNED NOT NULL,
  `fish_catch_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `length` decimal(10,2) NOT NULL,
  `width` decimal(10,2) NOT NULL,
  `depth` decimal(10,2) NOT NULL,
  `gross_tonnage` decimal(10,2) DEFAULT NULL,
  `horsepower` int DEFAULT NULL,
  `engine_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fishermen_count` int NOT NULL,
  `registration_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `home_port` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `captain_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `captain_license_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `catches`
--

CREATE TABLE `catches` (
  `id` bigint UNSIGNED NOT NULL,
  `fisherman_registration_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fisherman_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
  `landing_center` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_sampling` date DEFAULT NULL,
  `time_landing` time DEFAULT NULL,
  `enumerators` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fishing_ground` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weather_conditions` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `boat_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `boat_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `boat_length` decimal(5,2) DEFAULT NULL,
  `boat_width` decimal(5,2) DEFAULT NULL,
  `boat_depth` decimal(5,2) DEFAULT NULL,
  `gross_tonnage` decimal(8,2) DEFAULT NULL,
  `horsepower` int DEFAULT NULL,
  `engine_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fishermen_count` int DEFAULT NULL,
  `fishing_gear_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gear_specifications` text COLLATE utf8mb4_unicode_ci,
  `hooks_hauls` int DEFAULT NULL,
  `net_line_length` decimal(8,2) DEFAULT NULL,
  `soaking_time` decimal(5,2) DEFAULT NULL,
  `mesh_size` decimal(5,2) DEFAULT NULL,
  `days_fished` int DEFAULT NULL,
  `fishing_location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payao_used` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fishing_effort_notes` text COLLATE utf8mb4_unicode_ci,
  `catch_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_catch_kg` decimal(8,2) DEFAULT NULL,
  `subsample_taken` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subsample_weight` decimal(8,2) DEFAULT NULL,
  `below_legal_size` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `below_legal_species` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scientific_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `confidence_score` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detection_confidence` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bbox_width` int DEFAULT NULL,
  `bbox_height` int DEFAULT NULL,
  `pixels_per_cm` decimal(8,4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `catch_details`
--

CREATE TABLE `catch_details` (
  `id` bigint UNSIGNED NOT NULL,
  `fish_catch_id` bigint UNSIGNED NOT NULL,
  `catch_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `species` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `scientific_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `length_cm` decimal(8,1) DEFAULT NULL,
  `weight_g` decimal(10,1) DEFAULT NULL,
  `total_catch_kg` decimal(10,2) NOT NULL,
  `subsample_taken` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subsample_weight` decimal(10,2) DEFAULT NULL,
  `below_legal_size` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `below_legal_species` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `confidence_score` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detection_confidence` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bbox_width` int DEFAULT NULL,
  `bbox_height` int DEFAULT NULL,
  `pixels_per_cm` decimal(10,4) DEFAULT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fishing_operations`
--

CREATE TABLE `fishing_operations` (
  `id` bigint UNSIGNED NOT NULL,
  `fish_catch_id` bigint UNSIGNED NOT NULL,
  `fishing_gear_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gear_specifications` text COLLATE utf8mb4_unicode_ci,
  `hooks_hauls` int DEFAULT NULL,
  `net_line_length` decimal(10,2) DEFAULT NULL,
  `soaking_time` decimal(10,2) DEFAULT NULL,
  `mesh_size` decimal(10,2) DEFAULT NULL,
  `days_fished` int NOT NULL,
  `fishing_location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payao_used` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fishing_effort_notes` text COLLATE utf8mb4_unicode_ci,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `target_species` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `depth` decimal(10,2) DEFAULT NULL,
  `water_temperature` decimal(5,1) DEFAULT NULL,
  `weather_conditions` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fish_img_datasets`
--

CREATE TABLE `fish_img_datasets` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_07_20_153206_add_address_and_phone_to_users_table', 1),
(6, '2025_07_20_153334_add_profile_image_to_users_table', 1),
(7, '2025_07_21_003036_create_catches_table', 1),
(8, '2025_07_29_041832_add_bfar_fields_to_catches_table', 1),
(9, '2025_08_25_194202_add_fisherman_fields_to_catches_table', 1),
(10, '2025_10_24_160109_create_fish_img_datasets_table', 1),
(11, '2025_10_24_162952_create_boats_table', 1),
(12, '2025_10_24_163023_create_fishing_operations_table', 1),
(13, '2025_10_24_163044_create_catch_details_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'BFAR_PERSONNEL',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`, `address`, `phone`, `profile_image`) VALUES
(1, 'jayjay', 'jayjaynax152@gmail.com', NULL, '$2y$12$8ZmGBvCWQLENdCXb66jLcOhmUaUJda4yocQ9lmz.BB1SExaKujn/2', 'BFAR_PERSONNEL', NULL, '2025-10-24 08:33:33', '2025-10-24 08:33:33', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `boats`
--
ALTER TABLE `boats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `boats_fish_catch_id_foreign` (`fish_catch_id`);

--
-- Indexes for table `catches`
--
ALTER TABLE `catches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `catch_details`
--
ALTER TABLE `catch_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `catch_details_fish_catch_id_foreign` (`fish_catch_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `fishing_operations`
--
ALTER TABLE `fishing_operations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fishing_operations_fish_catch_id_foreign` (`fish_catch_id`);

--
-- Indexes for table `fish_img_datasets`
--
ALTER TABLE `fish_img_datasets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `boats`
--
ALTER TABLE `boats`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `catches`
--
ALTER TABLE `catches`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `catch_details`
--
ALTER TABLE `catch_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fishing_operations`
--
ALTER TABLE `fishing_operations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fish_img_datasets`
--
ALTER TABLE `fish_img_datasets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `boats`
--
ALTER TABLE `boats`
  ADD CONSTRAINT `boats_fish_catch_id_foreign` FOREIGN KEY (`fish_catch_id`) REFERENCES `catches` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `catch_details`
--
ALTER TABLE `catch_details`
  ADD CONSTRAINT `catch_details_fish_catch_id_foreign` FOREIGN KEY (`fish_catch_id`) REFERENCES `catches` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fishing_operations`
--
ALTER TABLE `fishing_operations`
  ADD CONSTRAINT `fishing_operations_fish_catch_id_foreign` FOREIGN KEY (`fish_catch_id`) REFERENCES `catches` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
