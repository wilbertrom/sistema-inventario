-- MySQL dump 10.13  Distrib 8.0.33, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: sistemainv
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.13-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categorias`
--

DROP TABLE IF EXISTS `categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_categoria` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias`
--

/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` VALUES (1,'Suministros'),(2,'Sistemas de seguridad'),(3,'Condiciones');
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;

--
-- Table structure for table `ccompu`
--

DROP TABLE IF EXISTS `ccompu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ccompu` (
  `id_ccompus` int(11) NOT NULL AUTO_INCREMENT,
  `procesador` varchar(45) NOT NULL,
  `tarjeta` varchar(45) NOT NULL,
  `ram` varchar(45) NOT NULL,
  `disco` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_ccompus`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ccompu`
--

/*!40000 ALTER TABLE `ccompu` DISABLE KEYS */;
/*!40000 ALTER TABLE `ccompu` ENABLE KEYS */;

--
-- Table structure for table `equipos`
--

DROP TABLE IF EXISTS `equipos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `equipos` (
  `id_equipos` int(11) NOT NULL AUTO_INCREMENT,
  `modelo` varchar(45) DEFAULT NULL,
  `cod_interno` varchar(45) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `id_ccompus` int(11) DEFAULT NULL,
  `id_tipos` int(11) NOT NULL,
  `id_estados` int(11) NOT NULL,
  `id_marcas` int(11) NOT NULL,
  `imagen` varchar(150) DEFAULT NULL,
  `id_grupos` int(11) DEFAULT NULL,
  `activo` binary(1) DEFAULT '1',
  PRIMARY KEY (`id_equipos`),
  KEY `fk_equipos_ccompu` (`id_ccompus`),
  KEY `fk_equipos_tipos1` (`id_tipos`),
  KEY `fk_equipos_estados1` (`id_estados`),
  KEY `fk_equipos_marcas1` (`id_marcas`),
  KEY `id_grupos` (`id_grupos`),
  CONSTRAINT `equipos_ibfk_1` FOREIGN KEY (`id_grupos`) REFERENCES `grupos` (`id_grupos`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_equipos_ccompu` FOREIGN KEY (`id_ccompus`) REFERENCES `ccompu` (`id_ccompus`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_equipos_estados1` FOREIGN KEY (`id_estados`) REFERENCES `estados` (`id_estados`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_equipos_marcas1` FOREIGN KEY (`id_marcas`) REFERENCES `marcas` (`id_marcas`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_equipos_tipos1` FOREIGN KEY (`id_tipos`) REFERENCES `tipos` (`id_tipos`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'IGNORE_SPACE,NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER trg_historial_estado



AFTER UPDATE ON equipos



FOR EACH ROW



BEGIN



    IF NEW.id_estados <> OLD.id_estados THEN



        INSERT INTO historial_estado (id_equipos, estado_antes, estado_despues, fecha)



        VALUES (OLD.id_equipos, OLD.id_estados, NEW.id_estados, NOW());



    END IF;



END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `estados`
--

DROP TABLE IF EXISTS `estados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estados` (
  `id_estados` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id_estados`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estados`
--

/*!40000 ALTER TABLE `estados` DISABLE KEYS */;
INSERT INTO `estados` VALUES (1,'En servicio'),(2,'Fuera de servicio'),(3,'En mantenimiento');
/*!40000 ALTER TABLE `estados` ENABLE KEYS */;

--
-- Table structure for table `grupos`
--

DROP TABLE IF EXISTS `grupos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `grupos` (
  `id_grupos` int(11) NOT NULL AUTO_INCREMENT,
  `id_mesas` int(11) NOT NULL,
  PRIMARY KEY (`id_grupos`),
  KEY `id_mesas` (`id_mesas`),
  CONSTRAINT `grupos_ibfk_1` FOREIGN KEY (`id_mesas`) REFERENCES `mesas` (`id_mesas`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupos`
--

/*!40000 ALTER TABLE `grupos` DISABLE KEYS */;
INSERT INTO `grupos` VALUES (1,1),(2,1),(3,1),(4,1),(6,2),(7,2),(8,2),(9,2),(10,3),(11,3),(12,3),(13,3),(14,4),(15,4),(16,4),(17,4),(18,5),(19,5),(20,5),(21,5),(22,6),(23,6),(24,6),(25,6),(26,7),(27,7),(28,7),(29,7),(30,8),(31,8),(32,8),(33,8);
/*!40000 ALTER TABLE `grupos` ENABLE KEYS */;

--
-- Table structure for table `historial_estado`
--

DROP TABLE IF EXISTS `historial_estado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `historial_estado` (
  `id_hest` int(11) NOT NULL AUTO_INCREMENT,
  `id_equipos` int(11) NOT NULL,
  `estado_antes` int(11) NOT NULL,
  `estado_despues` int(11) NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY (`id_hest`),
  KEY `historial_estado_ibfk_1` (`id_equipos`),
  CONSTRAINT `historial_estado_ibfk_1` FOREIGN KEY (`id_equipos`) REFERENCES `equipos` (`id_equipos`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historial_estado`
--

/*!40000 ALTER TABLE `historial_estado` DISABLE KEYS */;
/*!40000 ALTER TABLE `historial_estado` ENABLE KEYS */;

--
-- Table structure for table `items_requisiciones`
--

DROP TABLE IF EXISTS `items_requisiciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `items_requisiciones` (
  `id_items_r` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `id_req` int(11) NOT NULL,
  PRIMARY KEY (`id_items_r`),
  KEY `items_requisiciones_ibfk_1` (`id_req`),
  CONSTRAINT `items_requisiciones_ibfk_1` FOREIGN KEY (`id_req`) REFERENCES `requisiciones` (`id_req`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `items_requisiciones`
--

/*!40000 ALTER TABLE `items_requisiciones` DISABLE KEYS */;
/*!40000 ALTER TABLE `items_requisiciones` ENABLE KEYS */;

--
-- Table structure for table `mantenimientos`
--

DROP TABLE IF EXISTS `mantenimientos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mantenimientos` (
  `id_mantenimientos` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `descripcion` text NOT NULL,
  `especificacion` text DEFAULT NULL,
  `id_equipos` int(11) NOT NULL,
  `estado` int(1) NOT NULL,
  PRIMARY KEY (`id_mantenimientos`),
  KEY `MantToEquipos` (`id_equipos`),
  CONSTRAINT `MantToEquipos` FOREIGN KEY (`id_equipos`) REFERENCES `equipos` (`id_equipos`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mantenimientos`
--

/*!40000 ALTER TABLE `mantenimientos` DISABLE KEYS */;
/*!40000 ALTER TABLE `mantenimientos` ENABLE KEYS */;

--
-- Table structure for table `marcas`
--

DROP TABLE IF EXISTS `marcas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `marcas` (
  `id_marcas` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id_marcas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `marcas`
--

/*!40000 ALTER TABLE `marcas` DISABLE KEYS */;
INSERT INTO `marcas` (`id_marcas`,`nombre`) VALUES (1,'GHIA');
INSERT INTO `marcas` (`id_marcas`,`nombre`) VALUES (2,'VORAGO');
INSERT INTO `marcas` (`id_marcas`,`nombre`) VALUES (3,'TRUEBASIX');
INSERT INTO `marcas` (`id_marcas`,`nombre`) VALUES (4,'LOGITECH');
INSERT INTO `marcas` (`id_marcas`,`nombre`) VALUES (5,'ACTECK');
INSERT INTO `marcas` (`id_marcas`,`nombre`) VALUES (6,'SIN MARCA');
INSERT INTO `marcas` (`id_marcas`,`nombre`) VALUES (7,'CERANTOLA');
INSERT INTO `marcas` (`id_marcas`,`nombre`) VALUES (8,'STILA');
INSERT INTO `marcas` (`id_marcas`,`nombre`) VALUES (9,'BENQ');
INSERT INTO `marcas` (`id_marcas`,`nombre`) VALUES (10,'OFILINEA');
INSERT INTO `marcas` (`id_marcas`,`nombre`) VALUES (11,'CISIT');
INSERT INTO `marcas` (`id_marcas`,`nombre`) VALUES (12,'LENOVO');
INSERT INTO `marcas` (`id_marcas`,`nombre`) VALUES (13,'DELL');
INSERT INTO `marcas` (`id_marcas`,`nombre`) VALUES (14,'EASY');
INSERT INTO `marcas` (`id_marcas`,`nombre`) VALUES (15,'HP');
INSERT INTO `marcas` (`id_marcas`,`nombre`) VALUES (16,'EPSON');
INSERT INTO `marcas` (`id_marcas`,`nombre`) VALUES (17,'AASTRA');
INSERT INTO `marcas` (`id_marcas`,`nombre`) VALUES (18,'GEBESA');
INSERT INTO `marcas` (`id_marcas`,`nombre`) VALUES (19,'MANHATTAN');
INSERT INTO `marcas` (`id_marcas`,`nombre`) VALUES (20,'STEREN');
INSERT INTO `marcas` (`id_marcas`,`nombre`) VALUES (21,'SMART');
INSERT INTO `marcas` (`id_marcas`,`nombre`) VALUES (22,'PRETUL');
INSERT INTO `marcas` (`id_marcas`,`nombre`) VALUES (23,'SONY');
INSERT INTO `marcas` (`id_marcas`,`nombre`) VALUES (24,'LG');
/*!40000 ALTER TABLE `marcas` ENABLE KEYS */;

--
-- Table structure for table `mesas`
--

DROP TABLE IF EXISTS `mesas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mesas` (
  `id_mesas` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`id_mesas`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mesas`
--

/*!40000 ALTER TABLE `mesas` DISABLE KEYS */;
INSERT INTO `mesas` VALUES (1,'Mesa 1'),(2,'Mesa 2'),(3,'Mesa 3'),(4,'Mesa 4'),(5,'Mesa 5'),(6,'Mesa 6'),(7,'Mesa 7'),(8,'Mesa 8');
/*!40000 ALTER TABLE `mesas` ENABLE KEYS */;

--
-- Table structure for table `registro_mensual`
--

DROP TABLE IF EXISTS `registro_mensual`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `registro_mensual` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reporte_id` int(11) DEFAULT NULL,
  `servicio_id` int(11) DEFAULT NULL,
  `mes` int(2) NOT NULL,
  `status` enum('SI','NO','NA','') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `reporte_id` (`reporte_id`,`servicio_id`,`mes`),
  KEY `servicio_id` (`servicio_id`),
  CONSTRAINT `registro_mensual_ibfk_1` FOREIGN KEY (`reporte_id`) REFERENCES `reporte_anual` (`id`),
  CONSTRAINT `registro_mensual_ibfk_2` FOREIGN KEY (`servicio_id`) REFERENCES `servicio` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=117 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registro_mensual`
--

/*!40000 ALTER TABLE `registro_mensual` DISABLE KEYS */;
INSERT INTO `registro_mensual` VALUES (48,1,2,1,'NO'),(49,1,3,1,'SI'),(50,1,4,1,'NA'),(51,1,5,1,'NO'),(52,1,6,1,'NO'),(53,1,7,1,'SI'),(54,1,8,1,'SI'),(55,1,9,1,'SI'),(56,1,10,1,'SI'),(57,1,11,1,'SI'),(58,1,12,1,'SI'),(59,1,13,1,'SI'),(60,1,14,1,'SI'),(61,1,15,1,'SI'),(62,1,16,1,'SI'),(63,1,17,1,'SI'),(64,1,18,1,'SI'),(65,1,19,1,'SI'),(66,1,20,1,'SI'),(67,1,21,1,'SI'),(68,1,22,1,'NA'),(69,1,23,1,'NA'),(70,1,1,1,'NA'),(71,1,1,2,'NA'),(72,1,2,2,'NA'),(73,1,3,2,'NA'),(74,1,4,2,'SI'),(75,1,5,2,'NO'),(76,1,6,2,'NO'),(77,1,7,2,'NA'),(78,1,8,2,'SI'),(79,1,9,2,'NO'),(80,1,10,2,'NO'),(81,1,11,2,'NO'),(82,1,12,2,'NO'),(83,1,13,2,'NO'),(84,1,14,2,'NO'),(85,1,15,2,'SI'),(86,1,16,2,'NA'),(87,1,17,2,'SI'),(88,1,18,2,'SI'),(89,1,19,2,'SI'),(90,1,20,2,'SI'),(91,1,21,2,'NO'),(92,1,22,2,'NO'),(93,1,23,2,'NA'),(94,1,1,3,'NA'),(95,1,2,3,'NA'),(96,1,3,3,'NA'),(97,1,4,3,'SI'),(98,1,5,3,'NA'),(99,1,6,3,'NA'),(100,1,7,3,'NA'),(101,1,8,3,'SI'),(102,1,9,3,'NA'),(103,1,10,3,'NA'),(104,1,11,3,'NA'),(105,1,12,3,'NO'),(106,1,13,3,'NO'),(107,1,14,3,'NA'),(108,1,15,3,'SI'),(109,1,16,3,'NA'),(110,1,17,3,'SI'),(111,1,18,3,'SI'),(112,1,19,3,'SI'),(113,1,20,3,'SI'),(114,1,21,3,'NA'),(115,1,22,3,'NA'),(116,1,23,3,'NA');
/*!40000 ALTER TABLE `registro_mensual` ENABLE KEYS */;

--
-- Table structure for table `reporte_anual`
--

DROP TABLE IF EXISTS `reporte_anual`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reporte_anual` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `año` year(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reporte_anual`
--

/*!40000 ALTER TABLE `reporte_anual` DISABLE KEYS */;
INSERT INTO `reporte_anual` VALUES (1,2024);
/*!40000 ALTER TABLE `reporte_anual` ENABLE KEYS */;

--
-- Table structure for table `requisiciones`
--

DROP TABLE IF EXISTS `requisiciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `requisiciones` (
  `id_req` int(11) NOT NULL AUTO_INCREMENT,
  `razon` text NOT NULL,
  `proposito` text NOT NULL,
  `partida_p` varchar(50) NOT NULL,
  `fecha_actual` date DEFAULT curdate(),
  PRIMARY KEY (`id_req`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `requisiciones`
--

/*!40000 ALTER TABLE `requisiciones` DISABLE KEYS */;
/*!40000 ALTER TABLE `requisiciones` ENABLE KEYS */;

--
-- Table structure for table `servicio`
--

DROP TABLE IF EXISTS `servicio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `servicio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_servicio` varchar(255) NOT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categoria_id` (`categoria_id`),
  CONSTRAINT `servicio_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servicio`
--

/*!40000 ALTER TABLE `servicio` DISABLE KEYS */;
INSERT INTO `servicio` VALUES (1,'Aire a presion',1),(2,'Agua',1),(3,'Gas',1),(4,'Electricidad',1),(5,'Vapor',1),(6,'Aire comprimido',1),(7,'Otros',1),(8,'Extintores',2),(9,'Regaderas',2),(10,'Lavaojos',2),(11,'Extractores de gases',2),(12,'Botiquín',2),(13,'Alarma contra Incendio y Emergencia (pánico)',2),(14,'Rutas de evacuacion de Emergencia y RPBI',2),(15,'Sistema de Monitoreo por Cámaras',2),(16,'otros',2),(17,'Orden y limpieza',3),(18,'Ventilación',3),(19,'Iluminación',3),(20,'Recipientes para basura',3),(21,'Contenedores especiales',3),(22,'Manejo de Residuos Biologico, Infecciosos, Punzocortantes y Químicos',3),(23,'Otros',3);
/*!40000 ALTER TABLE `servicio` ENABLE KEYS */;

--
-- Table structure for table `tipos`
--

DROP TABLE IF EXISTS `tipos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipos` (
  `id_tipos` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id_tipos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipos`
--

/*!40000 ALTER TABLE `tipos` DISABLE KEYS */;
INSERT INTO `tipos` (`id_tipos`,`nombre`) VALUES (1,'MONITOR');
INSERT INTO `tipos` (`id_tipos`,`nombre`) VALUES (2,'CPU');
INSERT INTO `tipos` (`id_tipos`,`nombre`) VALUES (3,'MOUSE');
INSERT INTO `tipos` (`id_tipos`,`nombre`) VALUES (4,'TECLADO');
INSERT INTO `tipos` (`id_tipos`,`nombre`) VALUES (5,'SILLA');
INSERT INTO `tipos` (`id_tipos`,`nombre`) VALUES (6,'MESA');
INSERT INTO `tipos` (`id_tipos`,`nombre`) VALUES (7,'ESCRITORIO');
INSERT INTO `tipos` (`id_tipos`,`nombre`) VALUES (8,'PIZARRÓN');
INSERT INTO `tipos` (`id_tipos`,`nombre`) VALUES (9,'PANTALLA');
INSERT INTO `tipos` (`id_tipos`,`nombre`) VALUES (10,'PROYECTOR');
INSERT INTO `tipos` (`id_tipos`,`nombre`) VALUES (11,'ESTANTE');
INSERT INTO `tipos` (`id_tipos`,`nombre`) VALUES (12,'EXTINTOR');
INSERT INTO `tipos` (`id_tipos`,`nombre`) VALUES (13,'IMPRESORA');
INSERT INTO `tipos` (`id_tipos`,`nombre`) VALUES (14,'TELÉFONO');
INSERT INTO `tipos` (`id_tipos`,`nombre`) VALUES (15,'ARCHIVERO');
INSERT INTO `tipos` (`id_tipos`,`nombre`) VALUES (16,'CABLE');
INSERT INTO `tipos` (`id_tipos`,`nombre`) VALUES (17,'COPLE');
INSERT INTO `tipos` (`id_tipos`,`nombre`) VALUES (18,'CONTROL');
INSERT INTO `tipos` (`id_tipos`,`nombre`) VALUES (19,'HERRAMIENTA');
INSERT INTO `tipos` (`id_tipos`,`nombre`) VALUES (20,'GRABADORA');
INSERT INTO `tipos` (`id_tipos`,`nombre`) VALUES (21,'BOCINAS');
INSERT INTO `tipos` (`id_tipos`,`nombre`) VALUES (22,'MINI SPLIT');

/*!40000 ALTER TABLE `tipos` ENABLE KEYS */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `imagen` varchar(55) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Administrador','4f5304d0a069388f5057c385b23b2514353c17db255d26397165fb2ba5873f7f','admin@sistema.com','2024-06-27 16:36:19','1.png'),(2,'Maxima','e1cbd789f8fecdae6814ff55b4022e32ea63e304bc597d35d19faf3c3065c381','maxima@gmail.com','2024-07-24 22:26:24','2.png'),(3,'invitado','4c065d8484986f6ac8f2922dc58b0591b49672b66730bf817f1817b24cc17644','invitado@gmail.com','2024-08-12 15:24:21',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

--
-- Dumping data for table `equipos`
--

/*!40000 ALTER TABLE `equipos` DISABLE KEYS */;
INSERT INTO equipos (id_equipos, id_tipos, cod_interno, id_marcas, id_estados, descripcion) VALUES
(null, 1, 'OPEN SOURCE -MONITOR 1', 1, 1, '5151000135-185'),
(null, 1, 'OPEN SOURCE -MONITOR 2', 1, 1, '5151000135-196'),
(null, 1, 'OPEN SOURCE -MONITOR 3', 1, 1, null),
(null, 1, 'OPEN SOURCE -MONITOR 4', 1, 1, '5151000135-195'),
(null, 1, 'OPEN SOURCE -MONITOR 5', 1, 1, '5151000135-198'),
(null, 1, 'OPEN SOURCE -MONITOR 6', 1, 1, null),
(null, 1, 'OPEN SOURCE -MONITOR 7', 1, 1, null),
(null, 1, 'OPEN SOURCE -MONITOR 8', 1, 1, '5151000135-199'),
(null, 1, 'OPEN SOURCE -MONITOR 9', 1, 1, '5151000135-200'),
(null, 1, 'OPEN SOURCE -MONITOR 10', 1, 1, null),
(null, 1, 'OPEN SOURCE -MONITOR 11', 1, 1, null),
(null, 1, 'OPEN SOURCE -MONITOR 12', 1, 1, null),
(null, 1, 'OPEN SOURCE -MONITOR 13', 1, 1, null),
(null, 1, 'OPEN SOURCE -MONITOR 14', 1, 1, null),
(null, 1, 'OPEN SOURCE-MONITOR 15', 1, 1, null),
(null, 1, 'OPEN SOURCE-MONITOR 16', 1, 1, null),
(null, 1, 'OPEN SOURCE-MONITOR 17', 1, 1, '5151000135-189'),
(null, 1, 'OPEN SOURCE-MONITOR 18', 1, 1, '5151000135-184'),
(null, 1, 'OPEN SOURCE-MONITOR 19', 1, 1, null),
(null, 1, 'OPEN SOURCE-MONITOR 20', 1, 1, null),
(null, 1, 'OPEN SOURCE-MONITOR 21', 1, 1, '5151000135-230'),
(null, 1, 'OPEN SOURCE-MONITOR 22', 1, 1, '5151000135-182'),
(null, 1, 'OPEN SOURCE-MONITOR 23', 1, 1, '5151000135-181'),
(null, 1, 'OPEN SOURCE-MONITOR 24', 1, 1, '5151000135-231'),
(null, 1, 'OPEN SOURCE-MONITOR 25', 1, 1, '5151000135-191'),
(null, 1, 'OPEN SOURCE-MONITOR 26', 1, 1, null),
(null, 1, 'OPEN SOURCE-MONITOR 27', 1, 1, '5151000135-179'),
(null, 1, 'OPEN SOURCE-MONITOR 28', 1, 1, null),
(null, 1, 'OPEN SOURCE-MONITOR 29', 1, 1, '5151000135-192'),
(null, 1, 'OPEN SOURCE-MONITOR 30', 1, 1, '5151000135-178'),
(null, 1, 'OPEN SOURCE-MONITOR31', 1, 1, '5151000135-186'),
(null, 1, 'OPEN SOURCE-MONITOR32', 1, 1, '5151000135-190'),
(null, 1, 'OPEN SOURCE-MONITOR33', 2, 1, null),
(null, 2, 'OPEN SOURCE-CPU 1', 1, 1, '5151000141-427'),
(null, 2, 'OPEN SOURCE-CPU 2', 1, 1, '5151000141-431'),
(null, 2, 'OPEN SOURCE-CPU 3', 1, 1, null),
(null, 2, 'OPEN SOURCE-CPU 4', 1, 2, null),
(null, 2, 'OPEN SOURCE-CPU 5', 1, 1, null),
(null, 2, 'OPEN SOURCE-CPU 6', 1, 1, '5151000141-413'),
(null, 2, 'OPEN SOURCE-CPU 7', 1, 2, null),
(null, 2, 'OPEN SOURCE-CPU 8', 1, 2, '5151000141-410'),
(null, 2, 'OPEN SOURCE-CPU 9', 1, 1, '5151000141-446'),
(null, 2, 'OPEN SOURCE-CPU 10', 1, 1, '5151000141-409'),
(null, 2, 'OPEN SOURCE-CPU 11', 1, 2, '5151000141-428'),
(null, 2, 'OPEN SOURCE-CPU 12', 1, 1, '5151000141-407'),
(null, 2, 'OPEN SOURCE-CPU 13', 1, 2, null),
(null, 2, 'OPEN SOURCE-CPU 14', 1, 2, '5151000141-406'),
(null, 2, 'OPEN SOURCE-CPU 15', 1, 2, '5151000141-404'),
(null, 2, 'OPEN SOURCE-CPU 16', 1, 2, null),
(null, 2, 'OPEN SOURCE-CPU 17', 1, 1, '5151000141-433'),
(null, 2, 'OPEN SOURCE-CPU 18', 1, 1, '5151000141-434'),
(null, 2, 'OPEN SOURCE-CPU 19', 1, 1, '5151000141-435'),
(null, 2, 'OPEN SOURCE-CPU 20', 1, 1, '5151000141-436'),
(null, 2, 'OPEN SOURCE-CPU 21', 1, 1, '5151000141-437'),
(null, 2, 'OPEN SOURCE-CPU 22', 1, 1, '5151000141-438'),
(null, 2, 'OPEN SOURCE-CPU 23', 1, 1, '5151000141-444'),
(null, 2, 'OPEN SOURCE-CPU 24', 1, 2, null),
(null, 2, 'OPEN SOURCE-CPU 25', 1, 1, '5151000141-442'),
(null, 2, 'OPEN SOURCE-CPU 26', 1, 1, null),
(null, 2, 'OPEN SOURCE-CPU 27', 1, 2, null),
(null, 2, 'OPEN SOURCE-CPU 28', 1, 2, null),
(null, 2, 'OPEN SOURCE-CPU 29', 1, 1, '5151000141-494'),
(null, 2, 'OPEN SOURCE-CPU 30', 1, 1, '5151000141-405'),
(null, 2, 'OPEN SOURCE-CPU 31', 1, 1, '5151000141-448'),
(null, 2, 'OPEN SOURCE-CPU 32', 1, 2, null),
(null, 2, 'OPEN SOURCE-CPU 33', 1, 1, null),
(null, 3, 'OPEN SOURCE -M 1', 3, 1, null),
(null, 3, 'OPEN SOURCE -M 2', 1, 2, null),
(null, 3, 'OPEN SOURCE -M 3', 3, 1, null),
(null, 3, 'OPEN SOURCE -M 4', 1, 1, null),
(null, 3, 'OPEN SOURCE -M 5', 1, 1, null),
(null, 3, 'OPEN SOURCE -M 6', 3, 1, null),
(null, 3, 'OPEN SOURCE -M 7', 4, 1, null),
(null, 3, 'OPEN SOURCE -M 8', 1, 1, null),
(null, 3, 'OPEN SOURCE -M 9', 3, 2, null),
(null, 3, 'OPEN SOURCE -M 10', 1, 1, null),
(null, 3, 'OPEN SOURCE -M 11', 1, 1, null),
(null, 3, 'OPEN SOURCE -M 12', 1, 1, null),
(null, 3, 'OPEN SOURCE -M 13', 1, 1, null),
(null, 3, 'OPEN SOURCE -M 14', 1, 2, null),
(null, 3, 'OPEN SOURCE -M 15', 3, 1, null),
(null, 3, 'OPEN SOURCE -M 16', 1, 2, null),
(null, 3, 'OPEN SOURCE -M 17', 3, 1, null),
(null, 3, 'OPEN SOURCE -M 18', 1, 1, null),
(null, 3, 'OPEN SOURCE -M 19', 4, 1, null),
(null, 3, 'OPEN SOURCE -M 20', 1, 2, null),
(null, 3, 'OPEN SOURCE -M 21', 1, 1, null),
(null, 3, 'OPEN SOURCE -M 22', 1, 1, null),
(null, 3, 'OPEN SOURCE -M 23', 1, 2, null),
(null, 3, 'OPEN SOURCE -M 24', 1, 1, null),
(null, 3, 'OPEN SOURCE -M 25', 1, 1, null),
(null, 3, 'OPEN SOURCE -M 26', 1, 1, null),
(null, 3, 'OPEN SOURCE -M 27', 3, 1, null),
(null, 3, 'OPEN SOURCE -M 28', 1, 1, null),
(null, 3, 'OPEN SOURCE -M 29', 1, 1, null),
(null, 3, 'OPEN SOURCE -M 30', 3, 1, null),
(null, 3, 'OPEN SOURCE -M 31', 3, 1, null),
(null, 3, 'OPEN SOURCE -M 32', 4, 1, null),
(null, 3, 'OPEN SOURCE -M 33', 1, 1, null),
(null, 4, 'OPEN SOURCE -T1', 1, 1, null),
(null, 4, 'OPEN SOURCE -T2', 1, 1, null),
(null, 4, 'OPEN SOURCE -T3', 1, 1, null),
(null, 4, 'OPEN SOURCE -T4', 1, 1, null),
(null, 4, 'OPEN SOURCE -T5', 1, 2, '5151000144-44'),
(null, 4, 'OPEN SOURCE -T6', 1, 2, null),
(null, 4, 'OPEN SOURCE -T7', 5, 1, null),
(null, 4, 'OPEN SOURCE -T8', 1, 1, null),
(null, 4, 'OPEN SOURCE -T9', 1, 1, null),
(null, 4, 'OPEN SOURCE -T10', 1, 1, null),
(null, 4, 'OPEN SOURCE -T11', 1, 1, null),
(null, 4, 'OPEN SOURCE -T12', 1, 1, null),
(null, 4, 'OPEN SOURCE -T13', 1, 1, null),
(null, 4, 'OPEN SOURCE -T14', 1, 1, null),
(null, 4, 'OPEN SOURCE -T15', 1, 1, null),
(null, 4, 'OPEN SOURCE -T16', 1, 1, null),
(null, 4, 'OPEN SOURCE -T17', 1, 2, '5151000144-43'),
(null, 4, 'OPEN SOURCE -T18', 1, 1, null),
(null, 4, 'OPEN SOURCE -T19', 1, 1, null),
(null, 4, 'OPEN SOURCE -T20', 1, 1, null),
(null, 4, 'OPEN SOURCE -T21', 1, 1, null),
(null, 4, 'OPEN SOURCE -T22', 1, 1, null),
(null, 4, 'OPEN SOURCE -T23', 1, 2, '5151000144-234'),
(null, 4, 'OPEN SOURCE -T24', 1, 1, null),
(null, 4, 'OPEN SOURCE -T25', 1, 1, null),
(null, 4, 'OPEN SOURCE -T26', 5, 2, null),
(null, 4, 'OPEN SOURCE -T27', 5, 2, null),
(null, 4, 'OPEN SOURCE -T28', 1, 1, null),
(null, 4, 'OPEN SOURCE -T29', 1, 1, null),
(null, 4, 'OPEN SOURCE -T30', 1, 1, null),
(null, 4, 'OPEN SOURCE -T31', 5, 1, null),
(null, 4, 'OPEN SOURCE-T32', 1, 1, null),
(null, 4, 'OPEN SOURCE -T33', 5, 1, null),
(null, 5, 'OPEN SOURCE -SILLA 1', 6, 1, null),
(null, 5, 'OPEN SOURCE -SILLA 2', 6, 1, null),
(null, 5, 'OPEN SOURCE -SILLA 3', 6, 1, null),
(null, 5, 'OPEN SOURCE -SILLA 4', 6, 1, null),
(null, 5, 'OPEN SOURCE -SILLA 5', 6, 1, null),
(null, 5, 'OPEN SOURCE -SILLA 6', 6, 1, null),
(null, 5, 'OPEN SOURCE -SILLA 7', 6, 1, null),
(null, 5, 'OPEN SOURCE -SILLA 8', 6, 1, null),
(null, 5, 'OPEN SOURCE -SILLA 9', 6, 1, null),
(null, 5, 'OPEN SOURCE -SILLA 10', 6, 1, null),
(null, 5, 'OPEN SOURCE -SILLA 11', 6, 1, null),
(null, 5, 'OPEN SOURCE -SILLA 12', 6, 1, null),
(null, 5, 'OPEN SOURCE -SILLA 13', 6, 1, null),
(null, 5, 'OPEN SOURCE -SILLA 14', 6, 1, null),
(null, 5, 'OPEN SOURCE -SILLA 15', 6, 1, null),
(null, 5, 'OPEN SOURCE -SILLA 16', 6, 1, null),
(null, 5, 'OPEN SOURCE -SILLA 17', 6, 1, null),
(null, 5, 'OPEN SOURCE -SILLA 18', 6, 1, null),
(null, 5, 'OPEN SOURCE -SILLA 19', 6, 1, null),
(null, 5, 'OPEN SOURCE -SILLA 20', 6, 1, null),
(null, 5, 'OPEN SOURCE -SILLA 21', 6, 1, null),
(null, 5, 'OPEN SOURCE -SILLA 22', 6, 1, null),
(null, 5, 'OPEN SOURCE -SILLA 23', 6, 1, null),
(null, 5, 'OPEN SOURCE -SILLA 24', 6, 1, null),
(null, 5, 'OPEN SOURCE -SILLA 25', 6, 1, null),
(null, 5, 'OPEN SOURCE -SILLA 26', 6, 1, null),
(null, 5, 'OPEN SOURCE -SILLA 27', 6, 1, null),
(null, 5, 'OPEN SOURCE -SILLA 28', 6, 1, null),
(null, 5, 'OPEN SOURCE -SILLA 29', 6, 1, null),
(null, 5, 'OPEN SOURCE -SILLA 30', 6, 1, null),
(null, 5, 'OPEN SOURCE -SILLA 31', 6, 1, null),
(null, 5, 'OPEN SOURCE -SILLA 32', 6, 1, null),
(null, 5, 'OPEN SOURCE -SILLA 33', 6, 1, null),
(null, 5, 'OPEN SOURCE -SILLA 34', 6, 1, null),
(null, 6, 'OPEN SOURCE -MR 1', 6, 1, null),
(null, 6, 'OPEN SOURCE -MR 2', 6, 1, null),
(null, 6, 'OPEN SOURCE -MR 3', 6, 1, null),
(null, 6, 'OPEN SOURCE -MR 4', 6, 1, null),
(null, 6, 'OPEN SOURCE -MR 5', 6, 1, null),
(null, 6, 'OPEN SOURCE -MR 6', 6, 1, null),
(null, 6, 'OPEN SOURCE -MR 7', 6, 1, null),
(null, 6, 'OPEN SOURCE -MR 8', 6, 1, null),
(null, 6, 'OPEN SOURCE -MT 1', 7, 1, null),
(null, 6, 'OPEN SOURCE -MT 2', 7, 1, null),
(null, 6, 'OPEN SOURCE -M1', 6, 1, null),
(null, 6, 'OPEN SOURCE -M2', 6, 1, null),
(null, 6, 'OPEN SOURCE -M3', 8, 1, null),
(null, 7, 'OPEN SOURCE -E 1', 8, 1, null),
(null, 8, 'OPEN SOURCE -PIZARRÓN', 6, 1, null),
(null, 9, 'OPEN SOURCE -PANTALLLA', 9, 1, null),
(null, 10, 'OPEN SOURCE -PROY1', 9, 1, null),
(null, 11, 'OPEN SOURCE -ESTAN1', 10, 1, null),
(null, 11, 'OPEN SOURCE -ESTAN2', 10, 1, null),
(null, 12, 'OPEN SOURCE -EXTIN. 1', 11, 1, null),
(null, 12, 'OPEN SOURCE -EXTIN. 2', 11, 1, null),
(null, 1, 'OPEN SOURCE -MONITOR 34', 12, 1, null),
(null, 2, 'OPEN SOURCE -CPU 34', 12, 1, null),
(null, 3, 'OPEN SOURCE -M 34', 4, 1, null),
(null, 4, 'OPEN SOURCE -T34', 5, 1, null),
(null, 1, 'OPEN SOURCE -MONITOR 35', 1, 1, null),
(null, 2, 'OPEN SOURCE -CPU 35', 13, 1, null),
(null, 3, 'OPEN SOURCE -M 35', 14, 1, null),
(null, 4, 'OPEN SOURCE -T35', 1, 1, null),
(null, 13, 'OPEN SOURCE-IMP1', 15, 1, 'Ubicada en direccion'),
(null, 13, 'OPEN SOURCE-IMP2', 16, 1, 'No tiene tinta'),
(null, 14, 'OPEN SOURCE-TEL 1', 17, 2, null),
(null, 15, 'OPEN SOURCE-AM 1', 18, 1, null),
(null, 16, 'OPEN SOURCE-VGA1', 19, 1, null),
(null, 16, 'OPEN SOURCE-VGA2', 19, 1, null),
(null, 17, 'OPEN SOURCE- COPLE HDMI1', 20, 1, null),
(null, 16, 'OPEN SOURCE-HDMI1', 19, 1, null),
(null, 16, 'OPEN SOURCE-HDMI 2', 19, 1, null),
(null, 18, 'OPEN SOURCE-CONTROL1', 21, 1, null),
(null, 18, 'OPEN SOURCE-CONTROL2', 21, 1, null),
(null, 19, 'OPEN SOURCE -HTA1', 22, 1, null),
(null, 20, 'OPEN SOURCE -GRABADORA 1', 22, 2, null),
(null, 20, 'OPEN SOURCE -GRABADORA 2', 22, 2, null),
(null, 21, 'OPEN SOURCE -BOCINAS 1', 4, 1, null),
(null, 22, 'OPEN SOURCE -MINISPLIT 1', 24, 1, null),
(null, 22, 'OPEN SOURCE -MINISPLIT 2', 24, 1, null);
/*!40000 ALTER TABLE `equipos` ENABLE KEYS */;
--
-- Dumping routines for database 'sistemainv'
--
/*!50003 DROP PROCEDURE IF EXISTS `getEquipos` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `getEquipos`(IN id_grupo INT)
BEGIN



    SELECT 



        equipos.*, 



        marcas.nombre AS marca, 



        tipos.nombre AS tipo, 



        estados.nombre AS estado, 



        colores.nombre AS color



    FROM 



        equipos



    LEFT JOIN 



        marcas ON equipos.id_marcas = marcas.id_marcas



    LEFT JOIN 



        colores ON equipos.id_colores = colores.id_colores



    LEFT JOIN 



        tipos ON equipos.id_tipos = tipos.id_tipos



    LEFT JOIN 



        estados ON equipos.id_estados = estados.id_estados



    WHERE 



        equipos.id_grupos = id_grupo



    ORDER BY 



        equipos.id_tipos ASC;



END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `get_requisition` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_requisition`(IN id_req INT)
BEGIN



    SELECT 



        requisiciones.*, 



        items_requisiciones.nombre, 



        items_requisiciones.cantidad



    FROM 



        requisiciones



    LEFT JOIN 



        items_requisiciones ON items_requisiciones.id_req = requisiciones.id_req



    WHERE 



        requisiciones.id_req = id_req;



END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `get_requisitions` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_requisitions`()
BEGIN



    SELECT 



        requisiciones.*, 



        GROUP_CONCAT(items_requisiciones.nombre SEPARATOR ', ') AS items



    FROM 



        requisiciones



    LEFT JOIN 



        items_requisiciones ON items_requisiciones.id_req = requisiciones.id_req



    GROUP BY 



        requisiciones.id_req;



END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `login` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `login`(IN p_username VARCHAR(255), IN p_password VARCHAR(255))
BEGIN



    SELECT *



    FROM users



    WHERE username = p_username



      AND password = SHA2(p_password, 0);



END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `obtenerEquipoAsignado` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `obtenerEquipoAsignado`(IN id_grupo INT, IN tipo_equipo INT)
BEGIN



    SELECT *



    FROM equipos



    WHERE id_grupos = id_grupo



      AND id_tipos = tipo_equipo;



END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `obtenerEquiporPorTipo` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `obtenerEquiporPorTipo`(IN tipo INT)
BEGIN



    SELECT 



        equipos.id_tipos, 



        equipos.cod_interno, 



        equipos.id_equipos, 



        marcas.nombre AS marca



    FROM 



        equipos



    LEFT JOIN 



        marcas ON equipos.id_marcas = marcas.id_marcas



    WHERE 



        equipos.id_tipos = tipo;



END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `obtenerGrupos` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `obtenerGrupos`(IN id_mesa INT)
BEGIN



    SELECT *



    FROM grupos



    WHERE id_mesas = id_mesa;



END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `obtenerIdAsignado` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `obtenerIdAsignado`(IN id_grupo INT, IN tipo_equipo INT)
BEGIN



    SELECT 



        equipos.id_equipos



    FROM 



        equipos



    WHERE 



        equipos.id_grupos = id_grupo



      AND 



        equipos.id_tipos = tipo_equipo;



END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `obtenerImagen` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `obtenerImagen`(IN p_id INT)
BEGIN



    SELECT imagen



    FROM users



    WHERE id = p_id;



END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `obtenerNumeroMantenimientos` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `obtenerNumeroMantenimientos`()
BEGIN



    SELECT COUNT(*) AS total_mantenimientos



    FROM mantenimientos;



END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `obtenerOrdenesEquipo` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `obtenerOrdenesEquipo`(IN id INT)
BEGIN



    SELECT *



    FROM mantenimientos



    WHERE id_equipos = id;



END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `obtenerTodosMantenimientos` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `obtenerTodosMantenimientos`()
BEGIN



    SELECT mantenimientos.*, equipos.cod_interno



    FROM mantenimientos



    LEFT JOIN equipos ON mantenimientos.id_equipos = equipos.id_equipos;



END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `obtener_equipos` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `obtener_equipos`()
BEGIN



    SELECT 



        equipos.*, 



        marcas.nombre AS marca, 



        tipos.nombre AS tipo, 



        estados.nombre AS estado



    FROM 



        equipos



    LEFT JOIN 



        marcas ON equipos.id_marcas = marcas.id_marcas



    LEFT JOIN 



        tipos ON equipos.id_tipos = tipos.id_tipos



    LEFT JOIN 



        estados ON equipos.id_estados = estados.id_estados;



END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `obtener_equipos_por_tipo` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `obtener_equipos_por_tipo`(IN p_tipo INT)
BEGIN



    SELECT 



        equipos.*, 



        marcas.nombre AS marca, 



        tipos.nombre AS tipo, 



        estados.nombre AS estado



    FROM 



        equipos



    LEFT JOIN 



        marcas ON equipos.id_marcas = marcas.id_marcas



    LEFT JOIN 



        tipos ON equipos.id_tipos = tipos.id_tipos



    LEFT JOIN 



        estados ON equipos.id_estados = estados.id_estados



    WHERE 



        equipos.id_tipos = p_tipo;



END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `obtener_equipo_computo` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `obtener_equipo_computo`(IN id_equipos INT)
BEGIN



    SELECT 



        equipos.*, 



        marcas.nombre AS marca, 



        tipos.nombre AS tipo, 



        estados.nombre AS estado, 



        colores.nombre AS color, 



        ccompu.procesador, 



        ccompu.tarjeta, 



        ccompu.ram



    FROM 



        equipos



    LEFT JOIN 



        marcas ON equipos.id_marcas = marcas.id_marcas



    LEFT JOIN 



        colores ON equipos.id_colores = colores.id_colores



    LEFT JOIN 



        tipos ON equipos.id_tipos = tipos.id_tipos



    LEFT JOIN 



        estados ON equipos.id_estados = estados.id_estados



    LEFT JOIN 



        ccompu ON equipos.id_ccompus = ccompu.id_ccompus



    WHERE 



        equipos.id_equipos = id_equipos;



END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `obtener_id_ccompu` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `obtener_id_ccompu`(IN id_equipo INT)
BEGIN



    SELECT 



        equipos.id_ccompus



    FROM 



        equipos



    WHERE 



        equipos.id_equipos = id_equipo;



END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `obtener_info_equipo` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `obtener_info_equipo`(IN id INT)
BEGIN



    SELECT 



        equipos.id_equipos, 



        equipos.id_estados, 



        equipos.modelo, 



        equipos.cod_interno, 



        marcas.nombre AS marca, 



        tipos.nombre AS tipo, 



        estados.nombre AS estado



    FROM 



        equipos



    LEFT JOIN 



        marcas ON equipos.id_marcas = marcas.id_marcas



    LEFT JOIN 



        tipos ON equipos.id_tipos = tipos.id_tipos



    LEFT JOIN 



        estados ON equipos.id_estados = estados.id_estados



    WHERE 



        equipos.id_equipos = id;



END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-08-12  9:38:03
