CREATE TABLE `tb_cartscoupons` (
  `idcart` int(11) NOT NULL,
  `idcoupon` int(11) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `idcart` (`idcart`),
  KEY `idcoupon` (`idcoupon`),
  CONSTRAINT `tb_cartscoupons_ibfk_1` FOREIGN KEY (`idcart`) REFERENCES `tb_carts` (`idcart`),
  CONSTRAINT `tb_cartscoupons_ibfk_2` FOREIGN KEY (`idcoupon`) REFERENCES `tb_coupons` (`idcoupon`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8