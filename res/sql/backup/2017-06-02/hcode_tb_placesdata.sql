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
-- Table structure for table `tb_placesdata`
--

DROP TABLE IF EXISTS `tb_placesdata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_placesdata` (
  `idplace` int(11) NOT NULL,
  `desplace` varchar(128) NOT NULL,
  `idplacefather` int(11) DEFAULT NULL,
  `desplacefather` varchar(128) DEFAULT NULL,
  `idplacetype` int(11) NOT NULL,
  `desplacetype` varchar(128) NOT NULL,
  `idaddresstype` int(11) DEFAULT NULL,
  `desaddresstype` varchar(128) DEFAULT NULL,
  `idaddress` int(11) DEFAULT NULL,
  `desaddress` varchar(128) DEFAULT NULL,
  `desnumber` varchar(16) DEFAULT NULL,
  `desdistrict` varchar(64) DEFAULT NULL,
  `descity` varchar(64) DEFAULT NULL,
  `desstate` varchar(32) DEFAULT NULL,
  `descountry` varchar(32) DEFAULT NULL,
  `descep` char(8) DEFAULT NULL,
  `descomplement` varchar(32) DEFAULT NULL,
  `idcoordinate` int(11) DEFAULT NULL,
  `vllatitude` decimal(20,17) DEFAULT NULL,
  `vllongitude` decimal(20,17) DEFAULT NULL,
  `nrzoom` tinyint(4) DEFAULT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idplace`),
  KEY `idplacefather` (`idplacefather`),
  KEY `idplacetype` (`idplacetype`),
  KEY `idaddress` (`idaddress`),
  KEY `idaddresstype` (`idaddresstype`),
  KEY `idcoordinate` (`idcoordinate`),
  CONSTRAINT `tb_placesdata_ibfk_1` FOREIGN KEY (`idplace`) REFERENCES `tb_places` (`idplace`),
  CONSTRAINT `tb_placesdata_ibfk_2` FOREIGN KEY (`idplacefather`) REFERENCES `tb_places` (`idplace`),
  CONSTRAINT `tb_placesdata_ibfk_3` FOREIGN KEY (`idplacetype`) REFERENCES `tb_placestypes` (`idplacetype`),
  CONSTRAINT `tb_placesdata_ibfk_4` FOREIGN KEY (`idaddress`) REFERENCES `tb_addresses` (`idaddress`),
  CONSTRAINT `tb_placesdata_ibfk_5` FOREIGN KEY (`idaddresstype`) REFERENCES `tb_addressestypes` (`idaddresstype`),
  CONSTRAINT `tb_placesdata_ibfk_6` FOREIGN KEY (`idcoordinate`) REFERENCES `tb_coordinates` (`idcoordinate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_placesdata`
--

LOCK TABLES `tb_placesdata` WRITE;
/*!40000 ALTER TABLE `tb_placesdata` DISABLE KEYS */;
INSERT INTO `tb_placesdata` VALUES (2,'Hcode Treinamentos',NULL,NULL,5,'Empresas',2,'Comercial',2,'Avenida Ademar Saraiva Leão','234','Alvarenga','São Bernardo do Campo','São Paulo','Brasil','09853120','',1,-23.74117792700300000,-46.60400658845900000,19,'2017-05-11 20:54:42');
/*!40000 ALTER TABLE `tb_placesdata` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-06-02 14:09:21
