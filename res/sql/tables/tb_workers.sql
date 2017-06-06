CREATE TABLE `tb_workers` (
  `idworker` int(11) NOT NULL AUTO_INCREMENT,
  `idperson` int(11) NOT NULL,
  `idjobposition` int(11) NOT NULL,
  `idphoto` int(11) DEFAULT NULL,
  `inapproved` bit NOT NULL DEFAULT b'0',
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idworker`),
  KEY `idperson` (`idperson`),
  KEY `idjobposition` (`idjobposition`),
  KEY `idphoto` (`idphoto`),
  CONSTRAINT `FK_workers_persons` FOREIGN KEY (`idperson`) REFERENCES `tb_persons` (`idperson`),
  CONSTRAINT `FK_workers_jobspositions` FOREIGN KEY (`idjobposition`) REFERENCES `tb_jobspositions` (`idjobposition`),
  CONSTRAINT `FK_workers_files` FOREIGN KEY (`idphoto`) REFERENCES `tb_files` (`idfile`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1