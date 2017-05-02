CREATE TABLE `tb_personstypes` (
  `idpersontype` int(11) NOT NULL AUTO_INCREMENT,
  `despersontype` varchar(64) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idpersontype`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8