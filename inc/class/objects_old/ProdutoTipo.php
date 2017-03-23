<?php

class ProdutoTipo extends Model {

    public $required = array('desprodutotipo');
    protected $pk = "idprodutotipo";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_produtotipo_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_produtotipo_save(?, ?);", array(
                $this->getidprodutotipo(),
                $this->getdesprodutotipo()
            ));

            return $this->getidprodutotipo();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->execute("CALL sp_produtotipo_remove(".$this->getidprodutotipo().")");

        return true;
        
    }

}

?>