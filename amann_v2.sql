-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2017 at 11:16 AM
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
  `nohp_pengguna` varchar(256) NOT NULL,
  `nama_daerah` varchar(256) NOT NULL,
  `deskripsi_daerah` varchar(1024) NOT NULL,
  `gambar_daerah` varchar(1024) NOT NULL,
  `lat_daerah` double NOT NULL,
  `lng_daerah` double NOT NULL,
  `waktu` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `kantor_polisi` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(1, '', 1, '');

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
(1, 'NGAHAHA', 'irfan', 'irfan', 'irfan', '081311027844', '1996-08-16', 'Male');

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
