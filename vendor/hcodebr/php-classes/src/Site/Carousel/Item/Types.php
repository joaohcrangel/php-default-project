<?php

namespace Hcode\Site\Carousel\Item;

use Hcode\Collection;

class Types extends Collection {

    protected $class = "Hcode\Site\Carousel\Item\Type";
    protected $saveQuery = "sp_carouselsitemstypes_save";
    protected $saveArgs = array("idtype", "destype");
    protected $pk = "idtype";

    public function get(){}

    public static function listAll():Types
    {

    	$types = new Types();

    	$types->loadFromQuery("CALL sp_carouselsitemstypes_list();");

    	return $types;

    }

}

?>