CREATE TABLE `tb_transactionsfiles` (
  `idtransaction` int(11) NOT NULL,
  `idfile` int(11) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idtransaction`,`idfile`),
  KEY `fk_transactionsfiles_files_idx` (`idfile`),
  CONSTRAINT `fk_transactionsfiles_files` FOREIGN KEY (`idfile`) REFERENCES `tb_files` (`idfile`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_transactionsfiles_transactions` FOREIGN KEY (`idtransaction`) REFERENCES `tb_transactions` (`idtransaction`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8