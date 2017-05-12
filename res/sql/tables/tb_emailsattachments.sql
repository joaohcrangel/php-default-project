CREATE TABLE `tb_emailsattachments` (
  `idemail` int(11) NOT NULL,
  `idfile` int(11) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idemail`,`idfile`),
  KEY `fk_emailsattachments_files_idx` (`idfile`),
  CONSTRAINT `fk_emailsattachments_emails` FOREIGN KEY (`idemail`) REFERENCES `tb_emails` (`idemail`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_emailsattachments_files` FOREIGN KEY (`idfile`) REFERENCES `tb_files` (`idfile`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8