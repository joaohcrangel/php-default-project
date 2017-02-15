<?php

class CarouselsItemsTipos extends Collection {

    protected $class = "CarouselItemTipo";
    protected $saveQuery = "sp_carouselsitemstipos_save";
    protected $saveArgs = array("idtipo", "destipo");
    protected $pk = "idtipo";

    public function get(){}

    public static function listAll():CarouselsItemsTipos
    {

    	$tipos = new CarouselsItemsTipos();

    	$tipos->loadFromQuery("CALL sp_carouselsitemstipos_list();");

    	return $tipos;

    }

}

?>