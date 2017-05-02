CREATE TABLE `tb_personsvalues` (
  `idpersonvalue` int(11) NOT NULL AUTO_INCREMENT,
  `idperson` int(11) NOT NULL,
  `idfield` int(11) NOT NULL,
  `desvalue` varchar(128) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idpersonvalue`),
  KEY `idperson` (`idperson`),
  KEY `idfield` (`idfield`),
  CONSTRAINT `tb_personsvalues_ibfk_1` FOREIGN KEY (`idperson`) REFERENCES `tb_persons` (`idperson`),
  CONSTRAINT `tb_personsvalues_ibfk_2` FOREIGN KEY (`idfield`) REFERENCES `tb_personsvaluesfields` (`idfield`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8