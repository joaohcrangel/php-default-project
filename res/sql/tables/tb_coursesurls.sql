CREATE TABLE `tb_coursesurls` (
  `idcourse` int(11) NOT NULL,
  `idurl` int(11) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `idcourse` (`idcourse`),
  KEY `idurl` (`idurl`),
  CONSTRAINT `tb_coursesurls_ibfk_1` FOREIGN KEY (`idcourse`) REFERENCES `tb_courses` (`idcourse`),
  CONSTRAINT `tb_coursesurls_ibfk_2` FOREIGN KEY (`idurl`) REFERENCES `tb_urls` (`idurl`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1