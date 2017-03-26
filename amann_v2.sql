-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 26, 2017 at 05:13 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `amann_v2`
--

-- --------------------------------------------------------

--
-- Table structure for table `daerahrawan`
--

CREATE TABLE `daerahrawan` (
  `id_daerah` int(11) NOT NULL,
  `email_pengguna` varchar(256) NOT NULL,
  `nama_daerah` varchar(256) NOT NULL,
  `deskripsi_daerah` varchar(1024) NOT NULL,
  `gambar_daerah` varchar(1024) DEFAULT NULL,
  `lat_daerah` double NOT NULL,
  `lng_daerah` double NOT NULL,
  `waktu` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `kantor_polisi` double DEFAULT NULL,
  `status` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `daerahrawan`
--

INSERT INTO `daerahrawan` (`id_daerah`, `email_pengguna`, `nama_daerah`, `deskripsi_daerah`, `gambar_daerah`, `lat_daerah`, `lng_daerah`, `waktu`, `kantor_polisi`, `status`) VALUES
(1, 'irfan', 'Indonesia', 'Rawan Kecelakaan', NULL, -6.2443093, 106.8032679, '2017-03-26 03:13:22', NULL, 'AMAN'),
(2, 'irfan', 'Indonesia', 'Jalan gelap rawan perampokan', NULL, -6.2443093, 106.8032679, '2017-03-26 03:13:26', 584.0218443223617, 'RAWAN'),
(3, 'irfan', 'Indonesia', 'Daerah rawan penculikan', NULL, -6.2446497, 106.8029048, '2017-03-26 03:13:31', 503.5794914896314, 'AMAN'),
(4, 'irfan', '2,Kebayoran Baru,South Jakarta City,Jakarta', 'Rawan penculikan', NULL, -6.2443093, 106.8032679, '2017-03-26 03:13:35', 584.0218443223617, 'RAWAN'),
(5, 'ikhsan', 'Nusa Indah,Kebayoran Baru,South Jakarta City,Jakarta', 'Sering terjadi tabrakan kendaraan', NULL, -6.2446497, 106.8029048, '2017-03-26 03:13:39', 503.5794914896314, 'RAWAN'),
(6, 'ikhsan', 'Jalan Raya Punggul,Abiansemal,Badung Regency,Bali', 'Jam-jam galau', NULL, -8.5076983, 115.2182418, '2017-03-26 03:13:42', 1873243.6901038366, 'RAWAN');

-- --------------------------------------------------------

--
-- Table structure for table `helper`
--

CREATE TABLE `helper` (
  `id_helper` int(11) NOT NULL,
  `nohp_helper` varchar(256) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `token_helper` varchar(512) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `helper`
--

INSERT INTO `helper` (`id_helper`, `nohp_helper`, `id_pengguna`, `token_helper`) VALUES
(1, '', 1, ''),
(3, '081311027844', 2, NULL),
(8, '08522', 3, 'dB64w9ti-gs:APA91bEnFGLj1sxs8axrhJtO_lTefNNHL003gPhoPUZXuWfcYFtVNa_KXj3-NeF_ddkQSZgAjiluNrRvAUmZANHqGqQWeFvDU4jq2Px5gnyXyHK0L-QOQRfk2D5AO5kRfK2AGErHIiux'),
(9, '08555', 3, NULL),
(10, '08555', 3, NULL),
(11, '06555', 3, NULL),
(12, '06655', 3, NULL),
(13, '86352', 3, NULL),
(14, '08556', 4, NULL),
(15, '08555', 4, NULL),
(16, '044568', 4, NULL),
(17, '08455', 4, NULL),
(18, '88544', 4, NULL),
(19, '065785', 4, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `token_pengguna` varchar(512) NOT NULL,
  `nama_pengguna` varchar(256) NOT NULL,
  `email_pengguna` varchar(256) NOT NULL,
  `password_pengguna` varchar(256) NOT NULL,
  `nohp_pengguna` varchar(256) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `sex` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `token_pengguna`, `nama_pengguna`, `email_pengguna`, `password_pengguna`, `nohp_pengguna`, `tgl_lahir`, `sex`) VALUES
(1, 'dB64w9ti-gs:APA91bEnFGLj1sxs8axrhJtO_lTefNNHL003gPhoPUZXuWfcYFtVNa_KXj3-NeF_ddkQSZgAjiluNrRvAUmZANHqGqQWeFvDU4jq2Px5gnyXyHK0L-QOQRfk2D5AO5kRfK2AGErHIiux', 'irfan', 'irfan', 'irfan', '081311027844', '1996-08-16', 'Male'),
(2, 'cq09fCeeyU0:APA91bEzDlSc-hQmG0WpG28oXVZ_kWNpsZ1Gi1S7P5RO6BPtwSGSZvT_XGdhNWPeBXaGQ0HbXEXBwrBzZu2Ys6ALVShXR08bCOS23TUQZoTTYldqH7Y5CgWFThOlzRNrlK6hCK8Gehuk', 'tes', 'ikhsan', 'ikhsan', '08123123', '2001-12-02', 'male'),
(3, 'null', 'Abc', 'a@a.com', 'abc', '084226', '2001-12-07', 'Male'),
(4, 'null', 'Jsjsjs', 'a@a.com', 'njdjdjd', '05588', '2012-12-17', 'Female');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `daerahrawan`
--
ALTER TABLE `daerahrawan`
  ADD PRIMARY KEY (`id_daerah`);

--
-- Indexes for table `helper`
--
ALTER TABLE `helper`
  ADD PRIMARY KEY (`id_helper`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`),
  ADD UNIQUE KEY `nohp_pengguna` (`nohp_pengguna`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `daerahrawan`
--
ALTER TABLE `daerahrawan`
  MODIFY `id_daerah` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
