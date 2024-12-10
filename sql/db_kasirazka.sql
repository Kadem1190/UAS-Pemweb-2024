-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2024 at 02:08 PM
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
-- Database: `db_kasirazka`
--

-- --------------------------------------------------------

--
-- Table structure for table `detailpesanan`
--

CREATE TABLE `detailpesanan` (
  `iddetailpesanan` int(11) NOT NULL,
  `idpesanan` int(11) NOT NULL,
  `idproduk` int(11) DEFAULT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detailpesanan`
--

INSERT INTO `detailpesanan` (`iddetailpesanan`, `idpesanan`, `idproduk`, `qty`) VALUES
(1, 0, 1, 1),
(2, 0, 2, 1),
(3, 0, 2, 1),
(4, 0, 3, 1),
(5, 0, 3, 1),
(6, 0, 3, 1),
(7, 0, 3, 1),
(8, 0, 3, 1),
(9, 0, 4, 1),
(0, 1, 5, 1),
(0, 2, 1, 1),
(0, 3, 4, 2),
(0, 4, 3, 2),
(0, 5, 5, 2),
(0, 6, 2, 2),
(0, 7, 1, 2),
(0, 8, 2, 1),
(0, 9, 1, 1),
(0, 10, 9, 2),
(0, 11, 1, 2),
(0, 12, 1, 2),
(0, 13, 2, 2),
(0, 14, 5, 2),
(0, 15, 2, 2),
(0, 16, 2, 2),
(0, 17, 1, 2),
(0, 18, 1, 2),
(0, 19, 1, 2);

--
-- Triggers `detailpesanan`
--
DELIMITER $$
CREATE TRIGGER `after_delete_detailpesanan` AFTER DELETE ON `detailpesanan` FOR EACH ROW BEGIN
    UPDATE produk 
    SET stok = stok + OLD.qty
    WHERE idproduk = OLD.idproduk;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_insert_detailpesanan` AFTER INSERT ON `detailpesanan` FOR EACH ROW BEGIN

    UPDATE produk 
    SET stok = stok - NEW.qty
    WHERE idproduk = NEW.idproduk;

    IF (SELECT stok FROM produk WHERE idproduk = NEW.idproduk) < 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Stok tidak mencukupi untuk produk ini';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `masuk`
--

CREATE TABLE `masuk` (
  `idmasuk` int(11) NOT NULL,
  `idproduk` int(11) DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `masuk`
--

INSERT INTO `masuk` (`idmasuk`, `idproduk`, `qty`, `tanggal`) VALUES
(1, 1, 20, '2024-12-04');

--
-- Triggers `masuk`
--
DELIMITER $$
CREATE TRIGGER `after_insert_masuk` AFTER INSERT ON `masuk` FOR EACH ROW BEGIN
    
    UPDATE produk 
    SET stok = stok + NEW.qty
    WHERE idproduk = NEW.idproduk;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `idpesanan` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `iduser` int(11) DEFAULT NULL,
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('pending','completed') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`idpesanan`, `tanggal`, `iduser`, `total`, `status`) VALUES
(3, '2024-12-10', 2, 2400000.00, 'completed'),
(4, '2024-12-10', 2, 3000000.00, 'completed'),
(5, '2024-12-10', 2, 1500000.00, 'completed'),
(6, '2024-12-10', 2, 3500000.00, 'completed'),
(7, '2024-12-10', 2, 4500000.00, 'completed'),
(10, '2024-12-10', 2, 700000.00, 'completed'),
(11, '2024-12-10', 2, 4500000.00, 'completed'),
(12, '2024-12-10', 2, 4500000.00, 'completed'),
(13, '2024-12-10', 2, 3500000.00, 'completed'),
(14, '2024-12-10', 2, 4500000.00, 'completed'),
(15, '2024-12-10', 1, 7000000.00, 'completed'),
(16, '2024-12-10', 1, 3500000.00, 'completed'),
(17, '2024-12-10', 2, 4500000.00, 'completed'),
(18, '2024-12-10', 2, 4500000.00, 'completed'),
(19, '2024-12-10', 1, 9000000.00, 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `idproduk` int(11) NOT NULL,
  `namaproduk` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`idproduk`, `namaproduk`, `deskripsi`, `harga`, `stok`) VALUES
(1, 'Kulkas', 'Kulkas dua pintu 200 liter', 4500000, 16),
(2, 'Mesin Cuci', 'Mesin cuci front load 7 kg', 3500000, 14),
(3, 'TV LED', 'TV LED 32 inci Full HD', 3000000, 24),
(4, 'Penyedot Debu', 'Penyedot debu tanpa kabel', 1200000, 28),
(5, 'Microwave', 'Microwave 20 liter', 1500000, 13),
(6, 'Blender', 'Blender multifungsi 1.5 liter', 600000, 40),
(7, 'Setrika', 'Setrika uap 1800 watt', 500000, 50),
(8, 'AC', 'AC 1 PK dengan inverter', 4000000, 10),
(9, 'Rice Cooker', 'Rice cooker 1 liter dengan pemanas', 700000, 34),
(10, 'Kipas Angin', 'Kipas angin berdiri 18 inci', 400000, 50),
(11, 'Lampu LED', 'Lampu LED hemat energi 9 watt', 200000, 75),
(12, 'Spear Speaker', 'Speaker bluetooth portable', 900000, 40),
(13, 'Kamera Keamanan', 'Kamera CCTV 1080p Wi-Fi', 1200000, 20),
(14, 'Set Komputer', 'PC desktop dengan monitor 21 inci', 5000000, 50),
(15, 'Smartphone', 'Smartphone 6GB RAM 128GB Storage', 2500000, 60),
(16, 'Tablet', 'Tablet Android 10 inci 4GB RAM', 2200000, 50),
(17, 'Oven Listrik', 'Oven listrik 25 liter', 1000000, 15),
(18, 'Hair Dryer', 'Hair dryer profesional', 300000, 45),
(19, 'Electric Kettle', 'Ketel listrik 1.5 liter', 350000, 65),
(20, 'Kamera Digital', 'Kamera digital 24 MP', 3500000, 12);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `iduser` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','kasir') NOT NULL DEFAULT 'kasir'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`iduser`, `username`, `password`, `role`) VALUES
(1, 'Admin', '$2y$10$i2rSXIuH3xlKH27v8wEhbe.buZSIt0mT9SfNLiUks2RnvZyFCQKbW', 'admin'),
(2, 'Kasir1', '$2y$10$goRebOOQSm0te4G2//zXN.OlgaZbBH79FKwF9Oj7rY/srq9/Kt05i', 'kasir'),
(3, 'Kasir2', '$2y$10$6db90WU3i1f/P/IBj/04uudwMlG.wOvrQB09/HOq3BUk46tZnhkiS', 'kasir'),
(4, 'Supervisor', '$2y$10$VDLNnEnMzh272jJ4LiDdwu0q1p1IGpgV12GB7bmXGOi02kUK8cyP.', 'admin'),
(5, 'Owner', '$2y$10$ZnP.MyxPfPg8RY3ITcQCpeoty0Bwcs0XuIFU0I/22rcPE0Ouodk7i', 'admin'),
(12, 'Backdoor', '$2y$10$Aq7HqMXs2j8iE0SxuGiOse0sbFT.ht73EmBy8Xc/XIfU4cbPx2FVG', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`idpesanan`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`iduser`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `idpesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
