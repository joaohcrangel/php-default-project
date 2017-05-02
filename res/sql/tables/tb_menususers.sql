CREATE TABLE `tb_menususers` (
  `idmenu` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  KEY `FK_usersmenuspersons` (`iduser`),
  KEY `FK_usersmenusmenus` (`idmenu`),
  CONSTRAINT `FK_usersmenusmenus` FOREIGN KEY (`idmenu`) REFERENCES `tb_menus` (`idmenu`),
  CONSTRAINT `FK_usersmenuspersons` FOREIGN KEY (`iduser`) REFERENCES `tb_users` (`iduser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8