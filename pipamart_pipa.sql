-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 09, 2021 at 11:43 AM
-- Server version: 5.7.31-cll-lve
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pipamart_pipa`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_addresses`
--

CREATE TABLE `tbl_addresses` (
  `id` int(10) NOT NULL,
  `user_id` int(5) NOT NULL,
  `pincode` varchar(10) NOT NULL,
  `gstno` varchar(255) NOT NULL,
  `building_name` varchar(100) NOT NULL,
  `road_area_colony` text NOT NULL,
  `city` varchar(100) NOT NULL,
  `district` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `landmark` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile_no` varchar(20) NOT NULL,
  `alter_mobile_no` varchar(20) NOT NULL,
  `address_type` varchar(30) NOT NULL,
  `is_default` varchar(10) NOT NULL DEFAULT 'false',
  `created_at` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_addresses`
--

INSERT INTO `tbl_addresses` (`id`, `user_id`, `pincode`, `gstno`, `building_name`, `road_area_colony`, `city`, `district`, `state`, `country`, `landmark`, `name`, `email`, `mobile_no`, `alter_mobile_no`, `address_type`, `is_default`, `created_at`) VALUES
(1, 1, '401305', 'aaefcqefc', 'vasai virar', 'kala hanuman road', 'virar', '', 'Maharashtra', 'Australia', 'virar', 'shubham bhuvad', 'shubhambhuvad567@gmail.com', '+618830516259', '8830516259', '1', 'true', '1625746367'),
(2, 2, '306422', '', 'vfdc   dzf zsdf zf zdf dfz d dfz fd', 'dgvdsfzvb', 'Pali', 'Pali', 'Rajasthan', 'India', 'dfbfd', 'jit', 'jitendrag645@gmail.com', '9024645458', '9172409194', '1', 'true', '1625998254');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `username`, `password`, `email`, `image`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'viaviwebtech@gmail.com', '29102020094838_89371_24092019015612_71951_user.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_android_settings`
--

CREATE TABLE `tbl_android_settings` (
  `id` int(11) NOT NULL,
  `onesignal_app_id` text NOT NULL,
  `onesignal_rest_key` text NOT NULL,
  `api_all_order_by` varchar(255) NOT NULL,
  `api_home_limit` int(5) NOT NULL DEFAULT '5',
  `api_page_limit` int(3) NOT NULL,
  `api_cat_order_by` varchar(255) NOT NULL,
  `api_cat_post_order_by` varchar(255) NOT NULL,
  `publisher_id` text NOT NULL,
  `interstital_ad` text NOT NULL,
  `interstital_ad_id` text NOT NULL,
  `interstital_ad_click` varchar(255) NOT NULL,
  `banner_ad` text NOT NULL,
  `banner_ad_id` text NOT NULL,
  `banner_ad_type` varchar(30) NOT NULL DEFAULT 'admob',
  `banner_facebook_id` text NOT NULL,
  `interstital_ad_type` varchar(30) NOT NULL DEFAULT 'admob',
  `interstital_facebook_id` text NOT NULL,
  `native_ad` varchar(20) NOT NULL DEFAULT 'false',
  `app_update_status` varchar(10) NOT NULL DEFAULT 'false',
  `app_new_version` double NOT NULL,
  `app_update_desc` text NOT NULL,
  `app_redirect_url` text NOT NULL,
  `cancel_update_status` varchar(10) NOT NULL DEFAULT 'false'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_android_settings`
--

INSERT INTO `tbl_android_settings` (`id`, `onesignal_app_id`, `onesignal_rest_key`, `api_all_order_by`, `api_home_limit`, `api_page_limit`, `api_cat_order_by`, `api_cat_post_order_by`, `publisher_id`, `interstital_ad`, `interstital_ad_id`, `interstital_ad_click`, `banner_ad`, `banner_ad_id`, `banner_ad_type`, `banner_facebook_id`, `interstital_ad_type`, `interstital_facebook_id`, `native_ad`, `app_update_status`, `app_new_version`, `app_update_desc`, `app_redirect_url`, `cancel_update_status`) VALUES
(1, '', '', 'ASC', 5, 20, 'category_name', 'DESC', 'pub-3940256099942544', 'false', 'ca-app-pub-3940256099942544/1033173712', '3', 'false', 'ca-app-pub-3940256099942544/6300978111', 'admob', 'IMG_16_9_APP_INSTALL#288347782353524_288349185686717', 'admob', 'IMG_16_9_APP_INSTALL#293685261999350_293698135331396', 'false', 'false', 2, 'kindly you can update new version app', 'https://play.google.com/store/apps/developer?id=Viaan+Parmar', 'false');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_applied_coupon`
--

CREATE TABLE `tbl_applied_coupon` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `cart_id` int(10) NOT NULL,
  `cart_type` varchar(20) NOT NULL,
  `coupon_id` int(10) NOT NULL,
  `applied_on` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bank_details`
--

CREATE TABLE `tbl_bank_details` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `bank_holder_name` varchar(150) NOT NULL,
  `bank_holder_phone` varchar(20) NOT NULL,
  `bank_holder_email` varchar(150) NOT NULL,
  `account_no` varchar(100) NOT NULL,
  `account_type` varchar(50) NOT NULL,
  `bank_ifsc` varchar(20) NOT NULL,
  `bank_name` varchar(150) NOT NULL,
  `is_default` int(1) NOT NULL DEFAULT '0',
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_banner`
--

CREATE TABLE `tbl_banner` (
  `id` int(10) NOT NULL,
  `banner_title` varchar(150) NOT NULL,
  `banner_slug` varchar(150) NOT NULL,
  `banner_desc` text NOT NULL,
  `banner_image` text NOT NULL,
  `product_ids` longtext NOT NULL,
  `offer_id` int(10) NOT NULL DEFAULT '0',
  `created_at` varchar(150) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_banner`
--

INSERT INTO `tbl_banner` (`id`, `banner_title`, `banner_slug`, `banner_desc`, `banner_image`, `product_ids`, `offer_id`, `created_at`, `status`) VALUES
(1, 'Sale Keyboard Up To 20% Off', 'sale-keyboard-up-to-20-off', '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n', '03012020044445_84207.jpg', '', 0, '1561701428', 0),
(5, '40% off on kid\'s footwear', '40-off-on-kids-footwear', '<p>40% off on kid&#39;s footwear</p>\r\n', '03012020044022_64387.jpg', '', 0, '1578049822', 1),
(6, 'It\'s time for bata shoes and so on', 'its-time-for-bata-shoes-and-so-on', '<p>It&#39;s time for bata shoes and so on</p>\r\n', '03012020054220_70825.jpg', '', 0, '1578049897', 0),
(7, 'Get Discount And Mega Savings!', 'get-discount-and-mega-savings', '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry.</p>\r\n', '07102020041256_47520.jpg', '', 1, '1578721023', 1),
(8, 'b1', 'b1', '<p>asdf</p>\r\n', '23012021120825_47472.jpg', '', 0, '1611383906', 1),
(9, 'b2', 'b2', '<p>asdf</p>\r\n', '23012021120856_95253.jpg', '88', 0, '1611383936', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_brands`
--

CREATE TABLE `tbl_brands` (
  `id` int(10) NOT NULL,
  `category_id` text NOT NULL,
  `brand_name` varchar(150) NOT NULL,
  `brand_slug` varchar(150) NOT NULL,
  `brand_image` text NOT NULL,
  `created_at` varchar(150) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_brands`
--

INSERT INTO `tbl_brands` (`id`, `category_id`, `brand_name`, `brand_slug`, `brand_image`, `created_at`, `status`) VALUES
(1, '1,2', 'MI', 'mi', '26062019120231_10046.jpg', '1561529708', 1),
(2, '1', 'Oppo', 'oppo', '26062019121537_27773.png', '1561530920', 1),
(3, '1,4', 'Samsung', 'samsung', '26062019121648_53623.jpg', '1561531608', 1),
(4, '1', 'Syska', 'syska', '26062019121733_30903.jpg', '1561531653', 1),
(5, '1', 'Intex', 'intex', '26062019122447_19092.jpg', '1561532088', 1),
(6, '1', 'Realme', 'realme', '27062019115530_55172.jpg', '1561616730', 1),
(7, '1', 'Sony', 'sony', '29062019031314_31118.png', '1561801394', 1),
(8, '2', 'Lee', 'lee', '20092019103947_91171_1200px_lee_logo.png', '1568964486', 1),
(9, '1', 'Lois Caron', 'lois-caron', '', '1575261645', 1),
(10, '9', 'Sukkhi', 'sukkhi', '26102020111104_21597.png', '1577679937', 1),
(11, '1,4', 'LG', 'lg', '26102020110444_27753.png', '1577874302', 1),
(12, '4', '7CR', '7cr', '', '1577876631', 1),
(13, '1', 'Acer', 'acer', '03012020054347_46780.jpg', '1578053628', 1),
(14, '2', 'Flying Machine', 'flying-machine', '09012020035158_74503.png', '1578565318', 1),
(15, '2', 'U.S. Polo Association', 'us-polo-association', '09012020043602_9090.jpg', '1578567962', 1),
(16, '2', 'GoButtonskart', 'gobuttonskart', '', '1578630266', 1),
(17, '1', 'LimeStone', 'limestone', '10012020122729_28805.png', '1578639449', 1),
(18, '1', 'Louis Devin', 'louis-devin', '', '1578646278', 1),
(19, '10', 'Puma', 'puma', '23012020023430_82852.jpg', '1579770270', 1),
(20, '10', 'Adidas', 'adidas', '23012020024612_53790.jpg', '1579770972', 1),
(21, '10', 'Fitze', 'fitze', '23012020033040_43717.jpg', '1579773640', 1),
(22, '10', 'Nike', 'nike', '23012020035705_58840.jpg', '1579775225', 1),
(23, '10', 'Beonza', 'beonza', '', '1579781611', 1),
(24, '13', 'Ecotattva', 'ecotattva', '', '1626255779', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cart`
--

CREATE TABLE `tbl_cart` (
  `id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `product_qty` int(5) NOT NULL DEFAULT '1',
  `product_size` varchar(10) NOT NULL DEFAULT '0',
  `created_at` varchar(150) NOT NULL,
  `cart_status` int(2) NOT NULL DEFAULT '1',
  `last_update` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_cart`
--

INSERT INTO `tbl_cart` (`id`, `product_id`, `user_id`, `product_qty`, `product_size`, `created_at`, `cart_status`, `last_update`) VALUES
(10, 76, 2, 1, '', '1626238969', 1, ''),
(11, 88, 3, 1, '', '1626258425', 1, ''),
(16, 0, 3, 0, '0', '1627711424', 1, ''),
(43, 88, 1, 1, '', '1627738630', 1, '1627738754');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cart_tmp`
--

CREATE TABLE `tbl_cart_tmp` (
  `id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `product_qty` int(5) NOT NULL DEFAULT '1',
  `product_size` varchar(10) NOT NULL DEFAULT '0',
  `created_at` varchar(150) NOT NULL,
  `cart_status` int(1) NOT NULL DEFAULT '1',
  `cart_unique_id` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_cart_tmp`
--

INSERT INTO `tbl_cart_tmp` (`id`, `product_id`, `user_id`, `product_qty`, `product_size`, `created_at`, `cart_status`, `cart_unique_id`) VALUES
(9, 0, 3, 0, '0', '1627711424', 1, ''),
(10, 0, 1, 0, '0', '1627711458', 1, ''),
(11, 0, 1, 0, '0', '1627711504', 1, ''),
(12, 0, 1, 0, '0', '1627725288', 1, ''),
(13, 0, 1, 0, '0', '1627737806', 1, ''),
(14, 0, 1, 0, '0', '1627737854', 1, ''),
(15, 0, 1, 0, '0', '1627737861', 1, ''),
(16, 0, 1, 0, '0', '1627737918', 1, ''),
(17, 0, 1, 0, '0', '1627737958', 1, ''),
(18, 88, 1, 1, 'S', '1627738092', 1, 'chkref_61054fe7487cf'),
(19, 88, 1, 1, 'S', '1627738278', 1, 'chkref_610550994ee99'),
(20, 88, 1, 1, 'S', '1627738630', 1, 'chkref_61055202e13a1'),
(21, 88, 1, 1, 'S', '1627738794', 1, 'chkref_610552a7dec9e'),
(22, 0, 1, 0, '0', '1633757978', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `id` int(10) NOT NULL,
  `category_name` varchar(150) NOT NULL,
  `category_slug` varchar(150) NOT NULL,
  `category_image` text NOT NULL,
  `product_features` longtext NOT NULL,
  `set_on_home` int(1) NOT NULL DEFAULT '0',
  `created_at` varchar(150) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`id`, `category_name`, `category_slug`, `category_image`, `product_features`, `set_on_home`, `created_at`, `status`) VALUES
(1, 'Farming & Gardening', 'farming-gardening', '12072021111320_45517.jpg', '', 1, '1568958951', 1),
(2, 'Pet Supplies', 'pet-supplies', '12072021111136_52217.jpg', '', 1, '1568961064', 1),
(4, 'Religious & Ceremonial', 'religious-ceremonial', '12072021111032_61092.jpg', '', 0, '1571826275', 1),
(9, 'Home & Kitchen', 'home-kitchen', '12072021110841_15029.jpg', '', 0, '1577679355', 1),
(10, 'Grocery', 'grocery', '12072021110708_64852.jpg', 'size', 1, '1578050258', 1),
(11, 'Beauty & Health', 'beauty-health', '10012020102548_56343.jpg', 'color', 0, '1578632148', 1),
(13, 'Fashion', 'fashion', '23012020044452_57023.jpg', 'color,size', 0, '1579778059', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cms_contents`
--

CREATE TABLE `tbl_cms_contents` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `flag` varchar(100) NOT NULL,
  `created_at` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_cms_contents`
--

INSERT INTO `tbl_cms_contents` (`id`, `title`, `description`, `flag`, `created_at`) VALUES
(1, 'terms', 'terms desc', 'terms', '1626190642'),
(3, 'refund', 'refunds', 'terms', '1626192377'),
(4, 'Refund Policy 1', 'trial 1', 'refund', '1626261197'),
(5, 'Refund policy 2', 'trial 2', 'refund', '1626261213'),
(6, 'Refund policy 3', 'trial 3', 'refund', '1626261227'),
(7, 'Refund policy 4', 'trial 4', 'refund', '1626261239'),
(8, 'Refund Policy 5', 'trial 5', 'refund', '1626261251'),
(9, 'Refund policy 6', 'trial 6', 'refund', '1626261263'),
(10, 's1', 't1', 'shipping', '1626285888'),
(11, 's2', 't2', 'shipping', '1626285896'),
(12, 's3', 't3', 'shipping', '1626285908'),
(13, 's4', 't4', 'shipping', '1626285918'),
(14, 's5', 't5', 'shipping', '1626285927'),
(15, 'carrer1', 'carrer1', 'career', '1626331725');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contact_list`
--

CREATE TABLE `tbl_contact_list` (
  `id` int(11) NOT NULL,
  `contact_name` varchar(255) NOT NULL,
  `contact_email` varchar(255) NOT NULL,
  `contact_subject` int(5) NOT NULL,
  `contact_msg` text NOT NULL,
  `created_at` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_contact_list`
--

INSERT INTO `tbl_contact_list` (`id`, `contact_name`, `contact_email`, `contact_subject`, `contact_msg`, `created_at`) VALUES
(1, 'shubham', 'shubhambhuvad567@gmail.com', 2, 'efrgrfgr', '1607953825'),
(2, 'shubham bhuvad', 'shubhambhuvad567@gmail.com', 2, 'veqev', '1625743759'),
(3, 'jit', 'jitendrag645@gmail.com', 5, 'Test contact us by developer', '1625932553');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contact_sub`
--

CREATE TABLE `tbl_contact_sub` (
  `id` int(5) NOT NULL,
  `title` varchar(150) NOT NULL,
  `title_slug` varchar(150) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `created_at` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_contact_sub`
--

INSERT INTO `tbl_contact_sub` (`id`, `title`, `title_slug`, `status`, `created_at`) VALUES
(1, 'Order Cancellation', 'order-cancellation', 1, ''),
(2, 'Order Payment', 'order-payment', 1, ''),
(3, 'Order delayed', 'order-delayed', 1, '1625901167'),
(4, 'Product issue', 'product-issue', 1, '1625901167'),
(5, 'Bulk order enquiry', 'bulk-order-enquiry', 1, '1625901167');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_coupon`
--

CREATE TABLE `tbl_coupon` (
  `id` int(10) NOT NULL,
  `coupon_desc` text NOT NULL,
  `coupon_code` varchar(25) NOT NULL,
  `coupon_image` text NOT NULL,
  `coupon_per` int(10) NOT NULL,
  `coupon_amt` int(10) NOT NULL,
  `max_amt_status` varchar(5) NOT NULL,
  `coupon_max_amt` int(10) NOT NULL,
  `cart_status` varchar(5) NOT NULL,
  `coupon_cart_min` varchar(10) NOT NULL,
  `coupon_limit_use` int(10) NOT NULL DEFAULT '1',
  `created_at` varchar(150) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_coupon`
--

INSERT INTO `tbl_coupon` (`id`, `coupon_desc`, `coupon_code`, `coupon_image`, `coupon_per`, `coupon_amt`, `max_amt_status`, `coupon_max_amt`, `cart_status`, `coupon_cart_min`, `coupon_limit_use`, `created_at`, `status`) VALUES
(1, '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n', '40OFFALL', '29062019093713_18947.jpg', 0, 50, 'true', 1000, 'true', '2000', 1, '1561781233', 1),
(2, '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like readable English.</p>\r\n', '50%OFF', '29062019032607_64692.jpg', 50, 0, 'false', 50, 'true', '1000', 10, '1561802167', 1),
(3, '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s.</p>\r\n', '300RSOFF', '27072020020949_79264.jpg', 0, 10, 'false', 0, 'false', '3000', 10, '1595839189', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_faq`
--

CREATE TABLE `tbl_faq` (
  `id` int(10) NOT NULL,
  `faq_question` text NOT NULL,
  `faq_answer` longtext NOT NULL,
  `type` varchar(10) NOT NULL DEFAULT 'faq',
  `created_at` varchar(150) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_faq`
--

INSERT INTO `tbl_faq` (`id`, `faq_question`, `faq_answer`, `type`, `created_at`, `status`) VALUES
(1, 'Do We Sell Internationally?', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'faq', '1578554160', 1),
(2, 'What Does \'Out of Stock\' Means?', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.', 'faq', '1578554160', 1),
(3, 'Are Items Packaged?', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'faq', '1578560180', 1),
(4, 'Do you get \'Return Policy\'?', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'faq', '1578560180', 1),
(5, 'Why do I see \'Delivery Charge\'?', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'faq', '1578560180', 1),
(11, 'What is an EMI payment option?', 'The EMI or Equated Monthly Instalment payment option allows you to pay for your orders in easy monthly installments, provided you have a card from a partner bank. For details, including terms and condition, please click here.', 'payment', '1580361984', 1),
(12, 'How do I know if my order is eligible for an EMI?', 'If your order is eligible for an EMI purchase, you will see the EMI option, along with a table of EMI providers and their corresponding rates and tenures offered, on the product page. You can also pay for your total purchase in EMIs if your cart value is Rs 5,000 or more. However minimum purchase criteria can differ from product to product. For details please click here.', 'payment', '1580361984', 1),
(13, 'How do I know if the EMI payment process was successful?', 'As soon as you make your purchase on Tata CLiQ, you will see the full amount charged to your card. It will take the bank a few days (the time frame depends from bank to bank) to convert this into an EMI. From your next billing cycle, you will be charged the EMI amount and your credit limit will be reduced by the outstanding amount. For example, if you have made a three-month EMI purchase of RS 25,000 and your credit limit is RS 1,00,000, then your bank will block your credit limit by RS 25,000 and thus your available credit limit after the purchase will only be RS 75,000. As and when you pay your EMI every month, your credit limit will be released accordingly. For any further queries, please contact your bank.', 'payment', '1580361984', 1),
(14, 'How does the COD payment option work?', 'While making your purchase, select the Cash on Delivery payment option; you can then pay in cash when our logistics partner delivers your order to you. Please note that this option is only available at select PIN codes.', 'payment', '1580361984', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_logs`
--

CREATE TABLE `tbl_logs` (
  `id` int(11) NOT NULL,
  `uri` varchar(255) NOT NULL,
  `method` varchar(6) NOT NULL,
  `params` text,
  `api_key` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `time` int(11) NOT NULL,
  `rtime` float DEFAULT NULL,
  `authorized` varchar(1) NOT NULL,
  `response_code` smallint(3) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_offers`
--

CREATE TABLE `tbl_offers` (
  `id` int(10) NOT NULL,
  `offer_title` varchar(150) NOT NULL,
  `offer_slug` varchar(150) NOT NULL,
  `offer_desc` longtext NOT NULL,
  `offer_percentage` int(10) NOT NULL,
  `offer_image` text NOT NULL,
  `created_at` varchar(150) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_offers`
--

INSERT INTO `tbl_offers` (`id`, `offer_title`, `offer_slug`, `offer_desc`, `offer_percentage`, `offer_image`, `created_at`, `status`) VALUES
(1, 'MEGA SALE !', 'mega-sale', '<p>Mega Sale on Clothes for Mens and Womens</p>\r\n\r\n<p><strong>50% OFF </strong>on clothes.</p>\r\n', 50, '26102019112146_26747.jpg', '1569648061', 1),
(2, 'Our Biggest Weekend Sale', 'our-biggest-weekend-sale', '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>\r\n', 40, '26102019112945_52597.jpg', '1570163984', 1),
(3, 'Grand Offer for 50% Off', 'grand-offer-for-50-off', '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>\r\n', 50, '11012020101654_16931.jpg', '1572069709', 1),
(4, 'Your Day Just Got Better', 'your-day-just-got-better', '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n', 5, '11012020101952_34074.jpg', '1578718192', 1),
(5, 'Flat 20% OFF Super Sale (Limited Time Offer)', 'flat-20-off-super-sale-limited-time-offer', '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n', 20, '11012020102342_61736.jpg', '1578718422', 1),
(6, 'Sale 30% OFF', 'sale-30-off', '', 30, '11012020110932_78016.jpg', '1578721172', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order_details`
--

CREATE TABLE `tbl_order_details` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `coupon_id` int(5) NOT NULL DEFAULT '0',
  `order_unique_id` text NOT NULL,
  `order_address` int(5) NOT NULL,
  `gst` varchar(255) NOT NULL,
  `hsn` varchar(255) NOT NULL,
  `total_amt` double NOT NULL,
  `discount` varchar(10) DEFAULT '0',
  `discount_amt` double NOT NULL,
  `payable_amt` double NOT NULL,
  `new_payable_amt` double NOT NULL,
  `refund_amt` double NOT NULL DEFAULT '0',
  `refund_per` double NOT NULL DEFAULT '0',
  `order_date` varchar(150) NOT NULL,
  `delivery_date` varchar(150) NOT NULL,
  `order_status` int(2) NOT NULL DEFAULT '-1',
  `delivery_charge` varchar(5) NOT NULL DEFAULT '0',
  `pincode` varchar(10) NOT NULL,
  `building_name` varchar(100) NOT NULL,
  `road_area_colony` text NOT NULL,
  `city` varchar(100) NOT NULL,
  `district` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `landmark` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile_no` varchar(20) NOT NULL,
  `alter_mobile_no` varchar(20) NOT NULL,
  `address_type` varchar(30) NOT NULL,
  `is_seen` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_order_details`
--

INSERT INTO `tbl_order_details` (`id`, `user_id`, `coupon_id`, `order_unique_id`, `order_address`, `gst`, `hsn`, `total_amt`, `discount`, `discount_amt`, `payable_amt`, `new_payable_amt`, `refund_amt`, `refund_per`, `order_date`, `delivery_date`, `order_status`, `delivery_charge`, `pincode`, `building_name`, `road_area_colony`, `city`, `district`, `state`, `country`, `landmark`, `name`, `email`, `mobile_no`, `alter_mobile_no`, `address_type`, `is_seen`) VALUES
(15, 1, 0, '777554056', 1, '20', '65841111', 1200, '0', 0, 1, 1, 0, 0, '1627732450', '1628337250', 1, '0', '401305', 'vasai virar', 'kala hanuman road', 'virar', '', 'Maharashtra', 'Australia', 'virar', 'shubham bhuvad', 'shubhambhuvad567@gmail.com', '+618830516259', '8830516259', '1', 0),
(16, 1, 0, '180481451', 1, '20', '65841111', 1200, '0', 0, 1, 1, 0, 0, '1627732626', '1628337426', 1, '0', '401305', 'vasai virar', 'kala hanuman road', 'virar', '', 'Maharashtra', 'Australia', 'virar', 'shubham bhuvad', 'shubhambhuvad567@gmail.com', '+618830516259', '8830516259', '1', 0),
(17, 1, 0, '261278379', 1, '20', '65841111', 1200, '0', 0, 1, 1, 0, 0, '1627732669', '1628337469', 1, '0', '401305', 'vasai virar', 'kala hanuman road', 'virar', '', 'Maharashtra', 'Australia', 'virar', 'shubham bhuvad', 'shubhambhuvad567@gmail.com', '+618830516259', '8830516259', '1', 0),
(18, 1, 0, '1387009287', 1, '20', '65841111', 1200, '0', 0, 1, 1, 0, 0, '1627732812', '1628337612', 1, '0', '401305', 'vasai virar', 'kala hanuman road', 'virar', '', 'Maharashtra', 'Australia', 'virar', 'shubham bhuvad', 'shubhambhuvad567@gmail.com', '+618830516259', '8830516259', '1', 0),
(19, 1, 0, '812152685', 1, '20', '65841111', 1200, '0', 0, 0, 0, 0, 0, '1627733160', '1628337960', 1, '0', '401305', 'vasai virar', 'kala hanuman road', 'virar', '', 'Maharashtra', 'Australia', 'virar', 'shubham bhuvad', 'shubhambhuvad567@gmail.com', '+618830516259', '8830516259', '1', 0),
(20, 1, 0, '1721821477', 1, '20', '65841111', 1200, '0', 0, 1, 1, 0, 0, '1627733250', '1628338050', 1, '0', '401305', 'vasai virar', 'kala hanuman road', 'virar', '', 'Maharashtra', 'Australia', 'virar', 'shubham bhuvad', 'shubhambhuvad567@gmail.com', '+618830516259', '8830516259', '1', 0),
(21, 1, 0, '2041415435', 1, '20', '65841111', 1200, '0', 0, 1, 1, 0, 0, '1627733350', '1628338150', 1, '0', '401305', 'vasai virar', 'kala hanuman road', 'virar', '', 'Maharashtra', 'Australia', 'virar', 'shubham bhuvad', 'shubhambhuvad567@gmail.com', '+618830516259', '8830516259', '1', 0),
(22, 1, 0, '909286422', 1, '20', '65841111', 1200, '0', 0, 1440, 1440, 0, 0, '1627733499', '1628338299', 4, '0', '401305', 'vasai virar', 'kala hanuman road', 'virar', '', 'Maharashtra', 'Australia', 'virar', 'shubham bhuvad', 'shubhambhuvad567@gmail.com', '+618830516259', '8830516259', '1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order_items`
--

CREATE TABLE `tbl_order_items` (
  `id` int(10) NOT NULL,
  `order_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `product_title` varchar(150) NOT NULL,
  `product_qty` int(5) NOT NULL,
  `product_mrp` double NOT NULL,
  `product_price` double NOT NULL,
  `gst` varchar(255) NOT NULL,
  `you_save_amt` double NOT NULL DEFAULT '0',
  `product_size` varchar(10) NOT NULL,
  `total_price` double NOT NULL,
  `delivery_charge` float NOT NULL,
  `pro_order_status` int(3) NOT NULL DEFAULT '-1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_order_items`
--

INSERT INTO `tbl_order_items` (`id`, `order_id`, `user_id`, `product_id`, `product_title`, `product_qty`, `product_mrp`, `product_price`, `gst`, `you_save_amt`, `product_size`, `total_price`, `delivery_charge`, `pro_order_status`) VALUES
(15, 15, 1, 88, 'Ecotattva Full Sleeves Shirt', 1, 1200, 1200, '', 0, '', 1200, 0, 1),
(16, 16, 1, 88, 'Ecotattva Full Sleeves Shirt', 1, 1200, 1200, '', 0, '', 1200, 0, 1),
(17, 17, 1, 88, 'Ecotattva Full Sleeves Shirt', 1, 1200, 1200, '', 0, '', 1200, 0, 1),
(18, 18, 1, 88, 'Ecotattva Full Sleeves Shirt', 1, 1200, 1200, '', 0, '', 1200, 0, 1),
(19, 19, 1, 88, 'Ecotattva Full Sleeves Shirt', 1, 1200, 1200, '', 0, '', 1200, 0, 1),
(20, 20, 1, 88, 'Ecotattva Full Sleeves Shirt', 1, 1200, 1200, '', 0, '', 1200, 0, 1),
(21, 21, 1, 88, 'Ecotattva Full Sleeves Shirt', 1, 1200, 1200, '', 0, '', 1200, 0, 1),
(22, 22, 1, 88, 'Ecotattva Full Sleeves Shirt', 1, 1200, 1200, '20', 0, '', 1200, 0, 4);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order_status`
--

CREATE TABLE `tbl_order_status` (
  `id` int(20) NOT NULL,
  `order_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `status_title` varchar(100) NOT NULL,
  `status_desc` text NOT NULL,
  `created_at` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_order_status`
--

INSERT INTO `tbl_order_status` (`id`, `order_id`, `user_id`, `product_id`, `status_title`, `status_desc`, `created_at`) VALUES
(47, 15, 1, 0, '1', 'Your Order has been placed.', '1627732450'),
(48, 15, 1, 88, '1', 'Your Order has been placed.', '1627732450'),
(49, 16, 1, 0, '1', 'Your Order has been placed.', '1627732626'),
(50, 16, 1, 88, '1', 'Your Order has been placed.', '1627732626'),
(51, 17, 1, 0, '1', 'Your Order has been placed.', '1627732669'),
(52, 17, 1, 88, '1', 'Your Order has been placed.', '1627732669'),
(53, 18, 1, 0, '1', 'Your Order has been placed.', '1627732812'),
(54, 18, 1, 88, '1', 'Your Order has been placed.', '1627732812'),
(55, 19, 1, 0, '1', 'Your Order has been placed.', '1627733160'),
(56, 19, 1, 88, '1', 'Your Order has been placed.', '1627733160'),
(57, 20, 1, 0, '1', 'Your Order has been placed.', '1627733250'),
(58, 20, 1, 88, '1', 'Your Order has been placed.', '1627733250'),
(59, 21, 1, 0, '1', 'Your Order has been placed.', '1627733350'),
(60, 21, 1, 88, '1', 'Your Order has been placed.', '1627733350'),
(61, 22, 1, 0, '1', 'Your Order has been placed.', '1627733499'),
(62, 22, 1, 88, '1', 'Your Order has been placed.', '1627733499'),
(63, 22, 1, 0, '4', 'delivered', '1627733593'),
(64, 22, 1, 88, '4', 'delivered', '1627733593');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_partner_with_us_list`
--

CREATE TABLE `tbl_partner_with_us_list` (
  `id` int(11) NOT NULL,
  `contact_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `contact_email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `contact_phone` varchar(20) NOT NULL,
  `contact_msg` text CHARACTER SET utf8 NOT NULL,
  `enquiry_for` varchar(255) NOT NULL,
  `created_at` varchar(150) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_partner_with_us_list`
--

INSERT INTO `tbl_partner_with_us_list` (`id`, `contact_name`, `contact_email`, `contact_phone`, `contact_msg`, `enquiry_for`, `created_at`) VALUES
(4, 'jmg', '', '9024645458', 'test', 'Fashion,Beauty & health,Grocery,Electronics,Pet Supplies,Deal of the day', '1625934193');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product`
--

CREATE TABLE `tbl_product` (
  `id` int(10) NOT NULL,
  `category_id` int(5) NOT NULL,
  `sub_category_id` int(5) NOT NULL,
  `submenu_header_id` int(11) NOT NULL,
  `submenu_item_id` int(11) DEFAULT NULL,
  `brand_id` int(11) NOT NULL,
  `offer_id` int(10) NOT NULL DEFAULT '0',
  `product_title` varchar(255) NOT NULL,
  `product_slug` varchar(150) NOT NULL,
  `product_desc` longtext NOT NULL,
  `product_features` longtext NOT NULL,
  `featured_image` text NOT NULL,
  `featured_image2` text NOT NULL,
  `size_chart` text NOT NULL,
  `product_mrp` double NOT NULL,
  `selling_price` double NOT NULL DEFAULT '0',
  `gst` double NOT NULL,
  `hsn` varchar(255) NOT NULL,
  `you_save_amt` double NOT NULL DEFAULT '0',
  `you_save_per` double NOT NULL DEFAULT '0',
  `other_color_product` text NOT NULL,
  `color` varchar(100) NOT NULL,
  `product_size` text NOT NULL,
  `product_quantity` int(5) NOT NULL DEFAULT '1',
  `max_unit_buy` int(5) NOT NULL DEFAULT '1',
  `delivery_charge` float NOT NULL,
  `total_views` varchar(10) NOT NULL DEFAULT '0',
  `total_rate` int(10) NOT NULL DEFAULT '0',
  `rate_avg` double NOT NULL DEFAULT '0',
  `is_featured` int(1) DEFAULT '0',
  `today_deal` int(2) NOT NULL DEFAULT '0',
  `today_deal_date` varchar(150) NOT NULL DEFAULT '0',
  `total_sale` int(10) NOT NULL DEFAULT '0',
  `created_at` varchar(150) NOT NULL,
  `seo_title` varchar(150) NOT NULL,
  `seo_meta_description` longtext NOT NULL,
  `seo_keywords` longtext NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_product`
--

INSERT INTO `tbl_product` (`id`, `category_id`, `sub_category_id`, `submenu_header_id`, `submenu_item_id`, `brand_id`, `offer_id`, `product_title`, `product_slug`, `product_desc`, `product_features`, `featured_image`, `featured_image2`, `size_chart`, `product_mrp`, `selling_price`, `gst`, `hsn`, `you_save_amt`, `you_save_per`, `other_color_product`, `color`, `product_size`, `product_quantity`, `max_unit_buy`, `delivery_charge`, `total_views`, `total_rate`, `rate_avg`, `is_featured`, `today_deal`, `today_deal_date`, `total_sale`, `created_at`, `seo_title`, `seo_meta_description`, `seo_keywords`, `status`) VALUES
(88, 13, 29, 5, 9, 24, 0, 'Ecotattva Full Sleeves Shirt', 'ecotattva-full-sleeves-shirt', 'Ecotattva', '<h3><strong>Color : Off Orange</strong><br>\r\n<strong>Fabric :</strong> Premium Khadi<br>\r\n<strong>Type :</strong> Short Kurta<br>\r\n<strong>Thread count :</strong> 60s</h3>\r\n\r\n<ul>\r\n <li>\r\n <h3>100% Cotton</h3>\r\n </li>\r\n <li>\r\n <h3>Premium hand spun hand woven round neck Full Sleeves Short Kurta for men</h3>\r\n </li>\r\n <li>\r\n <h3>Printed with traditional hand printing techniques.</h3>\r\n </li>\r\n <li>\r\n <h3>This made in India product, which signifies the pride of India tireless efforts of our committed weavers brings gaiety to your wardrobe.</h3>\r\n </li>\r\n <li>\r\n <h3>We use only a global standard eco-friendly color group for dyeing.</h3>\r\n </li>\r\n <li>\r\n <h3>Colors may fade after some wash due to the eco-friendly dyeing and printing process employed.</h3>\r\n </li>\r\n <li>\r\n <h3>This is 100% handwoven Short Kurta by using naturally-dyed colors, so a variation of 10% to 20% in color is inevitable since it is not machine-made. That’s the specialty of “Khadi”.</h3>\r\n </li>\r\n <li>\r\n <h3>Wash in cold water. Try to avoid the use of a brush.</h3>\r\n </li>\r\n</ul>\r\n', '14072021032317_27832.png', '14072021032317_278321.png', '14072021032317_278322.png', 1200, 1200, 20, '65841111', 0, 0, '', 'Orange/FF2203', 'S, M, L, XL', 0, 1, 0, '115', 2, 4, 0, 0, '0', 4, '1626256397', 'Ecottva Full sleeves shirt', 'Full sleeves shirts for men', 'full sleeves shirt', 1),
(89, 13, 29, 0, 0, 24, 3, 'Ecotattva Full Sleeves Shirt-1', 'ecotattva-full-sleeves-shirt-1', 'Ecotattva', '<h3>General</h3>\r\n\r\n<table border=\"\\\\\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Sales Package</td>\r\n   <td>\r\n   <ul>\r\n    <li>Laptop, Battery, Power Adaptor, User Guide, Warranty Documents</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Model Number</td>\r\n   <td>\r\n   <ul>\r\n    <li>MQD32HN/A A1466</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Part Number</td>\r\n   <td>\r\n   <ul>\r\n    <li>MQD32HN/A</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Series</td>\r\n   <td>\r\n   <ul>\r\n    <li>MacBook Air</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Color</td>\r\n   <td>\r\n   <ul>\r\n    <li>Silver</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>Thin and Light Laptop</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Suitable For</td>\r\n   <td>\r\n   <ul>\r\n    <li>Travel & Business, Processing & Multitasking</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Battery Backup</td>\r\n   <td>\r\n   <ul>\r\n    <li>Upto 12 hours</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Power Supply</td>\r\n   <td>\r\n   <ul>\r\n    <li>45 W MagSafe 2 Power Adapter</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>MS Office Provided</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3><br>\r\n </h3>\r\n', '15072021051020_37619.jpg', '15072021051020_376191.jpg', '', 1200, 600, 0, '', 600, 50, '', 'Orange/FF2203', 'S, M, L, XL', 0, 1, 0, '2', 0, 0, 0, 0, '0', 0, '1626349220', '', '', '', 0),
(90, 13, 29, 0, 0, 24, 3, 'Ecotattva Full Sleeves Shirt-1-1', 'ecotattva-full-sleeves-shirt-1-1', 'Ecotattva', '<p><strong>Type: </strong>Flats</p>\r\n\r\n<p><strong>Closure: </strong>Slip On</p>\r\n\r\n<p><strong>Type for Flats: </strong>Sandal</p>\r\n\r\n<p><strong>Color: </strong>Maroon</p>\r\n\r\n<p><strong>Pack of: </strong>1</p>\r\n\r\n<p><strong>Sole Material: </strong>Rubber & Cork</p>\r\n\r\n<p><strong>Care instructions: </strong>Rub With A Dry Cloth. Do Not Use Water/Soap/Detergent For Cleaning.</p>\r\n\r\n<p><strong>Weight: </strong>150 g (per single Sandal) - Weight of the product may vary depending on size.</p>\r\n', '15072021051620_96423.jpg', '15072021051620_964231.jpg', '', 1200, 600, 0, '', 600, 50, '', 'Orange/FF2203', 'S, M, L, XL', 0, 1, 0, '0', 0, 0, 0, 0, '0', 0, '1626349580', '', '', '', 0),
(91, 13, 0, 0, 0, 24, 0, 'evwbrb', 'evwbrb', 'qefqeqe', '<p>qefqef</p>\r\n', '19072021050955_3034.jpg', '19072021050955_30341.jpg', '19072021050955_30342.jpg', 500, 500, 50, '5646511', 0, 0, '88', 'White/FFFFFF', 's,m,xl,xxl,xxxl', 0, 1, 0, '0', 0, 0, 0, 0, '0', 0, '1626694796', '', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_images`
--

CREATE TABLE `tbl_product_images` (
  `id` int(10) NOT NULL,
  `parent_id` int(10) NOT NULL,
  `image_file` text NOT NULL,
  `type` varchar(60) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_product_images`
--

INSERT INTO `tbl_product_images` (`id`, `parent_id`, `image_file`, `type`, `status`) VALUES
(50, 10, '27112019104137_31346_2_.jpg', 'product', 1),
(51, 10, '27112019104137_31346_2_1.jpg', 'product', 1),
(52, 10, '27112019104137_31346_2_2.jpg', 'product', 1),
(53, 10, '27112019104137_31346_2_3.jpg', 'product', 1),
(54, 11, '27112019105835_91751_2_.jpg', 'product', 1),
(55, 11, '27112019105835_91751_2_1.jpg', 'product', 1),
(56, 11, '27112019105835_91751_2_2.jpg', 'product', 1),
(57, 11, '27112019105835_91751_2_3.jpg', 'product', 1),
(58, 11, '27112019105835_91751_2_4.jpg', 'product', 1),
(59, 11, '27112019105835_91751_2_5.jpg', 'product', 1),
(89, 20, '11122019042220_16245.jpg', 'product', 1),
(90, 20, '11122019042220_162451.jpg', 'product', 1),
(91, 20, '11122019042220_162452.jpg', 'product', 1),
(453, 88, '14072021032317_27832.png', 'product', 1),
(454, 88, '14072021032512_65648_2_.png', 'product', 1),
(455, 88, '14072021032512_35761_2_.png', 'product', 1),
(456, 89, '15072021051020_37619.jpg', 'product', 1),
(457, 90, '15072021051620_96423.jpg', 'product', 1),
(458, 91, '19072021050955_3034.jpg', 'product', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rating`
--

CREATE TABLE `tbl_rating` (
  `id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `order_id` int(10) NOT NULL DEFAULT '0',
  `rating` double NOT NULL,
  `rating_desc` longtext NOT NULL,
  `created_at` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_rating`
--

INSERT INTO `tbl_rating` (`id`, `product_id`, `user_id`, `order_id`, `rating`, `rating_desc`, `created_at`) VALUES
(4, 88, 1, 15, 4, '', '1627737799');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_recent_viewed`
--

CREATE TABLE `tbl_recent_viewed` (
  `id` int(20) NOT NULL,
  `user_id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `created_at` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_recent_viewed`
--

INSERT INTO `tbl_recent_viewed` (`id`, `user_id`, `product_id`, `created_at`) VALUES
(1, 1, 27, '1625743974'),
(2, 1, 56, '1625808498'),
(3, 1, 85, '1625919765'),
(4, 1, 66, '1625920333'),
(5, 2, 83, '1626010585'),
(6, 2, 55, '1625997692'),
(7, 2, 66, '1625998280'),
(8, 2, 65, '1625998307'),
(9, 2, 87, '1625999347'),
(10, 2, 85, '1625999331'),
(11, 1, 84, '1626080856'),
(12, 2, 26, '1626236766'),
(13, 2, 77, '1626237044'),
(14, 2, 76, '1626238980'),
(15, 3, 88, '1627711417'),
(16, 1, 88, '1633757972');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_refund`
--

CREATE TABLE `tbl_refund` (
  `id` int(10) NOT NULL,
  `bank_id` int(10) NOT NULL DEFAULT '0',
  `user_id` int(10) NOT NULL DEFAULT '0',
  `order_id` int(10) NOT NULL,
  `order_unique_id` text NOT NULL,
  `product_id` int(10) NOT NULL,
  `product_title` varchar(150) NOT NULL,
  `product_amt` double NOT NULL,
  `refund_pay_amt` double NOT NULL,
  `refund_per` double NOT NULL DEFAULT '0',
  `gateway` varchar(20) NOT NULL,
  `refund_reason` longtext NOT NULL,
  `last_updated` varchar(255) NOT NULL,
  `request_status` int(1) NOT NULL DEFAULT '0',
  `cancel_by` int(10) NOT NULL DEFAULT '0',
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_settings`
--

CREATE TABLE `tbl_settings` (
  `id` int(11) NOT NULL,
  `gstno` varchar(255) NOT NULL,
  `app_order_email` varchar(150) NOT NULL,
  `app_name` varchar(255) NOT NULL,
  `app_email` varchar(150) NOT NULL,
  `app_version` varchar(10) NOT NULL DEFAULT '1.0.0',
  `app_logo` varchar(255) NOT NULL,
  `web_favicon` varchar(150) NOT NULL,
  `app_author` varchar(255) NOT NULL,
  `app_contact` varchar(255) NOT NULL,
  `app_website` varchar(255) NOT NULL,
  `app_description` text NOT NULL,
  `app_developed_by` varchar(255) NOT NULL,
  `facebook_url` text NOT NULL,
  `twitter_url` text NOT NULL,
  `youtube_url` text NOT NULL,
  `instagram_url` text NOT NULL,
  `whatsapp_url` text NOT NULL,
  `linkedin_url` text NOT NULL,
  `blog_url` text NOT NULL,
  `line_one` text NOT NULL,
  `line_two` text NOT NULL,
  `line_three` text NOT NULL,
  `line_four` text NOT NULL,
  `app_privacy_policy` text NOT NULL,
  `app_currency_code` varchar(30) NOT NULL,
  `app_currency_html_code` text NOT NULL,
  `email_otp_op_status` varchar(10) NOT NULL DEFAULT 'true',
  `cod_status` varchar(30) NOT NULL DEFAULT 'true',
  `paypal_status` varchar(30) NOT NULL DEFAULT 'true',
  `paypal_mode` varchar(10) NOT NULL,
  `paypal_client_id` text NOT NULL,
  `paypal_secret_key` text NOT NULL,
  `stripe_status` varchar(30) NOT NULL DEFAULT 'false',
  `stripe_key` text NOT NULL,
  `stripe_secret` text NOT NULL,
  `razorpay_status` varchar(20) NOT NULL DEFAULT 'false',
  `razorpay_key` text NOT NULL,
  `razorpay_secret` text NOT NULL,
  `razorpay_theme_color` varchar(30) NOT NULL DEFAULT 'eb1536',
  `google_login_status` varchar(20) NOT NULL DEFAULT 'false',
  `google_client_id` text NOT NULL,
  `google_secret_key` text NOT NULL,
  `facebook_status` varchar(20) NOT NULL DEFAULT 'false',
  `facebook_app_id` text NOT NULL,
  `facebook_app_secret` text NOT NULL,
  `home_slider_opt` varchar(6) NOT NULL DEFAULT 'true',
  `home_brand_opt` varchar(6) NOT NULL DEFAULT 'true',
  `home_category_opt` varchar(6) NOT NULL DEFAULT 'true',
  `home_offer_opt` varchar(6) NOT NULL DEFAULT 'true',
  `home_flase_opt` varchar(6) NOT NULL DEFAULT 'true',
  `home_latest_opt` varchar(6) NOT NULL DEFAULT 'true',
  `home_top_rated_opt` varchar(6) NOT NULL DEFAULT 'true',
  `min_rate` int(5) NOT NULL DEFAULT '3',
  `home_cat_wise_opt` varchar(6) NOT NULL DEFAULT 'true',
  `home_recent_opt` varchar(6) NOT NULL DEFAULT 'true',
  `app_home_slider_opt` varchar(6) NOT NULL DEFAULT 'true',
  `app_home_brand_opt` varchar(6) NOT NULL DEFAULT 'true',
  `app_home_category_opt` varchar(6) NOT NULL DEFAULT 'true',
  `app_home_offer_opt` varchar(6) NOT NULL DEFAULT 'true',
  `app_home_flase_opt` varchar(6) NOT NULL DEFAULT 'true',
  `app_home_latest_opt` varchar(6) NOT NULL DEFAULT 'true',
  `app_home_top_rated_opt` varchar(6) NOT NULL DEFAULT 'true',
  `app_home_cat_wise_opt` varchar(6) NOT NULL DEFAULT 'true',
  `app_home_recent_opt` varchar(6) NOT NULL DEFAULT 'true'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_settings`
--

INSERT INTO `tbl_settings` (`id`, `gstno`, `app_order_email`, `app_name`, `app_email`, `app_version`, `app_logo`, `web_favicon`, `app_author`, `app_contact`, `app_website`, `app_description`, `app_developed_by`, `facebook_url`, `twitter_url`, `youtube_url`, `instagram_url`, `whatsapp_url`, `linkedin_url`, `blog_url`, `line_one`, `line_two`, `line_three`, `line_four`, `app_privacy_policy`, `app_currency_code`, `app_currency_html_code`, `email_otp_op_status`, `cod_status`, `paypal_status`, `paypal_mode`, `paypal_client_id`, `paypal_secret_key`, `stripe_status`, `stripe_key`, `stripe_secret`, `razorpay_status`, `razorpay_key`, `razorpay_secret`, `razorpay_theme_color`, `google_login_status`, `google_client_id`, `google_secret_key`, `facebook_status`, `facebook_app_id`, `facebook_app_secret`, `home_slider_opt`, `home_brand_opt`, `home_category_opt`, `home_offer_opt`, `home_flase_opt`, `home_latest_opt`, `home_top_rated_opt`, `min_rate`, `home_cat_wise_opt`, `home_recent_opt`, `app_home_slider_opt`, `app_home_brand_opt`, `app_home_category_opt`, `app_home_offer_opt`, `app_home_flase_opt`, `app_home_latest_opt`, `app_home_top_rated_opt`, `app_home_cat_wise_opt`, `app_home_recent_opt`) VALUES
(1, '27AGKPT3559P2ZC', '', 'Pipa Mart', 'cosmicwebsolution@gmail.com', '1.0.0', '01072021025639_18680.jpg', '01072021025659_95573.png', 'Pipa Mart', '+91 7769964000', 'http://www.cosmicwebsolution.com/', '<p>Ecommerce App for Online Selling Product | Add to Cart | Ecommerce Script | Checkout With Payment Gateway | Paypal Payment Mode | Stripe Payment Mode | Razorpay Payment Mode</p>\r\n\r\n<p>We also develop custom applications, if you need any kind of custom application contact us on given Email or Contact No.</p>\r\n', 'Cosmic web solution', 'https://www.facebook.com/PipaMart', 'https://twitter.com/', 'https://www.youtube.com/', 'https://www.instagram.com/', '+91 7796849690', 'https://www.linkedin.com/', 'https://www.blog.com/', 'Sale- Discount upto 80% Off', 'Sale- Discount upto 80% Off', 'Sale- Discount upto 80% Off', 'Sale- Discount upto 80% Off', '<p><strong>We are committed to protecting your privacy</strong></p>\n\n<p>We collect the minimum amount of information about you that is commensurate with providing you with a satisfactory service. This policy indicates the type of processes that may result in data being collected about you. Your use of this website gives us the right to collect that information.&nbsp;</p>\n\n<p><strong>Information Collected</strong></p>\n\n<p>We may collect any or all of the information that you give us depending on the type of transaction you enter into, including your name, address, telephone number, and email address, together with data about your use of the website. Other information that may be needed from time to time to process a request may also be collected as indicated on the website.</p>\n\n<p><strong>Information Use</strong></p>\n\n<p>We use the information collected primarily to process the task for which you visited the website. Data collected in the UK is held in accordance with the Data Protection Act. All reasonable precautions are taken to prevent unauthorised access to this information. This safeguard may require you to provide additional forms of identity should you wish to obtain information about your account details.</p>\n\n<p><strong>Cookies</strong></p>\n\n<p>Your Internet browser has the in-built facility for storing small files - &quot;cookies&quot; - that hold information which allows a website to recognise your account. Our website takes advantage of this facility to enhance your experience. You have the ability to prevent your computer from accepting cookies but, if you do, certain functionality on the website may be impaired.</p>\n\n<p><strong>Disclosing Information</strong></p>\n\n<p>We do not disclose any personal information obtained about you from this website to third parties unless you permit us to do so by ticking the relevant boxes in registration or competition forms. We may also use the information to keep in contact with you and inform you of developments associated with us. You will be given the opportunity to remove yourself from any mailing list or similar device. If at any time in the future we should wish to disclose information collected on this website to any third party, it would only be with your knowledge and consent.&nbsp;</p>\n\n<p>We may from time to time provide information of a general nature to third parties - for example, the number of individuals visiting our website or completing a registration form, but we will not use any information that could identify those individuals.&nbsp;</p>\n\n<p>In addition Dummy may work with third parties for the purpose of delivering targeted behavioural advertising to the Dummy website. Through the use of cookies, anonymous information about your use of our websites and other websites will be used to provide more relevant adverts about goods and services of interest to you. For more information on online behavioural advertising and about how to turn this feature off, please visit youronlinechoices.com/opt-out.</p>\n\n<p><strong>Changes to this Policy</strong></p>\n\n<p>Any changes to our Privacy Policy will be placed here and will supersede this version of our policy. We will take reasonable steps to draw your attention to any changes in our policy. However, to be on the safe side, we suggest that you read this document each time you use the website to ensure that it still meets with your approval.</p>\n\n<p><strong>Contacting Us</strong></p>\n\n<p>If you have any questions about our Privacy Policy, or if you want to know what information we have collected about you, please email us at hd@dummy.com. You can also correct any factual errors in that information or require us to remove your details form any list under our control.</p>\n', 'INR', 'Rs.', 'true', 'true', 'true', 'sandbox', '', '', 'true', '', '', 'true', 'rzp_live_lDz5sX2uODOd0G', 'SPbPKZkwykPHCkh6VywvXDAk', 'FF5252', 'true', '', '', 'true', '', '', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 3, 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_smtp_settings`
--

CREATE TABLE `tbl_smtp_settings` (
  `id` int(5) NOT NULL,
  `smtp_library` varchar(20) NOT NULL DEFAULT 'ci',
  `smtp_type` varchar(20) NOT NULL DEFAULT 'server',
  `smtp_host` varchar(150) NOT NULL,
  `smtp_email` varchar(150) NOT NULL,
  `smtp_password` text NOT NULL,
  `smtp_secure` varchar(20) NOT NULL,
  `port_no` varchar(10) NOT NULL,
  `smtp_ghost` varchar(150) NOT NULL,
  `smtp_gemail` varchar(150) NOT NULL,
  `smtp_gpassword` text NOT NULL,
  `smtp_gsecure` varchar(20) NOT NULL,
  `gport_no` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_smtp_settings`
--

INSERT INTO `tbl_smtp_settings` (`id`, `smtp_library`, `smtp_type`, `smtp_host`, `smtp_email`, `smtp_password`, `smtp_secure`, `port_no`, `smtp_ghost`, `smtp_gemail`, `smtp_gpassword`, `smtp_gsecure`, `gport_no`) VALUES
(1, 'phpmailer', 'server', 'mail.googlehai.com', 'test@googlehai.com', 'cOwN7ddU;YfY', 'ssl', '465', 'smtp.gmail.com', 'shubhambhuvad567@gmail.com', 'shubham567', 'tls', 465);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_status_title`
--

CREATE TABLE `tbl_status_title` (
  `id` int(5) NOT NULL,
  `title` varchar(100) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_status_title`
--

INSERT INTO `tbl_status_title` (`id`, `title`, `status`) VALUES
(1, 'Placed', 1),
(2, 'Packed', 1),
(3, 'Shipped', 1),
(4, 'Delivered', 1),
(5, 'Cancelled', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_submenu_headers`
--

CREATE TABLE `tbl_submenu_headers` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `sub_category_id` int(11) NOT NULL,
  `submenu_header` varchar(200) NOT NULL,
  `created_at` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_submenu_headers`
--

INSERT INTO `tbl_submenu_headers` (`id`, `category_id`, `sub_category_id`, `submenu_header`, `created_at`) VALUES
(4, 13, 29, 'Ethnic Tops & Sets', '1626066020'),
(5, 13, 29, 'Western Tops &  Set', '1626066045'),
(7, 13, 29, 'ABC', '1626342580'),
(8, 13, 29, 'xyz', '1626342623');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_submenu_items`
--

CREATE TABLE `tbl_submenu_items` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `sub_category_id` int(11) NOT NULL,
  `submenu_header_id` int(11) NOT NULL,
  `submenu_item_name` varchar(200) NOT NULL,
  `submenu_item_name_slug` varchar(300) NOT NULL,
  `created_at` varchar(30) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_submenu_items`
--

INSERT INTO `tbl_submenu_items` (`id`, `category_id`, `sub_category_id`, `submenu_header_id`, `submenu_item_name`, `submenu_item_name_slug`, `created_at`, `status`) VALUES
(1, 13, 29, 5, 'Shirt - Formal', 'clothes-t-shirt', '1626072445', 1),
(3, 13, 29, 5, 'Shirt - Casual', 'decors', '1626098872', 1),
(4, 13, 29, 5, 'Tshirt - Polo', 'tshirt-polo', '1626254682', 1),
(5, 13, 29, 6, 'Briefs & Trunks', 'briefs-trunks', '1626254772', 1),
(6, 13, 29, 6, 'Boxers', 'boxers', '1626254795', 1),
(7, 13, 29, 4, 'Kurta', 'kurta', '1626254825', 1),
(8, 13, 29, 4, 'Kurta set', 'kurta-set', '1626254842', 1),
(9, 13, 29, 5, 'Tshirt - Roundneck', 'tshirt-roundneck', '1626254910', 1),
(10, 13, 29, 5, 'Jackets', 'jackets', '1626254931', 1),
(11, 13, 29, 5, 'Blazer', 'blazer', '1626254960', 1),
(12, 13, 29, 5, 'Suits', 'suits', '1626254977', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sub_category`
--

CREATE TABLE `tbl_sub_category` (
  `id` int(11) NOT NULL,
  `category_id` int(10) NOT NULL,
  `sub_category_name` varchar(150) NOT NULL,
  `sub_category_slug` varchar(150) NOT NULL,
  `sub_category_image` text NOT NULL,
  `created_at` varchar(150) NOT NULL,
  `show_on_off` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_sub_category`
--

INSERT INTO `tbl_sub_category` (`id`, `category_id`, `sub_category_name`, `sub_category_slug`, `sub_category_image`, `created_at`, `show_on_off`, `status`) VALUES
(22, 13, 'Kid Girl', 'kid-girl', '29012020022504_35093.jpg', '1579778172', 1, 1),
(23, 13, 'Kid Boy', 'kid-boy', '23012020044720_25781.jpg', '1579778240', 1, 1),
(28, 13, 'Womens', 'womens', '14072021024635_26406.jpg', '1626254196', 1, 1),
(29, 13, 'Mens', 'mens', '14072021024735_97630.jpg', '1626254255', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_teams`
--

CREATE TABLE `tbl_teams` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_teams`
--

INSERT INTO `tbl_teams` (`id`, `name`, `image`, `content`, `created_at`) VALUES
(5, 'chetan', '15072021112808_49502.jpg', '<p>1</p>\r\n', '1626261407'),
(6, 'reshma', '15072021112658_20968.jpg', '<p>2</p>\r\n', '1626261427'),
(7, 'bhavesh', '15072021112733_10545.jpg', '<p>1</p>\r\n', '1626261580'),
(8, 'varsha', '15072021112712_67596.jpg', '<p>1</p>\r\n', '1626261597'),
(9, 'jigar', '15072021112833_686.jpg', '<p>1</p>\r\n', '1626261614'),
(10, 'rekha', '15072021112618_47384.jpg', '<p>1</p>\r\n', '1626261627');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transaction`
--

CREATE TABLE `tbl_transaction` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `order_id` int(11) NOT NULL,
  `order_unique_id` text NOT NULL,
  `gateway` varchar(30) NOT NULL,
  `payment_amt` varchar(50) NOT NULL,
  `payment_id` varchar(255) NOT NULL,
  `razorpay_order_id` varchar(255) NOT NULL DEFAULT '0',
  `date` varchar(150) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_transaction`
--

INSERT INTO `tbl_transaction` (`id`, `user_id`, `email`, `order_id`, `order_unique_id`, `gateway`, `payment_amt`, `payment_id`, `razorpay_order_id`, `date`, `status`) VALUES
(15, 1, 'shubhambhuvad567@gmail.com', 15, '777554056', 'cod', '1,440.00', '0', '0', '1627732450', 1),
(16, 1, 'shubhambhuvad567@gmail.com', 16, '180481451', 'cod', '1,440.00', '0', '0', '1627732626', 1),
(17, 1, 'shubhambhuvad567@gmail.com', 17, '261278379', 'cod', '1,440.00', '0', '0', '1627732669', 1),
(18, 1, 'shubhambhuvad567@gmail.com', 18, '1387009287', 'cod', '1,440.00', '0', '0', '1627732812', 1),
(19, 1, 'shubhambhuvad567@gmail.com', 19, '812152685', 'cod', '', '0', '0', '1627733160', 1),
(20, 1, 'shubhambhuvad567@gmail.com', 20, '1721821477', 'cod', '1,440.00', '0', '0', '1627733250', 1),
(21, 1, 'shubhambhuvad567@gmail.com', 21, '2041415435', 'cod', '1,440.00', '0', '0', '1627733350', 1),
(22, 1, 'shubhambhuvad567@gmail.com', 22, '909286422', 'cod', '1440', '0', '0', '1627733499', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int(10) NOT NULL,
  `user_type` varchar(30) NOT NULL DEFAULT 'Normal',
  `user_name` varchar(150) NOT NULL,
  `user_email` varchar(80) NOT NULL,
  `user_phone` varchar(30) NOT NULL,
  `user_password` text NOT NULL,
  `user_image` text NOT NULL,
  `device_id` text NOT NULL,
  `player_id` varchar(150) NOT NULL DEFAULT '0',
  `created_at` varchar(150) NOT NULL,
  `auth_id` varchar(200) DEFAULT NULL,
  `register_platform` varchar(60) NOT NULL DEFAULT 'web',
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `user_type`, `user_name`, `user_email`, `user_phone`, `user_password`, `user_image`, `device_id`, `player_id`, `created_at`, `auth_id`, `register_platform`, `status`) VALUES
(1, 'Normal', 'shubham', 'shubhambhuvad567@gmail.com', '8830516259', '3b6beb51e76816e632a40d440eab0097', '', '', '0', '1625743906', NULL, 'web', 1),
(2, 'Normal', 'jit', 'jitendrag645@gmail.com', '9024645458', '8de62442b19dc6ab2cfa79fc2fbd90fa', '', '', '0', '1625996684', NULL, 'web', 1),
(3, 'Normal', 'bhavesh rakhecha', 'bhaveshrakhecha2929@gmail.com', '09819562902', '18340caa837396304626097998533fcb', '', '', '0', '1626258378', NULL, 'web', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_verify`
--

CREATE TABLE `tbl_verify` (
  `id` int(2) NOT NULL,
  `web_envato_buyer_name` text NOT NULL,
  `web_envato_purchase_code` text NOT NULL,
  `web_envato_buyer_email` varchar(150) NOT NULL,
  `web_url` text NOT NULL,
  `web_envato_purchased_status` int(2) NOT NULL DEFAULT '0',
  `android_envato_buyer_name` text NOT NULL,
  `android_envato_purchase_code` text NOT NULL,
  `android_envato_buyer_email` varchar(150) NOT NULL,
  `package_name` varchar(150) NOT NULL,
  `android_envato_purchased_status` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_verify`
--

INSERT INTO `tbl_verify` (`id`, `web_envato_buyer_name`, `web_envato_purchase_code`, `web_envato_buyer_email`, `web_url`, `web_envato_purchased_status`, `android_envato_buyer_name`, `android_envato_purchase_code`, `android_envato_buyer_email`, `package_name`, `android_envato_purchased_status`) VALUES
(1, 'viaviwebtech', 'abc', '-', '', 1, 'viaviwebtech', '', '-', 'com.example.ecommerceapp', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_verify_code`
--

CREATE TABLE `tbl_verify_code` (
  `id` int(10) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `verify_code` varchar(100) NOT NULL,
  `created_at` varchar(150) NOT NULL,
  `is_verify` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_verify_code`
--

INSERT INTO `tbl_verify_code` (`id`, `user_email`, `verify_code`, `created_at`, `is_verify`) VALUES
(1, 'anway@gmail.com', '2718', '1612415259', 0),
(2, 'shubhambhuvad567@gmail.com', '1248', '1625743890', 1),
(3, 'jitendrag645@gmail.com', '1906', '1625996610', 1),
(4, 'bhaveshrakhecha2929@gmail.com', '3705', '1626258296', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_web_settings`
--

CREATE TABLE `tbl_web_settings` (
  `id` int(2) NOT NULL,
  `site_name` text NOT NULL,
  `site_description` text NOT NULL,
  `site_keywords` text NOT NULL,
  `copyright_text` text NOT NULL,
  `web_logo_1` text NOT NULL,
  `web_logo_2` text NOT NULL,
  `web_favicon` text NOT NULL,
  `about_page_title` varchar(150) NOT NULL,
  `about_content` longtext NOT NULL,
  `about_image` varchar(255) DEFAULT NULL,
  `about_status` varchar(10) NOT NULL DEFAULT 'true',
  `faq_content` longtext NOT NULL,
  `privacy_page_title` varchar(150) NOT NULL,
  `privacy_content` longtext NOT NULL,
  `privacy_page_status` varchar(10) NOT NULL DEFAULT 'true',
  `terms_of_use_page_title` varchar(150) NOT NULL,
  `terms_of_use_content` longtext NOT NULL,
  `terms_of_use_page_status` varchar(10) NOT NULL DEFAULT 'true',
  `refund_return_policy_page_title` varchar(150) NOT NULL,
  `refund_return_policy` longtext NOT NULL,
  `refund_return_policy_status` varchar(10) NOT NULL DEFAULT 'true',
  `cancellation_page_title` varchar(150) NOT NULL,
  `cancellation_content` longtext NOT NULL,
  `cancellation_page_status` varchar(10) NOT NULL DEFAULT 'true',
  `payments_page_title` varchar(150) NOT NULL,
  `payments_content` longtext NOT NULL,
  `payments_page_status` varchar(10) NOT NULL DEFAULT 'true',
  `contact_page_title` varchar(150) NOT NULL,
  `address` varchar(255) NOT NULL,
  `contact_number` varchar(60) NOT NULL,
  `contact_email` varchar(60) NOT NULL,
  `home_ad` varchar(20) NOT NULL,
  `home_banner_ad` longtext NOT NULL,
  `product_ad` varchar(20) NOT NULL,
  `product_banner_ad` longtext NOT NULL,
  `android_app_url` text NOT NULL,
  `ios_app_url` text NOT NULL,
  `header_code` longtext NOT NULL,
  `footer_code` longtext NOT NULL,
  `eco_youtube_embed_code` varchar(70) NOT NULL,
  `eco_warrior_content` text NOT NULL,
  `eco_youtube_embed_code1` varchar(70) NOT NULL,
  `eco_warrior_content1` text NOT NULL,
  `libraries_load_from` varchar(10) NOT NULL DEFAULT 'local'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_web_settings`
--

INSERT INTO `tbl_web_settings` (`id`, `site_name`, `site_description`, `site_keywords`, `copyright_text`, `web_logo_1`, `web_logo_2`, `web_favicon`, `about_page_title`, `about_content`, `about_image`, `about_status`, `faq_content`, `privacy_page_title`, `privacy_content`, `privacy_page_status`, `terms_of_use_page_title`, `terms_of_use_content`, `terms_of_use_page_status`, `refund_return_policy_page_title`, `refund_return_policy`, `refund_return_policy_status`, `cancellation_page_title`, `cancellation_content`, `cancellation_page_status`, `payments_page_title`, `payments_content`, `payments_page_status`, `contact_page_title`, `address`, `contact_number`, `contact_email`, `home_ad`, `home_banner_ad`, `product_ad`, `product_banner_ad`, `android_app_url`, `ios_app_url`, `header_code`, `footer_code`, `eco_youtube_embed_code`, `eco_warrior_content`, `eco_youtube_embed_code1`, `eco_warrior_content1`, `libraries_load_from`) VALUES
(1, 'Pipamart', 'Pipamart Online shopping', '', 'Copyright © 2021 Pipamart. All Rights Reserved.', '23012021123019_97804.jpg', '23012021123019_978041.jpg', '01072021025715_74209.png', 'About Pipamart', '<h2>Pipamart was started by Mr. Chetan Tak as one of his efforts to bring khadi products online. The motto was to give work to the local people and promote local brands. </h2>\r\n', '15072021121015_27118.jpg', 'true', '<h3>1) What kind of customer service do you offer?</h3>\r\n\r\n<p>Our ecommerce consultants are here to answer your questions. In addition to FREE phone support, you can contact our consultants via email or live chat.</p>\r\n\r\n<h3>2) Can I build my new Ecommerce site while my other website is still live?</h3>\r\n\r\n<p>Yes! When you purchase one of our ecommerce solutions you will get a standard 3rd level domain to use while you are building your new website. When you are ready to begin hosting your new online store, you simply change your DNS settings to point your existing domain name to your new site.</p>\r\n\r\n<h3>3) Can I use my own domain name?</h3>\r\n\r\n<p>Absolutely! Simply point your domain directly to your new Network Solutions Ecommerce. You do not need to use a subdomain or any other temporary domain name placeholder.</p>\r\n\r\n<h3>4) Are there any system requirements?</h3>\r\n\r\n<p>To access your Ecommerce control panel, you must have Internet access and use a JavaScript enabled browser. The newest version of Internet Explorer, Firefox, Safari or Chrome are recommended.</p>\r\n', 'Privacy', '<h2>What is Lorem Ipsum?</h2>\r\n\r\n<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<h2>Where does it come from?</h2>\r\n\r\n<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p>\r\n', 'true', 'Terms of Use', '<h2>What is Lorem Ipsum?</h2>\r\n\r\n<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<h2>Where does it come from?</h2>\r\n\r\n<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p>\r\n\r\n<p> </p>\r\n', 'true', 'Refund Return Policy', '<h2>What is Lorem Ipsum?</h2>\r\n\r\n<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<h2>Where does it come from?</h2>\r\n\r\n<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p>\r\n', 'true', 'Cancellation Policy', '<h2>What is Lorem Ipsum?</h2>\r\n\r\n<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<h2>Where does it come from?</h2>\r\n\r\n<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p>\r\n', 'true', '', '', 'true', 'Contact us', 'A/ 303, Savli Apartment, Samelpada. Nalasopara West. Palghar', '+91 7769964000', 'info@pipamart.com', 'false', '', 'false', '', '', '', '', '', 'dyEdYUv2jKo', '<h1>Pipamart </h1>\r\n\r\n<h2>Spreading Happiness to Many Families through the Medium of KHADI & local products</h2>\r\n\r\n<p>A budding young social entrepreneur Balwant holds Bachelors in Mass Media (BMM) from University of Mumbai and Masters in Advertising and Marketing Management (MBA) from NIBM.</p>\r\n\r\n<p>Baiwant is a native of Wardha, born and raised in Gandhian atmosphere. He was fortunate to get a chance to understand the Gandhian ideology of Swaraj and Swavalamban since early childhood.</p>\r\n\r\n<p>He has been closely associated with Mahatma Gandhi&#39;s Ashram in Sewagram and Vinoba Bhave&#39;s Ashram in Pawnar and several</p>', 'HAI1vDtFoWg', '<h1>Pipamart </h1>\r\n\r\n<h2>Spreading Happiness to Many Families through the Medium of KHADI & local products</h2>\r\n\r\n<p>A budding young social entrepreneur Balwant holds Bachelors in Mass Media (BMM) from University of Mumbai and Masters in Advertising and Marketing Management (MBA) from NIBM.</p>\r\n\r\n<p>Baiwant is a native of Wardha, born and raised in Gandhian atmosphere. He was fortunate to get a chance to understand the Gandhian ideology of Swaraj and Swavalamban since early childhood.</p>\r\n\r\n<p>He has been closely associated with Mahatma Gandhi&#39;s Ashram in Sewagram and Vinoba Bhave&#39;s Ashram in Pawnar and several</p>', 'local');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_wishlist`
--

CREATE TABLE `tbl_wishlist` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `created_at` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_addresses`
--
ALTER TABLE `tbl_addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_android_settings`
--
ALTER TABLE `tbl_android_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_applied_coupon`
--
ALTER TABLE `tbl_applied_coupon`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_bank_details`
--
ALTER TABLE `tbl_bank_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_banner`
--
ALTER TABLE `tbl_banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_brands`
--
ALTER TABLE `tbl_brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_cart_tmp`
--
ALTER TABLE `tbl_cart_tmp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_cms_contents`
--
ALTER TABLE `tbl_cms_contents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_contact_list`
--
ALTER TABLE `tbl_contact_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_contact_sub`
--
ALTER TABLE `tbl_contact_sub`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_coupon`
--
ALTER TABLE `tbl_coupon`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_faq`
--
ALTER TABLE `tbl_faq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_logs`
--
ALTER TABLE `tbl_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_offers`
--
ALTER TABLE `tbl_offers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_order_details`
--
ALTER TABLE `tbl_order_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_order_items`
--
ALTER TABLE `tbl_order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_order_status`
--
ALTER TABLE `tbl_order_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_partner_with_us_list`
--
ALTER TABLE `tbl_partner_with_us_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_product_images`
--
ALTER TABLE `tbl_product_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_rating`
--
ALTER TABLE `tbl_rating`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_recent_viewed`
--
ALTER TABLE `tbl_recent_viewed`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_refund`
--
ALTER TABLE `tbl_refund`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_smtp_settings`
--
ALTER TABLE `tbl_smtp_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_status_title`
--
ALTER TABLE `tbl_status_title`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_submenu_headers`
--
ALTER TABLE `tbl_submenu_headers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_submenu_items`
--
ALTER TABLE `tbl_submenu_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_sub_category`
--
ALTER TABLE `tbl_sub_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_teams`
--
ALTER TABLE `tbl_teams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_transaction`
--
ALTER TABLE `tbl_transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_verify`
--
ALTER TABLE `tbl_verify`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_verify_code`
--
ALTER TABLE `tbl_verify_code`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_web_settings`
--
ALTER TABLE `tbl_web_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_wishlist`
--
ALTER TABLE `tbl_wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_addresses`
--
ALTER TABLE `tbl_addresses`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_android_settings`
--
ALTER TABLE `tbl_android_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_applied_coupon`
--
ALTER TABLE `tbl_applied_coupon`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `tbl_bank_details`
--
ALTER TABLE `tbl_bank_details`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_banner`
--
ALTER TABLE `tbl_banner`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_brands`
--
ALTER TABLE `tbl_brands`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `tbl_cart_tmp`
--
ALTER TABLE `tbl_cart_tmp`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_cms_contents`
--
ALTER TABLE `tbl_cms_contents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_contact_list`
--
ALTER TABLE `tbl_contact_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_contact_sub`
--
ALTER TABLE `tbl_contact_sub`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_coupon`
--
ALTER TABLE `tbl_coupon`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_faq`
--
ALTER TABLE `tbl_faq`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_logs`
--
ALTER TABLE `tbl_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_offers`
--
ALTER TABLE `tbl_offers`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_order_details`
--
ALTER TABLE `tbl_order_details`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tbl_order_items`
--
ALTER TABLE `tbl_order_items`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tbl_order_status`
--
ALTER TABLE `tbl_order_status`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `tbl_partner_with_us_list`
--
ALTER TABLE `tbl_partner_with_us_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `tbl_product_images`
--
ALTER TABLE `tbl_product_images`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=459;

--
-- AUTO_INCREMENT for table `tbl_rating`
--
ALTER TABLE `tbl_rating`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_recent_viewed`
--
ALTER TABLE `tbl_recent_viewed`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_refund`
--
ALTER TABLE `tbl_refund`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_smtp_settings`
--
ALTER TABLE `tbl_smtp_settings`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_status_title`
--
ALTER TABLE `tbl_status_title`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_submenu_headers`
--
ALTER TABLE `tbl_submenu_headers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_submenu_items`
--
ALTER TABLE `tbl_submenu_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_sub_category`
--
ALTER TABLE `tbl_sub_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tbl_teams`
--
ALTER TABLE `tbl_teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_transaction`
--
ALTER TABLE `tbl_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_verify`
--
ALTER TABLE `tbl_verify`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_verify_code`
--
ALTER TABLE `tbl_verify_code`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_web_settings`
--
ALTER TABLE `tbl_web_settings`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_wishlist`
--
ALTER TABLE `tbl_wishlist`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
