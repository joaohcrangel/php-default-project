<?php

class Carrinho extends Model {

    public $required = array('idcarrinho', 'idpessoa', 'dessession', 'nrprodutos', 'vltotal');
    protected $pk = "idcarrinho";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_carrinhos_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_carrinhos_save(?, ?, ?, ?, ?, ?, ?);", array(
                $this->getidcarrinho(),
                $this->getidpessoa(),
                $this->getdessession(),
                $this->getinfechado(),
                $this->getnrprodutos(),
                $this->getvltotal(),
                $this->getvltotalbruto()                
            ));

            return $this->getidcarrinho();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->execute("CALL sp_carrinhos_remove(".$this->getidcarrinho().")");

        return true;
        
    }

    public function getProdutos():Produtos
    {
        return new Produtos($this);
    }

}

?>