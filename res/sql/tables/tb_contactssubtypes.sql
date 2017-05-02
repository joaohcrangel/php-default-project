CREATE TABLE `tb_contactssubtypes` (
  `idcontactsubtype` int(11) NOT NULL AUTO_INCREMENT,
  `descontactsubtype` varchar(32) NOT NULL,
  `idcontacttype` int(11) NOT NULL,
  `iduser` int(11) DEFAULT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idcontactsubtype`),
  KEY `FK_contactstypes` (`idcontacttype`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8