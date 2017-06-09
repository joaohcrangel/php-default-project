CREATE TABLE `tb_transactionsaccountstypes` (
  `idtype` int(11) NOT NULL AUTO_INCREMENT,
  `destype` varchar(32) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idtype`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8