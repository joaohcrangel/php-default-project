<?php

class ProdutoPreco extends Model {

    public $required = array('idpreco', 'idproduto', 'vlpreco');
    protected $pk = "idpreco";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_produtosprecos_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_produtosprecos_save(?, ?, ?, ?, ?);", array(
                $this->getidpreco(),
                $this->getidproduto(),
                $this->getdtinicio(),
                $this->getdttermino(),
                $this->getvlpreco()
            ));

            return $this->getidpreco();

        }else{

            return false;

        }
        
    }

    public function remove():bool
    {

        $this->execute("CALL sp_produtosprecos_remove(".$this->getidpreco().")");

        return true;
        
    }

}

?>