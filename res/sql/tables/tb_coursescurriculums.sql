CREATE TABLE `tb_coursescurriculums` (
  `idcurriculum` int(11) NOT NULL AUTO_INCREMENT,
  `descurriculum` varchar(128) NOT NULL,
  `idsection` int(11) NOT NULL,
  `desdescription` varchar(2048) DEFAULT NULL,
  `nrorder` varchar(45) DEFAULT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idcurriculum`),
  KEY `FK_coursescurriculums_coursessections_idx` (`idsection`),
  CONSTRAINT `FK_coursescurriculums_coursessections` FOREIGN KEY (`idsection`) REFERENCES `tb_coursessections` (`idsection`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8