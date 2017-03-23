<?php

class UsuariosTipos extends Collection {

    protected $class = "UsuarioTipo";
    protected $saveQuery = "sp_usuariostipos_save";
    protected $saveArgs = array("idusuariotipo", "desusuariotipo");
    protected $pk = "idusuariotipo";

    public function get(){}

    public static function listAll(){

    	$usuariosTipos = new UsuariosTipos();

		$usuariosTipos->loadFromQuery("CALL sp_usuariostipos_list()");

		return $usuariosTipos;

    }

}

?>