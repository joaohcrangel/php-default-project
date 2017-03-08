<?php

class AdressType extends Model {

    const RESIDENCIAL = 1;
    const COMERCIAL = 2;
    const COBRANCA = 3;
    const ENTREGA = 4;

    public $required = array('idadresstype', 'desadresstype');
    protected $pk = "idadresstype";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_adressestypes_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_adressestypes_save(?, ?);", array(
                $this->getidadresstype(),
                $this->getdesadresstype()
            ));

            return $this->getidadresstype();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->execute("sp_adressestypes_remove", array(
            $this->getidadresstype()
        ));

        return true;
        
    }

}

?>