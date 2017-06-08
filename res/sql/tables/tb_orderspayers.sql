CREATE TABLE `tb_orderspayers` (
  `idpayer` int(11) NOT NULL AUTO_INCREMENT,
  `idorder` int(11) NOT NULL,
  `idperson` int(11) NOT NULL,
  `idcard` int(11) DEFAULT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idpayer`),
  KEY `fk_orderspayers_orders_idx` (`idorder`),
  KEY `fk_orderspayers_creditcards_idx` (`idcard`),
  KEY `fk_orderspayers_persons_idx` (`idperson`),
  CONSTRAINT `fk_orderspayers_creditcards` FOREIGN KEY (`idcard`) REFERENCES `tb_creditcards` (`idcard`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_orderspayers_orders` FOREIGN KEY (`idorder`) REFERENCES `tb_orders` (`idorder`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_orderspayers_persons` FOREIGN KEY (`idperson`) REFERENCES `tb_persons` (`idperson`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8