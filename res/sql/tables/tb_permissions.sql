CREATE TABLE `tb_permissions` (
  `idpermission` int(11) NOT NULL AUTO_INCREMENT,
  `despermission` varchar(64) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idpermission`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8