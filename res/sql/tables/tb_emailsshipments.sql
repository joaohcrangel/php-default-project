CREATE TABLE `tb_emailsshipments` (
  `idshipment` int(11) NOT NULL AUTO_INCREMENT,
  `idemail` int(11) NOT NULL,
  `idcontact` int(11) NOT NULL,
  `dtsent` datetime DEFAULT NULL,
  `dtreceived` datetime DEFAULT NULL,
  `dtvisualized` datetime DEFAULT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idshipment`),
  KEY `fk_emailsshipments_emails_idx` (`idemail`),
  KEY `fk_emailsshipments_contacts_idx` (`idcontact`),
  CONSTRAINT `fk_emailsshipments_contacts` FOREIGN KEY (`idcontact`) REFERENCES `tb_contacts` (`idcontact`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_emailsshipments_emails` FOREIGN KEY (`idemail`) REFERENCES `tb_emails` (`idemail`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8