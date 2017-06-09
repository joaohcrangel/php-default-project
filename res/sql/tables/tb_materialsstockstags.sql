CREATE TABLE `tb_materialsstockstags` (
  `idstock` int(11) NOT NULL,
  `idtag` int(11) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idstock`,`idtag`),
  KEY `fk_materialsstockstags_tags_idx` (`idtag`),
  CONSTRAINT `fk_materialsstockstags_materialsstocks` FOREIGN KEY (`idstock`) REFERENCES `tb_materialsstocks` (`idstock`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_materialsstockstags_tags` FOREIGN KEY (`idtag`) REFERENCES `tb_tags` (`idtag`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1