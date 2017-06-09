CREATE TABLE `tb_carousels` (
  `idcarousel` int(11) NOT NULL AUTO_INCREMENT,
  `descarousel` varchar(64) NOT NULL,
  `nrspeed` int(11) NOT NULL DEFAULT '300',
  `nrautoplay` int(11) NOT NULL DEFAULT '0',
  `desmode` enum('horizontal', 'vertical') NOT NULL DEFAULT 'horizontal',
  `inloop` tinyint(1) NOT NULL DEFAULT '0',
  `nritems` int(11) NOT NULL DEFAULT '3',
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idcarousel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8