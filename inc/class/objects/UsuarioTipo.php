<?php

class UsuarioTipo extends Model {

    const ADMINISTRATIVO = 1;
    const CLIENTE = 2;

    public $required = array('desusuariotipo');
    protected $pk = "idusuariotipo";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_usuariostipos_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_usuariostipos_save(?, ?);", array(
                $this->getidusuariotipo(),
                $this->getdesusuariotipo()
            ));

            return $this->getidusuariotipo();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_usuariostipos_remove", array(
            $this->getidusuariotipo()
        ));

        return true;
        
    }

}

?>