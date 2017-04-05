<?php

namespace Hcode;

class Places extends Collection {

    protected $class = "Place";
    protected $saveQuery = "sp_placees_save";
    protected $saveArgs = array("idplace", "idplacefather", "desplace", "idplacetype", "descontent", "nrviews", "vlreview");
    protected $pk = "idplace";
    public function get(){}

    public static function listAll(){

    	$places = new Places ();

    	$places->loadFromQuery("CALL sp_placees_list();");

    	return $places;

    }

}

?>