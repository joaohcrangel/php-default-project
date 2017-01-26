<?php

class Carrinhos extends Collection {

    protected $class = "Carrinho";
    protected $saveQuery = "sp_carrinhos_save";
    protected $saveArgs = array("idcarrinho", "idpessoa", "dessession", "infechado", "nrprodutos", "vltotal", "vltotalbruto");
    protected $pk = "idcarrinho";
    public function get(){}

    public static function listAll(){

    	$carrinhos = new Carrinhos();

    	$carrinhos->loadFromQuery("CALL sp_carrinhos_list();");

    	return $carrinhos;

    }

    public function getByPessoa(Pessoa $pessoa):Carrinhos
    
    {
    
         $this->loadFromQuery("CALL sp_carrinhosfrompessoa_list(?)",array(
               $pessoa->getidpessoa()
               
        ));

         return $this;

    }

}

?>