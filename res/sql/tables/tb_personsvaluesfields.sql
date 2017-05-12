CREATE TABLE `tb_personsvaluesfields` (
  `idfield` int(11) NOT NULL AUTO_INCREMENT,
  `desfield` varchar(128) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idfield`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8