CREATE TABLE `tb_instructors` (
  `idinstructor` int(11) NOT NULL AUTO_INCREMENT,
  `idperson` int(11) NOT NULL,
  `desbiography` text NOT NULL,
  `idphoto` int(11) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idinstructor`),
  KEY `fk_instructors_persons` (`idperson`),
  KEY `fk_instructors_files` (`idphoto`),
  CONSTRAINT `fk_instructors_files` FOREIGN KEY (`idphoto`) REFERENCES `tb_files` (`idfile`),
  CONSTRAINT `fk_instructors_persons` FOREIGN KEY (`idperson`) REFERENCES `tb_persons` (`idperson`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8