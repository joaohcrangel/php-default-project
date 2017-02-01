

<?php

class DocumentoTipo extends Model {

    public $required = array('iddocumentotipo', 'desdocumentotipo');
    protected $pk = "iddocumentotipo";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_documentostipos_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_documentostipos_save(?, ?);", array(
                $this->getiddocumentotipo(),
                $this->getdesdocumentotipo()
            ));

            return $this->getiddocumentotipo();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_documentostipos_remove", array(
            $this->getiddocumentotipo()
        ));

        return true;
        
    }

}

?>