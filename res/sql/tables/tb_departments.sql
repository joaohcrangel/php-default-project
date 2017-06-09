CREATE TABLE `tb_departments` (
  `iddepartment` int(11) NOT NULL AUTO_INCREMENT,
  `iddepartmentparent` int(11) DEFAULT NULL,
  `desdepartment` varchar(64) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`iddepartment`),
  KEY `fk_departments_departments_idx` (`iddepartmentparent`),
  CONSTRAINT `fk_departments_departments` FOREIGN KEY (`iddepartmentparent`) REFERENCES `tb_departments` (`iddepartment`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1