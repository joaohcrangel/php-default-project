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
-- Table structure for table `tb_instructors`
--

DROP TABLE IF EXISTS `tb_instructors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_instructors` (
  `idinstructor` int(11) NOT NULL AUTO_INCREMENT,
  `idperson` int(11) NOT NULL,
  `desbiography` text NOT NULL,
  `idphoto` int(11) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idinstructor`),
  KEY `fk_instructors_persons` (`idperson`),
  KEY `fk_instructors_files` (`idphoto`),
  CONSTRAINT `fk_instructors_files` FOREIGN KEY (`idphoto`) REFERENCES `tb_files` (`idfile`),
  CONSTRAINT `fk_instructors_persons` FOREIGN KEY (`idperson`) REFERENCES `tb_persons` (`idperson`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_instructors`
--

LOCK TABLES `tb_instructors` WRITE;
/*!40000 ALTER TABLE `tb_instructors` DISABLE KEYS */;
INSERT INTO `tb_instructors` VALUES (2,157,'Certificado MCP no exame 70-480 - Programming in HTML5 with JavaScript and CSS3, desenvolvedor web desde 2005 com ênfase em JavaScript e PHP. Tem vasta experiência em bibliotecas javascript como jQuery, Bootstrap, jQuery UI, jQuery Mobile, ExtJS, Backbone.\r\n\r\nEspecialista na Linguagem JavaScript ES2015 e PHP7 João planejou e construir dezenas de Sistemas Corporativos baseados em PHP e JavaScript, entre eles um ERP utilizado por grandes instituições de Ensino.\r\n\r\nAtua como Instrutor e CTO na Hcode onde coordena os sistemas desenvolvidos pela Hcode além da adoção de novas tecnologias e metodologias de desenvolvimento.\r\n\r\nNas horas vagas, desenvolve aplicativos em Android, além de criar muitas experiências com Arduíno e Raspberry Pi.',52,'2017-05-19 19:06:14'),(4,160,'Glaucio Daniel atua como Instrutor de TI, Administrador de Banco de Dados SQL Server e MySQL, Web Developer focado em HTML5, JavaScript(ES6), PHP. \r\n\r\n\r\nDurante mais de uma década foi instrutor e coordenador de treinamentos web no Grupo Impacta o maior centro de treinamento em TI da América Latina. Já treinou mais de 6000 alunos das maiores empresas do País entre elas: Vale, Petrobras, Itau, Ministério Público, Bradesco, Sabesp, Telefônica, Prefeitura de São Paulo, Jornal Folha de São Paulo, Rádio CBN, Tribunal Regional Eleitoral, Polícia Militar SP, Corpo de Bombeiros SP.\r\n\r\nAtua como CEO na Hcode onde trabalha com uma equipe incrível para criar cursos de alto nível online e presencial, voltados para o Desenvolvimento Web, são mais de 7500 alunos treinados pela Hcode em cursos online. Totalizando mais de 13500 alunos treinados.			      ',50,'2017-05-30 19:01:20'),(5,155,'Especialista em 3D, edição de vídeo e animação, projetista e cenógrafo. Atua a mais 15 anos em construção e projetos de eventos, atuando nas diversas nuances do projeto, construção civil, elétrica, hidráulica.\r\n\r\nAtua como Chefe de Operações - COO na Hcode onde coordena um dos pilares da Hcode que é a equipe de gravação, edição e pós-produção Hcode, coordena as atividades do Hcode Studio rotina de gravação, define os padrões e novos recursos que serão adotados nos cursos online.\r\n\r\nNas horas vagas, é um apaixonado por fotografia e cinema, estuda a fundo os conceitos de arte, cores, som e iluminação.',51,'2017-05-30 19:03:16');
/*!40000 ALTER TABLE `tb_instructors` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-06-02 14:10:28
