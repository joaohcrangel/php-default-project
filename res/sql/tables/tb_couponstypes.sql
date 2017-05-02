CREATE TABLE `tb_couponstypes` (
  `idcoupontype` int(11) NOT NULL AUTO_INCREMENT,
  `descoupontype` varchar(128) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idcoupontype`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8