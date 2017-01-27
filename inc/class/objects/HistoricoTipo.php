<?php

class HistoricoTipo extends Model {

    public $required = array('deshistoricotipo');
    protected $pk = "idhistoricotipo";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_historicostipos_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_historicostipos_save(?, ?);", array(
                $this->getidhistoricotipo(),
                $this->getdeshistoricotipo()
            ));

            return $this->getidhistoricotipo();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_historicostipos_remove", array(
            $this->getidhistoricotipo()
        ));

        return true;
        
    }

}

?>