CREATE TABLE `tb_coursessections` (
  `idsection` int(11) NOT NULL AUTO_INCREMENT,
  `dessection` varchar(128) NOT NULL,
  `nrorder` int(11) NOT NULL DEFAULT '0',
  `idcourse` int(11) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idsection`),
  KEY `FK_coursessections_courses_idx` (`idcourse`),
  CONSTRAINT `FK_coursessections_courses` FOREIGN KEY (`idcourse`) REFERENCES `tb_courses` (`idcourse`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8