


<?php

class City extends Model {

    public $required = array('idcity', 'descity', 'idstate');
    protected $pk = "idcity";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_cities_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_cities_save(?, ?, ?, ?);", array(
                $this->getidcity(),
                $this->getdescity(),
                $this->getidstate(),
                $this->getdtregister()
            ));

            return $this->getidcity();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_cities_remove", array(
            $this->getidcity()
        ));

        return true;
        
    }

}

?>