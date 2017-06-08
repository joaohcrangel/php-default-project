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
-- Table structure for table `tb_carouselsitems`
--

DROP TABLE IF EXISTS `tb_carouselsitems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_carouselsitems` (
  `iditem` int(11) NOT NULL AUTO_INCREMENT,
  `desitem` varchar(45) NOT NULL,
  `descontent` text,
  `nrorder` varchar(45) NOT NULL DEFAULT '0',
  `idtype` int(11) NOT NULL,
  `idcover` int(11) DEFAULT NULL,
  `idcarousel` int(11) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`iditem`),
  KEY `FK_carouselsitems_carousels_idx` (`idcarousel`),
  KEY `FK_carouselsitems_carouselsitemstypes_idx` (`idtype`),
  KEY `FK_carouselsitems_files_idx` (`idcover`),
  CONSTRAINT `FK_carouselsitems_carousels` FOREIGN KEY (`idcarousel`) REFERENCES `tb_carousels` (`idcarousel`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_carouselsitems_carouselsitemstypes` FOREIGN KEY (`idtype`) REFERENCES `tb_carouselsitemstypes` (`idtype`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_carouselsitems_files` FOREIGN KEY (`idcover`) REFERENCES `tb_files` (`idfile`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_carouselsitems`
--

LOCK TABLES `tb_carouselsitems` WRITE;
/*!40000 ALTER TABLE `tb_carouselsitems` DISABLE KEYS */;
INSERT INTO `tb_carouselsitems` VALUES (1,'teste','<div class=\"container clearfix\"><div class=\"slider-caption slider-caption-center\"><h2 data-caption-animate=\"fadeInUp\">Aprender pode ser Divertido</h2><p data-caption-animate=\"fadeInUp\" data-caption-delay=\"200\">Ensinamos tecnologias para criar sites modernos e aplicativos incríveis.</p></div></div>','0',1,15,1,'2017-05-26 17:23:17'),(2,'teste2','<div class=\"container clearfix\"><div class=\"slider-caption slider-caption-center\"><h2 data-caption-animate=\"fadeInUp\">Estudo Online</h2><p data-caption-animate=\"fadeInUp\" data-caption-delay=\"200\">Assista as aulas do seu computador, tablet ou celular.</p></div></div>','1',1,16,1,'2017-05-26 17:52:27'),(5,'item 3','<p>&nbsp;&nbsp;&nbsp;&nbsp;</p><h1>&nbsp; &nbsp; Olha aí João, ta funfando</h1>','2',1,29,1,'2017-05-29 18:34:43');
/*!40000 ALTER TABLE `tb_carouselsitems` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-06-02 14:04:44
