-- MariaDB dump 10.17  Distrib 10.4.13-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: opensource
-- ------------------------------------------------------
-- Server version	10.4.13-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `caracteristicas`
--

DROP TABLE IF EXISTS `caracteristicas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `caracteristicas` (
  `id_carac` int(11) NOT NULL AUTO_INCREMENT,
  `color` varchar(25) NOT NULL,
  `procesador` varchar(30) NOT NULL,
  `Tarjeta_madre` varchar(30) NOT NULL,
  `RAM` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_carac`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `caracteristicas`
--

LOCK TABLES `caracteristicas` WRITE;
/*!40000 ALTER TABLE `caracteristicas` DISABLE KEYS */;
/*!40000 ALTER TABLE `caracteristicas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `equipos`
--

DROP TABLE IF EXISTS `equipos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `equipos` (
  `id_equipo` int(11) NOT NULL AUTO_INCREMENT,
  `Marca` varchar(30) NOT NULL DEFAULT 'NOT NULL',
  `Modelo` varchar(45) NOT NULL DEFAULT 'NOT NULL',
  `Nserie` varchar(45) NOT NULL DEFAULT 'NOT NUL',
  `Carac_fisicas` text NOT NULL,
  `id_tipo` int(11) DEFAULT NULL,
  `id_estado` int(11) DEFAULT NULL,
  `id_mantenimiento` int(11) DEFAULT NULL,
  `id_carac` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_equipo`),
  KEY `Equipos_id_tipo_Tipo_id_tipo` (`id_tipo`),
  KEY `Equipos_id_estado_Estado_id_estado` (`id_estado`),
  KEY `id_carac` (`id_carac`),
  KEY `Equipos_id_mantenimiento_Mantenimiento_id_mantenimiento` (`id_mantenimiento`),
  CONSTRAINT `Equipos_id_estado_Estado_id_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`),
  CONSTRAINT `Equipos_id_mantenimiento_Mantenimiento_id_mantenimiento` FOREIGN KEY (`id_mantenimiento`) REFERENCES `mantenimiento` (`id_mantenimiento`),
  CONSTRAINT `Equipos_id_tipo_Tipo_id_tipo` FOREIGN KEY (`id_tipo`) REFERENCES `tipo` (`id_tipo`),
  CONSTRAINT `equipos_ibfk_1` FOREIGN KEY (`id_carac`) REFERENCES `caracteristicas` (`id_carac`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipos`
--

LOCK TABLES `equipos` WRITE;
/*!40000 ALTER TABLE `equipos` DISABLE KEYS */;
/*!40000 ALTER TABLE `equipos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estado`
--

DROP TABLE IF EXISTS `estado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estado` (
  `id_estado` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`id_estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estado`
--

LOCK TABLES `estado` WRITE;
/*!40000 ALTER TABLE `estado` DISABLE KEYS */;
/*!40000 ALTER TABLE `estado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupo`
--

DROP TABLE IF EXISTS `grupo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grupo` (
  `id_grupo` int(11) NOT NULL AUTO_INCREMENT,
  `id_equipo` int(11) DEFAULT NULL,
  `Mesa` int(11) NOT NULL,
  PRIMARY KEY (`id_grupo`),
  KEY `Grupo_id_equipo_Equipos_id_equipo` (`id_equipo`),
  CONSTRAINT `Grupo_id_equipo_Equipos_id_equipo` FOREIGN KEY (`id_equipo`) REFERENCES `equipos` (`id_equipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupo`
--

LOCK TABLES `grupo` WRITE;
/*!40000 ALTER TABLE `grupo` DISABLE KEYS */;
/*!40000 ALTER TABLE `grupo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantenimiento`
--

DROP TABLE IF EXISTS `mantenimiento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mantenimiento` (
  `id_mantenimiento` int(11) NOT NULL AUTO_INCREMENT,
  `Tipo` varchar(50) NOT NULL,
  `Fecha_mantenimiento` date NOT NULL,
  `Observaciones` text NOT NULL,
  PRIMARY KEY (`id_mantenimiento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mantenimiento`
--

LOCK TABLES `mantenimiento` WRITE;
/*!40000 ALTER TABLE `mantenimiento` DISABLE KEYS */;
/*!40000 ALTER TABLE `mantenimiento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `solicitud`
--

DROP TABLE IF EXISTS `solicitud`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `solicitud` (
  `id_solicitud` int(11) NOT NULL AUTO_INCREMENT,
  `id_equipo` int(11) DEFAULT NULL,
  `Tipo` varchar(35) NOT NULL,
  `observacion` text DEFAULT NULL,
  PRIMARY KEY (`id_solicitud`),
  KEY `Solicitud_id_equipo_Equipos_id_equipo` (`id_equipo`),
  CONSTRAINT `Solicitud_id_equipo_Equipos_id_equipo` FOREIGN KEY (`id_equipo`) REFERENCES `equipos` (`id_equipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `solicitud`
--

LOCK TABLES `solicitud` WRITE;
/*!40000 ALTER TABLE `solicitud` DISABLE KEYS */;
/*!40000 ALTER TABLE `solicitud` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo`
--

DROP TABLE IF EXISTS `tipo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo` (
  `id_tipo` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`id_tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo`
--

LOCK TABLES `tipo` WRITE;
/*!40000 ALTER TABLE `tipo` DISABLE KEYS */;
/*!40000 ALTER TABLE `tipo` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-06-30 21:55:51
