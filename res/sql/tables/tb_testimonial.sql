CREATE TABLE `tb_testimonial` (
  `idtestimony` int(11) NOT NULL AUTO_INCREMENT,
  `idperson` int(11) NOT NULL,
  `idphoto` int(11) DEFAULT NULL,
  `dessubtitle` varchar(128) NOT NULL,
  `destestimony` varchar(256) NOT NULL,
  `inapproved` bit NOT NULL DEFAULT b'0',
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idtestimony`),
  KEY `idperson` (`idperson`),
  KEY `tb_testimonialphoto_idx` (`idphoto`),
  CONSTRAINT `tb_testimonial_ibfk_1` FOREIGN KEY (`idperson`) REFERENCES `tb_persons` (`idperson`),
  CONSTRAINT `tb_testimonialphoto` FOREIGN KEY (`idphoto`) REFERENCES `tb_files` (`idfile`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1