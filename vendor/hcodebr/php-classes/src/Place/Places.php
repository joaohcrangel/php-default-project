<?php

namespace Hcode\Place;

use Hcode\Collection;

class Places extends Collection {

    protected $class = "Hcode\Place\Place";
    protected $saveQuery = "sp_placees_save";
    protected $saveArgs = array("idplace", "idplacefather", "desplace", "idplacetype", "descontent", "nrviews", "vlreview");
    protected $pk = "idplace";
    public function get(){}

    public static function listAll():Places
    {

    	$places = new Places();

    	$places->loadFromQuery("CALL sp_places_list();");

    	return $places;

    }

}

?>