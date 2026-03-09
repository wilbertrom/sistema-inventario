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
  PRIMARY KEY (`id_ccompus`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ccompu`
--

/*!40000 ALTER TABLE `ccompu` DISABLE KEYS */;
/*!40000 ALTER TABLE `ccompu` ENABLE KEYS */;

--
-- Table structure for table `colores`
--

DROP TABLE IF EXISTS `colores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `colores` (
  `id_colores` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id_colores`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `colores`
--

/*!40000 ALTER TABLE `colores` DISABLE KEYS */;
INSERT INTO `colores` VALUES (1,'Negro'),(2,'Azul'),(3,'Rojo'),(4,'Verde');
/*!40000 ALTER TABLE `colores` ENABLE KEYS */;

--
-- Table structure for table `equipos`
--

DROP TABLE IF EXISTS `equipos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `equipos` (
  `id_equipos` int(11) NOT NULL AUTO_INCREMENT,
  `modelo` varchar(45) NOT NULL,
  `cod_interno` varchar(45) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `id_ccompus` int(11) DEFAULT NULL,
  `id_tipos` int(11) NOT NULL,
  `id_estados` int(11) NOT NULL,
  `id_colores` int(11) NOT NULL,
  `id_marcas` int(11) NOT NULL,
  `imagen` varchar(150) DEFAULT NULL,
  `id_grupos` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_equipos`),
  KEY `fk_equipos_ccompu` (`id_ccompus`),
  KEY `fk_equipos_tipos1` (`id_tipos`),
  KEY `fk_equipos_estados1` (`id_estados`),
  KEY `fk_equipos_colores1` (`id_colores`),
  KEY `fk_equipos_marcas1` (`id_marcas`),
  KEY `id_grupos` (`id_grupos`),
  CONSTRAINT `equipos_ibfk_1` FOREIGN KEY (`id_grupos`) REFERENCES `grupos` (`id_grupos`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_equipos_ccompu` FOREIGN KEY (`id_ccompus`) REFERENCES `ccompu` (`id_ccompus`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_equipos_colores1` FOREIGN KEY (`id_colores`) REFERENCES `colores` (`id_colores`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_equipos_estados1` FOREIGN KEY (`id_estados`) REFERENCES `estados` (`id_estados`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_equipos_marcas1` FOREIGN KEY (`id_marcas`) REFERENCES `marcas` (`id_marcas`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_equipos_tipos1` FOREIGN KEY (`id_tipos`) REFERENCES `tipos` (`id_tipos`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipos`
--

/*!40000 ALTER TABLE `equipos` DISABLE KEYS */;
INSERT INTO `equipos` VALUES (60,'NA','OPEN SOURCE -MONITOR 1','5151000135-185	',NULL,2,1,1,16,'60.png',9),(61,'0','123425','sadfgfdg',NULL,3,1,2,16,NULL,33),(62,'0','OPEN SOURCE -M 27','Descripcion mouse',NULL,4,1,1,18,NULL,NULL),(63,'0','OPEN SOURCE -M 28','sdesa',NULL,4,1,1,16,NULL,NULL);
/*!40000 ALTER TABLE `equipos` ENABLE KEYS */;
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
  KEY `id_equipos` (`id_equipos`),
  CONSTRAINT `historial_estado_ibfk_1` FOREIGN KEY (`id_equipos`) REFERENCES `equipos` (`id_equipos`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historial_estado`
--

/*!40000 ALTER TABLE `historial_estado` DISABLE KEYS */;
INSERT INTO `historial_estado` VALUES (1,60,2,1,'2024-07-14');
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
  KEY `id_req` (`id_req`),
  CONSTRAINT `items_requisiciones_ibfk_1` FOREIGN KEY (`id_req`) REFERENCES `requisiciones` (`id_req`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `items_requisiciones`
--

/*!40000 ALTER TABLE `items_requisiciones` DISABLE KEYS */;
INSERT INTO `items_requisiciones` VALUES (1,'',0,1),(2,'',0,3),(3,'',0,4),(4,'',0,5),(5,'a',1,8),(6,'g',1,9),(7,'g',1,9),(8,'h',1,10),(9,'h',0,10);
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
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mantenimientos`
--

/*!40000 ALTER TABLE `mantenimientos` DISABLE KEYS */;
INSERT INTO `mantenimientos` VALUES (34,'2024-07-14','Nueva orden ....','se planeo ....',60,0),(35,'2024-07-22','aaaaa','aaa',60,1);
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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `marcas`
--

/*!40000 ALTER TABLE `marcas` DISABLE KEYS */;
INSERT INTO `marcas` VALUES (10,'LG'),(11,'SONY'),(12,'PRETUL'),(13,'SMART'),(14,'MANHATTAN'),(15,'STEREN'),(16,'GHIA'),(17,'ACTECK'),(18,'TRUEBASIX'),(19,'LOGITECH');
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
  `fecha_actual` date DEFAULT NULL,
  PRIMARY KEY (`id_req`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `requisiciones`
--

/*!40000 ALTER TABLE `requisiciones` DISABLE KEYS */;
INSERT INTO `requisiciones` VALUES (1,'a','a','a',NULL),(2,'a','a','a',NULL),(3,'b','b','b',NULL),(4,'c','c','c',NULL),(5,'d','d','d',NULL),(6,'d','d','d',NULL),(7,'e','e','e',NULL),(8,'f','f','f',NULL),(9,'g','g','g',NULL),(10,'h','h','h',NULL);
/*!40000 ALTER TABLE `requisiciones` ENABLE KEYS */;

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipos`
--

/*!40000 ALTER TABLE `tipos` DISABLE KEYS */;
INSERT INTO `tipos` VALUES (1,'Computadora'),(2,'Monitor'),(3,'Teclado'),(4,'Mouse'),(5,'Cable'),(6,'Proyector');
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','4f5304d0a069388f5057c385b23b2514353c17db255d26397165fb2ba5873f7f','admin@sistema.com','2024-06-27 16:36:19','1.png');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

--
-- Dumping routines for database 'sistemainv'
--
/*!50003 DROP PROCEDURE IF EXISTS `select_TENNIS_SP` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `select_TENNIS_SP`(in genero int)
BEGIN

    IF genero = -1 THEN	
		SELECT tennis.id_tennis, tennis.marca, tennis.modelo, tennis.genero, tennis.precio, tennis.ruta_imagen, ofertas.id_oferta
		FROM tennis
		LEFT JOIN ofertas on tennis.id_tennis = ofertas.id_tennis;
	ELSE
		SELECT tennis.id_tennis, tennis.marca, tennis.modelo, tennis.genero, tennis.precio, tennis.ruta_imagen, ofertas.id_oferta
		FROM tennis
		LEFT JOIN ofertas on tennis.id_tennis = ofertas.id_tennis
        WHERE tennis.genero = genero;
	END IF;
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

-- Dump completed on 2024-07-23  0:11:41
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
  PRIMARY KEY (`id_ccompus`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ccompu`
--

/*!40000 ALTER TABLE `ccompu` DISABLE KEYS */;
/*!40000 ALTER TABLE `ccompu` ENABLE KEYS */;

--
-- Table structure for table `colores`
--

DROP TABLE IF EXISTS `colores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `colores` (
  `id_colores` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id_colores`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `colores`
--

/*!40000 ALTER TABLE `colores` DISABLE KEYS */;
INSERT INTO `colores` VALUES (1,'Negro'),(2,'Azul'),(3,'Rojo'),(4,'Verde');
/*!40000 ALTER TABLE `colores` ENABLE KEYS */;

--
-- Table structure for table `equipos`
--

DROP TABLE IF EXISTS `equipos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `equipos` (
  `id_equipos` int(11) NOT NULL AUTO_INCREMENT,
  `modelo` varchar(45) NOT NULL,
  `cod_interno` varchar(45) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `id_ccompus` int(11) DEFAULT NULL,
  `id_tipos` int(11) NOT NULL,
  `id_estados` int(11) NOT NULL,
  `id_colores` int(11) NOT NULL,
  `id_marcas` int(11) NOT NULL,
  `imagen` varchar(150) DEFAULT NULL,
  `id_grupos` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_equipos`),
  KEY `fk_equipos_ccompu` (`id_ccompus`),
  KEY `fk_equipos_tipos1` (`id_tipos`),
  KEY `fk_equipos_estados1` (`id_estados`),
  KEY `fk_equipos_colores1` (`id_colores`),
  KEY `fk_equipos_marcas1` (`id_marcas`),
  KEY `id_grupos` (`id_grupos`),
  CONSTRAINT `equipos_ibfk_1` FOREIGN KEY (`id_grupos`) REFERENCES `grupos` (`id_grupos`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_equipos_ccompu` FOREIGN KEY (`id_ccompus`) REFERENCES `ccompu` (`id_ccompus`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_equipos_colores1` FOREIGN KEY (`id_colores`) REFERENCES `colores` (`id_colores`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_equipos_estados1` FOREIGN KEY (`id_estados`) REFERENCES `estados` (`id_estados`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_equipos_marcas1` FOREIGN KEY (`id_marcas`) REFERENCES `marcas` (`id_marcas`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_equipos_tipos1` FOREIGN KEY (`id_tipos`) REFERENCES `tipos` (`id_tipos`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipos`
--

/*!40000 ALTER TABLE `equipos` DISABLE KEYS */;
INSERT INTO `equipos` VALUES (60,'NA','OPEN SOURCE -MONITOR 1','5151000135-185	',NULL,2,1,1,16,'60.png',9),(61,'0','123425','sadfgfdg',NULL,3,1,2,16,NULL,33),(62,'0','OPEN SOURCE -M 27','Descripcion mouse',NULL,4,1,1,18,NULL,NULL),(63,'0','OPEN SOURCE -M 28','sdesa',NULL,4,1,1,16,NULL,NULL);
/*!40000 ALTER TABLE `equipos` ENABLE KEYS */;
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
  KEY `id_equipos` (`id_equipos`),
  CONSTRAINT `historial_estado_ibfk_1` FOREIGN KEY (`id_equipos`) REFERENCES `equipos` (`id_equipos`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historial_estado`
--

/*!40000 ALTER TABLE `historial_estado` DISABLE KEYS */;
INSERT INTO `historial_estado` VALUES (1,60,2,1,'2024-07-14');
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
  KEY `id_req` (`id_req`),
  CONSTRAINT `items_requisiciones_ibfk_1` FOREIGN KEY (`id_req`) REFERENCES `requisiciones` (`id_req`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `items_requisiciones`
--

/*!40000 ALTER TABLE `items_requisiciones` DISABLE KEYS */;
INSERT INTO `items_requisiciones` VALUES (1,'',0,1),(2,'',0,3),(3,'',0,4),(4,'',0,5),(5,'a',1,8),(6,'g',1,9),(7,'g',1,9),(8,'h',1,10),(9,'h',0,10);
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
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mantenimientos`
--

/*!40000 ALTER TABLE `mantenimientos` DISABLE KEYS */;
INSERT INTO `mantenimientos` VALUES (34,'2024-07-14','Nueva orden ....','se planeo ....',60,0),(35,'2024-07-22','aaaaa','aaa',60,1);
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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `marcas`
--

/*!40000 ALTER TABLE `marcas` DISABLE KEYS */;
INSERT INTO `marcas` VALUES (10,'LG'),(11,'SONY'),(12,'PRETUL'),(13,'SMART'),(14,'MANHATTAN'),(15,'STEREN'),(16,'GHIA'),(17,'ACTECK'),(18,'TRUEBASIX'),(19,'LOGITECH');
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
  `fecha_actual` date DEFAULT NULL,
  PRIMARY KEY (`id_req`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `requisiciones`
--

/*!40000 ALTER TABLE `requisiciones` DISABLE KEYS */;
INSERT INTO `requisiciones` VALUES (1,'a','a','a',NULL),(2,'a','a','a',NULL),(3,'b','b','b',NULL),(4,'c','c','c',NULL),(5,'d','d','d',NULL),(6,'d','d','d',NULL),(7,'e','e','e',NULL),(8,'f','f','f',NULL),(9,'g','g','g',NULL),(10,'h','h','h',NULL);
/*!40000 ALTER TABLE `requisiciones` ENABLE KEYS */;

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipos`
--

/*!40000 ALTER TABLE `tipos` DISABLE KEYS */;
INSERT INTO `tipos` VALUES (1,'Computadora'),(2,'Monitor'),(3,'Teclado'),(4,'Mouse'),(5,'Cable'),(6,'Proyector');
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','4f5304d0a069388f5057c385b23b2514353c17db255d26397165fb2ba5873f7f','admin@sistema.com','2024-06-27 16:36:19','1.png');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

--
-- Dumping routines for database 'sistemainv'
--
/*!50003 DROP PROCEDURE IF EXISTS `select_TENNIS_SP` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `select_TENNIS_SP`(in genero int)
BEGIN

    IF genero = -1 THEN	
		SELECT tennis.id_tennis, tennis.marca, tennis.modelo, tennis.genero, tennis.precio, tennis.ruta_imagen, ofertas.id_oferta
		FROM tennis
		LEFT JOIN ofertas on tennis.id_tennis = ofertas.id_tennis;
	ELSE
		SELECT tennis.id_tennis, tennis.marca, tennis.modelo, tennis.genero, tennis.precio, tennis.ruta_imagen, ofertas.id_oferta
		FROM tennis
		LEFT JOIN ofertas on tennis.id_tennis = ofertas.id_tennis
        WHERE tennis.genero = genero;
	END IF;
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

-- Dump completed on 2024-07-23  0:11:41
