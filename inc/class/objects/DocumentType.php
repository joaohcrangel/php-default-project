


<?php

class DocumentType extends Model {

    public $required = array('iddocumenttype', 'desdocumenttype');
    protected $pk = "iddocumenttype";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_documentstypes_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_documentstypes_save(?, ?, ?);", array(
                $this->getiddocumenttype(),
                $this->getdesdocumenttype(),
                $this->getdtregister()
            ));

            return $this->getiddocumenttype();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_documentstypes_remove", array(
            $this->getiddocumenttype()
        ));

        return true;
        
    }

}

?>