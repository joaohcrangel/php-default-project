<?php

class LugarHorario extends Model {

    public $required = array('idlugar', 'nrdia');
    protected $pk = "idhorario";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_lugareshorarios_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_lugareshorarios_save(?, ?, ?, ?, ?);", array(
                $this->getidhorario(),
                $this->getidlugar(),
                $this->getnrdia(),
                $this->gethrabre(),
                $this->gethrfecha()
            ));

            return $this->getidhorario();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->execute("CALL sp_lugareshorarios_remove(".$this->getidhorario().")");

        return true;
        
    }

}

?>