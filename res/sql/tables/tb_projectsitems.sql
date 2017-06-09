CREATE TABLE `tb_projectsitems` (
  `iditem` int(11) NOT NULL AUTO_INCREMENT,
  `desitem` varchar(64) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`iditem`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1