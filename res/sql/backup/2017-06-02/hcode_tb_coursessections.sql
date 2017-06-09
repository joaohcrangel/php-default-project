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
-- Table structure for table `tb_coursessections`
--

DROP TABLE IF EXISTS `tb_coursessections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_coursessections` (
  `idsection` int(11) NOT NULL AUTO_INCREMENT,
  `dessection` varchar(128) NOT NULL,
  `nrorder` int(11) NOT NULL DEFAULT '0',
  `idcourse` int(11) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idsection`),
  KEY `FK_coursessections_courses_idx` (`idcourse`),
  CONSTRAINT `FK_coursessections_courses` FOREIGN KEY (`idcourse`) REFERENCES `tb_courses` (`idcourse`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_coursessections`
--

LOCK TABLES `tb_coursessections` WRITE;
/*!40000 ALTER TABLE `tb_coursessections` DISABLE KEYS */;
INSERT INTO `tb_coursessections` VALUES (1,'Seção 1',1,2,'2017-05-16 19:08:28'),(2,'Seção 2',2,2,'2017-05-16 19:38:28'),(4,'História da Linguagem SQL, Instalação e Configuração do MySQL 5.7',1,4,'2017-05-30 16:49:27'),(5,'MySQL Workbench, Bancos e Tabelas',2,4,'2017-05-30 16:49:50'),(6,'DataType - Entendendo os Tipos de Dados',3,4,'2017-05-30 16:50:14'),(7,'Conhecendo as subdivisões da linguagem SQL, DDL, DCL, DTL, DQL e DML',4,4,'2017-05-30 16:50:40'),(8,'Comandos DML - Data Manipulation Language',5,4,'2017-05-30 16:51:09'),(9,'Comandos DQL - Data Query Language',6,4,'2017-05-30 16:51:35'),(10,'Cláusulas e Operadores servem como complemento para os comandos da linguagem SQL',7,4,'2017-05-30 16:52:06'),(11,'Alterando e Excluindo Dados - Update e Delete com Where',8,4,'2017-05-30 16:52:37'),(12,'Constraints - Evite redundância e anomalias de dados além de aplicar índices.',9,4,'2017-05-30 16:53:02'),(13,'Consultas Avançadas com Joins e Subqueries',10,4,'2017-05-30 16:53:25'),(14,'Agrupando Dados com Group By',11,4,'2017-05-30 16:53:56'),(15,'Views, Stored Procedures e Functions',12,4,'2017-05-30 16:54:23');
/*!40000 ALTER TABLE `tb_coursessections` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-06-02 14:12:23
