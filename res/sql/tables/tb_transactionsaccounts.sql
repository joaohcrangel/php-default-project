CREATE TABLE `tb_transactionsaccounts` (
  `idaccount` int(11) NOT NULL AUTO_INCREMENT,
  `desaccount` varchar(64) NOT NULL,
  `idtype` int(11) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idaccount`),
  KEY `fk_transactionsaccounts_transactionsaccountstypes_idx` (`idtype`),
  CONSTRAINT `fk_transactionsaccounts_transactionsaccountstypes` FOREIGN KEY (`idtype`) REFERENCES `tb_transactionstypes` (`idtransactiontype`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8