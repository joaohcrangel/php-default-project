<?php

class CursosCurriculos extends Collection {

    protected $class = "CursoCurriculo";
    protected $saveQuery = "sp_cursoscurriculos_save";
    protected $saveArgs = array("idcurriculo", "descurriculo", "idsecao", "desdescricao", "nrordem");
    protected $pk = "idcurriculo";

    public function get(){}

    public function getByCurso(Curso $curso):CursosCurriculos
    {

    	$this->loadFromQuery("CALL sp_curriculosfromcurso_list(?);", array(
    		$curso->getidcurso()
    	));

    	return $this;

    }

}

?>