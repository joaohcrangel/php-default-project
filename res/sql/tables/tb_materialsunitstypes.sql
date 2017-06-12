CREATE TABLE `tb_materialsunitstypes` (
  `idunitytype` int(11) NOT NULL AUTO_INCREMENT,
  `desunitytype` varchar(64) NOT NULL,
  `desunitytypeshort` varchar(8) DEFAULT 'null',
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idunitytype`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1