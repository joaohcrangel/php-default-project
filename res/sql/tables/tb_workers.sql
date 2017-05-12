CREATE TABLE `tb_workers` (
  `idworker` int(11) NOT NULL AUTO_INCREMENT,
  `idperson` int(11) NOT NULL,
  `idjobposition` int(11) NOT NULL,
  `idphoto` int(11) DEFAULT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idworker`),
  KEY `idperson` (`idperson`),
  KEY `idjobposition` (`idjobposition`),
  KEY `idphoto` (`idphoto`),
  CONSTRAINT `tb_workers_ibfk_1` FOREIGN KEY (`idperson`) REFERENCES `tb_persons` (`idperson`),
  CONSTRAINT `tb_workers_ibfk_2` FOREIGN KEY (`idjobposition`) REFERENCES `tb_jobspositions` (`idjobposition`),
  CONSTRAINT `tb_workers_ibfk_3` FOREIGN KEY (`idphoto`) REFERENCES `tb_files` (`idfile`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1