CREATE TABLE `tb_cartsfreights` (
  `idcart` int(11) NOT NULL,
  `descep` char(8) NOT NULL,
  `vlfreight` decimal(10,2) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `idcart` (`idcart`),
  CONSTRAINT `tb_cartsfreights_ibfk_1` FOREIGN KEY (`idcart`) REFERENCES `tb_carts` (`idcart`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8