CREATE TABLE `tb_materialsunitstypes` (
  `idunitytype` int(11) NOT NULL AUTO_INCREMENT,
  `desidunitytype` varchar(64) NOT NULL,
  `desunitytypeshort` varchar(8) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idunitytype`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1