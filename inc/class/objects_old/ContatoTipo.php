<?php

class ContatoTipo extends Model {

    public $required = array('descontatotipo');
    protected $pk = "idcontatotipo";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_contatostipos_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_contatostipos_save(?, ?);", array(
                $this->getidcontatotipo(),
                $this->getdescontatotipo()
            ));

            return $this->getidcontatotipo();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->execute("CALL sp_contatostipos_remove(".$this->getidcontatotipo().")");

        return true;
        
    }

}

?>