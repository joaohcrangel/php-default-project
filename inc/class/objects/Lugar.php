<?php

class Lugar extends Model {

    public $required = array('idlugar', 'deslugar', 'idendereco', 'idlugartipo');
    protected $pk = "idlugar";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_lugares_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_lugares_save(?, ?, ?, ?, ?, ?, ?, ?);", array(
                $this->getidlugar(),
                $this->getidlugarpai(),
                $this->getdeslugar(),
                $this->getidendereco(),
                $this->getidlugartipo(),
                $this->getdesconteudo(),
                $this->getnrviews(),
                $this->getvlreview()
            ));

            return $this->getidlugar();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->execute("CALL sp_lugares_remove(".$this->getidlugar().")");

        return true;
        
    }

}

?>