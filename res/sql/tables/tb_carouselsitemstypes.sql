CREATE TABLE `tb_carouselsitemstypes` (
  `idtype` int(11) NOT NULL AUTO_INCREMENT,
  `destype` varchar(32) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idtype`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8