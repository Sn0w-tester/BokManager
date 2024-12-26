-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 19, 2024 lúc 04:34 AM
-- Phiên bản máy phục vụ: 10.4.27-MariaDB
-- Phiên bản PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `bokmanager`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `billing_details`
--

CREATE TABLE `billing_details` (
  `id` int(5) NOT NULL,
  `bill_id` varchar(50) NOT NULL,
  `product_company` varchar(50) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `product_unit` varchar(20) NOT NULL,
  `packing_size` varchar(30) NOT NULL,
  `price` varchar(10) NOT NULL,
  `qty` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `billing_details`
--

INSERT INTO `billing_details` (`id`, `bill_id`, `product_company`, `product_name`, `product_unit`, `packing_size`, `price`, `qty`) VALUES
(12, '115', 'IPM', 'Attack Of Titan - Book Set', 'Set', '3', '68000', '2'),
(13, '116', 'IPM', 'Attack Of Titan - Book Set', 'Set', '3', '68000', '6'),
(14, '117', 'IPM', 'Monster #8 - chap 1', 'Unit', '1', '150000', '3'),
(15, '118', 'IPM', 'Attack Of Titan - Book Set', 'Set', '3', '68000', '1'),
(16, '119', 'IPM', 'Monster #8 - chap 1', 'Unit', '1', '150000', '10'),
(17, '119', 'IPM', 'Attack Of Titan - Book Set', 'Set', '3', '68000', '10'),
(18, '120', 'IPM', 'Monster #8 - chap 1', 'Unit', '1', '150000', '1');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `billing_header`
--

CREATE TABLE `billing_header` (
  `id` int(5) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `bill_type` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `bill_no` varchar(10) NOT NULL,
  `username` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `billing_header`
--

INSERT INTO `billing_header` (`id`, `full_name`, `bill_type`, `date`, `bill_no`, `username`) VALUES
(115, 'tuyet', 'Cash', '2024-12-17', 'BILL-00001', 'admin'),
(116, 'tan', 'Cash', '2024-12-17', 'BILL-00116', 'admin'),
(117, 'adminnnnn', 'Cash', '2024-12-17', 'BILL-00117', 'admin'),
(118, 'tann', 'Cash', '2024-12-17', 'BILL-00118', 'admin'),
(119, 'tan', 'Cash', '2024-12-19', 'BILL-00119', 'admin'),
(120, 'tan', 'Cash', '2024-12-19', 'BILL-00120', 'admin');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `company_name` varchar(50) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `category` varchar(50) NOT NULL,
  `unit` varchar(50) NOT NULL,
  `packing_size` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `books`
--

INSERT INTO `books` (`id`, `company_name`, `product_name`, `category`, `unit`, `packing_size`) VALUES
(10, 'IPM', 'Monster #8 - chap 1', 'Manga', 'Unit', '1'),
(11, 'Nha Nam', 'Nha gia kim', 'Novel', 'Unit', '1'),
(12, 'Other', 'Cay cam ngot cua toi', 'Novel', 'Unit', '1'),
(13, 'IPM', 'Attack Of Titan - Book Set', 'Manga', 'Set', '3'),
(14, 'IPM', 'program', 'Other', 'Unit', '1');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `category_name`) VALUES
(9, 'Novel'),
(10, 'Manga'),
(11, 'Comic'),
(12, 'Other');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `company`
--

CREATE TABLE `company` (
  `id` int(5) NOT NULL,
  `company_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `company`
--

INSERT INTO `company` (`id`, `company_name`) VALUES
(11, 'IPM'),
(12, 'Nxb Tre'),
(13, 'Nxb Kim Dong'),
(14, 'Nha Nam'),
(15, 'Other');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `party_info`
--

CREATE TABLE `party_info` (
  `id` int(5) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `businessname` varchar(100) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `address` varchar(100) NOT NULL,
  `city` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `party_info`
--

INSERT INTO `party_info` (`id`, `firstname`, `lastname`, `businessname`, `contact`, `address`, `city`) VALUES
(10, 'nguyenn', 'tan1', 'IPMs', '0988441814', 'binh thuy', 'Can Tho'),
(11, 'Trinh nguyen', 'Tu Lam', 'Fahasa', '0988441814', 'Thu Duc', 'tp. Ho Chi Minh');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `purchase_master`
--

CREATE TABLE `purchase_master` (
  `id` int(11) NOT NULL,
  `company_name` varchar(50) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `unit` varchar(50) NOT NULL,
  `packing_size` varchar(20) NOT NULL,
  `qty` varchar(10) NOT NULL,
  `price` varchar(20) NOT NULL,
  `party_name` varchar(100) NOT NULL,
  `purchase_type` varchar(100) NOT NULL,
  `expiry_date` date NOT NULL,
  `purchase_date` date NOT NULL,
  `username` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `purchase_master`
--

INSERT INTO `purchase_master` (`id`, `company_name`, `product_name`, `unit`, `packing_size`, `qty`, `price`, `party_name`, `purchase_type`, `expiry_date`, `purchase_date`, `username`) VALUES
(17, 'IPM', 'Attack Of Titan - Book Set', 'Set', '3', '40', '50000000', 'IPMs', 'Cash', '2024-12-25', '2024-12-17', 'admin'),
(18, 'IPM', 'Monster #8 - chap 1', 'Unit', '1', '100', '6500000000', 'IPMs', 'Debit', '2024-12-25', '2024-12-17', 'admin'),
(19, 'IPM', 'Monster #8 - chap 1', 'Unit', '1', '1000', '500000', 'Fahasa', 'Debit', '2024-12-25', '2024-12-19', 'admin'),
(20, 'IPM', 'program', 'Unit', '1', '100', '100000', 'IPMs', 'Debit', '2024-12-25', '2024-12-19', 'admin');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `recent_activities`
--

CREATE TABLE `recent_activities` (
  `id` int(11) NOT NULL,
  `activity_description` varchar(255) NOT NULL,
  `activity_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `recent_activities`
--

INSERT INTO `recent_activities` (`id`, `activity_description`, `activity_date`) VALUES
(15, 'Added new company: Fahasa', '2024-12-17 16:18:15'),
(16, 'Added new company: IPMs', '2024-12-17 16:18:24'),
(17, 'admin Deleted Company with ID 10: IPMs', '2024-12-17 16:18:44'),
(18, 'admin Deleted Company with ID 9: Fahasa', '2024-12-17 16:18:46'),
(19, 'Added new company: IPM', '2024-12-17 16:18:49'),
(20, 'Added new company: Nxb Tre', '2024-12-17 16:19:00'),
(21, 'Added new company: Nxb Kim Dong', '2024-12-17 16:19:17'),
(22, 'Added new company: Nha Nam', '2024-12-17 16:19:26'),
(23, 'Added new company: Other', '2024-12-17 16:19:33'),
(24, 'Added new Unit: Chap', '2024-12-17 16:20:01'),
(25, 'Added new Unit: Set', '2024-12-17 16:20:09'),
(26, 'Unit ID 8: Unit name updated from \'Chap\' to \'Chap\'', '2024-12-17 16:28:00'),
(27, 'Unit ID 8: Unit name updated from \'Chap\' to \'Unit\'', '2024-12-17 16:29:17'),
(28, 'User \'TuLam\' updated: Last Name changed from \'Tu Lam\' to \'Tu Lamm\'', '2024-12-17 16:30:22'),
(29, 'admin Deleted User has Username: test', '2024-12-17 16:30:58'),
(30, 'Added new company: test', '2024-12-17 16:31:50'),
(31, 'Company ID 16 updated: \'hahahah\' changed to \'hahahah\'', '2024-12-17 16:32:43'),
(32, 'admin Deleted Company with ID 16: hahahah', '2024-12-17 16:32:49'),
(33, 'Added new Business: IPMs', '2024-12-17 16:33:21'),
(34, 'Party Info ID 10 updated: Old Info: Firstname=nguyenn, Lastname=tan1, Business=IPMs, Contact=, Address=binh thuy, City=Can Tho => New Info: Firstname=nguyenn, Lastname=tan1, Business=IPMs, Contact=0988441814, Address=binh thuy, City=Can Tho', '2024-12-17 16:33:33'),
(35, 'Added new Business: Fahasa', '2024-12-17 16:34:58'),
(36, 'Added new category: novel', '2024-12-17 16:35:20'),
(37, 'Added new category: manga', '2024-12-17 16:35:25'),
(38, 'Added new category: Comic', '2024-12-17 16:35:35'),
(39, 'Added new category: Other', '2024-12-17 16:35:45'),
(40, 'Category ID 9 updated: \'novel\' changed to \'Novel\'', '2024-12-17 16:35:53'),
(41, 'Category ID 10 updated: \'manga\' changed to \'Manga\'', '2024-12-17 16:36:01'),
(42, 'Added new book: Monster #8 - chap 1', '2024-12-17 16:36:31'),
(43, 'Added new book: Nha gia kim', '2024-12-17 16:37:10'),
(44, 'Added new book: Cay cam ngot cua toi', '2024-12-17 16:37:46'),
(45, 'Added new book: Attack Of Titan - Book Set', '2024-12-17 16:38:02'),
(46, 'Purchase made: Company: IPM, Product: Attack Of Titan - Book Set, Unit: Set, Qty: 40, Price: 50000000, Purchase Type: Cash, Party: IPMs, Expiry Date: 2024-12-25', '2024-12-17 16:39:50'),
(47, 'Purchase made: Company: IPM, Product: Monster #8 - chap 1, Unit: Unit, Qty: 100, Price: 6500000000, Purchase Type: Debit, Party: IPMs, Expiry Date: 2024-12-25', '2024-12-17 16:40:44'),
(48, 'Stock ID 9: Selling price updated from 0 to 68000', '2024-12-17 16:41:18'),
(49, 'Stock ID 10: Selling price updated from 0 to 150000', '2024-12-17 16:41:29'),
(50, 'Created a new bill with Bill No. BILL-00001', '2024-12-17 16:42:39'),
(51, 'Added 1 units of Monster #8 - chap 1 to the bill (Bill No. 115)', '2024-12-17 16:42:39'),
(52, 'Added 2 units of Attack Of Titan - Book Set to the bill (Bill No. 115)', '2024-12-17 16:42:39'),
(53, 'Cart cleared after bill creation.', '2024-12-17 16:42:39'),
(54, 'Product return processed: Bill No: BILL-00001, Product: Monster #8 - chap 1, Company: IPM, Unit: Unit, Packing Size: 1, Qty: 1, Price: 150000, Total: 150000', '2024-12-17 16:55:26'),
(55, 'Created a new bill with Bill No. BILL-00116', '2024-12-17 16:56:49'),
(56, 'Added 6 units of Attack Of Titan - Book Set to the bill (Bill No. 116)', '2024-12-17 16:56:49'),
(57, 'Cart cleared after bill creation.', '2024-12-17 16:56:49'),
(58, 'Created a new bill with Bill No. BILL-00117', '2024-12-17 17:00:15'),
(59, 'Added 3 units of Monster #8 - chap 1 to the bill (Bill No. 117)', '2024-12-17 17:00:15'),
(60, 'Cart cleared after bill creation.', '2024-12-17 17:00:15'),
(61, 'admin Created a new bill with Bill No. BILL-00118', '2024-12-17 17:01:52'),
(62, 'Added 1 units of Attack Of Titan - Book Set to the bill (Bill No. 118)', '2024-12-17 17:01:52'),
(63, 'Cart cleared after bill creation.', '2024-12-17 17:01:52'),
(64, 'Purchase made: Company: IPM, Product: Monster #8 - chap 1, Unit: Unit, Qty: 1000, Price: 500000, Purchase Type: Debit, Party: Fahasa, Expiry Date: 2024-12-25', '2024-12-19 03:13:50'),
(65, 'admin Created a new bill with Bill No. BILL-00119', '2024-12-19 03:14:45'),
(66, 'Added 10 units of Monster #8 - chap 1 to the bill (Bill No. 119)', '2024-12-19 03:14:45'),
(67, 'Added 10 units of Attack Of Titan - Book Set to the bill (Bill No. 119)', '2024-12-19 03:14:45'),
(68, 'Cart cleared after bill creation.', '2024-12-19 03:14:45'),
(69, 'Added new User: tan123', '2024-12-19 03:16:01'),
(70, 'User \'tan123\' updated: First Name changed from \'nguyenn\' to \'nguyen\'', '2024-12-19 03:16:15'),
(71, 'admin Deleted User has Username: tan123', '2024-12-19 03:16:21'),
(72, 'Added new company: abc', '2024-12-19 03:16:52'),
(73, 'Company ID 17 updated: \'abc\' changed to \'abcc\'', '2024-12-19 03:17:00'),
(74, 'admin Deleted Company with ID 17: abcc', '2024-12-19 03:17:03'),
(75, 'Added new Business: tiki', '2024-12-19 03:17:28'),
(76, 'Party Info ID 12 updated: Old Info: Firstname=nguyen, Lastname=tan, Business=tiki, Contact=0988441816, Address=binh thuya, City=Can Thoo => New Info: Firstname=nguyen, Lastname=tan, Business=tikii, Contact=0988441816, Address=binh thuya, City=Can Thoo', '2024-12-19 03:17:40'),
(77, 'admin Deleted Party with ID 12: ', '2024-12-19 03:17:43'),
(78, 'Added new category: Others', '2024-12-19 03:17:59'),
(79, 'Category ID 13 updated: \'Others\' changed to \'Othersi\'', '2024-12-19 03:18:07'),
(80, 'admin Deleted Category with ID 13: Othersi', '2024-12-19 03:18:10'),
(81, 'Added new Unit: Other', '2024-12-19 03:18:37'),
(82, 'Added new book: program', '2024-12-19 03:19:02'),
(83, 'Purchase made: Company: IPM, Product: program, Unit: Unit, Qty: 100, Price: 100000, Purchase Type: Debit, Party: IPMs, Expiry Date: 2024-12-25', '2024-12-19 03:19:31'),
(84, 'Stock ID 11: Selling price updated from 0 to 30000', '2024-12-19 03:19:59'),
(85, ' admin Created a new bill with Bill No. BILL-00120', '2024-12-19 03:20:24'),
(86, 'Added 1 units of Monster #8 - chap 1 to the bill (Bill No. 120)', '2024-12-19 03:20:24'),
(87, 'Cart cleared after bill creation.', '2024-12-19 03:20:25');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `return_products`
--

CREATE TABLE `return_products` (
  `id` int(5) NOT NULL,
  `bill_no` varchar(10) NOT NULL,
  `return_by` varchar(50) NOT NULL,
  `return_date` varchar(15) NOT NULL,
  `product_company` varchar(50) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `product_unit` varchar(20) NOT NULL,
  `packing_size` varchar(20) NOT NULL,
  `product_price` varchar(19) NOT NULL,
  `product_qty` varchar(10) NOT NULL,
  `total` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `return_products`
--

INSERT INTO `return_products` (`id`, `bill_no`, `return_by`, `return_date`, `product_company`, `product_name`, `product_unit`, `packing_size`, `product_price`, `product_qty`, `total`) VALUES
(6, 'BILL-00001', 'admin', '24-12-17', 'IPM', 'Monster #8 - chap 1', 'Unit', '1', '150000', '1', '150000');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `stock_master`
--

CREATE TABLE `stock_master` (
  `id` int(5) NOT NULL,
  `product_company` varchar(100) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `product_unit` varchar(50) NOT NULL,
  `packing_size` varchar(50) NOT NULL,
  `product_qty` varchar(5) NOT NULL,
  `product_selling_price` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `stock_master`
--

INSERT INTO `stock_master` (`id`, `product_company`, `product_name`, `product_unit`, `packing_size`, `product_qty`, `product_selling_price`) VALUES
(9, 'IPM', 'Attack Of Titan - Book Set', 'Set', '3', '21', '68000'),
(10, 'IPM', 'Monster #8 - chap 1', 'Unit', '1', '1086', '150000'),
(11, 'IPM', 'program', 'Unit', '1', '100', '30000');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `unit`
--

CREATE TABLE `unit` (
  `id` int(11) NOT NULL,
  `units` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `unit`
--

INSERT INTO `unit` (`id`, `units`) VALUES
(8, 'Unit'),
(9, 'Set'),
(10, 'Other');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_registration`
--

CREATE TABLE `user_registration` (
  `id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(16) NOT NULL,
  `role` varchar(10) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `user_registration`
--

INSERT INTO `user_registration` (`id`, `firstname`, `lastname`, `username`, `password`, `role`, `status`) VALUES
(2, 'admin', 'admin', 'admin', 'admin', 'admin', 'active'),
(3, 'nguyen', 'tan', 'tandeptrai', '123', 'user', 'active'),
(10, 'Trinh Nguyen', 'Tu Lamm', 'TuLam', '12345', 'user', 'active'),
(11, 'tan', 'nguyen', 'tan', 'tan', 'user', 'active');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `billing_details`
--
ALTER TABLE `billing_details`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `billing_header`
--
ALTER TABLE `billing_header`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `party_info`
--
ALTER TABLE `party_info`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `purchase_master`
--
ALTER TABLE `purchase_master`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `recent_activities`
--
ALTER TABLE `recent_activities`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `return_products`
--
ALTER TABLE `return_products`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `stock_master`
--
ALTER TABLE `stock_master`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `user_registration`
--
ALTER TABLE `user_registration`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `billing_details`
--
ALTER TABLE `billing_details`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `billing_header`
--
ALTER TABLE `billing_header`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT cho bảng `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `company`
--
ALTER TABLE `company`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `party_info`
--
ALTER TABLE `party_info`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `purchase_master`
--
ALTER TABLE `purchase_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `recent_activities`
--
ALTER TABLE `recent_activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT cho bảng `return_products`
--
ALTER TABLE `return_products`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `stock_master`
--
ALTER TABLE `stock_master`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `unit`
--
ALTER TABLE `unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `user_registration`
--
ALTER TABLE `user_registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
