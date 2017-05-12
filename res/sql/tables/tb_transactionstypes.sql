CREATE TABLE `tb_transactionstypes` (
  `idtransactiontype` int(11) NOT NULL AUTO_INCREMENT,
  `destransactiontype` varchar(32) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idtransactiontype`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8