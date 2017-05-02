CREATE TABLE `tb_coupons` (
  `idcoupon` int(11) NOT NULL AUTO_INCREMENT,
  `idcoupontype` int(11) NOT NULL,
  `descoupon` varchar(128) NOT NULL,
  `descode` varchar(128) NOT NULL,
  `nrqtd` int(11) NOT NULL DEFAULT '1',
  `nrqtdused` int(11) NOT NULL DEFAULT '0',
  `dtstart` datetime DEFAULT NULL,
  `dtend` datetime DEFAULT NULL,
  `inremoved` bit(1) DEFAULT NULL,
  `nrdiscount` decimal(10,2) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idcoupon`),
  KEY `idcoupontype` (`idcoupontype`),
  CONSTRAINT `tb_coupons_ibfk_1` FOREIGN KEY (`idcoupontype`) REFERENCES `tb_couponstypes` (`idcoupontype`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8