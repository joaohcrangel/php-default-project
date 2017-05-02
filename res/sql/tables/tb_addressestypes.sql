CREATE TABLE `tb_addressestypes` (
  `idaddresstype` int(11) NOT NULL AUTO_INCREMENT,
  `desaddresstype` varchar(64) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idaddresstype`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8