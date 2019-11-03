# LoginBackend_PHP

This is the backend made for the LoginFrontend_Angularv2.0 app.

The backend is basically consumed as an REST API by Angular. 

Run the following queries for creating the Database and to have some data for testing: 

-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Nov 03, 2019 at 12:45 AM
-- Server version: 5.7.26
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `Proyecto`
--

-- --------------------------------------------------------

--
-- Table structure for table `deproyecto`
--

CREATE TABLE `deproyecto` (
  `deproyectoid` int(11) NOT NULL,
  `proyectoid` int(11) DEFAULT NULL,
  `titulo` varchar(50) DEFAULT NULL,
  `descripcion` text,
  `fecha` date DEFAULT NULL,
  `usuid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `proyecto`
--

CREATE TABLE `proyecto` (
  `proyectoid` int(11) NOT NULL,
  `titulo` varchar(50) DEFAULT NULL,
  `descripcion` text,
  `fecestimada` date DEFAULT NULL,
  `fecentrega` date DEFAULT NULL,
  `horas` varchar(4) DEFAULT NULL,
  `usuid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `proyecto`
--

INSERT INTO `proyecto` (`proyectoid`, `titulo`, `descripcion`, `fecestimada`, `fecentrega`, `horas`, `usuid`) VALUES
(67, 'proyecto de ola', 'proyecto de ola descripcion sisis olaolaola', '2019-09-11', '2019-09-12', '2', 31),
(70, 'jueputa', 'malditasea', '2019-10-02', '2019-10-03', '2', 4),
(78, 'con Richard', 'Richard', '2019-10-02', '2019-10-03', '1', 4),
(79, 'sin Richard', 'Richard se fue', '2019-10-02', '2019-10-03', '1', 4),
(95, 'Editado', 'jaja xdxdxd', '2019-10-02', '2019-10-03', '1', 4),
(96, 'con Camilo', 'Camilo si esta xdxdxdxd', '2019-10-02', '2019-10-03', '1', 4),
(99, 'alert', 'probando el alert :vvvv', '2019-10-03', '2019-10-05', '2', 4),
(100, 'alert2.0', 'la alerta pasada se totió :v', '2019-10-03', '2019-10-05', '2', 4),
(106, 'con petición', 'con petición en el delegado', '2019-10-05', '2019-10-07', '2', 4),
(107, 'Eli', 'preliminar:v', '2019-10-06', '2019-10-08', '2', 4),
(109, 'abrnuma', 'proyecto de numaxdxxdxxd', '2019-10-09', '2019-10-10', '2', 35),
(110, 'con yorluis', 'ola', '2019-10-02', '2019-09-01', '5', 4);

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `usuid` int(11) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `contrasena` varchar(50) NOT NULL,
  `rol` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`usuid`, `codigo`, `nombre`, `contrasena`, `rol`) VALUES
(4, 'iamandres17@gmail.com', 'Andrés Carrillo', 'YI0R8udDA7', 1),
(31, 'olaedit@ola.co', 'Ola como estas', '1', 0),
(32, 'si@gmail.com', 'si', 'ola123', 0),
(35, 'numa@numasisierto.nu', 'numa sisierto', 'numa123', 1),
(36, 'add@add.add', 'addsi', '1', 0),
(37, 'admin@admin.admin', 'administración', '1', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `deproyecto`
--
ALTER TABLE `deproyecto`
  ADD PRIMARY KEY (`deproyectoid`),
  ADD KEY `rel_usu` (`usuid`),
  ADD KEY `rel_proy` (`proyectoid`);

--
-- Indexes for table `proyecto`
--
ALTER TABLE `proyecto`
  ADD PRIMARY KEY (`proyectoid`),
  ADD KEY `proyecto_ibfk_1` (`usuid`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usuid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `deproyecto`
--
ALTER TABLE `deproyecto`
  MODIFY `deproyectoid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `proyecto`
--
ALTER TABLE `proyecto`
  MODIFY `proyectoid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usuid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `deproyecto`
--
ALTER TABLE `deproyecto`
  ADD CONSTRAINT `rel_proy` FOREIGN KEY (`proyectoid`) REFERENCES `proyecto` (`proyectoid`) ON DELETE CASCADE,
  ADD CONSTRAINT `rel_usu` FOREIGN KEY (`usuid`) REFERENCES `usuario` (`usuid`) ON DELETE CASCADE;

--
-- Constraints for table `proyecto`
--
ALTER TABLE `proyecto`
  ADD CONSTRAINT `proyecto_ibfk_1` FOREIGN KEY (`usuid`) REFERENCES `usuario` (`usuid`) ON DELETE CASCADE ON UPDATE NO ACTION;
