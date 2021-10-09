-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 04, 2020 at 01:02 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce_app_buyer`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_addresses`
--

CREATE TABLE `tbl_addresses` (
  `id` int(10) NOT NULL,
  `user_id` int(5) NOT NULL,
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
  `is_default` varchar(10) NOT NULL DEFAULT 'false',
  `created_at` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `api_home_limit` int(5) NOT NULL DEFAULT 5,
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
  `is_default` int(1) NOT NULL DEFAULT 0,
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
  `offer_id` int(10) NOT NULL DEFAULT 0,
  `created_at` varchar(150) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_banner`
--

INSERT INTO `tbl_banner` (`id`, `banner_title`, `banner_slug`, `banner_desc`, `banner_image`, `product_ids`, `offer_id`, `created_at`, `status`) VALUES
(1, 'Sale Keyboard Up To 20% Off', 'sale-keyboard-up-to-20-off', '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n', '03012020044445_84207.jpg', '65,63,62,61', 0, '1561701428', 1),
(5, '40% off on kid\'s footwear', '40-off-on-kids-footwear', '<p>40% off on kid&#39;s footwear</p>\r\n', '03012020044022_64387.jpg', '68,67,60,59,58', 0, '1578049822', 1),
(6, 'It\'s time for bata shoes and so on', 'its-time-for-bata-shoes-and-so-on', '<p>It&#39;s time for bata shoes and so on</p>\r\n', '03012020054220_70825.jpg', '60,59,56', 0, '1578049897', 1),
(7, 'Get Discount And Mega Savings!', 'get-discount-and-mega-savings', '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry.</p>\r\n', '07102020041256_47520.jpg', '50,43,38,36,35,34,9,8,5,1', 1, '1578721023', 1);

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
  `status` int(1) NOT NULL DEFAULT 1
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
(23, '10', 'Beonza', 'beonza', '', '1579781611', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cart`
--

CREATE TABLE `tbl_cart` (
  `id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `product_qty` int(5) NOT NULL DEFAULT 1,
  `product_size` varchar(10) NOT NULL DEFAULT '0',
  `created_at` varchar(150) NOT NULL,
  `cart_status` int(2) NOT NULL DEFAULT 1,
  `last_update` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cart_tmp`
--

CREATE TABLE `tbl_cart_tmp` (
  `id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `product_qty` int(5) NOT NULL DEFAULT 1,
  `product_size` varchar(10) NOT NULL DEFAULT '0',
  `created_at` varchar(150) NOT NULL,
  `cart_status` int(1) NOT NULL DEFAULT 1,
  `cart_unique_id` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `set_on_home` int(1) NOT NULL DEFAULT 0,
  `created_at` varchar(150) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`id`, `category_name`, `category_slug`, `category_image`, `product_features`, `set_on_home`, `created_at`, `status`) VALUES
(1, 'Electronics', 'electronics', '21102019093649_13765.jpg', 'color', 1, '1568958951', 1),
(2, 'Clothing', 'clothing', '21102019093406_95167.jpg', 'color,size', 1, '1568961064', 1),
(4, 'Home Appliance', 'home-appliance', '23102019035435_39909.jpg', 'color', 0, '1571826275', 1),
(9, 'Jewellery', 'jewellery', '30122019094555_85429.jpg', 'color', 0, '1577679355', 1),
(10, 'Footwear', 'footwear', '03012020045441_13882.jpg', 'color,size', 1, '1578050258', 1),
(11, 'Beauty & Health', 'beauty-health', '10012020102548_56343.jpg', 'color', 0, '1578632148', 1),
(13, 'Food & Nutrition', 'food-nutrition', '23012020044452_57023.jpg', 'color,size', 0, '1579778059', 1);

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

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contact_sub`
--

CREATE TABLE `tbl_contact_sub` (
  `id` int(5) NOT NULL,
  `title` varchar(150) NOT NULL,
  `title_slug` varchar(150) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `created_at` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_contact_sub`
--

INSERT INTO `tbl_contact_sub` (`id`, `title`, `title_slug`, `status`, `created_at`) VALUES
(1, 'Order Cancellation', 'order-cancellation', 1, ''),
(2, 'Order Payment', 'order-payment', 1, '');

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
  `coupon_limit_use` int(10) NOT NULL DEFAULT 1,
  `created_at` varchar(150) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_coupon`
--

INSERT INTO `tbl_coupon` (`id`, `coupon_desc`, `coupon_code`, `coupon_image`, `coupon_per`, `coupon_amt`, `max_amt_status`, `coupon_max_amt`, `cart_status`, `coupon_cart_min`, `coupon_limit_use`, `created_at`, `status`) VALUES
(1, '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n', '40OFFALL', '29062019093713_18947.jpg', 40, 0, 'true', 1000, 'true', '2000', 1, '1561781233', 1),
(2, '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like readable English.</p>\r\n', '50%OFF', '29062019032607_64692.jpg', 50, 0, 'false', 50, 'false', '10000', 10, '1561802167', 1),
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
  `status` int(1) NOT NULL DEFAULT 1
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
  `params` text DEFAULT NULL,
  `api_key` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `time` int(11) NOT NULL,
  `rtime` float DEFAULT NULL,
  `authorized` varchar(1) NOT NULL,
  `response_code` smallint(3) DEFAULT 0
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
  `status` int(1) NOT NULL DEFAULT 1
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
  `coupon_id` int(5) NOT NULL DEFAULT 0,
  `order_unique_id` text NOT NULL,
  `order_address` int(5) NOT NULL,
  `total_amt` double NOT NULL,
  `discount` varchar(10) DEFAULT '0',
  `discount_amt` double NOT NULL,
  `payable_amt` double NOT NULL,
  `new_payable_amt` double NOT NULL,
  `refund_amt` double NOT NULL DEFAULT 0,
  `refund_per` double NOT NULL DEFAULT 0,
  `order_date` varchar(150) NOT NULL,
  `delivery_date` varchar(150) NOT NULL,
  `order_status` int(2) NOT NULL DEFAULT -1,
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
  `is_seen` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `you_save_amt` double NOT NULL DEFAULT 0,
  `product_size` varchar(10) NOT NULL,
  `total_price` double NOT NULL,
  `delivery_charge` float NOT NULL,
  `pro_order_status` int(3) NOT NULL DEFAULT -1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product`
--

CREATE TABLE `tbl_product` (
  `id` int(10) NOT NULL,
  `category_id` int(5) NOT NULL,
  `sub_category_id` int(5) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `offer_id` int(10) NOT NULL DEFAULT 0,
  `product_title` varchar(255) NOT NULL,
  `product_slug` varchar(150) NOT NULL,
  `product_desc` longtext NOT NULL,
  `product_features` longtext NOT NULL,
  `featured_image` text NOT NULL,
  `featured_image2` text NOT NULL,
  `size_chart` text NOT NULL,
  `product_mrp` double NOT NULL,
  `selling_price` double NOT NULL DEFAULT 0,
  `you_save_amt` double NOT NULL DEFAULT 0,
  `you_save_per` double NOT NULL DEFAULT 0,
  `other_color_product` text NOT NULL,
  `color` varchar(100) NOT NULL,
  `product_size` text NOT NULL,
  `product_quantity` int(5) NOT NULL DEFAULT 1,
  `max_unit_buy` int(5) NOT NULL DEFAULT 1,
  `delivery_charge` float NOT NULL,
  `total_views` varchar(10) NOT NULL DEFAULT '0',
  `total_rate` int(10) NOT NULL DEFAULT 0,
  `rate_avg` double NOT NULL DEFAULT 0,
  `is_featured` int(1) DEFAULT 0,
  `today_deal` int(2) NOT NULL DEFAULT 0,
  `today_deal_date` varchar(150) NOT NULL DEFAULT '0',
  `total_sale` int(10) NOT NULL DEFAULT 0,
  `created_at` varchar(150) NOT NULL,
  `seo_title` varchar(150) NOT NULL,
  `seo_meta_description` longtext NOT NULL,
  `seo_keywords` longtext NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_product`
--

INSERT INTO `tbl_product` (`id`, `category_id`, `sub_category_id`, `brand_id`, `offer_id`, `product_title`, `product_slug`, `product_desc`, `product_features`, `featured_image`, `featured_image2`, `size_chart`, `product_mrp`, `selling_price`, `you_save_amt`, `you_save_per`, `other_color_product`, `color`, `product_size`, `product_quantity`, `max_unit_buy`, `delivery_charge`, `total_views`, `total_rate`, `rate_avg`, `is_featured`, `today_deal`, `today_deal_date`, `total_sale`, `created_at`, `seo_title`, `seo_meta_description`, `seo_keywords`, `status`) VALUES
(1, 1, 8, 1, 1, 'Redmi Note 7S (Astro Moonlight White, 64 GB)  (4 GB RAM)', 'redmi-note-7s-astro-moonlight-white-64-gb-4-gb-ram', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '<ul>\r\n <li>4 GB RAM | 64 GB ROM | Expandable Upto 256 GB</li>\r\n <li>16.0 cm (6.3 inch) FHD+ Display</li>\r\n <li>48MP + 5MP | 13MP Front Camera</li>\r\n <li>4000 mAh Battery</li>\r\n <li>Qualcomm Snapdragon 660 AIE Processor</li>\r\n <li>Quick Charge 4.0 Support</li>\r\n</ul>\r\n', '25102019040021_34193.jpg', '25102019040114_92396_2_.jpg', '', 155, 77.5, 77.5, 50, '3', 'Astro Moonlight White/E6E6E6', '', 0, 5, 0, '0', 0, 0, 0, 0, '0', 0, '1568979219', '', '', '', 1),
(3, 1, 8, 1, 0, 'Redmi Note 7S (Onyx Black, 32 GB)  (3 GB RAM)', 'redmi-note-7s-onyx-black-32-gb-3-gb-ram', '<ul>\r\n <li>4 GB RAM | 64 GB ROM | Expandable Upto 256 GB</li>\r\n <li>16.0 cm (6.3 inch) FHD+ Display</li>\r\n <li>48MP + 5MP | 13MP Front Camera</li>\r\n <li>4000 mAh Battery</li>\r\n <li>Qualcomm Snapdragon 660 AIE Processor</li>\r\n <li>Quick Charge 4.0 Support</li>\r\n</ul>\r\n', '<h3>General</h3>\r\n\r\n<table border=\"1\" cellpadding=\"10\" cellspacing=\"10\">\r\n <tbody>\r\n  <tr>\r\n   <td>In The Box</td>\r\n   <td>\r\n   <ul>\r\n    <li>Handset, Charging Cable, SIM Ejector Tool, Warranty Card, Manual, Soft Protective Case, Adapter</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Model Number</td>\r\n   <td>\r\n   <ul>\r\n    <li>MZB7744IN</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Model Name</td>\r\n   <td>\r\n   <ul>\r\n    <li>Redmi Note 7S</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Color</td>\r\n   <td>\r\n   <ul>\r\n    <li>Onyx Black</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Browse Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>Smartphones</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>SIM Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>Dual Sim</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Hybrid Sim Slot</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Touchscreen</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>OTG Compatible</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Sound Enhancements</td>\r\n   <td>\r\n   <ul>\r\n    <li>Speaker: Single (Bottom Opening), 2 Microphones (for Noise Cancellation), Smart PA</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>SAR Value</td>\r\n   <td>\r\n   <ul>\r\n    <li>Head - 0.962W/kg, Body - 0.838W/kg</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Display Features</h3>\r\n\r\n<table border=\"1\" cellpadding=\"10\" cellspacing=\"10\">\r\n <tbody>\r\n  <tr>\r\n   <td>Display Size</td>\r\n   <td>\r\n   <ul>\r\n    <li>16.0 cm (6.3 inch)</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Resolution</td>\r\n   <td>\r\n   <ul>\r\n    <li>2340 x 1080 pixels</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Resolution Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>Full HD+</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>GPU</td>\r\n   <td>\r\n   <ul>\r\n    <li>Adreno 512</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Display Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>IPS (In-cell), RD</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Other Display Features</td>\r\n   <td>\r\n   <ul>\r\n    <li>Contrast Ratio: 1500:1 (Typical), 81.41% NTSC Ratio, Gorilla Glass 5 (Front and Back)</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Os & Processor Features</h3>\r\n\r\n<table border=\"1\" cellpadding=\"10\" cellspacing=\"10\">\r\n <tbody>\r\n  <tr>\r\n   <td>Operating System</td>\r\n   <td>\r\n   <ul>\r\n    <li>Android Pie 9.0</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Processor Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>Qualcomm Snapdragon 660 AIE</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Processor Core</td>\r\n   <td>\r\n   <ul>\r\n    <li>Octa Core</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Primary Clock Speed</td>\r\n   <td>\r\n   <ul>\r\n    <li>2.2 GHz</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Secondary Clock Speed</td>\r\n   <td>\r\n   <ul>\r\n    <li>1.8 GHz</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Operating Frequency</td>\r\n   <td>\r\n   <ul>\r\n    <li>GSM: B2, B3, B5, B8, WCDMA: B1, B2, B5, B8, 4G LTE-TDD: B40, B41, 4G LTE-FDD: B1, B3, B5, B8, CA: 1C (Only DLCA), 3C, 40C, 41C</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Memory & Storage Features</h3>\r\n\r\n<table border=\"1\" cellpadding=\"10\" cellspacing=\"10\">\r\n <tbody>\r\n  <tr>\r\n   <td>Internal Storage</td>\r\n   <td>\r\n   <ul>\r\n    <li>32 GB</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>RAM</td>\r\n   <td>\r\n   <ul>\r\n    <li>3 GB</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Expandable Storage</td>\r\n   <td>\r\n   <ul>\r\n    <li>256 GB</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Supported Memory Card Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>microSD</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Memory Card Slot Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>Hybrid Slot</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Camera Features</h3>\r\n\r\n<table border=\"1\" cellpadding=\"10\" cellspacing=\"10\">\r\n <tbody>\r\n  <tr>\r\n   <td>Primary Camera Available</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Primary Camera</td>\r\n   <td>\r\n   <ul>\r\n    <li>48MP + 5MP</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Primary Camera Features</td>\r\n   <td>\r\n   <ul>\r\n    <li>48MP (GM1) - F1.79, 1.6 micrometer (4 in 1), 6P Lens (48MP) + 3P Lens (5MP), PDAF, 5MP - F2.2, 1.12 micrometer, Slow Motion Support at 120 fps</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Secondary Camera Available</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Secondary Camera</td>\r\n   <td>\r\n   <ul>\r\n    <li>13MP</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Secondary Camera Features</td>\r\n   <td>\r\n   <ul>\r\n    <li>F2.0 Aperture, 1.12 micrometer</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Flash</td>\r\n   <td>\r\n   <ul>\r\n    <li>Rear Flash</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Dual Camera Lens</td>\r\n   <td>\r\n   <ul>\r\n    <li>Primary Camera</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Connectivity Features</h3>\r\n\r\n<table border=\"1\" cellpadding=\"10\" cellspacing=\"10\">\r\n <tbody>\r\n  <tr>\r\n   <td>Network Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>3G, 4G VOLTE, 4G, 2G</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Supported Networks</td>\r\n   <td>\r\n   <ul>\r\n    <li>GSM, WCDMA, 4G VoLTE, 4G LTE</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Internet Connectivity</td>\r\n   <td>\r\n   <ul>\r\n    <li>4G, 3G, Wi-Fi</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>3G</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Bluetooth Support</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Bluetooth Version</td>\r\n   <td>\r\n   <ul>\r\n    <li>5.0</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Wi-Fi</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Wi-Fi Version</td>\r\n   <td>\r\n   <ul>\r\n    <li>802.11a/b/g/n/ac</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>USB Connectivity</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Audio Jack</td>\r\n   <td>\r\n   <ul>\r\n    <li>3.5mm</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Map Support</td>\r\n   <td>\r\n   <ul>\r\n    <li>Google Maps</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>GPS Support</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Other Details</h3>\r\n\r\n<table border=\"1\" cellpadding=\"10\" cellspacing=\"10\">\r\n <tbody>\r\n  <tr>\r\n   <td>Smartphone</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>SIM Size</td>\r\n   <td>\r\n   <ul>\r\n    <li>Nano SIM + Nano SIM</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>User Interface</td>\r\n   <td>\r\n   <ul>\r\n    <li>MIUI 10</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Graphics PPI</td>\r\n   <td>\r\n   <ul>\r\n    <li>409 PPI</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Sensors</td>\r\n   <td>\r\n   <ul>\r\n    <li>Rear Fingerprint Sensor, Ambient Light Sensor, Proximity Sensor, E-compass, Accelerometer, Gyroscope</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Other Features</td>\r\n   <td>\r\n   <ul>\r\n    <li>Clock Speed/Cores/Bits: 4 x Gold 2.2 GHz + 4 x Silver 1.8 GHz, eMMC v5.1, Charger: 5V/2A, Body: 2.5D Glass (Back and Front), Splash-proof Protected by P2i, Quick Charge 4.0, Super Low Light (Night) Photography, IR Blaster, USB Type-C (2.0)</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>GPS Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>A-GPS, GLONASS, BeiDou</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Battery & Power Features</h3>\r\n\r\n<table border=\"1\" cellpadding=\"10\" cellspacing=\"10\">\r\n <tbody>\r\n  <tr>\r\n   <td>Battery Capacity</td>\r\n   <td>\r\n   <ul>\r\n    <li>4000 mAh</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Battery Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>Li-polymer</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Dimensions</h3>\r\n\r\n<table border=\"1\" cellpadding=\"10\" cellspacing=\"10\">\r\n <tbody>\r\n  <tr>\r\n   <td>Width</td>\r\n   <td>\r\n   <ul>\r\n    <li>75.21 mm</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Height</td>\r\n   <td>\r\n   <ul>\r\n    <li>159.21 mm</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Depth</td>\r\n   <td>\r\n   <ul>\r\n    <li>8.1 mm</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Weight</td>\r\n   <td>\r\n   <ul>\r\n    <li>186 g</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Warranty</h3>\r\n\r\n<table border=\"1\" cellpadding=\"10\" cellspacing=\"10\">\r\n <tbody>\r\n  <tr>\r\n   <td>Warranty Summary</td>\r\n   <td>\r\n   <ul>\r\n    <li>Brand Warranty of 1 Year Available for Mobile and 6 Months for Accessories</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n', '25102019044132_87865.jpg', '25102019044145_21759_2_.jpg', '', 166.39, 166.39, 0, 0, '1', 'Onyx Black/171717', '', 0, 5, 0, '0', 0, 0, 0, 0, '0', 0, '1568979219', '', '', '', 1),
(4, 2, 3, 8, 0, 'Black Jeans for Girl', 'black-jeans-for-girl', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum\r\n', '', '25102019053946_62867.jpg', '25102019053956_59522_2_.jpg', '', 20.92, 20.92, 0, 0, '2', 'Sky Blue/27E3A6', 'XS, S, M, L, XL', 0, 3, 0, '0', 0, 0, 0, 0, '0', 0, '1569500852', '', '', '', 1),
(5, 1, 8, 3, 1, 'Samsung Galaxy M30s (Sapphire Blue, 4GB RAM, Super AMOLED Display, 64GB Storage, 6000mAH Battery)', 'samsung-galaxy-m30s-sapphire-blue-4gb-ram-super-amoled-display-64gb-storage-6000mah-battery', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '<h3>General</h3>\r\n\r\n<table border=\"1\" cellpadding=\"10\" cellspacing=\"10\">\r\n <tbody>\r\n  <tr>\r\n   <td>In The Box</td>\r\n   <td>\r\n   <ul>\r\n    <li>Handset, Adapter (5V/2A), Micro-USB Cable, Important Information Booklet with Warranty Card, Quick Guide, SIM Card Tool, Screen Protect Film</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Model Number</td>\r\n   <td>\r\n   <ul>\r\n    <li>RMX1941</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Model Name</td>\r\n   <td>\r\n   <ul>\r\n    <li>C2</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Color</td>\r\n   <td>\r\n   <ul>\r\n    <li>Diamond Black</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Browse Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>Smartphones</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>SIM Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>Dual Sim</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Hybrid Sim Slot</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Touchscreen</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>OTG Compatible</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Display Features</h3>\r\n\r\n<table border=\"1\" cellpadding=\"10\" cellspacing=\"10\">\r\n <tbody>\r\n  <tr>\r\n   <td>Display Size</td>\r\n   <td>\r\n   <ul>\r\n    <li>15.49 cm (6.1 inch)</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Resolution</td>\r\n   <td>\r\n   <ul>\r\n    <li>1560 x 720 pixels</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Resolution Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>HD+</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>GPU</td>\r\n   <td>\r\n   <ul>\r\n    <li>GE8320</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Display Colors</td>\r\n   <td>\r\n   <ul>\r\n    <li>16.7M</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Other Display Features</td>\r\n   <td>\r\n   <ul>\r\n    <li>Screen Texture: a-Si, In-cell Touch Panel Technology, Screen Ratio: 19.5:9, Touch Panel Glass Type: GG3, Screen Contrast: 1200/900, Color Saturation: 70%/65% NTSC, Maximum Brightness: 450 nits/400 nits</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n', '25102019043521_33791.jpg', '25102019043835_38319_2_.jpg', '', 216.15, 108, 108, 50, '', 'Sapphire Blue/3FD4E0', '', 0, 2, 0, '0', 0, 0, 0, 0, '0', 0, '1572001521', '', '', '', 1),
(8, 1, 8, 1, 1, 'Redmi Note 8 Pro (Gamma Green, 128 GB) (6 GB RAM)', 'redmi-note-8-pro-gamma-green-128-gb-6-gb-ram', '<ul>\r\n <li>6 GB RAM | 128 GB ROM | Expandable Upto 128 GB</li>\r\n <li>16.59 cm (6.53 inch) FHD+ Display</li>\r\n <li>64MP + 8MP</li>\r\n <li>4500 mAh Battery</li>\r\n</ul>\r\n', '', '07112019043756_10538.jpg', '07112019043856_38590_2_.jpg', '', 264.61, 132, 132, 50, '', 'Gamma Green/1783B3', '', 0, 5, 0, '0', 0, 0, 0, 0, '0', 0, '1573124876', '', '', '', 1),
(9, 1, 8, 6, 1, 'Realme XT (Pearl Blue, 64 GB) (4 GB RAM)', 'realme-xt-pearl-blue-64-gb-4-gb-ram', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n', '<ul>\r\n <li>4 GB RAM | 64 GB ROM | Expandable Upto 256 GB</li>\r\n <li>16.26 cm (6.4 inch) Display</li>\r\n <li>64MP + 8MP + 2MP + 2MP Quad Camera | 16MP Front Camera</li>\r\n <li>4000 mAh Battery</li>\r\n <li>Qualcomm 712 Processor</li>\r\n <li>FHD+ Super AMOLED Display</li>\r\n <li>In Display Fingerprint Sensor</li>\r\n</ul>\r\n', '07112019044349_64821.jpg', '07112019044421_82151_2_.jpg', '', 237.05, 118.5, 118.5, 50, '', 'Pearl Blue/2B52D9', '', 0, 5, 0, '0', 0, 0, 0, 0, '0', 0, '1573125229', '', '', '', 1),
(22, 1, 7, 9, 0, 'Analog Watch of Lois Caron', 'analog-watch-of-lois-caron', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n', '11122019042549_97888.jpg', '11122019042549_978881.jpg', '', 60, 60, 0, 0, '', 'White/FFFFFF', '', 0, 5, 0, '0', 0, 0, 0, 0, '0', 0, '1576061749', '', '', '', 1),
(23, 9, 16, 10, 0, 'Alloy Jewel Set  (Gold) International', 'alloy-jewel-set-gold-international', 'This Sukkhi Intricately Gold Plated AD Set of 3 Necklace Set Combo For Women is made of Alloy. Women love jewellery; specially traditional jewellery adore a women. They wear it on different occasion. They have special importance on ring ceremony, wedding and festive time. They can also wear it on regular basics. Make your moment memorable with this range. This jewel set features a unique one of a kind traditional embellish with antic finish.', '<p><strong>Base Material:</strong> Alloy</p>\r\n\r\n<p><strong>Color:</strong> Gold</p>\r\n\r\n<p><strong>Type:</strong> Earring & Necklace Set</p>\r\n\r\n<p><strong>Ideal For:</strong> Women</p>\r\n\r\n<p><strong>Plating:</strong> Gold-plated</p>\r\n\r\n<p><strong>Sales Package: </strong>3 Necklace, 6 Earring</p>\r\n\r\n<p><strong>Collection:</strong> Ethnic</p>\r\n\r\n<p><strong>Occasion:</strong> Wedding & Engagement</p>\r\n\r\n<p><strong>Weight:</strong> 100 g</p>\r\n', '30122019101543_47539.jpeg', '30122019101543_475391.jpeg', '', 6.88, 6.88, 0, 0, '', 'Gold/FFC829', '', 0, 3, 0, '0', 0, 0, 0, 0, '0', 0, '1577681143', '', '', '', 1),
(24, 4, 4, 11, 0, 'LG 190 L Direct Cool Single Door 5 Star 2019 BEE Rating Refrigerator with Base Drawer  (Shiny Steel, GL-D201APZY)', 'lg-190-l-direct-cool-single-door-5-star-2019-bee-rating-refrigerator-with-base-drawer-shiny-steel-gl-d201apzy', 'This 190 L Direct Cool refrigerator from LG will make your life simpler by keeping all your food items fresh, saving some space in your kitchen, and making ice faster. It has been ergonomically designed with toughened glass shelves to accommodate heavy utensils, and it includes a base stand drawer that lets you keep all items that don’t need refrigeration. That’s not all, the Smart Connect Technology ensures that your food continues to remain fresh, even when there is a power cut.', '<ul>\r\n <li>190 L : Good for couples and small families</li>\r\n <li>Smart Inverter Compressor</li>\r\n <li>5 Star : For Energy savings up to 55%</li>\r\n <li>Direct Cool : Economical, consumes less electricity, requires manual defrosting</li>\r\n <li>Base Stand with Drawer : For storing items that don&#39;t need cooling (Onion, Potato etc.)</li>\r\n</ul>\r\n\r\n<p> </p>\r\n\r\n<h3>General</h3>\r\n\r\n<table border=\"1\">\r\n <tbody>\r\n  <tr>\r\n   <td>In The Box</td>\r\n   <td>\r\n   <ul>\r\n    <li>1 Refrigerator Unit</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>Single Door</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Refrigerator Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>Top Mount</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Defrosting Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>Direct Cool</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Compressor Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>Smart Inverter Compressor</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Capacity</td>\r\n   <td>\r\n   <ul>\r\n    <li>190 L</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Number of Doors</td>\r\n   <td>\r\n   <ul>\r\n    <li>1</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Star Rating</td>\r\n   <td>\r\n   <ul>\r\n    <li>5</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Coolpad</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Toughened Glass</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Built-in Stabilizer</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Performance Features</h3>\r\n\r\n<table border=\"1\">\r\n <tbody>\r\n  <tr>\r\n   <td>Convertible Refrigerator</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Body And Design Features</h3>\r\n\r\n<table border=\"1\">\r\n <tbody>\r\n  <tr>\r\n   <td>Shelf Material</td>\r\n   <td>\r\n   <ul>\r\n    <li>Toughened Glass</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Design</td>\r\n   <td>\r\n   <ul>\r\n    <li>Solid</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n', '01012020035823_3022.jpg', '01012020035823_30221.jpg', '', 210.19, 210.19, 0, 0, '25', 'Shiny Steel/F0F0F0', '', 0, 2, 0, '0', 0, 0, 0, 0, '0', 0, '1577874503', '', '', '', 1),
(25, 4, 4, 11, 0, 'LG 190 L Direct Cool Single Door 5 Star 2019 BEE Rating Refrigerator  (Scarlet Plumeria, GL-B201ASPY)', 'lg-190-l-direct-cool-single-door-5-star-2019-bee-rating-refrigerator-scarlet-plumeria-gl-b201aspy', 'Drinks, fresh fruits, or leftover meals - your kitchen will always have something delicious to relish with this LG 190 L refrigerator in your home. This essential kitchen appliance features LG’s Smart Inverter Compressor, Smart Connect Technology, and an Anti-bacterial Gasket for effective cooling and long-lasting consistent performance.', '<h3>General</h3>\r\n\r\n<table border=\"\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>In The Box</td>\r\n   <td>\r\n   <ul>\r\n    <li>1 Refrigerator Unit</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>Single Door</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Refrigerator Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>Top Mount</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Defrosting Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>Direct Cool</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Compressor Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>Smart Inverter Compressor</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Capacity</td>\r\n   <td>\r\n   <ul>\r\n    <li>190 L</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Number of Doors</td>\r\n   <td>\r\n   <ul>\r\n    <li>1</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Star Rating</td>\r\n   <td>\r\n   <ul>\r\n    <li>5</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Coolpad</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Toughened Glass</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Built-in Stabilizer</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n', '01012020041454_30717.jpg', '01012020041454_307171.jpg', '', 210.19, 210.19, 0, 0, '24', 'Scarlet Plumeria/21191C', '', 0, 2, 0, '0', 0, 0, 0, 0, '0', 0, '1577875494', '', '', '', 1),
(26, 4, 4, 3, 0, 'Samsung 192 L Direct Cool Single Door 2 Star 2019 BEE Rating Refrigerator with Base Drawer  (Star Flower Red, RR19N1822R2-HL/ RR19R2822R2-NL)', 'samsung-192-l-direct-cool-single-door-2-star-2019-bee-rating-refrigerator-with-base-drawer-star-flower-red-rr19n1822r2-hl-rr19r2822r2-nl', 'Don’t just keep your fruits and veggies fresh, keep them hygienic as well. And, this 192-litre Samsung refrigerator helps you do just that. While this refrigerator’s anti-bacterial gasket prevents fungi and bacteria from accumulating inside it, its Vege Box offers you ample room to store delicious fruits and vegetables, so you don’t have to buy them again and again.', '<h3>General</h3>\r\n\r\n<table border=\"\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>In The Box</td>\r\n   <td>\r\n   <ul>\r\n    <li>1 Refrigerator Unit</li>\r\n    <li>User Manual</li>\r\n    <li>Warranty Card</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>Single Door</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Refrigerator Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>Top Mount</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Defrosting Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>Direct Cool</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Compressor Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>Normal Compressor</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Capacity</td>\r\n   <td>\r\n   <ul>\r\n    <li>192 L</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Number of Doors</td>\r\n   <td>\r\n   <ul>\r\n    <li>1</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Star Rating</td>\r\n   <td>\r\n   <ul>\r\n    <li>2</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Coolpad</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Toughened Glass</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Built-in Stabilizer</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Performance Features</h3>\r\n\r\n<table border=\"\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Convertible Refrigerator</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Body And Design Features</h3>\r\n\r\n<table border=\"\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Shelf Material</td>\r\n   <td>\r\n   <ul>\r\n    <li>Toughened Glass</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n', '01012020042007_4927.jpg', '01012020042007_49271.jpg', '', 187.76, 187.76, 0, 0, '', 'Star Flower Red/681620', '', 0, 2, 0, '0', 0, 0, 0, 0, '0', 0, '1577875807', '', '', '', 1),
(27, 4, 5, 0, 4, '7CR 5050 Wooden Wall Shelf  (Number of Shelves - 1, Brown)', '7cr-5050-wooden-wall-shelf-number-of-shelves-1-brown', 'Brand- 7CR (7CR brand aims to make people’s lives easy to easier.) Dimensions- (Inch-25X 10.2) Colour- Swiss Butter nut Material - 100% High Density HDF Wood Grain Finish Thickness- 8mm Model no- mult WB 5050 No. of hooks- 8 key hook Multi purpose uses- It has a unique feature for mobile charging and a small shelf for hold a visiting cards.', '<h3>In The Box</h3>\r\n\r\n<table border=\"\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Sales Package</td>\r\n   <td>\r\n   <ul>\r\n    <li>1 wall shelf</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Pack of</td>\r\n   <td>\r\n   <ul>\r\n    <li>1</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>General</h3>\r\n\r\n<table border=\"\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Brand</td>\r\n   <td>\r\n   <ul>\r\n    <li>7CR</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Model Number</td>\r\n   <td>\r\n   <ul>\r\n    <li>mult WB 5050</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Model Name</td>\r\n   <td>\r\n   <ul>\r\n    <li>5050</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Color</td>\r\n   <td>\r\n   <ul>\r\n    <li>Brown</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Material</td>\r\n   <td>\r\n   <ul>\r\n    <li>Wooden</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Suitable For</td>\r\n   <td>\r\n   <ul>\r\n    <li>Living Room & Bedroom</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Body & Design Features</h3>\r\n\r\n<table border=\"\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Number of Shelves</td>\r\n   <td>\r\n   <ul>\r\n    <li>1</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Mount Mechanism</td>\r\n   <td>\r\n   <ul>\r\n    <li>Screws</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Additional Features</h3>\r\n\r\n<table border=\"\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Rust Proof</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Other Features</td>\r\n   <td>\r\n   <ul>\r\n    <li>mobile charging and a small shelf for hold a visiting cards.</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Dimensions</h3>\r\n\r\n<table border=\"\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Width</td>\r\n   <td>\r\n   <ul>\r\n    <li>25 cm</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Height</td>\r\n   <td>\r\n   <ul>\r\n    <li>10.2 cm</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Other Dimensions</td>\r\n   <td>\r\n   <ul>\r\n    <li>25X10.2</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n', '01012020042657_12871.jpg', '01012020042657_128711.jpg', '', 5.82, 4.75, 0.25, 5, '', 'Brown/A3836A', '', 0, 5, 0, '0', 0, 0, 0, 0, '0', 0, '1577876217', '', '', '', 1),
(28, 1, 8, 6, 0, 'Realme 5 Pro (Sparkling Blue, 64 GB)  (4 GB RAM)', 'realme-5-pro-sparkling-blue-64-gb-4-gb-ram', 'Right from texting your buddies to clicking incredible pictures - the Realme 5 Pro lets you do more of what you love. Powered by a 10 nm octa-core Qualcomm Snapdragon 712 AIE processor, this phone lets you multitask seamlessly. Thanks to the 48 MP AI Quad Camera, you can capture beautiful scenic views on film. Watch everything on its 16 cm (6.3) FHD+ Mini-drop display come to life.', '<h3>General</h3>\r\n\r\n<table border=\"\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>In The Box</td>\r\n   <td>\r\n   <ul>\r\n    <li>Handset, Adapter (5V/4A), Important Info Booklet with Warranty Card, Quick Guide, SIM Card Tool, Screen Protect Film, Case</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Model Number</td>\r\n   <td>\r\n   <ul>\r\n    <li>RMX1971</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Model Name</td>\r\n   <td>\r\n   <ul>\r\n    <li>5 Pro</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Color</td>\r\n   <td>\r\n   <ul>\r\n    <li>Sparkling Blue</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Browse Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>Smartphones</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>SIM Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>Dual Sim</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Hybrid Sim Slot</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Touchscreen</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>OTG Compatible</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Sound Enhancements</td>\r\n   <td>\r\n   <ul>\r\n    <li>Double Mic Noise Suppression, Speaker - Bottom Right, Super Linear Speaker, Real Original Sound Technology</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n', '01012020060018_88421.jpg', '01012020060018_884211.jpg', '', 133, 133, 0, 0, '', 'Sparkling Blue/0B39D0', '', 0, 2, 0, '0', 0, 0, 0, 0, '0', 0, '1577881818', '', '', '', 1),
(30, 2, 3, 14, 0, 'Skinny Men Blue Jeans', 'skinny-men-blue-jeans', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', '<p><strong>Style Code: </strong>FMJN8371</p>\r\n\r\n<p><strong>Ideal For: </strong>Men</p>\r\n\r\n<p><strong>Suitable For: </strong>Western Wear</p>\r\n\r\n<p><strong>Pack Of: </strong>1</p>\r\n\r\n<p><strong>Reversible:</strong> No</p>\r\n\r\n<p><strong>Fabric: </strong>Pure Cotton</p>\r\n\r\n<p><strong>Faded: </strong>Heavy Fade</p>\r\n\r\n<p><strong>Rise: </strong>Mid Rise</p>\r\n\r\n<p><strong>Distressed: </strong>High Distress</p>\r\n\r\n<p><strong>Color: </strong>Blue</p>\r\n', '09012020041516_67337.jpg', '09012020041516_673371.jpg', '', 40.6, 40.6, 0, 0, '31', 'Blue/2497FF', 'XS, S, M, L, XL,  XXL', 0, 3, 0, '0', 0, 0, 0, 0, '0', 0, '1578566717', '', '', '', 1),
(31, 2, 3, 14, 0, 'Skinny Men Black Jeans', 'skinny-men-black-jeans', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', '<p><strong>Style Code: </strong>FMJN8371</p>\r\n\r\n<p><strong>Ideal For: </strong>Men</p>\r\n\r\n<p><strong>Suitable For: </strong>Western Wear</p>\r\n\r\n<p><strong>Pack Of: </strong>1</p>\r\n\r\n<p><strong>Reversible:</strong> No</p>\r\n\r\n<p><strong>Fabric: </strong>Pure Cotton</p>\r\n\r\n<p><strong>Faded: </strong>Heavy Fade</p>\r\n\r\n<p><strong>Rise: </strong>Mid Rise</p>\r\n\r\n<p><strong>Distressed: </strong>High Distress</p>\r\n\r\n<p><strong>Color: </strong>Black</p>\r\n', '09012020042505_19858.jpg', '09012020042505_198581.jpg', '', 40.6, 40.6, 0, 0, '30', 'Black/000000', 'XS, S, M, L, XL,  XXL', 0, 3, 0, '0', 0, 0, 0, 0, '0', 0, '1578567305', '', '', '', 1),
(32, 2, 3, 14, 0, 'Boyfriend Women Black Jeans', 'boyfriend-women-black-jeans', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', '<p><strong>Style Code: </strong>FWFLJN57</p>\r\n\r\n<p><strong>Ideal For: </strong>Women</p>\r\n\r\n<p><strong>Suitable For: </strong>Western Wear</p>\r\n\r\n<p><strong>Pack Of: </strong>1</p>\r\n\r\n<p><strong>Reversible:</strong> No</p>\r\n\r\n<p><strong>Fabric: </strong>Pure Cotton</p>\r\n\r\n<p><strong>Faded: </strong>Heavy Fade</p>\r\n\r\n<p><strong>Rise: </strong>Mid Rise</p>\r\n\r\n<p><strong>Distressed: </strong>High Distress</p>\r\n\r\n<p><strong>Color: </strong>Black</p>\r\n', '09012020043156_59802.jpg', '09012020043156_598021.jpg', '', 14.61, 14.61, 0, 0, '', 'Black/000000', 'XS, S, M, L, XL,  XXL', 0, 3, 0, '0', 0, 0, 0, 0, '0', 0, '1578567716', '', '', '', 1),
(33, 2, 2, 15, 0, 'Men Checkered Casual Spread Shirt', 'men-checkered-casual-spread-shirt', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '<p><strong>Pack of: </strong>1</p>\r\n\r\n<p><strong>Style Code: </strong>USSHV0066</p>\r\n\r\n<p><strong>Closure: </strong>Button</p>\r\n\r\n<p><strong>Fit: </strong>Regular</p>\r\n\r\n<p><strong>Fabric: </strong>Pure Cotton</p>\r\n\r\n<p><strong>Sleeve: </strong>Full Sleeve</p>\r\n\r\n<p><strong>Pattern: </strong>Checkered</p>\r\n\r\n<p><strong>Reversible: </strong>No</p>\r\n\r\n<p><strong>Collar: </strong>Spread</p>\r\n\r\n<p><strong>Color:</strong> Blue</p>\r\n\r\n<p><strong>Fabric Care: </strong>Dry in shade, Do not tumble dry, Do not bleach, Gentle Machine Wash</p>\r\n\r\n<p><strong>Suitable For:</strong> Western Wear</p>\r\n\r\n<p><strong>Hem: </strong>Asymmetric</p>\r\n\r\n<p><strong>Pockets: </strong>1 Patch Pocket at Front</p>\r\n', '09012020043932_86109.jpg', '09012020043932_861091.jpg', '', 14.69, 14.69, 0, 0, '', 'Blue/26B5FF', 'S, M, L, XL, XXL', 0, 3, 0, '0', 0, 0, 0, 0, '0', 0, '1578568172', '', '', '', 1),
(34, 2, 2, 16, 1, 'Men Solid Casual Spread Shirt', 'men-solid-casual-spread-shirt', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '<p><strong>Pack of: </strong>1</p>\r\n\r\n<p><strong>Style Code: </strong>GOB-00042</p>\r\n\r\n<p><strong>Fit: </strong>Slim</p>\r\n\r\n<p><strong>Fabric: </strong>Pure Cotton</p>\r\n\r\n<p><strong>Sleeve: </strong>Full Sleeve</p>\r\n\r\n<p><strong>Pattern: </strong>Solid</p>\r\n\r\n<p><strong>Reversible: </strong>No</p>\r\n\r\n<p><strong>Collar: </strong>Spread</p>\r\n', '09012020051411_41796.jpg', '09012020051411_417961.jpg', '', 13.99, 7, 6.99, 50, '35', 'Maroon/6A0D11', 'XS, S, M, L, XL,  XXL', 0, 5, 2, '0', 0, 0, 0, 0, '0', 0, '1578570251', '', '', '', 1),
(35, 2, 2, 16, 1, 'Men Solid Casual Spread Shirt In Black', 'men-solid-casual-spread-shirt-in-black', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '<p><strong>Pack of: </strong>1</p>\r\n\r\n<p><strong>Style Code: </strong>GOB-00039</p>\r\n\r\n<p><strong>Fit: </strong>Slim</p>\r\n\r\n<p><strong>Fabric: </strong>Pure Cotton</p>\r\n\r\n<p><strong>Sleeve: </strong>Full Sleeve</p>\r\n\r\n<p><strong>Pattern: </strong>Solid</p>\r\n\r\n<p><strong>Reversible: </strong>No</p>\r\n\r\n<p><strong>Collar: </strong>Spread</p>\r\n\r\n<p><strong>Color:</strong> Black</p>\r\n\r\n<p><strong>Fabric Care: </strong>Regular Machine Wash</p>\r\n\r\n<p><strong>Suitable For: </strong>Western Wear</p>\r\n\r\n<p><strong>Other Details: </strong>Model is Wearing \"M-Size\" Shirt</p>\r\n', '10012020095305_7281.jpg', '10012020095305_72811.jpg', '', 13.99, 7, 6.99, 50, '', 'Black/000000', 'XS, S, M, L, XL,  XXL', 0, 5, 2, '0', 0, 0, 0, 0, '0', 0, '1578630185', '', '', '', 1),
(36, 2, 2, 16, 1, 'Men Solid Casual Spread Shirt In Sky Blue', 'men-solid-casual-spread-shirt-in-sky-blue', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '<p><strong>Pack of: </strong>1</p>\r\n\r\n<p><strong>Style Code: </strong>GOB-00039</p>\r\n\r\n<p><strong>Fit: </strong>Slim</p>\r\n\r\n<p><strong>Fabric: </strong>Pure Cotton</p>\r\n\r\n<p><strong>Sleeve: </strong>Full Sleeve</p>\r\n\r\n<p><strong>Pattern: </strong>Solid</p>\r\n\r\n<p><strong>Reversible: </strong>No</p>\r\n\r\n<p><strong>Collar: </strong>Spread</p>\r\n\r\n<p><strong>Color:</strong> Black</p>\r\n\r\n<p><strong>Fabric Care: </strong>Regular Machine Wash</p>\r\n\r\n<p><strong>Suitable For: </strong>Western Wear</p>\r\n\r\n<p><strong>Other Details: </strong>Model is Wearing \"M-Size\" Shirt</p>\r\n', '10012020095647_23026.jpg', '10012020095647_230261.jpg', '', 13.99, 7, 6.99, 50, '34,35', 'Sky Blue/78CFEA', 'XS, S, M, L, XL,  XXL', 0, 5, 2, '0', 0, 0, 0, 0, '0', 0, '1578630407', '', '', '', 1),
(37, 2, 2, 0, 0, 'Men Checkered Casual Button Down Shirt', 'men-checkered-casual-button-down-shirt', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '<p><strong>Pack of: </strong>1</p>\r\n\r\n<p><strong>Style Code: </strong>AF-MN-INB-TBF-CTTN-CHK</p>\r\n\r\n<p><strong>Closure: </strong>Button</p>\r\n\r\n<p><strong>Fit: </strong>Slim</p>\r\n\r\n<p><strong>Fabric: </strong>Cotton Blend</p>\r\n\r\n<p><strong>Sleeve: </strong>Full Sleeve</p>\r\n\r\n<p><strong>Pattern: </strong>Checkered</p>\r\n\r\n<p><strong>Reversible: </strong>No</p>\r\n\r\n<p><strong>Collar: </strong>Button Down</p>\r\n\r\n<p><strong>Color: </strong>Dark Blue</p>\r\n\r\n<p><strong>Fabric Care: </strong>Regular Machine Wash</p>\r\n\r\n<p><strong>Suitable For: </strong>Western Wear</p>\r\n\r\n<p><strong>Hem: </strong>Curved</p>\r\n', '10012020100844_41250.jpg', '10012020100844_412501.jpg', '', 14.07, 14.07, 0, 0, '', 'Dark Blue/213F5C', 'XS, S, M, L, XL,  XXL', 0, 5, 2, '0', 0, 0, 0, 0, '0', 0, '1578631124', '', '', '', 1),
(38, 2, 3, 14, 1, 'Slim Men Blue Jeans', 'slim-men-blue-jeans', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', '<p><strong>Style Code: </strong>FMJNO0825</p>\r\n\r\n<p><strong>Ideal For: </strong>Men</p>\r\n\r\n<p><strong>Suitable For: </strong>Western Wear</p>\r\n\r\n<p><strong>Pack Of: </strong>1</p>\r\n\r\n<p><strong>Pocket Type: </strong>Patch Pocket, Coin Pocket, Curved Pocket</p>\r\n\r\n<p><strong>Pattern: </strong>Solid</p>\r\n\r\n<p><strong>Reversible: </strong>No</p>\r\n\r\n<p><strong>Closure: </strong>Button</p>\r\n\r\n<p><strong>Fabric: </strong>Cotton Blend</p>\r\n\r\n<p><strong>Faded: </strong>Light Fade</p>\r\n\r\n<p><strong>Rise: </strong>Mid Rise</p>\r\n\r\n<p><strong>Distressed: </strong>Clean Look</p>\r\n\r\n<p><strong>Color: </strong>Blue</p>\r\n\r\n<p><strong>Fly: </strong>Zipper</p>\r\n\r\n<p><strong>Secondary Color: </strong>Blue</p>\r\n\r\n<p><strong>Fabric Care: </strong>Do not Wring||Do not Dry Clean||Dry in Shade</p>\r\n', '10012020101913_5142.jpg', '10012020101913_51421.jpg', '23012020015528_71178_3_.jpg', 26.72, 13.36, 13.36, 50, '', 'Blue/3E5578', 'XS, S, M, L, XL,  XXL', 0, 5, 0, '0', 0, 0, 0, 0, '0', 0, '1578631753', '', '', '', 0);
INSERT INTO `tbl_product` (`id`, `category_id`, `sub_category_id`, `brand_id`, `offer_id`, `product_title`, `product_slug`, `product_desc`, `product_features`, `featured_image`, `featured_image2`, `size_chart`, `product_mrp`, `selling_price`, `you_save_amt`, `you_save_per`, `other_color_product`, `color`, `product_size`, `product_quantity`, `max_unit_buy`, `delivery_charge`, `total_views`, `total_rate`, `rate_avg`, `is_featured`, `today_deal`, `today_deal_date`, `total_sale`, `created_at`, `seo_title`, `seo_meta_description`, `seo_keywords`, `status`) VALUES
(39, 1, 21, 1, 0, 'Mi LED Smart TV 4A PRO 80 cm (32) with Android', 'mi-led-smart-tv-4a-pro-80-cm-32-with-android', 'Bring home the Mi LED Smart TV 4A PRO and transform your movie-watching experience. This LED TV comes with an 80-cm (32) Ultra-bright HD-Ready Display, a 64-bit quad-core processor, and stereo speakers which provide a cinematic experience right in the comfort of your home. Also, with features such as PatchWall and Google Assistant, your TV-watching experience is made even more convenient.', '<h3>General</h3>\r\n\r\n<table border=\\>\r\n <tbody>\r\n  <tr>\r\n   <td>In The Box</td>\r\n   <td>\r\n   <ul>\r\n    <li>LED TV 1U, Manual 1U, Screws 4U, Remote Control 1U, Stand 1U</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Model Name</td>\r\n   <td>\r\n   <ul>\r\n    <li>L32M5-AL</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Color</td>\r\n   <td>\r\n   <ul>\r\n    <li>Black</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Display Size</td>\r\n   <td>\r\n   <ul>\r\n    <li>80 cm (32)</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Screen Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>LED</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>HD Technology & Resolution</td>\r\n   <td>\r\n   <ul>\r\n    <li>HD Ready, 1366 x 768</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>3D</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Smart TV</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Curve TV</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Series</td>\r\n   <td>\r\n   <ul>\r\n    <li>4A PRO</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Touchscreen</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Motion Sensor</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>HDMI</td>\r\n   <td>\r\n   <ul>\r\n    <li>3</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>USB</td>\r\n   <td>\r\n   <ul>\r\n    <li>2</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Wi-Fi Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>802.11 b/g/n</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Built In Wi-Fi</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Launch Year</td>\r\n   <td>\r\n   <ul>\r\n    <li>2019</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Internet Features</h3>\r\n\r\n<table border=\\>\r\n <tbody>\r\n  <tr>\r\n   <td>Built In Wi-Fi</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>3G Dongle Plug and Play</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Ethernet (RJ45)</td>\r\n   <td>\r\n   <ul>\r\n    <li>1</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Other Internet Features</td>\r\n   <td>\r\n   <ul>\r\n    <li>Android Oreo 8.1, Google Play Store, Chromecast Built-in, Play Movies, Google Assistant, File Manager, Media Player, TV Manager, TV Guide App, LIVE TV App, VP9 Profile 2, H.265, H264, 14 Content Partners</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Connectivity Features</h3>\r\n\r\n<table border=\\>\r\n <tbody>\r\n  <tr>\r\n   <td>HDMI</td>\r\n   <td>\r\n   <ul>\r\n    <li>3 Side</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>USB</td>\r\n   <td>\r\n   <ul>\r\n    <li>2 x Side</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Component In (RGB Cable)</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Composite In (Audio Video Cable)</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>NFC Support</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Headphone Jack</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Analog Audio Input</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Video Features</h3>\r\n\r\n<table border=\\>\r\n <tbody>\r\n  <tr>\r\n   <td>Picture Engine</td>\r\n   <td>\r\n   <ul>\r\n    <li>Amlogic 7th Generation Imaging Engine</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Analog TV Reception</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Digital TV Reception</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>View Angle</td>\r\n   <td>\r\n   <ul>\r\n    <li>178 degree</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Digital Noise Filter</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>LED Display Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>Direct LED</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Aspect Ratio</td>\r\n   <td>\r\n   <ul>\r\n    <li>16:09</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Refresh Rate</td>\r\n   <td>\r\n   <ul>\r\n    <li>60 Hz</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Supported Video Formats</td>\r\n   <td>\r\n   <ul>\r\n    <li>H.265, H.264, Real, MPEG 1/2/4</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Other Video Features</td>\r\n   <td>\r\n   <ul>\r\n    <li>Dyanamic Noise reduction, Color Temperature Control, 5 Picture Mode (Standard, Movie, Vivid, Sport, Custom)</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Smart Tv Features</h3>\r\n\r\n<table border=\\>\r\n <tbody>\r\n  <tr>\r\n   <td>Number of Cores</td>\r\n   <td>\r\n   <ul>\r\n    <li>4</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Processor</td>\r\n   <td>\r\n   <ul>\r\n    <li>Amlogic 64-bit Quad-core</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Graphic Processor</td>\r\n   <td>\r\n   <ul>\r\n    <li>Mali-450 MP3</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Ram Capacity</td>\r\n   <td>\r\n   <ul>\r\n    <li>1 GB</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Storage Memory</td>\r\n   <td>\r\n   <ul>\r\n    <li>8 GB</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Supported App - Netflix</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Supported App - Youtube</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Supported App - Hotstar</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Supported App - Prime Video</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Supported Mobile Operating System</td>\r\n   <td>\r\n   <ul>\r\n    <li>Android</li>\r\n    <li>iOS</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Operating System Present</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Operating System</td>\r\n   <td>\r\n   <ul>\r\n    <li>Android</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Screen Mirroring</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>App Store Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>Play Store</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Content Providers</td>\r\n   <td>\r\n   <ul>\r\n    <li>Hotstar, Voot, Sony Liv, Sun NXT, Zee5, Hungama Play, ALT Balaji, VIU, Play Store</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Content Languages</td>\r\n   <td>\r\n   <ul>\r\n    <li>Marathi, Gujarati, Sinhala, Kannada, Tamil, Rajasthani, Hindi, English, Punjabi, Telugu, Bengali, Urdu, Malayalam, Bhojpuri, Oriya</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>System Languages</td>\r\n   <td>\r\n   <ul>\r\n    <li>Assamese, Marathi, Gujarati, Kannada, Tamil, English, Hindi, Punjabi, Bengali, Telugu, Urdu, Malayalam, Oriya</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Audio Features</h3>\r\n\r\n<table border=\\>\r\n <tbody>\r\n  <tr>\r\n   <td>Number of Speakers</td>\r\n   <td>\r\n   <ul>\r\n    <li>2</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Speaker Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>Stereo</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Sound Technology</td>\r\n   <td>\r\n   <ul>\r\n    <li>DTS-HD</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Surround Sound</td>\r\n   <td>\r\n   <ul>\r\n    <li>Stereo Sound</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Speaker Output RMS</td>\r\n   <td>\r\n   <ul>\r\n    <li>20 W</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Sound Mode</td>\r\n   <td>\r\n   <ul>\r\n    <li>Standard, News, Movie, Game, Custom</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Supported Audio Formats</td>\r\n   <td>\r\n   <ul>\r\n    <li>Stereo DTS</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Other Audio Features</td>\r\n   <td>\r\n   <ul>\r\n    <li>5 Equalizer - Standard, News, Movie, Game, Custom, 5 Band Equilizer</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Convenience Features</h3>\r\n\r\n<table border=\\>\r\n <tbody>\r\n  <tr>\r\n   <td>Other Convenience Features</td>\r\n   <td>\r\n   <ul>\r\n    <li>3.5mm Jack, Bluetooth Version - 4.2, Ultra Bright HD Display, Google Voice Button in Remote, Technical Superiority with VP9-10 Codec for 4K Videos</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Power Features</h3>\r\n\r\n<table border=\\>\r\n <tbody>\r\n  <tr>\r\n   <td>Power Requirement</td>\r\n   <td>\r\n   <ul>\r\n    <li>AC 100 - 240 V, 50/60 Hz</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Power Consumption</td>\r\n   <td>\r\n   <ul>\r\n    <li>50 W, 0.5 W (Standby)</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Remote Control Features</h3>\r\n\r\n<table border=\\>\r\n <tbody>\r\n  <tr>\r\n   <td>Touch Remote</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Smart Remote</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>RF Capable</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>IR Capable</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Internet Access</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Other Remote Control Features</td>\r\n   <td>\r\n   <ul>\r\n    <li>Voice search with Google Assistant</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Additional Features</h3>\r\n\r\n<table border=\\>\r\n <tbody>\r\n  <tr>\r\n   <td>\r\n   <ul>\r\n    <li>Thin Bezels, 12 Button Bluetooth Remote, With Remote - Control TV, Set-top Box, Smart Home Device, Infinite Scrolling, Patchwall, 802.11 b/g/n (2.4 GHz), Universal Search, Cable TV Integration</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Dimensions</h3>\r\n\r\n<table border=\\>\r\n <tbody>\r\n  <tr>\r\n   <td>Width x Height x Depth (without stand)</td>\r\n   <td>\r\n   <ul>\r\n    <li>733 mm x 435 mm x 80 mm</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Weight (without stand)</td>\r\n   <td>\r\n   <ul>\r\n    <li>3.855 kg</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Width x Height x Depth (with stand)</td>\r\n   <td>\r\n   <ul>\r\n    <li>733 mm x 479 mm x 180 mm</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Weight (with stand)</td>\r\n   <td>\r\n   <ul>\r\n    <li>3.9 kg</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Stand Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>Table Top</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Warranty</h3>\r\n\r\n<table border=\\>\r\n <tbody>\r\n  <tr>\r\n   <td>Warranty Summary</td>\r\n   <td>\r\n   <ul>\r\n    <li>1 Year Warranty on Product and Additional 1 Year Warranty on Panel</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Covered in Warranty</td>\r\n   <td>\r\n   <ul>\r\n    <li>Defect Arising Out of Faulty or Defective Material or Workmanship. Parts and Labour Costs are Covered</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Not Covered in Warranty</td>\r\n   <td>\r\n   <ul>\r\n    <li>Physical Damages after Usage, Scratches on Panel</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Warranty Service Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>On-site</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Installation & Demo</h3>\r\n\r\n<table border=\\>\r\n <tbody>\r\n  <tr>\r\n   <td>Installation & Demo Details</td>\r\n   <td>\r\n   <ul>\r\n    <li>Please note that any unauthorized handling or self-installation of the product will lead to return & product warranty being void</li>\r\n    <li>Installation will be free of cost only if done within 15 days of delivery</li>\r\n    <li>Flipkart will facilitate Installation & Demo at time of your convenience from an brand authorized service engineer</li>\r\n    <li>Customer will have to pay Rs 500 (Applicable Tax Extra) if the installation is requested post 15 days of delivery</li>\r\n    <li>The authorized service engineer will be providing detailed demo that includes</li>\r\n    <li>The service engineer will install your new TV, either on wall mount or on table top. The wall mount is not provided free of cost and is chargeable to the customer. The cost of wall mount is Rs. 399 (inclusive of applicable taxes) and will be available with service engineer for purchase</li>\r\n    <li>a. Physical check of all ports, including power and USB ports. b. Checking also of accessories c. Understanding your new TV&#39;s features with complete demonstration of features and settings d. Quick run-through on how to operate the TV e. Preventive maintenance action to be taken</li>\r\n    <li>Flipkart will communicate the day and time slot of the scheduled Installation & Demo through a SMS</li>\r\n    <li>The Installation & First Demo service will be provided free of cost. All additional accessories not part of the the package will be charged separately</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n', '10012020104042_23146.jpg', '10012020104042_231461.jpg', '', 175.84, 175.84, 0, 0, '', 'Black/000000', '', 0, 2, 0, '0', 0, 0, 0, 0, '0', 0, '1578633042', '', '', '', 1),
(40, 1, 7, 9, 5, 'Lcs-8181 Black Dial Day & Date Functioning Watch Analog Watch - For Men', 'lcs-8181-black-dial-day-date-functioning-watch-analog-watch-for-men', 'Day & date & time, day & date functioning, day & date, date display, black dial day & date functioning, black dial day & date functioning watch, black dial day & date functioning watch for men, black dial day & date functioning watch for boys, silicone pvc strap, day & date & calendar, silicone pvc, watches for men, watches for boys, mens watches, new design, new attractive, new arrival watches, unique watches', '<p><strong>Water resistant: </strong>No</p>\r\n\r\n<p><strong>Display type: </strong>Analog</p>\r\n\r\n<p><strong>Style code: </strong>Lcs-8181</p>\r\n\r\n<p><strong>Series: </strong>Black dial day & date functioning watch</p>\r\n\r\n<p><strong>Occasion: </strong>Casual, party-wedding, formal, sports</p>\r\n\r\n<p><strong>Watch type: </strong>Wrist watch</p>\r\n\r\n<p><strong>Pack of:</strong>1</p>\r\n\r\n<p><strong>Sales package: </strong>1 watch</p>\r\n\r\n<p><strong>Shock resistance: </strong>No</p>\r\n\r\n<p><strong>Scratch resistant: </strong>No</p>\r\n\r\n<p><strong>Mechanism: </strong>Quartz</p>\r\n\r\n<p><strong>Model name: </strong>Lcs-8181</p>\r\n\r\n<p><strong>Strap material:</strong>Silicone pvc strap</p>\r\n\r\n<p><strong>World time: </strong>No</p>\r\n\r\n<p><strong>Dual time: </strong>No</p>\r\n\r\n<p><strong>Strap type: </strong>Belt</p>\r\n\r\n<p><strong>Strap design: </strong>New design</p>\r\n\r\n<p><strong>Case/bezel material: </strong>Stainless steel</p>\r\n', '10012020111416_17139.jpg', '10012020111416_171391.jpg', '', 3.5, 2.4, 0.6, 20, '', 'Black/000000', '', 0, 5, 0, '0', 0, 0, 0, 0, '0', 0, '1578635056', '', '', '', 1),
(41, 1, 21, 7, 0, 'Sony Bravia R202F 80cm (32 inch) HD Ready LED TV  (KLV-32R202F)', 'sony-bravia-r202f-80cm-32-inch-hd-ready-led-tv-klv-32r202f', 'After a tiring day, unwind by enjoying your favourite action flicks and romcoms on this Sony TV. Watch visuals come to life on its 80 cm display. You can use the Photoframe mode to watch your cherished pictures on the big screen.\r\n\r\nSplendid Detail, Fine Texture\r\nEnjoy exquisite rock formations and natural textures in stunning clarity. This TV reduces image noise and improves contrast for added depth, detail and realism.\r\n\r\nThe Bigger, The Better\r\nSet your TV on Photoframe mode and watch a rotating gallery of your favourite photos on the big screen.\r\n\r\nPlayback Via USB\r\nUse the USB stick to play music, watch video clips and view photos on the big screen.\r\n\r\nStay Entertained\r\nTune into your favourite FM channel and enjoy the latest numbers.\r\n\r\nFeel at Home\r\nChoose from a wide variety of multi-Indian regional languages from BRAVIA\'s new on-screen interface. You just have to choose the preferred language and the TV will communicate in the same language.', '<h3>General</h3>\r\n\r\n<table border=\\>\r\n <tbody>\r\n  <tr>\r\n   <td>In The Box</td>\r\n   <td>\r\n   <ul>\r\n    <li>Remote Control(1 U)</li>\r\n    <li>1 U (Unit) [Including - Warranty Card (1 U)</li>\r\n    <li>AC Adapter(1 U)</li>\r\n    <li>Batteries(2 U)</li>\r\n    <li>AC Power Cord(1 U)</li>\r\n    <li>Instruction Manual(1 U)]</li>\r\n    <li>Table-Top Stand(1 U)</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Model Name</td>\r\n   <td>\r\n   <ul>\r\n    <li>KLV-32R202F</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Display Size</td>\r\n   <td>\r\n   <ul>\r\n    <li>80 cm (32)</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Screen Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>LED</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>HD Technology & Resolution</td>\r\n   <td>\r\n   <ul>\r\n    <li>HD Ready, 1366 x 768</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>3D</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Smart TV</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Curve TV</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Series</td>\r\n   <td>\r\n   <ul>\r\n    <li>Bravia R202F</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Touchscreen</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Motion Sensor</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>HDMI</td>\r\n   <td>\r\n   <ul>\r\n    <li>2</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>USB</td>\r\n   <td>\r\n   <ul>\r\n    <li>1</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Built In Wi-Fi</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Launch Year</td>\r\n   <td>\r\n   <ul>\r\n    <li>2018</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Internet Features</h3>\r\n\r\n<table border=\\>\r\n <tbody>\r\n  <tr>\r\n   <td>Built In Wi-Fi</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>3G Dongle Plug and Play</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Connectivity Features</h3>\r\n\r\n<table border=\\>\r\n <tbody>\r\n  <tr>\r\n   <td>HDMI</td>\r\n   <td>\r\n   <ul>\r\n    <li>2 Side</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>USB</td>\r\n   <td>\r\n   <ul>\r\n    <li>1 Side</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Video Features</h3>\r\n\r\n<table border=\\>\r\n <tbody>\r\n  <tr>\r\n   <td>LED Display Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>Direct LED</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Refresh Rate</td>\r\n   <td>\r\n   <ul>\r\n    <li>50 Hz</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Smart Tv Features</h3>\r\n\r\n<table border=\\>\r\n <tbody>\r\n  <tr>\r\n   <td>Supported App - Netflix</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Supported App - Youtube</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Supported App - Hotstar</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Audio Features</h3>\r\n\r\n<table border=\\>\r\n <tbody>\r\n  <tr>\r\n   <td>Number of Speakers</td>\r\n   <td>\r\n   <ul>\r\n    <li>2</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Speaker Output RMS</td>\r\n   <td>\r\n   <ul>\r\n    <li>20 W</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Power Features</h3>\r\n\r\n<table border=\\>\r\n <tbody>\r\n  <tr>\r\n   <td>Power Requirement</td>\r\n   <td>\r\n   <ul>\r\n    <li>AC 110 - 240 V, 50/60 Hz</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Power Consumption</td>\r\n   <td>\r\n   <ul>\r\n    <li>47 W, 0.5 W (Standby)</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Remote Control Features</h3>\r\n\r\n<table border=\\>\r\n <tbody>\r\n  <tr>\r\n   <td>Touch Remote</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Dimensions</h3>\r\n\r\n<table border=\\>\r\n <tbody>\r\n  <tr>\r\n   <td>Width x Height x Depth (without stand)</td>\r\n   <td>\r\n   <ul>\r\n    <li>729.28 mm x 73 mm</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Warranty</h3>\r\n\r\n<table border=\\>\r\n <tbody>\r\n  <tr>\r\n   <td>Warranty Summary</td>\r\n   <td>\r\n   <ul>\r\n    <li>1 Year Manufacturer Warranty</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Covered in Warranty</td>\r\n   <td>\r\n   <ul>\r\n    <li>Warranty of the Product is Limited to Manufacturing Defects Only</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Not Covered in Warranty</td>\r\n   <td>\r\n   <ul>\r\n    <li>Warranty Does Not Cover Any External Accessories (Such as Battery, Cable, Carrying Bag), Damage Caused to the Product Due to Improper Installation by Customer, Normal Wear and Tear to Magnetic Heads, Audio, Video, Laser Pick-ups and TV Picture Tubes, Panel, Damages Caused to the Product by Accident, Lightening, Ingress of Water, Fire, Dropping or Excessive Shock, Any Damage Caused Due to Tampering of the Product by an Unauthorized Agent, Liability for Loss of Data, Recorded Images or Business Opportunity Loss.</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Warranty Service Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>Offsite Service</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Installation & Demo</h3>\r\n\r\n<table border=\\>\r\n <tbody>\r\n  <tr>\r\n   <td>Installation & Demo Details</td>\r\n   <td>\r\n   <ul>\r\n    <li>We&#39;ll facilitate the installation and demo through authorized service engineer at your convenience.. The service engineer will install your new TV, either on wall mount or on table top. Installation and demo are provided free of cost. The engineer will also help you understand your new TV&#39;s features. The process generally covers: Wall-mounted or table-top installation, as requested. Physical check of all ports, including power and USB ports. Accessories also checked. Demonstration of features and settings. Quick run-through on how to operate the TV.</li>\r\n    <li>Please note that any unauthorized handling or self-installation of the product will lead to return & product warranty being void</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n', '10012020112559_28160.jpg', '10012020112559_281601.jpg', '', 239.15, 239.15, 0, 0, '', 'Black/000000', '', 0, 2, 0, '0', 0, 0, 0, 0, '0', 0, '1578635759', '', '', '', 1);
INSERT INTO `tbl_product` (`id`, `category_id`, `sub_category_id`, `brand_id`, `offer_id`, `product_title`, `product_slug`, `product_desc`, `product_features`, `featured_image`, `featured_image2`, `size_chart`, `product_mrp`, `selling_price`, `you_save_amt`, `you_save_per`, `other_color_product`, `color`, `product_size`, `product_quantity`, `max_unit_buy`, `delivery_charge`, `total_views`, `total_rate`, `rate_avg`, `is_featured`, `today_deal`, `today_deal_date`, `total_sale`, `created_at`, `seo_title`, `seo_meta_description`, `seo_keywords`, `status`) VALUES
(43, 1, 21, 1, 1, 'Mi LED Smart TV 4 Pro 138.8 cm', 'mi-led-smart-tv-4-pro-1388-cm', 'Take your TV-viewing experience to the next level with the Mi LED Smart TV 4. Thanks to its beautiful Frameless Display, you can have a fully immersive experience no matter what you are watching. The 4K+HDR and the Dolby+DTS technologies, along with the flagship performance and connectivity features this TV offers, make for a seamless experience.\r\n\r\nSlimness That Matters\r\nMake TV-watching an enjoyable experience on its 4.9 mm Ultra-thin profile.\r\n\r\nFrameless Display\r\nTake immersive viewing experience to the next level on this 138.8 cm (55) TV as it does not have any boundaries to limit your view.\r\n\r\nImage Technology\r\nThe 4K+HDR technology gives you clarity that is commendable and brightness that is balanced, so you can enjoy your favourite TV shows and movies with rich and crisp details.\r\n\r\nDolby+DTS:\r\nGet cinema-quality sounds right at your home, as this TV boasts Dolby Audio and DTS-HD.\r\n\r\nPerformance:\r\nIt is powered by a 64-bit quad-core processor, along with 2 GB of RAM, that makes switching between multiple apps a breeze. You can install multiple apps on this TV, as it comes with 8 GB of internal storage.\r\n\r\nConnectivity:\r\nIt comes with the dual-band Wi-Fi and Bluetooth 4.2 (Low Energy), so you can stream content from the Internet and smart devices seamlessly. In addition, you can connect multiple devices with the help of HDMI (ARC and Input), USB and AV Input ports.\r\n\r\nBuilt-in Chromecast:\r\nThis feature enables you to cast content from your smart devices on to the bigger screen of your TV.\r\n\r\nApplications:\r\nStream your favourite videos and TV shows from various apps, such as Voot, Hotstar, Hungama Play and much more.\r\n\r\nPatchWall with Android TV:\r\nOperate this TV easily as it comes with the PatchWall user interface (Android Oreo). It gives you the access to Google Play Store, so you can enjoy a host of amazing apps. Thanks to 14+ content partners, you can now enjoy 700,000+ hours of content using this TV.\r\n\r\nOne Remote:\r\nYou can seamlessly control content from the set-top box and Smart TV using just one remote, reducing the hassle of using multiple remotes. You can even control the TV with your phone.\r\n\r\nGoogle Voice Search:\r\nAvoid tiresome typing, or the endless scrolling through the navigation bar. You can easily find the content you\'re looking for by just asking, and Google Voice Search will find it for you. All you need to do is press the mic button on the remote and make use of the voice search feature.\r\n\r\nGoogle Assistant:\r\nThanks to this feature, you can now access your favourite content using just your voice - all you have to do is press the Google Assistant button on the remote control. What’s more is that you can also control your smart devices at home easily.', '<h3>General</h3>\r\n\r\n<table border=\"\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>In The Box</td>\r\n   <td>\r\n   <ul>\r\n    <li>Manual</li>\r\n    <li>1 LED TV</li>\r\n    <li>1 Smart Remote</li>\r\n    <li>Power cord</li>\r\n    <li>Stand</li>\r\n    <li>4 Screws</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Model Name</td>\r\n   <td>\r\n   <ul>\r\n    <li>L55M5-AN</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Color</td>\r\n   <td>\r\n   <ul>\r\n    <li>Grey</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Display Size</td>\r\n   <td>\r\n   <ul>\r\n    <li>138.8 cm (55)</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Screen Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>LED</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>HD Technology & Resolution</td>\r\n   <td>\r\n   <ul>\r\n    <li>Ultra HD (4K), 3840 x 2160</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>3D</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Smart TV</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Curve TV</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Series</td>\r\n   <td>\r\n   <ul>\r\n    <li>4 Pro</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Touchscreen</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Motion Sensor</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>HDMI</td>\r\n   <td>\r\n   <ul>\r\n    <li>3</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>USB</td>\r\n   <td>\r\n   <ul>\r\n    <li>2</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Built In Wi-Fi</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Launch Year</td>\r\n   <td>\r\n   <ul>\r\n    <li>2018</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Internet Features</h3>\r\n\r\n<table border=\"\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Built In Wi-Fi</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Mobile High-Definition Link</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>3G Dongle Plug and Play</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Ethernet (RJ45)</td>\r\n   <td>\r\n   <ul>\r\n    <li>1</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Other Internet Features</td>\r\n   <td>\r\n   <ul>\r\n    <li>Built In Chromecast</li>\r\n    <li>Google Play Music</li>\r\n    <li>Google Voice Search</li>\r\n    <li>Wifi: 2.4 GHz/5 GHz</li>\r\n    <li>Android Oreo</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Connectivity Features</h3>\r\n\r\n<table border=\"\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>HDMI</td>\r\n   <td>\r\n   <ul>\r\n    <li>3 Side</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>USB</td>\r\n   <td>\r\n   <ul>\r\n    <li>Left-hand Side</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Component In (RGB Cable)</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Composite In (Audio Video Cable)</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>NFC Support</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>PC Audio In</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>PC D-sub</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Headphone Jack</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Digital Audio Output</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>RF Connectivity Input</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Video Features</h3>\r\n\r\n<table border=\"\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Contrast Ratio</td>\r\n   <td>\r\n   <ul>\r\n    <li>6000:01:00 (Static)</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Digital TV Reception</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>View Angle</td>\r\n   <td>\r\n   <ul>\r\n    <li>178 Degree</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>LED Display Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>Edge LED</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Aspect Ratio</td>\r\n   <td>\r\n   <ul>\r\n    <li>16:09</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Refresh Rate</td>\r\n   <td>\r\n   <ul>\r\n    <li>60 Hz</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Supported Video Formats</td>\r\n   <td>\r\n   <ul>\r\n    <li>VP9, H265, H264, Real, MPEG1/2/4, WMV, VC-1, AVS</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Smart Tv Features</h3>\r\n\r\n<table border=\"\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Number of Cores</td>\r\n   <td>\r\n   <ul>\r\n    <li>4</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Processor</td>\r\n   <td>\r\n   <ul>\r\n    <li>Amlogic Quad Core</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Graphic Processor</td>\r\n   <td>\r\n   <ul>\r\n    <li>Penta core ARM Mali-450</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Ram Capacity</td>\r\n   <td>\r\n   <ul>\r\n    <li>2 GB</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Storage Memory</td>\r\n   <td>\r\n   <ul>\r\n    <li>8 GB</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Supported App - Netflix</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Supported App - Youtube</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Supported App - Hotstar</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Supported App - Prime Video</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Supported App - Others</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Supported Mobile Operating System</td>\r\n   <td>\r\n   <ul>\r\n    <li>Android</li>\r\n    <li>iOS</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Operating System Present</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Operating System</td>\r\n   <td>\r\n   <ul>\r\n    <li>Android</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Screen Mirroring</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>App Store Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>Google Play Store</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Content Providers</td>\r\n   <td>\r\n   <ul>\r\n    <li>Hotstar, Voot, Sony Liv, Sun Nxt, Zee5, Hungama Play, ALT Balaji, Viu, TVF Play, Flickstree</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Audio Features</h3>\r\n\r\n<table border=\"\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Number of Speakers</td>\r\n   <td>\r\n   <ul>\r\n    <li>2</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Speaker Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>Down Firing</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Sound Technology</td>\r\n   <td>\r\n   <ul>\r\n    <li>Dolby</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Surround Sound</td>\r\n   <td>\r\n   <ul>\r\n    <li>DTS</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Speaker Output RMS</td>\r\n   <td>\r\n   <ul>\r\n    <li>16 W</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Power Features</h3>\r\n\r\n<table border=\"\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Power Requirement</td>\r\n   <td>\r\n   <ul>\r\n    <li>AC 100 - 240 V, 50/60 Hz</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Power Consumption</td>\r\n   <td>\r\n   <ul>\r\n    <li>160 W, 0.5 W (Standby)</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Remote Control Features</h3>\r\n\r\n<table border=\"\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Touch Remote</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>RF Capable</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Internet Access</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Additional Features</h3>\r\n\r\n<table border=\"\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>\r\n   <ul>\r\n    <li>Patchwall with Android TV, Framelss Display, Oreo 8.1, Universal Search, Cable TV Integration, 64 bit Quad Core</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Dimensions</h3>\r\n\r\n<table border=\"\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Width x Height x Depth (without stand)</td>\r\n   <td>\r\n   <ul>\r\n    <li>1232.1 mm x 730.6 mm x 48 mm</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Width x Height x Depth (with stand)</td>\r\n   <td>\r\n   <ul>\r\n    <li>1232.1 mm x 791.7 mm x 216.5 mm</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Weight (with stand)</td>\r\n   <td>\r\n   <ul>\r\n    <li>17.2 kg</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Other Dimensions</td>\r\n   <td>\r\n   <ul>\r\n    <li>Minimum Depth: 4.9 mm</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Warranty</h3>\r\n\r\n<table border=\"\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Warranty Summary</td>\r\n   <td>\r\n   <ul>\r\n    <li>1 Year Warranty on Product + 1 Year Additional Warranty for Panel</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Covered in Warranty</td>\r\n   <td>\r\n   <ul>\r\n    <li>Warranty of the Product is Limited to Manufacturing Defects Only</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Not Covered in Warranty</td>\r\n   <td>\r\n   <ul>\r\n    <li>Warranty Does Not Cover Any External Accessories (Such as Battery, Cable, Carrying Bag), Damage Caused to the Product Due to Improper Installation by Customer, Normal Wear and Tear to Magnetic Heads, Audio, Video, Laser Pick-ups and TV Picture Tubes, Panel, Damages Caused to the Product by Accident, Lightening, Ingress of Water, Fire, Dropping or Excessive Shock, Any Damage Caused Due to Tampering of the Product by an Unauthorized Agent, Liability for Loss of Data, Recorded Images or Business Opportunity Loss.</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Warranty Service Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>On-site Technician Visit</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Installation & Demo</h3>\r\n\r\n<table border=\"\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Installation & Demo Details</td>\r\n   <td>\r\n   <ul>\r\n    <li>Customer will have to pay Rs 600 (Applicable Tax Extra) if the installation is requested post 15 days of delivery</li>\r\n    <li>Please note that any unauthorized handling or self-installation of the product will lead to return & product warranty being void</li>\r\n    <li>The service engineer will install your new TV, either on wall mount or on table top. The wall mount is not provided free of cost and is chargeable to the customer. The cost of wall mount is Rs. 499 (inclusive of applicable taxes) and will be available with service engineer for purchase</li>\r\n    <li>Installation will be free of cost only if done within 15 days of delivery</li>\r\n    <li>Flipkart will facilitate Installation & Demo at time of your convenience from an brand authorized service engineer</li>\r\n    <li>The authorized service engineer will be providing detailed demo that includes</li>\r\n    <li>a. Physical check of all ports, including power and USB ports. b. Checking also of accessories c. Understanding your new TV&#39;s features with complete demonstration of features and settings d. Quick run-through on how to operate the TV e. Preventive maintenance action to be taken</li>\r\n    <li>Flipkart will communicate the day and time slot of the scheduled Installation & Demo through a SMS</li>\r\n    <li>The Installation & First Demo service will be provided free of cost. All additional accessories not part of the the package will be charged separately</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n', '10012020121103_89317.jpg', '10012020121103_893171.jpg', '', 8000, 4000, 4000, 50, '', 'Black/000000', '', 0, 1, 0, '0', 0, 0, 0, 0, '0', 0, '1578638464', '', '', '', 1);
INSERT INTO `tbl_product` (`id`, `category_id`, `sub_category_id`, `brand_id`, `offer_id`, `product_title`, `product_slug`, `product_desc`, `product_features`, `featured_image`, `featured_image2`, `size_chart`, `product_mrp`, `selling_price`, `you_save_amt`, `you_save_per`, `other_color_product`, `color`, `product_size`, `product_quantity`, `max_unit_buy`, `delivery_charge`, `total_views`, `total_rate`, `rate_avg`, `is_featured`, `today_deal`, `today_deal_date`, `total_sale`, `created_at`, `seo_title`, `seo_meta_description`, `seo_keywords`, `status`) VALUES
(44, 1, 21, 1, 0, 'Mi LED Smart TV 4A 80 cm (32)', 'mi-led-smart-tv-4a-80-cm-32', 'Get the Mi LED Smart TV 4A 80 cm (32) that screams entertainment. You can take your TV-viewing experience to the next level as it comes with an HD-Ready LED Display, Stereo Speakers.\r\n\r\nHD-Ready LED Display:\r\nExplore every detail in brilliant clarity, along with vibrant life-like colors and enhanced brightness. Thanks to the upgraded graphics engine, there is reduced noise and improved contrast and brightness.\r\n\r\nPowerful 20 W Stereo Speakers (10 W x 2):\r\nThe powerful 20 W stereo speakers (10 W x 2) let you hear the awesome dialogues your favorite actors deliver loudly and clearly.\r\n\r\nLeading Performance:\r\nSeamlessly switch between multiple apps, as it comes with a 64-bit quad-core processor and 1 GB of RAM. It comes with multiple connectivity ports, such as HDMI, USB and much more, so you can enjoy the content from other media and storage devices as well. You can also connect to the Internet using the Ethernet port.\r\n\r\nPatch Wall:\r\nRevolutionist your TV-viewing experience, as you can seamlessly enjoy up to 500000+ hours of entertainment by discovering recommended content from different apps.\r\n\r\nOne Remote, One Interface:\r\nThis feature lets you combine and control your Smart TV and Set-top Box for a seamless TV-viewing experience.\r\n\r\nScreen Mirroring:\r\nThanks to this feature, you can enjoy content from other smart devices on a bigger screen. You can even control this TV using your Android phone that is connected to the same Wi-Fi.\r\n\r\nMultiple Ports:\r\nThis TV features multiple ports to connect your media devices.\r\n\r\nApplications:\r\nWith easy access to various content providers such as Hotstart, Voot, Hungama, and flickstree, you\'d never run out of things to watch.', '<h3>General</h3>\r\n\r\n<table border=\"\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>In The Box</td>\r\n   <td>\r\n   <ul>\r\n    <li>LED TV 1U, Manual 1U, Screws 4U, Remote Control 1U, Stand 1U</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Model Name</td>\r\n   <td>\r\n   <ul>\r\n    <li>L32M5-AI</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Display Size</td>\r\n   <td>\r\n   <ul>\r\n    <li>80 cm (32)</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Screen Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>LED</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>HD Technology & Resolution</td>\r\n   <td>\r\n   <ul>\r\n    <li>HD Ready, 1366 x 768 Pixels</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>3D</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Smart TV</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Curve TV</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Series</td>\r\n   <td>\r\n   <ul>\r\n    <li>4A</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Touchscreen</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Motion Sensor</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>HDMI</td>\r\n   <td>\r\n   <ul>\r\n    <li>3</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>USB</td>\r\n   <td>\r\n   <ul>\r\n    <li>2</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Wi-Fi Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>802.11a/b/g/n (2.4 GHz)</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Built In Wi-Fi</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Launch Year</td>\r\n   <td>\r\n   <ul>\r\n    <li>2018</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Internet Features</h3>\r\n\r\n<table border=\"\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Built In Wi-Fi</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>3G Dongle Plug and Play</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Ethernet (RJ45)</td>\r\n   <td>\r\n   <ul>\r\n    <li>1</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Connectivity Features</h3>\r\n\r\n<table border=\"\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>HDMI</td>\r\n   <td>\r\n   <ul>\r\n    <li>Side</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>USB</td>\r\n   <td>\r\n   <ul>\r\n    <li>Side</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Headphone Jack</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Video Features</h3>\r\n\r\n<table border=\"\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>View Angle</td>\r\n   <td>\r\n   <ul>\r\n    <li>178 degree</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>LED Display Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>LED</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Refresh Rate</td>\r\n   <td>\r\n   <ul>\r\n    <li>60 Hz</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Supported Video Formats</td>\r\n   <td>\r\n   <ul>\r\n    <li>H.265, H.264, Real, MPEG 1/2/4</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Smart Tv Features</h3>\r\n\r\n<table border=\"\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Number of Cores</td>\r\n   <td>\r\n   <ul>\r\n    <li>4</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Processor</td>\r\n   <td>\r\n   <ul>\r\n    <li>Amlogic 64-bit Quad-core</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Graphic Processor</td>\r\n   <td>\r\n   <ul>\r\n    <li>Mali-450 MP3</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Ram Capacity</td>\r\n   <td>\r\n   <ul>\r\n    <li>1 GB</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Storage Memory</td>\r\n   <td>\r\n   <ul>\r\n    <li>8 GB</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Supported App - Hotstar</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Operating System</td>\r\n   <td>\r\n   <ul>\r\n    <li>Android Based</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Screen Mirroring</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Content Providers</td>\r\n   <td>\r\n   <ul>\r\n    <li>Content Providers - Hotstar, Voot, Sony Liv, Sun Nxt, Zee5, Hungama Play, ALT Balaji, Viu, TVF Play, Flickstree</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Content Languages</td>\r\n   <td>\r\n   <ul>\r\n    <li>Marathi, Gujarati, Sinhala, Kannada, Tamil, Rajasthani, Hindi, English, Punjabi, Telugu, Bengali, Urdu, Malayalam, Bhojpuri, Oriya</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>System Languages</td>\r\n   <td>\r\n   <ul>\r\n    <li>Assamese, Marathi, Gujarati, Kannada, Tamil, English, Hindi, Punjabi, Bengali, Telugu, Urdu, Malayalam, Oriya</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Audio Features</h3>\r\n\r\n<table border=\"\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Number of Speakers</td>\r\n   <td>\r\n   <ul>\r\n    <li>2</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Sound Technology</td>\r\n   <td>\r\n   <ul>\r\n    <li>DTS</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Surround Sound</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Speaker Output RMS</td>\r\n   <td>\r\n   <ul>\r\n    <li>20 W</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Supported Audio Formats</td>\r\n   <td>\r\n   <ul>\r\n    <li>DTS</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Other Audio Features</td>\r\n   <td>\r\n   <ul>\r\n    <li>Surround Sound</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Power Features</h3>\r\n\r\n<table border=\"\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Power Requirement</td>\r\n   <td>\r\n   <ul>\r\n    <li>AC 100 - 240 V, 50/60 Hz</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Power Consumption</td>\r\n   <td>\r\n   <ul>\r\n    <li>50 W, 0.5 W (Standby)</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Remote Control Features</h3>\r\n\r\n<table border=\"\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Touch Remote</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Internet Access</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Additional Features</h3>\r\n\r\n<table border=\"\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>\r\n   <ul>\r\n    <li>Supported Photo Formats - PNG, GIF, JPG, DTS-HD Speakers, Cable TV Integration, 3.5mm jack, Ultra Bright HD display</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Dimensions</h3>\r\n\r\n<table border=\"\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Width x Height x Depth (without stand)</td>\r\n   <td>\r\n   <ul>\r\n    <li>733 mm x 435 mm x 80 mm</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Weight (without stand)</td>\r\n   <td>\r\n   <ul>\r\n    <li>3.855 kg</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Width x Height x Depth (with stand)</td>\r\n   <td>\r\n   <ul>\r\n    <li>733 mm x 479 mm x 180 mm</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Weight (with stand)</td>\r\n   <td>\r\n   <ul>\r\n    <li>3.9 kg</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Warranty</h3>\r\n\r\n<table border=\"\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Warranty Summary</td>\r\n   <td>\r\n   <ul>\r\n    <li>1 Year Warranty on Product and Additional 1 Year Warranty on Panel</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Covered in Warranty</td>\r\n   <td>\r\n   <ul>\r\n    <li>Defect Arising Out of Faulty or Defective Material or Workmanship. Parts and Labour Costs are Covered</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Not Covered in Warranty</td>\r\n   <td>\r\n   <ul>\r\n    <li>Physical Damages after Usage, Scratches on Panel</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Warranty Service Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>On-site Technician Visit</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Installation & Demo</h3>\r\n\r\n<table border=\"\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Installation & Demo Details</td>\r\n   <td>\r\n   <ul>\r\n    <li>Please note that any unauthorized handling or self-installation of the product will lead to return & product warranty being void</li>\r\n    <li>Installation will be free of cost only if done within 15 days of delivery</li>\r\n    <li>Flipkart will facilitate Installation & Demo at time of your convenience from an brand authorized service engineer</li>\r\n    <li>Customer will have to pay Rs 500 (Applicable Tax Extra) if the installation is requested post 15 days of delivery</li>\r\n    <li>The authorized service engineer will be providing detailed demo that includes</li>\r\n    <li>The service engineer will install your new TV, either on wall mount or on table top. The wall mount is not provided free of cost and is chargeable to the customer. The cost of wall mount is Rs. 399 (inclusive of applicable taxes) and will be available with service engineer for purchase</li>\r\n    <li>a. Physical check of all ports, including power and USB ports. b. Checking also of accessories c. Understanding your new TV&#39;s features with complete demonstration of features and settings d. Quick run-through on how to operate the TV e. Preventive maintenance action to be taken</li>\r\n    <li>Flipkart will communicate the day and time slot of the scheduled Installation & Demo through a SMS</li>\r\n    <li>The Installation & First Demo service will be provided free of cost. All additional accessories not part of the the package will be charged separately</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n', '10012020121722_42662.jpg', '10012020121722_426621.jpg', '', 175.84, 175.84, 0, 0, '', 'Black/000000', '', 0, 2, 0, '0', 0, 0, 0, 0, '0', 0, '1578638843', '', '', '', 1),
(45, 1, 21, 1, 0, 'Mi LED Smart TV 4A 108 cm (43)', 'mi-led-smart-tv-4a-108-cm-43', 'Get the Mi LED Smart TV 4A 80 cm (32) that screams entertainment. You can take your TV-viewing experience to the next level as it comes with an HD-Ready LED Display, Stereo Speakers.\r\n\r\nHD-Ready LED Display:\r\nExplore every detail in brilliant clarity, along with vibrant life-like colors and enhanced brightness. Thanks to the upgraded graphics engine, there is reduced noise and improved contrast and brightness.\r\n\r\nPowerful 20 W Stereo Speakers (10 W x 2):\r\nThe powerful 20 W stereo speakers (10 W x 2) let you hear the awesome dialogues your favorite actors deliver loudly and clearly.\r\n\r\nLeading Performance:\r\nSeamlessly switch between multiple apps, as it comes with a 64-bit quad-core processor and 1 GB of RAM. It comes with multiple connectivity ports, such as HDMI, USB and much more, so you can enjoy the content from other media and storage devices as well. You can also connect to the Internet using the Ethernet port.\r\n\r\nPatch Wall:\r\nRevolutionist your TV-viewing experience, as you can seamlessly enjoy up to 500000+ hours of entertainment by discovering recommended content from different apps.\r\n\r\nOne Remote, One Interface:\r\nThis feature lets you combine and control your Smart TV and Set-top Box for a seamless TV-viewing experience.\r\n\r\nScreen Mirroring:\r\nThanks to this feature, you can enjoy content from other smart devices on a bigger screen. You can even control this TV using your Android phone that is connected to the same Wi-Fi.\r\n\r\nMultiple Ports:\r\nThis TV features multiple ports to connect your media devices.\r\n\r\nApplications:\r\nWith easy access to various content providers such as Hotstart, Voot, Hungama, and flickstree, you\'d never run out of things to watch.', '<h3>General</h3>\r\n\r\n<table border=\"\\\\\\\\\\\\\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>In The Box</td>\r\n   <td>\r\n   <ul>\r\n    <li>LED TV 1U, Manual 1U, Screws 4U, Remote Control 1U, Stand 1U</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Model Name</td>\r\n   <td>\r\n   <ul>\r\n    <li>L32M5-AI</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Display Size</td>\r\n   <td>\r\n   <ul>\r\n    <li>880 cm (43)</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Screen Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>LED</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>HD Technology & Resolution</td>\r\n   <td>\r\n   <ul>\r\n    <li>HD Ready, 1366 x 768 Pixels</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>3D</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Smart TV</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Curve TV</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Series</td>\r\n   <td>\r\n   <ul>\r\n    <li>4A</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Touchscreen</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Motion Sensor</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>HDMI</td>\r\n   <td>\r\n   <ul>\r\n    <li>3</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>USB</td>\r\n   <td>\r\n   <ul>\r\n    <li>2</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Wi-Fi Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>802.11a/b/g/n (2.4 GHz)</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Built In Wi-Fi</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Launch Year</td>\r\n   <td>\r\n   <ul>\r\n    <li>2018</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Internet Features</h3>\r\n\r\n<table border=\"\\\\\\\\\\\\\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Built In Wi-Fi</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>3G Dongle Plug and Play</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Ethernet (RJ45)</td>\r\n   <td>\r\n   <ul>\r\n    <li>1</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Connectivity Features</h3>\r\n\r\n<table border=\"\\\\\\\\\\\\\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>HDMI</td>\r\n   <td>\r\n   <ul>\r\n    <li>Side</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>USB</td>\r\n   <td>\r\n   <ul>\r\n    <li>Side</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Headphone Jack</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Video Features</h3>\r\n\r\n<table border=\"\\\\\\\\\\\\\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>View Angle</td>\r\n   <td>\r\n   <ul>\r\n    <li>178 degree</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>LED Display Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>LED</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Refresh Rate</td>\r\n   <td>\r\n   <ul>\r\n    <li>60 Hz</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Supported Video Formats</td>\r\n   <td>\r\n   <ul>\r\n    <li>H.265, H.264, Real, MPEG 1/2/4</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Smart Tv Features</h3>\r\n\r\n<table border=\"\\\\\\\\\\\\\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Number of Cores</td>\r\n   <td>\r\n   <ul>\r\n    <li>4</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Processor</td>\r\n   <td>\r\n   <ul>\r\n    <li>Amlogic 64-bit Quad-core</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Graphic Processor</td>\r\n   <td>\r\n   <ul>\r\n    <li>Mali-450 MP3</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Ram Capacity</td>\r\n   <td>\r\n   <ul>\r\n    <li>1 GB</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Storage Memory</td>\r\n   <td>\r\n   <ul>\r\n    <li>8 GB</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Supported App - Hotstar</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Operating System</td>\r\n   <td>\r\n   <ul>\r\n    <li>Android Based</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Screen Mirroring</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Content Providers</td>\r\n   <td>\r\n   <ul>\r\n    <li>Content Providers - Hotstar, Voot, Sony Liv, Sun Nxt, Zee5, Hungama Play, ALT Balaji, Viu, TVF Play, Flickstree</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Content Languages</td>\r\n   <td>\r\n   <ul>\r\n    <li>Marathi, Gujarati, Sinhala, Kannada, Tamil, Rajasthani, Hindi, English, Punjabi, Telugu, Bengali, Urdu, Malayalam, Bhojpuri, Oriya</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>System Languages</td>\r\n   <td>\r\n   <ul>\r\n    <li>Assamese, Marathi, Gujarati, Kannada, Tamil, English, Hindi, Punjabi, Bengali, Telugu, Urdu, Malayalam, Oriya</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Audio Features</h3>\r\n\r\n<table border=\"\\\\\\\\\\\\\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Number of Speakers</td>\r\n   <td>\r\n   <ul>\r\n    <li>2</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Sound Technology</td>\r\n   <td>\r\n   <ul>\r\n    <li>DTS</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Surround Sound</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Speaker Output RMS</td>\r\n   <td>\r\n   <ul>\r\n    <li>20 W</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Supported Audio Formats</td>\r\n   <td>\r\n   <ul>\r\n    <li>DTS</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Other Audio Features</td>\r\n   <td>\r\n   <ul>\r\n    <li>Surround Sound</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Power Features</h3>\r\n\r\n<table border=\"\\\\\\\\\\\\\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Power Requirement</td>\r\n   <td>\r\n   <ul>\r\n    <li>AC 100 - 240 V, 50/60 Hz</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Power Consumption</td>\r\n   <td>\r\n   <ul>\r\n    <li>50 W, 0.5 W (Standby)</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Remote Control Features</h3>\r\n\r\n<table border=\"\\\\\\\\\\\\\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Touch Remote</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Internet Access</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Additional Features</h3>\r\n\r\n<table border=\"\\\\\\\\\\\\\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>\r\n   <ul>\r\n    <li>Supported Photo Formats - PNG, GIF, JPG, DTS-HD Speakers, Cable TV Integration, 3.5mm jack, Ultra Bright HD display</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Dimensions</h3>\r\n\r\n<table border=\"\\\\\\\\\\\\\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Width x Height x Depth (without stand)</td>\r\n   <td>\r\n   <ul>\r\n    <li>733 mm x 435 mm x 80 mm</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Weight (without stand)</td>\r\n   <td>\r\n   <ul>\r\n    <li>3.855 kg</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Width x Height x Depth (with stand)</td>\r\n   <td>\r\n   <ul>\r\n    <li>733 mm x 479 mm x 180 mm</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Weight (with stand)</td>\r\n   <td>\r\n   <ul>\r\n    <li>3.9 kg</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Warranty</h3>\r\n\r\n<table border=\"\\\\\\\\\\\\\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Warranty Summary</td>\r\n   <td>\r\n   <ul>\r\n    <li>1 Year Warranty on Product and Additional 1 Year Warranty on Panel</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Covered in Warranty</td>\r\n   <td>\r\n   <ul>\r\n    <li>Defect Arising Out of Faulty or Defective Material or Workmanship. Parts and Labour Costs are Covered</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Not Covered in Warranty</td>\r\n   <td>\r\n   <ul>\r\n    <li>Physical Damages after Usage, Scratches on Panel</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Warranty Service Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>On-site Technician Visit</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Installation & Demo</h3>\r\n\r\n<table border=\"\\\\\\\\\\\\\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Installation & Demo Details</td>\r\n   <td>\r\n   <ul>\r\n    <li>Please note that any unauthorized handling or self-installation of the product will lead to return & product warranty being void</li>\r\n    <li>Installation will be free of cost only if done within 15 days of delivery</li>\r\n    <li>Flipkart will facilitate Installation & Demo at time of your convenience from an brand authorized service engineer</li>\r\n    <li>Customer will have to pay Rs 500 (Applicable Tax Extra) if the installation is requested post 15 days of delivery</li>\r\n    <li>The authorized service engineer will be providing detailed demo that includes</li>\r\n    <li>The service engineer will install your new TV, either on wall mount or on table top. The wall mount is not provided free of cost and is chargeable to the customer. The cost of wall mount is Rs. 399 (inclusive of applicable taxes) and will be available with service engineer for purchase</li>\r\n    <li>a. Physical check of all ports, including power and USB ports. b. Checking also of accessories c. Understanding your new TV&#39;s features with complete demonstration of features and settings d. Quick run-through on how to operate the TV e. Preventive maintenance action to be taken</li>\r\n    <li>Flipkart will communicate the day and time slot of the scheduled Installation & Demo through a SMS</li>\r\n    <li>The Installation & First Demo service will be provided free of cost. All additional accessories not part of the the package will be charged separately</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n', '10012020122400_83003.jpg', '10012020122400_830031.jpg', '', 323.56, 323.56, 0, 0, '', 'Black/000000', '', 0, 1, 0, '0', 0, 0, 0, 0, '0', 0, '1578639240', '', '', '', 1),
(48, 1, 7, 18, 6, 'LD-BK040-WHT-BLK Analog Watch - For Men', 'ld-bk040-wht-blk-analog-watch-for-men', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '<p><strong>Display Type: </strong>Analog</p>\r\n\r\n<p><strong>Style Code: </strong>LD-BK040-WHT-BLK</p>\r\n\r\n<p><strong>Occasion: </strong>Casual</p>\r\n\r\n<p><strong>Watch Type: </strong>Wrist Watch, Thick Straps</p>\r\n\r\n<p><strong>Pack of: </strong>1</p>\r\n\r\n<p><strong>Sales Package: </strong>1 Wrist Watch & Warranty Card</p>\r\n\r\n<p><strong>Strap Material: </strong>Synthetic Leather Strap</p>\r\n\r\n<p><strong>Power Source: </strong>Battery Powered</p>\r\n\r\n<p><strong>Dial Color: </strong>White</p>\r\n\r\n<p><strong>Weight: </strong>200 g</p>\r\n\r\n<p><strong>Warranty Service Type: </strong>Offsite</p>\r\n', '10012020021954_61988.jpg', '10012020021954_619881.jpg', '', 14.07, 9.85, 4.22, 30, '', 'Black/000000', '', 0, 5, 0, '0', 0, 0, 0, 0, '0', 0, '1578646194', '', '', '', 1),
(50, 1, 7, 18, 1, 'LD-WT065-SLV-CH Analog Watch - For Men', 'ld-wt065-slv-ch-analog-watch-for-men', 'Stainless Steel Chain analog wrist watch by Louis Devin for Men. The watch comes with day and display feature which always keeps you ahead of your schedule.', '<p><strong>Display Type: </strong>Analog</p>\r\n\r\n<p><strong>Style Code: </strong>LD-WT065-SLV-CH</p>\r\n\r\n<p><strong>Occasion: </strong>Party-Wedding, Formal, Casual</p>\r\n\r\n<p><strong>Watch Type: </strong>Wrist Watch</p>\r\n\r\n<p><strong>Pack of: </strong>1</p>\r\n\r\n<p><strong>Sales Package: </strong>1 Wrist Watch & Warranty Card</p>\r\n\r\n<p><strong>Strap Material: </strong>Stainless Steel Strap</p>\r\n\r\n<p><strong>Power Source: </strong>Battery Powered</p>\r\n\r\n<p><strong>Dial Color: </strong>Silver</p>\r\n\r\n<p><strong>Weight: </strong>200 g</p>\r\n\r\n<p><strong>Warranty Service Type: </strong>Offsite</p>\r\n', '10012020023651_85384.jpg', '10012020023651_853841.jpg', '', 33.75, 16.5, 16.5, 50, '', 'Silver/C9C8C8', '', 0, 5, 0, '0', 0, 0, 0, 0, '0', 0, '1578647211', '', '', '', 1),
(51, 10, 18, 19, 3, 'Movemax IDP Running Shoes For Men  (Blue, Maroon)', 'movemax-idp-running-shoes-for-men-blue-maroon', 'The Movemax IDP is from the Sportstyle Core Collection of PUMA. These are perfect for daily comfort wear topped with style', '<p><strong>Color:</strong> Blue, Maroon</p>\r\n\r\n<p><strong>Outer Material: </strong>Mesh</p>\r\n\r\n<p><strong>Model Name: </strong>Movemax IDP</p>\r\n\r\n<p><strong>Ideal For: </strong>Men</p>\r\n\r\n<p><strong>Occasion: </strong>Sports</p>\r\n\r\n<p><strong>Sole Material: </strong>Rubber</p>\r\n\r\n<p><strong>Closure: </strong>Lace-Ups</p>\r\n\r\n<p><strong>Sales Package: </strong>1 Pair Shoes</p>\r\n\r\n<p><strong>Pack of: </strong>1</p>\r\n\r\n<p><strong>Tip Shape: </strong>Round</p>\r\n\r\n<p><strong>Care Instructions: </strong>Wipe with a clean dry cloth</p>\r\n', '23012020024311_60881.jpg', '23012020024311_608811.jpg', '23012020024311_608812.png', 56, 28, 28, 50, '53', 'Blue/2F3043', '6, 7, 8, 9, 10, 11', 0, 3, 0, '0', 0, 0, 0, 0, '0', 0, '1579770791', '', '', '', 1),
(52, 10, 18, 20, 6, 'Drogo 2.0 M Running Shoes For Men  (Blue)', 'drogo-20-m-running-shoes-for-men-blue', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '<p><strong>Color: </strong>Blue</p>\r\n\r\n<p><strong>Outer Material: </strong>Mesh</p>\r\n\r\n<p><strong>Model Name: </strong>Drogo 2.0 M</p>\r\n\r\n<p><strong>Ideal For: </strong>Men</p>\r\n\r\n<p><strong>Occasion: </strong>Sports</p>\r\n\r\n<p><strong>Leather Type: </strong>Napa</p>\r\n\r\n<p><strong>Secondary Color: </strong>Blue</p>\r\n\r\n<p><strong>Sole Material: </strong>Rubber</p>\r\n\r\n<p><strong>Closure: </strong>Lace-Ups</p>\r\n\r\n<p><strong>Weight: </strong>158 g (per single Shoe) - Weight of the product may vary depending on size.</p>\r\n\r\n<p><strong>Season: </strong>AW19</p>\r\n\r\n<p><strong>Tanning Process: </strong>Synthetic</p>\r\n', '23012020025603_67363.jpg', '23012020025603_673631.jpg', '23012020025603_673632.png', 50, 35, 15, 30, '', 'Blue/693F6E', '6, 7, 8, 9, 10, 11', 0, 3, 0, '0', 0, 0, 0, 0, '0', 0, '1579771563', '', '', '', 1),
(53, 10, 18, 19, 3, 'Movemax IDP Running Shoes For Men  (Black)', 'movemax-idp-running-shoes-for-men-black', 'The Movemax IDP is from the Sportstyle Core Collection of PUMA. These are perfect for daily comfort wear topped with style', '<p><strong>Color:</strong> Black</p>\r\n\r\n<p><strong>Outer Material: </strong>Mesh</p>\r\n\r\n<p><strong>Model Name: </strong>Movemax IDP</p>\r\n\r\n<p><strong>Ideal For: </strong>Men</p>\r\n\r\n<p><strong>Occasion: </strong>Sports</p>\r\n\r\n<p><strong>Sole Material: </strong>Rubber</p>\r\n\r\n<p><strong>Closure: </strong>Lace-Ups</p>\r\n\r\n<p><strong>Sales Package: </strong>1 Pair Shoes</p>\r\n\r\n<p><strong>Pack of: </strong>1</p>\r\n\r\n<p><strong>Tip Shape: </strong>Round</p>\r\n\r\n<p><strong>Care Instructions: </strong>Wipe with a clean dry cloth</p>\r\n', '23012020032419_74936.jpg', '23012020032419_749361.jpg', '23012020032419_749362.png', 56, 28, 28, 50, '51', 'Black/262626', '6, 7, 8, 9, 10, 11', 0, 3, 0, '0', 0, 0, 0, 0, '0', 0, '1579773259', '', '', '', 1),
(54, 10, 18, 20, 6, 'Drogo M Running Shoe For Men  (Navy)', 'drogo-m-running-shoe-for-men-navy', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '<p><strong>Color: </strong>Navy</p>\r\n\r\n<p><strong>Outer Material: </strong>Mesh</p>\r\n\r\n<p><strong>Model Name: </strong>Drogo 2.0 M</p>\r\n\r\n<p><strong>Ideal For: </strong>Men</p>\r\n\r\n<p><strong>Occasion: </strong>Sports</p>\r\n\r\n<p><strong>Leather Type: </strong>Napa</p>\r\n\r\n<p><strong>Secondary Color: </strong>Blue</p>\r\n\r\n<p><strong>Sole Material: </strong>Rubber</p>\r\n\r\n<p><strong>Closure: </strong>Lace-Ups</p>\r\n\r\n<p><strong>Weight: </strong>158 g (per single Shoe) - Weight of the product may vary depending on size.</p>\r\n\r\n<p><strong>Season: </strong>AW19</p>\r\n\r\n<p><strong>Tanning Process: </strong>Synthetic</p>\r\n', '23012020032752_3529.jpg', '23012020032752_35291.jpg', '23012020032752_35292.png', 37.88, 26.52, 11.36, 30, '', 'Navy/243A53', '6, 7, 8, 9, 10, 11', 0, 3, 0, '0', 0, 0, 0, 0, '0', 0, '1579773472', '', '', '', 1),
(55, 10, 18, 21, 6, 'Fitze 407 Casuals For Men  (Navy)', 'fitze-407-casuals-for-men-navy', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '<p><strong>Color: </strong>Navy</p>\r\n\r\n<p><strong>Inner Material: </strong>Synthetic</p>\r\n\r\n<p><strong>Outer Material: </strong>Mesh</p>\r\n\r\n<p><strong>Model Name: </strong>Fitze 407</p>\r\n\r\n<p><strong>Ideal For: </strong>Men</p>\r\n\r\n<p><strong>Occasion: </strong>Sports</p>\r\n\r\n<p><strong>School Shoe: </strong>No</p>\r\n\r\n<p><strong>Closure: </strong>Lace-Ups</p>\r\n\r\n<p><strong>Weight: </strong>200 g (per single Shoe) - Weight of the product may vary depending on size.</p>\r\n\r\n<p><strong>Upper Pattern: </strong>Mesh</p>\r\n\r\n<p><strong>Sales Package: </strong>2 Shoes</p>\r\n\r\n<p><strong>Pack of: </strong>2</p>\r\n\r\n<p><strong>Tip Shape: </strong>Round</p>\r\n\r\n<p><strong>Generic Name: </strong>Shoe</p>\r\n', '23012020033445_96891.jpg', '23012020033445_968911.jpg', '23012020033445_968912.png', 17, 11.9, 5.1, 30, '', 'Navy/242838', '7,8', 0, 3, 0, '0', 0, 0, 0, 0, '0', 0, '1579773885', '', '', '', 1),
(56, 10, 18, 22, 6, 'AIR ZOOM VOMERO 14 Running Shoes For Men  (Black)', 'air-zoom-vomero-14-running-shoes-for-men-black', 'Nike Air Zoom Vomero 14-Men\'s Running Shoe-BREAKTHROUGH RESPONSIVENESS WITH EVERY STRIDE.-The Nike Air Zoom Vomero 14 takes responsive cushioning to the next level. A full-length Zoom Air unit works with Nike React cushioning to deliver a super snappy, smooth ride. Up top, the sleek design is engineered to support your stride.-- Full-length Zoom Air unit gives a smooth, snappy feel.-Nike React technology delivers an extremely smooth ride.-Sleek mesh upper is engineered for durability and support.-Dynamic Fit technology combines Flywire cables and soft foam for a supportive feel in the midfoot.-Foam pods inside the collar hug the back of your foot for a secure feel.-- More Details Last: MR-10 Offset: 10mm (22 mm heel, 12 mm forefoot)', '<p><strong>Color: </strong>Black</p>\r\n\r\n<p><strong>Outer Material: </strong>Textile</p>\r\n\r\n<p><strong>Model Name: </strong>AIR ZOOM VOMERO 14</p>\r\n\r\n<p><strong>Ideal For: </strong>Men</p>\r\n\r\n<p><strong>Occasion: </strong>Sports</p>\r\n', '23012020040013_5234.jpg', '23012020040013_52341.jpg', '23012020040013_52342.png', 28, 19.6, 8.4, 30, '', 'Black/191A1B', '6, 7, 8, 9, 10, 11, 12', 0, 2, 0, '0', 0, 0, 0, 0, '0', 0, '1579775413', '', '', '', 1),
(57, 10, 17, 20, 5, 'Boys & Girls Lace Running Shoes  (Black)', 'boys-girls-lace-running-shoes-black', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '<p><strong>Number of Pairs: </strong>1</p>\r\n\r\n<p><strong>Style Code: </strong>CG6830</p>\r\n\r\n<p><strong>Size: </strong>13C</p>\r\n\r\n<p><strong>Brand Color: </strong>CBLACK/GREFOU/FTWWHT</p>\r\n\r\n<p><strong>Ideal For: </strong>Boys & Girls</p>\r\n\r\n<p><strong>Type: </strong>Sports Wear</p>\r\n\r\n<p><strong>Sub Type: </strong>Running Shoes</p>\r\n\r\n<p><strong>Primary Color: </strong>Black</p>\r\n\r\n<p><strong>Closure Type: </strong>Lace</p>\r\n\r\n<p><strong>Outer Material: </strong>Rubber</p>\r\n\r\n<p><strong>Sole Material: </strong>Rubber</p>\r\n\r\n<p><strong>Secondary Color: </strong>Black</p>\r\n\r\n<p><strong>Insole Material: </strong>Sponge</p>\r\n\r\n<p><strong>Removable Insole: </strong>No</p>\r\n\r\n<p><strong>Character: </strong>None</p>\r\n\r\n<p><strong>Care instructions: </strong>Hand wash</p>\r\n', '23012020041102_26327.jpg', '23012020041102_263271.jpg', '23012020041102_263272.png', 64.55, 51.2, 12.8, 20, '', 'Black/000000', '10C, 10.5C, 11C, 11.5C, 12C, 12.5C, 13C, 13.5C, 1, 1.5', 0, 2, 1, '0', 0, 0, 0, 0, '0', 0, '1579776062', '', '', '', 1),
(58, 10, 17, 20, 6, 'Boys Lace Cricket Shoes  (White)', 'boys-lace-cricket-shoes-white', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '<p><strong>Number of Pairs: </strong>1</p>\r\n\r\n<p><strong>Brand: </strong>ADIDAS</p>\r\n\r\n<p><strong>Style Code: </strong>DB3340</p>\r\n\r\n<p><strong>Size: </strong>1</p>\r\n\r\n<p><strong>Brand Color: </strong>FTWWHT/LEGMAR/ASHGRE</p>\r\n\r\n<p><strong>Ideal For: </strong>Boys</p>\r\n\r\n<p><strong>Type: </strong>Sports Wear</p>\r\n\r\n<p><strong>Sub Type: </strong>Cricket Shoes</p>\r\n\r\n<p><strong>Primary Color: </strong>White</p>\r\n\r\n<p><strong>Closure Type: </strong>Lace</p>\r\n\r\n<p><strong>Outer Material: </strong>Synthetic Leather</p>\r\n\r\n<p><strong>Sole Material: </strong>PU</p>\r\n\r\n<p><strong>Secondary Color: </strong>White</p>\r\n\r\n<p><strong>Insole Material: </strong>Sponge</p>\r\n\r\n<p><strong>Removable Insole: </strong>No</p>\r\n\r\n<p><strong>Character: </strong>None</p>\r\n', '23012020042138_71906.jpg', '23012020042138_719061.jpg', '23012020042138_719062.png', 52.9, 37.03, 15.87, 30, '', 'White/FFFFFF', '1, 2, 3, 4, 5', 0, 2, 0, '0', 0, 0, 0, 0, '0', 0, '1579776698', '', '', '', 1),
(59, 10, 17, 0, 0, 'Boys & Girls Lace Running Shoes  (Blue)', 'boys-girls-lace-running-shoes-blue', 'Used soft and cozy material. Before place order please measurement kids foot length.', '<p><strong>Number of Pairs: </strong>1</p>\r\n\r\n<p><strong>Brand: </strong>WINDY</p>\r\n\r\n<p><strong>Style Code: </strong>242</p>\r\n\r\n<p><strong>Size: </strong>6C</p>\r\n\r\n<p><strong>Brand Color: </strong>BLUE</p>\r\n\r\n<p><strong>Ideal For: </strong>Boys & Girls</p>\r\n\r\n<p><strong>Type: </strong>Sports Wear</p>\r\n\r\n<p><strong>Sub Type: </strong>Running Shoes</p>\r\n\r\n<p><strong>Primary Color: </strong>Blue</p>\r\n\r\n<p><strong>Closure Type: </strong>Lace</p>\r\n\r\n<p><strong>Outer Material: </strong>Canvas</p>\r\n\r\n<p><strong>Sole Material: </strong>PVC</p>\r\n\r\n<p><strong>Heel Design: </strong>Flats</p>\r\n\r\n<p><strong>Heel Height: </strong>1 to 2 inch</p>\r\n\r\n<p><strong>Secondary Color: </strong>White</p>\r\n\r\n<p><strong>Character: </strong>None</p>\r\n', '23012020052638_15971.jpg', '23012020052638_159711.jpg', '23012020052638_159712.png', 8.42, 8.42, 0, 0, '', 'Blue/3A4059', '5C, 6C, 7C, 8C, 9C', 0, 5, 0, '0', 0, 0, 0, 0, '0', 0, '1579780598', '', '', '', 1),
(60, 10, 17, 0, 6, 'Boys & Girls Lace Running Shoes  (Hitcolus Shoes )(Blue)', 'boys-girls-lace-running-shoes-hitcolus-shoes-blue', 'Used soft and cozy material. Before place order please measurement kids foot length.', '<p><strong>Number of Pairs: </strong>1</p>\r\n\r\n<p><strong>Brand: </strong>Hitcolus Shoes</p>\r\n\r\n<p><strong>Style Code: </strong>242</p>\r\n\r\n<p><strong>Size: </strong>4</p>\r\n\r\n<p><strong>Brand Color: </strong>Navy</p>\r\n\r\n<p><strong>Ideal For: </strong>Boys & Girls</p>\r\n\r\n<p><strong>Type: </strong>Sports Wear</p>\r\n\r\n<p><strong>Sub Type: </strong>Running Shoes</p>\r\n\r\n<p><strong>Primary Color: </strong>Blue</p>\r\n\r\n<p><strong>Closure Type: </strong>Lace</p>\r\n\r\n<p><strong>Outer Material: </strong>Canvas</p>\r\n\r\n<p><strong>Sole Material: </strong>PVC</p>\r\n\r\n<p><strong>Heel Design: </strong>Flats</p>\r\n\r\n<p><strong>Heel Height: </strong>1 to 2 inch</p>\r\n\r\n<p><strong>Secondary Color: </strong>White</p>\r\n\r\n<p><strong>Character: </strong>None</p>\r\n', '23012020053028_90318.jpg', '23012020053028_903181.jpg', '23012020053028_903182.png', 21.05, 14.74, 6.31, 30, '', 'Navy/56576D', '2, 3, 4, 5', 0, 5, 0, '0', 0, 0, 0, 0, '0', 0, '1579780828', '', '', '', 1),
(61, 10, 19, 23, 3, 'Women Multicolor Flats Sandal', 'women-multicolor-flats-sandal', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '<p><strong>Type: </strong>Flats</p>\r\n\r\n<p><strong>Type for Flats: </strong>Sandal</p>\r\n\r\n<p><strong>Color: </strong>Multicolor</p>\r\n\r\n<p><strong>Pack of: </strong>2</p>\r\n', '23012020054651_4578.jpg', '23012020054651_45781.jpg', '23012020054651_45782.png', 14.03, 7.02, 7.01, 50, '', 'Brown/2A2829', '4, 5, 6, 7, 8, 9', 0, 5, 0, '0', 0, 0, 0, 0, '0', 0, '1579781811', '', '', '', 1),
(62, 10, 19, 0, 4, 'Women Black Flats Sandal', 'women-black-flats-sandal', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '<p><strong>Type: </strong>Flats</p>\r\n\r\n<p><strong>Type for Heels: </strong>Wedges</p>\r\n\r\n<p><strong>Type for Flats: </strong>Sandal</p>\r\n\r\n<p><strong>Color: </strong>Black</p>\r\n\r\n<p><strong>Pack of: </strong>1</p>\r\n\r\n<p><strong>Sole Material: </strong>PVC</p>\r\n\r\n<p><strong>Weight:</strong>200 g (per single Sandal) - Weight of the product may vary depending on size.</p>\r\n\r\n<p><strong>Generic Name: </strong>Sandal</p>\r\n\r\n<p><strong>Country of Origin: </strong>India</p>\r\n', '23012020055023_78349.jpg', '23012020055023_783491.jpg', '23012020055023_783492.png', 12.63, 12, 0.63, 5, '', 'Black/000000', '4, 5, 6, 7, 8', 0, 5, 0, '0', 0, 0, 0, 0, '0', 0, '1579782023', '', '', '', 0),
(63, 10, 19, 0, 4, 'Women Multi color Flats Sandal (PM Traders)', 'women-multi-color-flats-sandal-pm-traders', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '<p><strong>Type: </strong>Flats</p>\r\n\r\n<p><strong>Type for Flats: </strong>Slip-on</p>\r\n\r\n<p><strong>Color: </strong>Multicolor</p>\r\n\r\n<p><strong>Pack of: </strong>3</p>\r\n\r\n<p><strong>Sole Material: </strong>PVC</p>\r\n\r\n<p><strong>Care instructions: </strong>CARE INSTRUCTIONS- Allow your pair of slippers to air and deodorize at regular basis; use shoe bags to prevent any stains or mildew.</p>\r\n\r\n<p><strong>Other Details: </strong>Upper and Inner Material Is Jute and Velvet And Synthetic And Sole is PVC And Its Lighweight Product Also.</p>\r\n\r\n<p><strong>Weight: </strong>200 g (per single Sandal) - Weight of the product may vary depending on size.</p>\r\n\r\n<p><strong>Generic Name: </strong>Sandal</p>\r\n', '23012020055853_46454.jpg', '23012020055853_464541.jpg', '23012020055853_464542.png', 12.63, 12.63, 0.63, 5, '', 'Black/000000', '4, 5, 6, 7, 8, 9', 0, 5, 0, '0', 0, 0, 0, 0, '0', 0, '1579782533', '', '', '', 1),
(64, 10, 19, 0, 0, 'Women Gold Flats Sandal', 'women-gold-flats-sandal', 'This pair of flats have a buckle at the vamp which gives a fancier look .', '<p><strong>Type: </strong>Flats</p>\r\n\r\n<p><strong>Type for Heels: </strong>Wedges</p>\r\n\r\n<p><strong>Type for Flats: </strong>Slip-on</p>\r\n\r\n<p><strong>Color: </strong>Gold</p>\r\n\r\n<p><strong>Tanning Process: </strong>Synthetic</p>\r\n\r\n<p><strong>Removable Insole: </strong>No</p>\r\n\r\n<p><strong>Pack of: </strong>1</p>\r\n\r\n<p><strong>Sole Material: </strong>PVC</p>\r\n\r\n<p><strong>Care instructions: </strong>Wipe with a damp cloth</p>\r\n\r\n<p><strong>Inner Material: </strong>PU</p>\r\n\r\n<p><strong>Weight: </strong>300 g (per single Sandal) - Weight of the product may vary depending on size.</p>\r\n', '24012020021738_99866.jpg', '24012020021738_998661.jpg', '24012020021738_998662.png', 22.43, 22.43, 0, 0, '65', 'Gold/B58A5F', '4, 5, 6, 7, 8, 9', 0, 5, 0, '0', 0, 0, 0, 0, '0', 0, '1579855658', '', '', '', 1),
(65, 10, 19, 0, 0, 'Women Brown Flats Sandal', 'women-brown-flats-sandal', 'This pair of flats have a buckle at the vamp which gives a fancier look .', '<p><strong>Type: </strong>Flats</p>\r\n\r\n<p><strong>Type for Heels: </strong>Wedges</p>\r\n\r\n<p><strong>Type for Flats: </strong>Slip-on</p>\r\n\r\n<p><strong>Color: </strong>Brown</p>\r\n\r\n<p><strong>Tanning Process: </strong>Synthetic</p>\r\n\r\n<p><strong>Removable Insole: </strong>No</p>\r\n\r\n<p><strong>Pack of: </strong>1</p>\r\n\r\n<p><strong>Sole Material: </strong>PVC</p>\r\n\r\n<p><strong>Care instructions: </strong>Wipe with a damp cloth</p>\r\n\r\n<p><strong>Inner Material: </strong>PU</p>\r\n\r\n<p><strong>Weight: </strong>300 g (per single Sandal) - Weight of the product may vary depending on size.</p>\r\n', '24012020022054_50616.jpg', '24012020022054_506161.jpg', '24012020022054_506162.png', 22.43, 22.43, 0, 0, '64', 'Brown/483134', '4, 5, 6, 7, 8, 9', 0, 5, 0, '0', 0, 0, 0, 0, '0', 0, '1579855854', '', '', '', 1),
(66, 10, 19, 0, 6, 'Women Maroon Flats Sandal', 'women-maroon-flats-sandal', 'From the house of Myra presenting an exclusive range of ethnic footwear\'s that match up with your chic and everyday attires and keeps your feet happy. Featuring pair of comfortable and multicolor flats with hand embroidery. Style with your ethnic attire to complete your look.', '<p><strong>Type: </strong>Flats</p>\r\n\r\n<p><strong>Closure: </strong>Slip On</p>\r\n\r\n<p><strong>Type for Flats: </strong>Sandal</p>\r\n\r\n<p><strong>Color: </strong>Maroon</p>\r\n\r\n<p><strong>Pack of: </strong>1</p>\r\n\r\n<p><strong>Sole Material: </strong>Rubber & Cork</p>\r\n\r\n<p><strong>Care instructions: </strong>Rub With A Dry Cloth. Do Not Use Water/Soap/Detergent For Cleaning.</p>\r\n\r\n<p><strong>Weight: </strong>150 g (per single Sandal) - Weight of the product may vary depending on size.</p>\r\n', '24012020022557_79781.jpg', '24012020022557_797811.jpg', '24012020022557_797812.png', 16.83, 11.78, 5.05, 30, '', 'Maroon/4F0810', '4, 5, 6, 7, 8, 9', 0, 5, 0, '0', 0, 0, 0, 0, '0', 0, '1579856157', '', '', '', 1);
INSERT INTO `tbl_product` (`id`, `category_id`, `sub_category_id`, `brand_id`, `offer_id`, `product_title`, `product_slug`, `product_desc`, `product_features`, `featured_image`, `featured_image2`, `size_chart`, `product_mrp`, `selling_price`, `you_save_amt`, `you_save_per`, `other_color_product`, `color`, `product_size`, `product_quantity`, `max_unit_buy`, `delivery_charge`, `total_views`, `total_rate`, `rate_avg`, `is_featured`, `today_deal`, `today_deal_date`, `total_sale`, `created_at`, `seo_title`, `seo_meta_description`, `seo_keywords`, `status`) VALUES
(67, 10, 17, 0, 3, 'Boys & Girls Lace Sneakers  (Brown)', 'boys-girls-lace-sneakers-brown', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '<p><strong>Number of Pairs: </strong>1</p>\r\n\r\n<p><strong>Brand: </strong>Earton</p>\r\n\r\n<p><strong>Style Code: </strong>ORIFWSH-3105</p>\r\n\r\n<p><strong>Size: </strong>13C</p>\r\n\r\n<p><strong>Brand Color: </strong>Brown</p>\r\n\r\n<p><strong>Ideal For: </strong>Boys & Girls</p>\r\n\r\n<p><strong>Type: </strong>Casual Wear</p>\r\n\r\n<p><strong>Sub Type: </strong>Sneakers</p>\r\n\r\n<p><strong>Primary Color: </strong>Brown</p>\r\n\r\n<p><strong>Closure Type: </strong>Lace</p>\r\n\r\n<p><strong>Outer Material: </strong>Canvas</p>\r\n\r\n<p><strong>Sole Material: </strong>PVC</p>\r\n\r\n<p><strong>Character: </strong>None</p>\r\n\r\n<p><strong>Generic Name: </strong>Kids Shoe</p>\r\n', '24012020023120_79522.jpg', '24012020023120_795221.jpg', '24012020023120_795222.png', 28.04, 14.02, 14.02, 50, '', 'Brown/9E4E29', '11C, 12C, 13C, 1, 2, 3, 4', 0, 3, 0, '0', 0, 0, 0, 0, '0', 0, '1579856480', '', '', '', 1),
(68, 10, 17, 0, 5, 'Boys Lace Sneakers  (Dark Blue)', 'boys-lace-sneakers-dark-blue', 'Light weight sports shoe. Excellent for all kind of Sports, especially for Running, Training and Gym. Made of High Quality upper with durable sole.', '<p><strong>Number of Pairs: </strong>1</p>\r\n\r\n<p><strong>Brand: </strong>footstair </p>\r\n\r\n<p><strong>Style Code: </strong>65766</p>\r\n\r\n<p><strong>Size: </strong>6</p>\r\n\r\n<p><strong>Brand Color: </strong>Blue</p>\r\n\r\n<p><strong>Ideal For: </strong>Boys</p>\r\n\r\n<p><strong>Type: </strong>Casual Wear</p>\r\n\r\n<p><strong>Sub Type: </strong>Sneakers</p>\r\n\r\n<p><strong>Primary Color: </strong>Dark Blue</p>\r\n\r\n<p><strong>Closure Type: </strong>Lace</p>\r\n\r\n<p><strong>Outer Material: </strong>Fabric</p>\r\n\r\n<p><strong>Sole Material: </strong>PVC</p>\r\n\r\n<p><strong>Heel Design: </strong>Platform</p>\r\n\r\n<p><strong>Heel Height: </strong>Less Than 1 inch</p>\r\n\r\n<p><strong>Character: </strong>None</p>\r\n\r\n<p><strong>Care instructions: </strong>Rotate your pair of shoes once every other day, allowing them to de-odorize and retain their shapes. Use Shoe bags to prevent any stains or mildew.Dust any dry dirt from the surface using a clean cloth. Use Polish or Shiner</p>\r\n', '24012020030200_89048.jpg', '24012020030200_890481.jpg', '24012020030200_890482.png', 22.43, 17.6, 4.4, 20, '', 'Dark Blue/0E1020', '6, 7, 8, 9', 0, 5, 0, '0', 0, 0, 0, 0, '0', 0, '1579858321', '', '', '', 1),
(70, 13, 23, 0, 5, 'Nescafe Classic Coffee, 200g Jar with Free Red Mug and Scoop Spoon', 'nescafe-classic-coffee-200g-jar-with-free-red-mug-and-scoop-spoon', 'Coffee beans: To take your coffee experiences to the next level, NESCAFÉ, the worlds favorite instant coffee brand, brings forth a rich and aromatic coffee in the form of NESCAFÉ classic.', '<p>To take your coffee experiences to the next level, NESCAFÉ, the worlds favourite instant coffee brand, brings forth a rich and aromatic coffee in the form of NESCAFÉ classic. The unmistakable flavour of NESCAFÉ classic is what makes this signature coffee so loved all over the world. Start your day right with the first sip of this classic 100% pure coffee and let the intense taste and wonderfully refreshing aroma of NESCAFÉ instant coffee awaken your senses to new opportunities. With over 75 years of experience and working with coffee farmers, to help them grow more sustainable coffee through improved crop techniques, we deliver the best coffee produced by the best selecting, roasting and blending methods. Usage: simply follow the instructions on the back of the pack and mix the coffee powder with hot water or milk to get your own cup of premium instant coffee right at home. The fine coffee powder creates rich, frothy instant coffee that will make a coffee lover smile with sheer delight. Storage recommendation: do store the product in a cool, dry and hygienic place. To ensure lasting freshness, close the lid tightly after every use. Always use a dry spoon.</p>\r\n', '30012020120757_82227.jpg', '30012020120757_822271.jpg', '', 7, 5.6, 1.4, 20, '', 'White/FFFFFF', '', 0, 1, 0, '0', 0, 0, 0, 0, '0', 0, '1580366277', '', '', '', 1),
(71, 13, 23, 0, 6, 'Red Label Natural Care Cardamom, Ginger, Liquorice, Tulsi Tea Box  (500 g)', 'red-label-natural-care-cardamom-ginger-liquorice-tulsi-tea-box-500-g', 'Product information provided by the seller on the Website is not exhaustive, please read the label on the physical product carefully for complete information provided by the manufacturer. For additional information, please contact the manufacturer.', '<h3>General</h3>\r\n\r\n<table border=\"1\">\r\n <tbody>\r\n  <tr>\r\n   <td>Brand</td>\r\n   <td>\r\n   <ul>\r\n    <li>Red Label</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>Flavored Tea</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Model Name</td>\r\n   <td>\r\n   <ul>\r\n    <li>Natural Care</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Quantity</td>\r\n   <td>\r\n   <ul>\r\n    <li>500 g</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Pack Of</td>\r\n   <td>\r\n   <ul>\r\n    <li>1</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Tea Form</td>\r\n   <td>\r\n   <ul>\r\n    <li>Powder</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Flavor</td>\r\n   <td>\r\n   <ul>\r\n    <li>Cardamom, Ginger, Liquorice, Tulsi</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Organic</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Container Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>Box</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Maximum Shelf Life</td>\r\n   <td>\r\n   <ul>\r\n    <li>12 Months</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Common Name</td>\r\n   <td>\r\n   <ul>\r\n    <li>Brooke bond</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n', '30012020122140_42005.jpg', '30012020122140_420051.jpg', '', 10, 7, 3, 30, '', 'White/FFFFFF', '', 0, 2, 0, '0', 0, 0, 0, 0, '0', 0, '1580367100', '', '', '', 1),
(72, 13, 22, 0, 4, 'Cadbury Shots Truffles', 'cadbury-shots-truffles', 'Product information provided by the seller on the Website is not exhaustive, please read the label on the physical product carefully for complete information provided by the manufacturer. For additional information, please contact the manufacturer.', '<h3>General</h3>\r\n\r\n<table border=\\>\r\n <tbody>\r\n  <tr>\r\n   <td>Brand</td>\r\n   <td>\r\n   <ul>\r\n    <li>Cadbury</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Model Name</td>\r\n   <td>\r\n   <ul>\r\n    <li>Shots</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>Milk Chocolate</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Maximum Shelf Life</td>\r\n   <td>\r\n   <ul>\r\n    <li>365 Days</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Gourmet</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Homemade</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Gift Pack</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Food Preference</td>\r\n   <td>\r\n   <ul>\r\n    <li>Vegetarian</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n', '30012020123400_63532.jpg', '30012020123400_635321.jpg', '', 4, 3.8, 0.2, 5, '', 'White/FFFFFF', '', 0, 5, 0.5, '0', 0, 0, 0, 0, '0', 0, '1580367840', '', '', '', 1),
(73, 13, 22, 0, 5, 'Aadvik Camel Milk Chocolates (Pack Of 6) Combo OF All Flavors 300g Bars', 'aadvik-camel-milk-chocolates-pack-of-6-combo-of-all-flavors-300g-bars', 'Cocoa Solids, Almonds, Butterscotch, Chilli, Herbs, Salt, Rice Crisps, Dates, Milk Solids (Camel Milk Powder), Cocoa Butter, Sugar, Emulsifiers (INS322, INS476)', '<h3>In The Box</h3>\r\n\r\n<table border=\"1\">\r\n <tbody>\r\n  <tr>\r\n   <td>Pack of</td>\r\n   <td>\r\n   <ul>\r\n    <li>6</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3><br>\r\nGeneral</h3>\r\n\r\n<table border=\"\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Brand</td>\r\n   <td>\r\n   <ul>\r\n    <li>Aadvik</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Model Name</td>\r\n   <td>\r\n   <ul>\r\n    <li>Camel Milk Chocolates (Pack Of 6) Combo OF All Flavors 300g</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>Milk Chocolate</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Maximum Shelf Life</td>\r\n   <td>\r\n   <ul>\r\n    <li>6 Months</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Gourmet</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>With Nuts</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Homemade</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Gift Pack</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Food Preference</td>\r\n   <td>\r\n   <ul>\r\n    <li>Vegetarian </li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<p> </p>\r\n\r\n<h3>Important Note</h3>\r\n\r\n<table border=\"\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>\r\n   <ul>\r\n    <li>Product information provided by the seller on the Website is not exhaustive, please read the label on the physical product carefully for complete information provided by the manufacturer. For additional information, please contact the manufacturer.</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n', '30012020123836_9178.jpg', '30012020123836_91781.jpg', '', 8, 6.4, 1.6, 20, '', 'White/FFFFFF', '', 0, 3, 0.5, '0', 0, 0, 0, 0, '0', 0, '1580368116', '', '', '', 1),
(74, 13, 24, 0, 6, 'BIKAJI ALL-IN-ONE KUCH-KUCH 1KG,MOONG DAL 400G', 'bikaji-all-in-one-kuch-kuch-1kgmoong-dal-400g', 'THIS PRODUCT IS MADE IN A FACILITY THAT PROCESSES FOODS CONTAINING PEANUTS,TREE NUTS,SOY,MILK,WHEAT & SESAME.', '<h3>In The Box</h3>\r\n\r\n<table border=\"\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Pack of</td>\r\n   <td>\r\n   <ul>\r\n    <li>2</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Sales Package</td>\r\n   <td>\r\n   <ul>\r\n    <li>BIKAJI ALL-IN-ONE KUCH-KUCH 1KG, BIKAJI MOONG DAL 400G</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>General</h3>\r\n\r\n<table border=\"\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Brand</td>\r\n   <td>\r\n   <ul>\r\n    <li>BIKAJI</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Model Name</td>\r\n   <td>\r\n   <ul>\r\n    <li>ALL-IN-ONE KUCH-KUCH 1KG,MOONG DAL 400G</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Quantity</td>\r\n   <td>\r\n   <ul>\r\n    <li>1.4 kg</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>Namkeen</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Flavor</td>\r\n   <td>\r\n   <ul>\r\n    <li>SPICY, SWEET</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Taste</td>\r\n   <td>\r\n   <ul>\r\n    <li>Spicy</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Organic</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Added Preservatives</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Food Preference</td>\r\n   <td>\r\n   <ul>\r\n    <li>Vegetarian</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Maximum Shelf Life</td>\r\n   <td>\r\n   <ul>\r\n    <li>6 Months</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Container Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>Pouch</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Gourmet</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Regional Speciality</td>\r\n   <td>\r\n   <ul>\r\n    <li>Bikenari</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Ingredient</td>\r\n   <td>\r\n   <ul>\r\n    <li>PEANUTS,TREE NUTS,SOY,MILK,WHEAT & SESAME</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Oil Used</td>\r\n   <td>\r\n   <ul>\r\n    <li>EDIBLE VEGETABLE OIL</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Manufactured By</td>\r\n   <td>\r\n   <ul>\r\n    <li>K. BIKAJI FOODS INTERNATIONAL LTD</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Additional Features</h3>\r\n\r\n<table border=\"\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Certification</td>\r\n   <td>\r\n   <ul>\r\n    <li>FSSAI</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Dimensions</h3>\r\n\r\n<table border=\"\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Width</td>\r\n   <td>\r\n   <ul>\r\n    <li>15 cm</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Height</td>\r\n   <td>\r\n   <ul>\r\n    <li>20 cm</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Depth</td>\r\n   <td>\r\n   <ul>\r\n    <li>5 cm</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Important Note</h3>\r\n\r\n<table border=\"\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>\r\n   <ul>\r\n    <li>Product information provided by the seller on the Website is not exhaustive, please read the label on the physical product carefully for complete information provided by the manufacturer. For additional information, please contact the manufacturer.</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n', '30012020030754_49158.jpg', '30012020030754_491581.jpg', '', 10, 7, 3, 30, '', 'White/FFFFFF', '', 0, 2, 1, '0', 0, 0, 0, 0, '0', 0, '1580377074', '', '', '', 1),
(75, 13, 24, 0, 4, 'Early Foods Assorted Pack of 2 - Multigrain Millet & Ragi Amaranth Jaggery Cookies X 2', 'early-foods-assorted-pack-of-2-multigrain-millet-ragi-amaranth-jaggery-cookies-x-2', 'Recommended for little ones who are ready for all grains & nuts. Best if they have 1-2 teeth to chew. If not, you can always dip in milk to help them bite. These cookies are made from organically certified whole wheat, millets, pulses, Organic Jaggery, Indian grown cacao powder, superior quality dry fruits & seeds that add natural vitamin and mineral supplements to your child\'s diet. 2 Assorted Packs. Contains ~14 pieces each.', '<p>Recommended for little ones who are ready for all grains & nuts. Best if they have 1-2 teeth to chew. If not, you can always dip in milk to help them bite. These cookies are made from organically certified whole wheat, millets, pulses, Organic Jaggery, Indian grown cacao powder, superior quality dry fruits & seeds that add natural vitamin and mineral supplements to your child&#39;s diet. 2 Assorted Packs. Contains ~14 pieces each. How are Early Foods Cookies Different & Special? - Freshly prepared batch of jaggery cookies for little ones & grownup&#39;s once you order online. Because children need freshly made foods for maximum nutrient absorption - Made from Organically Certified Whole Grains and 0% Maida - No Baking Powder, No Soda, No Raising Agents, No Egg - 0% Sugar, Sweetness from Organic Jaggery and Dates - No hydrogenated fats. Made from pure cow butter. - No Preservatives or Artificial Flavours Ingredients: Organic Whole Grains (Ragi, Amaranth, Wheat, Bajra, Foxtail Millet, Proso Millet, Kodo Millet, Moong Dal), Cow Butter, Organic Jaggery, Dry Fruits (Almonds, Pista, Cashews, Dates, Walnuts, Watermelon Seeds, Sunflower Seeds), Milk. Shelf Life: Best before 2 months from MFD. Consume before 1 months from opening the pack. Best to store in a dry steel or glass air tight container. Why Moms love Early Foods: - Made from ancient Indian Super Foods - We make really small batches of food each day. So you can always feed super fresh meals. - Grandma inspired recipes, simple, healthy with minimal processing - No Sugar or salt. - No Preservatives, colours or artificial flavours. All Natural</p>\r\n', '30012020033354_33916.jpg', '30012020033354_339161.jpg', '', 9, 8.55, 0.45, 5, '', 'White/FFFFFF', '', 0, 10, 0, '0', 0, 0, 0, 0, '0', 0, '1580378634', '', '', '', 1),
(76, 11, 27, 0, 6, 'WOW Skin Science Red Onion Black Seed Oil Ultimate Hair Care Kit', 'wow-skin-science-red-onion-black-seed-oil-ultimate-hair-care-kit', 'Get strong and lustrous hair with WOW Skin Science Ultimate Onion Oil Hair Kit. This kit contains Onion Oil Shampoo, Onion Oil Conditioner and Onion Hair Oil which helps to revive your tired scalp and hair. Red onion extract, black seed oil aid in rejuvenating tired scalp and weak hair.', '<p>Get strong and lustrous hair with WOW Skin Science Ultimate Onion Oil Hair Kit. This kit contains Onion Oil Shampoo, Onion Oil Conditioner and Onion Hair Oil which helps to revive your tired scalp and hair. Red onion extract, black seed oil aid in rejuvenating tired scalp and weak hair. This red onion extract and black seed oil infused in the shampoo, conditioner & hair oil improves circulation to the scalp and roots. The ultimate kit works on your hair to cleanse away buildup and improve quality of strands. It helps to give strong, lustrous hair and keep it healthy. It aids in moisturizing the scalp and helps nourish the roots. Contains no parabens, sulphates, color or silicones and helps to deliver maximum benefit.</p>\r\n\r\n<h3>Specifications</h3>\r\n\r\n<table border=\\>\r\n <tbody>\r\n  <tr>\r\n   <td>Model Number</td>\r\n   <td>\r\n   <ul>\r\n    <li>8904311902621</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Sales Package</td>\r\n   <td>\r\n   <ul>\r\n    <li>3</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Ideal For</td>\r\n   <td>\r\n   <ul>\r\n    <li>Men & Women</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>Hair Care Combo</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n', '30012020033648_36267.jpg', '30012020033648_362671.jpg', '', 50, 35, 15, 30, '', 'White/FFFFFF', '', 0, 1, 1, '0', 0, 0, 0, 0, '0', 0, '1580378808', '', '', '', 1),
(77, 11, 27, 0, 4, 'L\'Oreal Paris Excellence Creme Hair Color  (Natural Darkest Brown 3)', 'loreal-paris-excellence-creme-hair-color-natural-darkest-brown-3', 'Loreal Paris gives women world over a reason to color their hair with this Excellence Cream. Made using Pro-Keratin, the Loreal Paris Excellence Cream Hair Color coats each strand with glossiness and shine and ensures that coloring your hair is a pleasurable experience. The special Pro-Keratin strengthens and revitalises your hair so that when you color it, you are assured of hair color that shines with all its brilliance. This Excellence Cream in the shade Burgundy – 3.16 is a rich shade that looks subtle yet radiant whether under artificial light or natural.  \r\n\r\nWith the Loreal Paris Cream Hair Color, you can easily cover all the greys as the non-drip and creamy texture thoroughly coats each strand with color and gives you a natural finish. This kit also includes a Pre-Color Protective Treatment, ideal for fragile hair to prepare your hair for the treatment and an After-Color Protective Conditioner to enhance the look of hair color. So the next time you step out into the sun, let your glossy hair steal the limelight.', '<h3>Specifications</h3>\r\n\r\n<h3>In The Box</h3>\r\n\r\n<table border=\"1\">\r\n <tbody>\r\n  <tr>\r\n   <td>Pack of</td>\r\n   <td>\r\n   <ul>\r\n    <li>1</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Sales Package</td>\r\n   <td>\r\n   <ul>\r\n    <li>Developer, Conditioner, Colouring Creme, Protective Serum</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<p>General</p>\r\n\r\n<table border=\"1\">\r\n <tbody>\r\n  <tr>\r\n   <td>Brand</td>\r\n   <td>\r\n   <ul>\r\n    <li>L&#39;Oreal Paris</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Model Name</td>\r\n   <td>\r\n   <ul>\r\n    <li>Excellence Creme</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Quantity</td>\r\n   <td>\r\n   <ul>\r\n    <li>100 g, 72 ml</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Brand Color</td>\r\n   <td>\r\n   <ul>\r\n    <li>Natural Darkest Brown 3</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Ammonia Free</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Ideal For</td>\r\n   <td>\r\n   <ul>\r\n    <li>Women</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Color</td>\r\n   <td>\r\n   <ul>\r\n    <li>Brown</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Container Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>Sachet</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Hair Color Form</td>\r\n   <td>\r\n   <ul>\r\n    <li>Cream</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Maximum Shelf Life</td>\r\n   <td>\r\n   <ul>\r\n    <li>32 Months</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Other Features</td>\r\n   <td>\r\n   <ul>\r\n    <li>Triple Care Color with Triple Care Formula, Stronger Hair, 85% more Resistant to Brushing, Rejuvenates Color, Clean and Easy Preparation, and Application, Non-drip Conditioning Formula, Rich, Even, Long-lasting Color with a Soft and Silky Touch, Long-lasting, Enriched with Pro-Keratin, 100% Grey Coverage from Root to Tip, Helps Replenish Hair, Strengthens and Revitalises Hair</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n', '30012020034006_74308.jpg', '30012020034006_743081.jpg', '', 15, 14.25, 0.75, 5, '', 'White/FFFFFF', '', 0, 5, 0, '0', 0, 0, 0, 0, '0', 0, '1580379006', '', '', '', 1),
(78, 11, 26, 0, 5, 'Meralite Beard Lite Hair Growth Oil Hair Oil  (35 ml)', 'meralite-beard-lite-hair-growth-oil-hair-oil-35-ml', 'Beard Growth Oil is a specially developed product that is 100% Natural and made with Pure Essential Oils. This beard oil contains an intricately hand crafted blend of oils like Argan Oil, Hemp Seed, Sunflower, Coconut, Avocado, Sandalwood, Lemon, Patchouli, Black Seed, Grapseed Essential Oil and much more that are rich in Vitamin A,B,E,K, Omega 9,6, 3 & linoleum acid which help increase blood circulation to the face to assist stronger and faster beard growth. The oils hydrate & strengthen the beard to make it thicker while simultaneously helping faster hair growth to deliver a beard like never before.', '<h3>In The Box</h3>\r\n\r\n<table border=\\>\r\n <tbody>\r\n  <tr>\r\n   <td>Pack of</td>\r\n   <td>\r\n   <ul>\r\n    <li>1</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Sales Package</td>\r\n   <td>\r\n   <ul>\r\n    <li>1</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>General</h3>\r\n\r\n<table border=\\>\r\n <tbody>\r\n  <tr>\r\n   <td>Brand</td>\r\n   <td>\r\n   <ul>\r\n    <li>Meralite</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Model Name</td>\r\n   <td>\r\n   <ul>\r\n    <li>Beard Lite Hair Growth Oil</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Quantity</td>\r\n   <td>\r\n   <ul>\r\n    <li>35 ml</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Ideal For</td>\r\n   <td>\r\n   <ul>\r\n    <li>Men</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Applied For</td>\r\n   <td>\r\n   <ul>\r\n    <li>Hair Growth, Hair Strengthening, Anti-hair Fall, Lustre & Shine, Conditioning, Hair Thickening, Stress Relief</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Organic</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>Beard Oil</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Sulfate Free</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Hair Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>All Hair Types</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Container Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>Bottle</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Maximum Shelf Life</td>\r\n   <td>\r\n   <ul>\r\n    <li>36 Months</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Composition</td>\r\n   <td>\r\n   <ul>\r\n    <li>Argan Oil, Hemp Seed, Sunflower, Coconut, Avocado, Sandalwood, Lemon, Patchouli, Black Seed, Grapseed Essential Oil</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n', '30012020034948_85062.jpg', '30012020034948_850621.jpg', '', 4, 3.2, 0.8, 20, '', 'White/FFFFFF', '', 0, 5, 0, '0', 0, 0, 0, 0, '0', 0, '1580379588', '', '', '', 1),
(79, 11, 26, 0, 1, 'Gillette Mach 3 Cartridge  (Pack of 10)', 'gillette-mach-3-cartridge-pack-of-10', 'Q: what is meaning 3 set n 8 cartridge\r\nA:Triple Blades in each and total set of 8', '<h3>Shaving Cartridge Traits</h3>\r\n\r\n<table border=\\>\r\n <tbody>\r\n  <tr>\r\n   <td>Number of Blades per Cartridges</td>\r\n   <td>\r\n   <ul>\r\n    <li>3</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Number of Cartridges</td>\r\n   <td>\r\n   <ul>\r\n    <li>10</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Precision Trimmer</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>General Traits</h3>\r\n\r\n<table border=\\>\r\n <tbody>\r\n  <tr>\r\n   <td>Ideal For</td>\r\n   <td>\r\n   <ul>\r\n    <li>Men</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n', '30012020035213_37557.jpg', '30012020035213_375571.jpg', '', 30, 15, 15, 50, '', 'White/FFFFFF', '', 0, 1, 0, '0', 0, 0, 0, 0, '0', 0, '1580379733', '', '', '', 1),
(80, 11, 25, 0, 5, 'Lakme Radiance Complexion Compact  (Natural Coral, 9 g)', 'lakme-radiance-complexion-compact-natural-coral-9-g', 'Give your smooth and soft skin a radiant glow with the Lakme Radiance Compact. This compact is enriched with Vitamin E and C that replenish your skin, thereby making you look gorgeous in no time.', '<p>Give your smooth and soft skin a radiant glow with the Lakme Radiance Compact. This compact is enriched with Vitamin E and C that replenish your skin, thereby making you look gorgeous in no time.</p>\r\n\r\n<p><strong>Soft and Smooth Skin</strong></p>\r\n\r\n<p>This compact with its advanced Micromesh and Allantoin complex formula makes your skin softer and smoother. The Micromesh technology ensures that your face gets a matte finish while the Allantoin complex protects your skin from pollution. </p>\r\n\r\n<p><strong>Easy to Carry</strong></p>\r\n\r\n<p>Don’t let go of glowing skin even when you are in a hurry as this compact can be easily carried in your bag.</p>\r\n\r\n<h3>General</h3>\r\n\r\n<table border=\\>\r\n <tbody>\r\n  <tr>\r\n   <td>Brand</td>\r\n   <td>\r\n   <ul>\r\n    <li>Lakme</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Model Name</td>\r\n   <td>\r\n   <ul>\r\n    <li>Radiance Complexion</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Quantity</td>\r\n   <td>\r\n   <ul>\r\n    <li>9 g</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Shade</td>\r\n   <td>\r\n   <ul>\r\n    <li>Natural Coral</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Maximum Shelf Life</td>\r\n   <td>\r\n   <ul>\r\n    <li>24 Months</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>SPF Rating</td>\r\n   <td>\r\n   <ul>\r\n    <li>NA</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Composition</td>\r\n   <td>\r\n   <ul>\r\n    <li>Allantoin Complex, Vitamin E and C</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Skin Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>All Skin Type</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Texture</td>\r\n   <td>\r\n   <ul>\r\n    <li>Compressed Powder</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Finish</td>\r\n   <td>\r\n   <ul>\r\n    <li>Matte</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Skin Tone</td>\r\n   <td>\r\n   <ul>\r\n    <li>Fair</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Additional Features</h3>\r\n\r\n<table border=\\>\r\n <tbody>\r\n  <tr>\r\n   <td>Other Features</td>\r\n   <td>\r\n   <ul>\r\n    <li>Moisturizes Skin, Protects from Pollution, Advanced Micromesh Technology</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n', '30012020035951_2768.jpg', '30012020035951_27681.jpg', '', 3, 2.4, 0.6, 20, '', 'White/FFFFFF', '', 0, 1, 0, '0', 0, 0, 0, 0, '0', 0, '1580380191', '', '', '', 1),
(81, 11, 25, 0, 6, 'Divas combo kit  (7 Items in the set)', 'divas-combo-kit-7-items-in-the-set', 'Facial Kit-Cream Nail Paints:Liquid Premium Lipsticks:Stick Compact Powder:Pressed Powder Foundation:Liquid Eyeliner:Liquid Kajal:Stick Mascara:Liquid', '<h3>Specifications</h3>\r\n\r\n<table border=\\>\r\n <tbody>\r\n  <tr>\r\n   <td>Model Number</td>\r\n   <td>\r\n   <ul>\r\n    <li>1lake 1lor 1eye 2baby 2maybelline</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Sales Package</td>\r\n   <td>\r\n   <ul>\r\n    <li>yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Ideal For</td>\r\n   <td>\r\n   <ul>\r\n    <li>Women</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>Beauty Accessories Combo</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Gift Pack</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n', '30012020040619_69372.jpg', '30012020040619_693721.jpg', '', 10, 7, 3, 30, '', 'White/FFFFFF', '', 0, 10, 0, '0', 0, 0, 0, 0, '0', 0, '1580380579', '', '', '', 1),
(82, 9, 15, 0, 5, 'Alloy Gold-plated Kada', 'alloy-gold-plated-kada', '24K gold plating, Style: Trendy , Finish: Gold Plated, Metal :Alloy, Colour:Gold, Gender: Male, Avoid From Contact Of Organic Chemicals I.E. Perfume, Sprays, Water.Avoid Using Velvet Boxes For Storing Jewellery.', '<ul>\r\n <li>Material:Alloy</li>\r\n <li>Plating:Gold Plated</li>\r\n <li>Stones Used:None</li>\r\n <li>Color:Golden</li>\r\n <li>Type:Sikh Kada</li>\r\n <li>Gross Weight (in grams):30</li>\r\n <li>Jewellery Care:Keep it away from perfumes & sprays</li>\r\n <li>Disclaimer:Product colour may slightly vary due to photographic lighting sources or your monitor settings</li>\r\n <li>SUPC: SDL810367249</li>\r\n</ul>\r\n', '30012020042006_68838.jpg', '30012020042006_688381.jpg', '', 6, 4.8, 1.2, 20, '', 'gold/FFC10F', '', 0, 1, 0, '0', 0, 0, 0, 0, '0', 0, '1580381406', '', '', '', 1),
(83, 9, 15, 0, 6, 'Stainless Steel, Metal Gold-plated, Titanium Bracelet', 'stainless-steel-metal-gold-plated-titanium-bracelet', 'Bio Magnetic Bracelet for help to Blood Circulation by develop a Magnetic field . This Bio magnetic Bracelet Protect your Health with style. The Plating Is Non-Allergic And Safe For All Environments . You can adjust Bio Magnetic Energy Bracelet length as per the size of your wrist simply by removing Links at any watch repairing shop . This titanium magnetic therapy bracelet is Suitable For Both Men & women . Controlling high blood pressure and diabetes . Providing relief from arthritis , Joint and Muscles Pain . Increase Imagination and will power . Stress , headache , migraine , insomnia . Treating constipation , indigestion , acidity . Increase power , improving blood circulation and boosting body immunity levels.', '<p>Model Name:<strong> </strong>Bio Magnetic Bracelet</p>\r\n\r\n<p>Model Number: SHT5260</p>\r\n\r\n<p>Ideal For: Men, Boys, Girls, Women</p>\r\n\r\n<p>Type: Bracelet</p>\r\n\r\n<p>Color: Silver, Gold</p>\r\n\r\n<p>Base Material: Stainless Steel, Metal</p>\r\n\r\n<p>Bangle Size: Free</p>\r\n\r\n<p>Stretchable: No</p>\r\n\r\n<p>Adjustable Length: Yes</p>\r\n\r\n<p>Pack of: 1</p>\r\n\r\n<p>Occasion: Everyday</p>\r\n\r\n<p>Plating: Gold-plated, Titanium</p>\r\n\r\n<p>Clasp: Magnetic Clasp</p>\r\n\r\n<p>Body Structure: Open</p>\r\n\r\n<p>Design: Ball</p>\r\n\r\n<p>Occasion: Everyday</p>\r\n\r\n<p>Width: 205 mm</p>\r\n\r\n<p>Diameter: 8.10 inch</p>\r\n\r\n<p>Weight: 55 g</p>\r\n', '30012020043656_78861.jpg', '30012020043656_788611.jpg', '', 20, 14, 6, 30, '', 'Silver/E8E8E8', '', 0, 2, 0.5, '0', 0, 0, 0, 0, '0', 0, '1580382416', '', '', '', 1),
(84, 9, 16, 0, 5, 'Alloy Jewel Set  (Gold)', 'alloy-jewel-set-gold', 'Apara Fashion Jewelry brings to you the Exquisite, Fine crated Classic Designer Jewelry to Enhance your Natural Graceful Elegance. Women Love Jewelry as it not only enhances their beauty, but also gives them the social confidence. Festivals and celebrations are part of Indian culture and women like to traditionally dress themselves with latest trends in Jewelry and Apara exactly fulfills that need for the occasion. The Jewelry is made keeping in mind the Women ; who is today modern yet connected to our traditional values.', '<p>Model Number: RC1N407N71R</p>\r\n\r\n<p>Base Material: Alloy</p>\r\n\r\n<p>Color: Gold</p>\r\n\r\n<p>Type: Necklace, Earring & Maang Tikka Set</p>\r\n\r\n<p>Ideal For: Girls, Women</p>\r\n\r\n<p>Plating: Gold-plated</p>\r\n\r\n<p>Gemstone: Amber</p>\r\n\r\n<p>Sales Package: 2 Necklace, 2 Maang Tikka, 2 Pair of Earrings</p>\r\n\r\n<p>Collection: Ethnic</p>\r\n\r\n<p>Occasion: Wedding & Engagement</p>\r\n\r\n<p>Pearl Type: Cultured</p>\r\n', '30012020044544_75586.jpg', '30012020044544_755861.jpg', '', 15, 12, 3, 20, '', 'Gold/FFB147', '', 0, 3, 0, '0', 0, 0, 0, 0, '0', 0, '1580382944', '', '', '', 1),
(85, 4, 5, 0, 4, 'Decorasia Hexagon Shape Wood Wall Shelf  (Number of Shelves - 6, Brown, Orange)', 'decorasia-hexagon-shape-wood-wall-shelf-number-of-shelves-6-brown-orange', 'This Hexagon Shelf unit is the ultimate stylish yet functional piece for your living space. It offers a surprising amount of space for storing books, pictures and other decorative items. Plus it just looks really cool. Made in the mid century modern style, with clean lines and an interesting geometric shape, it transforms your room just by being there. These Shelves can be arranged in any order to make a desired look of your choice. This product is made of high quality Laminated MDF which is a substitute for wood. There are two large, medium, and small shelves, each measuring 11 x 11 x 4 inches, 9 x 9 x 4 inches and 7 x 7 x 4 inches, respectively. A one stop shop for home décor and furniture.', '<h3>In The Box</h3>\r\n\r\n<table border=\\>\r\n <tbody>\r\n  <tr>\r\n   <td>Sales Package</td>\r\n   <td>\r\n   <ul>\r\n    <li>6 Wall Shelf</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Pack of</td>\r\n   <td>\r\n   <ul>\r\n    <li>6</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>General</h3>\r\n\r\n<table border=\\>\r\n <tbody>\r\n  <tr>\r\n   <td>Brand</td>\r\n   <td>\r\n   <ul>\r\n    <li>Decorasia</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Model Number</td>\r\n   <td>\r\n   <ul>\r\n    <li>DWS101</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Model Name</td>\r\n   <td>\r\n   <ul>\r\n    <li>Hexagon Shape</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Color</td>\r\n   <td>\r\n   <ul>\r\n    <li>Brown, Orange</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Material</td>\r\n   <td>\r\n   <ul>\r\n    <li>Wood</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Suitable For</td>\r\n   <td>\r\n   <ul>\r\n    <li>Living Room & Bedroom</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Body & Design Features</h3>\r\n\r\n<table border=\\>\r\n <tbody>\r\n  <tr>\r\n   <td>Number of Shelves</td>\r\n   <td>\r\n   <ul>\r\n    <li>6</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Mount Mechanism</td>\r\n   <td>\r\n   <ul>\r\n    <li>Hanging</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Additional Features</h3>\r\n\r\n<table border=\\>\r\n <tbody>\r\n  <tr>\r\n   <td>Rust Proof</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Other Features</td>\r\n   <td>\r\n   <ul>\r\n    <li>No Assembly Required</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Dimensions</h3>\r\n\r\n<table border=\\>\r\n <tbody>\r\n  <tr>\r\n   <td>Width</td>\r\n   <td>\r\n   <ul>\r\n    <li>10 inch</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Height</td>\r\n   <td>\r\n   <ul>\r\n    <li>3.5 inch</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Other Dimensions</td>\r\n   <td>\r\n   <ul>\r\n    <li>Large Shelf: 11 x10 x3.5,, Medium Shelf :- 9 x8 x3.5,, Small Shelf: 7x6x3.5</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Warranty</h3>\r\n\r\n<table border=\\>\r\n <tbody>\r\n  <tr>\r\n   <td>Warranty Summary</td>\r\n   <td>\r\n   <ul>\r\n    <li>1 Year Manufacture Warranty</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Covered in Warranty</td>\r\n   <td>\r\n   <ul>\r\n    <li>manufacture defect</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Not Covered in Warranty</td>\r\n   <td>\r\n   <ul>\r\n    <li>Damage By Customer Mistake</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Warranty Service Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>Manufacture Warranty</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n', '30012020045637_53709.jpg', '30012020045637_537091.jpg', '', 17, 16.15, 0.85, 5, '', 'Coffee/782E17', '', 0, 5, 0, '0', 0, 0, 0, 0, '0', 0, '1580383597', '', '', '', 1),
(86, 1, 20, 0, 5, 'Asus ROG Strix G Core i7 9th Gen - (16 GB/512 GB SSD/Windows 10 Home/4 GB Graphics/NVIDIA Geforce GTX 1650) G531GT-AL018T Gaming Laptop  (15.6 inch, Black, 2.4 kg)', 'asus-rog-strix-g-core-i7-9th-gen-16-gb512-gb-ssdwindows-10-home4-gb-graphicsnvidia-geforce-gtx-1650-g531gt-al018t-gaming-laptop-156-inch-black-24-kg', 'This ASUS Core i7 9th Gen Gaming Laptop is equipped with the NVIDIA GeForce GTX 1650 Graphics Processor and enables stunning visuals, which make you lose yourself in your favourite game. Its dedicated GPU power helps you engage in creative multitasking so that you can be your productive best.', '<h3>General</h3>\r\n\r\n<table border=\"\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Sales Package</td>\r\n   <td>\r\n   <ul>\r\n    <li>Laptop, Power Adaptor, User Guide, Warranty Documents</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Model Number</td>\r\n   <td>\r\n   <ul>\r\n    <li>G531GT-AL018T</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Part Number</td>\r\n   <td>\r\n   <ul>\r\n    <li>90NR01L3-M03820</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Series</td>\r\n   <td>\r\n   <ul>\r\n    <li>ROG Strix G</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Color</td>\r\n   <td>\r\n   <ul>\r\n    <li>Black</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>Gaming Laptop</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Suitable For</td>\r\n   <td>\r\n   <ul>\r\n    <li>Gaming, Processing & Multitasking</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Power Supply</td>\r\n   <td>\r\n   <ul>\r\n    <li>150 W AC Adapter</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Battery Cell</td>\r\n   <td>\r\n   <ul>\r\n    <li>3 cell</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>MS Office Provided</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Processor And Memory Features</h3>\r\n\r\n<table border=\"\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Dedicated Graphic Memory Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>GDDR5</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Dedicated Graphic Memory Capacity</td>\r\n   <td>\r\n   <ul>\r\n    <li>4 GB</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Processor Brand</td>\r\n   <td>\r\n   <ul>\r\n    <li>Intel</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Processor Name</td>\r\n   <td>\r\n   <ul>\r\n    <li>Core i7</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Processor Generation</td>\r\n   <td>\r\n   <ul>\r\n    <li>9th Gen</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>SSD</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>SSD Capacity</td>\r\n   <td>\r\n   <ul>\r\n    <li>512 GB</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>RAM</td>\r\n   <td>\r\n   <ul>\r\n    <li>16 GB</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>RAM Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>DDR4</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Processor Variant</td>\r\n   <td>\r\n   <ul>\r\n    <li>9750H</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Chipset</td>\r\n   <td>\r\n   <ul>\r\n    <li>Intel HM370 Express</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Clock Speed</td>\r\n   <td>\r\n   <ul>\r\n    <li>2.6 GHz with Turbo Boost Upto 4.5 GHz</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Memory Slots</td>\r\n   <td>\r\n   <ul>\r\n    <li>2 Slots</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Expandable Memory</td>\r\n   <td>\r\n   <ul>\r\n    <li>Upto 32 GB</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>RAM Frequency</td>\r\n   <td>\r\n   <ul>\r\n    <li>2666 MHz</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Cache</td>\r\n   <td>\r\n   <ul>\r\n    <li>12 MB</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Graphic Processor</td>\r\n   <td>\r\n   <ul>\r\n    <li>NVIDIA Geforce GTX 1650</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Number of Cores</td>\r\n   <td>\r\n   <ul>\r\n    <li>6</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Operating System</h3>\r\n\r\n<table border=\"\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>OS Architecture</td>\r\n   <td>\r\n   <ul>\r\n    <li>64 bit</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Operating System</td>\r\n   <td>\r\n   <ul>\r\n    <li>Windows 10 Home</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>System Architecture</td>\r\n   <td>\r\n   <ul>\r\n    <li>64 bit</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Port And Slot Features</h3>\r\n\r\n<table border=\"\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Mic In</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>RJ45</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>USB Port</td>\r\n   <td>\r\n   <ul>\r\n    <li>3 x USB 3.1</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>HDMI Port</td>\r\n   <td>\r\n   <ul>\r\n    <li>1 x HDMI Port (v2.0)</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Display And Audio Features</h3>\r\n\r\n<table border=\"\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Touchscreen</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Screen Size</td>\r\n   <td>\r\n   <ul>\r\n    <li>39.62 cm (15.6 inch)</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Screen Resolution</td>\r\n   <td>\r\n   <ul>\r\n    <li>1920 x 1080 Pixel</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Screen Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>Full HD LED Backlit Anti-glare IPS Display (With 120 Hz Refresh Rate)</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Speakers</td>\r\n   <td>\r\n   <ul>\r\n    <li>Built-in Dual Speakers</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Internal Mic</td>\r\n   <td>\r\n   <ul>\r\n    <li>Built-in Array Microphone</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Sound Properties</td>\r\n   <td>\r\n   <ul>\r\n    <li>2 x 1.5 W Speakers</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Connectivity Features</h3>\r\n\r\n<table border=\"\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Wireless LAN</td>\r\n   <td>\r\n   <ul>\r\n    <li>IEEE 802.11ac</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Bluetooth</td>\r\n   <td>\r\n   <ul>\r\n    <li>v5.0</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Ethernet</td>\r\n   <td>\r\n   <ul>\r\n    <li>10/100/1000 Mbps</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Dimensions</h3>\r\n\r\n<table border=\"\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Dimensions</td>\r\n   <td>\r\n   <ul>\r\n    <li>360 x 275 x 25.8 mm</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Weight</td>\r\n   <td>\r\n   <ul>\r\n    <li>2.4 kg</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Additional Features</h3>\r\n\r\n<table border=\"\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Disk Drive</td>\r\n   <td>\r\n   <ul>\r\n    <li>Not Available</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Keyboard</td>\r\n   <td>\r\n   <ul>\r\n    <li>Illuminated Chiclet RGB Keyboard</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Backlit Keyboard</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Pointer Device</td>\r\n   <td>\r\n   <ul>\r\n    <li>Touchpad</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Included Software</td>\r\n   <td>\r\n   <ul>\r\n    <li>GameFirst, GameVisual, Sonic Studio</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Additional Features</td>\r\n   <td>\r\n   <ul>\r\n    <li>Li-ion Battery</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Warranty</h3>\r\n\r\n<table border=\"\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Warranty Summary</td>\r\n   <td>\r\n   <ul>\r\n    <li>1 Year Limited International Hardware Warranty</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Warranty Service Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>Onsite</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Covered in Warranty</td>\r\n   <td>\r\n   <ul>\r\n    <li>Manufacturing Defects</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Not Covered in Warranty</td>\r\n   <td>\r\n   <ul>\r\n    <li>Physical Damage</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Domestic Warranty</td>\r\n   <td>\r\n   <ul>\r\n    <li>1 Year</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>International Warranty</td>\r\n   <td>\r\n   <ul>\r\n    <li>1 Year</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n', '30012020050115_84444.jpg', '30012020050115_844441.jpg', '', 300, 240, 60, 20, '', 'black/292929', '', 0, 5, 0, '0', 0, 0, 0, 0, '0', 0, '1580383875', '', '', '', 1);
INSERT INTO `tbl_product` (`id`, `category_id`, `sub_category_id`, `brand_id`, `offer_id`, `product_title`, `product_slug`, `product_desc`, `product_features`, `featured_image`, `featured_image2`, `size_chart`, `product_mrp`, `selling_price`, `you_save_amt`, `you_save_per`, `other_color_product`, `color`, `product_size`, `product_quantity`, `max_unit_buy`, `delivery_charge`, `total_views`, `total_rate`, `rate_avg`, `is_featured`, `today_deal`, `today_deal_date`, `total_sale`, `created_at`, `seo_title`, `seo_meta_description`, `seo_keywords`, `status`) VALUES
(87, 1, 20, 0, 5, 'Apple MacBook Air Core i5 5th Gen - (8 GB/128 GB SSD/Mac OS Sierra) MQD32HN/A A1466  (13.3 inch, Silver, 1.35 kg)', 'apple-macbook-air-core-i5-5th-gen-8-gb128-gb-ssdmac-os-sierra-mqd32hna-a1466-133-inch-silver-135-kg', 'It is fun to use, it is powerful and it looks incredible, meet the Apple MacBook Air. This Sleek and Lightweight laptop is powered by Intel Core i5 5th Gen processor with 8 GB DDR3 RAM and 128 GB of SSD capacity to make multitasking smooth and easy. It is designed with a Backlit Keyboard and its Multi-Touch Trackpad will be an absolute pleasure to use.', '<h3>General</h3>\r\n\r\n<table border=\"\\\\\\\\\\\\\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Sales Package</td>\r\n   <td>\r\n   <ul>\r\n    <li>Laptop, Battery, Power Adaptor, User Guide, Warranty Documents</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Model Number</td>\r\n   <td>\r\n   <ul>\r\n    <li>MQD32HN/A A1466</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Part Number</td>\r\n   <td>\r\n   <ul>\r\n    <li>MQD32HN/A</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Series</td>\r\n   <td>\r\n   <ul>\r\n    <li>MacBook Air</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Color</td>\r\n   <td>\r\n   <ul>\r\n    <li>Silver</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>Thin and Light Laptop</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Suitable For</td>\r\n   <td>\r\n   <ul>\r\n    <li>Travel & Business, Processing & Multitasking</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Battery Backup</td>\r\n   <td>\r\n   <ul>\r\n    <li>Upto 12 hours</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Power Supply</td>\r\n   <td>\r\n   <ul>\r\n    <li>45 W MagSafe 2 Power Adapter</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>MS Office Provided</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Processor And Memory Features</h3>\r\n\r\n<table border=\"\\\\\\\\\\\\\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Processor Brand</td>\r\n   <td>\r\n   <ul>\r\n    <li>Intel</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Processor Name</td>\r\n   <td>\r\n   <ul>\r\n    <li>Core i5</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Processor Generation</td>\r\n   <td>\r\n   <ul>\r\n    <li>5th Gen</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>SSD</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>SSD Capacity</td>\r\n   <td>\r\n   <ul>\r\n    <li>128 GB</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>RAM</td>\r\n   <td>\r\n   <ul>\r\n    <li>8 GB</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>RAM Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>DDR3</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Clock Speed</td>\r\n   <td>\r\n   <ul>\r\n    <li>1.8 GHz with Turbo Boost Upto 2.9 GHz</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>RAM Frequency</td>\r\n   <td>\r\n   <ul>\r\n    <li>1600 MHz</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Cache</td>\r\n   <td>\r\n   <ul>\r\n    <li>3 MB</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Graphic Processor</td>\r\n   <td>\r\n   <ul>\r\n    <li>Intel Integrated HD 6000</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Operating System</h3>\r\n\r\n<table border=\"\\\\\\\\\\\\\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>OS Architecture</td>\r\n   <td>\r\n   <ul>\r\n    <li>64 bit</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Operating System</td>\r\n   <td>\r\n   <ul>\r\n    <li>Mac OS Sierra</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>System Architecture</td>\r\n   <td>\r\n   <ul>\r\n    <li>64 bit</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Port And Slot Features</h3>\r\n\r\n<table border=\"\\\\\\\\\\\\\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Mic In</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>USB Port</td>\r\n   <td>\r\n   <ul>\r\n    <li>2 x USB 3.0, 2 x Thunderbolt 2.0</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Multi Card Slot</td>\r\n   <td>\r\n   <ul>\r\n    <li>SDXC Card Reader</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Display And Audio Features</h3>\r\n\r\n<table border=\"\\\\\\\\\\\\\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Touchscreen</td>\r\n   <td>\r\n   <ul>\r\n    <li>No</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Screen Size</td>\r\n   <td>\r\n   <ul>\r\n    <li>33.78 cm (13.3 inch)</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Screen Resolution</td>\r\n   <td>\r\n   <ul>\r\n    <li>1440 x 900 Pixel</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Screen Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>HD+ LED Backlit Display</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Speakers</td>\r\n   <td>\r\n   <ul>\r\n    <li>Built-in Speakers</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Internal Mic</td>\r\n   <td>\r\n   <ul>\r\n    <li>Dual Microphones</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Sound Properties</td>\r\n   <td>\r\n   <ul>\r\n    <li>Stereo Speakers</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Connectivity Features</h3>\r\n\r\n<table border=\"\\\\\\\\\\\\\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Wireless LAN</td>\r\n   <td>\r\n   <ul>\r\n    <li>IEEE 802.11ac</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Bluetooth</td>\r\n   <td>\r\n   <ul>\r\n    <li>v4.0</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Dimensions</h3>\r\n\r\n<table border=\"\\\\\\\\\\\\\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Dimensions</td>\r\n   <td>\r\n   <ul>\r\n    <li>325 x 227 x 17 mm</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Weight</td>\r\n   <td>\r\n   <ul>\r\n    <li>1.35 kg</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Additional Features</h3>\r\n\r\n<table border=\"\\\\\\\\\\\\\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Disk Drive</td>\r\n   <td>\r\n   <ul>\r\n    <li>Not Available</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Web Camera</td>\r\n   <td>\r\n   <ul>\r\n    <li>720p FaceTime HD Camera</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Keyboard</td>\r\n   <td>\r\n   <ul>\r\n    <li>Full-size Backlit Keyboard</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Backlit Keyboard</td>\r\n   <td>\r\n   <ul>\r\n    <li>Yes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Pointer Device</td>\r\n   <td>\r\n   <ul>\r\n    <li>Multi-touch Trackpad</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Included Software</td>\r\n   <td>\r\n   <ul>\r\n    <li>Built-in Apps: Siri, Safari, App Store, iMovie, GarageBand, Keynote, FaceTime, iBooks, iTunes</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Additional Features</td>\r\n   <td>\r\n   <ul>\r\n    <li>Lithium Polymer Battery</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<h3>Warranty</h3>\r\n\r\n<table border=\"\\\\\\\\\\\\\\\\\">\r\n <tbody>\r\n  <tr>\r\n   <td>Warranty Summary</td>\r\n   <td>\r\n   <ul>\r\n    <li>1 Year Carry In Warranty</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Warranty Service Type</td>\r\n   <td>\r\n   <ul>\r\n    <li>Carry In</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Covered in Warranty</td>\r\n   <td>\r\n   <ul>\r\n    <li>Manufacturing Defects</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Not Covered in Warranty</td>\r\n   <td>\r\n   <ul>\r\n    <li>Physical Damages</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Domestic Warranty</td>\r\n   <td>\r\n   <ul>\r\n    <li>1 Year</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>International Warranty</td>\r\n   <td>\r\n   <ul>\r\n    <li>1 Year</li>\r\n   </ul>\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n', '30012020051034_78366.jpg', '30012020051034_783661.jpg', '', 200, 160, 40, 20, '', 'White/FFFFFF', '', 0, 1, 0, '0', 0, 0, 0, 0, '0', 0, '1580384434', 'Apple MacBook Air Core i5 5th Gen - (8 GB/128 GB SSD/Mac OS Sierra) MQD32HN/A A1466  (13.3 inch, Silver, 1.35 kg)', 'Apple MacBook Air Core i5 5th Gen - (8 GB/128 GB SSD/Mac OS Sierra) MQD32HN/A A1466  (13.3 inch, Silver, 1.35 kg)', 'Apple,8 GB/128 GB SSD/Mac OS Sierra,MQD32HN/A A1466,MacBook Air Core i5 5th Gen', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_images`
--

CREATE TABLE `tbl_product_images` (
  `id` int(10) NOT NULL,
  `parent_id` int(10) NOT NULL,
  `image_file` text NOT NULL,
  `type` varchar(60) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_product_images`
--

INSERT INTO `tbl_product_images` (`id`, `parent_id`, `image_file`, `type`, `status`) VALUES
(1, 1, '25102019041609_3624_2_.jpg', 'product', 1),
(2, 1, '25102019041609_84776_2_.jpg', 'product', 1),
(3, 1, '25102019041925_89155_2_.jpg', 'product', 1),
(4, 1, '25102019041925_46825_2_.jpg', 'product', 1),
(5, 1, '25102019041925_63164_2_.jpg', 'product', 1),
(6, 1, '25102019041926_15427_2_.jpg', 'product', 1),
(7, 1, '25102019041926_33413_2_.jpg', 'product', 1),
(8, 1, '25102019041926_26994_2_.jpg', 'product', 1),
(9, 5, '25102019043521_8701_2_.jpg', 'product', 1),
(10, 5, '25102019043521_8701_2_1.jpg', 'product', 1),
(11, 5, '25102019043521_8701_2_2.jpg', 'product', 1),
(12, 5, '25102019043521_8701_2_3.jpg', 'product', 1),
(13, 5, '25102019043521_8701_2_4.jpg', 'product', 1),
(14, 5, '25102019043521_8701_2_5.jpg', 'product', 1),
(15, 3, '25102019044132_42979_2_.jpg', 'product', 1),
(16, 3, '25102019044132_40690_2_.jpg', 'product', 1),
(17, 3, '25102019044132_35582_2_.jpg', 'product', 1),
(18, 3, '25102019044132_80229_2_.jpg', 'product', 1),
(19, 3, '25102019044132_46933_2_.jpg', 'product', 1),
(20, 3, '25102019044132_27725_2_.jpg', 'product', 1),
(21, 3, '25102019044133_71274_2_.jpg', 'product', 1),
(22, 3, '25102019044133_16782_2_.jpg', 'product', 1),
(23, 3, '25102019044133_13428_2_.jpg', 'product', 1),
(24, 4, '25102019053946_85368_2_.jpg', 'product', 1),
(25, 4, '25102019053946_14227_2_.jpg', 'product', 1),
(26, 4, '25102019053946_19100_2_.jpg', 'product', 1),
(27, 4, '25102019053946_62336_2_.jpg', 'product', 1),
(34, 8, '07112019043756_2047_2_.jpg', 'product', 1),
(35, 8, '07112019043756_2047_2_1.jpg', 'product', 1),
(36, 8, '07112019043756_2047_2_2.jpg', 'product', 1),
(37, 8, '07112019043756_2047_2_3.jpg', 'product', 1),
(38, 9, '07112019044349_88144_2_.jpg', 'product', 1),
(39, 9, '07112019044349_88144_2_1.jpg', 'product', 1),
(40, 9, '07112019044349_88144_2_2.jpg', 'product', 1),
(41, 9, '07112019044349_88144_2_3.jpg', 'product', 1),
(42, 9, '07112019044349_88144_2_4.jpg', 'product', 1),
(43, 9, '07112019044349_88144_2_5.jpg', 'product', 1),
(44, 9, '07112019044349_88144_2_6.jpg', 'product', 1),
(45, 9, '07112019044349_88144_2_7.jpg', 'product', 1),
(46, 9, '07112019044349_88144_2_8.jpg', 'product', 1),
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
(95, 22, '11122019042549_97888.jpg', 'product', 1),
(96, 22, '11122019042549_978881.jpg', 'product', 1),
(97, 22, '11122019042549_978882.jpg', 'product', 1),
(154, 23, '30122019101543_47539.jpeg', 'product', 1),
(155, 23, '30122019101543_475391.jpeg', 'product', 1),
(161, 24, '01012020035823_3022.jpg', 'product', 1),
(162, 24, '01012020035823_30221.jpg', 'product', 1),
(163, 24, '01012020035823_30222.jpg', 'product', 1),
(164, 24, '01012020035823_30223.jpg', 'product', 1),
(165, 24, '01012020035823_30224.jpg', 'product', 1),
(166, 24, '01012020035823_30225.jpg', 'product', 1),
(167, 25, '01012020041454_30717.jpg', 'product', 1),
(168, 25, '01012020041454_307171.jpg', 'product', 1),
(169, 25, '01012020041454_307172.jpg', 'product', 1),
(170, 25, '01012020041454_307173.jpg', 'product', 1),
(171, 25, '01012020041454_307174.jpg', 'product', 1),
(172, 25, '01012020041454_307175.jpg', 'product', 1),
(173, 25, '01012020041454_307176.jpg', 'product', 1),
(174, 25, '01012020041454_307177.jpg', 'product', 1),
(175, 25, '01012020041454_307178.jpg', 'product', 1),
(176, 26, '01012020042007_4927.jpg', 'product', 1),
(177, 26, '01012020042007_49271.jpg', 'product', 1),
(178, 26, '01012020042007_49272.jpg', 'product', 1),
(179, 26, '01012020042007_49273.jpg', 'product', 1),
(180, 26, '01012020042007_49274.jpg', 'product', 1),
(181, 26, '01012020042007_49275.jpg', 'product', 1),
(182, 26, '01012020042007_49276.jpg', 'product', 1),
(183, 26, '01012020042007_49277.jpg', 'product', 1),
(184, 26, '01012020042007_49278.jpg', 'product', 1),
(185, 26, '01012020042007_49279.jpg', 'product', 1),
(186, 27, '01012020042657_12871.jpg', 'product', 1),
(187, 27, '01012020042657_128711.jpg', 'product', 1),
(188, 28, '01012020060018_88421.jpg', 'product', 1),
(189, 28, '01012020060018_884211.jpg', 'product', 1),
(190, 28, '01012020060018_884212.jpg', 'product', 1),
(191, 28, '01012020060018_884213.jpg', 'product', 1),
(192, 28, '01012020060018_884214.jpg', 'product', 1),
(193, 28, '01012020060018_884215.jpg', 'product', 1),
(194, 28, '01012020060018_884216.jpg', 'product', 1),
(205, 30, '09012020041516_67337.jpg', 'product', 1),
(206, 30, '09012020041516_673371.jpg', 'product', 1),
(207, 30, '09012020041516_673372.jpg', 'product', 1),
(208, 30, '09012020041516_673373.jpg', 'product', 1),
(209, 31, '09012020042505_19858.jpg', 'product', 1),
(210, 31, '09012020042505_198581.jpg', 'product', 1),
(211, 31, '09012020042505_198582.jpg', 'product', 1),
(212, 31, '09012020042505_198583.jpg', 'product', 1),
(213, 32, '09012020043156_59802.jpg', 'product', 1),
(214, 32, '09012020043156_598021.jpg', 'product', 1),
(215, 32, '09012020043156_598022.jpg', 'product', 1),
(216, 32, '09012020043156_598023.jpg', 'product', 1),
(217, 33, '09012020043932_86109.jpg', 'product', 1),
(218, 33, '09012020043932_861091.jpg', 'product', 1),
(219, 33, '09012020043932_861092.jpg', 'product', 1),
(220, 33, '09012020043932_861093.jpg', 'product', 1),
(221, 34, '09012020051411_41796.jpg', 'product', 1),
(222, 34, '09012020051411_417961.jpg', 'product', 1),
(223, 35, '10012020095305_7281.jpg', 'product', 1),
(224, 36, '10012020095647_23026.jpg', 'product', 1),
(225, 36, '10012020095647_230261.jpg', 'product', 1),
(226, 37, '10012020100844_41250.jpg', 'product', 1),
(227, 37, '10012020100844_412501.jpg', 'product', 1),
(228, 37, '10012020100844_412502.jpg', 'product', 1),
(229, 37, '10012020100844_412503.jpg', 'product', 1),
(230, 38, '10012020101913_5142.jpg', 'product', 1),
(231, 38, '10012020101913_51421.jpg', 'product', 1),
(232, 38, '10012020101913_51422.jpg', 'product', 1),
(233, 38, '10012020101913_51423.jpg', 'product', 1),
(234, 39, '10012020104042_23146.jpg', 'product', 1),
(235, 39, '10012020104042_231461.jpg', 'product', 1),
(236, 39, '10012020104042_231462.jpg', 'product', 1),
(237, 39, '10012020104042_231463.jpg', 'product', 1),
(238, 39, '10012020104042_231464.jpg', 'product', 1),
(239, 39, '10012020104042_231465.jpg', 'product', 1),
(240, 39, '10012020104042_231466.jpg', 'product', 1),
(241, 39, '10012020104042_231467.jpg', 'product', 1),
(242, 39, '10012020104042_231468.jpg', 'product', 1),
(243, 40, '10012020111416_17139.jpg', 'product', 1),
(244, 40, '10012020111416_171391.jpg', 'product', 1),
(245, 40, '10012020111416_171392.jpg', 'product', 1),
(246, 40, '10012020111416_171393.jpg', 'product', 1),
(247, 40, '10012020111416_171394.jpg', 'product', 1),
(248, 40, '10012020111416_171395.jpg', 'product', 1),
(249, 41, '10012020112559_28160.jpg', 'product', 1),
(250, 41, '10012020112559_281601.jpg', 'product', 1),
(251, 41, '10012020112559_281602.jpg', 'product', 1),
(252, 41, '10012020112559_281603.jpg', 'product', 1),
(257, 43, '10012020121103_89317.jpg', 'product', 1),
(258, 43, '10012020121103_893171.jpg', 'product', 1),
(259, 43, '10012020121103_893172.jpg', 'product', 1),
(260, 43, '10012020121103_893173.jpg', 'product', 1),
(261, 43, '10012020121103_893174.jpg', 'product', 1),
(262, 43, '10012020121103_893175.jpg', 'product', 1),
(263, 43, '10012020121103_893176.jpg', 'product', 1),
(264, 44, '10012020121722_42662.jpg', 'product', 1),
(265, 44, '10012020121722_426621.jpg', 'product', 1),
(266, 44, '10012020121722_426622.jpg', 'product', 1),
(267, 44, '10012020121722_426623.jpg', 'product', 1),
(268, 44, '10012020121722_426624.jpg', 'product', 1),
(269, 44, '10012020121722_426625.jpg', 'product', 1),
(270, 44, '10012020121722_426626.jpg', 'product', 1),
(271, 45, '10012020122400_83003.jpg', 'product', 1),
(272, 45, '10012020122400_830031.jpg', 'product', 1),
(273, 45, '10012020122400_830032.jpg', 'product', 1),
(274, 45, '10012020122400_830033.jpg', 'product', 1),
(275, 45, '10012020122400_830034.jpg', 'product', 1),
(276, 45, '10012020122400_830035.jpg', 'product', 1),
(283, 48, '10012020021954_61988.jpg', 'product', 1),
(284, 48, '10012020021954_619881.jpg', 'product', 1),
(285, 48, '10012020021954_619882.jpg', 'product', 1),
(289, 50, '10012020023651_85384.jpg', 'product', 1),
(290, 50, '10012020023651_853841.jpg', 'product', 1),
(291, 50, '10012020023651_853842.jpg', 'product', 1),
(302, 51, '23012020024311_60881.jpg', 'product', 1),
(303, 51, '23012020024311_608811.jpg', 'product', 1),
(304, 51, '23012020024311_608812.jpg', 'product', 1),
(305, 51, '23012020024311_608813.jpg', 'product', 1),
(306, 51, '23012020024311_608814.jpg', 'product', 1),
(307, 51, '23012020024311_608815.jpg', 'product', 1),
(308, 52, '23012020025603_67363.jpg', 'product', 1),
(309, 52, '23012020025603_673631.jpg', 'product', 1),
(310, 52, '23012020025603_673632.jpg', 'product', 1),
(311, 52, '23012020025603_673633.jpg', 'product', 1),
(312, 52, '23012020025603_673634.jpg', 'product', 1),
(313, 52, '23012020025603_673635.jpg', 'product', 1),
(314, 52, '23012020025603_673636.jpg', 'product', 1),
(315, 53, '23012020032419_74936.jpg', 'product', 1),
(316, 53, '23012020032419_749361.jpg', 'product', 1),
(317, 53, '23012020032419_749362.jpg', 'product', 1),
(318, 53, '23012020032419_749363.jpg', 'product', 1),
(319, 53, '23012020032419_749364.jpg', 'product', 1),
(320, 54, '23012020032752_3529.jpg', 'product', 1),
(321, 54, '23012020032752_35291.jpg', 'product', 1),
(322, 54, '23012020032752_35292.jpg', 'product', 1),
(323, 54, '23012020032752_35293.jpg', 'product', 1),
(324, 54, '23012020032752_35294.jpg', 'product', 1),
(325, 54, '23012020032752_35295.jpg', 'product', 1),
(326, 54, '23012020032752_35296.jpg', 'product', 1),
(327, 55, '23012020033445_96891.jpg', 'product', 1),
(328, 55, '23012020033445_968911.jpg', 'product', 1),
(329, 55, '23012020033445_968912.jpg', 'product', 1),
(330, 56, '23012020040013_5234.jpg', 'product', 1),
(331, 56, '23012020040013_52341.jpg', 'product', 1),
(332, 56, '23012020040013_52342.jpg', 'product', 1),
(333, 56, '23012020040013_52343.jpg', 'product', 1),
(334, 56, '23012020040013_52344.jpg', 'product', 1),
(335, 56, '23012020040013_52345.jpg', 'product', 1),
(336, 56, '23012020040013_52346.jpg', 'product', 1),
(337, 57, '23012020041102_26327.jpg', 'product', 1),
(338, 57, '23012020041102_263271.jpg', 'product', 1),
(339, 57, '23012020041102_263272.jpg', 'product', 1),
(340, 57, '23012020041102_263273.jpg', 'product', 1),
(341, 58, '23012020042138_71906.jpg', 'product', 1),
(342, 58, '23012020042138_719061.jpg', 'product', 1),
(343, 58, '23012020042138_719062.jpg', 'product', 1),
(344, 58, '23012020042138_719063.jpg', 'product', 1),
(345, 59, '23012020052638_15971.jpg', 'product', 1),
(346, 59, '23012020052638_159711.jpg', 'product', 1),
(347, 59, '23012020052638_159712.jpg', 'product', 1),
(348, 60, '23012020053028_90318.jpg', 'product', 1),
(349, 60, '23012020053028_903181.jpg', 'product', 1),
(350, 60, '23012020053028_903182.jpg', 'product', 1),
(351, 61, '23012020054651_4578.jpg', 'product', 1),
(352, 61, '23012020054651_45781.jpg', 'product', 1),
(353, 61, '23012020054651_45782.jpg', 'product', 1),
(354, 62, '23012020055023_78349.jpg', 'product', 1),
(355, 62, '23012020055023_783491.jpg', 'product', 1),
(356, 63, '23012020055853_46454.jpg', 'product', 1),
(357, 63, '23012020055853_464541.jpg', 'product', 1),
(358, 63, '23012020055853_464542.jpg', 'product', 1),
(359, 64, '24012020021738_99866.jpg', 'product', 1),
(360, 64, '24012020021738_998661.jpg', 'product', 1),
(361, 64, '24012020021738_998662.jpg', 'product', 1),
(362, 64, '24012020021738_998663.jpg', 'product', 1),
(363, 65, '24012020022054_50616.jpg', 'product', 1),
(364, 65, '24012020022054_506161.jpg', 'product', 1),
(365, 65, '24012020022054_506162.jpg', 'product', 1),
(366, 65, '24012020022054_506163.jpg', 'product', 1),
(367, 66, '24012020022557_79781.jpg', 'product', 1),
(368, 66, '24012020022557_797811.jpg', 'product', 1),
(369, 66, '24012020022557_797812.jpg', 'product', 1),
(370, 67, '24012020023120_79522.jpg', 'product', 1),
(371, 67, '24012020023120_795221.jpg', 'product', 1),
(372, 67, '24012020023120_795222.jpg', 'product', 1),
(373, 68, '24012020030200_89048.jpg', 'product', 1),
(374, 68, '24012020030200_890481.jpg', 'product', 1),
(375, 68, '24012020030200_890482.jpg', 'product', 1),
(387, 70, '30012020121123_46351_2_.jpg', 'product', 1),
(391, 71, '30012020122140_420052.jpg', 'product', 1),
(392, 71, '30012020122140_420053.jpg', 'product', 1),
(393, 71, '30012020122140_420054.jpg', 'product', 1),
(394, 71, '30012020122140_420055.jpg', 'product', 1),
(395, 71, '30012020122140_420056.jpg', 'product', 1),
(396, 72, '30012020123400_63532.jpg', 'product', 1),
(397, 72, '30012020123400_635321.jpg', 'product', 1),
(398, 72, '30012020123400_635322.jpg', 'product', 1),
(399, 72, '30012020123400_635323.jpg', 'product', 1),
(400, 72, '30012020123400_635324.jpg', 'product', 1),
(401, 73, '30012020123836_9178.jpg', 'product', 1),
(402, 73, '30012020123836_91781.jpg', 'product', 1),
(403, 73, '30012020123836_91782.jpg', 'product', 1),
(404, 73, '30012020123836_91783.jpg', 'product', 1),
(405, 74, '30012020030754_49158.jpg', 'product', 1),
(406, 74, '30012020030754_491581.jpg', 'product', 1),
(407, 74, '30012020030754_491582.jpg', 'product', 1),
(408, 74, '30012020030754_491583.jpg', 'product', 1),
(409, 74, '30012020030754_491584.jpg', 'product', 1),
(411, 75, '30012020033354_33916.jpg', 'product', 1),
(412, 75, '30012020033354_339161.jpg', 'product', 1),
(413, 75, '30012020033354_339162.jpg', 'product', 1),
(414, 75, '30012020033354_339163.jpg', 'product', 1),
(415, 75, '30012020033354_339164.jpg', 'product', 1),
(416, 76, '30012020033648_36267.jpg', 'product', 1),
(417, 76, '30012020033648_362671.jpg', 'product', 1),
(418, 76, '30012020033648_362672.jpg', 'product', 1),
(419, 77, '30012020034006_74308.jpg', 'product', 1),
(420, 77, '30012020034006_743081.jpg', 'product', 1),
(421, 77, '30012020034006_743082.jpg', 'product', 1),
(422, 77, '30012020034006_743083.jpg', 'product', 1),
(423, 77, '30012020034006_743084.jpg', 'product', 1),
(424, 78, '30012020034948_85062.jpg', 'product', 1),
(425, 78, '30012020034948_850621.jpg', 'product', 1),
(426, 79, '30012020035213_37557.jpg', 'product', 1),
(427, 79, '30012020035213_375571.jpg', 'product', 1),
(428, 80, '30012020035951_2768.jpg', 'product', 1),
(429, 81, '30012020040619_69372.jpg', 'product', 1),
(430, 81, '30012020040619_693721.jpg', 'product', 1),
(431, 81, '30012020040619_693722.jpg', 'product', 1),
(432, 82, '30012020042006_68838.jpg', 'product', 1),
(433, 82, '30012020042006_688381.jpg', 'product', 1),
(434, 82, '30012020042006_688382.jpg', 'product', 1),
(435, 83, '30012020043656_78861.jpg', 'product', 1),
(436, 83, '30012020043656_788611.jpg', 'product', 1),
(437, 83, '30012020043656_788612.jpg', 'product', 1),
(438, 83, '30012020043656_788613.jpg', 'product', 1),
(439, 84, '30012020044544_75586.jpg', 'product', 1),
(440, 84, '30012020044544_755861.jpg', 'product', 1),
(441, 84, '30012020044544_755862.jpg', 'product', 1),
(442, 84, '30012020044544_755863.jpg', 'product', 1),
(443, 85, '30012020045637_53709.jpg', 'product', 1),
(444, 85, '30012020045637_537091.jpg', 'product', 1),
(445, 86, '30012020050115_84444.jpg', 'product', 1),
(446, 86, '30012020050115_844441.jpg', 'product', 1),
(447, 86, '30012020050115_844442.jpg', 'product', 1),
(448, 86, '30012020050115_844443.jpg', 'product', 1),
(449, 87, '30012020051034_78366.jpg', 'product', 1),
(450, 87, '30012020051034_783661.jpg', 'product', 1),
(451, 87, '30012020051034_783662.jpg', 'product', 1),
(452, 87, '30012020051034_783663.jpg', 'product', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rating`
--

CREATE TABLE `tbl_rating` (
  `id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `order_id` int(10) NOT NULL DEFAULT 0,
  `rating` double NOT NULL,
  `rating_desc` longtext NOT NULL,
  `created_at` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

-- --------------------------------------------------------

--
-- Table structure for table `tbl_refund`
--

CREATE TABLE `tbl_refund` (
  `id` int(10) NOT NULL,
  `bank_id` int(10) NOT NULL DEFAULT 0,
  `user_id` int(10) NOT NULL DEFAULT 0,
  `order_id` int(10) NOT NULL,
  `order_unique_id` text NOT NULL,
  `product_id` int(10) NOT NULL,
  `product_title` varchar(150) NOT NULL,
  `product_amt` double NOT NULL,
  `refund_pay_amt` double NOT NULL,
  `refund_per` double NOT NULL DEFAULT 0,
  `gateway` varchar(20) NOT NULL,
  `refund_reason` longtext NOT NULL,
  `last_updated` varchar(255) NOT NULL,
  `request_status` int(1) NOT NULL DEFAULT 0,
  `cancel_by` int(10) NOT NULL DEFAULT 0,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_settings`
--

CREATE TABLE `tbl_settings` (
  `id` int(11) NOT NULL,
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
  `min_rate` int(5) NOT NULL DEFAULT 3,
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

INSERT INTO `tbl_settings` (`id`, `app_order_email`, `app_name`, `app_email`, `app_version`, `app_logo`, `web_favicon`, `app_author`, `app_contact`, `app_website`, `app_description`, `app_developed_by`, `facebook_url`, `twitter_url`, `youtube_url`, `instagram_url`, `app_privacy_policy`, `app_currency_code`, `app_currency_html_code`, `email_otp_op_status`, `cod_status`, `paypal_status`, `paypal_mode`, `paypal_client_id`, `paypal_secret_key`, `stripe_status`, `stripe_key`, `stripe_secret`, `razorpay_status`, `razorpay_key`, `razorpay_secret`, `razorpay_theme_color`, `google_login_status`, `google_client_id`, `google_secret_key`, `facebook_status`, `facebook_app_id`, `facebook_app_secret`, `home_slider_opt`, `home_brand_opt`, `home_category_opt`, `home_offer_opt`, `home_flase_opt`, `home_latest_opt`, `home_top_rated_opt`, `min_rate`, `home_cat_wise_opt`, `home_recent_opt`, `app_home_slider_opt`, `app_home_brand_opt`, `app_home_category_opt`, `app_home_offer_opt`, `app_home_flase_opt`, `app_home_latest_opt`, `app_home_top_rated_opt`, `app_home_cat_wise_opt`, `app_home_recent_opt`) VALUES
(1, 'user.viaviweb@gmail.com', 'Online Shopping CMS', 'user.viaviweb@gmail.com', '1.0.0', '28092020025412_64200.png', '28092020025555_42487.png', 'viaviwebtech', '+91 922 7777 522', 'http://www.viaviweb.com/', '<p>Ecommerce App for Online Selling Product | Add to Cart | Ecommerce Script | Checkout With Payment Gateway | Paypal Payment Mode | Stripe Payment Mode | Razorpay Payment Mode</p>\r\n\r\n<p>Website: <a href=\"http://www.viaviweb.com\">www.viaviweb.com</a></p>\r\n\r\n<p>We also develop custom applications, if you need any kind of custom application contact us on given Email or Contact No.</p>\r\n\r\n<p><strong>Email:</strong> viaviwebtech@gmail.com<br>\r\n<strong>WhatsApp:</strong> +919227777522<br>\r\n<strong>Website:</strong> <a href=\"http://www.viaviweb.com\">www.viaviweb.com</a></p>\r\n', 'Viavi Webtech', 'https://www.facebook.com/viaviwebtech', 'https://twitter.com/viaviwebtech', 'https://www.youtube.com/viaviwebtech', 'https://www.instagram.com/viaviwebtech/', '<p><strong>We are committed to protecting your privacy</strong></p>\n\n<p>We collect the minimum amount of information about you that is commensurate with providing you with a satisfactory service. This policy indicates the type of processes that may result in data being collected about you. Your use of this website gives us the right to collect that information.&nbsp;</p>\n\n<p><strong>Information Collected</strong></p>\n\n<p>We may collect any or all of the information that you give us depending on the type of transaction you enter into, including your name, address, telephone number, and email address, together with data about your use of the website. Other information that may be needed from time to time to process a request may also be collected as indicated on the website.</p>\n\n<p><strong>Information Use</strong></p>\n\n<p>We use the information collected primarily to process the task for which you visited the website. Data collected in the UK is held in accordance with the Data Protection Act. All reasonable precautions are taken to prevent unauthorised access to this information. This safeguard may require you to provide additional forms of identity should you wish to obtain information about your account details.</p>\n\n<p><strong>Cookies</strong></p>\n\n<p>Your Internet browser has the in-built facility for storing small files - &quot;cookies&quot; - that hold information which allows a website to recognise your account. Our website takes advantage of this facility to enhance your experience. You have the ability to prevent your computer from accepting cookies but, if you do, certain functionality on the website may be impaired.</p>\n\n<p><strong>Disclosing Information</strong></p>\n\n<p>We do not disclose any personal information obtained about you from this website to third parties unless you permit us to do so by ticking the relevant boxes in registration or competition forms. We may also use the information to keep in contact with you and inform you of developments associated with us. You will be given the opportunity to remove yourself from any mailing list or similar device. If at any time in the future we should wish to disclose information collected on this website to any third party, it would only be with your knowledge and consent.&nbsp;</p>\n\n<p>We may from time to time provide information of a general nature to third parties - for example, the number of individuals visiting our website or completing a registration form, but we will not use any information that could identify those individuals.&nbsp;</p>\n\n<p>In addition Dummy may work with third parties for the purpose of delivering targeted behavioural advertising to the Dummy website. Through the use of cookies, anonymous information about your use of our websites and other websites will be used to provide more relevant adverts about goods and services of interest to you. For more information on online behavioural advertising and about how to turn this feature off, please visit youronlinechoices.com/opt-out.</p>\n\n<p><strong>Changes to this Policy</strong></p>\n\n<p>Any changes to our Privacy Policy will be placed here and will supersede this version of our policy. We will take reasonable steps to draw your attention to any changes in our policy. However, to be on the safe side, we suggest that you read this document each time you use the website to ensure that it still meets with your approval.</p>\n\n<p><strong>Contacting Us</strong></p>\n\n<p>If you have any questions about our Privacy Policy, or if you want to know what information we have collected about you, please email us at hd@dummy.com. You can also correct any factual errors in that information or require us to remove your details form any list under our control.</p>\n', 'INR', 'Rs.', 'true', 'true', 'true', 'sandbox', '', '', 'true', '', '', 'true', '', '', 'FF5252', 'true', '', '', 'true', '', '', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 3, 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true');

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
(1, 'phpmailer', 'server', '', '', '', 'ssl', '465', '', '', '', 'tls', 465);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_status_title`
--

CREATE TABLE `tbl_status_title` (
  `id` int(5) NOT NULL,
  `title` varchar(100) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1
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
-- Table structure for table `tbl_sub_category`
--

CREATE TABLE `tbl_sub_category` (
  `id` int(11) NOT NULL,
  `category_id` int(10) NOT NULL,
  `sub_category_name` varchar(150) NOT NULL,
  `sub_category_slug` varchar(150) NOT NULL,
  `sub_category_image` text NOT NULL,
  `created_at` varchar(150) NOT NULL,
  `show_on_off` int(1) NOT NULL DEFAULT 0,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_sub_category`
--

INSERT INTO `tbl_sub_category` (`id`, `category_id`, `sub_category_name`, `sub_category_slug`, `sub_category_image`, `created_at`, `show_on_off`, `status`) VALUES
(2, 2, 'Shirt', 'shirt', '23102019053157_49175.jpg', '1570084668', 1, 1),
(3, 2, 'Jeans', 'jeans', '23102019052330_39760.jpg', '1570179058', 1, 1),
(4, 4, 'Refrigerator', 'refrigerator', '23102019040136_44995.jpg', '1571826696', 1, 1),
(5, 4, 'Home & Decor', 'home-decor', '27112019103751_80127.jpg', '1574831272', 1, 1),
(7, 1, 'Watches', 'watches', '10122019104653_4809.jpg', '1575955013', 1, 1),
(8, 1, 'Mobiles', 'mobiles', '23102019051943_65874.jpg', '1568960439', 1, 1),
(15, 9, 'Bangle & Bracelets', 'bangle-bracelets', '30122019094742_23360.jpg', '1577679462', 1, 1),
(16, 9, 'Necklaces', 'necklaces', '30122019100913_2194.jpg', '1577679968', 1, 1),
(17, 10, 'Kids Footwear', 'kids-footwear', '03012020045816_37450.jpg', '1578050896', 1, 1),
(18, 10, 'Mens Footwear', 'mens-footwear', '03012020050201_23335.jpeg', '1578051121', 1, 1),
(19, 10, 'Women Footwear', 'women-footwear', '03012020050548_63142.jpg', '1578051348', 1, 1),
(20, 1, 'Laptops', 'laptops', '03012020053905_1229.jpg', '1578053345', 1, 1),
(21, 1, 'Television', 'television', '09012020034113_46403.jpg', '1578564673', 1, 1),
(22, 13, 'Chocolates', 'chocolates', '29012020022504_35093.jpg', '1579778172', 1, 1),
(23, 13, 'Coffee, Tea & Beverages', 'coffee-tea-beverages', '23012020044720_25781.jpg', '1579778240', 1, 1),
(24, 13, 'Snacks Corner', 'snacks-corner', '23012020044821_11662.jpg', '1579778301', 1, 1),
(25, 11, 'Makeup', 'makeup', '23012020045214_12101.jpg', '1579778534', 1, 1),
(26, 11, 'Shaving & Beard Care', 'shaving-beard-care', '23012020045629_65182.jpg', '1579778789', 1, 1),
(27, 11, 'Hair Care And Accessory', 'hair-care-and-accessory', '23012020050156_59241.jpg', '1579779116', 1, 1);

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
  `status` int(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `web_envato_purchased_status` int(2) NOT NULL DEFAULT 0,
  `android_envato_buyer_name` text NOT NULL,
  `android_envato_purchase_code` text NOT NULL,
  `android_envato_buyer_email` varchar(150) NOT NULL,
  `package_name` varchar(150) NOT NULL,
  `android_envato_purchased_status` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_verify`
--

INSERT INTO `tbl_verify` (`id`, `web_envato_buyer_name`, `web_envato_purchase_code`, `web_envato_buyer_email`, `web_url`, `web_envato_purchased_status`, `android_envato_buyer_name`, `android_envato_purchase_code`, `android_envato_buyer_email`, `package_name`, `android_envato_purchased_status`) VALUES
(1, '', '', '-', '', 0, '', '', '-', 'com.example.ecommerceapp', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_verify_code`
--

CREATE TABLE `tbl_verify_code` (
  `id` int(10) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `verify_code` varchar(100) NOT NULL,
  `created_at` varchar(150) NOT NULL,
  `is_verify` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `libraries_load_from` varchar(10) NOT NULL DEFAULT 'local'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_web_settings`
--

INSERT INTO `tbl_web_settings` (`id`, `site_name`, `site_description`, `site_keywords`, `copyright_text`, `web_logo_1`, `web_logo_2`, `web_favicon`, `about_page_title`, `about_content`, `about_status`, `faq_content`, `privacy_page_title`, `privacy_content`, `privacy_page_status`, `terms_of_use_page_title`, `terms_of_use_content`, `terms_of_use_page_status`, `refund_return_policy_page_title`, `refund_return_policy`, `refund_return_policy_status`, `cancellation_page_title`, `cancellation_content`, `cancellation_page_status`, `payments_page_title`, `payments_content`, `payments_page_status`, `contact_page_title`, `address`, `contact_number`, `contact_email`, `home_ad`, `home_banner_ad`, `product_ad`, `product_banner_ad`, `android_app_url`, `ios_app_url`, `header_code`, `footer_code`, `libraries_load_from`) VALUES
(1, 'Online Shopping CMS (eCommerce System,  eCommerce Marketplace, Buy, Sell, PayPal, Stripe, Razorpay, COD)', 'Ecommerce App is Best Script for Online Selling Product | Add to Cart | Ecommerce Script | Checkout With Payment Gateway | Paypal Payment Mode | Stripe Payment Mode | Razorpay Payment Mode', 'Online Shopping CMS,eCommerce System, PayPal, Stripe,Razorpay,COD,Checkout With Payment Gateway', 'Copyright © 2020 <a href=\"http://www.viaviweb.com\" target=\"_blank\">Viaviweb.com</a>. All Rights Reserved.', '28092020034501_21635.png', '28092020034819_672312.png', '28092020025610_50141.png', 'About Us', '<h2>What is Lorem Ipsum?</h2>\r\n\r\n<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<h2>Where does it come from?</h2>\r\n\r\n<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p>\r\n', 'true', '<h3>1) What kind of customer service do you offer?</h3>\r\n\r\n<p>Our ecommerce consultants are here to answer your questions. In addition to FREE phone support, you can contact our consultants via email or live chat.</p>\r\n\r\n<h3>2) Can I build my new Ecommerce site while my other website is still live?</h3>\r\n\r\n<p>Yes! When you purchase one of our ecommerce solutions you will get a standard 3rd level domain to use while you are building your new website. When you are ready to begin hosting your new online store, you simply change your DNS settings to point your existing domain name to your new site.</p>\r\n\r\n<h3>3) Can I use my own domain name?</h3>\r\n\r\n<p>Absolutely! Simply point your domain directly to your new Network Solutions Ecommerce. You do not need to use a subdomain or any other temporary domain name placeholder.</p>\r\n\r\n<h3>4) Are there any system requirements?</h3>\r\n\r\n<p>To access your Ecommerce control panel, you must have Internet access and use a JavaScript enabled browser. The newest version of Internet Explorer, Firefox, Safari or Chrome are recommended.</p>\r\n', 'Privacy', '<h2>What is Lorem Ipsum?</h2>\r\n\r\n<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<h2>Where does it come from?</h2>\r\n\r\n<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p>\r\n', 'true', 'Terms of Use', '<h2>What is Lorem Ipsum?</h2>\r\n\r\n<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<h2>Where does it come from?</h2>\r\n\r\n<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p>\r\n\r\n<p> </p>\r\n', 'true', 'Refund Return Policy', '<h2>What is Lorem Ipsum?</h2>\r\n\r\n<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<h2>Where does it come from?</h2>\r\n\r\n<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p>\r\n', 'true', 'Cancellation Policy', '<h2>What is Lorem Ipsum?</h2>\r\n\r\n<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<h2>Where does it come from?</h2>\r\n\r\n<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p>\r\n', 'true', '', '', 'true', 'Contact Us', '3rd floor, Shyam Complex, Parivar Park, Near Mayani Chowk, Rajkot - 360005', '+91 922 7777 522', 'info@viaviweb.com', 'false', '', 'false', '', 'https://play.google.com/store/apps/dev?id=7157478532572017100', 'https://apps.apple.com/in/developer/vishal-pamar/id1141291247', '', '', 'local');

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
-- Indexes for table `tbl_sub_category`
--
ALTER TABLE `tbl_sub_category`
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
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_bank_details`
--
ALTER TABLE `tbl_bank_details`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_banner`
--
ALTER TABLE `tbl_banner`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_brands`
--
ALTER TABLE `tbl_brands`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_cart_tmp`
--
ALTER TABLE `tbl_cart_tmp`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_contact_list`
--
ALTER TABLE `tbl_contact_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_contact_sub`
--
ALTER TABLE `tbl_contact_sub`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_coupon`
--
ALTER TABLE `tbl_coupon`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_faq`
--
ALTER TABLE `tbl_faq`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_order_items`
--
ALTER TABLE `tbl_order_items`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_order_status`
--
ALTER TABLE `tbl_order_status`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `tbl_product_images`
--
ALTER TABLE `tbl_product_images`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=453;

--
-- AUTO_INCREMENT for table `tbl_rating`
--
ALTER TABLE `tbl_rating`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_recent_viewed`
--
ALTER TABLE `tbl_recent_viewed`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_refund`
--
ALTER TABLE `tbl_refund`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT for table `tbl_sub_category`
--
ALTER TABLE `tbl_sub_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tbl_transaction`
--
ALTER TABLE `tbl_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_verify`
--
ALTER TABLE `tbl_verify`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_verify_code`
--
ALTER TABLE `tbl_verify_code`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

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
