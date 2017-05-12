CREATE TABLE `tb_emailsblacklists` (
  `idblacklist` int(11) NOT NULL AUTO_INCREMENT,
  `idcontact` int(11) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idblacklist`),
  KEY `fk_emailsblacklists_contacts_idx` (`idcontact`),
  CONSTRAINT `fk_emailsblacklists_contacts` FOREIGN KEY (`idcontact`) REFERENCES `tb_contacts` (`idcontact`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8