CREATE TABLE `tb_transactionsaccounts` (
  `idaccount` int(11) NOT NULL AUTO_INCREMENT,
  `desaccount` varchar(64) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idaccount`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8