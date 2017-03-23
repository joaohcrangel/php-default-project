<?php

class PermissaoMenu extends Model {

    public $required = array();
    protected $pk = "";

    public function get(){

        $args = func_get_args();
        
        
        $this->queryToAttr("CALL sp_permissoesmenu_get(".$args[0].". ".$args[1].");");
        
        
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_permissoesmenu_save();", array(
                

            ));

            return $this->get();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->execute("CALL sp_permissoesmenu_remove(".$this->get().")");

        return true;
        
    }

}

?>