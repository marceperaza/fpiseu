-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 16, 2015 at 01:44 AM
-- Server version: 10.0.22-MariaDB
-- PHP Version: 5.6.14

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fpiseu`
--
CREATE DATABASE IF NOT EXISTS `fpiseu` DEFAULT CHARACTER SET latin1 COLLATE latin1_spanish_ci;
USE `fpiseu`;

-- --------------------------------------------------------

--
-- Table structure for table `seu_perfiles`
--

DROP TABLE IF EXISTS `seu_perfiles`;
CREATE TABLE IF NOT EXISTS `seu_perfiles` (
  `id_perfil` int(11) NOT NULL AUTO_INCREMENT,
  `perfil` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`id_perfil`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seu_permisos`
--

DROP TABLE IF EXISTS `seu_permisos`;
CREATE TABLE IF NOT EXISTS `seu_permisos` (
  `id_permiso` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_perfil` int(11) NOT NULL,
  `permiso_modulo` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `permiso_mask` bigint(20) NOT NULL,
  PRIMARY KEY (`id_permiso`),
  UNIQUE KEY `id_usuario_2` (`id_usuario`,`id_perfil`,`permiso_modulo`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_perfil` (`id_perfil`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seu_usuarios`
--

DROP TABLE IF EXISTS `seu_usuarios`;
CREATE TABLE IF NOT EXISTS `seu_usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `clave` varchar(107) COLLATE latin1_spanish_ci NOT NULL,
  `nombres` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `apellidos` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `usuario_mask` int(11) NOT NULL,
  `usuario_tipo` int(11) NOT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `seu_permisos`
--
ALTER TABLE `seu_permisos`
  ADD CONSTRAINT `seu_permisos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `seu_usuarios` (`id_usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `seu_permisos_ibfk_2` FOREIGN KEY (`id_perfil`) REFERENCES `seu_perfiles` (`id_perfil`) ON DELETE CASCADE;
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
