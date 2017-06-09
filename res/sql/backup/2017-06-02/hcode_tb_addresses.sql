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
-- Table structure for table `tb_addresses`
--

DROP TABLE IF EXISTS `tb_addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_addresses` (
  `idaddress` int(11) NOT NULL AUTO_INCREMENT,
  `idaddresstype` int(11) NOT NULL,
  `desaddress` varchar(64) NOT NULL,
  `desnumber` varchar(16) NOT NULL,
  `desdistrict` varchar(64) NOT NULL,
  `descity` varchar(64) NOT NULL,
  `desstate` varchar(32) NOT NULL,
  `descountry` varchar(32) NOT NULL,
  `descep` char(8) NOT NULL,
  `descomplement` varchar(32) DEFAULT NULL,
  `inmain` tinyint(1) NOT NULL DEFAULT '0',
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idaddress`),
  KEY `FK_addressestypes` (`idaddresstype`),
  CONSTRAINT `FK_addressestypes` FOREIGN KEY (`idaddresstype`) REFERENCES `tb_addressestypes` (`idaddresstype`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_addresses`
--

LOCK TABLES `tb_addresses` WRITE;
/*!40000 ALTER TABLE `tb_addresses` DISABLE KEYS */;
INSERT INTO `tb_addresses` VALUES (2,2,'Avenida Ademar Saraiva Leão','234','Alvarenga','São Bernardo do Campo','São Paulo','Brasil','09853120','',1,'2017-05-11 20:53:08'),(3,2,'Avenida Ademar Saraiva Leão','234','Alvarenga','São Bernardo do Campo','São Paulo','Brasil','09853120','',1,'2017-05-11 20:53:25'),(4,1,'Rua Nossa Senhora de Guadalupe','140','Alvarenga','São Bernardo do Campo','São Paulo','Brasil','09854410','(Jd das Orquídeas)',1,'2017-05-16 14:26:02'),(5,1,'Rua dos Alemães','48','Alvarenga','São Bernardo do Campo','São Paulo','Brasil','09853030','(Pq Bandeirantes)',1,'2017-05-24 02:58:40'),(6,1,'Rua dos Alemães','48','Alvarenga','São Bernardo do Campo','São Paulo','Brasil','09853030','(Pq Bandeirantes)',1,'2017-05-24 02:59:23'),(7,1,'Rua dos Alemães','48','Alvarenga','São Bernardo do Campo','São Paulo','Brasil','09853030','(Pq Bandeirantes)',1,'2017-05-24 03:00:10'),(8,1,'Rua dos Alemães','55','Alvarenga','São Bernardo do Campo','São Paulo','Brasil','09853030','(Pq Bandeirantes)',1,'2017-05-24 03:04:31'),(9,1,'Rua dos Alemães','100','Alvarenga','São Bernardo do Campo','São Paulo','Brasil','09853030','(Pq Bandeirantes)',1,'2017-05-24 03:12:22'),(10,1,'Rua dos Alemães','48','Alvarenga','São Bernardo do Campo','São Paulo','Brasil','09853030','(Pq Bandeirantes)',1,'2017-05-24 16:28:00'),(11,1,'Rua dos Alemães','46','Alvarenga','São Bernardo do Campo','São Paulo','Brasil','09853030','(Pq Bandeirantes)',1,'2017-05-24 17:58:40'),(12,1,'Rua dos Alemães','46','Alvarenga','São Bernardo do Campo','São Paulo','Brasil','09853030','(Pq Bandeirantes)',1,'2017-05-24 17:59:14'),(13,2,'Rua dos Alemães','48','Alvarenga','São Bernardo do Campo','São Paulo','Brasil','09853030','(Pq Bandeirantes)',1,'2017-05-24 18:00:40'),(14,2,'Rua dos Alemães','48','Alvarenga','São Bernardo do Campo','São Paulo','Brasil','09853030','(Pq Bandeirantes)',1,'2017-05-24 18:03:55'),(15,1,'Rua dos Alemães','41','Alvarenga','São Bernardo do Campo','São Paulo','Brasil','09853030','(Pq Bandeirantes)',1,'2017-05-24 18:08:01'),(16,1,'Rua dos Alemães','41','Alvarenga','São Bernardo do Campo','São Paulo','Brasil','09853030','(Pq Bandeirantes)',1,'2017-05-24 18:08:34'),(17,1,'Rua dos Alemães','23','Alvarenga','São Bernardo do Campo','São Paulo','Brasil','09853030','(Pq Bandeirantes)',1,'2017-05-25 16:51:00'),(18,1,'Rua dos Alemães','50','Alvarenga','São Bernardo do Campo','São Paulo','Brasil','09853030','(Pq Bandeirantes)',1,'2017-05-29 17:20:19'),(19,1,'Rua dos Alemães','48','Alvarenga','São Bernardo do Campo','São Paulo','Brasil','09853030','(Pq Bandeirantes)',1,'2017-05-29 18:23:01'),(20,1,'Rua dos Alemães','47','Alvarenga','São Bernardo do Campo','São Paulo','Brasil','09853030','(Pq Bandeirantes)',1,'2017-05-29 18:39:25'),(21,1,'Rua dos Alemães','39','Alvarenga','São Bernardo do Campo','São Paulo','Brasil','09853030','(Pq Bandeirantes)',1,'2017-05-29 18:49:20'),(22,1,'Rua dos Alemães','39','Alvarenga','São Bernardo do Campo','São Paulo','Brasil','09853030','(Pq Bandeirantes)',1,'2017-05-29 18:49:57'),(23,1,'Rua dos Alemães','17','Alvarenga','São Bernardo do Campo','São Paulo','Brasil','09853030','(Pq Bandeirantes)',1,'2017-05-29 18:54:57'),(24,1,'Rua dos Alemães','20','Alvarenga','São Bernardo do Campo','São Paulo','Brasil','09853030','(Pq Bandeirantes)',1,'2017-05-29 19:18:00'),(25,1,'Rua dos Alemães','20','Alvarenga','São Bernardo do Campo','São Paulo','Brasil','09853030','(Pq Bandeirantes)',1,'2017-05-29 19:18:54'),(26,1,'Rua dos Alemães','5','Alvarenga','São Bernardo do Campo','São Paulo','Brasil','09853030','(Pq Bandeirantes)',1,'2017-05-29 19:28:58'),(27,1,'Rua dos Alemães','45','Alvarenga','São Bernardo do Campo','São Paulo','Brasil','09853030','(Pq Bandeirantes)',1,'2017-05-29 19:31:15'),(28,1,'Rua dos Alemães','79','Alvarenga','São Bernardo do Campo','São Paulo','Brasil','09853030','(Pq Bandeirantes)',1,'2017-05-29 19:33:55'),(29,1,'Rua dos Alemães','34','Alvarenga','São Bernardo do Campo','São Paulo','Brasil','09853030','(Pq Bandeirantes)',1,'2017-05-29 22:53:45'),(30,1,'Rua dos Alemães','23','Alvarenga','São Bernardo do Campo','São Paulo','Brasil','09853030','(Pq Bandeirantes)',1,'2017-05-29 22:54:57'),(31,1,'Rua dos Alemães','48','Alvarenga','São Bernardo do Campo','São Paulo','Brasil','09853030','(Pq Bandeirantes)',1,'2017-05-29 22:56:51'),(32,1,'Rua dos Alemães','34','Alvarenga','São Bernardo do Campo','São Paulo','Brasil','09853030','(Pq Bandeirantes)',1,'2017-05-29 23:04:07'),(33,1,'Rua dos Alemães','34','Alvarenga','São Bernardo do Campo','São Paulo','Brasil','09853030','(Pq Bandeirantes)',1,'2017-05-29 23:11:21'),(34,1,'Rua dos Alemães','23','Alvarenga','São Bernardo do Campo','São Paulo','Brasil','09853030','(Pq Bandeirantes)',1,'2017-05-29 23:17:33'),(35,1,'Rua dos Alemães','46','Alvarenga','São Bernardo do Campo','São Paulo','Brasil','09853030','(Pq Bandeirantes)',1,'2017-05-30 01:31:56'),(36,1,'Rua dos Alemães','34','Alvarenga','São Bernardo do Campo','São Paulo','Brasil','09853030','(Pq Bandeirantes)',1,'2017-05-30 01:41:54'),(37,1,'Rua dos Alemães','23','Alvarenga','São Bernardo do Campo','São Paulo','Brasil','09853030','(Pq Bandeirantes)',1,'2017-05-30 01:45:13'),(38,1,'Rua dos Alemães','43','Alvarenga','São Bernardo do Campo','São Paulo','Brasil','09853030','(Pq Bandeirantes)',1,'2017-05-30 01:48:11'),(39,1,'Rua dos Alemães','34','Alvarenga','São Bernardo do Campo','São Paulo','Brasil','09853030','(Pq Bandeirantes)',1,'2017-05-30 01:49:09'),(40,1,'Rua dos Alemães','23','Alvarenga','São Bernardo do Campo','São Paulo','Brasil','09853030','(Pq Bandeirantes)',1,'2017-05-30 01:51:54'),(41,1,'Rua dos Alemães','34','Alvarenga','São Bernardo do Campo','São Paulo','Brasil','09853030','(Pq Bandeirantes)',1,'2017-05-30 18:17:50'),(42,1,'Rua dos Alemães','34','Alvarenga','São Bernardo do Campo','São Paulo','Brasil','09853030','(Pq Bandeirantes)',1,'2017-05-30 18:56:01'),(43,1,'Rua dos Alemães','34','Alvarenga','São Bernardo do Campo','São Paulo','Brasil','09853030','(Pq Bandeirantes)',1,'2017-05-30 19:00:15'),(44,1,'Rua dos Alemães','32','Alvarenga','São Bernardo do Campo','São Paulo','Brasil','09853030','(Pq Bandeirantes)',1,'2017-05-30 19:04:06'),(45,1,'Rua dos Alemães','45','Alvarenga','São Bernardo do Campo','São Paulo','Brasil','09853030','(Pq Bandeirantes)',1,'2017-05-30 19:08:21'),(46,1,'Rua dos Alemães','23','Alvarenga','São Bernardo do Campo','São Paulo','Brasil','09853030','(Pq Bandeirantes)',1,'2017-05-30 20:29:29'),(47,1,'Rua dos Alemães','34','Alvarenga','São Bernardo do Campo','São Paulo','Brasil','09853030','(Pq Bandeirantes)',1,'2017-05-31 16:58:19'),(48,1,'Rua dos Alemães','45','Alvarenga','São Bernardo do Campo','São Paulo','Brasil','09853030','(Pq Bandeirantes)',1,'2017-05-31 17:12:06'),(49,1,'Rua dos Alemães','34','Alvarenga','São Bernardo do Campo','São Paulo','Brasil','09853030','(Pq Bandeirantes)',1,'2017-06-02 16:46:57');
/*!40000 ALTER TABLE `tb_addresses` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-06-02 14:10:22
