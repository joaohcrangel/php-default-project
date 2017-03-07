


<?php

class PersonCategory extends Model {

    public $required = array('idperson', 'idcategory');
    protected $pk = array(idperson, idcategory);

    public function get(){

        $args = func_get_args();
                        if(!isset($args[0])) throw new Exception($->pk[0]." não informado");
                if(!isset($args[1])) throw new Exception($->pk[1]." não informado");
                $this->queryToAttr("CALL sp_personscategories_get(".$args[0].". ".$args[1].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_personscategories_save(?, ?, ?);", array(
                $this->getidperson(),
                $this->getidcategory(),
                $this->getdtregister()
            ));

            return $this->getidperson();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_personscategories_remove", array(
            $this->getidperson()
        ));

        return true;
        
    }

}

?>