-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Oct 31, 2024 at 09:55 AM
-- Server version: 5.7.39
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `academy_laravel_1.4`
--

-- --------------------------------------------------------

--
-- Table structure for table `addtocarts`
--

CREATE TABLE `addtocarts` (
  `id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `description` longtext,
  `document` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `category_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `thumbnail` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `banner` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `keywords` text COLLATE utf8_unicode_ci,
  `is_popular` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subtitle` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_comments`
--

CREATE TABLE `blog_comments` (
  `id` int(11) NOT NULL,
  `blog_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `check` int(11) DEFAULT NULL,
  `comment` longtext COLLATE utf8_unicode_ci,
  `likes` longtext COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_likes`
--

CREATE TABLE `blog_likes` (
  `id` int(255) NOT NULL,
  `blog_id` int(255) DEFAULT NULL,
  `user_id` int(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `bootcamps`
--

CREATE TABLE `bootcamps` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `description` longtext,
  `short_description` text,
  `is_paid` int(11) DEFAULT NULL,
  `price` double(10,2) DEFAULT NULL,
  `discount_flag` int(11) DEFAULT NULL,
  `discounted_price` double(10,2) DEFAULT NULL,
  `publish_date` int(11) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `faqs` longtext,
  `requirements` longtext,
  `outcomes` longtext,
  `meta_keywords` text,
  `meta_description` longtext,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `bootcamp_categories`
--

CREATE TABLE `bootcamp_categories` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `bootcamp_live_classes`
--

CREATE TABLE `bootcamp_live_classes` (
  `id` int(11) NOT NULL,
  `module_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` longtext,
  `start_time` int(11) DEFAULT NULL,
  `end_time` int(11) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `provider` varchar(255) DEFAULT NULL,
  `joining_data` longtext,
  `force_stop` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `bootcamp_modules`
--

CREATE TABLE `bootcamp_modules` (
  `id` int(11) NOT NULL,
  `bootcamp_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `publish_date` int(11) DEFAULT NULL,
  `expiry_date` int(11) DEFAULT NULL,
  `restriction` varchar(255) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `bootcamp_purchases`
--

CREATE TABLE `bootcamp_purchases` (
  `id` int(11) NOT NULL,
  `invoice` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `bootcamp_id` int(11) DEFAULT NULL,
  `price` double(10,2) DEFAULT NULL,
  `tax` double(10,2) DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `payment_details` text,
  `status` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `admin_revenue` double(10,2) DEFAULT NULL,
  `instructor_revenue` double(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `bootcamp_resources`
--

CREATE TABLE `bootcamp_resources` (
  `id` int(11) NOT NULL,
  `module_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `upload_type` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `uploaded_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `builder_pages`
--

CREATE TABLE `builder_pages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `html` longtext,
  `identifier` varchar(255) DEFAULT NULL,
  `is_permanent` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `edit_home_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `builder_pages`
--

INSERT INTO `builder_pages` (`id`, `name`, `html`, `identifier`, `is_permanent`, `status`, `edit_home_id`, `created_at`, `updated_at`) VALUES
(12, 'Elegant', '', 'elegant', 1, 0, NULL, '2024-08-27 04:25:11', '2024-10-31 01:03:56'),
(13, 'Kindergarden', NULL, 'kindergarden', 1, 0, 1, '2024-08-27 04:25:11', '2024-10-31 01:03:56'),
(14, 'Cooking', NULL, 'cooking', 1, 0, 1, '2024-08-27 04:25:11', '2024-10-31 01:03:56'),
(15, 'University', NULL, 'university', 1, 0, 1, '2024-08-27 04:25:11', '2024-10-31 01:03:56'),
(16, 'Language', NULL, 'language', 1, 0, NULL, '2024-08-27 04:25:11', '2024-10-31 01:03:56'),
(17, 'Development', NULL, 'development', 1, 0, 1, '2024-08-27 04:25:11', '2024-10-31 01:03:56'),
(18, 'Marketplace', NULL, 'marketplace', 1, 0, 1, '2024-08-27 04:25:11', '2024-10-31 01:03:56'),
(19, 'Meditation', NULL, 'meditation', 1, 0, 1, '2024-08-27 04:25:11', '2024-10-31 01:03:56'),
(23, 'Default', '[\"top_bar\",\"header\",\"hero_banner\",\"features\",\"category\",\"featured_courses\",\"about_us\",\"testimonial\",\"blog\",\"footer\"]', NULL, NULL, 1, NULL, '2024-08-27 04:25:11', '2024-10-31 01:03:56');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(255) NOT NULL,
  `user_id` int(255) DEFAULT NULL,
  `course_id` int(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  `status` int(11) DEFAULT NULL,
  `keywords` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `certificates`
--

CREATE TABLE `certificates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `course_id` bigint(20) UNSIGNED DEFAULT NULL,
  `identifier` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(21) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8_unicode_ci,
  `message` text COLLATE utf8_unicode_ci,
  `has_read` int(11) DEFAULT '0',
  `replied` int(11) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(255) NOT NULL,
  `user_id` int(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `discount` float(10,2) DEFAULT NULL,
  `expiry` varchar(255) DEFAULT NULL,
  `status` int(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `course_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_paid` int(11) DEFAULT NULL,
  `is_best` int(11) NOT NULL DEFAULT '0',
  `price` double(10,2) DEFAULT NULL,
  `discounted_price` double(10,2) DEFAULT NULL,
  `discount_flag` int(11) DEFAULT NULL,
  `meta_keywords` text COLLATE utf8mb4_unicode_ci,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preview` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` mediumtext COLLATE utf8mb4_unicode_ci,
  `requirements` mediumtext COLLATE utf8mb4_unicode_ci,
  `outcomes` mediumtext COLLATE utf8mb4_unicode_ci,
  `faqs` mediumtext COLLATE utf8mb4_unicode_ci,
  `instructors` text COLLATE utf8mb4_unicode_ci,
  `average_rating` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `symbol` varchar(255) DEFAULT NULL,
  `paypal_supported` int(11) DEFAULT NULL,
  `stripe_supported` int(11) DEFAULT NULL,
  `ccavenue_supported` int(11) DEFAULT '0',
  `iyzico_supported` int(11) DEFAULT '0',
  `paystack_supported` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `name`, `code`, `symbol`, `paypal_supported`, `stripe_supported`, `ccavenue_supported`, `iyzico_supported`, `paystack_supported`) VALUES
(1, 'US Dollar', 'USD', '$', 1, 1, 0, 0, 0),
(2, 'Albanian Lek', 'ALL', 'Lek', 0, 1, 0, 0, 0),
(3, 'Algerian Dinar', 'DZD', 'دج', 1, 1, 0, 0, 0),
(4, 'Angolan Kwanza', 'AOA', 'Kz', 1, 1, 0, 0, 0),
(5, 'Argentine Peso', 'ARS', '$', 1, 1, 0, 0, 0),
(6, 'Armenian Dram', 'AMD', '֏', 1, 1, 0, 0, 0),
(7, 'Aruban Florin', 'AWG', 'ƒ', 1, 1, 0, 0, 0),
(8, 'Australian Dollar', 'AUD', '$', 1, 1, 0, 0, 0),
(9, 'Azerbaijani Manat', 'AZN', 'm', 1, 1, 0, 0, 0),
(10, 'Bahamian Dollar', 'BSD', 'B$', 1, 1, 0, 0, 0),
(11, 'Bahraini Dinar', 'BHD', '.د.ب', 1, 1, 0, 0, 0),
(12, 'Bangladeshi Taka', 'BDT', '৳', 1, 1, 0, 0, 0),
(13, 'Barbadian Dollar', 'BBD', 'Bds$', 1, 1, 0, 0, 0),
(14, 'Belarusian Ruble', 'BYR', 'Br', 0, 0, 0, 0, 0),
(15, 'Belgian Franc', 'BEF', 'fr', 1, 1, 0, 0, 0),
(16, 'Belize Dollar', 'BZD', '$', 1, 1, 0, 0, 0),
(17, 'Bermudan Dollar', 'BMD', '$', 1, 1, 0, 0, 0),
(18, 'Bhutanese Ngultrum', 'BTN', 'Nu.', 1, 1, 0, 0, 0),
(19, 'Bitcoin', 'BTC', '฿', 1, 1, 0, 0, 0),
(20, 'Bolivian Boliviano', 'BOB', 'Bs.', 1, 1, 0, 0, 0),
(21, 'Bosnia', 'BAM', 'KM', 1, 1, 0, 0, 0),
(22, 'Botswanan Pula', 'BWP', 'P', 1, 1, 0, 0, 0),
(23, 'Brazilian Real', 'BRL', 'R$', 1, 1, 0, 0, 0),
(24, 'British Pound Sterling', 'GBP', '£', 1, 1, 0, 0, 0),
(25, 'Brunei Dollar', 'BND', 'B$', 1, 1, 0, 0, 0),
(26, 'Bulgarian Lev', 'BGN', 'Лв.', 1, 1, 0, 0, 0),
(27, 'Burundian Franc', 'BIF', 'FBu', 1, 1, 0, 0, 0),
(28, 'Cambodian Riel', 'KHR', 'KHR', 1, 1, 0, 0, 0),
(29, 'Canadian Dollar', 'CAD', '$', 1, 1, 0, 0, 0),
(30, 'Cape Verdean Escudo', 'CVE', '$', 1, 1, 0, 0, 0),
(31, 'Cayman Islands Dollar', 'KYD', '$', 1, 1, 0, 0, 0),
(32, 'CFA Franc BCEAO', 'XOF', 'CFA', 1, 1, 0, 0, 0),
(33, 'CFA Franc BEAC', 'XAF', 'FCFA', 1, 1, 0, 0, 0),
(34, 'CFP Franc', 'XPF', '₣', 1, 1, 0, 0, 0),
(35, 'Chilean Peso', 'CLP', '$', 1, 1, 0, 0, 0),
(36, 'Chinese Yuan', 'CNY', '¥', 1, 1, 0, 0, 0),
(37, 'Colombian Peso', 'COP', '$', 1, 1, 0, 0, 0),
(38, 'Comorian Franc', 'KMF', 'CF', 1, 1, 0, 0, 0),
(39, 'Congolese Franc', 'CDF', 'FC', 1, 1, 0, 0, 0),
(40, 'Costa Rican ColÃ³n', 'CRC', '₡', 1, 1, 0, 0, 0),
(41, 'Croatian Kuna', 'HRK', 'kn', 1, 1, 0, 0, 0),
(42, 'Cuban Convertible Peso', 'CUC', '$, CUC', 1, 1, 0, 0, 0),
(43, 'Czech Republic Koruna', 'CZK', 'Kč', 1, 1, 0, 0, 0),
(44, 'Danish Krone', 'DKK', 'Kr.', 1, 1, 0, 0, 0),
(45, 'Djiboutian Franc', 'DJF', 'Fdj', 1, 1, 0, 0, 0),
(46, 'Dominican Peso', 'DOP', '$', 1, 1, 0, 0, 0),
(47, 'East Caribbean Dollar', 'XCD', '$', 1, 1, 0, 0, 0),
(48, 'Egyptian Pound', 'EGP', 'ج.م', 1, 1, 0, 0, 0),
(49, 'Eritrean Nakfa', 'ERN', 'Nfk', 1, 1, 0, 0, 0),
(50, 'Estonian Kroon', 'EEK', 'kr', 1, 1, 0, 0, 0),
(51, 'Ethiopian Birr', 'ETB', 'Nkf', 1, 1, 0, 0, 0),
(52, 'Euro', 'EUR', '€', 1, 1, 0, 0, 0),
(53, 'Falkland Islands Pound', 'FKP', '£', 1, 1, 0, 0, 0),
(54, 'Fijian Dollar', 'FJD', 'FJ$', 1, 1, 0, 0, 0),
(55, 'Gambian Dalasi', 'GMD', 'D', 1, 1, 0, 0, 0),
(56, 'Georgian Lari', 'GEL', 'ლ', 1, 1, 0, 0, 0),
(57, 'German Mark', 'DEM', 'DM', 1, 1, 0, 0, 0),
(58, 'Ghanaian Cedi', 'GHS', 'GH₵', 1, 1, 0, 0, 0),
(59, 'Gibraltar Pound', 'GIP', '£', 1, 1, 0, 0, 0),
(60, 'Greek Drachma', 'GRD', '₯, Δρχ, Δρ', 1, 1, 0, 0, 0),
(61, 'Guatemalan Quetzal', 'GTQ', 'Q', 1, 1, 0, 0, 0),
(62, 'Guinean Franc', 'GNF', 'FG', 1, 1, 0, 0, 0),
(63, 'Guyanaese Dollar', 'GYD', '$', 1, 1, 0, 0, 0),
(64, 'Haitian Gourde', 'HTG', 'G', 1, 1, 0, 0, 0),
(65, 'Honduran Lempira', 'HNL', 'L', 1, 1, 0, 0, 0),
(66, 'Hong Kong Dollar', 'HKD', '$', 1, 1, 0, 0, 0),
(67, 'Hungarian Forint', 'HUF', 'Ft', 1, 1, 0, 0, 0),
(68, 'Icelandic KrÃ³na', 'ISK', 'kr', 1, 1, 0, 0, 0),
(69, 'Indian Rupee', 'INR', '₹', 1, 1, 1, 0, 0),
(70, 'Indonesian Rupiah', 'IDR', 'Rp', 1, 1, 0, 0, 0),
(71, 'Iranian Rial', 'IRR', '﷼', 1, 1, 0, 0, 0),
(72, 'Iraqi Dinar', 'IQD', 'د.ع', 1, 1, 0, 0, 0),
(73, 'Israeli New Sheqel', 'ILS', '₪', 1, 1, 0, 0, 0),
(74, 'Italian Lira', 'ITL', 'L,£', 1, 1, 0, 0, 0),
(75, 'Jamaican Dollar', 'JMD', 'J$', 1, 1, 0, 0, 0),
(76, 'Japanese Yen', 'JPY', '¥', 1, 1, 0, 0, 0),
(77, 'Jordanian Dinar', 'JOD', 'ا.د', 1, 1, 0, 0, 0),
(78, 'Kazakhstani Tenge', 'KZT', 'лв', 1, 1, 0, 0, 0),
(79, 'Kenyan Shilling', 'KES', 'KSh', 1, 1, 0, 0, 0),
(80, 'Kuwaiti Dinar', 'KWD', 'ك.د', 1, 1, 0, 0, 0),
(81, 'Kyrgystani Som', 'KGS', 'лв', 1, 1, 0, 0, 0),
(82, 'Laotian Kip', 'LAK', '₭', 1, 1, 0, 0, 0),
(83, 'Latvian Lats', 'LVL', 'Ls', 0, 0, 0, 0, 0),
(84, 'Lebanese Pound', 'LBP', '£', 1, 1, 0, 0, 0),
(85, 'Lesotho Loti', 'LSL', 'L', 1, 1, 0, 0, 0),
(86, 'Liberian Dollar', 'LRD', '$', 1, 1, 0, 0, 0),
(87, 'Libyan Dinar', 'LYD', 'د.ل', 1, 1, 0, 0, 0),
(88, 'Lithuanian Litas', 'LTL', 'Lt', 0, 0, 0, 0, 0),
(89, 'Macanese Pataca', 'MOP', '$', 1, 1, 0, 0, 0),
(90, 'Macedonian Denar', 'MKD', 'ден', 1, 1, 0, 0, 0),
(91, 'Malagasy Ariary', 'MGA', 'Ar', 1, 1, 0, 0, 0),
(92, 'Malawian Kwacha', 'MWK', 'MK', 1, 1, 0, 0, 0),
(93, 'Malaysian Ringgit', 'MYR', 'RM', 1, 1, 0, 0, 0),
(94, 'Maldivian Rufiyaa', 'MVR', 'Rf', 1, 1, 0, 0, 0),
(95, 'Mauritanian Ouguiya', 'MRO', 'MRU', 1, 1, 0, 0, 0),
(96, 'Mauritian Rupee', 'MUR', '₨', 1, 1, 0, 0, 0),
(97, 'Mexican Peso', 'MXN', '$', 1, 1, 0, 0, 0),
(98, 'Moldovan Leu', 'MDL', 'L', 1, 1, 0, 0, 0),
(99, 'Mongolian Tugrik', 'MNT', '₮', 1, 1, 0, 0, 0),
(100, 'Moroccan Dirham', 'MAD', 'MAD', 1, 1, 0, 0, 0),
(101, 'Mozambican Metical', 'MZM', 'MT', 1, 1, 0, 0, 0),
(102, 'Myanmar Kyat', 'MMK', 'K', 1, 1, 0, 0, 0),
(103, 'Namibian Dollar', 'NAD', '$', 1, 1, 0, 0, 0),
(104, 'Nepalese Rupee', 'NPR', '₨', 1, 1, 0, 0, 0),
(105, 'Netherlands Antillean Guilder', 'ANG', 'ƒ', 1, 1, 0, 0, 0),
(106, 'New Taiwan Dollar', 'TWD', '$', 1, 1, 0, 0, 0),
(107, 'New Zealand Dollar', 'NZD', '$', 1, 1, 0, 0, 0),
(108, 'Nicaraguan CÃ³rdoba', 'NIO', 'C$', 1, 1, 0, 0, 0),
(109, 'Nigerian Naira', 'NGN', '₦', 1, 1, 0, 0, 1),
(110, 'North Korean Won', 'KPW', '₩', 0, 0, 0, 0, 0),
(111, 'Norwegian Krone', 'NOK', 'kr', 1, 1, 0, 0, 0),
(112, 'Omani Rial', 'OMR', '.ع.ر', 0, 0, 0, 0, 0),
(113, 'Pakistani Rupee', 'PKR', '₨', 1, 1, 0, 0, 0),
(114, 'Panamanian Balboa', 'PAB', 'B/.', 1, 1, 0, 0, 0),
(115, 'Papua New Guinean Kina', 'PGK', 'K', 1, 1, 0, 0, 0),
(116, 'Paraguayan Guarani', 'PYG', '₲', 1, 1, 0, 0, 0),
(117, 'Peruvian Nuevo Sol', 'PEN', 'S/.', 1, 1, 0, 0, 0),
(118, 'Philippine Peso', 'PHP', '₱', 1, 1, 0, 0, 0),
(119, 'Polish Zloty', 'PLN', 'zł', 1, 1, 0, 0, 0),
(120, 'Qatari Rial', 'QAR', 'ق.ر', 1, 1, 0, 0, 0),
(121, 'Romanian Leu', 'RON', 'lei', 1, 1, 0, 0, 0),
(122, 'Russian Ruble', 'RUB', '₽', 1, 1, 0, 0, 0),
(123, 'Rwandan Franc', 'RWF', 'FRw', 1, 1, 0, 0, 0),
(124, 'Salvadoran ColÃ³n', 'SVC', '₡', 0, 0, 0, 0, 0),
(125, 'Samoan Tala', 'WST', 'SAT', 1, 1, 0, 0, 0),
(126, 'Saudi Riyal', 'SAR', '﷼', 1, 1, 0, 0, 0),
(127, 'Serbian Dinar', 'RSD', 'din', 1, 1, 0, 0, 0),
(128, 'Seychellois Rupee', 'SCR', 'SRe', 1, 1, 0, 0, 0),
(129, 'Sierra Leonean Leone', 'SLL', 'Le', 1, 1, 0, 0, 0),
(130, 'Singapore Dollar', 'SGD', '$', 1, 1, 0, 0, 0),
(131, 'Slovak Koruna', 'SKK', 'Sk', 1, 1, 0, 0, 0),
(132, 'Solomon Islands Dollar', 'SBD', 'Si$', 1, 1, 0, 0, 0),
(133, 'Somali Shilling', 'SOS', 'Sh.so.', 1, 1, 0, 0, 0),
(134, 'South African Rand', 'ZAR', 'R', 1, 1, 0, 0, 0),
(135, 'South Korean Won', 'KRW', '₩', 1, 1, 0, 0, 0),
(136, 'Special Drawing Rights', 'XDR', 'SDR', 1, 1, 0, 0, 0),
(137, 'Sri Lankan Rupee', 'LKR', 'Rs', 1, 1, 0, 0, 0),
(138, 'St. Helena Pound', 'SHP', '£', 1, 1, 0, 0, 0),
(139, 'Sudanese Pound', 'SDG', '.س.ج', 1, 1, 0, 0, 0),
(140, 'Surinamese Dollar', 'SRD', '$', 1, 1, 0, 0, 0),
(141, 'Swazi Lilangeni', 'SZL', 'E', 1, 1, 0, 0, 0),
(142, 'Swedish Krona', 'SEK', 'kr', 1, 1, 0, 0, 0),
(143, 'Swiss Franc', 'CHF', 'CHf', 1, 1, 0, 0, 0),
(144, 'Syrian Pound', 'SYP', 'LS', 0, 0, 0, 0, 0),
(145, 'São Tomé and Príncipe Dobra', 'STD', 'Db', 1, 1, 0, 0, 0),
(146, 'Tajikistani Somoni', 'TJS', 'SM', 1, 1, 0, 0, 0),
(147, 'Tanzanian Shilling', 'TZS', 'TSh', 1, 1, 0, 0, 0),
(148, 'Thai Baht', 'THB', '฿', 1, 1, 0, 0, 0),
(149, 'Tongan pa\'anga', 'TOP', '$', 1, 1, 0, 0, 0),
(150, 'Trinidad & Tobago Dollar', 'TTD', '$', 1, 1, 0, 0, 0),
(151, 'Tunisian Dinar', 'TND', 'ت.د', 1, 1, 0, 0, 0),
(152, 'Turkish Lira', 'TRY', '₺', 1, 1, 0, 1, 0),
(153, 'Turkmenistani Manat', 'TMT', 'T', 1, 1, 0, 0, 0),
(154, 'Ugandan Shilling', 'UGX', 'USh', 1, 1, 0, 0, 0),
(155, 'Ukrainian Hryvnia', 'UAH', '₴', 1, 1, 0, 0, 0),
(156, 'United Arab Emirates Dirham', 'AED', 'إ.د', 1, 1, 0, 0, 0),
(157, 'Uruguayan Peso', 'UYU', '$', 1, 1, 0, 0, 0),
(158, 'Afghan Afghani', 'AFA', '؋', 1, 1, 0, 0, 0),
(159, 'Uzbekistan Som', 'UZS', 'лв', 1, 1, 0, 0, 0),
(160, 'Vanuatu Vatu', 'VUV', 'VT', 1, 1, 0, 0, 0),
(161, 'Venezuelan BolÃvar', 'VEF', 'Bs', 0, 0, 0, 0, 0),
(162, 'Vietnamese Dong', 'VND', '₫', 1, 1, 0, 0, 0),
(163, 'Yemeni Rial', 'YER', '﷼', 1, 1, 0, 0, 0),
(164, 'Zambian Kwacha', 'ZMK', 'ZK', 1, 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `device_ips`
--

CREATE TABLE `device_ips` (
  `id` int(20) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `session_id` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `course_id` bigint(20) UNSIGNED DEFAULT NULL,
  `enrollment_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `entry_date` int(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `expiry_date` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `forums`
--

CREATE TABLE `forums` (
  `id` int(255) NOT NULL,
  `user_id` int(255) DEFAULT NULL,
  `course_id` int(255) DEFAULT NULL,
  `parent_id` int(255) NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `description` longtext,
  `likes` longtext,
  `dislikes` longtext,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `frontend_settings`
--

CREATE TABLE `frontend_settings` (
  `id` int(11) UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` longtext COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `frontend_settings`
--

INSERT INTO `frontend_settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'banner_title', 'Start learning from the world’s pro Instructors', '2023-10-31 11:08:12', '2024-10-27 02:22:09'),
(2, 'banner_sub_title', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum.', '2023-10-31 11:08:12', '2024-10-27 02:22:09'),
(4, 'about_us', '<div>Limitless learning at your fingertips</div><div><br></div><div>Limitless learning at your fingertipsAdvertising a busines online includes assembling the they awesome site. Having the most well-planned on to the our SEO services keep you on the top a business Having the moston to the online.</div><div><br></div><div><br></div><div><br></div><div>Advertising a busines online includes assembling the they awesome site.</div><div><br></div><div><br></div><div>Range including technical skills</div><div>Range including technical skills</div><div>Range including technical skills</div><div><br></div>', '2023-10-31 11:08:12', '2024-10-27 02:22:09'),
(10, 'terms_and_condition', '<h2>Terms and Condition</h2>', '2023-10-31 11:08:12', '2024-10-27 02:22:09'),
(11, 'privacy_policy', '<p></p><p></p><h2><span xss=\"removed\">Privacy Policy</span></h2>', '2023-10-31 11:08:12', '2024-10-27 02:22:09'),
(13, 'theme', 'default', '2023-10-31 11:08:12', '2023-10-31 11:08:12'),
(14, 'cookie_note', 'This website uses cookies to personalize content and analyse traffic in order to offer you a better experience.', '2023-10-31 11:08:12', '2024-10-27 02:22:09'),
(15, 'cookie_status', '0', '2023-10-31 11:08:12', '2024-10-27 02:22:09'),
(16, 'cookie_policy', '<h2 class=\"\">Cookie policy</h2><ol><li>Cookies are small text files that can be used by websites to make a user\'s experience more efficient.</li><li>The law states that we can store cookies on your device if they are strictly necessary for the operation of this site. For all other types of cookies we need your permission.</li><li>This site uses different types of cookies. Some cookies are placed by third party services that appear on our pages.</li></ol>', '2023-10-31 11:08:12', '2024-10-27 02:22:09'),
(17, 'banner_image', 'uploads/banner_image/banner-image.png', '2023-10-31 11:08:12', '2024-05-29 23:12:03'),
(18, 'light_logo', 'uploads/light_logo/light-logo-default.png', '2023-10-31 11:08:12', '2024-05-29 06:23:34'),
(19, 'dark_logo', 'uploads/dark_logo/dark-logo-default.png', '2023-10-31 11:08:12', '2024-05-29 06:23:58'),
(20, 'small_logo', 'uploads/small_logo/small-logo-1712661659.jpg', '2023-10-31 11:08:12', '2024-04-09 05:20:59'),
(21, 'favicon', 'uploads/favicon/favicon-default.png', '2023-10-31 11:08:12', '2024-05-29 06:24:18'),
(22, 'recaptcha_status', '0', '2023-10-31 11:08:12', '2023-11-01 23:27:24'),
(23, 'recaptcha_secretkey', 'Valid-secret-key', '2023-10-31 11:08:12', '2023-11-01 23:27:24'),
(24, 'recaptcha_sitekey', 'Valid-site-key', '2023-10-31 11:08:12', '2023-11-01 23:27:24'),
(25, 'refund_policy', '<h2><span xss=\"removed\">Refund Policy</span></h2>', '2023-10-31 11:08:12', '2024-10-27 02:22:09'),
(26, 'facebook', 'https://facebook.com', '2023-10-31 11:08:12', '2024-10-27 02:22:09'),
(27, 'twitter', 'https://twitter.com', '2023-10-31 11:08:12', '2024-10-27 02:22:09'),
(28, 'linkedin', 'https://linkedin.com', '2023-10-31 11:08:12', '2024-10-27 02:22:09'),
(31, 'blog_page_title', 'Where possibilities begin', '2023-10-31 11:08:12', '2023-10-31 11:08:12'),
(32, 'blog_page_subtitle', 'We’re a leading marketplace platform for learning and teaching online. Explore some of our most popular content and learn something new.', '2023-10-31 11:08:12', '2023-10-31 11:08:12'),
(33, 'blog_page_banner', 'blog-page.png', '2023-10-31 11:08:12', '2023-10-31 11:08:12'),
(34, 'instructors_blog_permission', '1', '2023-10-31 11:08:12', '2023-12-07 00:28:58'),
(35, 'blog_visibility_on_the_home_page', '1', '2023-10-31 11:08:12', '2023-12-07 00:28:58'),
(37, 'website_faqs', '[{\"question\":\"How to create an account?\",\"answer\":\"Interactively procrastinate high-payoff content without backward-compatible data. Quickly to cultivate optimal processes and tactical architectures. For The Completely iterate covalent strategic.\"},{\"question\":\"Do you provide any support for this kit?\",\"answer\":\"Interactively procrastinate high-payoff content without backward-compatible data. Quickly to cultivate optimal processes and tactical architectures. For The Completely iterate covalent strategic.\"},{\"question\":\"How to create an account?\",\"answer\":\"Interactively procrastinate high-payoff content without backward-compatible data. Quickly to cultivate optimal processes and tactical architectures. For The Completely iterate covalent strategic.\"},{\"question\":\"How long do you provide support?\",\"answer\":\"Interactively procrastinate high-payoff content without backward-compatible data. Quickly to cultivate optimal processes and tactical architectures. For The Completely iterate covalent strategic.\"}]', '2023-10-31 11:08:12', '2024-09-11 04:57:12'),
(38, 'motivational_speech', '[{\"title\":\"Jenny Murtagh\",\"designation\":\"Graphic Design\",\"description\":\"Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even for slightly believable randomised words.\",\"image\":\"I6zvV1Mr30YUhLfJgwje.png\"},{\"title\":\"Jenny Murtagh\",\"designation\":\"Graphic Design\",\"description\":\"Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even for slightly believable randomised words.\",\"image\":\"ZLfkhGame7sYQvqKxD0J.png\"},{\"title\":\"Jenny Murtagh\",\"designation\":\"Graphic Design\",\"description\":\"Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even for slightly believable randomised words.\",\"image\":\"xBYkXnfvmPiU3j0CzME1.png\"}]', '2023-10-31 11:08:12', '2024-09-11 04:57:18'),
(39, 'home_page', NULL, '2023-10-31 11:08:12', '2024-10-31 01:03:56'),
(40, 'contact_info', '{\"email\":\"creativeitem@example.com\",\"phone\":\"67564345676\",\"address\":\"629 12th St, Modesto\",\"office_hours\":\"8\",\"location\":\"40.689880, -74.045203\"}', '2023-10-31 11:08:12', '2024-09-11 04:57:26'),
(41, 'promo_video_provider', 'youtube', '2023-10-31 11:08:12', '2024-10-27 02:22:09'),
(42, 'promo_video_link', 'https://youtu.be/4QCaXTOwigw?si=NsFeBQhWNZC859-l', '2023-10-31 11:08:12', '2024-10-27 02:22:09'),
(43, 'mobile_app_link', 'https://youtu.be/4QCaXTOwigw?si=NsFeBQhWNZC859-l', '2023-10-31 11:08:12', '2024-10-27 02:22:09');

-- --------------------------------------------------------

--
-- Table structure for table `home_page_settings`
--

CREATE TABLE `home_page_settings` (
  `id` int(11) NOT NULL,
  `home_page_id` int(11) DEFAULT NULL,
  `key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` longtext COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `home_page_settings`
--

INSERT INTO `home_page_settings` (`id`, `home_page_id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 14, 'cooking', '{\"title\":\"Become An Instructor\",\"description\":\"Training programs can bring you a super exciting experience of learning through online! You never face any negative experience while enjoying your classes.\\r\\n\\r\\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc vulputate ad litora torquent Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc vulputate ad litora torquent per conubi himenaeos Awesome site Lorem Ipsum has been the industry\'s standard dummy text ever since the unknown printer took a galley of type and scrambled.\\r\\n\\r\\nConsectetur adipiscing elit. Nunc vulputate ad litora torquent per conubi himenaeos Awesome site Lorem Ipsum has been the industry\'s standard dummy text ever since.\",\"video_url\":\"https:\\/\\/www.youtube.com\\/watch?v=iTlsP6RfCQ8\",\"image\":\"instructor_image.jpg\"}', '2024-05-15 09:43:54', '2024-10-28 05:14:50'),
(3, 15, 'university', '{\"image\":\"default-university.webp\",\"faq_image\":\"default-university2.webp\",\"slider_items\":\"[\\\"https:\\\\\\/\\\\\\/www.youtube.com\\\\\\/watch?v=iTlsP6RfCQ8\\\"]\"}', '2024-05-16 02:31:00', '2024-09-24 06:09:07'),
(4, 17, 'development', '{\"title\":\"Leading the Way in Software Development\",\"description\":\"Far far away, behind the word mountains, far from the away countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.\\r\\nTraining programs can bring you a super exciting experience of learning through online! You never face any negative experience while enjoying your classes. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc vulputate ad litora torquent\",\"video_url\":null,\"image\":\"default-dev-banner.webp\"}', '2024-05-18 05:40:13', '2024-05-18 08:08:06'),
(5, 13, 'kindergarden', '{\"title\":\"Creating A Community Of Life Long Learners\",\"description\":\"Training programs can bring you a super exciting experience of learning through online! You never face any negative experience while enjoying your classes.\\r\\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc vulputate ad litora torquent\\r\\nTraining programs can bring you a super exciting experience of learning through online! You never face any negative experience while enjoying your classes. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc vulputate ad litora torquent\",\"video_url\":null,\"image\":\"default-community-banner.webp\"}', '2024-05-18 08:02:45', '2024-05-18 08:07:59'),
(6, 18, 'marketplace', '{\"instructor\":{\"title\":\"Become an instructor\",\"description\":\"Training programs can bring you a super exciting experience of learning through online! You never face any negative experience while enjoying your classes.\\r\\n\\r\\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc vulputate ad litora torquent Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc vulputate ad litora torquent per conubi himenaeos Awesome site Lorem Ipsum has been the industry\'s standard dummy text ever since the unknown printer took a galley of type and scrambled.\\r\\n\\r\\nConsectetur adipiscing elit. Nunc vulputate ad litora torquent per conubi himenaeos Awesome site Lorem Ipsum has been the industry\'s standard dummy text ever sinces.\",\"video_url\":\"https:\\/\\/www.youtube.com\\/watch?v=i-rv4VQiBko\",\"image\":\"default-video-area-banner.webp\"},\"slider\":[{\"banner_title\":\"LEARN FROM TODAY\",\"banner_description\":\"Academy Starter is a community for creative people\"},{\"banner_title\":\"LEARN FROM TODAY\",\"banner_description\":\"Academy Starter is a community for creative people\"},{\"banner_title\":\"LEARN FROM TODAY\",\"banner_description\":\"Academy Starter is a community for creative people\"},{\"banner_title\":\"LEARN FROM TODAY\",\"banner_description\":\"Academy Starter is a community for creative people\"}]}', '2024-05-18 22:55:44', '2024-05-20 01:22:25'),
(7, 19, 'meditation', '{\"big_image\":\"664b020ed2bbb.png\",\"meditation\":[{\"banner_title\":\"Balance Body & Mind\",\"image\":\"664b07fa650dd.yoga-benefit-1.svg\",\"banner_description\":\"It is a long established fact that a reader will be distracted by the readable content.\"},{\"banner_title\":\"Balance Body & Minds\",\"image\":\"664b08157c7ed.yoga-benefit-2.svg\",\"banner_description\":\"It is a long established fact that a reader will be distracted by the readable content.\"},{\"banner_title\":\"Balance Body & Mind\",\"image\":\"664b08157cab8.yoga-benefit-3.svg\",\"banner_description\":\"It is a long established fact that a reader will be distracted by the readable content.\"},{\"banner_title\":\"Balance Body & Mind\",\"image\":\"664b08157d2be.yoga-benefit-4.svg\",\"banner_description\":\"It is a long established fact that a reader will be distracted by the readable content.\"},{\"banner_title\":\"Balance Body & Mind\",\"image\":\"664b08263ba18.yoga-benefit-5.svg\",\"banner_description\":\"It is a long established fact that a reader will be distracted by the readable content.\"},{\"banner_title\":\"Balance Body & Minddf\",\"image\":\"664b08263bcca.yoga-benefit-6.svg\",\"banner_description\":\"It is a long established fact that a reader will be distracted by the readable content.\"}]}', '2024-05-19 23:54:56', '2024-05-20 02:21:58');

-- --------------------------------------------------------

--
-- Table structure for table `instructor_reviews`
--

CREATE TABLE `instructor_reviews` (
  `id` int(255) NOT NULL,
  `user_id` int(255) DEFAULT NULL,
  `instructor_id` int(255) DEFAULT NULL,
  `rating` varchar(244) DEFAULT NULL,
  `review` longtext,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direction` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `direction`, `created_at`, `updated_at`) VALUES
(3, 'English', 'ltr', '2024-04-08 10:42:26', '2024-04-09 01:12:02');

-- --------------------------------------------------------

--
-- Table structure for table `language_phrases`
--

CREATE TABLE `language_phrases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `language_id` bigint(20) UNSIGNED DEFAULT NULL,
  `phrase` text COLLATE utf8mb4_unicode_ci,
  `translated` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `language_phrases`
--

INSERT INTO `language_phrases` (`id`, `language_id`, `phrase`, `translated`, `created_at`, `updated_at`) VALUES
(1, 3, 'Log In', 'Log In', NULL, NULL),
(2, 3, 'Login', 'Login', NULL, NULL),
(3, 3, 'See your growth and get consulting support!', 'See your growth and get consulting support!', NULL, NULL),
(4, 3, 'Email', 'Email', NULL, NULL),
(5, 3, 'Your Email', 'Your Email', NULL, NULL),
(6, 3, 'Password', 'Password', NULL, NULL),
(7, 3, 'Remember Me', 'Remember Me', NULL, NULL),
(8, 3, 'Forget Password?', 'Forget Password?', NULL, NULL),
(9, 3, 'Not have an account yet?', 'Not have an account yet?', NULL, NULL),
(10, 3, 'Create Account', 'Create Account', NULL, NULL),
(11, 3, 'Home', 'Home', NULL, NULL),
(12, 3, 'Courses', 'Courses', NULL, NULL),
(13, 3, 'All Courses', 'All Courses', NULL, NULL),
(14, 3, 'Bootcamp', 'Bootcamp', NULL, NULL),
(15, 3, 'Search...', 'Search...', NULL, NULL),
(16, 3, 'Search courses', 'Search courses', NULL, NULL),
(17, 3, 'Cart', 'Cart', NULL, NULL),
(18, 3, 'Sign Up', 'Sign Up', NULL, NULL),
(19, 3, 'Contact with Us', 'Contact with Us', NULL, NULL),
(20, 3, 'Top Categories', 'Top Categories', NULL, NULL),
(21, 3, 'Useful links', 'Useful links', NULL, NULL),
(22, 3, 'Course', 'Course', NULL, NULL),
(23, 3, 'Blog', 'Blog', NULL, NULL),
(24, 3, 'Company', 'Company', NULL, NULL),
(25, 3, 'Phone : ', 'Phone : ', NULL, NULL),
(26, 3, 'Email : ', 'Email : ', NULL, NULL),
(27, 3, 'Email address', 'Email address', NULL, NULL),
(28, 3, 'Submit', 'Submit', NULL, NULL),
(29, 3, 'About Us', 'About Us', NULL, NULL),
(30, 3, 'Privacy Policy', 'Privacy Policy', NULL, NULL),
(31, 3, 'Terms And Use', 'Terms And Use', NULL, NULL),
(32, 3, 'Sales and Refunds', 'Sales and Refunds', NULL, NULL),
(33, 3, 'FAQ', 'FAQ', NULL, NULL),
(34, 3, 'Close', 'Close', NULL, NULL),
(35, 3, 'Are you sure?', 'Are you sure?', NULL, NULL),
(36, 3, 'You can\'t bring it back!', 'You can\'t bring it back!', NULL, NULL),
(37, 3, 'Cancel', 'Cancel', NULL, NULL),
(38, 3, 'Yes, I\'m sure', 'Yes, I\'m sure', NULL, NULL),
(39, 3, 'Just Now', 'Just Now', NULL, NULL),
(40, 3, 'Success !', 'Success !', NULL, NULL),
(41, 3, 'Attention !', 'Attention !', NULL, NULL),
(42, 3, 'An Error Occurred !', 'An Error Occurred !', NULL, NULL),
(43, 3, 'Remove from wishlist', 'Remove from wishlist', NULL, NULL),
(44, 3, 'This course added to your wishlist', 'This course added to your wishlist', NULL, NULL),
(45, 3, 'Add to wishlist', 'Add to wishlist', NULL, NULL),
(46, 3, 'This course removed from your wishlist', 'This course removed from your wishlist', NULL, NULL),
(47, 3, 'Enter your keywords', 'Enter your keywords', NULL, NULL),
(48, 3, 'Show less', 'Show less', NULL, NULL),
(49, 3, 'Show more', 'Show more', NULL, NULL),
(50, 3, 'Showing', 'Showing', NULL, NULL),
(51, 3, 'of', 'of', NULL, NULL),
(52, 3, 'data', 'data', NULL, NULL),
(53, 3, 'Grid', 'Grid', NULL, NULL),
(54, 3, 'List', 'List', NULL, NULL),
(55, 3, 'Filter', 'Filter', NULL, NULL),
(56, 3, 'Categories', 'Categories', NULL, NULL),
(57, 3, 'Price', 'Price', NULL, NULL),
(58, 3, 'Paid', 'Paid', NULL, NULL),
(59, 3, 'Discount', 'Discount', NULL, NULL),
(60, 3, 'Free', 'Free', NULL, NULL),
(61, 3, 'Level', 'Level', NULL, NULL),
(62, 3, 'Beginner', 'Beginner', NULL, NULL),
(63, 3, 'Intermediate', 'Intermediate', NULL, NULL),
(64, 3, 'Advanced', 'Advanced', NULL, NULL),
(65, 3, 'language', 'language', NULL, NULL),
(66, 3, 'English', 'English', NULL, NULL),
(67, 3, 'Spanish', 'Spanish', NULL, NULL),
(68, 3, 'Italic', 'Italic', NULL, NULL),
(69, 3, 'German', 'German', NULL, NULL),
(70, 3, 'Ratings', 'Ratings', NULL, NULL),
(71, 3, 'No data found !', 'No data found !', NULL, NULL),
(72, 3, 'Please attempt utilizing the suitable keywords in your search query to obtain more precise results.', 'Please attempt utilizing the suitable keywords in your search query to obtain more precise results.', NULL, NULL),
(73, 3, 'Back', 'Back', NULL, NULL),
(74, 3, 'Dashboard', 'Dashboard', NULL, NULL),
(75, 3, 'Number of Courses', 'Number of Courses', NULL, NULL),
(76, 3, 'Number of Lessons', 'Number of Lessons', NULL, NULL),
(77, 3, 'Number of Enrollment', 'Number of Enrollment', NULL, NULL),
(78, 3, 'Number of Students', 'Number of Students', NULL, NULL),
(79, 3, 'Number of Instructor', 'Number of Instructor', NULL, NULL),
(80, 3, 'Admin Revenue This Year', 'Admin Revenue This Year', NULL, NULL),
(81, 3, 'Admin Revenue', 'Admin Revenue', NULL, NULL),
(82, 3, 'Course Status', 'Course Status', NULL, NULL),
(83, 3, 'Explore Courses', 'Explore Courses', NULL, NULL),
(84, 3, 'Active', 'Active', NULL, NULL),
(85, 3, 'Upcoming', 'Upcoming', NULL, NULL),
(86, 3, 'Pending', 'Pending', NULL, NULL),
(87, 3, 'Private', 'Private', NULL, NULL),
(88, 3, 'Draft', 'Draft', NULL, NULL),
(89, 3, 'Inactive', 'Inactive', NULL, NULL),
(90, 3, 'Pending Requested withdrawal', 'Pending Requested withdrawal', NULL, NULL),
(91, 3, 'Instructor Payout', 'Instructor Payout', NULL, NULL),
(92, 3, 'Main Menu', 'Main Menu', NULL, NULL),
(93, 3, 'Category', 'Category', NULL, NULL),
(94, 3, 'Manage Courses', 'Manage Courses', NULL, NULL),
(95, 3, 'Add New Course', 'Add New Course', NULL, NULL),
(96, 3, 'Coupons', 'Coupons', NULL, NULL),
(97, 3, 'Manage Bootcamps', 'Manage Bootcamps', NULL, NULL),
(98, 3, 'Add New Bootcamp', 'Add New Bootcamp', NULL, NULL),
(99, 3, 'Purchase History', 'Purchase History', NULL, NULL),
(100, 3, 'Student enrollment', 'Student enrollment', NULL, NULL),
(101, 3, 'Course enrollment', 'Course enrollment', NULL, NULL),
(102, 3, 'Enrollment History', 'Enrollment History', NULL, NULL),
(103, 3, 'Enroll student', 'Enroll student', NULL, NULL),
(104, 3, 'Payment Report', 'Payment Report', NULL, NULL),
(105, 3, 'Offline payments', 'Offline payments', NULL, NULL),
(106, 3, 'Instructor Revenue', 'Instructor Revenue', NULL, NULL),
(107, 3, 'Payment History', 'Payment History', NULL, NULL),
(108, 3, 'Users', 'Users', NULL, NULL),
(109, 3, 'Admin', 'Admin', NULL, NULL),
(110, 3, 'Manage Admin', 'Manage Admin', NULL, NULL),
(111, 3, 'Add New Admin', 'Add New Admin', NULL, NULL),
(112, 3, 'Instructor', 'Instructor', NULL, NULL),
(113, 3, 'Manage Instructors', 'Manage Instructors', NULL, NULL),
(114, 3, 'Add new Instructor', 'Add new Instructor', NULL, NULL),
(115, 3, 'Instructor Setting', 'Instructor Setting', NULL, NULL),
(116, 3, 'Application', 'Application', NULL, NULL),
(117, 3, 'Student', 'Student', NULL, NULL),
(118, 3, 'Manage Students', 'Manage Students', NULL, NULL),
(119, 3, 'Add new Student', 'Add new Student', NULL, NULL),
(120, 3, 'Message', 'Message', NULL, NULL),
(121, 3, 'Newsletter', 'Newsletter', NULL, NULL),
(122, 3, 'Manage Newsletters', 'Manage Newsletters', NULL, NULL),
(123, 3, 'Subscribed User', 'Subscribed User', NULL, NULL),
(124, 3, 'Contacts', 'Contacts', NULL, NULL),
(125, 3, 'Blogs', 'Blogs', NULL, NULL),
(126, 3, 'Manage Blogs', 'Manage Blogs', NULL, NULL),
(127, 3, 'Pending Blogs', 'Pending Blogs', NULL, NULL),
(128, 3, 'Settings', 'Settings', NULL, NULL),
(129, 3, 'System Settings', 'System Settings', NULL, NULL),
(130, 3, 'Website Settings', 'Website Settings', NULL, NULL),
(131, 3, 'Payment Settings', 'Payment Settings', NULL, NULL),
(132, 3, 'Manage Language', 'Manage Language', NULL, NULL),
(133, 3, 'Live Class Settings', 'Live Class Settings', NULL, NULL),
(134, 3, 'SMTP Settings', 'SMTP Settings', NULL, NULL),
(135, 3, 'Certificate Settings', 'Certificate Settings', NULL, NULL),
(136, 3, 'Player Settings', 'Player Settings', NULL, NULL),
(137, 3, 'Open AI Settings', 'Open AI Settings', NULL, NULL),
(138, 3, 'Home Page Builder', 'Home Page Builder', NULL, NULL),
(139, 3, 'SEO Settings', 'SEO Settings', NULL, NULL),
(140, 3, 'About', 'About', NULL, NULL),
(141, 3, 'Manage Profile', 'Manage Profile', NULL, NULL),
(142, 3, 'Admin Panel', 'Admin Panel', NULL, NULL),
(143, 3, 'View site', 'View site', NULL, NULL),
(144, 3, 'AI Assistant', 'AI Assistant', NULL, NULL),
(145, 3, 'Help Center', 'Help Center', NULL, NULL),
(146, 3, 'Read documentation', 'Read documentation', NULL, NULL),
(147, 3, 'Watch video tutorial', 'Watch video tutorial', NULL, NULL),
(148, 3, 'Get customer support', 'Get customer support', NULL, NULL),
(149, 3, 'Order customization', 'Order customization', NULL, NULL),
(150, 3, 'Request a new feature', 'Request a new feature', NULL, NULL),
(151, 3, 'Get Services', 'Get Services', NULL, NULL),
(152, 3, 'My Profile', 'My Profile', NULL, NULL),
(153, 3, 'Sign Out', 'Sign Out', NULL, NULL),
(154, 3, 'Confirm', 'Confirm', NULL, NULL),
(155, 3, 'Loading', 'Loading', NULL, NULL),
(156, 3, 'Website name', 'Website name', NULL, NULL),
(157, 3, 'Website title', 'Website title', NULL, NULL),
(158, 3, 'Website keywords', 'Website keywords', NULL, NULL),
(159, 3, 'Website description', 'Website description', NULL, NULL),
(160, 3, 'Author', 'Author', NULL, NULL),
(161, 3, 'Slogan', 'Slogan', NULL, NULL),
(162, 3, 'System email', 'System email', NULL, NULL),
(163, 3, 'Address', 'Address', NULL, NULL),
(164, 3, 'Phone', 'Phone', NULL, NULL),
(165, 3, 'Youtube API key', 'Youtube API key', NULL, NULL),
(166, 3, 'Get YouTube API key', 'Get YouTube API key', NULL, NULL),
(167, 3, 'If you want to use Google Drive video, you need to enable the Google Drive service in this API', 'If you want to use Google Drive video, you need to enable the Google Drive service in this API', NULL, NULL),
(168, 3, 'Vimeo API key', 'Vimeo API key', NULL, NULL),
(169, 3, 'get Vimeo API key', 'get Vimeo API key', NULL, NULL),
(170, 3, 'Purchase code', 'Purchase code', NULL, NULL),
(171, 3, 'System language', 'System language', NULL, NULL),
(172, 3, 'Course selling tax', 'Course selling tax', NULL, NULL),
(173, 3, 'Enter 0 if you want to disable the tax option', 'Enter 0 if you want to disable the tax option', NULL, NULL),
(174, 3, 'Device limitation', 'Device limitation', NULL, NULL),
(175, 3, 'Footer text', 'Footer text', NULL, NULL),
(176, 3, 'Footer link', 'Footer link', NULL, NULL),
(177, 3, 'Save Changes', 'Save Changes', NULL, NULL),
(178, 3, 'Update Product', 'Update Product', NULL, NULL),
(179, 3, 'File', 'File', NULL, NULL),
(180, 3, 'Update', 'Update', NULL, NULL),
(181, 3, 'Version updated successfully', 'Version updated successfully', NULL, NULL),
(182, 3, 'Select your service', 'Select your service', NULL, NULL),
(183, 3, 'Course title', 'Course title', NULL, NULL),
(184, 3, 'Course short description', 'Course short description', NULL, NULL),
(185, 3, 'Course long description', 'Course long description', NULL, NULL),
(186, 3, 'Course requirements', 'Course requirements', NULL, NULL),
(187, 3, 'Course outcomes', 'Course outcomes', NULL, NULL),
(188, 3, 'Course faq', 'Course faq', NULL, NULL),
(189, 3, 'Course seo tags', 'Course seo tags', NULL, NULL),
(190, 3, 'Course lesson text', 'Course lesson text', NULL, NULL),
(191, 3, 'Course certificate text', 'Course certificate text', NULL, NULL),
(192, 3, 'Course quiz text', 'Course quiz text', NULL, NULL),
(193, 3, 'Course blog title', 'Course blog title', NULL, NULL),
(194, 3, 'Course blog post', 'Course blog post', NULL, NULL),
(195, 3, 'Course thumbnail', 'Course thumbnail', NULL, NULL),
(196, 3, 'Enter your keyword', 'Enter your keyword', NULL, NULL),
(197, 3, 'Generate', 'Generate', NULL, NULL),
(198, 3, 'Generating', 'Generating', NULL, NULL),
(199, 3, 'Your images', 'Your images', NULL, NULL),
(200, 3, 'Generated text', 'Generated text', NULL, NULL),
(201, 3, 'Copy', 'Copy', NULL, NULL),
(202, 3, 'Copied', 'Copied', NULL, NULL),
(203, 3, 'Not found', 'Not found', NULL, NULL),
(204, 3, 'About This Application', 'About This Application', NULL, NULL),
(205, 3, 'Software version', 'Software version', NULL, NULL),
(206, 3, 'Laravel version', 'Laravel version', NULL, NULL),
(207, 3, 'Check update', 'Check update', NULL, NULL),
(208, 3, 'Php version', 'Php version', NULL, NULL),
(209, 3, 'Curl enable', 'Curl enable', NULL, NULL),
(210, 3, 'enabled', 'enabled', NULL, NULL),
(211, 3, 'Product license', 'Product license', NULL, NULL),
(212, 3, 'Enter valid purchase code', 'Enter valid purchase code', NULL, NULL),
(213, 3, 'Customer support status', 'Customer support status', NULL, NULL),
(214, 3, 'Support expiry date', 'Support expiry date', NULL, NULL),
(215, 3, 'Customer name', 'Customer name', NULL, NULL),
(216, 3, 'Customer support', 'Customer support', NULL, NULL),
(217, 3, 'Payment setting', 'Payment setting', NULL, NULL),
(218, 3, 'Currency Settings', 'Currency Settings', NULL, NULL),
(219, 3, 'Heads up !!', 'Heads up !!', NULL, NULL),
(220, 3, 'Ensure that the system currency and all active payment gateway currencies are same', 'Ensure that the system currency and all active payment gateway currencies are same', NULL, NULL),
(221, 3, 'Select currency', 'Select currency', NULL, NULL),
(222, 3, 'Currency position', 'Currency position', NULL, NULL),
(223, 3, 'Left', 'Left', NULL, NULL),
(224, 3, 'Right', 'Right', NULL, NULL),
(225, 3, 'Left with a space', 'Left with a space', NULL, NULL),
(226, 3, 'Right with a space', 'Right with a space', NULL, NULL),
(227, 3, 'No', 'No', NULL, NULL),
(228, 3, 'Yes', 'Yes', NULL, NULL),
(229, 3, 'Want to keep test mode enabled', 'Want to keep test mode enabled', NULL, NULL),
(230, 3, 'sandbox client id', 'sandbox client id', NULL, NULL),
(231, 3, 'sandbox secret key', 'sandbox secret key', NULL, NULL),
(232, 3, 'production client id', 'production client id', NULL, NULL),
(233, 3, 'production secret key', 'production secret key', NULL, NULL),
(234, 3, 'setting', 'setting', NULL, NULL),
(235, 3, 'public key', 'public key', NULL, NULL),
(236, 3, 'secret key', 'secret key', NULL, NULL),
(237, 3, 'public live key', 'public live key', NULL, NULL),
(238, 3, 'secret live key', 'secret live key', NULL, NULL),
(239, 3, 'Choose an option', 'Choose an option', NULL, NULL),
(240, 3, 'bank information', 'bank information', NULL, NULL),
(241, 3, 'secret test key', 'secret test key', NULL, NULL),
(242, 3, 'public test key', 'public test key', NULL, NULL),
(243, 3, 'Cookie Policy', 'Cookie Policy', NULL, NULL),
(244, 3, 'Accept', 'Accept', NULL, NULL),
(245, 3, 'Learn More', 'Learn More', NULL, NULL),
(246, 3, 'Students has Enrolled', 'Students has Enrolled', NULL, NULL),
(247, 3, 'Page Builder', 'Page Builder', NULL, NULL),
(248, 3, 'Create Page', 'Create Page', NULL, NULL),
(249, 3, '#', '#', NULL, NULL),
(250, 3, 'Page Name', 'Page Name', NULL, NULL),
(251, 3, 'Status', 'Status', NULL, NULL),
(252, 3, 'Action', 'Action', NULL, NULL),
(253, 3, 'Edit Home Page', 'Edit Home Page', NULL, NULL),
(254, 3, 'Edit Home', 'Edit Home', NULL, NULL),
(255, 3, 'Preview', 'Preview', NULL, NULL),
(256, 3, 'Edit Layout', 'Edit Layout', NULL, NULL),
(257, 3, 'Edit Page', 'Edit Page', NULL, NULL),
(258, 3, 'Edit', 'Edit', NULL, NULL),
(259, 3, 'Delete', 'Delete', NULL, NULL),
(260, 3, 'Home page activated', 'Home page activated', NULL, NULL),
(261, 3, 'The Leader in online learning', 'The Leader in online learning', NULL, NULL),
(262, 3, 'Get Started', 'Get Started', NULL, NULL),
(263, 3, 'Special Featured Course', 'Special Featured Course', NULL, NULL),
(264, 3, 'Those course highlights a handpicked course with exceptional content or exclusive offerings.', 'Those course highlights a handpicked course with exceptional content or exclusive offerings.', NULL, NULL),
(265, 3, 'Why Choose Us', 'Why Choose Us', NULL, NULL),
(266, 3, 'Happy student', 'Happy student', NULL, NULL),
(267, 3, 'Quality educators', 'Quality educators', NULL, NULL),
(268, 3, 'Premium courses', 'Premium courses', NULL, NULL),
(269, 3, 'Cost-free course', 'Cost-free course', NULL, NULL),
(270, 3, 'Top Rated Course', 'Top Rated Course', NULL, NULL),
(271, 3, 'Top rated course showcases the highest-rated course based on student reviews and performance metrics.', 'Top rated course showcases the highest-rated course based on student reviews and performance metrics.', NULL, NULL),
(272, 3, 'What the people Thinks About Us', 'What the people Thinks About Us', NULL, NULL),
(273, 3, 'It highlights feedback and testimonials from users, reflecting their experiences and satisfaction.', 'It highlights feedback and testimonials from users, reflecting their experiences and satisfaction.', NULL, NULL),
(274, 3, 'Frequently Asked Questions', 'Frequently Asked Questions', NULL, NULL),
(275, 3, 'Our Latest Blog', 'Our Latest Blog', NULL, NULL),
(276, 3, 'The latest blog highlights the most recent articles, updates, and insights from our platform.', 'The latest blog highlights the most recent articles, updates, and insights from our platform.', NULL, NULL),
(277, 3, 'Wishlist', 'Wishlist', NULL, NULL),
(278, 3, 'Log Out', 'Log Out', NULL, NULL),
(279, 3, 'Logout', 'Logout', NULL, NULL),
(280, 3, 'Admin Dashboard', 'Admin Dashboard', NULL, NULL),
(281, 3, 'It is a long established fact that a reader will be the distract by the read content of a page layout', 'It is a long established fact that a reader will be the distract by the read content of a page layout', NULL, NULL),
(282, 3, 'Subscribe to stay tuned for new web design and latest updates. Let\'s do it!', 'Subscribe to stay tuned for new web design and latest updates. Let\'s do it!', NULL, NULL),
(283, 3, '© 2024 All Rights Reserved', '© 2024 All Rights Reserved', NULL, NULL),
(284, 3, '404 not found', '404 not found', NULL, NULL),
(285, 3, 'The page you requested could not be found', 'The page you requested could not be found', NULL, NULL),
(286, 3, 'Please try the following', 'Please try the following', NULL, NULL),
(287, 3, 'Check the spelling of the url', 'Check the spelling of the url', NULL, NULL),
(288, 3, 'If you are still puzzled, click on the home link below', 'If you are still puzzled, click on the home link below', NULL, NULL),
(289, 3, 'Back to home', 'Back to home', NULL, NULL),
(290, 3, 'Become An Instructor', 'Become An Instructor', NULL, NULL),
(291, 3, 'Title', 'Title', NULL, NULL),
(292, 3, 'Description', 'Description', NULL, NULL),
(293, 3, 'Video Url', 'Video Url', NULL, NULL),
(294, 3, 'Image', 'Image', NULL, NULL),
(295, 3, 'Banner Information', 'Banner Information', NULL, NULL),
(296, 3, 'Add new', 'Add new', NULL, NULL),
(297, 3, 'Remove', 'Remove', NULL, NULL),
(298, 3, 'Video Link', 'Video Link', NULL, NULL),
(299, 3, 'Youtube', 'Youtube', NULL, NULL),
(300, 3, 'HTML5', 'HTML5', NULL, NULL),
(301, 3, 'All Category', 'All Category', NULL, NULL),
(302, 3, 'Add new category', 'Add new category', NULL, NULL),
(303, 3, 'Category Name', 'Category Name', NULL, NULL),
(304, 3, 'Enter your category name', 'Enter your category name', NULL, NULL),
(305, 3, 'Enter your unique category name', 'Enter your unique category name', NULL, NULL),
(306, 3, 'Pick Your Icon', 'Pick Your Icon', NULL, NULL),
(307, 3, 'Pick your category icon', 'Pick your category icon', NULL, NULL),
(308, 3, 'Keywords', 'Keywords', NULL, NULL),
(309, 3, 'optional', 'optional', NULL, NULL),
(310, 3, 'Category Description', 'Category Description', NULL, NULL),
(311, 3, 'Enter your description', 'Enter your description', NULL, NULL),
(312, 3, 'Thumbnail', 'Thumbnail', NULL, NULL),
(313, 3, 'Category logo', 'Category logo', NULL, NULL),
(314, 3, 'Category added successfully', 'Category added successfully', NULL, NULL),
(315, 3, 'Add', 'Add', NULL, NULL),
(316, 3, 'Edit category', 'Edit category', NULL, NULL),
(317, 3, 'Create course', 'Create course', NULL, NULL),
(318, 3, 'Enter Course Title', 'Enter Course Title', NULL, NULL),
(319, 3, 'Short Description', 'Short Description', NULL, NULL),
(320, 3, 'Enter Short Description', 'Enter Short Description', NULL, NULL),
(321, 3, 'Enter Description', 'Enter Description', NULL, NULL),
(322, 3, 'Create as', 'Create as', NULL, NULL),
(323, 3, 'Select a category', 'Select a category', NULL, NULL),
(324, 3, 'Course level', 'Course level', NULL, NULL),
(325, 3, 'Select your course level', 'Select your course level', NULL, NULL),
(326, 3, 'Made in', 'Made in', NULL, NULL),
(327, 3, 'Select your course language', 'Select your course language', NULL, NULL),
(328, 3, 'Pricing type', 'Pricing type', NULL, NULL),
(329, 3, 'Enter your course price', 'Enter your course price', NULL, NULL),
(330, 3, 'Check if this course has discount', 'Check if this course has discount', NULL, NULL),
(331, 3, 'Discounted price', 'Discounted price', NULL, NULL),
(332, 3, 'Enter your discount price', 'Enter your discount price', NULL, NULL),
(333, 3, 'Finish!', 'Finish!', NULL, NULL),
(334, 3, 'Course added successfully', 'Course added successfully', NULL, NULL),
(335, 3, 'Edit course', 'Edit course', NULL, NULL),
(336, 3, 'Editing', 'Editing', NULL, NULL),
(337, 3, 'Help', 'Help', NULL, NULL),
(338, 3, 'Frontend View', 'Frontend View', NULL, NULL),
(339, 3, 'Course Player', 'Course Player', NULL, NULL),
(340, 3, 'Curriculum', 'Curriculum', NULL, NULL),
(341, 3, 'Basic', 'Basic', NULL, NULL),
(342, 3, 'Live Class', 'Live Class', NULL, NULL),
(343, 3, 'Pricing', 'Pricing', NULL, NULL),
(344, 3, 'Info', 'Info', NULL, NULL),
(345, 3, 'Media', 'Media', NULL, NULL),
(346, 3, 'SEO', 'SEO', NULL, NULL),
(347, 3, 'Add new section', 'Add new section', NULL, NULL),
(348, 3, 'Add section', 'Add section', NULL, NULL),
(349, 3, 'Add a new Section', 'Add a new Section', NULL, NULL),
(350, 3, 'Create bootcamp', 'Create bootcamp', NULL, NULL),
(351, 3, 'Check if this bootcamp has discount', 'Check if this bootcamp has discount', NULL, NULL),
(352, 3, 'Publish Date', 'Publish Date', NULL, NULL),
(353, 3, 'Bootcamp Category', 'Bootcamp Category', NULL, NULL),
(354, 3, 'No data found', 'No data found', NULL, NULL),
(355, 3, 'Add category', 'Add category', NULL, NULL),
(356, 3, 'Category has been created.', 'Category has been created.', NULL, NULL),
(357, 3, 'Total bootcamps', 'Total bootcamps', NULL, NULL),
(358, 3, 'Bootcamp has been created.', 'Bootcamp has been created.', NULL, NULL),
(359, 3, 'Edit bootcamp', 'Edit bootcamp', NULL, NULL),
(360, 3, 'Frontent View', 'Frontent View', NULL, NULL),
(361, 3, 'Create Student', 'Create Student', NULL, NULL),
(362, 3, 'Student Info', 'Student Info', NULL, NULL),
(363, 3, 'Login Credentials', 'Login Credentials', NULL, NULL),
(364, 3, 'Social Links', 'Social Links', NULL, NULL),
(365, 3, 'Name', 'Name', NULL, NULL),
(366, 3, 'Biography', 'Biography', NULL, NULL),
(367, 3, 'User image', 'User image', NULL, NULL),
(368, 3, 'Facebook', 'Facebook', NULL, NULL),
(369, 3, 'Twitter', 'Twitter', NULL, NULL),
(370, 3, 'Linkedin', 'Linkedin', NULL, NULL),
(371, 3, 'Student add successfully', 'Student add successfully', NULL, NULL),
(372, 3, 'Student List', 'Student List', NULL, NULL),
(373, 3, 'Export', 'Export', NULL, NULL),
(374, 3, 'PDF', 'PDF', NULL, NULL),
(375, 3, 'Print', 'Print', NULL, NULL),
(376, 3, 'Search user', 'Search user', NULL, NULL),
(377, 3, 'Search', 'Search', NULL, NULL),
(378, 3, 'Enrolled Course', 'Enrolled Course', NULL, NULL),
(379, 3, 'Options', 'Options', NULL, NULL),
(380, 3, 'Email Verification', 'Email Verification', NULL, NULL),
(381, 3, 'Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.', 'Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.', NULL, NULL),
(382, 3, 'Resend Verification Email', 'Resend Verification Email', NULL, NULL),
(383, 3, 'My Courses', 'My Courses', NULL, NULL),
(384, 3, 'My Bootcamps', 'My Bootcamps', NULL, NULL),
(385, 3, 'Upload picture', 'Upload picture', NULL, NULL),
(386, 3, 'Upload New', 'Upload New', NULL, NULL),
(387, 3, 'My Teams', 'My Teams', NULL, NULL),
(388, 3, 'Please try using the appropriate keywords.', 'Please try using the appropriate keywords.', NULL, NULL),
(389, 3, 'Bootcamps', 'Bootcamps', NULL, NULL),
(390, 3, 'All Bootcamps', 'All Bootcamps', NULL, NULL),
(391, 3, 'Class', 'Class', NULL, NULL),
(392, 3, 'View Details', 'View Details', NULL, NULL),
(393, 3, 'Buy Now', 'Buy Now', NULL, NULL),
(394, 3, 'Item is already purchased.', 'Item is already purchased.', NULL, NULL),
(395, 3, 'Bootcamp payment', 'Bootcamp payment', NULL, NULL),
(396, 3, 'Order summary', 'Order summary', NULL, NULL),
(397, 3, 'Cancel Payment', 'Cancel Payment', NULL, NULL),
(398, 3, 'Select payment gateway', 'Select payment gateway', NULL, NULL),
(399, 3, 'Item List', 'Item List', NULL, NULL),
(400, 3, 'Total', 'Total', NULL, NULL),
(401, 3, 'Grand Total', 'Grand Total', NULL, NULL),
(402, 3, 'Reviews', 'Reviews', NULL, NULL),
(403, 3, 'lesson', 'lesson', NULL, NULL),
(404, 3, 'Students', 'Students', NULL, NULL),
(405, 3, 'Terms and condition', 'Terms and condition', NULL, NULL),
(406, 3, 'Terms', 'Terms', NULL, NULL),
(407, 3, 'WELLCOME TO CHEF', 'WELLCOME TO CHEF', NULL, NULL),
(408, 3, 'Visit Courses', 'Visit Courses', NULL, NULL),
(409, 3, 'Enrolled Learners', 'Enrolled Learners', NULL, NULL),
(410, 3, 'Online Instructors', 'Online Instructors', NULL, NULL),
(411, 3, 'Latest Top Skills', 'Latest Top Skills', NULL, NULL),
(412, 3, 'Awesome  site the top advertising been business.', 'Awesome  site the top advertising been business.', NULL, NULL),
(413, 3, 'Industry Experts', 'Industry Experts', NULL, NULL),
(414, 3, 'Learning From Anywhere', 'Learning From Anywhere', NULL, NULL),
(415, 3, 'Top Rated Courses', 'Top Rated Courses', NULL, NULL),
(416, 3, 'Upcoming Courses', 'Upcoming Courses', NULL, NULL),
(417, 3, 'Highlights the latest courses set to launch, giving students a sneak peek at new opportunities for learning and skill development. Stay ahead with our curated selection of upcoming educational offerings!', 'Highlights the latest courses set to launch, giving students a sneak peek at new opportunities for learning and skill development. Stay ahead with our curated selection of upcoming educational offerings!', NULL, NULL),
(418, 3, 'Featured Courses', 'Featured Courses', NULL, NULL),
(419, 3, 'Think more clearly', 'Think more clearly', NULL, NULL),
(420, 3, 'Awesome  site. on the top advertising a business online includes assembling Having the most keep.', 'Awesome  site. on the top advertising a business online includes assembling Having the most keep.', NULL, NULL),
(421, 3, 'Video title', 'Video title', NULL, NULL),
(422, 3, 'Our Popular Instructor', 'Our Popular Instructor', NULL, NULL),
(423, 3, 'Highlights our most sought-after educator, recognized for their engaging teaching style and exceptional course content. Discover their expertise and join the many students who have benefited from their classes!', 'Highlights our most sought-after educator, recognized for their engaging teaching style and exceptional course content. Discover their expertise and join the many students who have benefited from their classes!', NULL, NULL),
(424, 3, 'Frequently Asked Questions?', 'Frequently Asked Questions?', NULL, NULL),
(425, 3, 'FAQ provides quick answers to common inquiries, helping users resolve doubts efficiently.', 'FAQ provides quick answers to common inquiries, helping users resolve doubts efficiently.', NULL, NULL),
(426, 3, 'Follow The Latest News', 'Follow The Latest News', NULL, NULL),
(427, 3, 'Top Courses', 'Top Courses', NULL, NULL),
(428, 3, 'lessons', 'lessons', NULL, NULL),
(429, 3, 'Subscribe to our newsletter to get latest updates', 'Subscribe to our newsletter to get latest updates', NULL, NULL),
(430, 3, 'Subscribe to stay tuned for new latest updates and offer. Let\'s do it! ', 'Subscribe to stay tuned for new latest updates and offer. Let\'s do it! ', NULL, NULL),
(431, 3, 'Subscribe', 'Subscribe', NULL, NULL),
(432, 3, 'Read our privacy policy', 'Read our privacy policy', NULL, NULL),
(433, 3, 'Here', 'Here', NULL, NULL),
(434, 3, 'Blog category', 'Blog category', NULL, NULL),
(435, 3, 'Subtitle', 'Subtitle', NULL, NULL),
(436, 3, '(80  Character)', '(80  Character)', NULL, NULL),
(437, 3, 'Category add successfully', 'Category add successfully', NULL, NULL),
(438, 3, 'Total number of blog', 'Total number of blog', NULL, NULL),
(439, 3, 'Add new blog', 'Add new blog', NULL, NULL),
(440, 3, 'Search Title', 'Search Title', NULL, NULL),
(441, 3, 'Add Blog', 'Add Blog', NULL, NULL),
(442, 3, 'Enter blog title', 'Enter blog title', NULL, NULL),
(443, 3, 'Writing your keyword and hit htw enter button', 'Writing your keyword and hit htw enter button', NULL, NULL),
(444, 3, 'Blog banner', 'Blog banner', NULL, NULL),
(445, 3, 'Blog thumbnail', 'Blog thumbnail', NULL, NULL),
(446, 3, 'Would you like to designate it as popular?', 'Would you like to designate it as popular?', NULL, NULL),
(447, 3, 'Blog add successfully', 'Blog add successfully', NULL, NULL),
(448, 3, 'Creator', 'Creator', NULL, NULL),
(449, 3, 'View on frontend', 'View on frontend', NULL, NULL),
(450, 3, 'Read More', 'Read More', NULL, NULL),
(451, 3, 'Get Started Now', 'Get Started Now', NULL, NULL),
(452, 3, 'Creating A Community Of Life Long Learners', 'Creating A Community Of Life Long Learners', NULL, NULL),
(453, 3, 'Our LMS goes beyond just providing courses. It\'s a platform designed to ignite curiosity and empower your lifelong learning journey.  This supportive community provides a space to ask questions, no matter how big or small, and receive insightful answers from experienced learners and subject-matter experts.', 'Our LMS goes beyond just providing courses. It\'s a platform designed to ignite curiosity and empower your lifelong learning journey.  This supportive community provides a space to ask questions, no matter how big or small, and receive insightful answers from experienced learners and subject-matter experts.', NULL, NULL),
(454, 3, 'Share your own experiences and challenges, and find encouragement and inspiration from others on a similar path. The diverse perspectives within our community will broaden your horizons and challenge your thinking, fostering a deeper understanding and a richer learning experience.  Together, we\'ll transform learning from a solitary pursuit into a collaborative adventure, where shared knowledge fuels individual growth and collective discovery.', 'Share your own experiences and challenges, and find encouragement and inspiration from others on a similar path. The diverse perspectives within our community will broaden your horizons and challenge your thinking, fostering a deeper understanding and a richer learning experience.  Together, we\'ll transform learning from a solitary pursuit into a collaborative adventure, where shared knowledge fuels individual growth and collective discovery.', NULL, NULL),
(455, 3, 'Learn more about us', 'Learn more about us', NULL, NULL),
(456, 3, 'Our Online Courses', 'Our Online Courses', NULL, NULL),
(457, 3, 'See More', 'See More', NULL, NULL),
(458, 3, 'Our Blog', 'Our Blog', NULL, NULL),
(459, 3, 'LEARN FROM TODAY', 'LEARN FROM TODAY', NULL, NULL),
(460, 3, 'Watch Video', 'Watch Video', NULL, NULL),
(461, 3, 'Expert Mentors', 'Expert Mentors', NULL, NULL),
(462, 3, 'Students Globally', 'Students Globally', NULL, NULL),
(463, 3, 'Cost Free Course', 'Cost Free Course', NULL, NULL),
(464, 3, 'What they’re saying about our courses', 'What they’re saying about our courses', NULL, NULL),
(465, 3, 'Having enjoyed a breathlessly successful 2015, there can be no DJ  dynamic set of teaching tools Billed to be deployed.', 'Having enjoyed a breathlessly successful 2015, there can be no DJ  dynamic set of teaching tools Billed to be deployed.', NULL, NULL),
(466, 3, 'Student email verification', 'Student email verification', NULL, NULL),
(467, 3, 'Disabled', 'Disabled', NULL, NULL),
(468, 3, 'Frontend Settings', 'Frontend Settings', NULL, NULL),
(469, 3, 'Motivational Speech', 'Motivational Speech', NULL, NULL),
(470, 3, 'Website FAQS', 'Website FAQS', NULL, NULL),
(471, 3, 'Contact Information', 'Contact Information', NULL, NULL),
(472, 3, 'User Reviews', 'User Reviews', NULL, NULL),
(473, 3, 'Logo & Images', 'Logo & Images', NULL, NULL),
(474, 3, 'Frontend website settings', 'Frontend website settings', NULL, NULL),
(475, 3, 'Banner title', 'Banner title', NULL, NULL),
(476, 3, 'Banner sub title', 'Banner sub title', NULL, NULL),
(477, 3, 'Promo Video Provider', 'Promo Video Provider', NULL, NULL),
(478, 3, 'Youtube Video Link', 'Youtube Video Link', NULL, NULL),
(479, 3, 'Vimeo Video Link', 'Vimeo Video Link', NULL, NULL),
(480, 3, 'HTML5 Video link', 'HTML5 Video link', NULL, NULL),
(481, 3, 'Promo video link', 'Promo video link', NULL, NULL),
(482, 3, 'Cookie status', 'Cookie status', NULL, NULL),
(483, 3, 'Cookie note', 'Cookie note', NULL, NULL),
(484, 3, 'Refund policy', 'Refund policy', NULL, NULL),
(485, 3, 'Mobile App download Link', 'Mobile App download Link', NULL, NULL),
(486, 3, 'Update Settings', 'Update Settings', NULL, NULL),
(487, 3, 'designation', 'designation', NULL, NULL),
(488, 3, 'Question', 'Question', NULL, NULL),
(489, 3, 'Write a question', 'Write a question', NULL, NULL),
(490, 3, 'Answer', 'Answer', NULL, NULL),
(491, 3, 'Write a question answer', 'Write a question answer', NULL, NULL),
(492, 3, 'Contact Email', 'Contact Email', NULL, NULL),
(493, 3, 'Phone Number', 'Phone Number', NULL, NULL),
(494, 3, 'Office Hours', 'Office Hours', NULL, NULL),
(495, 3, 'Location', 'Location', NULL, NULL),
(496, 3, 'Latitude', 'Latitude', NULL, NULL),
(497, 3, 'Longitude', 'Longitude', NULL, NULL),
(498, 3, 'Recaptcha settings', 'Recaptcha settings', NULL, NULL),
(499, 3, 'Recaptcha status', 'Recaptcha status', NULL, NULL),
(500, 3, 'Recaptcha sitekey', 'Recaptcha sitekey', NULL, NULL),
(501, 3, 'Recaptcha secretkey', 'Recaptcha secretkey', NULL, NULL),
(502, 3, 'Update recaptcha settings', 'Update recaptcha settings', NULL, NULL),
(503, 3, 'Review', 'Review', NULL, NULL),
(504, 3, 'Add new Review', 'Add new Review', NULL, NULL),
(505, 3, 'Click here to choose a banner image', 'Click here to choose a banner image', NULL, NULL),
(506, 3, 'Upload banner image', 'Upload banner image', NULL, NULL),
(507, 3, 'Click here to choose a light logo', 'Click here to choose a light logo', NULL, NULL),
(508, 3, 'Upload light logo', 'Upload light logo', NULL, NULL),
(509, 3, 'Click here to choose a dark logo', 'Click here to choose a dark logo', NULL, NULL),
(510, 3, 'Upload dark logo', 'Upload dark logo', NULL, NULL),
(511, 3, 'Click here to choose a favicon', 'Click here to choose a favicon', NULL, NULL),
(512, 3, 'Upload favicon', 'Upload favicon', NULL, NULL),
(513, 3, 'Frontend settings update successfully', 'Frontend settings update successfully', NULL, NULL),
(514, 3, 'User already register and signing up for using it', 'User already register and signing up for using it', NULL, NULL),
(515, 3, 'Get Courses', 'Get Courses', NULL, NULL),
(516, 3, 'Start Learning', 'Start Learning', NULL, NULL),
(517, 3, 'Coding', 'Coding', NULL, NULL),
(518, 3, 'Languages', 'Languages', NULL, NULL),
(519, 3, 'The industry\'s standard dummy text ever since the  unknown printer took a galley of type and scrambled', 'The industry\'s standard dummy text ever since the  unknown printer took a galley of type and scrambled', NULL, NULL),
(520, 3, 'Online Courses', 'Online Courses', NULL, NULL),
(521, 3, 'Top Instructors', 'Top Instructors', NULL, NULL),
(522, 3, 'Online Certificates', 'Online Certificates', NULL, NULL),
(523, 3, 'Pick A Course To', 'Pick A Course To', NULL, NULL),
(524, 3, 'Download our mobile app, start learning', 'Download our mobile app, start learning', NULL, NULL),
(525, 3, 'Academy', 'Academy', NULL, NULL),
(526, 3, 'Download Now', 'Download Now', NULL, NULL),
(527, 3, 'Frequently Asked', 'Frequently Asked', NULL, NULL),
(528, 3, 'Questions', 'Questions', NULL, NULL),
(529, 3, 'What Our', 'What Our', NULL, NULL),
(530, 3, 'Have To Say', 'Have To Say', NULL, NULL),
(531, 3, 'Get News with', 'Get News with', NULL, NULL),
(532, 3, 'comment', 'comment', NULL, NULL),
(533, 3, 'Course Manager', 'Course Manager', NULL, NULL),
(534, 3, 'Active courses', 'Active courses', NULL, NULL),
(535, 3, 'Pending courses', 'Pending courses', NULL, NULL),
(536, 3, 'Free courses', 'Free courses', NULL, NULL),
(537, 3, 'Paid courses', 'Paid courses', NULL, NULL),
(538, 3, 'All', 'All', NULL, NULL),
(539, 3, 'Apply', 'Apply', NULL, NULL),
(540, 3, 'Lesson & Section', 'Lesson & Section', NULL, NULL),
(541, 3, 'Enrolled Student', 'Enrolled Student', NULL, NULL),
(542, 3, 'Section', 'Section', NULL, NULL),
(543, 3, 'View Course On Frontend', 'View Course On Frontend', NULL, NULL),
(544, 3, 'Go To Course Playing Page', 'Go To Course Playing Page', NULL, NULL),
(545, 3, 'Duplicate Course', 'Duplicate Course', NULL, NULL),
(546, 3, 'Make As Active', 'Make As Active', NULL, NULL),
(547, 3, 'Delete Course', 'Delete Course', NULL, NULL),
(548, 3, 'Course updated successfully', 'Course updated successfully', NULL, NULL),
(549, 3, 'Multi language setting', 'Multi language setting', NULL, NULL),
(550, 3, 'Language list', 'Language list', NULL, NULL),
(551, 3, 'Add Language', 'Add Language', NULL, NULL),
(552, 3, 'Import Language', 'Import Language', NULL, NULL),
(553, 3, 'Direction', 'Direction', NULL, NULL),
(554, 3, 'Option', 'Option', NULL, NULL),
(555, 3, 'LTR', 'LTR', NULL, NULL),
(556, 3, 'RTL', 'RTL', NULL, NULL),
(557, 3, 'Edit phrase', 'Edit phrase', NULL, NULL),
(558, 3, 'Add new language', 'Add new language', NULL, NULL),
(559, 3, 'No special character or space is allowed. Valid examples: French, Spanish, Bengali etc', 'No special character or space is allowed. Valid examples: French, Spanish, Bengali etc', NULL, NULL),
(560, 3, 'Save', 'Save', NULL, NULL),
(561, 3, 'Import your language files from here. (Ex: english.json)', 'Import your language files from here. (Ex: english.json)', NULL, NULL),
(562, 3, 'Import', 'Import', NULL, NULL),
(563, 3, 'phrase_updated', 'phrase_updated', NULL, NULL),
(564, 3, 'Direction has been updated', 'Direction has been updated', NULL, NULL),
(565, 3, 'Education For Eeveryone', 'Education For Eeveryone', NULL, NULL),
(566, 3, 'Search here', 'Search here', NULL, NULL),
(567, 3, 'Online Instructor have a new ideas every week.', 'Online Instructor have a new ideas every week.', NULL, NULL),
(568, 3, 'Special Featured Course.', 'Special Featured Course.', NULL, NULL),
(569, 3, 'View More', 'View More', NULL, NULL),
(570, 3, 'Know About Academy LMS Learning Platform', 'Know About Academy LMS Learning Platform', NULL, NULL),
(571, 3, 'Far far away, behind the word mountains, far from the away countries Vokalia and Consonantia, there live the blind texts.', 'Far far away, behind the word mountains, far from the away countries Vokalia and Consonantia, there live the blind texts.', NULL, NULL),
(572, 3, 'Free Resources Learning English for Beginner', 'Free Resources Learning English for Beginner', NULL, NULL),
(573, 3, 'Far far away, behind the word mountains, far from the away countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.', 'Far far away, behind the word mountains, far from the away countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.', NULL, NULL),
(574, 3, 'Instructor have a new ideas every week.', 'Instructor have a new ideas every week.', NULL, NULL),
(575, 3, 'Meet Our Team', 'Meet Our Team', NULL, NULL),
(576, 3, 'Download our mobile app, start learning today', 'Download our mobile app, start learning today', NULL, NULL),
(577, 3, 'Includes all Course && Features', 'Includes all Course && Features', NULL, NULL),
(578, 3, 'Get Bundle', 'Get Bundle', NULL, NULL),
(579, 3, 'Create Instructor', 'Create Instructor', NULL, NULL),
(580, 3, 'Instructor Info', 'Instructor Info', NULL, NULL),
(581, 3, 'Payment Information', 'Payment Information', NULL, NULL),
(582, 3, 'Instructor add successfully', 'Instructor add successfully', NULL, NULL),
(583, 3, 'Instructor List', 'Instructor List', NULL, NULL),
(584, 3, 'Number Of Course', 'Number Of Course', NULL, NULL),
(585, 3, 'View courses', 'View courses', NULL, NULL),
(586, 3, 'Make As Inactive', 'Make As Inactive', NULL, NULL),
(587, 3, 'Enroll Students', 'Enroll Students', NULL, NULL),
(588, 3, 'Course to enrol', 'Course to enrol', NULL, NULL),
(589, 3, 'Select a course', 'Select a course', NULL, NULL),
(590, 3, 'Enroll History', 'Enroll History', NULL, NULL),
(591, 3, 'Add new enrollment', 'Add new enrollment', NULL, NULL),
(592, 3, 'Enrolled Date', 'Enrolled Date', NULL, NULL),
(593, 3, 'Expiry Date', 'Expiry Date', NULL, NULL),
(594, 3, 'Lifetime access', 'Lifetime access', NULL, NULL),
(595, 3, 'Add Review', 'Add Review', NULL, NULL),
(596, 3, 'Select User', 'Select User', NULL, NULL),
(597, 3, 'Select an user', 'Select an user', NULL, NULL),
(598, 3, 'Rating', 'Rating', NULL, NULL),
(599, 3, 'Select a Rating', 'Select a Rating', NULL, NULL),
(600, 3, 'Review added successfull', 'Review added successfull', NULL, NULL),
(601, 3, 'About Us Image', 'About Us Image', NULL, NULL),
(602, 3, 'Faq  Image', 'Faq  Image', NULL, NULL),
(603, 3, 'Faq Image', 'Faq Image', NULL, NULL),
(604, 3, 'Slider image & video link', 'Slider image & video link', NULL, NULL),
(605, 3, 'Add Image', 'Add Image', NULL, NULL),
(606, 3, 'Add Video Link', 'Add Video Link', NULL, NULL),
(607, 3, 'Homepage updated successfully', 'Homepage updated successfully', NULL, NULL),
(608, 3, 'Duration', 'Duration', NULL, NULL),
(609, 3, 'Course Details', 'Course Details', NULL, NULL),
(610, 3, 'Certificate Course', 'Certificate Course', NULL, NULL),
(611, 3, 'Overview', 'Overview', NULL, NULL),
(612, 3, 'Details', 'Details', NULL, NULL),
(613, 3, 'Course Overview', 'Course Overview', NULL, NULL),
(614, 3, 'No Course Description', 'No Course Description', NULL, NULL),
(615, 3, 'FAQ area empty', 'FAQ area empty', NULL, NULL),
(616, 3, 'Course curriculum', 'Course curriculum', NULL, NULL),
(617, 3, 'Course curriculum Empty', 'Course curriculum Empty', NULL, NULL),
(618, 3, 'Requirment', 'Requirment', NULL, NULL),
(619, 3, 'Outcomes', 'Outcomes', NULL, NULL),
(620, 3, 'Rate this course : ', 'Rate this course : ', NULL, NULL),
(621, 3, 'Remove all', 'Remove all', NULL, NULL),
(622, 3, 'Write a reveiw ...', 'Write a reveiw ...', NULL, NULL),
(623, 3, 'Add to cart', 'Add to cart', NULL, NULL),
(624, 3, 'Share', 'Share', NULL, NULL),
(625, 3, 'Share on Facebook', 'Share on Facebook', NULL, NULL),
(626, 3, 'Share on Twitter', 'Share on Twitter', NULL, NULL),
(627, 3, 'Share on Whatsapp', 'Share on Whatsapp', NULL, NULL),
(628, 3, 'Share on Linkedin', 'Share on Linkedin', NULL, NULL),
(629, 3, 'Certificate', 'Certificate', NULL, NULL),
(630, 3, 'Certificate template', 'Certificate template', NULL, NULL),
(631, 3, 'Build your certificate', 'Build your certificate', NULL, NULL),
(632, 3, 'Upload your certificate template', 'Upload your certificate template', NULL, NULL),
(633, 3, 'Upload', 'Upload', NULL, NULL),
(634, 3, 'Certificate elements', 'Certificate elements', NULL, NULL),
(635, 3, 'Available Variable Data', 'Available Variable Data', NULL, NULL),
(636, 3, 'Add a new element', 'Add a new element', NULL, NULL),
(637, 3, 'Enter Text with variable data', 'Enter Text with variable data', NULL, NULL),
(638, 3, 'Total Lesson', 'Total Lesson', NULL, NULL),
(639, 3, 'Choice a font-family', 'Choice a font-family', NULL, NULL),
(640, 3, 'Default', 'Default', NULL, NULL),
(641, 3, 'Pinyon Script', 'Pinyon Script', NULL, NULL),
(642, 3, 'Font Size', 'Font Size', NULL, NULL),
(643, 3, 'Save Template', 'Save Template', NULL, NULL),
(644, 3, 'Certificate builder template has been updated', 'Certificate builder template has been updated', NULL, NULL),
(645, 3, 'Progress', 'Progress', NULL, NULL),
(646, 3, 'Start Now', 'Start Now', NULL, NULL),
(647, 3, 'Course Playing Page', 'Course Playing Page', NULL, NULL),
(648, 3, 'Summary', 'Summary', NULL, NULL),
(649, 3, 'Forum', 'Forum', NULL, NULL),
(650, 3, 'Class Schedules', 'Class Schedules', NULL, NULL),
(651, 3, 'Topic', 'Topic', NULL, NULL),
(652, 3, 'Date & time', 'Date & time', NULL, NULL),
(653, 3, 'Keep up the great work!', 'Keep up the great work!', NULL, NULL),
(654, 3, 'Your dedication to ongoing progress is inspiring.', 'Your dedication to ongoing progress is inspiring.', NULL, NULL),
(655, 3, 'Every step forward is a testament to your commitment to growth and excellence.', 'Every step forward is a testament to your commitment to growth and excellence.', NULL, NULL),
(656, 3, 'Stay focused, stay determined, and continue to push yourself to new heights.', 'Stay focused, stay determined, and continue to push yourself to new heights.', NULL, NULL),
(657, 3, 'You have got this!', 'You have got this!', NULL, NULL),
(658, 3, 'Search answers here', 'Search answers here', NULL, NULL),
(659, 3, 'Questions in this course', 'Questions in this course', NULL, NULL),
(660, 3, 'Ask question', 'Ask question', NULL, NULL),
(661, 3, 'Completed', 'Completed', NULL, NULL),
(662, 3, 'Enter title', 'Enter title', NULL, NULL),
(663, 3, 'Section added successfully', 'Section added successfully', NULL, NULL),
(664, 3, 'Add new lesson', 'Add new lesson', NULL, NULL),
(665, 3, 'Add lesson', 'Add lesson', NULL, NULL),
(666, 3, 'Add new quiz', 'Add new quiz', NULL, NULL),
(667, 3, 'Add quiz', 'Add quiz', NULL, NULL),
(668, 3, 'Sort sections', 'Sort sections', NULL, NULL),
(669, 3, 'Sort Section', 'Sort Section', NULL, NULL),
(670, 3, 'Edit section', 'Edit section', NULL, NULL),
(671, 3, 'Delete section', 'Delete section', NULL, NULL),
(672, 3, 'No lessons are available.', 'No lessons are available.', NULL, NULL),
(673, 3, 'Select lesson type', 'Select lesson type', NULL, NULL),
(674, 3, 'YouTube Video', 'YouTube Video', NULL, NULL),
(675, 3, 'Vimeo Video', 'Vimeo Video', NULL, NULL),
(676, 3, 'Video file', 'Video file', NULL, NULL),
(677, 3, 'Video url [ .mp4 ]', 'Video url [ .mp4 ]', NULL, NULL),
(678, 3, 'Google drive video', 'Google drive video', NULL, NULL),
(679, 3, 'Document file', 'Document file', NULL, NULL),
(680, 3, 'Text', 'Text', NULL, NULL),
(681, 3, 'Iframe embed', 'Iframe embed', NULL, NULL),
(682, 3, 'Next', 'Next', NULL, NULL),
(683, 3, 'Lesson type', 'Lesson type', NULL, NULL),
(684, 3, 'Change', 'Change', NULL, NULL),
(685, 3, 'Enter your text', 'Enter your text', NULL, NULL),
(686, 3, 'Do you want to keep it free as a preview lesson', 'Do you want to keep it free as a preview lesson', NULL, NULL),
(687, 3, 'Mark as free lesson', 'Mark as free lesson', NULL, NULL),
(688, 3, 'lesson added successfully', 'lesson added successfully', NULL, NULL),
(689, 3, 'Sort lessons', 'Sort lessons', NULL, NULL),
(690, 3, 'Edit lesson', 'Edit lesson', NULL, NULL),
(691, 3, 'Delete lesson', 'Delete lesson', NULL, NULL),
(692, 3, 'Congratulations!', 'Congratulations!', NULL, NULL),
(693, 3, 'Your hard work has paid off. Here is to new beginnings and endless opportunities ahead!', 'Your hard work has paid off. Here is to new beginnings and endless opportunities ahead!', NULL, NULL),
(694, 3, 'Get Certificate', 'Get Certificate', NULL, NULL),
(695, 3, 'Download Certificate', 'Download Certificate', NULL, NULL),
(696, 3, 'Download', 'Download', NULL, NULL),
(697, 3, 'Auto', 'Auto', NULL, NULL),
(698, 3, 'Continue', 'Continue', NULL, NULL),
(699, 3, 'Shopping cart', 'Shopping cart', NULL, NULL),
(700, 3, 'Cart items', 'Cart items', NULL, NULL),
(701, 3, 'Payment summary', 'Payment summary', NULL, NULL),
(702, 3, 'Sub total', 'Sub total', NULL, NULL),
(703, 3, 'Tax', 'Tax', NULL, NULL),
(704, 3, '%', '%', NULL, NULL),
(705, 3, 'Apply coupon', 'Apply coupon', NULL, NULL),
(706, 3, 'Send as a gift', 'Send as a gift', NULL, NULL),
(707, 3, 'Enter user email', 'Enter user email', NULL, NULL),
(708, 3, 'Continue to payment', 'Continue to payment', NULL, NULL),
(709, 3, 'Payment failed! Please try again.', 'Payment failed! Please try again.', NULL, NULL),
(710, 3, 'Parent category', 'Parent category', NULL, NULL),
(711, 3, '- Mark it as parent -', '- Mark it as parent -', NULL, NULL),
(712, 3, 'Choose category thumbnail', 'Choose category thumbnail', NULL, NULL),
(713, 3, 'Choose category Logo', 'Choose category Logo', NULL, NULL),
(714, 3, 'Category updated successfully', 'Category updated successfully', NULL, NULL),
(715, 3, 'Enable the Fileinfo extension on your server to upload files.', 'Enable the Fileinfo extension on your server to upload files.', NULL, NULL),
(716, 3, 'Fileinfo extension', 'Fileinfo extension', NULL, NULL),
(717, 3, 'Enable this Fileinfo extension on your server to upload files', 'Enable this Fileinfo extension on your server to upload files', NULL, NULL),
(718, 3, 'paytm merchant key', 'paytm merchant key', NULL, NULL),
(719, 3, 'paytm merchant mid', 'paytm merchant mid', NULL, NULL),
(720, 3, 'paytm merchant website', 'paytm merchant website', NULL, NULL),
(721, 3, 'industry type id', 'industry type id', NULL, NULL),
(722, 3, 'channel id', 'channel id', NULL, NULL),
(723, 3, 'Payment settings update successfully', 'Payment settings update successfully', NULL, NULL),
(724, 3, 'Configure ZOOM server-to-server-oauth credentials', 'Configure ZOOM server-to-server-oauth credentials', NULL, NULL),
(725, 3, 'Account Email', 'Account Email', NULL, NULL),
(726, 3, 'Account ID', 'Account ID', NULL, NULL),
(727, 3, 'Client ID', 'Client ID', NULL, NULL),
(728, 3, 'Client Secret', 'Client Secret', NULL, NULL),
(729, 3, 'Do you want to use Web SDK for your live class?', 'Do you want to use Web SDK for your live class?', NULL, NULL),
(730, 3, 'Meeting SDK Client ID', 'Meeting SDK Client ID', NULL, NULL),
(731, 3, 'Meeting SDK Client Secret', 'Meeting SDK Client Secret', NULL, NULL),
(732, 3, 'Enroll delete successfully', 'Enroll delete successfully', NULL, NULL),
(733, 3, '500 error found', '500 error found', NULL, NULL),
(734, 3, 'A technical error has occurred', 'A technical error has occurred', NULL, NULL),
(735, 3, 'Please contact with site administrator', 'Please contact with site administrator', NULL, NULL),
(736, 3, 'please_do_not_refresh_this_page', 'please_do_not_refresh_this_page', NULL, NULL),
(737, 3, 'Please do not refresh this page', 'Please do not refresh this page', NULL, NULL),
(738, 3, 'User', 'User', NULL, NULL),
(739, 3, 'Item', 'Item', NULL, NULL),
(740, 3, 'Paid amount', 'Paid amount', NULL, NULL),
(741, 3, 'Payment method', 'Payment method', NULL, NULL),
(742, 3, 'Purchased date', 'Purchased date', NULL, NULL),
(743, 3, 'Invoice', 'Invoice', NULL, NULL),
(744, 3, 'Select an option', 'Select an option', NULL, NULL),
(745, 3, 'Total Mark', 'Total Mark', NULL, NULL),
(746, 3, 'Pass Mark', 'Pass Mark', NULL, NULL),
(747, 3, 'Retake', 'Retake', NULL, NULL),
(748, 3, 'Quiz has been created.', 'Quiz has been created.', NULL, NULL),
(749, 3, 'Result', 'Result', NULL, NULL),
(750, 3, 'Edit quiz', 'Edit quiz', NULL, NULL),
(751, 3, 'Update Quiz', 'Update Quiz', NULL, NULL),
(752, 3, 'Add Question', 'Add Question', NULL, NULL),
(753, 3, 'Question Type', 'Question Type', NULL, NULL),
(754, 3, 'Multiple Choice', 'Multiple Choice', NULL, NULL),
(755, 3, 'Fill in the blanks', 'Fill in the blanks', NULL, NULL),
(756, 3, 'True or False', 'True or False', NULL, NULL),
(757, 3, 'Write question', 'Write question', NULL, NULL),
(758, 3, 'Your questions here', 'Your questions here', NULL, NULL);
INSERT INTO `language_phrases` (`id`, `language_id`, `phrase`, `translated`, `created_at`, `updated_at`) VALUES
(759, 3, 'You can keep multiple options. Just put an option and hit enter.', 'You can keep multiple options. Just put an option and hit enter.', NULL, NULL),
(760, 3, 'You can select multiple answers.', 'You can select multiple answers.', NULL, NULL),
(761, 3, 'Manage Course', 'Manage Course', NULL, NULL),
(762, 3, 'Time left : ', 'Time left : ', NULL, NULL),
(763, 3, 'Hour', 'Hour', NULL, NULL),
(764, 3, 'Minute', 'Minute', NULL, NULL),
(765, 3, 'Second', 'Second', NULL, NULL),
(766, 3, 'Total Marks', 'Total Marks', NULL, NULL),
(767, 3, 'Pass Marks', 'Pass Marks', NULL, NULL),
(768, 3, 'Attempts', 'Attempts', NULL, NULL),
(769, 3, 'Total Question', 'Total Question', NULL, NULL),
(770, 3, 'Start Quiz', 'Start Quiz', NULL, NULL),
(771, 3, 'Quiz has been updated.', 'Quiz has been updated.', NULL, NULL),
(772, 3, 'Question has been added.', 'Question has been added.', NULL, NULL),
(773, 3, 'Sort Questions', 'Sort Questions', NULL, NULL),
(774, 3, 'Edit Question', 'Edit Question', NULL, NULL),
(775, 3, 'Update Question', 'Update Question', NULL, NULL),
(776, 3, 'Watermark Type', 'Watermark Type', NULL, NULL),
(777, 3, 'Js Watermark', 'Js Watermark', NULL, NULL),
(778, 3, 'FFMpeg', 'FFMpeg', NULL, NULL),
(779, 3, 'Watermark', 'Watermark', NULL, NULL),
(780, 3, 'Opacity', 'Opacity', NULL, NULL),
(781, 3, 'Opacity (0 - 100)', 'Opacity (0 - 100)', NULL, NULL),
(782, 3, 'Width', 'Width', NULL, NULL),
(783, 3, 'Width (px)', 'Width (px)', NULL, NULL),
(784, 3, 'Height', 'Height', NULL, NULL),
(785, 3, 'Height (px)', 'Height (px)', NULL, NULL),
(786, 3, 'Top', 'Top', NULL, NULL),
(787, 3, 'Top (px)', 'Top (px)', NULL, NULL),
(788, 3, 'Left (px)', 'Left (px)', NULL, NULL),
(789, 3, 'Enter your html5 video url', 'Enter your html5 video url', NULL, NULL),
(790, 3, 'The image size should be', 'The image size should be', NULL, NULL),
(791, 3, 'Caption', 'Caption', NULL, NULL),
(792, 3, '.vtt', '.vtt', NULL, NULL),
(793, 3, 'Animation speed', 'Animation speed', NULL, NULL),
(794, 3, 'Second (0 - 200)', 'Second (0 - 200)', NULL, NULL),
(795, 3, 'Your changes has been saved.', 'Your changes has been saved.', NULL, NULL),
(796, 3, 'Second (0 - 10000)', 'Second (0 - 10000)', NULL, NULL),
(797, 3, 'by', 'by', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `course_id` bigint(20) UNSIGNED DEFAULT NULL,
  `section_id` bigint(20) UNSIGNED DEFAULT NULL,
  `lesson_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_mark` int(11) DEFAULT NULL,
  `pass_mark` int(11) DEFAULT NULL,
  `retake` int(11) DEFAULT NULL,
  `lesson_src` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attachment` longtext COLLATE utf8mb4_unicode_ci,
  `attachment_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_type` text COLLATE utf8mb4_unicode_ci,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_free` int(11) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `summary` longtext COLLATE utf8mb4_unicode_ci,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `like_dislike_reviews`
--

CREATE TABLE `like_dislike_reviews` (
  `id` int(255) NOT NULL,
  `review_id` int(255) DEFAULT NULL,
  `user_id` int(255) DEFAULT NULL,
  `liked` int(255) DEFAULT '0',
  `disliked` int(255) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `live_classes`
--

CREATE TABLE `live_classes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `course_id` bigint(20) UNSIGNED DEFAULT NULL,
  `class_topic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `class_date_and_time` timestamp NULL DEFAULT NULL,
  `additional_info` longtext COLLATE utf8mb4_unicode_ci,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media_files`
--

CREATE TABLE `media_files` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  `story_id` int(11) DEFAULT NULL,
  `album_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `page_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `chat_id` int(11) DEFAULT NULL,
  `file_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `privacy` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(255) NOT NULL,
  `thread_id` int(255) DEFAULT NULL,
  `sender_id` int(255) DEFAULT NULL,
  `receiver_id` int(255) DEFAULT NULL,
  `message` longtext,
  `read` int(11) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `message_threads`
--

CREATE TABLE `message_threads` (
  `id` int(255) NOT NULL,
  `code` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_one` int(255) DEFAULT NULL,
  `contact_two` int(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `newsletters`
--

CREATE TABLE `newsletters` (
  `id` int(11) NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `newsletter_subscribers`
--

CREATE TABLE `newsletter_subscribers` (
  `id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification_settings`
--

CREATE TABLE `notification_settings` (
  `id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_editable` int(11) DEFAULT NULL,
  `addon_identifier` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_types` varchar(400) COLLATE utf8_unicode_ci DEFAULT NULL,
  `system_notification` varchar(400) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_notification` varchar(400) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `template` longtext COLLATE utf8_unicode_ci,
  `setting_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `setting_sub_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_updated` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `notification_settings`
--

INSERT INTO `notification_settings` (`id`, `type`, `is_editable`, `addon_identifier`, `user_types`, `system_notification`, `email_notification`, `subject`, `template`, `setting_title`, `setting_sub_title`, `date_updated`, `created_at`, `updated_at`) VALUES
(1, 'edit_email_template', 1, NULL, '[\"admin\",\"user\"]', '{\"admin\":\"1\",\"user\":\"1\"}', '{\"admin\":\"1\",\"user\":\"0\"}', '{\"admin\":\"New user registered\",\"user\":\"Registered successfully\"}', '{\"admin\":\"New user registered [user_name] \\r\\n<br>User email: <b>[user_email]<\\/b>\",\"user\":\"You have successfully registered with us at [system_name].\"}', 'New user registration', 'Get notified when a new user signs up', '1693215071', '2023-11-02 11:13:07', '2023-12-05 01:23:15'),
(2, 'email_verification', 0, NULL, '[\"user\"]', '{\"user\":\"0\"}', '{\"user\":\"1\"}', '{\"user\":\"Email verification code\"}', '{\"user\":\"You have received a email verification code. Your verification code is [email_verification_code]\"}', 'Email verification', 'It is permanently enabled for student email verification.', '1684135777', '2023-11-02 11:13:07', '2023-11-02 11:13:07'),
(3, 'forget_password_mail', 0, NULL, '[\"user\"]', '{\"user\":\"0\"}', '{\"user\":\"1\"}', '{\"user\":\"Forgot password verification code\"}', '{\"user\":\"You have received a email verification code. Your verification code is [system_name][verification_link][minutes]\"}', 'Forgot password mail', 'It is permanently enabled for student email verification.', '1684145383', '2023-11-02 11:13:07', '2023-11-02 11:13:07'),
(4, 'new_device_login_confirmation', 0, NULL, '[\"user\"]', '{\"user\":\"0\"}', '{\"user\":\"1\"}', '{\"user\":\"Please confirm your login\"}', '{\"user\":\"Have you tried logging in with a different device? Confirm using the verification code. Your verification code is [verification_code]. Remember that you will lose access to your previous device after logging in to the new device <b>[user_agent]<\\/b>.<br> Use the verification code within [minutes] minutes\"}', 'Account security alert', 'Send verification code for login from a new device', '1684145383', '2023-11-02 11:13:07', '2023-11-02 11:13:07'),
(6, 'course_purchase', 1, NULL, '[\"admin\",\"student\",\"instructor\"]', '{\"admin\":\"1\",\"student\":\"1\",\"instructor\":\"1\"}', '{\"admin\":\"0\",\"student\":\"0\",\"instructor\":\"0\"}', '{\"admin\":\"A new course has been sold\",\"instructor\":\"A new course has been sold\",\"student\":\"You have purchased a new course\"}', '{\"admin\":\"<p>Course title: [course_title]<\\/p><p>Student: [student_name]\\r\\n<\\/p><p>Paid amount: [paid_amount]<\\/p><p>Instructor: [instructor_name]<\\/p>\",\"instructor\":\"Course title: [course_title]\\r\\nStudent: [student_name]\\r\\nPaid amount: [paid_amount]\",\"student\":\"Course title: [course_title]\\r\\nPaid amount: [paid_amount]\\r\\nInstructor: [instructor_name]\"}', 'Course purchase notification', 'Stay up-to-date on student course purchases.', '1684303456', '2023-11-02 11:13:07', '2023-11-02 11:13:07'),
(7, 'course_completion_mail', 1, NULL, '[\"student\",\"instructor\"]', '{\"student\":\"1\",\"instructor\":\"1\"}', '{\"student\":\"0\",\"instructor\":\"0\"}', '{\"instructor\":\"Course completion\",\"student\":\"You have completed a new course\"}', '{\"instructor\":\"Course completed [course_title]\\r\\nStudent: [student_name]\",\"student\":\"Course: [course_title]\\r\\nInstructor: [instructor_name]\"}', 'Course completion mail', 'Stay up to date on student course completion.', '1684303457', '2023-11-02 11:13:07', '2023-11-02 11:13:07'),
(8, 'certificate_eligibility', 1, 'certificate', '[\"student\",\"instructor\"]', '{\"student\":\"1\",\"instructor\":\"1\"}', '{\"student\":\"0\",\"instructor\":\"0\"}', '{\"instructor\":\"Certificate eligibility\",\"student\":\"certificate eligibility\"}', '{\"instructor\":\"Course: [course_title]\\r\\nStudent: [student_name]\\r\\nCertificate link: [certificate_link]\",\"student\":\"Course: [course_title]\\r\\nInstructor: [instructor_name]\\r\\nCertificate link: [certificate_link]\"}', 'Course eligibility notification', 'Stay up to date on course certificate eligibility.', '1684303460', '2023-11-02 11:13:07', '2023-11-02 11:13:07'),
(9, 'offline_payment_suspended_mail', 1, 'offline_payment', '[\"student\"]', '{\"student\":\"1\"}', '{\"student\":\"0\"}', '{\"student\":\"Your payment has been suspended\"}', '{\"student\":\"<p>Your offline payment has been <b style=\'color: red;\'>suspended</b> !</p><p>Please provide a valid document of your payment.</p>\"}', 'Offline payment suspended mail', 'If students provides fake information, notify them of the suspension', '1684303463', '2023-11-02 11:13:07', '2023-11-02 11:13:07'),
(10, 'bundle_purchase', 1, 'course_bundle', '[\"admin\",\"student\",\"instructor\"]', '{\"admin\":\"1\",\"student\":\"1\",\"instructor\":\"1\"}', '{\"admin\":\"0\",\"student\":\"0\",\"instructor\":\"0\"}', '{\"admin\":\"A new course bundle has been sold \",\"instructor\":\"A new course bundle has been sold \",\"student\":\"You have purchased a new course bundle test\"}', '{\"admin\":\"Course bundle: [bundle_title]\\r\\nStudent: [student_name]\\r\\nInstructor: [instructor_name] \",\"instructor\":\"Course bundle: [bundle_title]\\r\\nStudent: [student_name] \",\"student\":\"Course bundle: [bundle_title]\\r\\nInstructor: [instructor_name] \"}', 'Course bundle purchase notification', 'Stay up-to-date on student course bundle purchases.', '1684303467', '2023-11-02 11:13:07', '2023-11-02 11:13:07'),
(13, 'add_new_user_as_affiliator', 0, 'affiliate_course', '[\"affiliator\"]', '{\"affiliator\":\"0\"}', '{\"affiliator\":\"1\"}', '{\"affiliator\":\"Congratulation ! You are assigned as an affiliator\"}', '{\"affiliator\":\"You are assigned as a website Affiliator.\\r\\nWebsite: [website_link]\\r\\n<br>\\r\\nPassword: [password]\"}', 'New user added as affiliator', 'Send account information to the new user', '1684135777', '2023-11-02 11:13:07', '2023-11-02 11:13:07'),
(14, 'affiliator_approval_notification', 1, 'affiliate_course', '[\"affiliator\"]', '{\"affiliator\":\"1\"}', '{\"affiliator\":\"0\"}', '{\"affiliator\":\"Congratulations! Your affiliate request has been approved\"}', '{\"affiliator\":\"Congratulations! Your affiliate request has been approved\"}', 'Affiliate approval notification', 'Send affiliate approval mail to the user account', '1684303472', '2023-11-02 11:13:07', '2023-11-02 11:13:07'),
(15, 'affiliator_request_cancellation', 1, 'affiliate_course', '[\"affiliator\"]', '{\"affiliator\":\"1\"}', '{\"affiliator\":\"0\"}', '{\"affiliator\":\"Sorry ! Your request has been currently refused\"}', '{\"affiliator\":\"Sorry ! Your request has been currently refused.\"}', 'Affiliator request cancellation', 'Send mail, when you cancel the affiliation request', '1684303473', '2023-11-02 11:13:07', '2023-11-02 11:13:07'),
(16, 'affiliation_amount_withdrawal_request', 1, 'affiliate_course', '[\"admin\",\"affiliator\"]', '{\"admin\":\"1\",\"affiliator\":\"1\"}', '{\"admin\":\"0\",\"affiliator\":\"0\"}', '{\"admin\":\"New money withdrawal request\",\"affiliator\":\"New money withdrawal request\"}', '{\"admin\":\"New money withdrawal request by [\'user_name] [amount]\",\"affiliator\":\"Your Withdrawal request of [amount] has been sent to authority\"}', 'Affiliation money withdrawal request', 'Send mail, when the users request the withdrawal of money', '1684303476', '2023-11-02 11:13:07', '2023-11-02 11:13:07'),
(17, 'approval_affiliation_amount_withdrawal_request', 1, 'affiliate_course', '[\"affiliator\"]', '{\"affiliator\":\"1\"}', '{\"affiliator\":\"0\"}', '{\"affiliator\":\"Congartulation ! Your withdrawal request has been approved\"}', '{\"affiliator\":\"Congartulation ! Your payment request has been approved.\"}', 'Approval of withdrawal request of affiliation', 'Send mail, when you approved the affiliation withdrawal request', '1684303480', '2023-11-02 11:13:07', '2023-11-02 11:13:07'),
(18, 'course_gift', 1, NULL, '[\"payer\",\"receiver\"]', '{\"payer\":\"1\",\"receiver\":\"1\"}', '{\"payer\":\"1\",\"receiver\":\"1\"}', '{\"payer\":\"You have gift a course\",\"receiver\":\"You have received a course gift\"}', '{\"payer\":\"You have gift a course to [user_name] [course_title][instructor]\",\"receiver\":\"You have received a course gift by [payer][course_title][instructor]\"}', 'Course gift notification', 'Notify users after course gift', '1691818623', '2023-11-02 11:13:07', '2023-11-06 05:02:28');

-- --------------------------------------------------------

--
-- Table structure for table `offline_payments`
--

CREATE TABLE `offline_payments` (
  `id` int(255) NOT NULL,
  `user_id` int(255) DEFAULT NULL,
  `item_type` varchar(255) DEFAULT NULL,
  `items` varchar(255) DEFAULT NULL,
  `tax` double DEFAULT NULL,
  `total_amount` double DEFAULT NULL,
  `coupon` varchar(255) DEFAULT NULL,
  `phone_no` varchar(255) DEFAULT NULL,
  `bank_no` varchar(255) DEFAULT NULL,
  `doc` varchar(255) DEFAULT NULL,
  `status` int(255) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
-- Table structure for table `payment_gateways`
--

CREATE TABLE `payment_gateways` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `identifier` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `keys` text COLLATE utf8mb4_unicode_ci,
  `status` int(11) DEFAULT NULL,
  `test_mode` int(11) DEFAULT NULL,
  `is_addon` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_gateways`
--

INSERT INTO `payment_gateways` (`id`, `identifier`, `currency`, `title`, `model_name`, `description`, `keys`, `status`, `test_mode`, `is_addon`, `created_at`, `updated_at`) VALUES
(1, 'paypal', 'USD', 'Paypal', 'Paypal', '', '{\"sandbox_client_id\":\"AfGaziKslex-scLAyYdDYXNFaz2aL5qGau-SbDgE_D2E80D3AFauLagP8e0kCq9au7W4IasmFbirUUYc\",\"sandbox_secret_key\":\"EMa5pCTuOpmHkhHaCGibGhVUcKg0yt5-C3CzJw-OWJCzaXXzTlyD17SICob_BkfM_0Nlk7TWnN42cbGz\",\"production_client_id\":\"1234\",\"production_secret_key\":\"12345\"}', 1, 1, 0, '2023-06-24 03:51:49', '2023-11-28 01:44:37'),
(2, 'stripe', 'USD', 'Stripe', 'StripePay', '', '{\"public_key\":\"pk_test_c6VvBEbwHFdulFZ62q1IQrar\",\"secret_key\":\"sk_test_9IMkiM6Ykxr1LCe2dJ3PgaxS\",\"public_live_key\":\"pk_live_xxxxxxxxxxxxxxxxxxxxxxxx\",\"secret_live_key\":\"sk_live_xxxxxxxxxxxxxxxxxxxxxxxx\"}', 1, 1, 0, '2023-06-24 03:51:49', '2023-10-30 01:33:32'),
(3, 'razorpay', 'INR', 'Razorpay', 'Razorpay', '', '{\"public_key\":\"rzp_test_J60bqBOi1z1aF5\",\"secret_key\":\"uk935K7p4j96UCJgHK8kAU4q\"}', 1, 1, 0, '2023-06-24 03:51:49', '2024-09-10 22:41:31'),
(4, 'flutterwave', 'USD', 'Flutterwave', 'Flutterwave', '', '{\"public_key\":\"FLWPUBK_TEST-48dfbeb50344ecd8bc075b4ffe9ba266-X\",\"secret_key\":\"FLWSECK_TEST-1691582e23bd6ee4fb04213ec0b862dd-X\"}', 1, 1, 0, '2023-06-24 03:51:49', '2023-10-30 01:39:58'),
(5, 'paytm', 'INR', 'Paytm', 'Paytm', '', '{\"paytm_merchant_key\":\"NLcIjJn!!lkjDZQN\",\"paytm_merchant_mid\":\"YEPkQv98980476147162\",\"paytm_merchant_website\":\"WEBSTAGING\",\"industry_type_id\":\"Retail\",\"channel_id\":\"WEB\"}', 1, 1, 0, '2023-06-24 03:51:49', '2024-10-30 04:17:36'),
(6, 'offline', 'USD', 'Offline Payment', 'OfflinePayment', '', '{\"bank_information\":\"Write your bank information and instructions here\"}', 1, 0, 0, '2023-06-24 03:51:49', '2024-09-24 01:00:18'),
(7, 'paystack', 'NGN', 'Paystack', 'Paystack', NULL, '{\"secret_test_key\":\"sk_test_c746060e693dd50c6f397dffc6c3b2f655217c94\",\"public_test_key\":\"pk_test_0816abbed3c339b8473ff22f970c7da1c78cbe1b\",\"secret_live_key\":\"sk_live_xxxxxxxxxxxxxxxxxxxxxxxxx\",\"public_live_key\":\"pk_live_xxxxxxxxxxxxxxxxxxxxxxxxx\"}', 1, 1, 0, '2024-10-03 11:05:03', '2024-10-03 11:05:03');

-- --------------------------------------------------------

--
-- Table structure for table `payment_histories`
--

CREATE TABLE `payment_histories` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `payment_type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `invoice` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_added` int(11) DEFAULT NULL,
  `last_modified` int(11) DEFAULT NULL,
  `admin_revenue` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `instructor_revenue` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tax` double DEFAULT NULL,
  `instructor_payment_status` int(11) DEFAULT '0',
  `transaction_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `session_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `coupon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payouts`
--

CREATE TABLE `payouts` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `payment_type` varchar(255) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `permissions` longtext COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
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
-- Table structure for table `player_settings`
--

CREATE TABLE `player_settings` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `player_settings`
--

INSERT INTO `player_settings` (`id`, `title`, `description`, `created_at`, `updated_at`) VALUES
(1, 'watermark_width', '100', '2024-08-27 11:25:27', '2024-10-30 05:47:08'),
(2, 'watermark_height', '24', '2024-08-27 11:25:27', '2024-10-30 05:47:08'),
(3, 'watermark_top', '10', '2024-08-27 11:25:27', '2024-10-30 05:47:08'),
(4, 'watermark_left', '10', '2024-08-27 11:25:27', '2024-10-30 05:47:08'),
(5, 'watermark_opacity', '30', '2024-08-27 11:25:27', '2024-10-30 05:47:08'),
(6, 'watermark_type', 'js', '2024-08-27 11:25:27', '2024-10-30 05:47:08'),
(7, 'watermark_logo', 'uploads/watermark/watermark-default.png', '2024-08-27 11:25:27', '2024-08-27 11:25:27'),
(8, 'animation_speed', '1000', '2024-10-30 11:38:00', '2024-10-30 05:47:08');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) DEFAULT NULL,
  `title` longtext COLLATE utf8mb4_unicode_ci,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `answer` mediumtext COLLATE utf8mb4_unicode_ci,
  `options` longtext COLLATE utf8mb4_unicode_ci,
  `sort` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `id` int(255) NOT NULL,
  `user_id` int(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `section_id` int(255) DEFAULT NULL,
  `duration` varchar(255) DEFAULT NULL,
  `total_mark` int(255) DEFAULT NULL,
  `pass_mark` int(255) DEFAULT NULL,
  `drip_rule` int(255) DEFAULT NULL,
  `summary` longtext,
  `attempts` longtext,
  `sort` int(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_submissions`
--

CREATE TABLE `quiz_submissions` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `correct_answer` longtext COLLATE utf8mb4_unicode_ci,
  `wrong_answer` longtext COLLATE utf8mb4_unicode_ci,
  `submits` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(255) UNSIGNED NOT NULL,
  `user_id` int(255) DEFAULT NULL,
  `course_id` int(255) DEFAULT NULL,
  `rating` int(255) DEFAULT NULL,
  `review_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `review` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `course_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort` int(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seo_fields`
--

CREATE TABLE `seo_fields` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` int(20) DEFAULT NULL,
  `blog_id` int(20) DEFAULT NULL,
  `route` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_route` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_keywords` text COLLATE utf8mb4_unicode_ci,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `meta_robot` text COLLATE utf8mb4_unicode_ci,
  `canonical_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `custom_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `json_ld` longtext COLLATE utf8mb4_unicode_ci,
  `og_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `og_description` text COLLATE utf8mb4_unicode_ci,
  `og_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `seo_fields`
--

INSERT INTO `seo_fields` (`id`, `course_id`, `blog_id`, `route`, `name_route`, `meta_title`, `meta_keywords`, `meta_description`, `meta_robot`, `canonical_url`, `custom_url`, `json_ld`, `og_title`, `og_description`, `og_image`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 'Home', 'home', 'Home page', NULL, 'Home page for academy Seo', 'xxxxxx', 'https://academy.com', 'https://academy.com', '<script type=\"application/ld+json\"> {   \"@context\": \"http://schema.org\",   \"@type\": \"WebSite\",   \"name\": \"CodeCanyon\",   \"url\": \"https://codecanyon.net\" } </script>', 'ooooooooo', 'zzzzzzzzzz', 'OG-home.jpg', NULL, NULL),
(2, NULL, NULL, 'Compare', 'compare', 'Course compare', '[{\"value\":\"course\"},{\"value\":\"compare\"},{\"value\":\"difference\"}]', 'Course compare', 'xxxxxx', 'https:://academy.com/course-compare', 'https:://academy.com/course-compare', NULL, 'Course compare', 'Course compare', '2-customer-php-version.PNG', NULL, NULL),
(3, NULL, NULL, 'Privacy', 'privacy.policy', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'OG-documantation.jpg', NULL, NULL),
(4, NULL, NULL, 'Refund', 'refund.policy', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'OG-Blog.jpg', NULL, NULL),
(5, NULL, NULL, 'Terms- condition', 'terms.condition', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'OG-service.jpg', NULL, NULL),
(6, NULL, NULL, 'Faq', 'faq', 'Creative elements - ui subscription system', '[{\"value\":\"ui kits\"},{\"value\":\"website template\"},{\"value\":\"video template\"}]', 'Best and affordable ui kit subscription system', NULL, NULL, NULL, NULL, NULL, NULL, 'OG-elements home.jpg', NULL, NULL),
(7, NULL, NULL, 'Cookie policy', 'cookie.policy', 'Academy LMS - Cookie policy', '[{\"value\":\"ui kits\"},{\"value\":\"website template\"},{\"value\":\"video template\"}]', 'NULL', NULL, NULL, NULL, NULL, NULL, NULL, 'OG-elements home.jpg', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) UNSIGNED NOT NULL,
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `type`, `description`, `created_at`, `updated_at`) VALUES
(1, 'language', 'english', '2023-10-29 05:36:40', '2024-09-24 05:51:14'),
(2, 'system_name', 'Academy LMS LARAVEL', '2023-10-29 05:36:40', '2024-09-24 05:51:14'),
(3, 'system_title', 'Academy Learning Club', '2023-10-29 05:36:40', '2024-09-24 05:51:14'),
(4, 'system_email', 'academy@example.com', '2023-10-29 05:36:40', '2024-09-24 05:51:14'),
(5, 'address', 'Sydney, Australia', '2023-10-29 05:36:40', '2024-09-24 05:51:14'),
(6, 'phone', '+143-52-9933631', '2023-10-29 05:36:40', '2024-09-24 05:51:14'),
(7, 'purchase_code', 'your-purchase-code', '2023-10-29 05:36:40', '2024-09-24 05:51:14'),
(8, 'paypal', '[{\"active\":\"1\",\"mode\":\"sandbox\",\"sandbox_client_id\":\"AfGaziKslex-scLAyYdDYXNFaz2aL5qGau-SbDgE_D2E80D3AFauLagP8e0kCq9au7W4IasmFbirUUYc\",\"sandbox_secret_key\":\"EMa5pCTuOpmHkhHaCGibGhVUcKg0yt5-C3CzJw-OWJCzaXXzTlyD17SICob_BkfM_0Nlk7TWnN42cbGz\",\"production_client_id\":\"1234\",\"production_secret_key\":\"12345\"}]', '2023-10-29 05:36:40', '2023-10-29 05:36:40'),
(9, 'stripe_keys', '[{\"active\":\"1\",\"testmode\":\"on\",\"public_key\":\"pk_test_CAC3cB1mhgkJqXtypYBTGb4f\",\"secret_key\":\"sk_test_iatnshcHhQVRXdygXw3L2Pp2\",\"public_live_key\":\"pk_live_xxxxxxxxxxxxxxxxxxxxxxxx\",\"secret_live_key\":\"sk_live_xxxxxxxxxxxxxxxxxxxxxxxx\"}]', '2023-10-29 05:36:40', '2023-10-29 05:36:40'),
(10, 'youtube_api_key', 'youtube-and-google-drive-api-key', '2023-10-29 05:36:40', '2024-09-24 05:51:14'),
(11, 'vimeo_api_key', 'vimeo-api-key', '2023-10-29 05:36:40', '2024-09-24 05:51:14'),
(12, 'slogan', 'A course based video CMS', '2023-10-29 05:36:40', '2024-09-24 05:51:14'),
(13, 'text_align', NULL, '2023-10-29 05:36:40', '2023-10-29 05:36:40'),
(14, 'allow_instructor', '1', '2023-10-29 05:36:40', '2023-12-05 23:04:06'),
(15, 'instructor_revenue', '70', '2023-10-29 05:36:40', '2023-12-05 23:04:11'),
(16, 'system_currency', 'INR', '2023-10-29 05:36:40', '2024-10-30 01:47:54'),
(17, 'paypal_currency', 'USD', '2023-10-29 05:36:40', '2023-10-29 05:36:40'),
(18, 'stripe_currency', 'USD', '2023-10-29 05:36:40', '2023-10-29 05:36:40'),
(19, 'author', 'Creativeitem', '2023-10-29 05:36:40', '2024-09-24 05:51:14'),
(20, 'currency_position', 'right-space', '2023-10-29 05:36:40', '2024-10-30 01:47:54'),
(21, 'website_description', 'Talemy is your ideal education the WordPress theme for sharing and selling your knowledge online. Teach what you love. Talemy gives you the tools.', '2023-10-29 05:36:40', '2024-09-24 05:51:14'),
(22, 'website_keywords', 'LMS,Learning Management System,Creativeitem,Academy LMS', '2023-10-29 05:36:40', '2024-09-24 05:51:14'),
(23, 'footer_text', 'Creativeitem', '2023-10-29 05:36:40', '2024-09-24 05:51:14'),
(24, 'footer_link', 'https://creativeitem.com/', '2023-10-29 05:36:40', '2024-09-24 05:51:14'),
(25, 'protocol', 'smtp', '2023-10-29 05:36:40', '2024-09-24 06:07:39'),
(26, 'smtp_host', 'smtp.gmail.com', '2023-10-29 05:36:40', '2024-09-24 06:07:39'),
(27, 'smtp_port', '465', '2023-10-29 05:36:40', '2024-09-24 06:07:39'),
(28, 'smtp_user', 'your-email-address', '2023-10-29 05:36:40', '2024-09-24 06:07:39'),
(29, 'smtp_pass', 'enter-your-smtp-password', '2023-10-29 05:36:40', '2024-09-24 06:07:39'),
(30, 'version', '1.3', '2023-10-29 05:36:40', '2023-10-29 05:36:40'),
(31, 'student_email_verification', 'disable', '2023-10-29 05:36:40', '2023-12-05 00:54:45'),
(32, 'instructor_application_note', 'Fill all the fields carefully and share if you want to share any document with us it will help us to evaluate you as an instructor. dfdfs', '2023-10-29 05:36:40', '2023-12-05 23:04:06'),
(33, 'razorpay_keys', '[{\"active\":\"1\",\"key\":\"rzp_test_J60bqBOi1z1aF5\",\"secret_key\":\"uk935K7p4j96UCJgHK8kAU4q\",\"theme_color\":\"#c7a600\"}]', '2023-10-29 05:36:40', '2023-10-29 05:36:40'),
(34, 'razorpay_currency', 'USD', '2023-10-29 05:36:40', '2023-10-29 05:36:40'),
(35, 'fb_app_id', 'fb-app-id', '2023-10-29 05:36:40', '2023-10-29 05:36:40'),
(36, 'fb_app_secret', 'fb-app-secret', '2023-10-29 05:36:40', '2023-10-29 05:36:40'),
(37, 'fb_social_login', '0', '2023-10-29 05:36:40', '2023-10-29 05:36:40'),
(38, 'drip_content_settings', '{\"lesson_completion_role\":\"duration\",\"minimum_duration\":\"15:30:00\",\"minimum_percentage\":\"60\",\"locked_lesson_message\":\"<h3 xss=\\\"removed\\\" style=\\\"text-align: center; \\\"><span xss=\\\"removed\\\" style=\\\"\\\">Permission denied!<\\/span><\\/h3><p xss=\\\"removed\\\" style=\\\"text-align: center; \\\"><span xss=\\\"removed\\\">This course supports drip content, so you must complete the previous lessons.<\\/span><\\/p>\",\"files\":null}', '2023-10-29 05:36:40', '2023-10-29 05:26:38'),
(41, 'course_accessibility', 'publicly', '2023-10-29 05:36:40', '2023-12-05 00:54:45'),
(42, 'smtp_crypto', 'ssl', '2023-10-29 05:36:40', '2024-09-24 06:07:39'),
(47, 'academy_cloud_access_token', 'jdfghasdfasdfasdfasdfasdf', '2023-10-29 05:36:40', '2023-10-29 05:36:40'),
(48, 'course_selling_tax', '0', '2023-10-29 05:36:40', '2024-09-24 05:51:14'),
(49, 'ccavenue_keys', '[{\"active\":\"1\",\"ccavenue_merchant_id\":\"cmi_xxxxxx\",\"ccavenue_working_key\":\"cwk_xxxxxxxxxxxx\",\"ccavenue_access_code\":\"ccc_xxxxxxxxxxxxx\"}]', '2023-10-29 05:36:40', '2023-10-29 05:36:40'),
(50, 'ccavenue_currency', 'INR', '2023-10-29 05:36:40', '2023-10-29 05:36:40'),
(51, 'iyzico_keys', '[{\"active\":\"1\",\"testmode\":\"on\",\"iyzico_currency\":\"TRY\",\"api_test_key\":\"atk_xxxxxxxx\",\"secret_test_key\":\"stk_xxxxxxxx\",\"api_live_key\":\"alk_xxxxxxxx\",\"secret_live_key\":\"slk_xxxxxxxx\"}]', '2023-10-29 05:36:40', '2023-10-29 05:36:40'),
(52, 'iyzico_currency', 'TRY', '2023-10-29 05:36:40', '2023-10-29 05:36:40'),
(53, 'paystack_keys', '[{\"active\":\"1\",\"testmode\":\"on\",\"secret_test_key\":\"sk_test_c746060e693dd50c6f397dffc6c3b2f655217c94\",\"public_test_key\":\"pk_test_0816abbed3c339b8473ff22f970c7da1c78cbe1b\",\"secret_live_key\":\"sk_live_xxxxxxxxxxxxxxxxxxxxx\",\"public_live_key\":\"pk_live_xxxxxxxxxxxxxxxxxxxxx\"}]', '2023-10-29 05:36:40', '2023-10-29 05:36:40'),
(54, 'paystack_currency', 'NGN', '2023-10-29 05:36:40', '2023-10-29 05:36:40'),
(55, 'paytm_keys', '[{\"PAYTM_MERCHANT_KEY\":\"PAYTM_MERCHANT_KEY\",\"PAYTM_MERCHANT_MID\":\"PAYTM_MERCHANT_MID\",\"PAYTM_MERCHANT_WEBSITE\":\"DEFAULT\",\"INDUSTRY_TYPE_ID\":\"Retail\",\"CHANNEL_ID\":\"WEB\"}]', '2023-10-29 05:36:40', '2023-10-29 05:36:40'),
(57, 'google_analytics_id', NULL, '2023-10-29 05:36:40', '2023-12-05 00:54:45'),
(58, 'meta_pixel_id', NULL, '2023-10-29 05:36:40', '2023-12-05 00:54:45'),
(59, 'smtp_from_email', 'your-email-address', '2023-10-29 05:36:40', '2024-09-24 06:07:39'),
(61, 'language_dirs', '{\"english\":\"ltr\",\"hindi\":\"rtl\",\"arabic\":\"rtl\"}', '2023-10-29 05:36:40', '2023-10-29 05:36:40'),
(62, 'certificate_template', 'uploads/certificate-template/certificate-default.png', '2024-03-12 08:17:10', '2024-08-27 05:21:49'),
(63, 'certificate_builder_content', '<style>\n            @import url(\'https://fonts.googleapis.com/css2?family=Italianno&display=swap\');\n            @import url(\'https://fonts.googleapis.com/css2?family=Pinyon+Script&display=swap%27\');\n            @import url(\'https://fonts.googleapis.com/css2?family=Miss+Fajardose&display=swap%27\');\n        </style>\n        \n\n                                <style>\n            @import url(\'https://fonts.googleapis.com/css2?family=Italianno&display=swap\');\n            @import url(\'https://fonts.googleapis.com/css2?family=Pinyon+Script&display=swap%27\');\n            @import url(\'https://fonts.googleapis.com/css2?family=Miss+Fajardose&display=swap%27\');\n        </style>\n        \n\n                                <style>\n            @import url(\'https://fonts.googleapis.com/css2?family=Italianno&display=swap\');\n            @import url(\'https://fonts.googleapis.com/css2?family=Pinyon+Script&display=swap%27\');\n            @import url(\'https://fonts.googleapis.com/css2?family=Miss+Fajardose&display=swap%27\');\n        </style>\n        \n\n                                <style>\n            @import url(\'https://fonts.googleapis.com/css2?family=Italianno&display=swap\');\n            @import url(\'https://fonts.googleapis.com/css2?family=Pinyon+Script&display=swap%27\');\n            @import url(\'https://fonts.googleapis.com/css2?family=Miss+Fajardose&display=swap%27\');\n        </style>\n        \n\n                                <style>\n            @import url(\'https://fonts.googleapis.com/css2?family=Italianno&display=swap\');\n            @import url(\'https://fonts.googleapis.com/css2?family=Pinyon+Script&display=swap%27\');\n            @import url(\'https://fonts.googleapis.com/css2?family=Miss+Fajardose&display=swap%27\');\n        </style>\n        \n\n                                \n<style>\n            @import url(\'https://fonts.googleapis.com/css2?family=Italianno&display=swap\');\n            @import url(\'https://fonts.googleapis.com/css2?family=Pinyon+Script&display=swap%27\');\n            @import url(\'https://fonts.googleapis.com/css2?family=Miss+Fajardose&display=swap%27\');\n        </style><style>\n            @import url(\'https://fonts.googleapis.com/css2?family=Italianno&display=swap\');\n            @import url(\'https://fonts.googleapis.com/css2?family=Pinyon+Script&display=swap%27\');\n            @import url(\'https://fonts.googleapis.com/css2?family=Miss+Fajardose&display=swap%27\');\n        </style><style>\n            @import url(\'https://fonts.googleapis.com/css2?family=Italianno&display=swap\');\n            @import url(\'https://fonts.googleapis.com/css2?family=Pinyon+Script&display=swap%27\');\n            @import url(\'https://fonts.googleapis.com/css2?family=Miss+Fajardose&display=swap%27\');\n        </style><style>\n            @import url(\'https://fonts.googleapis.com/css2?family=Italianno&display=swap\');\n            @import url(\'https://fonts.googleapis.com/css2?family=Pinyon+Script&display=swap%27\');\n            @import url(\'https://fonts.googleapis.com/css2?family=Miss+Fajardose&display=swap%27\');\n        </style><style>\n            @import url(\'https://fonts.googleapis.com/css2?family=Italianno&display=swap\');\n            @import url(\'https://fonts.googleapis.com/css2?family=Pinyon+Script&display=swap%27\');\n            @import url(\'https://fonts.googleapis.com/css2?family=Miss+Fajardose&display=swap%27\');\n        </style><style>\n            @import url(\'https://fonts.googleapis.com/css2?family=Italianno&display=swap\');\n            @import url(\'https://fonts.googleapis.com/css2?family=Pinyon+Script&display=swap%27\');\n            @import url(\'https://fonts.googleapis.com/css2?family=Miss+Fajardose&display=swap%27\');\n        </style><style>\n            @import url(\'https://fonts.googleapis.com/css2?family=Italianno&display=swap\');\n            @import url(\'https://fonts.googleapis.com/css2?family=Pinyon+Script&display=swap%27\');\n            @import url(\'https://fonts.googleapis.com/css2?family=Miss+Fajardose&display=swap%27\');\n        </style><style>\n            @import url(\'https://fonts.googleapis.com/css2?family=Italianno&display=swap\');\n            @import url(\'https://fonts.googleapis.com/css2?family=Pinyon+Script&display=swap%27\');\n            @import url(\'https://fonts.googleapis.com/css2?family=Miss+Fajardose&display=swap%27\');\n        </style><style>\n            @import url(\'https://fonts.googleapis.com/css2?family=Italianno&display=swap\');\n            @import url(\'https://fonts.googleapis.com/css2?family=Pinyon+Script&display=swap%27\');\n            @import url(\'https://fonts.googleapis.com/css2?family=Miss+Fajardose&display=swap%27\');\n        </style><div id=\"certificate-layout-module\" class=\"certificate-layout-module resizeable-canvas draggable ui-draggable ui-draggable-handle ui-resizable hidden-position\" style=\"position: relative; width: 1069.2px; height: 755.055px; left: 0px; top: -1px;\" bis_skin_checked=\"1\">\n                <img class=\"certificate-template\" style=\"width: 100%; height: 100%;\" src=\"http://localhost/academy-laravel/academy_1.4/public/uploads/certificate-template/certificate-default.png\"><div class=\"ui-resizable-handle ui-resizable-e\" style=\"z-index: 90;\" bis_skin_checked=\"1\"></div><div class=\"ui-resizable-handle ui-resizable-s\" style=\"z-index: 90;\" bis_skin_checked=\"1\"></div><div class=\"ui-resizable-handle ui-resizable-se ui-icon ui-icon-gripsmall-diagonal-se\" style=\"z-index: 90;\" bis_skin_checked=\"1\"></div><div class=\"draggable resizeable-canvas ui-draggable ui-draggable-handle ui-resizable\" style=\"position: absolute; font-size: 16px; top: 114px; left: 93px; width: 84.8906px; font-family: &quot;auto&quot;; padding: 5px !important; height: 80px;\" bis_skin_checked=\"1\">\n                {qr_code}\n                <i class=\"remove-item fi-rr-cross-circle cursor-pointer\" onclick=\"$(this).parent().remove()\">\n            </i><div class=\"ui-resizable-handle ui-resizable-e\" style=\"z-index: 90;\" bis_skin_checked=\"1\"></div><div class=\"ui-resizable-handle ui-resizable-s\" style=\"z-index: 90;\" bis_skin_checked=\"1\"></div><div class=\"ui-resizable-handle ui-resizable-se ui-icon ui-icon-gripsmall-diagonal-se\" style=\"z-index: 90;\" bis_skin_checked=\"1\"></div></div><div class=\"draggable resizeable-canvas ui-draggable ui-draggable-handle ui-resizable\" style=\"position: absolute; font-size: 18px; top: 546px; left: 125px; width: 210.031px; font-family: &quot;Pinyon Script&quot;; padding: 5px !important; height: 37px;\" bis_skin_checked=\"1\">\n                {instructor_name}\n                <i class=\"remove-item fi-rr-cross-circle cursor-pointer\" onclick=\"$(this).parent().remove()\">\n            </i><div class=\"ui-resizable-handle ui-resizable-e\" style=\"z-index: 90;\" bis_skin_checked=\"1\"></div><div class=\"ui-resizable-handle ui-resizable-s\" style=\"z-index: 90;\" bis_skin_checked=\"1\"></div><div class=\"ui-resizable-handle ui-resizable-se ui-icon ui-icon-gripsmall-diagonal-se\" style=\"z-index: 90;\" bis_skin_checked=\"1\"></div></div><div class=\"draggable resizeable-canvas ui-draggable ui-draggable-handle ui-resizable\" style=\"position: absolute; font-size: 18px; top: 546px; left: 724px; width: 210.188px; font-family: &quot;Pinyon Script&quot;; padding: 5px !important; height: 39px;\" bis_skin_checked=\"1\">\n                {student_name}\n                <i class=\"remove-item fi-rr-cross-circle cursor-pointer\" onclick=\"$(this).parent().remove()\">\n            </i><div class=\"ui-resizable-handle ui-resizable-e\" style=\"z-index: 90;\" bis_skin_checked=\"1\"></div><div class=\"ui-resizable-handle ui-resizable-s\" style=\"z-index: 90;\" bis_skin_checked=\"1\"></div><div class=\"ui-resizable-handle ui-resizable-se ui-icon ui-icon-gripsmall-diagonal-se\" style=\"z-index: 90;\" bis_skin_checked=\"1\"></div></div><div class=\"draggable resizeable-canvas ui-draggable ui-draggable-handle ui-resizable\" style=\"position: absolute; font-size: 16px; top: 545px; left: 442px; width: min-content; font-family: &quot;auto&quot;; padding: 5px !important;\" bis_skin_checked=\"1\">\n                {course_completion_date}\n                <i class=\"remove-item fi-rr-cross-circle cursor-pointer\" onclick=\"$(this).parent().remove()\">\n            </i><div class=\"ui-resizable-handle ui-resizable-e\" style=\"z-index: 90;\" bis_skin_checked=\"1\"></div><div class=\"ui-resizable-handle ui-resizable-s\" style=\"z-index: 90;\" bis_skin_checked=\"1\"></div><div class=\"ui-resizable-handle ui-resizable-se ui-icon ui-icon-gripsmall-diagonal-se\" style=\"z-index: 90;\" bis_skin_checked=\"1\"></div></div><div class=\"draggable resizeable-canvas ui-draggable ui-draggable-handle ui-resizable\" style=\"position: absolute; font-size: 12px; top: 665px; left: 457px; width: min-content; font-family: &quot;auto&quot;; padding: 5px !important;\" bis_skin_checked=\"1\">\n                {certificate_download_date}\n                <i class=\"remove-item fi-rr-cross-circle cursor-pointer\" onclick=\"$(this).parent().remove()\">\n            </i><div class=\"ui-resizable-handle ui-resizable-e\" style=\"z-index: 90;\" bis_skin_checked=\"1\"></div><div class=\"ui-resizable-handle ui-resizable-s\" style=\"z-index: 90;\" bis_skin_checked=\"1\"></div><div class=\"ui-resizable-handle ui-resizable-se ui-icon ui-icon-gripsmall-diagonal-se\" style=\"z-index: 90;\" bis_skin_checked=\"1\"></div></div><div class=\"draggable resizeable-canvas ui-draggable ui-draggable-handle ui-resizable\" style=\"position: absolute;font-size: 30px;top: 136px;left: 264px;width: 534.336px;padding: 5px !important;height: 62px;font-family: auto;\" bis_skin_checked=\"1\">\n                COURSE COMPLETION CERTIFICATE\n                <i class=\"remove-item fi-rr-cross-circle cursor-pointer\" onclick=\"$(this).parent().remove()\">\n            </i><div class=\"ui-resizable-handle ui-resizable-e\" style=\"z-index: 90;\" bis_skin_checked=\"1\"></div><div class=\"ui-resizable-handle ui-resizable-s\" style=\"z-index: 90;\" bis_skin_checked=\"1\"></div><div class=\"ui-resizable-handle ui-resizable-se ui-icon ui-icon-gripsmall-diagonal-se\" style=\"z-index: 90;\" bis_skin_checked=\"1\"></div></div><div class=\"draggable resizeable-canvas ui-draggable ui-draggable-handle ui-resizable\" style=\"position: absolute; font-size: 18px; top: 211px; left: 205px; width: 664.5px; font-family: &quot;Pinyon Script&quot;; padding: 5px !important; height: 98px;\" bis_skin_checked=\"1\">\n                This certificate is awarded to {student_name} in recognition of their successful completion of Course on {course_completion_date}. Your hard work, dedication, and commitment to learning have enabled you to achieve this milestone, and we are proud to recognize your accomplishment.\n                <i class=\"remove-item fi-rr-cross-circle cursor-pointer\" onclick=\"$(this).parent().remove()\">\n            </i><div class=\"ui-resizable-handle ui-resizable-e\" style=\"z-index: 90;\" bis_skin_checked=\"1\"></div><div class=\"ui-resizable-handle ui-resizable-s\" style=\"z-index: 90;\" bis_skin_checked=\"1\"></div><div class=\"ui-resizable-handle ui-resizable-se ui-icon ui-icon-gripsmall-diagonal-se\" style=\"z-index: 90;\" bis_skin_checked=\"1\"></div></div><div class=\"draggable resizeable-canvas ui-draggable ui-draggable-handle ui-resizable\" style=\"position: absolute; font-size: 18px; top: 316px; left: 315px; width: 428.25px; font-family: &quot;auto&quot;; padding: 5px !important; height: 48px;\" bis_skin_checked=\"1\">\n                {course_title}\n                <i class=\"remove-item fi-rr-cross-circle cursor-pointer\" onclick=\"$(this).parent().remove()\">\n            </i><div class=\"ui-resizable-handle ui-resizable-e\" style=\"z-index: 90;\" bis_skin_checked=\"1\"></div><div class=\"ui-resizable-handle ui-resizable-s\" style=\"z-index: 90;\" bis_skin_checked=\"1\"></div><div class=\"ui-resizable-handle ui-resizable-se ui-icon ui-icon-gripsmall-diagonal-se\" style=\"z-index: 90;\" bis_skin_checked=\"1\"></div></div></div>', '2024-03-12 08:17:50', '2024-10-29 01:43:51'),
(64, '_token', 'tEYJPyWB4tjFp0tz78j0gDLj07tLXnw5hVpU5mX7', '2024-03-12 08:18:24', '2024-08-27 05:25:46'),
(65, 'zoom_account_email', 'example@gmail.com', '2024-03-12 08:18:24', '2024-08-27 05:19:46'),
(66, 'zoom_account_id', 'RG4XYxxxxxxxxxxxxxxx', '2024-03-12 08:18:24', '2024-08-27 05:19:46'),
(67, 'zoom_client_id', 'mFgJ4xxxxxxxxxxxxxxx', '2024-03-12 08:18:24', '2024-08-27 05:19:46'),
(68, 'zoom_client_secret', 'OZ6m9xxxxxxxxxxxxxxxx', '2024-03-12 08:18:24', '2024-08-27 05:19:46'),
(69, 'zoom_web_sdk', 'active', '2024-03-12 08:18:24', '2024-08-27 05:19:46'),
(70, 'zoom_sdk_client_id', '7M6Wxxxxxxxxxxxx', '2024-03-12 08:18:24', '2024-08-27 05:19:46'),
(71, 'zoom_sdk_client_secret', 'z1Nzxxxxxxxxxxxxxx', '2024-03-12 08:18:24', '2024-08-27 05:19:46'),
(72, 'open_ai_model', 'gpt-3.5-turbo-0125', '2024-03-12 09:11:12', '2024-08-27 05:25:46'),
(73, 'open_ai_max_token', '100', '2024-03-12 09:11:12', '2024-08-27 05:25:46'),
(74, 'open_ai_secret_key', 'sk-JPYxxxxxxxxxxxxxxxxxxx', '2024-03-12 09:11:12', '2024-08-27 05:25:46'),
(75, 'timezone', 'Asia/Dhaka', '2024-07-01 02:06:24', '2024-07-01 08:06:24'),
(76, 'device_limitation', '10', '2023-10-29 05:36:40', '2024-09-24 05:51:14');

-- --------------------------------------------------------

--
-- Table structure for table `team_package_members`
--

CREATE TABLE `team_package_members` (
  `id` int(11) NOT NULL,
  `leader_id` int(11) DEFAULT NULL,
  `team_package_id` int(11) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `team_package_purchases`
--

CREATE TABLE `team_package_purchases` (
  `id` int(11) NOT NULL,
  `invoice` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `package_id` int(11) DEFAULT NULL,
  `price` float(10,2) DEFAULT NULL,
  `admin_revenue` float(10,2) DEFAULT NULL,
  `instructor_revenue` float(10,2) DEFAULT NULL,
  `tax` float(10,2) DEFAULT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_details` text COLLATE utf8mb4_unicode_ci,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `team_training_packages`
--

CREATE TABLE `team_training_packages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` double(10,2) DEFAULT NULL,
  `course_privacy` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `allocation` int(11) DEFAULT NULL,
  `expiry_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` int(11) DEFAULT NULL,
  `expiry_date` int(11) DEFAULT NULL,
  `features` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `thumbnail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pricing_type` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `skills` text COLLATE utf8mb4_unicode_ci,
  `facebook` text COLLATE utf8mb4_unicode_ci,
  `twitter` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linkedin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about` text COLLATE utf8mb4_unicode_ci,
  `biography` longtext COLLATE utf8mb4_unicode_ci,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paymentkeys` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_reviews`
--

CREATE TABLE `user_reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `review` longtext COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `watch_durations`
--

CREATE TABLE `watch_durations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `watch_histories`
--

CREATE TABLE `watch_histories` (
  `id` int(255) UNSIGNED NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `completed_lesson` longtext COLLATE utf8mb4_unicode_ci,
  `watching_lesson_id` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `completed_date` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(255) DEFAULT NULL,
  `course_id` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addtocarts`
--
ALTER TABLE `addtocarts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_comments`
--
ALTER TABLE `blog_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_likes`
--
ALTER TABLE `blog_likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bootcamps`
--
ALTER TABLE `bootcamps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bootcamp_categories`
--
ALTER TABLE `bootcamp_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bootcamp_live_classes`
--
ALTER TABLE `bootcamp_live_classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bootcamp_modules`
--
ALTER TABLE `bootcamp_modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bootcamp_purchases`
--
ALTER TABLE `bootcamp_purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bootcamp_resources`
--
ALTER TABLE `bootcamp_resources`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `builder_pages`
--
ALTER TABLE `builder_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_parent_id_index` (`parent_id`);

--
-- Indexes for table `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `certificates_identifier_unique` (`identifier`),
  ADD KEY `certificates_user_id_index` (`user_id`),
  ADD KEY `certificates_course_id_index` (`course_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `courses_user_id_index` (`user_id`),
  ADD KEY `courses_category_id_index` (`category_id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `device_ips`
--
ALTER TABLE `device_ips`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `enrollments_user_id_index` (`user_id`),
  ADD KEY `enrollments_course_id_index` (`course_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `forums`
--
ALTER TABLE `forums`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `frontend_settings`
--
ALTER TABLE `frontend_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `home_page_settings`
--
ALTER TABLE `home_page_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `instructor_reviews`
--
ALTER TABLE `instructor_reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `language_phrases`
--
ALTER TABLE `language_phrases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `language_phrases_language_id_index` (`language_id`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lessons_user_id_index` (`user_id`),
  ADD KEY `lessons_course_id_index` (`course_id`),
  ADD KEY `lessons_section_id_index` (`section_id`);

--
-- Indexes for table `like_dislike_reviews`
--
ALTER TABLE `like_dislike_reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `live_classes`
--
ALTER TABLE `live_classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `live_classes_user_id_index` (`user_id`),
  ADD KEY `live_classes_course_id_index` (`course_id`);

--
-- Indexes for table `media_files`
--
ALTER TABLE `media_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message_threads`
--
ALTER TABLE `message_threads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `message_thread_sender_foreign` (`contact_one`),
  ADD KEY `message_thread_receiver_foreign` (`contact_two`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newsletters`
--
ALTER TABLE `newsletters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_settings`
--
ALTER TABLE `notification_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offline_payments`
--
ALTER TABLE `offline_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payment_gateways`
--
ALTER TABLE `payment_gateways`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_histories`
--
ALTER TABLE `payment_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payouts`
--
ALTER TABLE `payouts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `player_settings`
--
ALTER TABLE `player_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz_submissions`
--
ALTER TABLE `quiz_submissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sections_user_id_index` (`user_id`),
  ADD KEY `sections_course_id_index` (`course_id`);

--
-- Indexes for table `seo_fields`
--
ALTER TABLE `seo_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team_package_members`
--
ALTER TABLE `team_package_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team_package_purchases`
--
ALTER TABLE `team_package_purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team_training_packages`
--
ALTER TABLE `team_training_packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_reviews`
--
ALTER TABLE `user_reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `watch_durations`
--
ALTER TABLE `watch_durations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `watch_histories`
--
ALTER TABLE `watch_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addtocarts`
--
ALTER TABLE `addtocarts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_comments`
--
ALTER TABLE `blog_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_likes`
--
ALTER TABLE `blog_likes`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bootcamps`
--
ALTER TABLE `bootcamps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bootcamp_categories`
--
ALTER TABLE `bootcamp_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bootcamp_live_classes`
--
ALTER TABLE `bootcamp_live_classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bootcamp_modules`
--
ALTER TABLE `bootcamp_modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bootcamp_purchases`
--
ALTER TABLE `bootcamp_purchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bootcamp_resources`
--
ALTER TABLE `bootcamp_resources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `builder_pages`
--
ALTER TABLE `builder_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `certificates`
--
ALTER TABLE `certificates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(21) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=165;

--
-- AUTO_INCREMENT for table `device_ips`
--
ALTER TABLE `device_ips`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `forums`
--
ALTER TABLE `forums`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `frontend_settings`
--
ALTER TABLE `frontend_settings`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `home_page_settings`
--
ALTER TABLE `home_page_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `instructor_reviews`
--
ALTER TABLE `instructor_reviews`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `language_phrases`
--
ALTER TABLE `language_phrases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=798;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `like_dislike_reviews`
--
ALTER TABLE `like_dislike_reviews`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `live_classes`
--
ALTER TABLE `live_classes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `media_files`
--
ALTER TABLE `media_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `message_threads`
--
ALTER TABLE `message_threads`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `newsletters`
--
ALTER TABLE `newsletters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_settings`
--
ALTER TABLE `notification_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `offline_payments`
--
ALTER TABLE `offline_payments`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_gateways`
--
ALTER TABLE `payment_gateways`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `payment_histories`
--
ALTER TABLE `payment_histories`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payouts`
--
ALTER TABLE `payouts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `player_settings`
--
ALTER TABLE `player_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz_submissions`
--
ALTER TABLE `quiz_submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `seo_fields`
--
ALTER TABLE `seo_fields`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `team_package_members`
--
ALTER TABLE `team_package_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `team_package_purchases`
--
ALTER TABLE `team_package_purchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `team_training_packages`
--
ALTER TABLE `team_training_packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_reviews`
--
ALTER TABLE `user_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `watch_durations`
--
ALTER TABLE `watch_durations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `watch_histories`
--
ALTER TABLE `watch_histories`
  MODIFY `id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
