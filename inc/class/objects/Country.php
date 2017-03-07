


<?php

class Country extends Model {

    public $required = array('idcountry', 'descountry');
    protected $pk = "idcountry";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_countries_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_countries_save(?, ?, ?);", array(
                $this->getidcountry(),
                $this->getdescountry(),
                $this->getdtregister()
            ));

            return $this->getidcountry();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_countries_remove", array(
            $this->getidcountry()
        ));

        return true;
        
    }

}

?>