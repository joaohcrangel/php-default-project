<?php

class CarouselItemTipo extends Model {

    public $required = array('idtipo', 'destipo');
    protected $pk = "idtipo";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_carouselsitemstipos_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_carouselsitemstipos_save(?, ?);", array(
                $this->getidtipo(),
                $this->getdestipo()
            ));

            return $this->getidtipo();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_carouselsitemstipos_remove", array(
            $this->getidtipo()
        ));

        return true;
        
    }

}

?>