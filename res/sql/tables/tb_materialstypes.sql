CREATE TABLE `tb_materialstypes` (
  `idtype` int(11) NOT NULL AUTO_INCREMENT,
  `destype` varchar(64) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idtype`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1