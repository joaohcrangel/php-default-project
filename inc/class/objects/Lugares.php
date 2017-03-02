<?php

class Lugares extends Collection {

    protected $class = "Lugar";
    protected $saveQuery = "sp_lugares_save";
    protected $saveArgs = array("idlugar", "idlugarpai", "deslugar", "idlugartipo", "desconteudo", "nrviews", "vlreview");
    protected $pk = "idlugar";
    public function get(){}

    public static function listAll(){

    	$lugares = new Lugares();

    	$lugares->loadFromQuery("CALL sp_lugares_list();");

    	return $lugares;

    }

}

?>