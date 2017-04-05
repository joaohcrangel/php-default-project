<?php

namespace Hcode;

class CarouselsItemsTypes extends Collection {

    protected $class = "Hcode\CarouselItemType";
    protected $saveQuery = "sp_carouselsitemstypes_save";
    protected $saveArgs = array("idtype", "destype");
    protected $pk = "idtype";

    public function get(){}

    public static function listAll():CarouselsItemsTypes
    {

    	$types = new CarouselsItemsTypes();

    	$types->loadFromQuery("CALL sp_carouselsitemstypes_list();");

    	return $types;

    }

}

?>