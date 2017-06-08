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
-- Table structure for table `tb_states`
--

DROP TABLE IF EXISTS `tb_states`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_states` (
  `idstate` int(11) NOT NULL AUTO_INCREMENT,
  `desstate` varchar(64) NOT NULL,
  `desuf` char(2) NOT NULL,
  `idcountry` int(11) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idstate`),
  KEY `FK_states_countries_idx` (`idcountry`),
  CONSTRAINT `FK_states_countries` FOREIGN KEY (`idcountry`) REFERENCES `tb_countries` (`idcountry`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_states`
--

LOCK TABLES `tb_states` WRITE;
/*!40000 ALTER TABLE `tb_states` DISABLE KEYS */;
INSERT INTO `tb_states` VALUES (1,'Acre','AC',1,'2017-04-18 16:17:59'),(2,'Alagoas','AL',1,'2017-04-18 16:17:59'),(3,'Amazonas','AM',1,'2017-04-18 16:17:59'),(4,'Amapá','AP',1,'2017-04-18 16:17:59'),(5,'Bahia','BA',1,'2017-04-18 16:17:59'),(6,'Ceará','CE',1,'2017-04-18 16:17:59'),(7,'Distrito Federal','DF',1,'2017-04-18 16:17:59'),(8,'Espírito Santo','ES',1,'2017-04-18 16:17:59'),(9,'Goiás','GO',1,'2017-04-18 16:17:59'),(10,'Maranhão','MA',1,'2017-04-18 16:17:59'),(11,'Minas Gerais','MG',1,'2017-04-18 16:17:59'),(12,'Mato Grosso do Sul','MS',1,'2017-04-18 16:17:59'),(13,'Mato Grosso','MT',1,'2017-04-18 16:17:59'),(14,'Pará','PA',1,'2017-04-18 16:17:59'),(15,'Paraíba','PB',1,'2017-04-18 16:17:59'),(16,'Pernambuco','PE',1,'2017-04-18 16:17:59'),(17,'Piauí','PI',1,'2017-04-18 16:17:59'),(18,'Paraná','PR',1,'2017-04-18 16:17:59'),(19,'Rio de Janeiro','RJ',1,'2017-04-18 16:17:59'),(20,'Rio Grande do Norte','RN',1,'2017-04-18 16:17:59'),(21,'Rondônia','RO',1,'2017-04-18 16:17:59'),(22,'Roraima','RR',1,'2017-04-18 16:17:59'),(23,'Rio Grande do Sul','RS',1,'2017-04-18 16:17:59'),(24,'Santa Catarina','SC',1,'2017-04-18 16:17:59'),(25,'Sergipe','SE',1,'2017-04-18 16:17:59'),(26,'São Paulo','SP',1,'2017-04-18 16:17:59'),(27,'Tocantins','TO',1,'2017-04-18 16:17:59');
/*!40000 ALTER TABLE `tb_states` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-06-02 14:09:28
