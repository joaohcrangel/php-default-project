CREATE TABLE `tb_jobspositions` (
  `idjobposition` int(11) NOT NULL AUTO_INCREMENT,
  `desjobposition` varchar(256) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idjobposition`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8