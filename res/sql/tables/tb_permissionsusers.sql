CREATE TABLE `tb_permissionsusers` (
  `idpermission` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idpermission`,`iduser`),
  KEY `FK_userspermissions` (`iduser`),
  CONSTRAINT `FK_permissionsusers` FOREIGN KEY (`idpermission`) REFERENCES `tb_permissions` (`idpermission`),
  CONSTRAINT `FK_userspermissions` FOREIGN KEY (`iduser`) REFERENCES `tb_users` (`iduser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8