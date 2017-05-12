CREATE TABLE `tb_productsurls` (
  `idproduct` int(11) NOT NULL,
  `idurl` int(11) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `idproduct` (`idproduct`),
  KEY `idurl` (`idurl`),
  CONSTRAINT `tb_productsurls_ibfk_1` FOREIGN KEY (`idproduct`) REFERENCES `tb_products` (`idproduct`),
  CONSTRAINT `tb_productsurls_ibfk_2` FOREIGN KEY (`idurl`) REFERENCES `tb_urls` (`idurl`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1