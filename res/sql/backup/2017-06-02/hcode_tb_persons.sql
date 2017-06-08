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
-- Table structure for table `tb_persons`
--

DROP TABLE IF EXISTS `tb_persons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_persons` (
  `idperson` int(11) NOT NULL AUTO_INCREMENT,
  `idpersontype` int(1) NOT NULL,
  `desperson` varchar(64) NOT NULL,
  `inremoved` bit(1) NOT NULL DEFAULT b'0',
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idperson`),
  KEY `FK_personstypes` (`idpersontype`),
  CONSTRAINT `FK_persons_personstypes` FOREIGN KEY (`idpersontype`) REFERENCES `tb_personstypes` (`idpersontype`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=165 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_persons`
--

LOCK TABLES `tb_persons` WRITE;
/*!40000 ALTER TABLE `tb_persons` DISABLE KEYS */;
INSERT INTO `tb_persons` VALUES (1,1,'João Rangel','\0','2017-05-10 16:37:00'),(3,1,'','','2017-05-10 16:38:45'),(4,1,'','','2017-05-10 16:38:45'),(5,1,'','','2017-05-10 16:38:45'),(6,1,'Anthony Rafael Ribeiro','','2017-05-16 14:37:08'),(7,1,'Anthony Rafael Ribeiro','','2017-05-16 14:37:37'),(8,1,'Anthony Rafael Ribeiro','','2017-05-16 14:37:38'),(9,1,'Anthony Rafael Ribeiro','','2017-05-16 14:37:40'),(10,1,'Anthony Rafael Ribeiro','','2017-05-16 14:37:42'),(11,1,'Anthony Rafael Ribeiro','','2017-05-16 14:37:44'),(12,1,'Anthony Rafael Ribeiro','','2017-05-16 14:37:46'),(13,1,'Anthony Rafael Ribeiro','','2017-05-16 14:38:44'),(14,1,'Anthony Rafael Ribeiro','','2017-05-16 14:37:25'),(15,1,'Luke Skywalker','','2017-05-16 14:37:49'),(16,1,'Luke Skywalker','','2017-05-16 14:37:52'),(17,1,'Ronaldo Braz','\0','2017-05-18 00:55:13'),(18,1,'Ronaldo braz da silva','\0','2017-05-20 16:13:07'),(19,1,'ronaldo','\0','2017-05-20 16:21:07'),(20,1,'ronaldo','\0','2017-05-20 16:22:08'),(21,1,'Ronaldo braz da silva','\0','2017-05-20 16:23:44'),(22,1,'Ronaldo Braz Da Silva','\0','2017-05-20 16:27:32'),(23,1,'Ronaldo Braz Da Silva','\0','2017-05-20 16:30:39'),(24,1,'Ronaldo braz da silva','\0','2017-05-20 16:35:04'),(25,1,'ronaldo','\0','2017-05-20 16:38:04'),(26,1,'ronaldo','\0','2017-05-20 16:39:42'),(27,1,'ronaldo','\0','2017-05-20 16:40:36'),(28,1,'Ronaldo braz da silva','\0','2017-05-20 17:35:27'),(29,1,'Ronaldo Braz Silva','\0','2017-05-20 17:39:18'),(30,1,'ronaldo braz','\0','2017-05-20 17:43:07'),(31,1,'ronaldo braz','\0','2017-05-20 17:45:27'),(32,1,'ronaldo','\0','2017-05-20 17:52:16'),(33,1,'ronaldo','\0','2017-05-20 17:57:17'),(34,1,'ronaldo','\0','2017-05-20 18:01:24'),(35,1,'ronaldo','\0','2017-05-20 18:09:48'),(36,1,'ronaldo','\0','2017-05-20 18:10:39'),(37,1,'ronaldo','\0','2017-05-20 18:12:10'),(38,1,'ronaldo','\0','2017-05-20 18:18:15'),(39,1,'Ronaldo Braz da silva','\0','2017-05-21 21:02:26'),(40,1,'ronaldo','\0','2017-05-21 21:20:04'),(41,1,'ronaldo','\0','2017-05-21 21:21:12'),(42,1,'ronaldo','\0','2017-05-21 21:28:16'),(43,1,'ronaldo','\0','2017-05-21 21:29:05'),(44,1,'Ronaldo braz da silva','\0','2017-05-23 12:18:03'),(45,1,'João Rangel','\0','2017-05-23 12:36:05'),(46,1,'ronaldo','\0','2017-05-23 13:12:58'),(47,1,'ronaldo','\0','2017-05-23 13:16:43'),(48,1,'ronaldo','\0','2017-05-23 13:17:41'),(49,1,'ronaldo','\0','2017-05-23 13:18:18'),(50,1,'ronaldo','\0','2017-05-23 13:18:23'),(51,1,'ronaldo','\0','2017-05-23 16:41:14'),(52,1,'ronaldo','\0','2017-05-23 17:06:36'),(53,1,'ronaldo','\0','2017-05-23 17:08:55'),(54,1,'ronaldo','\0','2017-05-23 17:10:49'),(55,1,'ronaldo','\0','2017-05-23 17:12:33'),(56,1,'ronaldo','\0','2017-05-23 17:12:40'),(57,1,'ronaldo','\0','2017-05-23 17:13:52'),(58,1,'ronaldo','\0','2017-05-23 17:16:42'),(59,1,'ronaldo','\0','2017-05-23 17:19:41'),(60,1,'ronaldo','\0','2017-05-23 17:22:05'),(61,1,'angelica','\0','2017-05-23 17:25:11'),(62,1,'ronaldo','\0','2017-05-23 18:02:52'),(63,1,'ronaldo','\0','2017-05-23 18:04:11'),(64,1,'ronaldo','\0','2017-05-23 18:05:00'),(65,1,'ronaldo','\0','2017-05-23 18:08:37'),(66,1,'ronaldo','\0','2017-05-23 18:09:57'),(67,1,'ronaldo','\0','2017-05-23 18:11:50'),(68,1,'ronaldo','\0','2017-05-23 19:49:47'),(69,1,'ronaldo','\0','2017-05-23 19:56:58'),(70,1,'ronaldo','\0','2017-05-23 19:57:48'),(71,1,'ronaldo','\0','2017-05-23 20:04:10'),(72,1,'ronaldo','\0','2017-05-23 20:25:19'),(73,1,'ronaldo','\0','2017-05-23 20:33:47'),(74,1,'ronaldo','\0','2017-05-23 20:34:40'),(75,1,'ronaldo','\0','2017-05-23 20:41:07'),(76,1,'ronaldo','\0','2017-05-23 20:47:06'),(77,1,'ronaldo','\0','2017-05-23 21:10:12'),(78,1,'ronaldo','\0','2017-05-23 21:12:11'),(79,1,'ronaldo','\0','2017-05-23 21:18:00'),(80,1,'ronaldo','\0','2017-05-23 21:19:27'),(81,1,'ronaldo','\0','2017-05-23 21:22:11'),(82,1,'ronaldo','\0','2017-05-23 21:24:03'),(83,1,'ronaldo','\0','2017-05-24 01:30:36'),(84,1,'ronaldo','\0','2017-05-24 01:32:50'),(85,1,'ronaldo','\0','2017-05-24 01:36:59'),(86,1,'ronaldo','\0','2017-05-24 01:40:58'),(87,1,'ronaldo','\0','2017-05-24 01:41:14'),(88,1,'ronaldo','\0','2017-05-24 01:43:32'),(89,1,'ronaldo','\0','2017-05-24 01:51:31'),(90,1,'ronaldo','\0','2017-05-24 01:53:35'),(91,1,'ronaldo','\0','2017-05-24 01:59:20'),(92,1,'ronaldo','\0','2017-05-24 02:03:30'),(93,1,'ronaldo','\0','2017-05-24 02:03:50'),(94,1,'ronaldo','\0','2017-05-24 02:04:20'),(95,1,'ronaldo','\0','2017-05-24 02:04:48'),(96,1,'ronaldo','\0','2017-05-24 02:05:10'),(97,1,'ronaldo','\0','2017-05-24 02:05:41'),(98,1,'ronaldo','\0','2017-05-24 02:07:01'),(99,1,'ronaldo','\0','2017-05-24 02:07:13'),(100,1,'ronaldo','\0','2017-05-24 02:07:45'),(101,1,'ronaldo','\0','2017-05-24 02:08:18'),(102,1,'ronaldo','\0','2017-05-24 02:19:54'),(103,1,'ronaldo','\0','2017-05-24 02:29:23'),(104,1,'ronaldo','\0','2017-05-24 02:47:33'),(105,1,'ronaldo','\0','2017-05-24 02:48:03'),(106,1,'ronaldo','\0','2017-05-24 02:50:01'),(107,1,'ronaldo','\0','2017-05-24 02:51:12'),(108,1,'ronaldo','\0','2017-05-24 02:54:44'),(109,1,'ronaldo','\0','2017-05-24 02:55:11'),(110,1,'ronaldo','\0','2017-05-24 02:56:28'),(111,1,'ronaldo','\0','2017-05-24 02:58:37'),(112,1,'ronaldo','\0','2017-05-24 02:59:19'),(113,1,'ronaldo','\0','2017-05-24 03:00:07'),(114,1,'angelica souza','\0','2017-05-24 03:04:28'),(115,1,'Angelica Souza','\0','2017-05-24 03:12:18'),(116,1,'Isaballi','\0','2017-05-24 16:27:56'),(117,1,'João Rangel','\0','2017-05-24 17:58:36'),(118,1,'João Rangel','\0','2017-05-24 17:59:10'),(119,1,'Ronaldo Braz da silva','\0','2017-05-24 18:00:37'),(120,1,'Ronaldo Braz da silva','\0','2017-05-24 18:03:52'),(121,1,'Ronaldo Braz','\0','2017-05-24 18:07:58'),(122,1,'Ronaldo Braz','\0','2017-05-24 18:08:31'),(123,1,'Ronaldo Braz','\0','2017-05-25 16:50:56'),(124,1,'João Rangel','\0','2017-05-29 17:17:58'),(125,1,'João Rangel','\0','2017-05-29 17:20:12'),(126,1,'João Rangel','\0','2017-05-29 18:22:57'),(127,1,'João Rangel','\0','2017-05-29 18:39:22'),(128,1,'Ronaldo Braz','\0','2017-05-29 18:49:12'),(129,1,'Ronaldo Braz','\0','2017-05-29 18:49:53'),(130,1,'Ronaldo Braz','\0','2017-05-29 18:54:53'),(131,1,'Angelica Souza ','\0','2017-05-29 19:17:57'),(132,1,'Ronaldo','\0','2017-05-29 19:18:51'),(133,1,'Ronaldo','\0','2017-05-29 19:28:55'),(134,1,'Ronaldo','\0','2017-05-29 19:31:12'),(135,1,'Angelica','\0','2017-05-29 19:33:53'),(136,1,'ronaldo','\0','2017-05-29 22:53:42'),(137,1,'ronaldo','\0','2017-05-29 22:54:54'),(138,1,'João','\0','2017-05-29 22:56:49'),(139,1,'ronaldo','\0','2017-05-29 23:04:04'),(140,1,'ronaldo','\0','2017-05-29 23:11:19'),(141,1,'ronaldo','\0','2017-05-29 23:17:31'),(142,1,'ronaldo','\0','2017-05-30 01:31:53'),(143,1,'ronaldo','\0','2017-05-30 01:41:51'),(144,1,'ronaldo','\0','2017-05-30 01:45:10'),(145,1,'ronaldo','\0','2017-05-30 01:48:09'),(146,1,'ronaldo','\0','2017-05-30 01:49:06'),(147,1,'ronaldo','\0','2017-05-30 01:51:51'),(148,1,'Isabelli Souza','\0','2017-05-30 18:17:47'),(149,1,'ronaldo','\0','2017-05-30 18:37:01'),(150,1,'ronaldo','\0','2017-05-30 18:49:10'),(151,1,'ronaldo','\0','2017-05-30 18:55:57'),(152,1,'Glaucio Daniel Souza Santos','\0','2017-05-30 18:59:01'),(153,1,'ronaldo','\0','2017-05-30 19:00:12'),(154,1,'Glaucio Daniel Souza Santos','\0','2017-05-30 19:01:18'),(155,1,'Djalma Sindeaux','\0','2017-05-30 19:03:14'),(156,1,'ronaldo','\0','2017-05-30 19:04:01'),(157,1,'João Rangel','\0','2017-05-30 19:07:55'),(158,1,'isabelli','\0','2017-05-30 19:08:15'),(159,1,'Glaucio Daniel Souza Santos','\0','2017-05-30 19:37:24'),(160,1,'Glaucio Daniel Souza Santos','\0','2017-05-30 20:15:00'),(161,1,'ronaldo','\0','2017-05-30 20:29:26'),(162,1,'ronaldo','\0','2017-05-31 16:58:14'),(163,1,'ronaldo','\0','2017-05-31 17:11:58'),(164,1,'ronaldo','\0','2017-06-02 16:46:53');
/*!40000 ALTER TABLE `tb_persons` ENABLE KEYS */;
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
/*!50003 CREATE*/ /*!50017 DEFINER=`hcode`@`%.%.%.%`*/ /*!50003 TRIGGER tg_persons_AFTER_INSERT AFTER INSERT ON tb_persons FOR EACH ROW
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
/*!50003 CREATE*/ /*!50017 DEFINER=`hcode`@`%.%.%.%`*/ /*!50003 TRIGGER tg_persons_AFTER_UPDATE AFTER UPDATE ON tb_persons FOR EACH ROW
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
/*!50003 CREATE*/ /*!50017 DEFINER=`hcode`@`%.%.%.%`*/ /*!50003 TRIGGER tg_persons_BEFORE_DELETE BEFORE DELETE ON tb_persons FOR EACH ROW
BEGIN
	CALL sp_personsdata_remove(OLD.idperson);
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

-- Dump completed on 2017-06-02 14:10:35
