CREATE TABLE `tb_permissionsmenus` (
  `idpermission` int(11) NOT NULL,
  `idmenu` int(11) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idpermission`,`idmenu`),
  KEY `FK_menuspermissions` (`idmenu`),
  CONSTRAINT `FK_menuspermissions` FOREIGN KEY (`idmenu`) REFERENCES `tb_menus` (`idmenu`),
  CONSTRAINT `FK_permissionsmenus` FOREIGN KEY (`idpermission`) REFERENCES `tb_permissions` (`idpermission`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8