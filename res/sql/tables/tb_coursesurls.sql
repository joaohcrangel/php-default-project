CREATE TABLE `tb_coursesurls` (
  `idcourse` int(11) NOT NULL,
  `idurl` int(11) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `idcourse` (`idcourse`),
  KEY `idurl` (`idurl`),
  CONSTRAINT `FK_courses_urls_course` FOREIGN KEY (`idcourse`) REFERENCES `tb_courses` (`idcourse`),
  CONSTRAINT `FK_courses_urls_url` FOREIGN KEY (`idurl`) REFERENCES `tb_urls` (`idurl`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1