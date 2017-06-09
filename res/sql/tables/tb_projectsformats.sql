CREATE TABLE `tb_projectsformats` (
  `idformat` int(11) NOT NULL AUTO_INCREMENT,
  `desformat` varchar(64) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idformat`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1