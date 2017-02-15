<?php

class CursosSecoes extends Collection {

    protected $class = "CursoSecao";
    protected $saveQuery = "sp_cursossecoes_save";
    protected $saveArgs = array("idsecao", "dessecao", "nrordem", "idcurso");
    protected $pk = "idsecao";

    public function get(){}

    public function getByCurso(Curso $curso):CursosSecoes
    {

    	$this->loadFromQuery("CALL sp_secoesfromcurso_list(?);", array(
    		$curso->getidcurso()
    	));

    	return $this;

    }

}

?>