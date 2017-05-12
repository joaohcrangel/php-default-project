CREATE TABLE `tb_cartsproducts` (
  `idcartproduct` int(11) NOT NULL AUTO_INCREMENT,
  `idcart` int(11) NOT NULL,
  `idproduct` int(11) NOT NULL,
  `dtremoved` datetime DEFAULT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idcartproduct`),
  KEY `idcart` (`idcart`),
  KEY `idproduct` (`idproduct`),
  CONSTRAINT `tb_cartsproducts_ibfk_1` FOREIGN KEY (`idcart`) REFERENCES `tb_carts` (`idcart`),
  CONSTRAINT `tb_cartsproducts_ibfk_2` FOREIGN KEY (`idproduct`) REFERENCES `tb_products` (`idproduct`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8