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
-- Table structure for table `tb_formspayments`
--

DROP TABLE IF EXISTS `tb_formspayments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_formspayments` (
  `idformpayment` int(11) NOT NULL AUTO_INCREMENT,
  `idgateway` int(11) NOT NULL,
  `desformpayment` varchar(128) NOT NULL,
  `nrparcelsmax` int(11) NOT NULL,
  `instatus` bit(1) DEFAULT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idformpayment`),
  KEY `idgateway` (`idgateway`),
  CONSTRAINT `tb_formspayments_ibfk_1` FOREIGN KEY (`idgateway`) REFERENCES `tb_gateways` (`idgateway`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_formspayments`
--

LOCK TABLES `tb_formspayments` WRITE;
/*!40000 ALTER TABLE `tb_formspayments` DISABLE KEYS */;
INSERT INTO `tb_formspayments` VALUES (1,1,'Visa',12,'','2017-04-18 16:17:54'),(2,1,'MasterCard',12,'','2017-04-18 16:17:54'),(3,1,'Diners Club',12,'','2017-04-18 16:17:54'),(4,1,'Amex',12,'','2017-04-18 16:17:54'),(5,1,'HiperCard',12,'','2017-04-18 16:17:54'),(6,1,'Aura',12,'','2017-04-18 16:17:54'),(7,1,'Elo',12,'','2017-04-18 16:17:54'),(8,1,'Boleto',1,'','2017-04-18 16:17:54'),(9,1,'Débito Online Itaú',1,'','2017-04-18 16:17:54'),(10,1,'Débito Online Banco do Brasil',1,'','2017-04-18 16:17:54'),(11,1,'Débito Online Banco Banrisul',1,'','2017-04-18 16:17:54'),(12,1,'Débito Online Banco Bradesco',1,'','2017-04-18 16:17:54'),(13,1,'Débito Online Banco HSBC',1,'','2017-04-18 16:17:54'),(14,1,'PlenoCard',3,'','2017-04-18 16:17:54'),(15,1,'PersonalCard',3,'','2017-04-18 16:17:54'),(16,1,'JCB',1,'','2017-04-18 16:17:54'),(17,1,'Discover',1,'','2017-04-18 16:17:54'),(18,1,'BrasilCard',12,'','2017-04-18 16:17:54'),(19,1,'FortBrasil',12,'','2017-04-18 16:17:54'),(20,1,'CardBan',12,'','2017-04-18 16:17:54'),(21,1,'ValeCard',3,'','2017-04-18 16:17:54'),(22,1,'Cabal',12,'','2017-04-18 16:17:54'),(23,1,'Mais',10,'','2017-04-18 16:17:54'),(24,1,'Avista',6,'','2017-04-18 16:17:54'),(25,1,'GRANDCARD',12,'','2017-04-18 16:17:54'),(26,1,'Sorocred',12,'','2017-04-18 16:17:54');
/*!40000 ALTER TABLE `tb_formspayments` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-06-02 14:13:48
