CREATE TABLE `tb_productstypes` (
  `idproducttype` int(11) NOT NULL AUTO_INCREMENT,
  `desproducttype` varchar(64) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idproducttype`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8