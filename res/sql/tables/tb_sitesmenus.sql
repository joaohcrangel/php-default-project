CREATE TABLE `tb_sitesmenus` (
  `idmenu` int(11) NOT NULL AUTO_INCREMENT,
  `idmenufather` int(11) DEFAULT NULL,
  `desmenu` varchar(128) NOT NULL,
  `desicon` varchar(64) DEFAULT NULL,
  `deshref` varchar(64) NOT NULL,
  `nrorder` int(11) NOT NULL,
  `nrsubmenus` int(11) NOT NULL DEFAULT '0',
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idmenu`),
  KEY `FK_sitesmenus_sitesmenus` (`idmenufather`),
  CONSTRAINT `FK_sitesmenus_sitesmenus` FOREIGN KEY (`idmenufather`) REFERENCES `tb_sitesmenus` (`idmenu`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8