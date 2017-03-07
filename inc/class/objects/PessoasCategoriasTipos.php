<?php

class PessoasCategoriasTipos extends Collection {

    protected $class = "PessoaCategoriaTipo";
    protected $saveQuery = "sp_pessoascategoriastipos_save";
    protected $saveArgs = array("idcategoria", "descategoria");
    protected $pk = "idcategoria";

    public function get(){}

    public static function listAll():PessoasCategoriasTipos
    {

    	$tipos = new PessoasCategoriasTipos();

    	$tipos->loadFromQuery("CALL sp_pessoascategoriastipos_list();");

    	return $tipos;

    }

}

?>