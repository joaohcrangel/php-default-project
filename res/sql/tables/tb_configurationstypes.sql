CREATE TABLE `tb_configurationstypes` (
  `idconfigurationtype` int(11) NOT NULL AUTO_INCREMENT,
  `desconfigurationtype` varchar(32) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idconfigurationtype`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8