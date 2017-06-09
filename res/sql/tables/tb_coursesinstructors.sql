CREATE TABLE `tb_coursesinstructors` (
  `idcourse` int(11) NOT NULL,
  `idinstructor` int(11) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `fk_coursesinstructors_courses` (`idcourse`),
  KEY `fk_coursesinstructors_instructors` (`idinstructor`),
  PRIMARY KEY (`idcourse`, `idinstructor`),
  CONSTRAINT `fk_coursesinstructors_courses` FOREIGN KEY (`idcourse`) REFERENCES `tb_courses` (`idcourse`),
  CONSTRAINT `fk_coursesinstructors_instructors` FOREIGN KEY (`idinstructor`) REFERENCES `tb_instructors` (`idinstructor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
