-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 04, 2023 at 11:16 AM
-- Server version: 8.0.31
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test_lampart`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint NOT NULL AUTO_INCREMENT COMMENT 'Đây là khóa chính',
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `status` tinyint NOT NULL COMMENT '-1:delete\r\n1:active',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Category 1', 1, '2023-07-04 18:14:11', '2023-07-04 18:14:11'),
(2, 'Category 2', 1, '2023-07-04 18:14:11', '2023-07-04 18:14:11'),
(3, 'Category 3', 1, '2023-07-04 18:14:11', '2023-07-04 18:14:11'),
(4, 'Category 4', 1, '2023-07-04 18:14:11', '2023-07-04 18:14:11'),
(5, 'Category 5', 1, '2023-07-04 18:14:11', '2023-07-04 18:14:11');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint NOT NULL AUTO_INCREMENT COMMENT 'Đây là khóa chính',
  `category_id` bigint DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `status` tinyint NOT NULL COMMENT '-1:delete\r\n1:active',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Product 1', 'public/uploads/products/file_1688469308.png', 1, '2023-07-04 18:15:08', '2023-07-04 18:15:08'),
(2, 2, 'Product 2', '', 1, '2023-07-04 18:15:18', '2023-07-04 18:15:18'),
(3, 3, 'Product 3', 'public/uploads/products/file_1688469330.png', 1, '2023-07-04 18:15:30', '2023-07-04 18:15:30'),
(4, 4, 'Product 4', '', 1, '2023-07-04 18:15:43', '2023-07-04 18:15:43'),
(5, 5, 'Product 5', '', 1, '2023-07-04 18:15:49', '2023-07-04 18:15:49'),
(6, 1, 'Product 6', 'public/uploads/products/file_1688469356.png', 1, '2023-07-04 18:15:56', '2023-07-04 18:15:56');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
