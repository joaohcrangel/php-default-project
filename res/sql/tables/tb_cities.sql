CREATE TABLE `tb_cities` (
  `idcity` int(11) NOT NULL AUTO_INCREMENT,
  `descity` varchar(128) NOT NULL,
  `idstate` int(11) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idcity`),
  KEY `FK_cities_states_idx` (`idstate`),
  CONSTRAINT `FK_cities_states` FOREIGN KEY (`idstate`) REFERENCES `tb_states` (`idstate`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5565 DEFAULT CHARSET=utf8