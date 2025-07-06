-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 06, 2025 at 01:07 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_ci4`
--

-- --------------------------------------------------------

--
-- Table structure for table `diskon`
--

CREATE TABLE `diskon` (
  `id` int(11) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `nominal` double NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diskon`
--

INSERT INTO `diskon` (`id`, `tanggal`, `nominal`, `created_at`, `updated_at`) VALUES
(2, '2025-07-02', 193843, '2025-07-01 04:21:02', '2025-07-01 04:21:02'),
(3, '2025-07-03', 1000000, '2025-07-01 04:21:02', '2025-07-02 07:04:45'),
(4, '2025-07-04', 113656, '2025-07-01 04:21:02', '2025-07-01 04:21:02'),
(5, '2025-07-05', 196631, '2025-07-01 04:21:02', '2025-07-01 04:21:02'),
(6, '2025-07-06', 197775, '2025-07-01 04:21:02', '2025-07-01 04:21:02'),
(7, '2025-07-07', 195781, '2025-07-01 04:21:02', '2025-07-01 04:21:02'),
(8, '2025-07-08', 77817, '2025-07-01 04:21:02', '2025-07-01 04:21:02'),
(9, '2025-07-09', 77178, '2025-07-01 04:21:02', '2025-07-01 04:21:02'),
(10, '2025-07-10', 114157, '2025-07-01 04:21:02', '2025-07-01 04:21:02'),
(12, '2025-07-11', 250000, '2025-07-02 05:05:43', '2025-07-02 05:05:43'),
(13, '2025-07-25', 250000, '2025-07-02 06:53:29', '2025-07-02 06:53:29'),
(25, '2025-07-12', 230370, '2025-07-03 05:24:34', '2025-07-03 05:24:34'),
(26, '2025-07-30', 250000, '2025-07-03 06:27:30', '2025-07-03 06:27:30');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2025-05-09-061019', 'App\\Database\\Migrations\\User', 'default', 'App', 1747979825, 1),
(2, '2025-05-09-061030', 'App\\Database\\Migrations\\Product', 'default', 'App', 1747979825, 1),
(3, '2025-05-09-061042', 'App\\Database\\Migrations\\Transaction', 'default', 'App', 1747979825, 1),
(4, '2025-05-09-061052', 'App\\Database\\Migrations\\TransactionDetail', 'default', 'App', 1747979825, 1),
(5, '2025-05-12-091016', 'App\\Database\\Migrations\\ProductCategory', 'default', 'App', 1747979825, 1),
(6, '2025-05-29-045758', 'App\\Database\\Migrations\\ProductCategory', 'default', 'App', 1748494701, 2),
(8, '2025-07-01-041530', 'App\\Database\\Migrations\\Diskon', 'default', 'App', 1751343450, 3);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `harga` double NOT NULL,
  `jumlah` int(5) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `nama`, `harga`, `jumlah`, `foto`, `created_at`, `updated_at`) VALUES
(1, 'ASUS TUF A15 FA506NF', 10899000, 50, 'asus_tuf_a15.jpg', '2025-05-23 05:58:05', '2025-05-23 06:59:36'),
(2, 'Asus Vivobook 14 A1404ZA', 6899000, 7, 'asus_vivobook_14.jpg', '2025-05-23 05:58:05', NULL),
(3, 'Lenovo IdeaPad Slim 3-14IAU7', 6299000, 5, 'lenovo_idepad_slim_3.jpg', '2025-05-23 05:58:05', NULL),
(5, 'Asus Gaming K16', 9000000, 1, '1751600206_9652bdc6bc07772196b4.jpg', '2025-07-04 03:36:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Laptop', '2025-05-29 13:10:27', '2025-05-29 13:10:27'),
(2, 'Printer', '2025-05-29 13:10:27', '2025-05-29 13:10:27');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `total_harga` double NOT NULL,
  `alamat` text NOT NULL,
  `ongkir` double DEFAULT NULL,
  `status` int(1) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`id`, `username`, `total_harga`, `alamat`, `ongkir`, `status`, `created_at`, `updated_at`) VALUES
