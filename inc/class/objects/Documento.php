<?php

class Documento extends Model {

    public $required = array('iddocumentotipo', 'idpessoa', 'desdocumento');
    protected $pk = "iddocumento";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_documentos_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_documentos_save(?, ?, ?, ?);", array(
                $this->getiddocumento(),
                $this->getiddocumentotipo(),
                $this->getidpessoa(),
                $this->getdesdocumento()
            ));

            return $this->getiddocumento();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->execute("CALL sp_documentos_remove(".$this->getiddocumento().")");

        return true;
        
    }

}

?>