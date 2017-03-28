<?php

class Coordenada extends Model {

    public $required = array('vllatitude', 'vllongitude', 'nrzoom');
    protected $pk = "idcoordenada";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_coordenadas_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_coordenadas_save(?, ?, ?, ?);", array(
                $this->getidcoordenada(),
                $this->getvllatitude(),
                $this->getvllongitude(),
                $this->getnrzoom()
            ));

            return $this->getidcoordenada();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->execute("CALL sp_coordenadas_remove(".$this->getidcoordenada().")");

        return true;
        
    }

}

?>