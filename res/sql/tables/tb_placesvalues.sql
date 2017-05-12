CREATE TABLE `tb_placesvalues` (
  `idplacevalue` int(11) NOT NULL AUTO_INCREMENT,
  `idplace` int(11) NOT NULL,
  `idfield` int(11) NOT NULL,
  `desvalue` varchar(128) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idplacevalue`),
  KEY `idplace` (`idplace`),
  KEY `idfield` (`idfield`),
  CONSTRAINT `tb_placesvalues_ibfk_1` FOREIGN KEY (`idplace`) REFERENCES `tb_places` (`idplace`),
  CONSTRAINT `tb_placesvalues_ibfk_2` FOREIGN KEY (`idfield`) REFERENCES `tb_placesvaluesfields` (`idfield`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8