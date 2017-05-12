CREATE TABLE `tb_userstypes` (
  `idusertype` int(11) NOT NULL AUTO_INCREMENT,
  `desusertype` varchar(32) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idusertype`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8