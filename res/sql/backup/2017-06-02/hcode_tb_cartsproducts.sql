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
-- Table structure for table `tb_cartsproducts`
--

DROP TABLE IF EXISTS `tb_cartsproducts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_cartsproducts` (
  `idcartproduct` int(11) NOT NULL AUTO_INCREMENT,
  `idcart` int(11) NOT NULL,
  `idproduct` int(11) NOT NULL,
  `idprice` int(11) NOT NULL,
  `dtremoved` datetime DEFAULT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idcartproduct`),
  KEY `idcart` (`idcart`),
  KEY `idproduct` (`idproduct`),
  KEY `tb_cartsproducts_productsprices_idx` (`idprice`),
  CONSTRAINT `fk_cartsproducts_carts` FOREIGN KEY (`idcart`) REFERENCES `tb_carts` (`idcart`),
  CONSTRAINT `fk_cartsproducts_products` FOREIGN KEY (`idproduct`) REFERENCES `tb_products` (`idproduct`),
  CONSTRAINT `fk_cartsproducts_productsprices` FOREIGN KEY (`idprice`) REFERENCES `tb_productsprices` (`idprice`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_cartsproducts`
--

LOCK TABLES `tb_cartsproducts` WRITE;
/*!40000 ALTER TABLE `tb_cartsproducts` DISABLE KEYS */;
INSERT INTO `tb_cartsproducts` VALUES (1,13,6,8,'2017-05-16 22:56:55','2017-05-16 22:48:26'),(2,13,6,9,'2017-05-16 22:56:55','2017-05-16 22:53:36'),(3,13,6,9,'2017-05-16 22:56:55','2017-05-16 22:56:20'),(4,14,6,9,NULL,'2017-05-16 23:02:04'),(5,16,6,9,'2017-05-17 01:26:11','2017-05-16 23:03:39'),(6,16,6,9,'2017-05-17 01:26:11','2017-05-16 23:05:22'),(7,16,6,9,'2017-05-17 01:26:11','2017-05-17 01:24:51'),(8,26,6,10,'2017-05-17 18:26:31','2017-05-17 17:17:19'),(10,26,6,10,'2017-05-17 18:26:31','2017-05-17 18:17:11'),(11,26,6,10,NULL,'2017-05-17 18:27:03'),(12,26,6,10,NULL,'2017-05-17 21:37:45'),(13,78,6,10,NULL,'2017-06-01 13:59:39'),(14,79,6,10,NULL,'2017-06-01 16:54:17'),(15,82,8,13,NULL,'2017-06-02 14:13:48');
/*!40000 ALTER TABLE `tb_cartsproducts` ENABLE KEYS */;
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
/*!50003 CREATE*/ /*!50017 DEFINER=`hcode`@`%.%.%.%`*/ /*!50003 TRIGGER tg_cartsproducts_AFTER_INSERT AFTER INSERT ON tb_cartsproducts FOR EACH ROW
BEGIN
	CALL sp_cartsdata_save(NEW.idcart);
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
/*!50003 CREATE*/ /*!50017 DEFINER=`hcode`@`%.%.%.%`*/ /*!50003 TRIGGER tg_cartsproducts_AFTER_UPDATE AFTER UPDATE ON tb_cartsproducts FOR EACH ROW
BEGIN
	CALL sp_cartsdata_save(NEW.idcart);
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

-- Dump completed on 2017-06-02 14:11:19
