CREATE TABLE `tb_contactstypes` (
  `idcontacttype` int(11) NOT NULL AUTO_INCREMENT,
  `descontacttype` varchar(64) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idcontacttype`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8