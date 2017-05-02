CREATE TABLE `tb_states` (
  `idstate` int(11) NOT NULL AUTO_INCREMENT,
  `desstate` varchar(64) NOT NULL,
  `desuf` char(2) NOT NULL,
  `idcountry` int(11) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idstate`),
  KEY `FK_states_countries_idx` (`idcountry`),
  CONSTRAINT `FK_states_countries` FOREIGN KEY (`idcountry`) REFERENCES `tb_countries` (`idcountry`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8