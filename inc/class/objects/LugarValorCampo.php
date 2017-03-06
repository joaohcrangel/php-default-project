


<?php

class LugarValorCampo extends Model {

    public $required = array('descampo');
    protected $pk = "idcampo";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_lugaresvalorescampos_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_lugaresvalorescampos_save(?, ?);", array(
                $this->getidcampo(),
                $this->getdescampo()
            ));

            return $this->getidcampo();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_lugaresvalorescampos_remove", array(
            $this->getidcampo()
        ));

        return true;
        
    }

}

?>