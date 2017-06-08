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
-- Table structure for table `tb_sitesmenus`
--

DROP TABLE IF EXISTS `tb_sitesmenus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_sitesmenus` (
  `idmenu` int(11) NOT NULL AUTO_INCREMENT,
  `idmenufather` int(11) DEFAULT NULL,
  `desmenu` varchar(128) NOT NULL,
  `desicon` varchar(64) DEFAULT NULL,
  `deshref` varchar(64) NOT NULL,
  `nrorder` int(11) NOT NULL,
  `nrsubmenus` int(11) NOT NULL DEFAULT '0',
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idmenu`),
  KEY `FK_sitesmenus_sitesmenus` (`idmenufather`),
  CONSTRAINT `FK_sitesmenus_sitesmenus` FOREIGN KEY (`idmenufather`) REFERENCES `tb_sitesmenus` (`idmenu`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_sitesmenus`
--

LOCK TABLES `tb_sitesmenus` WRITE;
/*!40000 ALTER TABLE `tb_sitesmenus` DISABLE KEYS */;
INSERT INTO `tb_sitesmenus` VALUES (1,NULL,'Home','','/',0,1,'2017-05-29 18:20:02'),(2,NULL,'Contato','','/contato',3,0,'2017-05-29 18:21:23'),(3,NULL,'Blog','','/blog',4,0,'2017-05-29 18:22:09'),(5,NULL,'Curso de PHP 7','','/shop/curso-completo-de-php-7',1,0,'2017-05-29 18:19:48'),(6,NULL,'Curso de HTML5','','/shop/curso-html5-css3-javascript',2,0,'2017-06-02 14:10:32');
/*!40000 ALTER TABLE `tb_sitesmenus` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-06-02 14:10:01
