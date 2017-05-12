CREATE TABLE `tb_userslogstypes` (
  `idlogtype` int(11) NOT NULL AUTO_INCREMENT,
  `deslogtype` varchar(32) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idlogtype`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8