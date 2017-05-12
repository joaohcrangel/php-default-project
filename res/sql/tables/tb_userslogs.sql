CREATE TABLE `tb_userslogs` (
  `idlog` int(11) NOT NULL AUTO_INCREMENT,
  `iduser` int(11) NOT NULL,
  `idlogtype` int(11) NOT NULL,
  `deslog` varchar(256) NOT NULL,
  `desip` varchar(64) NOT NULL,
  `dessession` varchar(64) NOT NULL,
  `desuseragent` varchar(128) NOT NULL,
  `despath` varchar(256) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idlog`),
  KEY `fk_userslogs_users_idx` (`iduser`),
  KEY `fk_userslogs_userslogstypes_idx` (`idlogtype`),
  CONSTRAINT `fk_userslogs_users` FOREIGN KEY (`iduser`) REFERENCES `tb_users` (`iduser`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_userslogs_userslogstypes` FOREIGN KEY (`idlogtype`) REFERENCES `tb_personslogstypes` (`idlogtype`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8