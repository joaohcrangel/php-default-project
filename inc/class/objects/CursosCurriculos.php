<?php

class CursosCurriculos extends Collection {

    protected $class = "CursoCurriculo";
    protected $saveQuery = "sp_cursoscurriculos_save";
    protected $saveArgs = array("idcurriculo", "descurriculo", "idsecao", "desdescricao", "nrordem");
    protected $pk = "idcurriculo";

    public function get(){}

    public function getByCursoSecao(CursoSecao $secao):CursosCurriculos
    {

    	$this->loadFromQuery("CALL sp_curriculosfromsecao_list(?);", array(
    		$secao->getidsecao()
    	));

    	return $this;

    }

}

?>