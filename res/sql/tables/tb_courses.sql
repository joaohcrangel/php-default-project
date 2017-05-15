CREATE TABLE `tb_courses` (
  `idcourse` int(11) NOT NULL AUTO_INCREMENT,
  `descourse` varchar(64) NOT NULL,
  `destitle` varchar(256) DEFAULT NULL,
  `vlworkload` decimal(10,2) NOT NULL DEFAULT '0.00',
  `nrlessons` int(11) NOT NULL DEFAULT '0',
  `nrexercises` int(11) NOT NULL DEFAULT '0',
  `desdescription` varchar(10240) DEFAULT NULL,
  `inremoved` tinyint(1) NOT NULL DEFAULT 0,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idcourse`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8