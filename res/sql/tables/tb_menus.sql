CREATE TABLE `tb_menus` (
  `idmenu` int(11) NOT NULL AUTO_INCREMENT,
  `idmenufather` int(11) DEFAULT NULL,
  `desmenu` varchar(128) NOT NULL,
  `desicon` varchar(64) NOT NULL,
  `deshref` varchar(64) NOT NULL,
  `nrorder` int(11) NOT NULL,
  `nrsubmenus` int(11) DEFAULT '0',
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idmenu`),
  KEY `FK_menus_menus` (`idmenufather`),
  CONSTRAINT `FK_menus_menus` FOREIGN KEY (`idmenufather`) REFERENCES `tb_menus` (`idmenu`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8