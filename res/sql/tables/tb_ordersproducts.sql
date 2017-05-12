CREATE TABLE `tb_ordersproducts` (
  `idorder` int(11) NOT NULL,
  `idproduct` int(11) NOT NULL,
  `nrqtd` int(11) NOT NULL,
  `vlprice` decimal(10,2) NOT NULL,
  `vltotal` decimal(10,2) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idorder`,`idproduct`),
  KEY `idproduct` (`idproduct`),
  CONSTRAINT `tb_ordersproducts_ibfk_1` FOREIGN KEY (`idorder`) REFERENCES `tb_orders` (`idorder`),
  CONSTRAINT `tb_ordersproducts_ibfk_2` FOREIGN KEY (`idproduct`) REFERENCES `tb_products` (`idproduct`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8