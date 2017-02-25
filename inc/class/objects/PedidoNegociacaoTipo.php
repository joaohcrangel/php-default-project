<?php

class PedidoNegociacaoTipo extends Model {

    public $required = array('desnegociacao');
    protected $pk = "idnegociacao";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_pedidosnegociacoestipos_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_pedidosnegociacoestipos_save(?, ?);", array(
                $this->getidnegociacao(),
                $this->getdesnegociacao()
            ));

            return $this->getidnegociacao();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_pedidosnegociacoestipos_remove", array(
            $this->getidnegociacao()
        ));

        return true;
        
    }

}

?>