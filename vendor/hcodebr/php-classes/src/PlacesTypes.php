<?php

namespace Hcode;

class PlacesTypes extends Collection {

    protected $class = "Hcode\PlaceType";
    protected $saveQuery = "sp_placeestypes_save";
    protected $saveArgs = array("idplacetype", "desplacetype");
    protected $pk = "idplacetype";
    public function get(){}

    public static function listAll(){

    	$types = new PlacesTypes();

    	$types->loadFromQuery("CALL sp_placeestypes_list();");

    	return $types;

    }

}

?>