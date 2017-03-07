


<?php

class Document extends Model {

    public $required = array('iddocument', 'iddocumenttype', 'idperson', 'desdocument');
    protected $pk = "iddocument";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_documents_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_documents_save(?, ?, ?, ?, ?);", array(
                $this->getiddocument(),
                $this->getiddocumenttype(),
                $this->getidperson(),
                $this->getdesdocument(),
                $this->getdtregister()
            ));

            return $this->getiddocument();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_documents_remove", array(
            $this->getiddocument()
        ));

        return true;
        
    }

}

?>