CREATE TABLE `tb_placestypes` (
  `idplacetype` int(11) NOT NULL AUTO_INCREMENT,
  `desplacetype` varchar(128) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idplacetype`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8