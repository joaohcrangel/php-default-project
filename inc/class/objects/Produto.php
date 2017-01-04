<?php

class Produto extends Model {

    public $required = array('desproduto', 'idprodutotipo', 'vlpreco');
    protected $pk = "idproduto";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_produto_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_produto_save(?, ?, ?, ?);", array(
                $this->getidproduto(),
                $this->getidprodutotipo(),
                $this->getdesproduto(),
                $this->getvlpreco()
            ));

            return $this->getidproduto();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->execute("CALL sp_produto_remove(".$this->getidproduto().")");

        return true;
        
    }

}

?>