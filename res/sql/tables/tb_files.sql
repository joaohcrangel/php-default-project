CREATE TABLE `tb_files` (
  `idfile` int(11) NOT NULL AUTO_INCREMENT,
  `desdirectory` varchar(256) NOT NULL,
  `desfile` varchar(128) NOT NULL,
  `desextension` varchar(32) NOT NULL,
  `desalias` varchar(128) DEFAULT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idfile`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8