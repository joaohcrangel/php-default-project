CREATE TABLE `tb_countries` (
  `idcountry` int(11) NOT NULL AUTO_INCREMENT,
  `descountry` varchar(64) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idcountry`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8