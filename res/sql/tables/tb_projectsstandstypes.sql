CREATE TABLE `tb_projectsstandstypes` (
  `idstandtype` int(11) NOT NULL AUTO_INCREMENT,
  `desstandtype` varchar(64) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idstandtype`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1