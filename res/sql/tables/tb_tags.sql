CREATE TABLE `tb_tags` (
  `idtag` int(11) NOT NULL AUTO_INCREMENT,
  `destag` varchar(32) NOT NULL,
  `inactive` bit(1) NOT NULL DEFAULT b'1',
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idtag`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1