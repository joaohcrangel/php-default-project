CREATE TABLE `tb_users` (
  `iduser` int(11) NOT NULL AUTO_INCREMENT,
  `idperson` int(11) NOT NULL,
  `desuser` varchar(128) NOT NULL,
  `despassword` varchar(256) NOT NULL,
  `inblocked` tinyint(1) NOT NULL DEFAULT 0,
  `idusertype` int(11) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`iduser`),
  KEY `FK_users_persons` (`idperson`),
  KEY `FK_users_userstypes` (`idusertype`),
  CONSTRAINT `FK_users_persons` FOREIGN KEY (`idperson`) REFERENCES `tb_persons` (`idperson`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_users_userstypes` FOREIGN KEY (`idusertype`) REFERENCES `tb_userstypes` (`idusertype`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8