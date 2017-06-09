CREATE DATABASE  IF NOT EXISTS `hcode` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `hcode`;
-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 104.131.120.158    Database: hcode
-- ------------------------------------------------------
-- Server version	5.7.18-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tb_productsprices`
--

DROP TABLE IF EXISTS `tb_productsprices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_productsprices` (
  `idprice` int(11) NOT NULL AUTO_INCREMENT,
  `idproduct` int(11) NOT NULL,
  `dtstart` datetime NOT NULL,
  `dtend` datetime DEFAULT NULL,
  `vlprice` decimal(10,2) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idprice`),
  KEY `idproduct` (`idproduct`),
  CONSTRAINT `tb_productsprices_ibfk_1` FOREIGN KEY (`idproduct`) REFERENCES `tb_products` (`idproduct`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_productsprices`
--

LOCK TABLES `tb_productsprices` WRITE;
/*!40000 ALTER TABLE `tb_productsprices` DISABLE KEYS */;
INSERT INTO `tb_productsprices` VALUES (1,6,'2017-05-16 21:57:27','2017-05-16 21:59:49',60.00,'2017-05-16 21:57:27'),(2,6,'2017-05-16 21:59:49','2017-05-16 22:02:52',50.00,'2017-05-16 21:59:49'),(3,6,'2017-05-16 22:02:52','2017-05-16 22:05:35',70.00,'2017-05-16 22:02:52'),(4,6,'2017-05-16 22:05:35','2017-05-16 22:07:13',40.00,'2017-05-16 22:05:35'),(5,6,'2017-05-16 22:07:13','2017-05-16 22:10:00',50.00,'2017-05-16 22:07:13'),(6,6,'2017-05-16 22:10:00','2017-05-16 22:10:23',30.00,'2017-05-16 22:10:00'),(7,6,'2017-05-16 22:10:24','2017-05-16 22:10:40',55.00,'2017-05-16 22:10:24'),(8,6,'2017-05-16 22:10:40','2017-05-16 22:49:09',80.00,'2017-05-16 22:10:40'),(9,6,'2017-05-16 22:49:09','2017-05-17 14:00:13',100.00,'2017-05-16 22:49:09'),(10,6,'2017-05-17 14:00:13',NULL,50.00,'2017-05-17 14:00:13'),(11,9,'2017-05-30 16:45:40','2017-05-30 19:21:59',70.00,'2017-05-30 16:45:40'),(12,9,'2017-05-30 19:21:59',NULL,25.00,'2017-05-30 19:21:59'),(13,8,'2017-06-02 14:13:40',NULL,99.00,'2017-06-02 14:13:40');
/*!40000 ALTER TABLE `tb_productsprices` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = latin1 */ ;
/*!50003 SET character_set_results = latin1 */ ;
/*!50003 SET collation_connection  = latin1_swedish_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`hcode`@`%.%.%.%`*/ /*!50003 TRIGGER tg_productsprices_AFTER_INSERT AFTER INSERT ON tb_productsprices FOR EACH ROW
BEGIN
	CALL sp_productsdata_save(NEW.idproduct);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = latin1 */ ;
/*!50003 SET character_set_results = latin1 */ ;
/*!50003 SET collation_connection  = latin1_swedish_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`hcode`@`%.%.%.%`*/ /*!50003 TRIGGER tg_productsprices_AFTER_UPDATE AFTER UPDATE ON tb_productsprices FOR EACH ROW
BEGIN
	CALL sp_productsdata_save(NEW.idproduct);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = latin1 */ ;
/*!50003 SET character_set_results = latin1 */ ;
/*!50003 SET collation_connection  = latin1_swedish_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`hcode`@`%.%.%.%`*/ /*!50003 TRIGGER tg_productsprices_BEFORE_DELETE BEFORE DELETE ON tb_productsprices FOR EACH ROW
BEGIN
	CALL sp_productsdata_remove(OLD.idproduct);
END */;;
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

-- Dump completed on 2017-06-02 14:14:16
