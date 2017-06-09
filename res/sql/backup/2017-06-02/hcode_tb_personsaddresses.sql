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
-- Table structure for table `tb_personsaddresses`
--

DROP TABLE IF EXISTS `tb_personsaddresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_personsaddresses` (
  `idperson` int(11) NOT NULL,
  `idaddress` int(11) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `idperson` (`idperson`),
  KEY `idaddress` (`idaddress`),
  CONSTRAINT `tb_personsaddresses_ibfk_1` FOREIGN KEY (`idperson`) REFERENCES `tb_persons` (`idperson`),
  CONSTRAINT `tb_personsaddresses_ibfk_2` FOREIGN KEY (`idaddress`) REFERENCES `tb_addresses` (`idaddress`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_personsaddresses`
--

LOCK TABLES `tb_personsaddresses` WRITE;
/*!40000 ALTER TABLE `tb_personsaddresses` DISABLE KEYS */;
INSERT INTO `tb_personsaddresses` VALUES (16,4,'2017-05-16 14:26:02'),(111,5,'2017-05-24 02:58:41'),(112,6,'2017-05-24 02:59:23'),(113,7,'2017-05-24 03:00:11'),(114,8,'2017-05-24 03:04:31'),(115,9,'2017-05-24 03:12:23'),(116,10,'2017-05-24 16:28:01'),(117,11,'2017-05-24 17:58:40'),(118,12,'2017-05-24 17:59:14'),(119,13,'2017-05-24 18:00:41'),(120,14,'2017-05-24 18:03:55'),(121,15,'2017-05-24 18:08:02'),(122,16,'2017-05-24 18:08:35'),(123,17,'2017-05-25 16:51:00'),(125,18,'2017-05-29 17:20:20'),(126,19,'2017-05-29 18:23:02'),(127,20,'2017-05-29 18:39:26'),(128,21,'2017-05-29 18:49:20'),(129,22,'2017-05-29 18:49:58'),(130,23,'2017-05-29 18:54:57'),(131,24,'2017-05-29 19:18:01'),(132,25,'2017-05-29 19:18:54'),(133,26,'2017-05-29 19:28:59'),(134,27,'2017-05-29 19:31:16'),(135,28,'2017-05-29 19:33:56'),(136,29,'2017-05-29 22:53:45'),(137,30,'2017-05-29 22:54:57'),(138,31,'2017-05-29 22:56:52'),(139,32,'2017-05-29 23:04:08'),(140,33,'2017-05-29 23:11:22'),(141,34,'2017-05-29 23:17:34'),(142,35,'2017-05-30 01:31:57'),(143,36,'2017-05-30 01:41:54'),(144,37,'2017-05-30 01:45:13'),(145,38,'2017-05-30 01:48:12'),(146,39,'2017-05-30 01:49:09'),(147,40,'2017-05-30 01:51:54'),(148,41,'2017-05-30 18:17:51'),(151,42,'2017-05-30 18:56:02'),(153,43,'2017-05-30 19:00:16'),(156,44,'2017-05-30 19:04:07'),(158,45,'2017-05-30 19:08:22'),(161,46,'2017-05-30 20:29:30'),(162,47,'2017-05-31 16:58:19'),(163,48,'2017-05-31 17:12:06'),(164,49,'2017-06-02 16:46:57');
/*!40000 ALTER TABLE `tb_personsaddresses` ENABLE KEYS */;
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
/*!50003 CREATE*/ /*!50017 DEFINER=`hcode`@`%.%.%.%`*/ /*!50003 TRIGGER tg_personsaddresses_AFTER_INSERT AFTER INSERT ON tb_personsaddresses FOR EACH ROW
BEGIN
	CALL sp_personsdata_save(NEW.idperson);
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
/*!50003 CREATE*/ /*!50017 DEFINER=`hcode`@`%.%.%.%`*/ /*!50003 TRIGGER tg_personsaddresses_AFTER_UPDATE AFTER UPDATE ON tb_personsaddresses FOR EACH ROW
BEGIN
	CALL sp_personsdata_save(NEW.idperson);
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
/*!50003 CREATE*/ /*!50017 DEFINER=`hcode`@`%.%.%.%`*/ /*!50003 TRIGGER tg_personsaddresses_BEFORE_DELETE BEFORE DELETE ON `tb_personsaddresses` FOR EACH ROW
BEGIN
	CALL sp_personsdata_save(OLD.idperson);
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

-- Dump completed on 2017-06-02 14:06:39
