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
-- Table structure for table `tb_configurations`
--

DROP TABLE IF EXISTS `tb_configurations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_configurations` (
  `idconfiguration` int(11) NOT NULL AUTO_INCREMENT,
  `desconfiguration` varchar(64) NOT NULL,
  `desvalue` varchar(2048) NOT NULL,
  `desdescription` varchar(256) DEFAULT NULL,
  `idconfigurationtype` int(11) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idconfiguration`),
  KEY `FK_configurations_configurationstypes_idx` (`idconfigurationtype`),
  KEY `IX_desconfiguration` (`desconfiguration`),
  CONSTRAINT `FK_configurations_configurationstypes` FOREIGN KEY (`idconfigurationtype`) REFERENCES `tb_configurationstypes` (`idconfigurationtype`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_configurations`
--

LOCK TABLES `tb_configurations` WRITE;
/*!40000 ALTER TABLE `tb_configurations` DISABLE KEYS */;
INSERT INTO `tb_configurations` VALUES (1,'ADMIN_NAME','HTML5dev','Nome visual da administração.',1,'2017-04-18 16:18:00'),(2,'UPLOAD_DIR','/res/uploads/','Diretório padrão para uploads de arquivos.',1,'2017-04-18 16:18:00'),(3,'UPLOAD_MAX_FILESIZE','2097152','Tamanho máximo permitido para upload de arquivos em bytes.',2,'2017-04-18 16:18:00'),(4,'UPLOAD_MIME_TYPE','{\"jpg\":\"image/jpeg\",\"png\":\"image/png\",\"gif\":\"image/gif\",\"pdf\":\"application/pdf\"}','Tipos de arquivos permitidos para fazer upload.',6,'2017-04-18 16:18:00'),(5,'GOOGLE_MAPS_KEY','AIzaSyBAFIuWNcFZbd_qAnCzuO27sayyFfsQ-aw','Chave de acesso ao plugin do Google Maps',1,'2017-04-18 16:18:00');
/*!40000 ALTER TABLE `tb_configurations` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-06-02 14:04:51
