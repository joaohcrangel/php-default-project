CREATE TABLE `tb_ordersreceipts` (
  `idorder` int(11) NOT NULL,
  `desauthentication` varchar(256) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idorder`),
  CONSTRAINT `tb_ordersreceipts_ibfk_1` FOREIGN KEY (`idorder`) REFERENCES `tb_orders` (`idorder`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8