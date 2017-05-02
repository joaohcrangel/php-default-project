CREATE TABLE `tb_places` (
  `idplace` int(11) NOT NULL AUTO_INCREMENT,
  `idplacefather` int(11) DEFAULT NULL,
  `desplace` varchar(128) NOT NULL,
  `idplacetype` int(11) NOT NULL,
  `descontent` text,
  `nrviews` int(11) DEFAULT NULL,
  `vlreview` decimal(10,2) DEFAULT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idplace`),
  KEY `idplacefather` (`idplacefather`),
  KEY `idplacetype` (`idplacetype`),
  CONSTRAINT `tb_places_ibfk_1` FOREIGN KEY (`idplacefather`) REFERENCES `tb_places` (`idplace`),
  CONSTRAINT `tb_places_ibfk_2` FOREIGN KEY (`idplacetype`) REFERENCES `tb_placestypes` (`idplacetype`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8