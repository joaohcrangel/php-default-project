<?php

class CarrinhoProduto extends Model {

    public $required = array('idcarrinho', 'idproduto');
    protected $pk = "idcarrinho";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_carrinhosprodutos_get(".$args[0].", ".$args[1].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_carrinhosprodutos_save(?, ?, ?, ?);", array(
                $this->getidcarrinho(),
                $this->getidproduto(),
                $this->getinremovido(),
                $this->getdtremovido()
            ));

            return $this->getidcarrinho();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->execute("CALL sp_carrinhosprodutos_remove(".$this->getidcarrinho().", ".$this->getidproduto().")");

        return true;
        
    }

}

?>