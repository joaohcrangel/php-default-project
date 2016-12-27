<?php

class Permissoes extends Collection {

    protected $class = "Permissao";
    protected $saveQuery = "CALL sp_permissoes_save(?, ?);";
    protected $saveArgs = array('idpermissao', 'despermissao');
    protected $pk = "idpermissao";

    public function get(){}

    public static function listFromMenu(Menu $menu, $faltantes = false){

    	$permissoes = new Permissoes();

        $query = ($faltantes === false)?"CALL sp_permissoesfrommenus_list(?)":"CALL sp_permissoesfrommenusfaltantes_list(?)";

    	$permissoes->loadFromQuery($query, array(
    		$menu->getidmenu()    		
    	));

    	return $permissoes;

    }

}

?>