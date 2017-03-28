<?php

class CarrinhosCupons extends Collection {

    protected $class = "CarrinhoCupom";
    protected $saveQuery = "sp_carrinhoscupons_save";
    protected $saveArgs = array("idcarrinho", "idcupom");
    protected $pk = array('idcarrinho', 'idcupom');

    public function get(){}

    public static function listAll():CarrinhosCupons
    {

    	$cupons = new CarrinhosCupons();

    	$cupons->loadFromQuery("CALL sp_carrinhoscupons_list();");

    	return $cupons;

    }

}

?>