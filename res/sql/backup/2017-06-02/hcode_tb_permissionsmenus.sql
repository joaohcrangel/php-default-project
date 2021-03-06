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
-- Table structure for table `tb_permissionsmenus`
--

DROP TABLE IF EXISTS `tb_permissionsmenus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_permissionsmenus` (
  `idpermission` int(11) NOT NULL,
  `idmenu` int(11) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idpermission`,`idmenu`),
  KEY `FK_menuspermissions` (`idmenu`),
  CONSTRAINT `FK_menuspermissions` FOREIGN KEY (`idmenu`) REFERENCES `tb_menus` (`idmenu`),
  CONSTRAINT `FK_permissionsmenus` FOREIGN KEY (`idpermission`) REFERENCES `tb_permissions` (`idpermission`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_permissionsmenus`
--

LOCK TABLES `tb_permissionsmenus` WRITE;
/*!40000 ALTER TABLE `tb_permissionsmenus` DISABLE KEYS */;
INSERT INTO `tb_permissionsmenus` VALUES (1,1,'2017-04-18 16:17:59'),(1,2,'2017-04-18 16:17:59'),(1,3,'2017-04-18 16:17:59'),(1,4,'2017-04-18 16:17:59'),(1,5,'2017-04-18 16:17:59'),(1,6,'2017-04-18 16:17:59'),(1,7,'2017-04-18 16:17:59'),(1,8,'2017-04-18 16:17:59'),(1,9,'2017-04-18 16:17:59'),(1,10,'2017-04-18 16:17:59'),(1,11,'2017-04-18 16:17:59'),(1,12,'2017-04-18 16:17:59'),(1,13,'2017-04-18 16:17:59'),(1,14,'2017-04-18 16:17:59'),(1,15,'2017-04-18 16:17:59'),(1,16,'2017-04-18 16:17:59'),(1,17,'2017-04-18 16:17:59'),(1,18,'2017-04-18 16:17:59'),(1,19,'2017-04-18 16:17:59'),(1,20,'2017-04-18 16:17:59'),(1,21,'2017-04-18 16:17:59'),(1,22,'2017-04-18 16:17:59'),(1,23,'2017-04-18 16:17:59'),(1,24,'2017-04-18 16:17:59'),(1,25,'2017-04-18 16:17:59'),(1,26,'2017-04-18 16:17:59'),(1,27,'2017-04-18 16:17:59'),(1,28,'2017-04-18 16:17:59'),(1,29,'2017-04-18 16:17:59'),(1,30,'2017-04-18 16:17:59'),(1,31,'2017-04-18 16:17:59'),(1,32,'2017-04-18 16:17:59'),(1,33,'2017-04-18 16:17:59'),(1,34,'2017-04-18 16:17:59'),(1,35,'2017-04-18 16:17:59'),(1,36,'2017-04-18 16:17:59'),(1,37,'2017-04-18 16:17:59'),(1,38,'2017-04-18 16:17:59'),(1,39,'2017-04-18 16:17:59'),(1,40,'2017-04-18 16:17:59'),(1,41,'2017-04-18 16:17:59'),(1,42,'2017-04-18 16:17:59'),(1,43,'2017-04-18 16:17:59'),(1,44,'2017-04-18 16:17:59'),(1,45,'2017-04-18 16:17:59'),(1,46,'2017-04-18 16:17:59'),(1,47,'2017-04-18 16:17:59'),(1,48,'2017-04-18 16:17:59'),(1,49,'2017-04-18 16:17:59'),(1,50,'2017-04-18 16:17:59'),(1,51,'2017-04-18 16:17:59'),(1,52,'2017-04-18 16:17:59'),(1,53,'2017-04-18 16:17:59');
/*!40000 ALTER TABLE `tb_permissionsmenus` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-06-02 14:05:48
