CREATE TABLE `tb_contacts` (
  `idcontact` int(11) NOT NULL AUTO_INCREMENT,
  `idcontactsubtype` int(11) NOT NULL,
  `idperson` int(11) NOT NULL,
  `descontact` varchar(128) NOT NULL,
  `inmain` tinyint(1) NOT NULL DEFAULT 0,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idcontact`),
  KEY `FK_contactssubtypes` (`idcontactsubtype`),
  KEY `FK_personscontacts` (`idperson`),
  CONSTRAINT `FK_contactssubtypes` FOREIGN KEY (`idcontactsubtype`) REFERENCES `tb_contactssubtypes` (`idcontactsubtype`),
  CONSTRAINT `FK_personscontacts` FOREIGN KEY (`idperson`) REFERENCES `tb_persons` (`idperson`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8