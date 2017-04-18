<?php

namespace Hcode\Place;

use Hcode\Collection;

class Types extends Collection {

    protected $class = "Hcode\Place\Type";
    protected $saveQuery = "sp_placeestypes_save";
    protected $saveArgs = array("idplacetype", "desplacetype");
    protected $pk = "idplacetype";
    public function get(){}

    public static function listAll(){

    	$types = new Types();

    	$types->loadFromQuery("CALL sp_placeestypes_list();");

    	return $types;

    }

}

?>