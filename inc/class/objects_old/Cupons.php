<?php

class Cupons extends Collection {

    protected $class = "Cupom";
    protected $saveQuery = "sp_cupons_save";
    protected $saveArgs = array("idcupom", "idcupomtipo", "descupom", "descodigo", "nrqtd", "nrqtdusado", "dtinicio", "dttermino", "inremovido", "nrdesconto");
    protected $pk = "idcupom";

    public function get(){}

    public static function listAll():Cupons
    {

    	$cupons = new Cupons();

    	$cupons->loadFromQuery("CALL sp_cupons_list();");

    	return $cupons;

    }

    public function getByCarrinho(Carrinho $carrinho):Cupons
    {

        $this->loadFromQuery("CALL sp_cuponsfromcarrinho_list(?);", array(
            $carrinho->getidcarrinho()
        ));

        return $this;

    }

}

?>