(1, 'empluk00', 10924000, 'jl. Imam Bonjol 207', 25000, 0, '2025-06-20 06:01:46', '2025-06-20 06:01:46'),
(2, 'empluk00', 6649000, 'jl. Imam Bonjol 207', 350000, 0, '2025-06-20 08:09:55', '2025-06-20 08:09:55'),
(3, 'empluk00', 10935000, '', 36000, 0, '2025-07-03 09:01:43', '2025-07-03 09:01:43'),
(4, 'empluk00', 5924000, 'nakula raya', 25000, 0, '2025-07-03 10:30:09', '2025-07-03 10:30:09'),
(5, 'danuja.firmansyah', 20838000, 'Nakula', 40000, 0, '2025-07-03 13:49:29', '2025-07-03 13:49:29');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_detail`
--

CREATE TABLE `transaction_detail` (
  `id` int(11) UNSIGNED NOT NULL,
  `transaction_id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) UNSIGNED NOT NULL,
  `jumlah` int(5) NOT NULL,
  `diskon` double DEFAULT NULL,
  `subtotal_harga` double NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction_detail`
--

INSERT INTO `transaction_detail` (`id`, `transaction_id`, `product_id`, `jumlah`, `diskon`, `subtotal_harga`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 0, 10899000, '2025-06-20 06:01:46', '2025-06-20 06:01:46'),
(2, 2, 3, 1, 0, 6299000, '2025-06-20 08:09:55', '2025-06-20 08:09:55'),
(3, 3, 1, 1, 0, 10899000, '2025-07-03 09:01:43', '2025-07-03 09:01:43'),
(4, 4, 2, 1, 0, 5899000, '2025-07-03 10:30:09', '2025-07-03 10:30:09'),
(5, 5, 1, 2, 0, 20798000, '2025-07-03 13:49:29', '2025-07-03 13:49:29');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'danuja.firmansyah', 'estiono98@ardianto.in', '$2y$10$x/aAfO1JpSIjFZxVuNBXOOX9p4/bKiLjbf8b3/LSnPTA4oajWLpCG', 'guest', '2025-05-23 05:58:48', NULL),
(2, 'empluk00', 'kurnia19@gmail.com', '$2y$10$0EI3XLcMTv1ef9vtV0FTfumFYPd91xlt9XZkdCBhRClbqVjdghlJu', 'admin', '2025-05-23 05:58:48', NULL),
(3, 'sihombing.atma', 'diana.widiastuti@widiastuti.mil.id', '$2y$10$uPqsnh11jg5MsLQROF72Uu93Z3x6UDFtfUzwJlIa9dY/sT.8IvlDm', 'admin', '2025-05-23 05:58:48', NULL),
(4, 'dongoran.jaiman', 'anita.widodo@yahoo.co.id', '$2y$10$.hOD22l1DQ3xFkpanZ.XO.6HjQ3nbNJt17N0AcKviHu.Fwqkj.sum', 'admin', '2025-05-23 05:58:48', NULL),
(5, 'wardaya88', 'dzulaika@palastri.id', '$2y$10$zrnEaTR8Rqke3G9XXcR6QujU6VzSBrmZe9NQNyKjdfOoaZzIKLJjS', 'admin', '2025-05-23 05:58:49', NULL),
(6, 'thamrin.lili', 'wibisono.hamzah@saptono.in', '$2y$10$4xXn7rhwQ9xIAkS58EqEjOSJi6bMIS.YgYnZlTUT9PN3XNd91wWZK', 'guest', '2025-05-23 05:58:49', NULL),
(7, 'bagas.astuti', 'tania46@gmail.co.id', '$2y$10$fyng77AKjyhlp5dgsGqJhei51AzeO.kKojk7hCGO7ijNLaANu9K/W', 'admin', '2025-05-23 05:58:49', NULL),
(8, 'wpranowo', 'onasyiah@zulaika.info', '$2y$10$evfjMzpnWqKwK3.S8hm9Fuvx/PPrGtrkY5GMjIEJHMh2d7aKvTwle', 'admin', '2025-05-23 05:58:49', NULL),
(9, 'briyanti', 'safitri.heryanto@pudjiastuti.sch.id', '$2y$10$jD7.cyQGwBXuGsTakIn3DukicvWr1kWWSUOzzbM938d1pQw6ChXGK', 'guest', '2025-05-23 05:58:49', NULL),
(10, 'tania81', 'mmustofa@gmail.com', '$2y$10$61Qa0Gz2qwpWqbDtftTtwOTAHzlGUU4skYyFIbDd5NNTjXuS0kSKy', 'admin', '2025-05-23 05:58:49', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `diskon`
--
ALTER TABLE `diskon`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tanggal` (`tanggal`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction_detail`
--
ALTER TABLE `transaction_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `diskon`
--
ALTER TABLE `diskon`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transaction_detail`
--
ALTER TABLE `transaction_detail`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
